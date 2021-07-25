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
use App\Models\Backend-UserModel;

class UserController extends ResourceController {
	
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


			$sql = " SELECT USER_ST_SYS_ID, USER_ID, USER_DESC, USER_LOCN_CODE, USER_PERS_CODE, USER_PASSWD, USER_PW_CHANGE_YN, USER_EMAIL, USER_OFFICE_PHONE, USER_HOME_PHONE, USER_CELL_PHONE, USER_IMAGE_PATH, USER_FROM_DT, USER_UPTO_DT, USER_LOGIN_FROM, USER_LOGIN_UPTO, USER_PW_AUTH_CODE, USER_RESET_PW_YN, USER_TYPE, USER_ROLE, USER_SHOW_SALE_PRICE_YN, USER_GLOBAL_YN, USER_GLOBAL_ACCESS_YN, USER_FORCE_SEC_YN, USER_FEEDBACK_YN, USER_SESSION_EXP_YN, USER_EMAIL_PASSWD, USER_ACTIVE_YN, USER_LANG_CODE, USER_CR_UID, USER_CR_DT, USER_UPD_UID, USER_UPD_DT FROM SITE_M_USER  
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
			if(!($this->validate("User"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_USER_ST_SYS_ID = $this->request->getVar("@user_end_parameter_USER_ST_SYS_ID");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_USER_DESC = $this->request->getVar("@user_end_parameter_USER_DESC");
			$_P_USER_LOCN_CODE = $this->request->getVar("@user_end_parameter_USER_LOCN_CODE");
			$_P_USER_PERS_CODE = $this->request->getVar("@user_end_parameter_USER_PERS_CODE");
			$_P_USER_PASSWD = $this->request->getVar("@user_end_parameter_USER_PASSWD");
			$_P_USER_PW_CHANGE_YN = $this->request->getVar("@user_end_parameter_USER_PW_CHANGE_YN");
			$_P_USER_EMAIL = $this->request->getVar("@user_end_parameter_USER_EMAIL");
			$_P_USER_OFFICE_PHONE = $this->request->getVar("@user_end_parameter_USER_OFFICE_PHONE");
			$_P_USER_HOME_PHONE = $this->request->getVar("@user_end_parameter_USER_HOME_PHONE");
			$_P_USER_CELL_PHONE = $this->request->getVar("@user_end_parameter_USER_CELL_PHONE");
			$_P_USER_IMAGE_PATH = $this->request->getVar("@user_end_parameter_USER_IMAGE_PATH");
			$_P_USER_FROM_DT = $this->request->getVar("@user_end_parameter_USER_FROM_DT");
			$_P_USER_UPTO_DT = $this->request->getVar("@user_end_parameter_USER_UPTO_DT");
			$_P_USER_LOGIN_FROM = $this->request->getVar("@user_end_parameter_USER_LOGIN_FROM");
			$_P_USER_LOGIN_UPTO = $this->request->getVar("@user_end_parameter_USER_LOGIN_UPTO");
			$_P_USER_PW_AUTH_CODE = $this->request->getVar("@user_end_parameter_USER_PW_AUTH_CODE");
			$_P_USER_RESET_PW_YN = $this->request->getVar("@user_end_parameter_USER_RESET_PW_YN");
			$_P_USER_TYPE = $this->request->getVar("@user_end_parameter_USER_TYPE");
			$_P_USER_ROLE = $this->request->getVar("@user_end_parameter_USER_ROLE");
			$_P_USER_SHOW_SALE_PRICE_YN = $this->request->getVar("@user_end_parameter_USER_SHOW_SALE_PRICE_YN");
			$_P_USER_GLOBAL_YN = $this->request->getVar("@user_end_parameter_USER_GLOBAL_YN");
			$_P_USER_GLOBAL_ACCESS_YN = $this->request->getVar("@user_end_parameter_USER_GLOBAL_ACCESS_YN");
			$_P_USER_FORCE_SEC_YN = $this->request->getVar("@user_end_parameter_USER_FORCE_SEC_YN");
			$_P_USER_FEEDBACK_YN = $this->request->getVar("@user_end_parameter_USER_FEEDBACK_YN");
			$_P_USER_SESSION_EXP_YN = $this->request->getVar("@user_end_parameter_USER_SESSION_EXYN");
			$_P_USER_EMAIL_PASSWD = $this->request->getVar("@user_end_parameter_USER_EMAIL_PASSWD");
			$_P_USER_ACTIVE_YN = $this->request->getVar("@user_end_parameter_USER_ACTIVE_YN");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_USER_CR_UID = $this->request->getVar("@user_end_parameter_USER_CR_UID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_USER_ST_SYS_ID", "value"=>$_P_USER_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_USER_DESC", "value"=>$_P_USER_DESC, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_LOCN_CODE", "value"=>$_P_USER_LOCN_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_PERS_CODE", "value"=>$_P_USER_PERS_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_PASSWD", "value"=>$_P_USER_PASSWD, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_USER_PW_CHANGE_YN", "value"=>$_P_USER_PW_CHANGE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_EMAIL", "value"=>$_P_USER_EMAIL, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_OFFICE_PHONE", "value"=>$_P_USER_OFFICE_PHONE, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_HOME_PHONE", "value"=>$_P_USER_HOME_PHONE, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_CELL_PHONE", "value"=>$_P_USER_CELL_PHONE, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_IMAGE_PATH", "value"=>$_P_USER_IMAGE_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_USER_FROM_DT", "value"=>$_P_USER_FROM_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_UPTO_DT", "value"=>$_P_USER_UPTO_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_LOGIN_FROM", "value"=>$_P_USER_LOGIN_FROM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_LOGIN_UPTO", "value"=>$_P_USER_LOGIN_UPTO, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_PW_AUTH_CODE", "value"=>$_P_USER_PW_AUTH_CODE, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_USER_RESET_PW_YN", "value"=>$_P_USER_RESET_PW_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_TYPE", "value"=>$_P_USER_TYPE, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_ROLE", "value"=>$_P_USER_ROLE, "type"=>SQLT_CHR, "length"=>15),
				array("name"=>":P_USER_SHOW_SALE_PRICE_YN", "value"=>$_P_USER_SHOW_SALE_PRICE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_GLOBAL_YN", "value"=>$_P_USER_GLOBAL_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_GLOBAL_ACCESS_YN", "value"=>$_P_USER_GLOBAL_ACCESS_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_FORCE_SEC_YN", "value"=>$_P_USER_FORCE_SEC_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_FEEDBACK_YN", "value"=>$_P_USER_FEEDBACK_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_SESSION_EXP_YN", "value"=>$_P_USER_SESSION_EXP_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_EMAIL_PASSWD", "value"=>$_P_USER_EMAIL_PASSWD, "type"=>SQLT_CHR, "length"=>150),
				array("name"=>":P_USER_ACTIVE_YN", "value"=>$_P_USER_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_CR_UID", "value"=>$_P_USER_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","INSERT_SITE_M_USER", $params);

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
			$sql = " SELECT USER_ST_SYS_ID, USER_ID, USER_DESC, USER_LOCN_CODE, USER_PERS_CODE, USER_PASSWD, USER_PW_CHANGE_YN, USER_EMAIL, USER_OFFICE_PHONE, USER_HOME_PHONE, USER_CELL_PHONE, USER_IMAGE_PATH, USER_FROM_DT, USER_UPTO_DT, USER_LOGIN_FROM, USER_LOGIN_UPTO, USER_PW_AUTH_CODE, USER_RESET_PW_YN, USER_TYPE, USER_ROLE, USER_SHOW_SALE_PRICE_YN, USER_GLOBAL_YN, USER_GLOBAL_ACCESS_YN, USER_FORCE_SEC_YN, USER_FEEDBACK_YN, USER_SESSION_EXP_YN, USER_EMAIL_PASSWD, USER_ACTIVE_YN, USER_LANG_CODE, USER_CR_UID, USER_CR_DT, USER_UPD_UID, USER_UPD_DT FROM SITE_M_USER  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM SITE_M_USER)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_USER_ST_SYS_ID"	=>	$value["USER_ST_SYS_ID"],
						"@user_end_parameter_USER_ID"	=>	$value["USER_ID"],
						"@user_end_parameter_USER_DESC"	=>	$value["USER_DESC"],
						"@user_end_parameter_USER_LOCN_CODE"	=>	$value["USER_LOCN_CODE"],
						"@user_end_parameter_USER_PERS_CODE"	=>	$value["USER_PERS_CODE"],
						"@user_end_parameter_USER_PASSWD"	=>	$value["USER_PASSWD"],
						"@user_end_parameter_USER_PW_CHANGE_YN"	=>	$value["USER_PW_CHANGE_YN"],
						"@user_end_parameter_USER_EMAIL"	=>	$value["USER_EMAIL"],
						"@user_end_parameter_USER_OFFICE_PHONE"	=>	$value["USER_OFFICE_PHONE"],
						"@user_end_parameter_USER_HOME_PHONE"	=>	$value["USER_HOME_PHONE"],
						"@user_end_parameter_USER_CELL_PHONE"	=>	$value["USER_CELL_PHONE"],
						"@user_end_parameter_USER_IMAGE_PATH"	=>	$value["USER_IMAGE_PATH"],
						"@user_end_parameter_USER_FROM_DT"	=>	$value["USER_FROM_DT"],
						"@user_end_parameter_USER_UPTO_DT"	=>	$value["USER_UPTO_DT"],
						"@user_end_parameter_USER_LOGIN_FROM"	=>	$value["USER_LOGIN_FROM"],
						"@user_end_parameter_USER_LOGIN_UPTO"	=>	$value["USER_LOGIN_UPTO"],
						"@user_end_parameter_USER_PW_AUTH_CODE"	=>	$value["USER_PW_AUTH_CODE"],
						"@user_end_parameter_USER_RESET_PW_YN"	=>	$value["USER_RESET_PW_YN"],
						"@user_end_parameter_USER_TYPE"	=>	$value["USER_TYPE"],
						"@user_end_parameter_USER_ROLE"	=>	$value["USER_ROLE"],
						"@user_end_parameter_USER_SHOW_SALE_PRICE_YN"	=>	$value["USER_SHOW_SALE_PRICE_YN"],
						"@user_end_parameter_USER_GLOBAL_YN"	=>	$value["USER_GLOBAL_YN"],
						"@user_end_parameter_USER_GLOBAL_ACCESS_YN"	=>	$value["USER_GLOBAL_ACCESS_YN"],
						"@user_end_parameter_USER_FORCE_SEC_YN"	=>	$value["USER_FORCE_SEC_YN"],
						"@user_end_parameter_USER_FEEDBACK_YN"	=>	$value["USER_FEEDBACK_YN"],
						"@user_end_parameter_USER_SESSION_EXP_YN"	=>	$value["USER_SESSION_EXP_YN"],
						"@user_end_parameter_USER_EMAIL_PASSWD"	=>	$value["USER_EMAIL_PASSWD"],
						"@user_end_parameter_USER_ACTIVE_YN"	=>	$value["USER_ACTIVE_YN"],
						"@user_end_parameter_USER_LANG_CODE"	=>	$value["USER_LANG_CODE"],
						"@user_end_parameter_USER_CR_UID"	=>	$value["USER_CR_UID"],
						"@user_end_parameter_USER_CR_DT"	=>	$value["USER_CR_DT"],
						"@user_end_parameter_USER_UPD_UID"	=>	$value["USER_UPD_UID"],
						"@user_end_parameter_USER_UPD_DT"	=>	$value["USER_UPD_DT"],
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
			$sql = " SELECT USER_ST_SYS_ID, USER_ID, USER_DESC, USER_LOCN_CODE, USER_PERS_CODE, USER_PASSWD, USER_PW_CHANGE_YN, USER_EMAIL, USER_OFFICE_PHONE, USER_HOME_PHONE, USER_CELL_PHONE, USER_IMAGE_PATH, USER_FROM_DT, USER_UPTO_DT, USER_LOGIN_FROM, USER_LOGIN_UPTO, USER_PW_AUTH_CODE, USER_RESET_PW_YN, USER_TYPE, USER_ROLE, USER_SHOW_SALE_PRICE_YN, USER_GLOBAL_YN, USER_GLOBAL_ACCESS_YN, USER_FORCE_SEC_YN, USER_FEEDBACK_YN, USER_SESSION_EXP_YN, USER_EMAIL_PASSWD, USER_ACTIVE_YN, USER_LANG_CODE, USER_CR_UID, USER_CR_DT, USER_UPD_UID, USER_UPD_DT FROM SITE_M_USER  
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
						
						"@user_end_parameter_USER_ST_SYS_ID"	=>	$value["USER_ST_SYS_ID"],
						"@user_end_parameter_USER_ID"	=>	$value["USER_ID"],
						"@user_end_parameter_USER_DESC"	=>	$value["USER_DESC"],
						"@user_end_parameter_USER_LOCN_CODE"	=>	$value["USER_LOCN_CODE"],
						"@user_end_parameter_USER_PERS_CODE"	=>	$value["USER_PERS_CODE"],
						"@user_end_parameter_USER_PASSWD"	=>	$value["USER_PASSWD"],
						"@user_end_parameter_USER_PW_CHANGE_YN"	=>	$value["USER_PW_CHANGE_YN"],
						"@user_end_parameter_USER_EMAIL"	=>	$value["USER_EMAIL"],
						"@user_end_parameter_USER_OFFICE_PHONE"	=>	$value["USER_OFFICE_PHONE"],
						"@user_end_parameter_USER_HOME_PHONE"	=>	$value["USER_HOME_PHONE"],
						"@user_end_parameter_USER_CELL_PHONE"	=>	$value["USER_CELL_PHONE"],
						"@user_end_parameter_USER_IMAGE_PATH"	=>	$value["USER_IMAGE_PATH"],
						"@user_end_parameter_USER_FROM_DT"	=>	$value["USER_FROM_DT"],
						"@user_end_parameter_USER_UPTO_DT"	=>	$value["USER_UPTO_DT"],
						"@user_end_parameter_USER_LOGIN_FROM"	=>	$value["USER_LOGIN_FROM"],
						"@user_end_parameter_USER_LOGIN_UPTO"	=>	$value["USER_LOGIN_UPTO"],
						"@user_end_parameter_USER_PW_AUTH_CODE"	=>	$value["USER_PW_AUTH_CODE"],
						"@user_end_parameter_USER_RESET_PW_YN"	=>	$value["USER_RESET_PW_YN"],
						"@user_end_parameter_USER_TYPE"	=>	$value["USER_TYPE"],
						"@user_end_parameter_USER_ROLE"	=>	$value["USER_ROLE"],
						"@user_end_parameter_USER_SHOW_SALE_PRICE_YN"	=>	$value["USER_SHOW_SALE_PRICE_YN"],
						"@user_end_parameter_USER_GLOBAL_YN"	=>	$value["USER_GLOBAL_YN"],
						"@user_end_parameter_USER_GLOBAL_ACCESS_YN"	=>	$value["USER_GLOBAL_ACCESS_YN"],
						"@user_end_parameter_USER_FORCE_SEC_YN"	=>	$value["USER_FORCE_SEC_YN"],
						"@user_end_parameter_USER_FEEDBACK_YN"	=>	$value["USER_FEEDBACK_YN"],
						"@user_end_parameter_USER_SESSION_EXP_YN"	=>	$value["USER_SESSION_EXP_YN"],
						"@user_end_parameter_USER_EMAIL_PASSWD"	=>	$value["USER_EMAIL_PASSWD"],
						"@user_end_parameter_USER_ACTIVE_YN"	=>	$value["USER_ACTIVE_YN"],
						"@user_end_parameter_USER_LANG_CODE"	=>	$value["USER_LANG_CODE"],
						"@user_end_parameter_USER_CR_UID"	=>	$value["USER_CR_UID"],
						"@user_end_parameter_USER_CR_DT"	=>	$value["USER_CR_DT"],
						"@user_end_parameter_USER_UPD_UID"	=>	$value["USER_UPD_UID"],
						"@user_end_parameter_USER_UPD_DT"	=>	$value["USER_UPD_DT"],
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
			$sql = " SELECT USER_ST_SYS_ID, USER_ID, USER_DESC, USER_LOCN_CODE, USER_PERS_CODE, USER_PASSWD, USER_PW_CHANGE_YN, USER_EMAIL, USER_OFFICE_PHONE, USER_HOME_PHONE, USER_CELL_PHONE, USER_IMAGE_PATH, USER_FROM_DT, USER_UPTO_DT, USER_LOGIN_FROM, USER_LOGIN_UPTO, USER_PW_AUTH_CODE, USER_RESET_PW_YN, USER_TYPE, USER_ROLE, USER_SHOW_SALE_PRICE_YN, USER_GLOBAL_YN, USER_GLOBAL_ACCESS_YN, USER_FORCE_SEC_YN, USER_FEEDBACK_YN, USER_SESSION_EXP_YN, USER_EMAIL_PASSWD, USER_ACTIVE_YN, USER_LANG_CODE, USER_CR_UID, USER_CR_DT, USER_UPD_UID, USER_UPD_DT FROM SITE_M_USER  
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
						
						"@user_end_parameter_USER_ST_SYS_ID"	=>	$value["USER_ST_SYS_ID"],
						"@user_end_parameter_USER_ID"	=>	$value["USER_ID"],
						"@user_end_parameter_USER_DESC"	=>	$value["USER_DESC"],
						"@user_end_parameter_USER_LOCN_CODE"	=>	$value["USER_LOCN_CODE"],
						"@user_end_parameter_USER_PERS_CODE"	=>	$value["USER_PERS_CODE"],
						"@user_end_parameter_USER_PASSWD"	=>	$value["USER_PASSWD"],
						"@user_end_parameter_USER_PW_CHANGE_YN"	=>	$value["USER_PW_CHANGE_YN"],
						"@user_end_parameter_USER_EMAIL"	=>	$value["USER_EMAIL"],
						"@user_end_parameter_USER_OFFICE_PHONE"	=>	$value["USER_OFFICE_PHONE"],
						"@user_end_parameter_USER_HOME_PHONE"	=>	$value["USER_HOME_PHONE"],
						"@user_end_parameter_USER_CELL_PHONE"	=>	$value["USER_CELL_PHONE"],
						"@user_end_parameter_USER_IMAGE_PATH"	=>	$value["USER_IMAGE_PATH"],
						"@user_end_parameter_USER_FROM_DT"	=>	$value["USER_FROM_DT"],
						"@user_end_parameter_USER_UPTO_DT"	=>	$value["USER_UPTO_DT"],
						"@user_end_parameter_USER_LOGIN_FROM"	=>	$value["USER_LOGIN_FROM"],
						"@user_end_parameter_USER_LOGIN_UPTO"	=>	$value["USER_LOGIN_UPTO"],
						"@user_end_parameter_USER_PW_AUTH_CODE"	=>	$value["USER_PW_AUTH_CODE"],
						"@user_end_parameter_USER_RESET_PW_YN"	=>	$value["USER_RESET_PW_YN"],
						"@user_end_parameter_USER_TYPE"	=>	$value["USER_TYPE"],
						"@user_end_parameter_USER_ROLE"	=>	$value["USER_ROLE"],
						"@user_end_parameter_USER_SHOW_SALE_PRICE_YN"	=>	$value["USER_SHOW_SALE_PRICE_YN"],
						"@user_end_parameter_USER_GLOBAL_YN"	=>	$value["USER_GLOBAL_YN"],
						"@user_end_parameter_USER_GLOBAL_ACCESS_YN"	=>	$value["USER_GLOBAL_ACCESS_YN"],
						"@user_end_parameter_USER_FORCE_SEC_YN"	=>	$value["USER_FORCE_SEC_YN"],
						"@user_end_parameter_USER_FEEDBACK_YN"	=>	$value["USER_FEEDBACK_YN"],
						"@user_end_parameter_USER_SESSION_EXP_YN"	=>	$value["USER_SESSION_EXP_YN"],
						"@user_end_parameter_USER_EMAIL_PASSWD"	=>	$value["USER_EMAIL_PASSWD"],
						"@user_end_parameter_USER_ACTIVE_YN"	=>	$value["USER_ACTIVE_YN"],
						"@user_end_parameter_USER_LANG_CODE"	=>	$value["USER_LANG_CODE"],
						"@user_end_parameter_USER_CR_UID"	=>	$value["USER_CR_UID"],
						"@user_end_parameter_USER_CR_DT"	=>	$value["USER_CR_DT"],
						"@user_end_parameter_USER_UPD_UID"	=>	$value["USER_UPD_UID"],
						"@user_end_parameter_USER_UPD_DT"	=>	$value["USER_UPD_DT"],
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
			$sql = " SELECT USER_ST_SYS_ID, USER_ID, USER_DESC, USER_LOCN_CODE, USER_PERS_CODE, USER_PASSWD, USER_PW_CHANGE_YN, USER_EMAIL, USER_OFFICE_PHONE, USER_HOME_PHONE, USER_CELL_PHONE, USER_IMAGE_PATH, USER_FROM_DT, USER_UPTO_DT, USER_LOGIN_FROM, USER_LOGIN_UPTO, USER_PW_AUTH_CODE, USER_RESET_PW_YN, USER_TYPE, USER_ROLE, USER_SHOW_SALE_PRICE_YN, USER_GLOBAL_YN, USER_GLOBAL_ACCESS_YN, USER_FORCE_SEC_YN, USER_FEEDBACK_YN, USER_SESSION_EXP_YN, USER_EMAIL_PASSWD, USER_ACTIVE_YN, USER_LANG_CODE, USER_CR_UID, USER_CR_DT, USER_UPD_UID, USER_UPD_DT FROM SITE_M_USER  
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
			if(!($this->validate("User"))){
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
		  		
					$_OLD_USER_ST_SYS_ID	=	$value["USER_ST_SYS_ID"];
					$_OLD_USER_ID	=	$value["USER_ID"];
					$_OLD_USER_DESC	=	$value["USER_DESC"];
					$_OLD_USER_LOCN_CODE	=	$value["USER_LOCN_CODE"];
					$_OLD_USER_PERS_CODE	=	$value["USER_PERS_CODE"];
					$_OLD_USER_PASSWD	=	$value["USER_PASSWD"];
					$_OLD_USER_PW_CHANGE_YN	=	$value["USER_PW_CHANGE_YN"];
					$_OLD_USER_EMAIL	=	$value["USER_EMAIL"];
					$_OLD_USER_OFFICE_PHONE	=	$value["USER_OFFICE_PHONE"];
					$_OLD_USER_HOME_PHONE	=	$value["USER_HOME_PHONE"];
					$_OLD_USER_CELL_PHONE	=	$value["USER_CELL_PHONE"];
					$_OLD_USER_IMAGE_PATH	=	$value["USER_IMAGE_PATH"];
					$_OLD_USER_FROM_DT	=	$value["USER_FROM_DT"];
					$_OLD_USER_UPTO_DT	=	$value["USER_UPTO_DT"];
					$_OLD_USER_LOGIN_FROM	=	$value["USER_LOGIN_FROM"];
					$_OLD_USER_LOGIN_UPTO	=	$value["USER_LOGIN_UPTO"];
					$_OLD_USER_PW_AUTH_CODE	=	$value["USER_PW_AUTH_CODE"];
					$_OLD_USER_RESET_PW_YN	=	$value["USER_RESET_PW_YN"];
					$_OLD_USER_TYPE	=	$value["USER_TYPE"];
					$_OLD_USER_ROLE	=	$value["USER_ROLE"];
					$_OLD_USER_SHOW_SALE_PRICE_YN	=	$value["USER_SHOW_SALE_PRICE_YN"];
					$_OLD_USER_GLOBAL_YN	=	$value["USER_GLOBAL_YN"];
					$_OLD_USER_GLOBAL_ACCESS_YN	=	$value["USER_GLOBAL_ACCESS_YN"];
					$_OLD_USER_FORCE_SEC_YN	=	$value["USER_FORCE_SEC_YN"];
					$_OLD_USER_FEEDBACK_YN	=	$value["USER_FEEDBACK_YN"];
					$_OLD_USER_SESSION_EXP_YN	=	$value["USER_SESSION_EXP_YN"];
					$_OLD_USER_EMAIL_PASSWD	=	$value["USER_EMAIL_PASSWD"];
					$_OLD_USER_ACTIVE_YN	=	$value["USER_ACTIVE_YN"];
					$_OLD_USER_LANG_CODE	=	$value["USER_LANG_CODE"];
					$_OLD_USER_CR_UID	=	$value["USER_CR_UID"];
					$_OLD_USER_CR_DT	=	$value["USER_CR_DT"];
					$_OLD_USER_UPD_UID	=	$value["USER_UPD_UID"];
					$_OLD_USER_UPD_DT	=	$value["USER_UPD_DT"];
		  	}
		  }
		  
			$_P_USER_ST_SYS_ID = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_USER_DESC = $this->request->getVar("passing_parameter");
			$_P_USER_LOCN_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_PERS_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_PASSWD = $this->request->getVar("passing_parameter");
			$_P_USER_PW_CHANGE_YN = $this->request->getVar("passing_parameter");
			$_P_USER_EMAIL = $this->request->getVar("passing_parameter");
			$_P_USER_OFFICE_PHONE = $this->request->getVar("passing_parameter");
			$_P_USER_HOME_PHONE = $this->request->getVar("passing_parameter");
			$_P_USER_CELL_PHONE = $this->request->getVar("passing_parameter");
			$_P_USER_IMAGE_PATH = $this->request->getVar("passing_parameter");
			$_P_USER_FROM_DT = $this->request->getVar("passing_parameter");
			$_P_USER_UPTO_DT = $this->request->getVar("passing_parameter");
			$_P_USER_LOGIN_FROM = $this->request->getVar("passing_parameter");
			$_P_USER_LOGIN_UPTO = $this->request->getVar("passing_parameter");
			$_P_USER_PW_AUTH_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_RESET_PW_YN = $this->request->getVar("passing_parameter");
			$_P_USER_TYPE = $this->request->getVar("passing_parameter");
			$_P_USER_ROLE = $this->request->getVar("passing_parameter");
			$_P_USER_SHOW_SALE_PRICE_YN = $this->request->getVar("passing_parameter");
			$_P_USER_GLOBAL_YN = $this->request->getVar("passing_parameter");
			$_P_USER_GLOBAL_ACCESS_YN = $this->request->getVar("passing_parameter");
			$_P_USER_FORCE_SEC_YN = $this->request->getVar("passing_parameter");
			$_P_USER_FEEDBACK_YN = $this->request->getVar("passing_parameter");
			$_P_USER_SESSION_EXP_YN = $this->request->getVar("passing_parameter");
			$_P_USER_EMAIL_PASSWD = $this->request->getVar("passing_parameter");
			$_P_USER_ACTIVE_YN = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_UPD_UID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_USER_ST_SYS_ID", "value"=>$_P_USER_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_USER_DESC", "value"=>$_P_USER_DESC, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_LOCN_CODE", "value"=>$_P_USER_LOCN_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_PERS_CODE", "value"=>$_P_USER_PERS_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_PASSWD", "value"=>$_P_USER_PASSWD, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_USER_PW_CHANGE_YN", "value"=>$_P_USER_PW_CHANGE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_EMAIL", "value"=>$_P_USER_EMAIL, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_OFFICE_PHONE", "value"=>$_P_USER_OFFICE_PHONE, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_HOME_PHONE", "value"=>$_P_USER_HOME_PHONE, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_CELL_PHONE", "value"=>$_P_USER_CELL_PHONE, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_USER_IMAGE_PATH", "value"=>$_P_USER_IMAGE_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_USER_FROM_DT", "value"=>$_P_USER_FROM_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_UPTO_DT", "value"=>$_P_USER_UPTO_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_LOGIN_FROM", "value"=>$_P_USER_LOGIN_FROM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_LOGIN_UPTO", "value"=>$_P_USER_LOGIN_UPTO, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_PW_AUTH_CODE", "value"=>$_P_USER_PW_AUTH_CODE, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_USER_RESET_PW_YN", "value"=>$_P_USER_RESET_PW_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_TYPE", "value"=>$_P_USER_TYPE, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_ROLE", "value"=>$_P_USER_ROLE, "type"=>SQLT_CHR, "length"=>15),
				array("name"=>":P_USER_SHOW_SALE_PRICE_YN", "value"=>$_P_USER_SHOW_SALE_PRICE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_GLOBAL_YN", "value"=>$_P_USER_GLOBAL_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_GLOBAL_ACCESS_YN", "value"=>$_P_USER_GLOBAL_ACCESS_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_FORCE_SEC_YN", "value"=>$_P_USER_FORCE_SEC_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_FEEDBACK_YN", "value"=>$_P_USER_FEEDBACK_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_SESSION_EXP_YN", "value"=>$_P_USER_SESSION_EXP_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_USER_EMAIL_PASSWD", "value"=>$_P_USER_EMAIL_PASSWD, "type"=>SQLT_CHR, "length"=>150),
				array("name"=>":P_USER_ACTIVE_YN", "value"=>$_P_USER_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_UPD_UID", "value"=>$_P_USER_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","UPDATE_SITE_M_USER", $params);

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
			
			$_P_USER_ST_SYS_ID = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_CR_UID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_USER_ST_SYS_ID", "value"=>$_P_USER_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_CR_UID", "value"=>$_P_USER_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","DELETE_SITE_M_USER", $params);

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
