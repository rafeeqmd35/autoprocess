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
use App\Models\Backend-CountryModel;

class CountryController extends ResourceController {
	
	use ResponseTrait;

	function __construct()
  {
    $this->db = db_connect();
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

			$page_no = $this->request->getVar("page_no");
			if(empty($page_no)){
				$page_no = 1;
			}

			$data_limit = $this->request->getVar("data_limit");
			if(empty($data_limit)){
				$data_limit = 10;
			}

			$startRecord = ($page_no * $data_limit) - $data_limit;


			$sql = " SELECT SCN_ISO, SCN_ST_SYS_ID, SCN_DESC, SCN_FLAG_IMAGE_PATH, SCN_CCY_CODE, SCN_CCY_SYMBOL, SCN_EXCHANGE_RATE, SCN_FROM_DT, SCN_UPTO_DT, SCN_ACTIVE_YN, SCN_LANG_CODE, SCN_CR_UID, SCN_CR_DT, SCN_UPD_UID, SCN_UPD_DT FROM SITE_M_COUNTRY  
				ORDER BY $order_by_column_name $sort_by 
				OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
			$query = $this->db->query($sql)->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_SCN_ISO"	=>	$value["SCN_ISO"],
						"@user_end_parameter_SCN_ST_SYS_ID"	=>	$value["SCN_ST_SYS_ID"],
						"@user_end_parameter_SCN_DESC"	=>	$value["SCN_DESC"],
						"@user_end_parameter_SCN_FLAG_IMAGE_PATH"	=>	$value["SCN_FLAG_IMAGE_PATH"],
						"@user_end_parameter_SCN_CCY_CODE"	=>	$value["SCN_CCY_CODE"],
						"@user_end_parameter_SCN_CCY_SYMBOL"	=>	$value["SCN_CCY_SYMBOL"],
						"@user_end_parameter_SCN_EXCHANGE_RATE"	=>	$value["SCN_EXCHANGE_RATE"],
						"@user_end_parameter_SCN_FROM_DT"	=>	$value["SCN_FROM_DT"],
						"@user_end_parameter_SCN_UPTO_DT"	=>	$value["SCN_UPTO_DT"],
						"@user_end_parameter_SCN_ACTIVE_YN"	=>	$value["SCN_ACTIVE_YN"],
						"@user_end_parameter_SCN_LANG_CODE"	=>	$value["SCN_LANG_CODE"],
						"@user_end_parameter_SCN_CR_UID"	=>	$value["SCN_CR_UID"],
						"@user_end_parameter_SCN_CR_DT"	=>	$value["SCN_CR_DT"],
						"@user_end_parameter_SCN_UPD_UID"	=>	$value["SCN_UPD_UID"],
						"@user_end_parameter_SCN_UPD_DT"	=>	$value["SCN_UPD_DT"],
					];
					$data_to_send[] = $name_array;
				}

			}

			$data = [
				"results" => $data_to_send
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
			if(!($this->validate("Country"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_SCN_ISO = $this->request->getVar("@user_end_parameter_SCN_ISO");
			$_P_SCN_ST_SYS_ID = $this->request->getVar("@user_end_parameter_SCN_ST_SYS_ID");
			$_P_SCN_DESC = $this->request->getVar("@user_end_parameter_SCN_DESC");
			$_P_SCN_FLAG_IMAGE_PATH = $this->request->getVar("@user_end_parameter_SCN_FLAG_IMAGE_PATH");
			$_P_SCN_CCY_CODE = $this->request->getVar("@user_end_parameter_SCN_CCY_CODE");
			$_P_SCN_CCY_SYMBOL = $this->request->getVar("@user_end_parameter_SCN_CCY_SYMBOL");
			$_P_SCN_EXCHANGE_RATE = $this->request->getVar("@user_end_parameter_SCN_EXCHANGE_RATE");
			$_P_SCN_FROM_DT = $this->request->getVar("@user_end_parameter_SCN_FROM_DT");
			$_P_SCN_UPTO_DT = $this->request->getVar("@user_end_parameter_SCN_UPTO_DT");
			$_P_SCN_ACTIVE_YN = $this->request->getVar("@user_end_parameter_SCN_ACTIVE_YN");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_SCN_ISO", "value"=>$_P_SCN_ISO, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_SCN_ST_SYS_ID", "value"=>$_P_SCN_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SCN_DESC", "value"=>$_P_SCN_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_SCN_FLAG_IMAGE_PATH", "value"=>$_P_SCN_FLAG_IMAGE_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_SCN_CCY_CODE", "value"=>$_P_SCN_CCY_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_SCN_CCY_SYMBOL", "value"=>$_P_SCN_CCY_SYMBOL, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_SCN_EXCHANGE_RATE", "value"=>$_P_SCN_EXCHANGE_RATE, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SCN_FROM_DT", "value"=>$_P_SCN_FROM_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SCN_UPTO_DT", "value"=>$_P_SCN_UPTO_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SCN_ACTIVE_YN", "value"=>$_P_SCN_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","INSERT_SITE_M_COUNTRY", $params);

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
			$sql = " SELECT SCN_ISO, SCN_ST_SYS_ID, SCN_DESC, SCN_FLAG_IMAGE_PATH, SCN_CCY_CODE, SCN_CCY_SYMBOL, SCN_EXCHANGE_RATE, SCN_FROM_DT, SCN_UPTO_DT, SCN_ACTIVE_YN, SCN_LANG_CODE, SCN_CR_UID, SCN_CR_DT, SCN_UPD_UID, SCN_UPD_DT FROM SITE_M_COUNTRY  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM SITE_M_COUNTRY)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_SCN_ISO"	=>	$value["SCN_ISO"],
						"@user_end_parameter_SCN_ST_SYS_ID"	=>	$value["SCN_ST_SYS_ID"],
						"@user_end_parameter_SCN_DESC"	=>	$value["SCN_DESC"],
						"@user_end_parameter_SCN_FLAG_IMAGE_PATH"	=>	$value["SCN_FLAG_IMAGE_PATH"],
						"@user_end_parameter_SCN_CCY_CODE"	=>	$value["SCN_CCY_CODE"],
						"@user_end_parameter_SCN_CCY_SYMBOL"	=>	$value["SCN_CCY_SYMBOL"],
						"@user_end_parameter_SCN_EXCHANGE_RATE"	=>	$value["SCN_EXCHANGE_RATE"],
						"@user_end_parameter_SCN_FROM_DT"	=>	$value["SCN_FROM_DT"],
						"@user_end_parameter_SCN_UPTO_DT"	=>	$value["SCN_UPTO_DT"],
						"@user_end_parameter_SCN_ACTIVE_YN"	=>	$value["SCN_ACTIVE_YN"],
						"@user_end_parameter_SCN_LANG_CODE"	=>	$value["SCN_LANG_CODE"],
						"@user_end_parameter_SCN_CR_UID"	=>	$value["SCN_CR_UID"],
						"@user_end_parameter_SCN_CR_DT"	=>	$value["SCN_CR_DT"],
						"@user_end_parameter_SCN_UPD_UID"	=>	$value["SCN_UPD_UID"],
						"@user_end_parameter_SCN_UPD_DT"	=>	$value["SCN_UPD_DT"],
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
			
			$sql = " SELECT SCN_ISO, SCN_ST_SYS_ID, SCN_DESC, SCN_FLAG_IMAGE_PATH, SCN_CCY_CODE, SCN_CCY_SYMBOL, SCN_EXCHANGE_RATE, SCN_FROM_DT, SCN_UPTO_DT, SCN_ACTIVE_YN, SCN_LANG_CODE, SCN_CR_UID, SCN_CR_DT, SCN_UPD_UID, SCN_UPD_DT FROM SITE_M_COUNTRY  
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
						
						"@user_end_parameter_SCN_ISO"	=>	$value["SCN_ISO"],
						"@user_end_parameter_SCN_ST_SYS_ID"	=>	$value["SCN_ST_SYS_ID"],
						"@user_end_parameter_SCN_DESC"	=>	$value["SCN_DESC"],
						"@user_end_parameter_SCN_FLAG_IMAGE_PATH"	=>	$value["SCN_FLAG_IMAGE_PATH"],
						"@user_end_parameter_SCN_CCY_CODE"	=>	$value["SCN_CCY_CODE"],
						"@user_end_parameter_SCN_CCY_SYMBOL"	=>	$value["SCN_CCY_SYMBOL"],
						"@user_end_parameter_SCN_EXCHANGE_RATE"	=>	$value["SCN_EXCHANGE_RATE"],
						"@user_end_parameter_SCN_FROM_DT"	=>	$value["SCN_FROM_DT"],
						"@user_end_parameter_SCN_UPTO_DT"	=>	$value["SCN_UPTO_DT"],
						"@user_end_parameter_SCN_ACTIVE_YN"	=>	$value["SCN_ACTIVE_YN"],
						"@user_end_parameter_SCN_LANG_CODE"	=>	$value["SCN_LANG_CODE"],
						"@user_end_parameter_SCN_CR_UID"	=>	$value["SCN_CR_UID"],
						"@user_end_parameter_SCN_CR_DT"	=>	$value["SCN_CR_DT"],
						"@user_end_parameter_SCN_UPD_UID"	=>	$value["SCN_UPD_UID"],
						"@user_end_parameter_SCN_UPD_DT"	=>	$value["SCN_UPD_DT"],
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
			
			$sql = " SELECT SCN_ISO, SCN_ST_SYS_ID, SCN_DESC, SCN_FLAG_IMAGE_PATH, SCN_CCY_CODE, SCN_CCY_SYMBOL, SCN_EXCHANGE_RATE, SCN_FROM_DT, SCN_UPTO_DT, SCN_ACTIVE_YN, SCN_LANG_CODE, SCN_CR_UID, SCN_CR_DT, SCN_UPD_UID, SCN_UPD_DT FROM SITE_M_COUNTRY  
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
						
						"@user_end_parameter_SCN_ISO"	=>	$value["SCN_ISO"],
						"@user_end_parameter_SCN_ST_SYS_ID"	=>	$value["SCN_ST_SYS_ID"],
						"@user_end_parameter_SCN_DESC"	=>	$value["SCN_DESC"],
						"@user_end_parameter_SCN_FLAG_IMAGE_PATH"	=>	$value["SCN_FLAG_IMAGE_PATH"],
						"@user_end_parameter_SCN_CCY_CODE"	=>	$value["SCN_CCY_CODE"],
						"@user_end_parameter_SCN_CCY_SYMBOL"	=>	$value["SCN_CCY_SYMBOL"],
						"@user_end_parameter_SCN_EXCHANGE_RATE"	=>	$value["SCN_EXCHANGE_RATE"],
						"@user_end_parameter_SCN_FROM_DT"	=>	$value["SCN_FROM_DT"],
						"@user_end_parameter_SCN_UPTO_DT"	=>	$value["SCN_UPTO_DT"],
						"@user_end_parameter_SCN_ACTIVE_YN"	=>	$value["SCN_ACTIVE_YN"],
						"@user_end_parameter_SCN_LANG_CODE"	=>	$value["SCN_LANG_CODE"],
						"@user_end_parameter_SCN_CR_UID"	=>	$value["SCN_CR_UID"],
						"@user_end_parameter_SCN_CR_DT"	=>	$value["SCN_CR_DT"],
						"@user_end_parameter_SCN_UPD_UID"	=>	$value["SCN_UPD_UID"],
						"@user_end_parameter_SCN_UPD_DT"	=>	$value["SCN_UPD_DT"],
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
			
			$sql = " SELECT SCN_ISO, SCN_ST_SYS_ID, SCN_DESC, SCN_FLAG_IMAGE_PATH, SCN_CCY_CODE, SCN_CCY_SYMBOL, SCN_EXCHANGE_RATE, SCN_FROM_DT, SCN_UPTO_DT, SCN_ACTIVE_YN, SCN_LANG_CODE, SCN_CR_UID, SCN_CR_DT, SCN_UPD_UID, SCN_UPD_DT FROM SITE_M_COUNTRY  
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
			if(!($this->validate("Country"))){
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
		  		
					$_OLD_SCN_ISO	=	$value["SCN_ISO"];
					$_OLD_SCN_ST_SYS_ID	=	$value["SCN_ST_SYS_ID"];
					$_OLD_SCN_DESC	=	$value["SCN_DESC"];
					$_OLD_SCN_FLAG_IMAGE_PATH	=	$value["SCN_FLAG_IMAGE_PATH"];
					$_OLD_SCN_CCY_CODE	=	$value["SCN_CCY_CODE"];
					$_OLD_SCN_CCY_SYMBOL	=	$value["SCN_CCY_SYMBOL"];
					$_OLD_SCN_EXCHANGE_RATE	=	$value["SCN_EXCHANGE_RATE"];
					$_OLD_SCN_FROM_DT	=	$value["SCN_FROM_DT"];
					$_OLD_SCN_UPTO_DT	=	$value["SCN_UPTO_DT"];
					$_OLD_SCN_ACTIVE_YN	=	$value["SCN_ACTIVE_YN"];
					$_OLD_SCN_LANG_CODE	=	$value["SCN_LANG_CODE"];
					$_OLD_SCN_CR_UID	=	$value["SCN_CR_UID"];
					$_OLD_SCN_CR_DT	=	$value["SCN_CR_DT"];
					$_OLD_SCN_UPD_UID	=	$value["SCN_UPD_UID"];
					$_OLD_SCN_UPD_DT	=	$value["SCN_UPD_DT"];
		  	}
		  }
		  
			$_P_SCN_ISO = $this->request->getVar("@user_end_parameter_SCN_ISO");
			$_P_SCN_ST_SYS_ID = $this->request->getVar("@user_end_parameter_SCN_ST_SYS_ID");
			$_P_SCN_DESC = $this->request->getVar("@user_end_parameter_SCN_DESC");
			$_P_SCN_FLAG_IMAGE_PATH = $this->request->getVar("@user_end_parameter_SCN_FLAG_IMAGE_PATH");
			$_P_SCN_CCY_CODE = $this->request->getVar("@user_end_parameter_SCN_CCY_CODE");
			$_P_SCN_CCY_SYMBOL = $this->request->getVar("@user_end_parameter_SCN_CCY_SYMBOL");
			$_P_SCN_EXCHANGE_RATE = $this->request->getVar("@user_end_parameter_SCN_EXCHANGE_RATE");
			$_P_SCN_FROM_DT = $this->request->getVar("@user_end_parameter_SCN_FROM_DT");
			$_P_SCN_UPTO_DT = $this->request->getVar("@user_end_parameter_SCN_UPTO_DT");
			$_P_SCN_ACTIVE_YN = $this->request->getVar("@user_end_parameter_SCN_ACTIVE_YN");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_SCN_ISO", "value"=>$_P_SCN_ISO, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_SCN_ST_SYS_ID", "value"=>$_P_SCN_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SCN_DESC", "value"=>$_P_SCN_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_SCN_FLAG_IMAGE_PATH", "value"=>$_P_SCN_FLAG_IMAGE_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_SCN_CCY_CODE", "value"=>$_P_SCN_CCY_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_SCN_CCY_SYMBOL", "value"=>$_P_SCN_CCY_SYMBOL, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_SCN_EXCHANGE_RATE", "value"=>$_P_SCN_EXCHANGE_RATE, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_SCN_FROM_DT", "value"=>$_P_SCN_FROM_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SCN_UPTO_DT", "value"=>$_P_SCN_UPTO_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SCN_ACTIVE_YN", "value"=>$_P_SCN_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","UPDATE_SITE_M_COUNTRY", $params);

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

			
			$_P_SCN_ISO = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_SCN_ISO", "value"=>$_P_SCN_ISO, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","DELETE_SITE_M_COUNTRY", $params);

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
