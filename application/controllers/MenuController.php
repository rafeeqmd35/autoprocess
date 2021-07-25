<?php
//Steps to do 
// check the namespace is proper or not
// And add the parameter for validation and passing inputs
// for show and edit plz check the PRIMARY_KEY columns
// apart from this whatever u want u can do
//$_CR_DT_COLUMN_NAME - need to define created date column name
//$_PRIMARY_COLUMN_NAME -  need to add primary column name
// passing_parameter -  need to pass proper value here
namespace App\Controllers\Backend\Application;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Backend\Application\MenuModel;

class MenuController extends ResourceController {
	
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


			$sql = " SELECT MENU_ST_SYS_ID, MENU_MODULE, MENU_CODE, MENU_DESC, MENU_PARENT_CODE, MENU_TYPE, MENU_DISP_SEQ, MENU_DEFINITION, MENU_MULTI_INST_YN, MENU_TXN_CODE, MENU_PARA_01, MENU_PARA_02, MENU_PARA_03, MENU_PARA_04, MENU_PARA_05, MENU_PARA_06, MENU_PARA_07, MENU_PARA_08, MENU_PARA_09, MENU_PARA_10, MENU_PARA_11, MENU_PARA_12, MENU_PARA_13, MENU_PARA_14, MENU_PARA_15, MENU_PARA_16, MENU_PARA_17, MENU_PARA_18, MENU_PARA_19, MENU_PARA_20, MENU_LANG_CODE, MENU_ACTIVE_YN, MENU_FROM_DT, MENU_UPTO_DT, MENU_CR_UID, MENU_CR_DT, MENU_UPD_UID, MENU_UPD_DT FROM SITE_M_MENU  
				ORDER BY $order_by_column_name $sort_by 
				OFFSET $startRecord ROWS FETCH NEXT $data_limit ROWS ONLY ";
			$query = $this->db->query($sql)->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_MENU_ST_SYS_ID"	=>	$value["MENU_ST_SYS_ID"],
						"@user_end_parameter_MENU_MODULE"	=>	$value["MENU_MODULE"],
						"@user_end_parameter_MENU_CODE"	=>	$value["MENU_CODE"],
						"@user_end_parameter_MENU_DESC"	=>	$value["MENU_DESC"],
						"@user_end_parameter_MENU_PARENT_CODE"	=>	$value["MENU_PARENT_CODE"],
						"@user_end_parameter_MENU_TYPE"	=>	$value["MENU_TYPE"],
						"@user_end_parameter_MENU_DISP_SEQ"	=>	$value["MENU_DISP_SEQ"],
						"@user_end_parameter_MENU_DEFINITION"	=>	$value["MENU_DEFINITION"],
						"@user_end_parameter_MENU_MULTI_INST_YN"	=>	$value["MENU_MULTI_INST_YN"],
						"@user_end_parameter_MENU_TXN_CODE"	=>	$value["MENU_TXN_CODE"],
						"@user_end_parameter_MENU_PARA_01"	=>	$value["MENU_PARA_01"],
						"@user_end_parameter_MENU_PARA_02"	=>	$value["MENU_PARA_02"],
						"@user_end_parameter_MENU_PARA_03"	=>	$value["MENU_PARA_03"],
						"@user_end_parameter_MENU_PARA_04"	=>	$value["MENU_PARA_04"],
						"@user_end_parameter_MENU_PARA_05"	=>	$value["MENU_PARA_05"],
						"@user_end_parameter_MENU_PARA_06"	=>	$value["MENU_PARA_06"],
						"@user_end_parameter_MENU_PARA_07"	=>	$value["MENU_PARA_07"],
						"@user_end_parameter_MENU_PARA_08"	=>	$value["MENU_PARA_08"],
						"@user_end_parameter_MENU_PARA_09"	=>	$value["MENU_PARA_09"],
						"@user_end_parameter_MENU_PARA_10"	=>	$value["MENU_PARA_10"],
						"@user_end_parameter_MENU_PARA_11"	=>	$value["MENU_PARA_11"],
						"@user_end_parameter_MENU_PARA_12"	=>	$value["MENU_PARA_12"],
						"@user_end_parameter_MENU_PARA_13"	=>	$value["MENU_PARA_13"],
						"@user_end_parameter_MENU_PARA_14"	=>	$value["MENU_PARA_14"],
						"@user_end_parameter_MENU_PARA_15"	=>	$value["MENU_PARA_15"],
						"@user_end_parameter_MENU_PARA_16"	=>	$value["MENU_PARA_16"],
						"@user_end_parameter_MENU_PARA_17"	=>	$value["MENU_PARA_17"],
						"@user_end_parameter_MENU_PARA_18"	=>	$value["MENU_PARA_18"],
						"@user_end_parameter_MENU_PARA_19"	=>	$value["MENU_PARA_19"],
						"@user_end_parameter_MENU_PARA_20"	=>	$value["MENU_PARA_20"],
						"@user_end_parameter_MENU_LANG_CODE"	=>	$value["MENU_LANG_CODE"],
						"@user_end_parameter_MENU_ACTIVE_YN"	=>	$value["MENU_ACTIVE_YN"],
						"@user_end_parameter_MENU_FROM_DT"	=>	$value["MENU_FROM_DT"],
						"@user_end_parameter_MENU_UPTO_DT"	=>	$value["MENU_UPTO_DT"],
						"@user_end_parameter_MENU_CR_UID"	=>	$value["MENU_CR_UID"],
						"@user_end_parameter_MENU_CR_DT"	=>	$value["MENU_CR_DT"],
						"@user_end_parameter_MENU_UPD_UID"	=>	$value["MENU_UPD_UID"],
						"@user_end_parameter_MENU_UPD_DT"	=>	$value["MENU_UPD_DT"],
					];
					$data_to_send[] = $name_array;
				}

			}

			$data = [
				"results" => $data_to_send
			];
			return $this->respond($data);
		}catch(Exception $e){
			echo $e;
		}
	}

	public function create(){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			if(!($this->validate("Menu"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			
			$_P_MENU_ST_SYS_ID = $this->request->getVar("@user_end_parameter_MENU_ST_SYS_ID");
			$_P_MENU_MODULE = $this->request->getVar("@user_end_parameter_MENU_MODULE");
			$_P_MENU_CODE = $this->request->getVar("@user_end_parameter_MENU_CODE");
			$_P_MENU_DESC = $this->request->getVar("@user_end_parameter_MENU_DESC");
			$_P_MENU_PARENT_CODE = $this->request->getVar("@user_end_parameter_MENU_PARENT_CODE");
			$_P_MENU_TYPE = $this->request->getVar("@user_end_parameter_MENU_TYPE");
			$_P_MENU_DISP_SEQ = $this->request->getVar("@user_end_parameter_MENU_DISSEQ");
			$_P_MENU_DEFINITION = $this->request->getVar("@user_end_parameter_MENU_DEFINITION");
			$_P_MENU_MULTI_INST_YN = $this->request->getVar("@user_end_parameter_MENU_MULTI_INST_YN");
			$_P_MENU_TXN_CODE = $this->request->getVar("@user_end_parameter_MENU_TXN_CODE");
			$_P_MENU_PARA_01 = $this->request->getVar("@user_end_parameter_MENU_PARA_01");
			$_P_MENU_PARA_02 = $this->request->getVar("@user_end_parameter_MENU_PARA_02");
			$_P_MENU_PARA_03 = $this->request->getVar("@user_end_parameter_MENU_PARA_03");
			$_P_MENU_PARA_04 = $this->request->getVar("@user_end_parameter_MENU_PARA_04");
			$_P_MENU_PARA_05 = $this->request->getVar("@user_end_parameter_MENU_PARA_05");
			$_P_MENU_PARA_06 = $this->request->getVar("@user_end_parameter_MENU_PARA_06");
			$_P_MENU_PARA_07 = $this->request->getVar("@user_end_parameter_MENU_PARA_07");
			$_P_MENU_PARA_08 = $this->request->getVar("@user_end_parameter_MENU_PARA_08");
			$_P_MENU_PARA_09 = $this->request->getVar("@user_end_parameter_MENU_PARA_09");
			$_P_MENU_PARA_10 = $this->request->getVar("@user_end_parameter_MENU_PARA_10");
			$_P_MENU_PARA_11 = $this->request->getVar("@user_end_parameter_MENU_PARA_11");
			$_P_MENU_PARA_12 = $this->request->getVar("@user_end_parameter_MENU_PARA_12");
			$_P_MENU_PARA_13 = $this->request->getVar("@user_end_parameter_MENU_PARA_13");
			$_P_MENU_PARA_14 = $this->request->getVar("@user_end_parameter_MENU_PARA_14");
			$_P_MENU_PARA_15 = $this->request->getVar("@user_end_parameter_MENU_PARA_15");
			$_P_MENU_PARA_16 = $this->request->getVar("@user_end_parameter_MENU_PARA_16");
			$_P_MENU_PARA_17 = $this->request->getVar("@user_end_parameter_MENU_PARA_17");
			$_P_MENU_PARA_18 = $this->request->getVar("@user_end_parameter_MENU_PARA_18");
			$_P_MENU_PARA_19 = $this->request->getVar("@user_end_parameter_MENU_PARA_19");
			$_P_MENU_PARA_20 = $this->request->getVar("@user_end_parameter_MENU_PARA_20");
			$_P_MENU_ACTIVE_YN = $this->request->getVar("@user_end_parameter_MENU_ACTIVE_YN");
			$_P_MENU_FROM_DT = $this->request->getVar("@user_end_parameter_MENU_FROM_DT");
			$_P_MENU_UPTO_DT = $this->request->getVar("@user_end_parameter_MENU_UPTO_DT");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_MENU_ST_SYS_ID", "value"=>$_P_MENU_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MENU_MODULE", "value"=>$_P_MENU_MODULE, "type"=>SQLT_CHR, "length"=>15),
				array("name"=>":P_MENU_CODE", "value"=>$_P_MENU_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MENU_DESC", "value"=>$_P_MENU_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARENT_CODE", "value"=>$_P_MENU_PARENT_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MENU_TYPE", "value"=>$_P_MENU_TYPE, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MENU_DISP_SEQ", "value"=>$_P_MENU_DISP_SEQ, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MENU_DEFINITION", "value"=>$_P_MENU_DEFINITION, "type"=>SQLT_CHR, "length"=>500),
				array("name"=>":P_MENU_MULTI_INST_YN", "value"=>$_P_MENU_MULTI_INST_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MENU_TXN_CODE", "value"=>$_P_MENU_TXN_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MENU_PARA_01", "value"=>$_P_MENU_PARA_01, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_02", "value"=>$_P_MENU_PARA_02, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_03", "value"=>$_P_MENU_PARA_03, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_04", "value"=>$_P_MENU_PARA_04, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_05", "value"=>$_P_MENU_PARA_05, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_06", "value"=>$_P_MENU_PARA_06, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_07", "value"=>$_P_MENU_PARA_07, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_08", "value"=>$_P_MENU_PARA_08, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_09", "value"=>$_P_MENU_PARA_09, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_10", "value"=>$_P_MENU_PARA_10, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_11", "value"=>$_P_MENU_PARA_11, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_12", "value"=>$_P_MENU_PARA_12, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_13", "value"=>$_P_MENU_PARA_13, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_14", "value"=>$_P_MENU_PARA_14, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_15", "value"=>$_P_MENU_PARA_15, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_16", "value"=>$_P_MENU_PARA_16, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_17", "value"=>$_P_MENU_PARA_17, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_18", "value"=>$_P_MENU_PARA_18, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_19", "value"=>$_P_MENU_PARA_19, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_20", "value"=>$_P_MENU_PARA_20, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_ACTIVE_YN", "value"=>$_P_MENU_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MENU_FROM_DT", "value"=>$_P_MENU_FROM_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_MENU_UPTO_DT", "value"=>$_P_MENU_UPTO_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","INSERT_SITE_M_MENU", $params);

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
			$sql = " SELECT MENU_ST_SYS_ID, MENU_MODULE, MENU_CODE, MENU_DESC, MENU_PARENT_CODE, MENU_TYPE, MENU_DISP_SEQ, MENU_DEFINITION, MENU_MULTI_INST_YN, MENU_TXN_CODE, MENU_PARA_01, MENU_PARA_02, MENU_PARA_03, MENU_PARA_04, MENU_PARA_05, MENU_PARA_06, MENU_PARA_07, MENU_PARA_08, MENU_PARA_09, MENU_PARA_10, MENU_PARA_11, MENU_PARA_12, MENU_PARA_13, MENU_PARA_14, MENU_PARA_15, MENU_PARA_16, MENU_PARA_17, MENU_PARA_18, MENU_PARA_19, MENU_PARA_20, MENU_LANG_CODE, MENU_ACTIVE_YN, MENU_FROM_DT, MENU_UPTO_DT, MENU_CR_UID, MENU_CR_DT, MENU_UPD_UID, MENU_UPD_DT FROM SITE_M_MENU  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM SITE_M_MENU)";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						
						"@user_end_parameter_MENU_ST_SYS_ID"	=>	$value["MENU_ST_SYS_ID"],
						"@user_end_parameter_MENU_MODULE"	=>	$value["MENU_MODULE"],
						"@user_end_parameter_MENU_CODE"	=>	$value["MENU_CODE"],
						"@user_end_parameter_MENU_DESC"	=>	$value["MENU_DESC"],
						"@user_end_parameter_MENU_PARENT_CODE"	=>	$value["MENU_PARENT_CODE"],
						"@user_end_parameter_MENU_TYPE"	=>	$value["MENU_TYPE"],
						"@user_end_parameter_MENU_DISP_SEQ"	=>	$value["MENU_DISP_SEQ"],
						"@user_end_parameter_MENU_DEFINITION"	=>	$value["MENU_DEFINITION"],
						"@user_end_parameter_MENU_MULTI_INST_YN"	=>	$value["MENU_MULTI_INST_YN"],
						"@user_end_parameter_MENU_TXN_CODE"	=>	$value["MENU_TXN_CODE"],
						"@user_end_parameter_MENU_PARA_01"	=>	$value["MENU_PARA_01"],
						"@user_end_parameter_MENU_PARA_02"	=>	$value["MENU_PARA_02"],
						"@user_end_parameter_MENU_PARA_03"	=>	$value["MENU_PARA_03"],
						"@user_end_parameter_MENU_PARA_04"	=>	$value["MENU_PARA_04"],
						"@user_end_parameter_MENU_PARA_05"	=>	$value["MENU_PARA_05"],
						"@user_end_parameter_MENU_PARA_06"	=>	$value["MENU_PARA_06"],
						"@user_end_parameter_MENU_PARA_07"	=>	$value["MENU_PARA_07"],
						"@user_end_parameter_MENU_PARA_08"	=>	$value["MENU_PARA_08"],
						"@user_end_parameter_MENU_PARA_09"	=>	$value["MENU_PARA_09"],
						"@user_end_parameter_MENU_PARA_10"	=>	$value["MENU_PARA_10"],
						"@user_end_parameter_MENU_PARA_11"	=>	$value["MENU_PARA_11"],
						"@user_end_parameter_MENU_PARA_12"	=>	$value["MENU_PARA_12"],
						"@user_end_parameter_MENU_PARA_13"	=>	$value["MENU_PARA_13"],
						"@user_end_parameter_MENU_PARA_14"	=>	$value["MENU_PARA_14"],
						"@user_end_parameter_MENU_PARA_15"	=>	$value["MENU_PARA_15"],
						"@user_end_parameter_MENU_PARA_16"	=>	$value["MENU_PARA_16"],
						"@user_end_parameter_MENU_PARA_17"	=>	$value["MENU_PARA_17"],
						"@user_end_parameter_MENU_PARA_18"	=>	$value["MENU_PARA_18"],
						"@user_end_parameter_MENU_PARA_19"	=>	$value["MENU_PARA_19"],
						"@user_end_parameter_MENU_PARA_20"	=>	$value["MENU_PARA_20"],
						"@user_end_parameter_MENU_LANG_CODE"	=>	$value["MENU_LANG_CODE"],
						"@user_end_parameter_MENU_ACTIVE_YN"	=>	$value["MENU_ACTIVE_YN"],
						"@user_end_parameter_MENU_FROM_DT"	=>	$value["MENU_FROM_DT"],
						"@user_end_parameter_MENU_UPTO_DT"	=>	$value["MENU_UPTO_DT"],
						"@user_end_parameter_MENU_CR_UID"	=>	$value["MENU_CR_UID"],
						"@user_end_parameter_MENU_CR_DT"	=>	$value["MENU_CR_DT"],
						"@user_end_parameter_MENU_UPD_UID"	=>	$value["MENU_UPD_UID"],
						"@user_end_parameter_MENU_UPD_DT"	=>	$value["MENU_UPD_DT"],
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
			$_PRIMARY_COLUMN_NAME = "column@";
			$sql = " SELECT MENU_ST_SYS_ID, MENU_MODULE, MENU_CODE, MENU_DESC, MENU_PARENT_CODE, MENU_TYPE, MENU_DISP_SEQ, MENU_DEFINITION, MENU_MULTI_INST_YN, MENU_TXN_CODE, MENU_PARA_01, MENU_PARA_02, MENU_PARA_03, MENU_PARA_04, MENU_PARA_05, MENU_PARA_06, MENU_PARA_07, MENU_PARA_08, MENU_PARA_09, MENU_PARA_10, MENU_PARA_11, MENU_PARA_12, MENU_PARA_13, MENU_PARA_14, MENU_PARA_15, MENU_PARA_16, MENU_PARA_17, MENU_PARA_18, MENU_PARA_19, MENU_PARA_20, MENU_LANG_CODE, MENU_ACTIVE_YN, MENU_FROM_DT, MENU_UPTO_DT, MENU_CR_UID, MENU_CR_DT, MENU_UPD_UID, MENU_UPD_DT FROM SITE_M_MENU  
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
						
						"@user_end_parameter_MENU_ST_SYS_ID"	=>	$value["MENU_ST_SYS_ID"],
						"@user_end_parameter_MENU_MODULE"	=>	$value["MENU_MODULE"],
						"@user_end_parameter_MENU_CODE"	=>	$value["MENU_CODE"],
						"@user_end_parameter_MENU_DESC"	=>	$value["MENU_DESC"],
						"@user_end_parameter_MENU_PARENT_CODE"	=>	$value["MENU_PARENT_CODE"],
						"@user_end_parameter_MENU_TYPE"	=>	$value["MENU_TYPE"],
						"@user_end_parameter_MENU_DISP_SEQ"	=>	$value["MENU_DISP_SEQ"],
						"@user_end_parameter_MENU_DEFINITION"	=>	$value["MENU_DEFINITION"],
						"@user_end_parameter_MENU_MULTI_INST_YN"	=>	$value["MENU_MULTI_INST_YN"],
						"@user_end_parameter_MENU_TXN_CODE"	=>	$value["MENU_TXN_CODE"],
						"@user_end_parameter_MENU_PARA_01"	=>	$value["MENU_PARA_01"],
						"@user_end_parameter_MENU_PARA_02"	=>	$value["MENU_PARA_02"],
						"@user_end_parameter_MENU_PARA_03"	=>	$value["MENU_PARA_03"],
						"@user_end_parameter_MENU_PARA_04"	=>	$value["MENU_PARA_04"],
						"@user_end_parameter_MENU_PARA_05"	=>	$value["MENU_PARA_05"],
						"@user_end_parameter_MENU_PARA_06"	=>	$value["MENU_PARA_06"],
						"@user_end_parameter_MENU_PARA_07"	=>	$value["MENU_PARA_07"],
						"@user_end_parameter_MENU_PARA_08"	=>	$value["MENU_PARA_08"],
						"@user_end_parameter_MENU_PARA_09"	=>	$value["MENU_PARA_09"],
						"@user_end_parameter_MENU_PARA_10"	=>	$value["MENU_PARA_10"],
						"@user_end_parameter_MENU_PARA_11"	=>	$value["MENU_PARA_11"],
						"@user_end_parameter_MENU_PARA_12"	=>	$value["MENU_PARA_12"],
						"@user_end_parameter_MENU_PARA_13"	=>	$value["MENU_PARA_13"],
						"@user_end_parameter_MENU_PARA_14"	=>	$value["MENU_PARA_14"],
						"@user_end_parameter_MENU_PARA_15"	=>	$value["MENU_PARA_15"],
						"@user_end_parameter_MENU_PARA_16"	=>	$value["MENU_PARA_16"],
						"@user_end_parameter_MENU_PARA_17"	=>	$value["MENU_PARA_17"],
						"@user_end_parameter_MENU_PARA_18"	=>	$value["MENU_PARA_18"],
						"@user_end_parameter_MENU_PARA_19"	=>	$value["MENU_PARA_19"],
						"@user_end_parameter_MENU_PARA_20"	=>	$value["MENU_PARA_20"],
						"@user_end_parameter_MENU_LANG_CODE"	=>	$value["MENU_LANG_CODE"],
						"@user_end_parameter_MENU_ACTIVE_YN"	=>	$value["MENU_ACTIVE_YN"],
						"@user_end_parameter_MENU_FROM_DT"	=>	$value["MENU_FROM_DT"],
						"@user_end_parameter_MENU_UPTO_DT"	=>	$value["MENU_UPTO_DT"],
						"@user_end_parameter_MENU_CR_UID"	=>	$value["MENU_CR_UID"],
						"@user_end_parameter_MENU_CR_DT"	=>	$value["MENU_CR_DT"],
						"@user_end_parameter_MENU_UPD_UID"	=>	$value["MENU_UPD_UID"],
						"@user_end_parameter_MENU_UPD_DT"	=>	$value["MENU_UPD_DT"],
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
			$_PRIMARY_COLUMN_NAME = "column@";
			$sql = " SELECT MENU_ST_SYS_ID, MENU_MODULE, MENU_CODE, MENU_DESC, MENU_PARENT_CODE, MENU_TYPE, MENU_DISP_SEQ, MENU_DEFINITION, MENU_MULTI_INST_YN, MENU_TXN_CODE, MENU_PARA_01, MENU_PARA_02, MENU_PARA_03, MENU_PARA_04, MENU_PARA_05, MENU_PARA_06, MENU_PARA_07, MENU_PARA_08, MENU_PARA_09, MENU_PARA_10, MENU_PARA_11, MENU_PARA_12, MENU_PARA_13, MENU_PARA_14, MENU_PARA_15, MENU_PARA_16, MENU_PARA_17, MENU_PARA_18, MENU_PARA_19, MENU_PARA_20, MENU_LANG_CODE, MENU_ACTIVE_YN, MENU_FROM_DT, MENU_UPTO_DT, MENU_CR_UID, MENU_CR_DT, MENU_UPD_UID, MENU_UPD_DT FROM SITE_M_MENU  
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
						
						"@user_end_parameter_MENU_ST_SYS_ID"	=>	$value["MENU_ST_SYS_ID"],
						"@user_end_parameter_MENU_MODULE"	=>	$value["MENU_MODULE"],
						"@user_end_parameter_MENU_CODE"	=>	$value["MENU_CODE"],
						"@user_end_parameter_MENU_DESC"	=>	$value["MENU_DESC"],
						"@user_end_parameter_MENU_PARENT_CODE"	=>	$value["MENU_PARENT_CODE"],
						"@user_end_parameter_MENU_TYPE"	=>	$value["MENU_TYPE"],
						"@user_end_parameter_MENU_DISP_SEQ"	=>	$value["MENU_DISP_SEQ"],
						"@user_end_parameter_MENU_DEFINITION"	=>	$value["MENU_DEFINITION"],
						"@user_end_parameter_MENU_MULTI_INST_YN"	=>	$value["MENU_MULTI_INST_YN"],
						"@user_end_parameter_MENU_TXN_CODE"	=>	$value["MENU_TXN_CODE"],
						"@user_end_parameter_MENU_PARA_01"	=>	$value["MENU_PARA_01"],
						"@user_end_parameter_MENU_PARA_02"	=>	$value["MENU_PARA_02"],
						"@user_end_parameter_MENU_PARA_03"	=>	$value["MENU_PARA_03"],
						"@user_end_parameter_MENU_PARA_04"	=>	$value["MENU_PARA_04"],
						"@user_end_parameter_MENU_PARA_05"	=>	$value["MENU_PARA_05"],
						"@user_end_parameter_MENU_PARA_06"	=>	$value["MENU_PARA_06"],
						"@user_end_parameter_MENU_PARA_07"	=>	$value["MENU_PARA_07"],
						"@user_end_parameter_MENU_PARA_08"	=>	$value["MENU_PARA_08"],
						"@user_end_parameter_MENU_PARA_09"	=>	$value["MENU_PARA_09"],
						"@user_end_parameter_MENU_PARA_10"	=>	$value["MENU_PARA_10"],
						"@user_end_parameter_MENU_PARA_11"	=>	$value["MENU_PARA_11"],
						"@user_end_parameter_MENU_PARA_12"	=>	$value["MENU_PARA_12"],
						"@user_end_parameter_MENU_PARA_13"	=>	$value["MENU_PARA_13"],
						"@user_end_parameter_MENU_PARA_14"	=>	$value["MENU_PARA_14"],
						"@user_end_parameter_MENU_PARA_15"	=>	$value["MENU_PARA_15"],
						"@user_end_parameter_MENU_PARA_16"	=>	$value["MENU_PARA_16"],
						"@user_end_parameter_MENU_PARA_17"	=>	$value["MENU_PARA_17"],
						"@user_end_parameter_MENU_PARA_18"	=>	$value["MENU_PARA_18"],
						"@user_end_parameter_MENU_PARA_19"	=>	$value["MENU_PARA_19"],
						"@user_end_parameter_MENU_PARA_20"	=>	$value["MENU_PARA_20"],
						"@user_end_parameter_MENU_LANG_CODE"	=>	$value["MENU_LANG_CODE"],
						"@user_end_parameter_MENU_ACTIVE_YN"	=>	$value["MENU_ACTIVE_YN"],
						"@user_end_parameter_MENU_FROM_DT"	=>	$value["MENU_FROM_DT"],
						"@user_end_parameter_MENU_UPTO_DT"	=>	$value["MENU_UPTO_DT"],
						"@user_end_parameter_MENU_CR_UID"	=>	$value["MENU_CR_UID"],
						"@user_end_parameter_MENU_CR_DT"	=>	$value["MENU_CR_DT"],
						"@user_end_parameter_MENU_UPD_UID"	=>	$value["MENU_UPD_UID"],
						"@user_end_parameter_MENU_UPD_DT"	=>	$value["MENU_UPD_DT"],
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
			$sql = " SELECT MENU_ST_SYS_ID, MENU_MODULE, MENU_CODE, MENU_DESC, MENU_PARENT_CODE, MENU_TYPE, MENU_DISP_SEQ, MENU_DEFINITION, MENU_MULTI_INST_YN, MENU_TXN_CODE, MENU_PARA_01, MENU_PARA_02, MENU_PARA_03, MENU_PARA_04, MENU_PARA_05, MENU_PARA_06, MENU_PARA_07, MENU_PARA_08, MENU_PARA_09, MENU_PARA_10, MENU_PARA_11, MENU_PARA_12, MENU_PARA_13, MENU_PARA_14, MENU_PARA_15, MENU_PARA_16, MENU_PARA_17, MENU_PARA_18, MENU_PARA_19, MENU_PARA_20, MENU_LANG_CODE, MENU_ACTIVE_YN, MENU_FROM_DT, MENU_UPTO_DT, MENU_CR_UID, MENU_CR_DT, MENU_UPD_UID, MENU_UPD_DT FROM SITE_M_MENU  
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
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			if(!($this->validate("Menu"))){
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
		  		
					$_OLD_MENU_ST_SYS_ID	=	$value["MENU_ST_SYS_ID"];
					$_OLD_MENU_MODULE	=	$value["MENU_MODULE"];
					$_OLD_MENU_CODE	=	$value["MENU_CODE"];
					$_OLD_MENU_DESC	=	$value["MENU_DESC"];
					$_OLD_MENU_PARENT_CODE	=	$value["MENU_PARENT_CODE"];
					$_OLD_MENU_TYPE	=	$value["MENU_TYPE"];
					$_OLD_MENU_DISP_SEQ	=	$value["MENU_DISP_SEQ"];
					$_OLD_MENU_DEFINITION	=	$value["MENU_DEFINITION"];
					$_OLD_MENU_MULTI_INST_YN	=	$value["MENU_MULTI_INST_YN"];
					$_OLD_MENU_TXN_CODE	=	$value["MENU_TXN_CODE"];
					$_OLD_MENU_PARA_01	=	$value["MENU_PARA_01"];
					$_OLD_MENU_PARA_02	=	$value["MENU_PARA_02"];
					$_OLD_MENU_PARA_03	=	$value["MENU_PARA_03"];
					$_OLD_MENU_PARA_04	=	$value["MENU_PARA_04"];
					$_OLD_MENU_PARA_05	=	$value["MENU_PARA_05"];
					$_OLD_MENU_PARA_06	=	$value["MENU_PARA_06"];
					$_OLD_MENU_PARA_07	=	$value["MENU_PARA_07"];
					$_OLD_MENU_PARA_08	=	$value["MENU_PARA_08"];
					$_OLD_MENU_PARA_09	=	$value["MENU_PARA_09"];
					$_OLD_MENU_PARA_10	=	$value["MENU_PARA_10"];
					$_OLD_MENU_PARA_11	=	$value["MENU_PARA_11"];
					$_OLD_MENU_PARA_12	=	$value["MENU_PARA_12"];
					$_OLD_MENU_PARA_13	=	$value["MENU_PARA_13"];
					$_OLD_MENU_PARA_14	=	$value["MENU_PARA_14"];
					$_OLD_MENU_PARA_15	=	$value["MENU_PARA_15"];
					$_OLD_MENU_PARA_16	=	$value["MENU_PARA_16"];
					$_OLD_MENU_PARA_17	=	$value["MENU_PARA_17"];
					$_OLD_MENU_PARA_18	=	$value["MENU_PARA_18"];
					$_OLD_MENU_PARA_19	=	$value["MENU_PARA_19"];
					$_OLD_MENU_PARA_20	=	$value["MENU_PARA_20"];
					$_OLD_MENU_LANG_CODE	=	$value["MENU_LANG_CODE"];
					$_OLD_MENU_ACTIVE_YN	=	$value["MENU_ACTIVE_YN"];
					$_OLD_MENU_FROM_DT	=	$value["MENU_FROM_DT"];
					$_OLD_MENU_UPTO_DT	=	$value["MENU_UPTO_DT"];
					$_OLD_MENU_CR_UID	=	$value["MENU_CR_UID"];
					$_OLD_MENU_CR_DT	=	$value["MENU_CR_DT"];
					$_OLD_MENU_UPD_UID	=	$value["MENU_UPD_UID"];
					$_OLD_MENU_UPD_DT	=	$value["MENU_UPD_DT"];
		  	}
		  }
		  
			$_P_MENU_ST_SYS_ID = $this->request->getVar("@user_end_parameter_MENU_ST_SYS_ID");
			$_P_MENU_MODULE = $this->request->getVar("@user_end_parameter_MENU_MODULE");
			$_P_MENU_CODE = $this->request->getVar("@user_end_parameter_MENU_CODE");
			$_P_MENU_DESC = $this->request->getVar("@user_end_parameter_MENU_DESC");
			$_P_MENU_PARENT_CODE = $this->request->getVar("@user_end_parameter_MENU_PARENT_CODE");
			$_P_MENU_TYPE = $this->request->getVar("@user_end_parameter_MENU_TYPE");
			$_P_MENU_DISP_SEQ = $this->request->getVar("@user_end_parameter_MENU_DISSEQ");
			$_P_MENU_DEFINITION = $this->request->getVar("@user_end_parameter_MENU_DEFINITION");
			$_P_MENU_MULTI_INST_YN = $this->request->getVar("@user_end_parameter_MENU_MULTI_INST_YN");
			$_P_MENU_TXN_CODE = $this->request->getVar("@user_end_parameter_MENU_TXN_CODE");
			$_P_MENU_PARA_01 = $this->request->getVar("@user_end_parameter_MENU_PARA_01");
			$_P_MENU_PARA_02 = $this->request->getVar("@user_end_parameter_MENU_PARA_02");
			$_P_MENU_PARA_03 = $this->request->getVar("@user_end_parameter_MENU_PARA_03");
			$_P_MENU_PARA_04 = $this->request->getVar("@user_end_parameter_MENU_PARA_04");
			$_P_MENU_PARA_05 = $this->request->getVar("@user_end_parameter_MENU_PARA_05");
			$_P_MENU_PARA_06 = $this->request->getVar("@user_end_parameter_MENU_PARA_06");
			$_P_MENU_PARA_07 = $this->request->getVar("@user_end_parameter_MENU_PARA_07");
			$_P_MENU_PARA_08 = $this->request->getVar("@user_end_parameter_MENU_PARA_08");
			$_P_MENU_PARA_09 = $this->request->getVar("@user_end_parameter_MENU_PARA_09");
			$_P_MENU_PARA_10 = $this->request->getVar("@user_end_parameter_MENU_PARA_10");
			$_P_MENU_PARA_11 = $this->request->getVar("@user_end_parameter_MENU_PARA_11");
			$_P_MENU_PARA_12 = $this->request->getVar("@user_end_parameter_MENU_PARA_12");
			$_P_MENU_PARA_13 = $this->request->getVar("@user_end_parameter_MENU_PARA_13");
			$_P_MENU_PARA_14 = $this->request->getVar("@user_end_parameter_MENU_PARA_14");
			$_P_MENU_PARA_15 = $this->request->getVar("@user_end_parameter_MENU_PARA_15");
			$_P_MENU_PARA_16 = $this->request->getVar("@user_end_parameter_MENU_PARA_16");
			$_P_MENU_PARA_17 = $this->request->getVar("@user_end_parameter_MENU_PARA_17");
			$_P_MENU_PARA_18 = $this->request->getVar("@user_end_parameter_MENU_PARA_18");
			$_P_MENU_PARA_19 = $this->request->getVar("@user_end_parameter_MENU_PARA_19");
			$_P_MENU_PARA_20 = $this->request->getVar("@user_end_parameter_MENU_PARA_20");
			$_P_MENU_ACTIVE_YN = $this->request->getVar("@user_end_parameter_MENU_ACTIVE_YN");
			$_P_MENU_FROM_DT = $this->request->getVar("@user_end_parameter_MENU_FROM_DT");
			$_P_MENU_UPTO_DT = $this->request->getVar("@user_end_parameter_MENU_UPTO_DT");
			$_P_LANG_CODE = $this->request->getVar("@user_end_parameter_LANG_CODE");
			$_P_USER_ID = $this->request->getVar("@user_end_parameter_USER_ID");
			$_P_ERR_NUM = $this->request->getVar("@user_end_parameter_ERR_NUM");
			$_P_ERR_MSG = $this->request->getVar("@user_end_parameter_ERR_MSG");

			$params = array(
			
				array("name"=>":P_MENU_ST_SYS_ID", "value"=>$_P_MENU_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MENU_MODULE", "value"=>$_P_MENU_MODULE, "type"=>SQLT_CHR, "length"=>15),
				array("name"=>":P_MENU_CODE", "value"=>$_P_MENU_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MENU_DESC", "value"=>$_P_MENU_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARENT_CODE", "value"=>$_P_MENU_PARENT_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MENU_TYPE", "value"=>$_P_MENU_TYPE, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MENU_DISP_SEQ", "value"=>$_P_MENU_DISP_SEQ, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MENU_DEFINITION", "value"=>$_P_MENU_DEFINITION, "type"=>SQLT_CHR, "length"=>500),
				array("name"=>":P_MENU_MULTI_INST_YN", "value"=>$_P_MENU_MULTI_INST_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MENU_TXN_CODE", "value"=>$_P_MENU_TXN_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MENU_PARA_01", "value"=>$_P_MENU_PARA_01, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_02", "value"=>$_P_MENU_PARA_02, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_03", "value"=>$_P_MENU_PARA_03, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_04", "value"=>$_P_MENU_PARA_04, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_05", "value"=>$_P_MENU_PARA_05, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_06", "value"=>$_P_MENU_PARA_06, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_07", "value"=>$_P_MENU_PARA_07, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_08", "value"=>$_P_MENU_PARA_08, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_09", "value"=>$_P_MENU_PARA_09, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_10", "value"=>$_P_MENU_PARA_10, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_11", "value"=>$_P_MENU_PARA_11, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_12", "value"=>$_P_MENU_PARA_12, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_13", "value"=>$_P_MENU_PARA_13, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_14", "value"=>$_P_MENU_PARA_14, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_15", "value"=>$_P_MENU_PARA_15, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_16", "value"=>$_P_MENU_PARA_16, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_17", "value"=>$_P_MENU_PARA_17, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_18", "value"=>$_P_MENU_PARA_18, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_19", "value"=>$_P_MENU_PARA_19, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_PARA_20", "value"=>$_P_MENU_PARA_20, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MENU_ACTIVE_YN", "value"=>$_P_MENU_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MENU_FROM_DT", "value"=>$_P_MENU_FROM_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_MENU_UPTO_DT", "value"=>$_P_MENU_UPTO_DT, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","UPDATE_SITE_M_MENU", $params);

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
			
			$_P_MENU_ST_SYS_ID = $this->request->getVar("passing_parameter");
			$_P_MENU_CODE = $this->request->getVar("passing_parameter");
			$_P_LANG_CODE = $this->request->getVar("passing_parameter");
			$_P_USER_ID = $this->request->getVar("passing_parameter");
			$_P_ERR_NUM = $this->request->getVar("passing_parameter");
			$_P_ERR_MSG = $this->request->getVar("passing_parameter");

			$params = array(
			
				array("name"=>":P_MENU_ST_SYS_ID", "value"=>$_P_MENU_ST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MENU_CODE", "value"=>$_P_MENU_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_LANG_CODE", "value"=>$_P_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_USER_ID", "value"=>$_P_USER_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_ERR_NUM", "value"=>&$_P_ERR_NUM, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$_P_ERR_MSG, "type"=>SQLT_CHR, "length"=>300)
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("SPINE_SITE","DELETE_SITE_M_MENU", $params);

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
