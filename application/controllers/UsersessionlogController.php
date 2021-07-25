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
use App\Models\Backend-UsersessionlogModel;

class UsersessionlogController extends ResourceController {
	
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


			$sql = " SELECT UL_SYS_ID, UL_ST_SYS_ID, UL_USER_ID, UL_LOGIN_TIME, UL_LOGOUT_TIME, UL_SID, UL_IP_ADDRESS, UL_TERMINAL, UL_HOST, UL_OS_USER, UL_CLIENT_PUBLIC_IP, UL_CLIENT_DEVICE_IP, UL_CLIENT_DEVICE_NAME, UL_CLIENT_BROWSER, UL_CLIENT_CITY, UL_CLIENT_REGION, UL_CLIENT_COUNTRY, UL_CLIENT_PHONE, UL_CLIENT_LONGITUDE, UL_CLIENT_LATITUDE, UL_STATUS, UL_REMARKS FROM SITE_USER_SESSION_LOGS  
				ORDER BY $order_by_column_name $sort_by 
				OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
			$query = $this->db->query($sql)->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_UL_SYS_ID"	=>	$value["UL_SYS_ID"],
						"@user_end_parameter_UL_ST_SYS_ID"	=>	$value["UL_ST_SYS_ID"],
						"@user_end_parameter_UL_USER_ID"	=>	$value["UL_USER_ID"],
						"@user_end_parameter_UL_LOGIN_TIME"	=>	$value["UL_LOGIN_TIME"],
						"@user_end_parameter_UL_LOGOUT_TIME"	=>	$value["UL_LOGOUT_TIME"],
						"@user_end_parameter_UL_SID"	=>	$value["UL_SID"],
						"@user_end_parameter_UL_IP_ADDRESS"	=>	$value["UL_IP_ADDRESS"],
						"@user_end_parameter_UL_TERMINAL"	=>	$value["UL_TERMINAL"],
						"@user_end_parameter_UL_HOST"	=>	$value["UL_HOST"],
						"@user_end_parameter_UL_OS_USER"	=>	$value["UL_OS_USER"],
						"@user_end_parameter_UL_CLIENT_PUBLIC_IP"	=>	$value["UL_CLIENT_PUBLIC_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_IP"	=>	$value["UL_CLIENT_DEVICE_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_NAME"	=>	$value["UL_CLIENT_DEVICE_NAME"],
						"@user_end_parameter_UL_CLIENT_BROWSER"	=>	$value["UL_CLIENT_BROWSER"],
						"@user_end_parameter_UL_CLIENT_CITY"	=>	$value["UL_CLIENT_CITY"],
						"@user_end_parameter_UL_CLIENT_REGION"	=>	$value["UL_CLIENT_REGION"],
						"@user_end_parameter_UL_CLIENT_COUNTRY"	=>	$value["UL_CLIENT_COUNTRY"],
						"@user_end_parameter_UL_CLIENT_PHONE"	=>	$value["UL_CLIENT_PHONE"],
						"@user_end_parameter_UL_CLIENT_LONGITUDE"	=>	$value["UL_CLIENT_LONGITUDE"],
						"@user_end_parameter_UL_CLIENT_LATITUDE"	=>	$value["UL_CLIENT_LATITUDE"],
						"@user_end_parameter_UL_STATUS"	=>	$value["UL_STATUS"],
						"@user_end_parameter_UL_REMARKS"	=>	$value["UL_REMARKS"],
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
			if(!($this->validate("Usersessionlog"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_ST_SYS_ID = $this->request->getVar("@user_end_parameter_ST_SYS_ID");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_SYS_ID = $this->request->getVar("@user_end_parameter_SYS_ID");
			$_P_CLIENT_PUBLIC_IP = $this->request->getVar("@user_end_parameter_CLIENT_PUBLIC_IP");
			$_P_CLIENT_DEVICE_IP = $this->request->getVar("@user_end_parameter_CLIENT_DEVICE_IP");
			$_P_CLIENT_DEVICE_NAME = $this->request->getVar("@user_end_parameter_CLIENT_DEVICE_NAME");
			$_P_CLIENT_BROWSER = $this->request->getVar("@user_end_parameter_CLIENT_BROWSER");
			$_P_CLIENT_CITY = $this->request->getVar("@user_end_parameter_CLIENT_CITY");
			$_P_CLIENT_REGION = $this->request->getVar("@user_end_parameter_CLIENT_REGION");
			$_P_CLIENT_COUNTRY = $this->request->getVar("@user_end_parameter_CLIENT_COUNTRY");
			$_P_CLIENT_PHONE = $this->request->getVar("@user_end_parameter_CLIENT_PHONE");
			$_P_CLIENT_LONGITUDE = $this->request->getVar("@user_end_parameter_CLIENT_LONGITUDE");
			$_P_CLIENT_LATITUDE = $this->request->getVar("@user_end_parameter_CLIENT_LATITUDE");
			$_P_STATUS = $this->request->getVar("@user_end_parameter_STATUS");
			$_P_REMARKS = $this->request->getVar("@user_end_parameter_REMARKS");

			$params = array(
			
				array("name"=>":P_ST_SYS_ID", "value"=>$_P_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SYS_ID", "value"=>&$_P_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CLIENT_PUBLIC_IP", "value"=>$_P_CLIENT_PUBLIC_IP, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_DEVICE_IP", "value"=>$_P_CLIENT_DEVICE_IP, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_DEVICE_NAME", "value"=>$_P_CLIENT_DEVICE_NAME, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_BROWSER", "value"=>$_P_CLIENT_BROWSER, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_CITY", "value"=>$_P_CLIENT_CITY, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_REGION", "value"=>$_P_CLIENT_REGION, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_COUNTRY", "value"=>$_P_CLIENT_COUNTRY, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_PHONE", "value"=>$_P_CLIENT_PHONE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_LONGITUDE", "value"=>$_P_CLIENT_LONGITUDE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_LATITUDE", "value"=>$_P_CLIENT_LATITUDE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_STATUS", "value"=>$_P_STATUS, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_REMARKS", "value"=>$_P_REMARKS, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","PROC_SITE_USER_SESSION_LOGS", $params);

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
			$sql = " SELECT UL_SYS_ID, UL_ST_SYS_ID, UL_USER_ID, UL_LOGIN_TIME, UL_LOGOUT_TIME, UL_SID, UL_IP_ADDRESS, UL_TERMINAL, UL_HOST, UL_OS_USER, UL_CLIENT_PUBLIC_IP, UL_CLIENT_DEVICE_IP, UL_CLIENT_DEVICE_NAME, UL_CLIENT_BROWSER, UL_CLIENT_CITY, UL_CLIENT_REGION, UL_CLIENT_COUNTRY, UL_CLIENT_PHONE, UL_CLIENT_LONGITUDE, UL_CLIENT_LATITUDE, UL_STATUS, UL_REMARKS FROM SITE_USER_SESSION_LOGS  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM SITE_USER_SESSION_LOGS)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_UL_SYS_ID"	=>	$value["UL_SYS_ID"],
						"@user_end_parameter_UL_ST_SYS_ID"	=>	$value["UL_ST_SYS_ID"],
						"@user_end_parameter_UL_USER_ID"	=>	$value["UL_USER_ID"],
						"@user_end_parameter_UL_LOGIN_TIME"	=>	$value["UL_LOGIN_TIME"],
						"@user_end_parameter_UL_LOGOUT_TIME"	=>	$value["UL_LOGOUT_TIME"],
						"@user_end_parameter_UL_SID"	=>	$value["UL_SID"],
						"@user_end_parameter_UL_IP_ADDRESS"	=>	$value["UL_IP_ADDRESS"],
						"@user_end_parameter_UL_TERMINAL"	=>	$value["UL_TERMINAL"],
						"@user_end_parameter_UL_HOST"	=>	$value["UL_HOST"],
						"@user_end_parameter_UL_OS_USER"	=>	$value["UL_OS_USER"],
						"@user_end_parameter_UL_CLIENT_PUBLIC_IP"	=>	$value["UL_CLIENT_PUBLIC_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_IP"	=>	$value["UL_CLIENT_DEVICE_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_NAME"	=>	$value["UL_CLIENT_DEVICE_NAME"],
						"@user_end_parameter_UL_CLIENT_BROWSER"	=>	$value["UL_CLIENT_BROWSER"],
						"@user_end_parameter_UL_CLIENT_CITY"	=>	$value["UL_CLIENT_CITY"],
						"@user_end_parameter_UL_CLIENT_REGION"	=>	$value["UL_CLIENT_REGION"],
						"@user_end_parameter_UL_CLIENT_COUNTRY"	=>	$value["UL_CLIENT_COUNTRY"],
						"@user_end_parameter_UL_CLIENT_PHONE"	=>	$value["UL_CLIENT_PHONE"],
						"@user_end_parameter_UL_CLIENT_LONGITUDE"	=>	$value["UL_CLIENT_LONGITUDE"],
						"@user_end_parameter_UL_CLIENT_LATITUDE"	=>	$value["UL_CLIENT_LATITUDE"],
						"@user_end_parameter_UL_STATUS"	=>	$value["UL_STATUS"],
						"@user_end_parameter_UL_REMARKS"	=>	$value["UL_REMARKS"],
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
			
			$sql = " SELECT UL_SYS_ID, UL_ST_SYS_ID, UL_USER_ID, UL_LOGIN_TIME, UL_LOGOUT_TIME, UL_SID, UL_IP_ADDRESS, UL_TERMINAL, UL_HOST, UL_OS_USER, UL_CLIENT_PUBLIC_IP, UL_CLIENT_DEVICE_IP, UL_CLIENT_DEVICE_NAME, UL_CLIENT_BROWSER, UL_CLIENT_CITY, UL_CLIENT_REGION, UL_CLIENT_COUNTRY, UL_CLIENT_PHONE, UL_CLIENT_LONGITUDE, UL_CLIENT_LATITUDE, UL_STATUS, UL_REMARKS FROM SITE_USER_SESSION_LOGS  
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
						
						"@user_end_parameter_UL_SYS_ID"	=>	$value["UL_SYS_ID"],
						"@user_end_parameter_UL_ST_SYS_ID"	=>	$value["UL_ST_SYS_ID"],
						"@user_end_parameter_UL_USER_ID"	=>	$value["UL_USER_ID"],
						"@user_end_parameter_UL_LOGIN_TIME"	=>	$value["UL_LOGIN_TIME"],
						"@user_end_parameter_UL_LOGOUT_TIME"	=>	$value["UL_LOGOUT_TIME"],
						"@user_end_parameter_UL_SID"	=>	$value["UL_SID"],
						"@user_end_parameter_UL_IP_ADDRESS"	=>	$value["UL_IP_ADDRESS"],
						"@user_end_parameter_UL_TERMINAL"	=>	$value["UL_TERMINAL"],
						"@user_end_parameter_UL_HOST"	=>	$value["UL_HOST"],
						"@user_end_parameter_UL_OS_USER"	=>	$value["UL_OS_USER"],
						"@user_end_parameter_UL_CLIENT_PUBLIC_IP"	=>	$value["UL_CLIENT_PUBLIC_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_IP"	=>	$value["UL_CLIENT_DEVICE_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_NAME"	=>	$value["UL_CLIENT_DEVICE_NAME"],
						"@user_end_parameter_UL_CLIENT_BROWSER"	=>	$value["UL_CLIENT_BROWSER"],
						"@user_end_parameter_UL_CLIENT_CITY"	=>	$value["UL_CLIENT_CITY"],
						"@user_end_parameter_UL_CLIENT_REGION"	=>	$value["UL_CLIENT_REGION"],
						"@user_end_parameter_UL_CLIENT_COUNTRY"	=>	$value["UL_CLIENT_COUNTRY"],
						"@user_end_parameter_UL_CLIENT_PHONE"	=>	$value["UL_CLIENT_PHONE"],
						"@user_end_parameter_UL_CLIENT_LONGITUDE"	=>	$value["UL_CLIENT_LONGITUDE"],
						"@user_end_parameter_UL_CLIENT_LATITUDE"	=>	$value["UL_CLIENT_LATITUDE"],
						"@user_end_parameter_UL_STATUS"	=>	$value["UL_STATUS"],
						"@user_end_parameter_UL_REMARKS"	=>	$value["UL_REMARKS"],
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
			
			$sql = " SELECT UL_SYS_ID, UL_ST_SYS_ID, UL_USER_ID, UL_LOGIN_TIME, UL_LOGOUT_TIME, UL_SID, UL_IP_ADDRESS, UL_TERMINAL, UL_HOST, UL_OS_USER, UL_CLIENT_PUBLIC_IP, UL_CLIENT_DEVICE_IP, UL_CLIENT_DEVICE_NAME, UL_CLIENT_BROWSER, UL_CLIENT_CITY, UL_CLIENT_REGION, UL_CLIENT_COUNTRY, UL_CLIENT_PHONE, UL_CLIENT_LONGITUDE, UL_CLIENT_LATITUDE, UL_STATUS, UL_REMARKS FROM SITE_USER_SESSION_LOGS  
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
						
						"@user_end_parameter_UL_SYS_ID"	=>	$value["UL_SYS_ID"],
						"@user_end_parameter_UL_ST_SYS_ID"	=>	$value["UL_ST_SYS_ID"],
						"@user_end_parameter_UL_USER_ID"	=>	$value["UL_USER_ID"],
						"@user_end_parameter_UL_LOGIN_TIME"	=>	$value["UL_LOGIN_TIME"],
						"@user_end_parameter_UL_LOGOUT_TIME"	=>	$value["UL_LOGOUT_TIME"],
						"@user_end_parameter_UL_SID"	=>	$value["UL_SID"],
						"@user_end_parameter_UL_IP_ADDRESS"	=>	$value["UL_IP_ADDRESS"],
						"@user_end_parameter_UL_TERMINAL"	=>	$value["UL_TERMINAL"],
						"@user_end_parameter_UL_HOST"	=>	$value["UL_HOST"],
						"@user_end_parameter_UL_OS_USER"	=>	$value["UL_OS_USER"],
						"@user_end_parameter_UL_CLIENT_PUBLIC_IP"	=>	$value["UL_CLIENT_PUBLIC_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_IP"	=>	$value["UL_CLIENT_DEVICE_IP"],
						"@user_end_parameter_UL_CLIENT_DEVICE_NAME"	=>	$value["UL_CLIENT_DEVICE_NAME"],
						"@user_end_parameter_UL_CLIENT_BROWSER"	=>	$value["UL_CLIENT_BROWSER"],
						"@user_end_parameter_UL_CLIENT_CITY"	=>	$value["UL_CLIENT_CITY"],
						"@user_end_parameter_UL_CLIENT_REGION"	=>	$value["UL_CLIENT_REGION"],
						"@user_end_parameter_UL_CLIENT_COUNTRY"	=>	$value["UL_CLIENT_COUNTRY"],
						"@user_end_parameter_UL_CLIENT_PHONE"	=>	$value["UL_CLIENT_PHONE"],
						"@user_end_parameter_UL_CLIENT_LONGITUDE"	=>	$value["UL_CLIENT_LONGITUDE"],
						"@user_end_parameter_UL_CLIENT_LATITUDE"	=>	$value["UL_CLIENT_LATITUDE"],
						"@user_end_parameter_UL_STATUS"	=>	$value["UL_STATUS"],
						"@user_end_parameter_UL_REMARKS"	=>	$value["UL_REMARKS"],
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
			
			$sql = " SELECT UL_SYS_ID, UL_ST_SYS_ID, UL_USER_ID, UL_LOGIN_TIME, UL_LOGOUT_TIME, UL_SID, UL_IP_ADDRESS, UL_TERMINAL, UL_HOST, UL_OS_USER, UL_CLIENT_PUBLIC_IP, UL_CLIENT_DEVICE_IP, UL_CLIENT_DEVICE_NAME, UL_CLIENT_BROWSER, UL_CLIENT_CITY, UL_CLIENT_REGION, UL_CLIENT_COUNTRY, UL_CLIENT_PHONE, UL_CLIENT_LONGITUDE, UL_CLIENT_LATITUDE, UL_STATUS, UL_REMARKS FROM SITE_USER_SESSION_LOGS  
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
			if(!($this->validate("Usersessionlog"))){
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
		  		
					$_OLD_UL_SYS_ID	=	$value["UL_SYS_ID"];
					$_OLD_UL_ST_SYS_ID	=	$value["UL_ST_SYS_ID"];
					$_OLD_UL_USER_ID	=	$value["UL_USER_ID"];
					$_OLD_UL_LOGIN_TIME	=	$value["UL_LOGIN_TIME"];
					$_OLD_UL_LOGOUT_TIME	=	$value["UL_LOGOUT_TIME"];
					$_OLD_UL_SID	=	$value["UL_SID"];
					$_OLD_UL_IP_ADDRESS	=	$value["UL_IP_ADDRESS"];
					$_OLD_UL_TERMINAL	=	$value["UL_TERMINAL"];
					$_OLD_UL_HOST	=	$value["UL_HOST"];
					$_OLD_UL_OS_USER	=	$value["UL_OS_USER"];
					$_OLD_UL_CLIENT_PUBLIC_IP	=	$value["UL_CLIENT_PUBLIC_IP"];
					$_OLD_UL_CLIENT_DEVICE_IP	=	$value["UL_CLIENT_DEVICE_IP"];
					$_OLD_UL_CLIENT_DEVICE_NAME	=	$value["UL_CLIENT_DEVICE_NAME"];
					$_OLD_UL_CLIENT_BROWSER	=	$value["UL_CLIENT_BROWSER"];
					$_OLD_UL_CLIENT_CITY	=	$value["UL_CLIENT_CITY"];
					$_OLD_UL_CLIENT_REGION	=	$value["UL_CLIENT_REGION"];
					$_OLD_UL_CLIENT_COUNTRY	=	$value["UL_CLIENT_COUNTRY"];
					$_OLD_UL_CLIENT_PHONE	=	$value["UL_CLIENT_PHONE"];
					$_OLD_UL_CLIENT_LONGITUDE	=	$value["UL_CLIENT_LONGITUDE"];
					$_OLD_UL_CLIENT_LATITUDE	=	$value["UL_CLIENT_LATITUDE"];
					$_OLD_UL_STATUS	=	$value["UL_STATUS"];
					$_OLD_UL_REMARKS	=	$value["UL_REMARKS"];
		  	}
		  }
		  
			$_P_ST_SYS_ID = $this->request->getVar("@user_end_parameter_ST_SYS_ID");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_SYS_ID = $this->request->getVar("@user_end_parameter_SYS_ID");
			$_P_CLIENT_PUBLIC_IP = $this->request->getVar("@user_end_parameter_CLIENT_PUBLIC_IP");
			$_P_CLIENT_DEVICE_IP = $this->request->getVar("@user_end_parameter_CLIENT_DEVICE_IP");
			$_P_CLIENT_DEVICE_NAME = $this->request->getVar("@user_end_parameter_CLIENT_DEVICE_NAME");
			$_P_CLIENT_BROWSER = $this->request->getVar("@user_end_parameter_CLIENT_BROWSER");
			$_P_CLIENT_CITY = $this->request->getVar("@user_end_parameter_CLIENT_CITY");
			$_P_CLIENT_REGION = $this->request->getVar("@user_end_parameter_CLIENT_REGION");
			$_P_CLIENT_COUNTRY = $this->request->getVar("@user_end_parameter_CLIENT_COUNTRY");
			$_P_CLIENT_PHONE = $this->request->getVar("@user_end_parameter_CLIENT_PHONE");
			$_P_CLIENT_LONGITUDE = $this->request->getVar("@user_end_parameter_CLIENT_LONGITUDE");
			$_P_CLIENT_LATITUDE = $this->request->getVar("@user_end_parameter_CLIENT_LATITUDE");
			$_P_STATUS = $this->request->getVar("@user_end_parameter_STATUS");
			$_P_REMARKS = $this->request->getVar("@user_end_parameter_REMARKS");

			$params = array(
			
				array("name"=>":P_ST_SYS_ID", "value"=>$_P_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_SYS_ID", "value"=>&$_P_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CLIENT_PUBLIC_IP", "value"=>$_P_CLIENT_PUBLIC_IP, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_DEVICE_IP", "value"=>$_P_CLIENT_DEVICE_IP, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_DEVICE_NAME", "value"=>$_P_CLIENT_DEVICE_NAME, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_BROWSER", "value"=>$_P_CLIENT_BROWSER, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_CITY", "value"=>$_P_CLIENT_CITY, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_REGION", "value"=>$_P_CLIENT_REGION, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_COUNTRY", "value"=>$_P_CLIENT_COUNTRY, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_PHONE", "value"=>$_P_CLIENT_PHONE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_LONGITUDE", "value"=>$_P_CLIENT_LONGITUDE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_CLIENT_LATITUDE", "value"=>$_P_CLIENT_LATITUDE, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_STATUS", "value"=>$_P_STATUS, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_REMARKS", "value"=>$_P_REMARKS, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","PROC_SITE_USER_SESSION_LOGS", $params);

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
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","DELETE_SITE_USER_SESSION_LOGS", $params);

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
