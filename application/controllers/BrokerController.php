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
use App\Models\Backend-BrokerModel;

class BrokerController extends ResourceController {
	
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


			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
				ORDER BY $order_by_column_name $sort_by 
				OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
			$query = $this->db->query($sql)->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			if(!($this->validate("Broker"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_MB_TITLE = $this->request->getVar("@user_end_parameter_MB_TITLE");
			$_P_MB_NAME = $this->request->getVar("@user_end_parameter_MB_NAME");
			$_P_MB_EMAIL = $this->request->getVar("@user_end_parameter_MB_EMAIL");
			$_P_MB_PASSWD = $this->request->getVar("@user_end_parameter_MB_PASSWD");
			$_P_MB_MOBILE = $this->request->getVar("@user_end_parameter_MB_MOBILE");
			$_P_MB_ID_NUMBER = $this->request->getVar("@user_end_parameter_MB_ID_NUMBER");
			$_P_MB_ID_PATH = $this->request->getVar("@user_end_parameter_MB_ID_PATH");
			$_P_MB_COMP_NAME = $this->request->getVar("@user_end_parameter_MB_COMNAME");
			$_P_MB_COMP_ADDRESS = $this->request->getVar("@user_end_parameter_MB_COMADDRESS");
			$_P_MB_PHONE = $this->request->getVar("@user_end_parameter_MB_PHONE");
			$_P_MB_TAX_REG_YN = $this->request->getVar("@user_end_parameter_MB_TAX_REG_YN");
			$_P_MB_TAX_REG_NO = $this->request->getVar("@user_end_parameter_MB_TAX_REG_NO");
			$_P_MB_TAX_REG_PATH = $this->request->getVar("@user_end_parameter_MB_TAX_REG_PATH");
			$_P_MB_BANK_NAME = $this->request->getVar("@user_end_parameter_MB_BANK_NAME");
			$_P_MB_BANK_ACCOUNT_NUMBER = $this->request->getVar("@user_end_parameter_MB_BANK_ACCOUNT_NUMBER");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_SYS_ID = $this->request->getVar("@user_end_parameter_SYS_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_MB_TITLE", "value"=>$_P_MB_TITLE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_MB_NAME", "value"=>$_P_MB_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_EMAIL", "value"=>$_P_MB_EMAIL, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_MB_PASSWD", "value"=>$_P_MB_PASSWD, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_MOBILE", "value"=>$_P_MB_MOBILE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_NUMBER", "value"=>$_P_MB_ID_NUMBER, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_PATH", "value"=>$_P_MB_ID_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_COMP_NAME", "value"=>$_P_MB_COMP_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_COMP_ADDRESS", "value"=>$_P_MB_COMP_ADDRESS, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_PHONE", "value"=>$_P_MB_PHONE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_TAX_REG_YN", "value"=>$_P_MB_TAX_REG_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MB_TAX_REG_NO", "value"=>$_P_MB_TAX_REG_NO, "type"=>SQLT_CHR, "length"=>30),
				array("name"=>":P_MB_TAX_REG_PATH", "value"=>$_P_MB_TAX_REG_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_BANK_NAME", "value"=>$_P_MB_BANK_NAME, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_BANK_ACCOUNT_NUMBER", "value"=>$_P_MB_BANK_ACCOUNT_NUMBER, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SYS_ID", "value"=>&$_P_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_MKTG","INSERT_MKTG_BROKER", $params);

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
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM MKTG_BROKER)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
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
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
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
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
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
			if(!($this->validate("Broker"))){
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
		  		
					$_OLD_MB_SYS_ID	=	$value["MB_SYS_ID"];
					$_OLD_MB_TITLE	=	$value["MB_TITLE"];
					$_OLD_MB_NAME	=	$value["MB_NAME"];
					$_OLD_MB_EMAIL	=	$value["MB_EMAIL"];
					$_OLD_MB_PASSWD	=	$value["MB_PASSWD"];
					$_OLD_MB_MOBILE	=	$value["MB_MOBILE"];
					$_OLD_MB_ID_NUMBER	=	$value["MB_ID_NUMBER"];
					$_OLD_MB_ID_PATH	=	$value["MB_ID_PATH"];
					$_OLD_MB_COMP_NAME	=	$value["MB_COMP_NAME"];
					$_OLD_MB_COMP_ADDRESS	=	$value["MB_COMP_ADDRESS"];
					$_OLD_MB_PHONE	=	$value["MB_PHONE"];
					$_OLD_MB_TAX_REG_YN	=	$value["MB_TAX_REG_YN"];
					$_OLD_MB_TAX_REG_NO	=	$value["MB_TAX_REG_NO"];
					$_OLD_MB_TAX_REG_EXP_DT	=	$value["MB_TAX_REG_EXP_DT"];
					$_OLD_MB_TAX_REG_PATH	=	$value["MB_TAX_REG_PATH"];
					$_OLD_MB_BANK_NAME	=	$value["MB_BANK_NAME"];
					$_OLD_MB_BANK_ACCOUNT_NUMBER	=	$value["MB_BANK_ACCOUNT_NUMBER"];
					$_OLD_MB_REGISTER_DT	=	$value["MB_REGISTER_DT"];
					$_OLD_MB_STAUS	=	$value["MB_STAUS"];
					$_OLD_MB_APPROVE_YN	=	$value["MB_APPROVE_YN"];
					$_OLD_MB_APPROVE_DT	=	$value["MB_APPROVE_DT"];
					$_OLD_MB_APPROVE_UID	=	$value["MB_APPROVE_UID"];
					$_OLD_MB_APPROVE_COMP_CODE	=	$value["MB_APPROVE_COMP_CODE"];
					$_OLD_MB_APPROVE_COA_CODE	=	$value["MB_APPROVE_COA_CODE"];
					$_OLD_MB_APPROVE_COMMISSION_PCT	=	$value["MB_APPROVE_COMMISSION_PCT"];
		  	}
		  }
		  

			$params = array(
			
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_MKTG","UPDATE_MKTG_BROKER", $params);

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

			

			$params = array(
			
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_MKTG","DELETE_MKTG_BROKER", $params);

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
use App\Models\Backend-BrokerModel;

class BrokerController extends ResourceController {
	
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


			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
				ORDER BY $order_by_column_name $sort_by 
				OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
			$query = $this->db->query($sql)->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			if(!($this->validate("Broker"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_MB_TITLE = $this->request->getVar("@user_end_parameter_MB_TITLE");
			$_P_MB_NAME = $this->request->getVar("@user_end_parameter_MB_NAME");
			$_P_MB_EMAIL = $this->request->getVar("@user_end_parameter_MB_EMAIL");
			$_P_MB_PASSWD = $this->request->getVar("@user_end_parameter_MB_PASSWD");
			$_P_MB_MOBILE = $this->request->getVar("@user_end_parameter_MB_MOBILE");
			$_P_MB_ID_NUMBER = $this->request->getVar("@user_end_parameter_MB_ID_NUMBER");
			$_P_MB_ID_PATH = $this->request->getVar("@user_end_parameter_MB_ID_PATH");
			$_P_MB_COMP_NAME = $this->request->getVar("@user_end_parameter_MB_COMNAME");
			$_P_MB_COMP_ADDRESS = $this->request->getVar("@user_end_parameter_MB_COMADDRESS");
			$_P_MB_PHONE = $this->request->getVar("@user_end_parameter_MB_PHONE");
			$_P_MB_TAX_REG_YN = $this->request->getVar("@user_end_parameter_MB_TAX_REG_YN");
			$_P_MB_TAX_REG_NO = $this->request->getVar("@user_end_parameter_MB_TAX_REG_NO");
			$_P_MB_TAX_REG_PATH = $this->request->getVar("@user_end_parameter_MB_TAX_REG_PATH");
			$_P_MB_BANK_NAME = $this->request->getVar("@user_end_parameter_MB_BANK_NAME");
			$_P_MB_BANK_ACCOUNT_NUMBER = $this->request->getVar("@user_end_parameter_MB_BANK_ACCOUNT_NUMBER");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_SYS_ID = $this->request->getVar("@user_end_parameter_SYS_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_MB_TITLE", "value"=>$_P_MB_TITLE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_MB_NAME", "value"=>$_P_MB_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_EMAIL", "value"=>$_P_MB_EMAIL, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_MB_PASSWD", "value"=>$_P_MB_PASSWD, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_MOBILE", "value"=>$_P_MB_MOBILE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_NUMBER", "value"=>$_P_MB_ID_NUMBER, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_PATH", "value"=>$_P_MB_ID_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_COMP_NAME", "value"=>$_P_MB_COMP_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_COMP_ADDRESS", "value"=>$_P_MB_COMP_ADDRESS, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_PHONE", "value"=>$_P_MB_PHONE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_TAX_REG_YN", "value"=>$_P_MB_TAX_REG_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MB_TAX_REG_NO", "value"=>$_P_MB_TAX_REG_NO, "type"=>SQLT_CHR, "length"=>30),
				array("name"=>":P_MB_TAX_REG_PATH", "value"=>$_P_MB_TAX_REG_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_BANK_NAME", "value"=>$_P_MB_BANK_NAME, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_BANK_ACCOUNT_NUMBER", "value"=>$_P_MB_BANK_ACCOUNT_NUMBER, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SYS_ID", "value"=>&$_P_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_MKTG","INSERT_MKTG_BROKER", $params);

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
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM MKTG_BROKER)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
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
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
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
						
						"@user_end_parameter_MB_SYS_ID"	=>	$value["MB_SYS_ID"],
						"@user_end_parameter_MB_TITLE"	=>	$value["MB_TITLE"],
						"@user_end_parameter_MB_NAME"	=>	$value["MB_NAME"],
						"@user_end_parameter_MB_EMAIL"	=>	$value["MB_EMAIL"],
						"@user_end_parameter_MB_PASSWD"	=>	$value["MB_PASSWD"],
						"@user_end_parameter_MB_MOBILE"	=>	$value["MB_MOBILE"],
						"@user_end_parameter_MB_ID_NUMBER"	=>	$value["MB_ID_NUMBER"],
						"@user_end_parameter_MB_ID_PATH"	=>	$value["MB_ID_PATH"],
						"@user_end_parameter_MB_COMP_NAME"	=>	$value["MB_COMP_NAME"],
						"@user_end_parameter_MB_COMP_ADDRESS"	=>	$value["MB_COMP_ADDRESS"],
						"@user_end_parameter_MB_PHONE"	=>	$value["MB_PHONE"],
						"@user_end_parameter_MB_TAX_REG_YN"	=>	$value["MB_TAX_REG_YN"],
						"@user_end_parameter_MB_TAX_REG_NO"	=>	$value["MB_TAX_REG_NO"],
						"@user_end_parameter_MB_TAX_REG_EXP_DT"	=>	$value["MB_TAX_REG_EXP_DT"],
						"@user_end_parameter_MB_TAX_REG_PATH"	=>	$value["MB_TAX_REG_PATH"],
						"@user_end_parameter_MB_BANK_NAME"	=>	$value["MB_BANK_NAME"],
						"@user_end_parameter_MB_BANK_ACCOUNT_NUMBER"	=>	$value["MB_BANK_ACCOUNT_NUMBER"],
						"@user_end_parameter_MB_REGISTER_DT"	=>	$value["MB_REGISTER_DT"],
						"@user_end_parameter_MB_STAUS"	=>	$value["MB_STAUS"],
						"@user_end_parameter_MB_APPROVE_YN"	=>	$value["MB_APPROVE_YN"],
						"@user_end_parameter_MB_APPROVE_DT"	=>	$value["MB_APPROVE_DT"],
						"@user_end_parameter_MB_APPROVE_UID"	=>	$value["MB_APPROVE_UID"],
						"@user_end_parameter_MB_APPROVE_COMP_CODE"	=>	$value["MB_APPROVE_COMP_CODE"],
						"@user_end_parameter_MB_APPROVE_COA_CODE"	=>	$value["MB_APPROVE_COA_CODE"],
						"@user_end_parameter_MB_APPROVE_COMMISSION_PCT"	=>	$value["MB_APPROVE_COMMISSION_PCT"],
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
			
			$sql = " SELECT MB_SYS_ID, MB_TITLE, MB_NAME, MB_EMAIL, MB_PASSWD, MB_MOBILE, MB_ID_NUMBER, MB_ID_PATH, MB_COMP_NAME, MB_COMP_ADDRESS, MB_PHONE, MB_TAX_REG_YN, MB_TAX_REG_NO, MB_TAX_REG_EXP_DT, MB_TAX_REG_PATH, MB_BANK_NAME, MB_BANK_ACCOUNT_NUMBER, MB_REGISTER_DT, MB_STAUS, MB_APPROVE_YN, MB_APPROVE_DT, MB_APPROVE_UID, MB_APPROVE_COMP_CODE, MB_APPROVE_COA_CODE, MB_APPROVE_COMMISSION_PCT FROM MKTG_BROKER  
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
			if(!($this->validate("Broker"))){
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
		  		
					$_OLD_MB_SYS_ID	=	$value["MB_SYS_ID"];
					$_OLD_MB_TITLE	=	$value["MB_TITLE"];
					$_OLD_MB_NAME	=	$value["MB_NAME"];
					$_OLD_MB_EMAIL	=	$value["MB_EMAIL"];
					$_OLD_MB_PASSWD	=	$value["MB_PASSWD"];
					$_OLD_MB_MOBILE	=	$value["MB_MOBILE"];
					$_OLD_MB_ID_NUMBER	=	$value["MB_ID_NUMBER"];
					$_OLD_MB_ID_PATH	=	$value["MB_ID_PATH"];
					$_OLD_MB_COMP_NAME	=	$value["MB_COMP_NAME"];
					$_OLD_MB_COMP_ADDRESS	=	$value["MB_COMP_ADDRESS"];
					$_OLD_MB_PHONE	=	$value["MB_PHONE"];
					$_OLD_MB_TAX_REG_YN	=	$value["MB_TAX_REG_YN"];
					$_OLD_MB_TAX_REG_NO	=	$value["MB_TAX_REG_NO"];
					$_OLD_MB_TAX_REG_EXP_DT	=	$value["MB_TAX_REG_EXP_DT"];
					$_OLD_MB_TAX_REG_PATH	=	$value["MB_TAX_REG_PATH"];
					$_OLD_MB_BANK_NAME	=	$value["MB_BANK_NAME"];
					$_OLD_MB_BANK_ACCOUNT_NUMBER	=	$value["MB_BANK_ACCOUNT_NUMBER"];
					$_OLD_MB_REGISTER_DT	=	$value["MB_REGISTER_DT"];
					$_OLD_MB_STAUS	=	$value["MB_STAUS"];
					$_OLD_MB_APPROVE_YN	=	$value["MB_APPROVE_YN"];
					$_OLD_MB_APPROVE_DT	=	$value["MB_APPROVE_DT"];
					$_OLD_MB_APPROVE_UID	=	$value["MB_APPROVE_UID"];
					$_OLD_MB_APPROVE_COMP_CODE	=	$value["MB_APPROVE_COMP_CODE"];
					$_OLD_MB_APPROVE_COA_CODE	=	$value["MB_APPROVE_COA_CODE"];
					$_OLD_MB_APPROVE_COMMISSION_PCT	=	$value["MB_APPROVE_COMMISSION_PCT"];
		  	}
		  }
		  

			$params = array(
			
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_MKTG","UPDATE_MKTG_BROKER", $params);

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

			

			$params = array(
			
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_MKTG","DELETE_MKTG_BROKER", $params);

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
