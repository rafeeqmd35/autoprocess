<?php
//Steps to do 
// check the namespace is proper or not
// And add the parameter for validation and passing inputs
// for show and edit plz check the PRIMARY_KEY columns
// apart from this whatever u want u can do
//$_CR_DT_COLUMN_NAME - need to define created date column name
//$_PRIMARY_COLUMN_NAME -  need to add primary column name
// passing_parameter -  need to pass proper value here
namespace App\Controllers\Backend;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Backend-ProductfilterModel;

class ProductfilterController extends ResourceController {
	
	use ResponseTrait;

	function __construct()
  {
    $this->db = db_connect();
  }
  

	private function total_count($_PRIMARY_KEY = "", $_TABLE_NAME = "", $site_column="",$site_column_value){
	  $sql = "SELECT COUNT($_PRIMARY_KEY) AS TOT FROM $_TABLE_NAME  ";
	  if($site_column != ""){
	  	$sql = $sql . "WHERE $site_column = '$site_column_value'";
	  }
	  $result = $this->db->query($sql)->getResult("array");
	  return $result[0]["TOT"];
  }

  private function total_count_after_filter($sql=""){
    if($sql == ""){
      return 0; 
    }
    $result = $this->db->query($sql)->getResult("array");
    return count($result);
  }

	public function index(){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			$search_value = $this->request->getVar("search_value");
			$search_column = $this->request->getVar("search_column");

			$order_by_column_name = $this->request->getVar("order_by_column_name");
			if(empty($order_by_column_name)){
				$order_by_column_name = 1;
			}

			$sort_by = $this->request->getVar("sort_by");
			if(empty($sort_by)){
				$sort_by = " DESC ";
			}

			$page_no = $this->request->getVar("page");
			if(empty($page_no)){
				$page_no = 1;
			}

			$data_limit = $this->request->getVar("limit");
			if(empty($data_limit)){
				$data_limit = 10;
			}

			$startRecord = ($page_no * $data_limit) - $data_limit;

			if(!empty($search_value) && empty($search_column)){
        $validation_error = [
          "search_column"  =>  "Searching Column required "
        ];
        $result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
        return $this->respond($result);

      }

      $searching = false;
      $search_sql = "";
      if(!empty($search_value) && !empty($search_column)){
        $searching = true;
      }

      $logged_site_id = $this->request->getVar("logged_site_id");


			$sql = "SELECT * FROM ( SELECT SPF_SYS_ID, SPF_ST_SYS_ID, SPF_SPI_SYS_ID, SPF_FILTER_TYPE, SPF_TAGS, SPF_ORDERING, SPF_ACTIVE_YN, SPF_LANG_CODE, SPF_CR_UID, SPF_CR_DT, SPF_UPD_UID, SPF_UPD_DT FROM SITE_M_PRODUCT_FILTER )  ";

			if($searching === true){
        $sql = $sql . " WHERE UPPER(".strtoupper($search_column).") LIKE UPPER('%$search_value%') ";
        $search_sql = $sql;
      }
      
      $sql = $sql . " ORDER BY $order_by_column_name $sort_by  OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
      $query = $this->db->query($sql);
      $result_array = $query->getResult("array");

			$data_to_send = [];
			$total_count = 0;
			$filtered_total_count = $this->total_count_after_filter($search_sql);

			if($result_array){
				$return_status = "0";
				$error_message = "Success";

				foreach ($result_array as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_SPF_SYS_ID"	=>	$value["SPF_SYS_ID"],
						"@user_end_parameter_SPF_ST_SYS_ID"	=>	$value["SPF_ST_SYS_ID"],
						"@user_end_parameter_SPF_SPI_SYS_ID"	=>	$value["SPF_SPI_SYS_ID"],
						"@user_end_parameter_SPF_FILTER_TYPE"	=>	$value["SPF_FILTER_TYPE"],
						"@user_end_parameter_SPF_TAGS"	=>	$value["SPF_TAGS"],
						"@user_end_parameter_SPF_ORDERING"	=>	$value["SPF_ORDERING"],
						"@user_end_parameter_SPF_ACTIVE_YN"	=>	$value["SPF_ACTIVE_YN"],
						"@user_end_parameter_SPF_LANG_CODE"	=>	$value["SPF_LANG_CODE"],
						"@user_end_parameter_SPF_CR_UID"	=>	$value["SPF_CR_UID"],
						"@user_end_parameter_SPF_CR_DT"	=>	$value["SPF_CR_DT"],
						"@user_end_parameter_SPF_UPD_UID"	=>	$value["SPF_UPD_UID"],
						"@user_end_parameter_SPF_UPD_DT"	=>	$value["SPF_UPD_DT"],
					];
					$data_to_send[] = $name_array;
				}
				$primary_key = "PRIMARY_KEY_NEED_TO_SEND";
        $table_name = "SITE_M_PRODUCT_FILTER";
        $site_column = "";
        $site_column_value = $logged_site_id;
        $total_count = $this->total_count($primary_key, $table_name,$site_column,$site_column_value);

			}

			$data = [
				"return_status" => "0",
				"error_message" => "Success",
				"row_count" => $total_count,
				"filtered_count" => $filtered_total_count,
				"result" => $data_to_send
			];
			return $this->respond($data);
		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}

	public function create(){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			if(!($this->validate("Productfilter"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_SPF_ST_SYS_ID = $this->request->getVar("@user_end_parameter_SPF_ST_SYS_ID");
			$_P_SPF_SPI_SYS_ID = $this->request->getVar("@user_end_parameter_SPF_SPI_SYS_ID");
			$_P_SPF_FILTER_TYPE = $this->request->getVar("@user_end_parameter_SPF_FILTER_TYPE");
			$_P_SPF_TAGS = $this->request->getVar("@user_end_parameter_SPF_TAGS");
			$_P_SPF_ORDERING = $this->request->getVar("@user_end_parameter_SPF_ORDERING");
			$_P_SPF_ACTIVE_YN = $this->request->getVar("@user_end_parameter_SPF_ACTIVE_YN");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_SPF_ST_SYS_ID", "value"=>$_P_SPF_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SPF_SPI_SYS_ID", "value"=>$_P_SPF_SPI_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SPF_FILTER_TYPE", "value"=>$_P_SPF_FILTER_TYPE, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_SPF_TAGS", "value"=>$_P_SPF_TAGS, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_SPF_ORDERING", "value"=>$_P_SPF_ORDERING, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SPF_ACTIVE_YN", "value"=>$_P_SPF_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","INSERT_SITE_M_PRODUCT_FILTER", $params);

			$return_status = $_P_ERR_NUM;
			$error_message = $_P_ERR_MSG;
			$result_array = [];

		  if($return_status != "0")
		  {
		    $this->db->txn_have_error();
				$this->db->txn_end_now();
				$errMsg = $datatoShow["error_msg"];
				$errFlag = $datatoShow["error_flag"];
				$errStatic = $datatoShow["error_static"];
				if($errMsg != "SUCCESS" && $errFlag !== TRUE && $errStatic == "ERROR"){
					$return_status = "-11111";
					$error_message = $errMsg;
				}
			}else{
				$this->db->txn_end_now();
				//$result_array = [];
			}

			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> $result_array);
			return $this->respond($response);	

		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}

	public function new(){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			$_CR_DT_COLUMN_NAME = "column@";
			$sql = " SELECT SPF_SYS_ID, SPF_ST_SYS_ID, SPF_SPI_SYS_ID, SPF_FILTER_TYPE, SPF_TAGS, SPF_ORDERING, SPF_ACTIVE_YN, SPF_LANG_CODE, SPF_CR_UID, SPF_CR_DT, SPF_UPD_UID, SPF_UPD_DT FROM SITE_M_PRODUCT_FILTER  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM SITE_M_PRODUCT_FILTER)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_SPF_SYS_ID"	=>	$value["SPF_SYS_ID"],
						"@user_end_parameter_SPF_ST_SYS_ID"	=>	$value["SPF_ST_SYS_ID"],
						"@user_end_parameter_SPF_SPI_SYS_ID"	=>	$value["SPF_SPI_SYS_ID"],
						"@user_end_parameter_SPF_FILTER_TYPE"	=>	$value["SPF_FILTER_TYPE"],
						"@user_end_parameter_SPF_TAGS"	=>	$value["SPF_TAGS"],
						"@user_end_parameter_SPF_ORDERING"	=>	$value["SPF_ORDERING"],
						"@user_end_parameter_SPF_ACTIVE_YN"	=>	$value["SPF_ACTIVE_YN"],
						"@user_end_parameter_SPF_LANG_CODE"	=>	$value["SPF_LANG_CODE"],
						"@user_end_parameter_SPF_CR_UID"	=>	$value["SPF_CR_UID"],
						"@user_end_parameter_SPF_CR_DT"	=>	$value["SPF_CR_DT"],
						"@user_end_parameter_SPF_UPD_UID"	=>	$value["SPF_UPD_UID"],
						"@user_end_parameter_SPF_UPD_DT"	=>	$value["SPF_UPD_DT"],
					];
					$data_to_send[] = $name_array;
				}

			}else{
				$return_status = "-112";
				$error_message = "No Data Found";
			}
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> $data_to_send);
			return $this->respond($response);
		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}

	public function show($_id = null){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			$_logged_site_id = $this->request->getVar("logged_site_id");
			

			$_PRIMARY_COLUMN_NAME = "column@";//SITE_ID COLUMN NAME
			$_PRIMARY_COLUMN_NAME_2 = "column@";//
			
			$sql = " SELECT SPF_SYS_ID, SPF_ST_SYS_ID, SPF_SPI_SYS_ID, SPF_FILTER_TYPE, SPF_TAGS, SPF_ORDERING, SPF_ACTIVE_YN, SPF_LANG_CODE, SPF_CR_UID, SPF_CR_DT, SPF_UPD_UID, SPF_UPD_DT FROM SITE_M_PRODUCT_FILTER  
							WHERE :PRIMARY_KEY: = :SITE_ID: AND :PRIMARY_KEY_2: = :ID: ";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"SITE_ID"     => $_logged_site_id,
							"PRIMARY_KEY_2"     => $_PRIMARY_COLUMN_NAME_2,
							"ID"     => $_id,
							
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_SPF_SYS_ID"	=>	$value["SPF_SYS_ID"],
						"@user_end_parameter_SPF_ST_SYS_ID"	=>	$value["SPF_ST_SYS_ID"],
						"@user_end_parameter_SPF_SPI_SYS_ID"	=>	$value["SPF_SPI_SYS_ID"],
						"@user_end_parameter_SPF_FILTER_TYPE"	=>	$value["SPF_FILTER_TYPE"],
						"@user_end_parameter_SPF_TAGS"	=>	$value["SPF_TAGS"],
						"@user_end_parameter_SPF_ORDERING"	=>	$value["SPF_ORDERING"],
						"@user_end_parameter_SPF_ACTIVE_YN"	=>	$value["SPF_ACTIVE_YN"],
						"@user_end_parameter_SPF_LANG_CODE"	=>	$value["SPF_LANG_CODE"],
						"@user_end_parameter_SPF_CR_UID"	=>	$value["SPF_CR_UID"],
						"@user_end_parameter_SPF_CR_DT"	=>	$value["SPF_CR_DT"],
						"@user_end_parameter_SPF_UPD_UID"	=>	$value["SPF_UPD_UID"],
						"@user_end_parameter_SPF_UPD_DT"	=>	$value["SPF_UPD_DT"],
					];
					$data_to_send[] = $name_array;
				}

			}else{
				$return_status = "-112";
				$error_message = "No Data Found";
			}
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> $data_to_send);
			return $this->respond($response);
		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}

	public function edit($_id = null){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			$_logged_site_id = $this->request->getVar("logged_site_id");
			

			$_PRIMARY_COLUMN_NAME = "column@";//SITE_ID COLUMN NAME
			$_PRIMARY_COLUMN_NAME_2 = "column@";//
			
			$sql = " SELECT SPF_SYS_ID, SPF_ST_SYS_ID, SPF_SPI_SYS_ID, SPF_FILTER_TYPE, SPF_TAGS, SPF_ORDERING, SPF_ACTIVE_YN, SPF_LANG_CODE, SPF_CR_UID, SPF_CR_DT, SPF_UPD_UID, SPF_UPD_DT FROM SITE_M_PRODUCT_FILTER  
							WHERE :PRIMARY_KEY: = :SITE_ID: AND :PRIMARY_KEY_2: = :ID: ";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"SITE_ID"     => $_logged_site_id,
							"PRIMARY_KEY_2"     => $_PRIMARY_COLUMN_NAME_2,
							"ID"     => $_id,
							
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_SPF_SYS_ID"	=>	$value["SPF_SYS_ID"],
						"@user_end_parameter_SPF_ST_SYS_ID"	=>	$value["SPF_ST_SYS_ID"],
						"@user_end_parameter_SPF_SPI_SYS_ID"	=>	$value["SPF_SPI_SYS_ID"],
						"@user_end_parameter_SPF_FILTER_TYPE"	=>	$value["SPF_FILTER_TYPE"],
						"@user_end_parameter_SPF_TAGS"	=>	$value["SPF_TAGS"],
						"@user_end_parameter_SPF_ORDERING"	=>	$value["SPF_ORDERING"],
						"@user_end_parameter_SPF_ACTIVE_YN"	=>	$value["SPF_ACTIVE_YN"],
						"@user_end_parameter_SPF_LANG_CODE"	=>	$value["SPF_LANG_CODE"],
						"@user_end_parameter_SPF_CR_UID"	=>	$value["SPF_CR_UID"],
						"@user_end_parameter_SPF_CR_DT"	=>	$value["SPF_CR_DT"],
						"@user_end_parameter_SPF_UPD_UID"	=>	$value["SPF_UPD_UID"],
						"@user_end_parameter_SPF_UPD_DT"	=>	$value["SPF_UPD_DT"],
					];
					$data_to_send[] = $name_array;
				}

			}else{
				$return_status = "-112";
				$error_message = "No Data Found";
			}
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> $data_to_send);
			return $this->respond($response);
		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}

	protected function fetch($_id = null, $_logged_site_id = null){
		try{

			$_PRIMARY_COLUMN_NAME = "column@";//SITE_ID COLUMN NAME
			$_PRIMARY_COLUMN_NAME_2 = "column@";//
			
			$sql = " SELECT SPF_SYS_ID, SPF_ST_SYS_ID, SPF_SPI_SYS_ID, SPF_FILTER_TYPE, SPF_TAGS, SPF_ORDERING, SPF_ACTIVE_YN, SPF_LANG_CODE, SPF_CR_UID, SPF_CR_DT, SPF_UPD_UID, SPF_UPD_DT FROM SITE_M_PRODUCT_FILTER  
							WHERE :PRIMARY_KEY: = :SITE_ID: AND :PRIMARY_KEY_2: = :ID: ";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"SITE_ID"     => $_logged_site_id,
							"PRIMARY_KEY_2"     => $_PRIMARY_COLUMN_NAME_2,
							"ID"     => $_id,
							
			])->getResult("array");

			if($query){
				$return_status = "0";
				$error_message = "Success";
			}else{
				$return_status = "-113";
				$error_message = "No Data Found";
			}
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> $query);
			// return $this->respond($response);
			return $response;
		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			//return $this->respond($response);	
			return $response;
		}
	}

	public function update($_id = null){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			if(!($this->validate("Productfilter"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

      //$this->request->getVar("passing parameter");

      $_exist_data = [];

      $_logged_site_id = $this->request->getVar("logged_site_id");
      
      $_fetch_edit = $this->fetch($_id, $_logged_site_id);

      if($_fetch_edit["return_status"] != "0" || $_fetch_edit["return_status"] != "Success" && count($_fetch_edit["result"]) == 0){
      	$result = array("return_status"=>"-113","error_message"=>"No Data Found","result"=>[] );
      	return $this->respond($result);
      }else{
      	$_exist_data = $_fetch_edit["result"];
      	foreach ($_exist_data as $key => $value) {
		  		
					$_OLD_SPF_SYS_ID	=	$value["SPF_SYS_ID"];
					$_OLD_SPF_ST_SYS_ID	=	$value["SPF_ST_SYS_ID"];
					$_OLD_SPF_SPI_SYS_ID	=	$value["SPF_SPI_SYS_ID"];
					$_OLD_SPF_FILTER_TYPE	=	$value["SPF_FILTER_TYPE"];
					$_OLD_SPF_TAGS	=	$value["SPF_TAGS"];
					$_OLD_SPF_ORDERING	=	$value["SPF_ORDERING"];
					$_OLD_SPF_ACTIVE_YN	=	$value["SPF_ACTIVE_YN"];
					$_OLD_SPF_LANG_CODE	=	$value["SPF_LANG_CODE"];
					$_OLD_SPF_CR_UID	=	$value["SPF_CR_UID"];
					$_OLD_SPF_CR_DT	=	$value["SPF_CR_DT"];
					$_OLD_SPF_UPD_UID	=	$value["SPF_UPD_UID"];
					$_OLD_SPF_UPD_DT	=	$value["SPF_UPD_DT"];
		  	}
		  }
		  
			$_P_SPF_SYS_ID = $this->request->getVar("@user_end_parameter_SPF_SYS_ID");
			$_P_SPF_ST_SYS_ID = $this->request->getVar("@user_end_parameter_SPF_ST_SYS_ID");
			$_P_SPF_SPI_SYS_ID = $this->request->getVar("@user_end_parameter_SPF_SPI_SYS_ID");
			$_P_SPF_FILTER_TYPE = $this->request->getVar("@user_end_parameter_SPF_FILTER_TYPE");
			$_P_SPF_TAGS = $this->request->getVar("@user_end_parameter_SPF_TAGS");
			$_P_SPF_ORDERING = $this->request->getVar("@user_end_parameter_SPF_ORDERING");
			$_P_SPF_ACTIVE_YN = $this->request->getVar("@user_end_parameter_SPF_ACTIVE_YN");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_SPF_SYS_ID", "value"=>$_P_SPF_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SPF_ST_SYS_ID", "value"=>$_P_SPF_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SPF_SPI_SYS_ID", "value"=>$_P_SPF_SPI_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SPF_FILTER_TYPE", "value"=>$_P_SPF_FILTER_TYPE, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_SPF_TAGS", "value"=>$_P_SPF_TAGS, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_SPF_ORDERING", "value"=>$_P_SPF_ORDERING, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SPF_ACTIVE_YN", "value"=>$_P_SPF_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","UPDATE_SITE_M_PRODUCT_FILTER", $params);

			$return_status = $_P_ERR_NUM;
			$error_message = $_P_ERR_MSG;
			$result_array = [];

		  if($return_status != "0")
		  {
		    $this->db->txn_have_error();
				$this->db->txn_end_now();
				$errMsg = $datatoShow["error_msg"];
				$errFlag = $datatoShow["error_flag"];
				$errStatic = $datatoShow["error_static"];
				if($errMsg != "SUCCESS" && $errFlag !== TRUE && $errStatic == "ERROR"){
					$return_status = "-11111";
					$error_message = $errMsg;
				}
			}else{
				$this->db->txn_end_now();
				//$result_array = [];
			}

			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> $result_array);
			return $this->respond($response);	

		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}

	public function delete($_id = null){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			$inputs = $this->request->getRawInput();
			$_lang_code = $inputs["lang_code"];
			$_logged_user_id = $inputs["logged_user_id"];
			$_logged_site_id = $inputs["logged_site_id"];
			

      $_fetch_edit = $this->fetch($_id, $_logged_site_id);


      if($_fetch_edit["return_status"] != "0" || $_fetch_edit["return_status"] != "Success" && count($_fetch_edit["result"]) == 0){
      	$result = array("return_status"=>"-113","error_message"=>"No Data Found","result"=>[] );
      	return $this->respond($result);
      }else{
      	//$_exist_data = $_fetch_edit["result"];
      }

			
			$_P_SPF_SYS_ID = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_SPF_SYS_ID", "value"=>$_P_SPF_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","DELETE_SITE_M_PRODUCT_FILTER", $params);

			$return_status = $_P_ERR_NUM;
			$error_message = $_P_ERR_MSG;

		  if($return_status != "0")
		  {
		    $this->db->txn_have_error();
				$this->db->txn_end_now();
				$errMsg = $datatoShow["error_msg"];
				$errFlag = $datatoShow["error_flag"];
				$errStatic = $datatoShow["error_static"];
				if($errMsg != "SUCCESS" && $errFlag !== TRUE && $errStatic == "ERROR"){
					$return_status = "-11111";
					$error_message = $errMsg;
				}
			}else{
				$this->db->txn_end_now();
			}

			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	

		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}
}

?>
