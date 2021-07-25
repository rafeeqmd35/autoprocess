<?php
//Steps to do 
// check the namespace is proper or not
// And add the parameter for validation and passing inputs
// for show and edit plz check the PRIMARY_KEY columns
// apart from this whatever u want u can do
//$_CR_DT_COLUMN_NAME - need to define created date column name
//$_PRIMARY_COLUMN_NAME -  need to add primary column name
namespace App\Controllers\Backend;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Backend-SiteModel;

class SiteController extends ResourceController {
	
	use ResponseTrait;

	function __construct()
  {
    $this->db = db_connect();
  }
  
	public function index(){
		try{
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


			$sql = " SELECT ST_SYS_ID, ST_DESC, ST_DOMAIN, ST_THEME, ST_ACTIVE_YN, ST_LANG_CODE, ST_CR_UID, ST_CR_DT, ST_UPD_UID, ST_UPD_DT, ST_FAVICON_PATH FROM SITE_M_SITE  
				ORDER BY $order_by_column_name $sort_by 
				OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
			$query = $this->db->query($sql)->getResult("array");
			$data = [
				"results" => $query
			];
			return $this->respond($data);
		}catch(Exception $e){
			echo $e;
		}
	}

	public function create(){
		try{
			if(!($this->validate("Site"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_ST_DESC = $this->request->getVar("passing_parameter");
			$_P_ST_DOMAIN = $this->request->getVar("passing_parameter");
			$_P_ST_THEME = $this->request->getVar("passing_parameter");
			$_P_ST_FAVICON_PATH = $this->request->getVar("passing_parameter");
			$_P_ST_ACTIVE_YN = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_ST_DESC", "value"=>$_P_ST_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_ST_DOMAIN", "value"=>$_P_ST_DOMAIN, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_ST_THEME", "value"=>$_P_ST_THEME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_ST_FAVICON_PATH", "value"=>$_P_ST_FAVICON_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_ST_ACTIVE_YN", "value"=>$_P_ST_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","INSERT_SITE_M_SITE", $params);

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

	public function new(){
		try{
			$_CR_DT_COLUMN_NAME = "column@";
			$sql = " SELECT ST_SYS_ID, ST_DESC, ST_DOMAIN, ST_THEME, ST_ACTIVE_YN, ST_LANG_CODE, ST_CR_UID, ST_CR_DT, ST_UPD_UID, ST_UPD_DT, ST_FAVICON_PATH FROM SITE_M_SITE  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM SITE_M_SITE)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"ST_SYS_ID"	=>	$value["ST_SYS_ID"],
						"ST_DESC"	=>	$value["ST_DESC"],
						"ST_DOMAIN"	=>	$value["ST_DOMAIN"],
						"ST_THEME"	=>	$value["ST_THEME"],
						"ST_ACTIVE_YN"	=>	$value["ST_ACTIVE_YN"],
						"ST_LANG_CODE"	=>	$value["ST_LANG_CODE"],
						"ST_CR_UID"	=>	$value["ST_CR_UID"],
						"ST_CR_DT"	=>	$value["ST_CR_DT"],
						"ST_UPD_UID"	=>	$value["ST_UPD_UID"],
						"ST_UPD_DT"	=>	$value["ST_UPD_DT"],
						"ST_FAVICON_PATH"	=>	$value["ST_FAVICON_PATH"],
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
			$_PRIMARY_COLUMN_NAME = "column@";
			$sql = " SELECT ST_SYS_ID, ST_DESC, ST_DOMAIN, ST_THEME, ST_ACTIVE_YN, ST_LANG_CODE, ST_CR_UID, ST_CR_DT, ST_UPD_UID, ST_UPD_DT, ST_FAVICON_PATH FROM SITE_M_SITE  
							WHERE :PRIMARY_KEY: = :ID:";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"ID"     => $_id
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"ST_SYS_ID"	=>	$value["ST_SYS_ID"],
						"ST_DESC"	=>	$value["ST_DESC"],
						"ST_DOMAIN"	=>	$value["ST_DOMAIN"],
						"ST_THEME"	=>	$value["ST_THEME"],
						"ST_ACTIVE_YN"	=>	$value["ST_ACTIVE_YN"],
						"ST_LANG_CODE"	=>	$value["ST_LANG_CODE"],
						"ST_CR_UID"	=>	$value["ST_CR_UID"],
						"ST_CR_DT"	=>	$value["ST_CR_DT"],
						"ST_UPD_UID"	=>	$value["ST_UPD_UID"],
						"ST_UPD_DT"	=>	$value["ST_UPD_DT"],
						"ST_FAVICON_PATH"	=>	$value["ST_FAVICON_PATH"],
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
			$_PRIMARY_COLUMN_NAME = "column@";
			$sql = " SELECT ST_SYS_ID, ST_DESC, ST_DOMAIN, ST_THEME, ST_ACTIVE_YN, ST_LANG_CODE, ST_CR_UID, ST_CR_DT, ST_UPD_UID, ST_UPD_DT, ST_FAVICON_PATH FROM SITE_M_SITE  
							WHERE :PRIMARY_KEY: = :ID: ";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"ID"     => $_id
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"ST_SYS_ID"	=>	$value["ST_SYS_ID"],
						"ST_DESC"	=>	$value["ST_DESC"],
						"ST_DOMAIN"	=>	$value["ST_DOMAIN"],
						"ST_THEME"	=>	$value["ST_THEME"],
						"ST_ACTIVE_YN"	=>	$value["ST_ACTIVE_YN"],
						"ST_LANG_CODE"	=>	$value["ST_LANG_CODE"],
						"ST_CR_UID"	=>	$value["ST_CR_UID"],
						"ST_CR_DT"	=>	$value["ST_CR_DT"],
						"ST_UPD_UID"	=>	$value["ST_UPD_UID"],
						"ST_UPD_DT"	=>	$value["ST_UPD_DT"],
						"ST_FAVICON_PATH"	=>	$value["ST_FAVICON_PATH"],
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

	protected function fetch($_id = null){
		try{
			$_PRIMARY_COLUMN_NAME = "column@";
			$sql = " SELECT ST_SYS_ID, ST_DESC, ST_DOMAIN, ST_THEME, ST_ACTIVE_YN, ST_LANG_CODE, ST_CR_UID, ST_CR_DT, ST_UPD_UID, ST_UPD_DT, ST_FAVICON_PATH FROM SITE_M_SITE  
							WHERE :PRIMARY_KEY: = :ID: ";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"ID"     => $_id
			])->getResult("array");

			if($query){
				$return_status = "0";
				$error_message = "Success";
			}else{
				$return_status = "-113";
				$error_message = "No Data Found";
			}
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> $query);
			return $this->respond($response);
		}catch(\Exception $e){
			//throw new \RuntimeException($e->getMessage(), $e->getCode(), $e);
			$return_status = "-333";
			$error_message = $e->getMessage();
			$response = array("return_status"=>$return_status,"error_message"=>$error_message,"result"=> []);
			return $this->respond($response);	
		}
	}

	public function update($_id = null){
		try{
			if(!($this->validate("Site"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

      //$this->request->getVar("passing parameter");

      $_exist_data = [];

      $_fetch_edit = $this->fetch($_id);

      if($_fetch_edit["return_status"] != "0" || $_fetch_edit["return_status"] != "Success" && count($_fetch_edit["result"]) == 0){
      	$result = array("return_status"=>"-113","error_message"=>"No Data Found","result"=>[] );
      	return $this->respond($result);
      }else{
      	$_exist_data = $_fetch_edit["result"];
      	foreach ($_exist_data as $key => $value) {
		  		
					$_OLD_ST_SYS_ID	=	$value["ST_SYS_ID"];
					$_OLD_ST_DESC	=	$value["ST_DESC"];
					$_OLD_ST_DOMAIN	=	$value["ST_DOMAIN"];
					$_OLD_ST_THEME	=	$value["ST_THEME"];
					$_OLD_ST_ACTIVE_YN	=	$value["ST_ACTIVE_YN"];
					$_OLD_ST_LANG_CODE	=	$value["ST_LANG_CODE"];
					$_OLD_ST_CR_UID	=	$value["ST_CR_UID"];
					$_OLD_ST_CR_DT	=	$value["ST_CR_DT"];
					$_OLD_ST_UPD_UID	=	$value["ST_UPD_UID"];
					$_OLD_ST_UPD_DT	=	$value["ST_UPD_DT"];
					$_OLD_ST_FAVICON_PATH	=	$value["ST_FAVICON_PATH"];
		  	}
		  }
		  
			$_P_ST_SYS_ID = $this->request->getVar("passing_parameter");
			$_P_ST_DESC = $this->request->getVar("passing_parameter");
			$_P_ST_DOMAIN = $this->request->getVar("passing_parameter");
			$_P_ST_THEME = $this->request->getVar("passing_parameter");
			$_P_ST_FAVICON_PATH = $this->request->getVar("passing_parameter");
			$_P_ST_ACTIVE_YN = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_ST_SYS_ID", "value"=>$_P_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_ST_DESC", "value"=>$_P_ST_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_ST_DOMAIN", "value"=>$_P_ST_DOMAIN, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_ST_THEME", "value"=>$_P_ST_THEME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_ST_FAVICON_PATH", "value"=>$_P_ST_FAVICON_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_ST_ACTIVE_YN", "value"=>$_P_ST_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","UPDATE_SITE_M_SITE", $params);

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

	public function delete($_id = null){
		try{
			
			$_P_ST_SYS_ID = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_ST_SYS_ID", "value"=>$_P_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>2),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","DELETE_SITE_M_SITE", $params);

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
