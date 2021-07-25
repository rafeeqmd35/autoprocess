<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebServices extends CI_Controller {
	public $dyDB;
	public $sessionUser;
	function __construct()
	{
	    parent::__construct();
	    $this->load->model('WebServicesMod');
	    $this->sessionUser = 'NEED_TO_ASSIGN';
	}
	public function index()
	{
		$this->WebServicesMod->test();
	}

	public function dbConnect()
	{
		$postdata = file_get_contents("php://input");
		$_POST = json_decode($postdata, true);

		$outputArray = array();
		$dbType = $_POST['dbType'];
		$host = $_POST['hostName'];
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$dbname = $_POST['db'];
		$port = '';
		$dbdriver = $_POST['driver'];
		$tableName = $_POST['tableName'];
		$procedureName = $_POST['procedureName'];
		$remarks = $_POST['remarks'];
		$action = $_POST['action'];
		$strtoupper = $_POST['caps'];
		
		$bodyContent = '';

		
		

		$this->dyDB = array(
		'hostname' => $host,
		'username' => $user,
		'password' => $pass,
		'database' => $dbname,
		'dbdriver' => $dbdriver,
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'port' => $port
		// 'char_set' => 'utf8',
		// 'dbcollat' => 'utf8_general_ci'
		);

		$dynamicDB = $this->load->database($this->dyDB, TRUE);
	}
	public function connectHere()
	{

		$postdata = file_get_contents("php://input");
		$_POST = json_decode($postdata, true);

		$outputArray = array();
		$dbType = $_POST['dbType'];
		$host = $_POST['hostName'];
		$user = $_POST['user'];
		$pass = $_POST['pass'];
		$dbname = $_POST['db'];
		$port = '';
		$dbdriver = $_POST['driver'];
		$tableName = $_POST['tableName'];
		$procedureName = $_POST['procedureName'];
		$remarks = $_POST['remarks'];
		$action = $_POST['action'];
		$strtoupper = $_POST['caps'];
		
		$bodyContent = '';

		$this->dyDB = array(
		'hostname' => $host,
		'username' => $user,
		'password' => $pass,
		'database' => $dbname,
		'dbdriver' => $dbdriver,
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'port' => $port
		// 'char_set' => 'utf8',
		// 'dbcollat' => 'utf8_general_ci'
		);

		$dynamicDB = $this->load->database($this->dyDB, TRUE);

		if($dbType == 'mysql'){
		// $sql="SELECT * FROM aaa";
		// $result =  $dynamicDB->query($sql)->result_array();
		// //$result = $this->WebServicesMod->connectHere();
		// print_r($result);
		// query to fetch the column name and schema
		$sql = "select * from INFORMATION_SCHEMA.COLUMNS where TABLE_NAME='$tableName' ";
		$resultSql =  $dynamicDB->query($sql)->result_array();
		// print_r($resultSql);
		// exit;
		foreach ($resultSql as $key => $value) {
			$outputArray['name'][] = $value['COLUMN_NAME'];
			$outputArray['type'][] = $value['COLUMN_TYPE'];
		}
			$sql = "DROP PROCEDURE IF EXISTS `$procedureName`";

			//IN `FIERSA` INT(20)
			$result =  $dynamicDB->query($sql);
			if($action == 'SELECT_ALL'){
				$inputs = '';
			}else if($action == 'SELECT' || $action == 'DELETE'){
				//DELETE FROM `test` WHERE 0
				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$inputs = 'IN p_'.$value['COLUMN_NAME'].' '.$value['COLUMN_TYPE'];
						break;
					}
				}
			}else if($action == 'INSERT'){
				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$inputs = 'IN p_'.$value['COLUMN_NAME'].' '.$value['COLUMN_TYPE'];
					}else{
						$inputs = $inputs.', IN p_'.$value['COLUMN_NAME'].' '.$value['COLUMN_TYPE'];
					}
					
				}
			}else if($action == 'UPDATE'){
				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$inputs = 'IN p_'.$value['COLUMN_NAME'].' '.$value['COLUMN_TYPE'];
					}else{
						$inputs = $inputs.', IN p_'.$value['COLUMN_NAME'].' '.$value['COLUMN_TYPE'];
					}
					
				}
			}
			if($strtoupper == 'Y'){
				$sqlAction = '('.strtoupper($inputs).')';	
			}else{
				$sqlAction = '('.$inputs.')';
			}
			
			$sql = " CREATE DEFINER=`$user`@`$host` PROCEDURE `$procedureName` ".$sqlAction." COMMENT '$remarks' DETERMINISTIC CONTAINS SQL SQL SECURITY DEFINER";
			$sql = $sql." BEGIN ";
			//action method here
			if($action == 'SELECT_ALL'){
				$bodyContent = "SELECT * FROM $tableName";
			}else if($action == 'SELECT'){
				$bodyContent = "SELECT * FROM $tableName";
				$bodyContent = $bodyContent . ' WHERE ';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
						break;
					}
				}
			}else if($action == 'DELETE'){
				$bodyContent = "DELETE  FROM $tableName";
				$bodyContent = $bodyContent . ' WHERE ';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
						break;
					}
				}
			}else if($action == 'INSERT'){
				//INSERT INTO STUDENT (name,user_name,branch) values (name ,user_name,branch);
				// sample query above
				$bodyContent = "INSERT INTO $tableName ( ";
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$bodyContent = $bodyContent. $value['COLUMN_NAME'];
					}else{
						$bodyContent = $bodyContent.",".$value['COLUMN_NAME'];
					}
				}
				$bodyContent = $bodyContent . ' ) VALUES (';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$bodyContent = $bodyContent. ' p_'.$value['COLUMN_NAME'];
					}else{
						$bodyContent = $bodyContent.', p_'.$value['COLUMN_NAME'];
					}
				}
				$bodyContent = $bodyContent . ' ) ';
				if($strtoupper == 'Y'){
					$bodyContent = strtoupper($bodyContent);
				}
			}else if($action == 'UPDATE'){
				//UPDATE `test` SET `id`=[value-1],`first_name`=[value-2],`last_name`=[value-3],`age`=[value-4] WHERE 1
				// sample query above
				$bodyContent = "UPDATE $tableName SET ";
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
					}else{
						$bodyContent = $bodyContent.",".$value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
					}
				}
				$bodyContent = $bodyContent . ' WHERE ';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
						break;
					}
				}
				$bodyContent = $bodyContent . '  ';
				if($strtoupper == 'Y'){
					$bodyContent = strtoupper($bodyContent);
				}
			}
			//action end
			$sql = $sql . $bodyContent ;
			$sql = $sql." ;  ";
			$sql = $sql." END ";
			//$result =  $dynamicDB->query($sql);
			//$outputArray['query'] = $sql;
		}else if($dbType == 'oracle'){
			$sql = "select COLUMN_NAME, DATA_TYPE from ALL_TAB_COLUMNS where TABLE_NAME='$tableName'";
			$resultSql =  $dynamicDB->query($sql)->result_array();
			// print_r($resultSql);
			// exit;
			foreach ($resultSql as $key => $value) {
				$outputArray['name'][] = $value['COLUMN_NAME'];
				$outputArray['type'][] = $value['DATA_TYPE'];
			}
			//$sql = "DROP PROCEDURE IF EXISTS `$procedureName`";

			//IN `FIERSA` INT(20)
			$result =  $dynamicDB->query($sql);
			if($action == 'SELECT_ALL'){
				$inputs = '';
			}else if($action == 'SELECT' || $action == 'DELETE'){
				//DELETE FROM `test` WHERE 0

			// $sqlKey = "SELECT COLS.TABLE_NAME, COLS.COLUMN_NAME, COLS.POSITION, CONS.STATUS, CONS.OWNER
			// FROM ALL_CONSTRAINTS CONS, ALL_CONS_COLUMNS COLS
			// WHERE COLS.TABLE_NAME = '$tableName'
			// AND CONS.CONSTRAINT_TYPE = 'P'
			// AND CONS.CONSTRAINT_NAME = COLS.CONSTRAINT_NAME
			// AND CONS.OWNER = COLS.OWNER
			// ORDER BY COLS.TABLE_NAME, COLS.POSITION";
			// 	$resultSqlKey =  $dynamicDB->query($sqlKey)->result_array();

				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$inputs = ' p_'.$value['COLUMN_NAME'].' IN '.$value['DATA_TYPE'];
						break;
					}
				}
			}else if($action == 'INSERT'){
				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$inputs = '  p_'.$value['COLUMN_NAME'].' IN '.$value['DATA_TYPE'];
					}else{
						$inputs = $inputs.',  p_'.$value['COLUMN_NAME'].' IN '.$value['DATA_TYPE'];
					}
					
				}
			}else if($action == 'UPDATE'){
				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$inputs = '   p_'.$value['COLUMN_NAME'].' IN '.$value['DATA_TYPE'];
					}else{
						$inputs = $inputs.',  p_'.$value['COLUMN_NAME'].' IN '.$value['DATA_TYPE'];
					}
					
				}
			}
			if($strtoupper == 'Y'){
				$sqlAction = '('.strtoupper($inputs).')';	
			}else{
				$sqlAction = '('.$inputs.')';
			}
			
			$sql = " CREATE OR REPLACE PROCEDURE $procedureName ".$sqlAction;
			//$sql = $sql." IS E_CUST_ERROR EXCEPTION; BEGIN ";
			$sql = $sql." IS BEGIN ";
			//action method here
			if($action == 'SELECT_ALL'){
				$bodyContent = "SELECT * FROM $tableName";
			}else if($action == 'SELECT'){
				$bodyContent = "SELECT * FROM $tableName";
				$bodyContent = $bodyContent . ' WHERE ';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
						break;
					}
				}
			}else if($action == 'DELETE'){
				$bodyContent = "DELETE  FROM $tableName";
				$bodyContent = $bodyContent . ' WHERE ';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
						break;
					}
				}
			}else if($action == 'INSERT'){
				//INSERT INTO STUDENT (name,user_name,branch) values (name ,user_name,branch);
				// sample query above
				$bodyContent = "INSERT INTO $tableName ( ";
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$bodyContent = $bodyContent. $value['COLUMN_NAME'];
					}else{
						$bodyContent = $bodyContent.",".$value['COLUMN_NAME'];
					}
				}
				$bodyContent = $bodyContent . ' ) VALUES (';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$bodyContent = $bodyContent. ' p_'.$value['COLUMN_NAME'];
					}else{
						$bodyContent = $bodyContent.', p_'.$value['COLUMN_NAME'];
					}
				}
				$bodyContent = $bodyContent . ' ) ';
				if($strtoupper == 'Y'){
					$bodyContent = strtoupper($bodyContent);
				}
			}else if($action == 'UPDATE'){
				//UPDATE `test` SET `id`=[value-1],`first_name`=[value-2],`last_name`=[value-3],`age`=[value-4] WHERE 1
				// sample query above
				$bodyContent = "UPDATE $tableName SET ";
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
					}else{
						$bodyContent = $bodyContent.",".$value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
					}
				}
				$bodyContent = $bodyContent . ' WHERE ';
				foreach ($resultSql as $key => $value) {
					if($value['COLUMN_KEY'] == 'PRI'){
						$bodyContent = $bodyContent. $value['COLUMN_NAME']. ' = '.'p_'.$value['COLUMN_NAME'];
						break;
					}
				}
				$bodyContent = $bodyContent . '  ';
				if($strtoupper == 'Y'){
					$bodyContent = strtoupper($bodyContent);
				}
			}
			//action end
			$sql = $sql . $bodyContent ;
			$sql = $sql." ;  ";
			$sql = $sql." END $procedureName; ";
			//$result =  $dynamicDB->query($sql);
		}
		
		
		$outputArray['query'] = $sql;
		//$outputArray = $sql;
		echo json_encode($outputArray);
		exit;
	}

	function writeInFile(){
		//print_r(CTRLPATH);exit;
		$txt = "function save(){}";
 		$myfile = file_put_contents(CTRLPATH.'Admin.php', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
	}
function getControllerFun(){
	$postdata = file_get_contents("php://input");
	$_POST = json_decode($postdata, true);

	$outputArray = array();
	$dbType = $_POST['dbType'];
	$host = $_POST['hostName'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$dbname = $_POST['db'];
	$port = '';
	$dbdriver = $_POST['driver'];
	$tableName = $_POST['tableName'];
	$procedureName = $_POST['procedureName'];
	$remarks = $_POST['remarks'];
	$action = $_POST['action'];
	$strtoupper = $_POST['caps'];
	
	$bodyContent = '';

	$this->dyDB = array(
		'hostname' => $host,
		'username' => $user,
		'password' => $pass,
		'database' => $dbname,
		'dbdriver' => $dbdriver,
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'port' => $port
		// 'char_set' => 'utf8',
		// 'dbcollat' => 'utf8_general_ci'
		);

	$dynamicDB = $this->load->database($this->dyDB, TRUE);

	$process = $_POST['process'];
	$tableName = $_POST['tableName'];// first letter alone caps others small
	$processName = $_POST['processName'];// first letter alone caps others small
	$pkgName = $_POST['pkgName'];// package name if not send then empty
	
	$module = $_POST['module'];
	
	$fileName = $processName.'Ctrl';
	$ctrlName = $processName.'Ctrl';
	$modelName = $processName.'Mod';
	$getAllFun = 'getAll'.$processName.'Fun';
	$getFun = 'get'.$processName.'Fun';
	$saveFun = 'save'.$processName.'Fun';
	$updateFun = 'update'.$processName.'Fun';
	$deleteFun = 'delete'.$processName.'Fun';
	$processFun = $processName.'Process';
	$viewFun = $processName.'_View';
	$datatable = $processName.'_Datatable';
	$addFun = $processName.'_Add';
	$editFun = $processName.'_Edit';
	if($process == 'NEW'){
		// controller creation started
		$classDefText = '<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class '.$ctrlName.' extends CI_Controller {
		
		function '.$ctrlName.'(){
			parent::__construct();
			$this->load->model("'.$modelName.'");
		}';

		$processFunText = '
		function '.$processFun.'($mode="View"){
			if($mode == "Add"){
				$this->'.$addFun.'();
			}else if($mode == "Edit"){
				$this->'.$editFun.'();
			}else{
				$this->'.$viewFun.'();
			}
		}';

		$viewFunText = '
		function '.$viewFun.'(){
			$data["mode"] = "view";
			$this->load->view("'.$module.'/'.$processFun.'_View",$data);
		}';

		$addFunText = '
		function '.$addFun.'(){
			$data["mode"] = "add";
			$this->load->view("'.$module.'/'.$processFun.'",$data);
		}';

		$editFunText = '
		function '.$editFun.'(){
			$data["mode"] = "edit";
			$this->load->view("'.$module.'/'.$processFun.'",$data);
		}';


		$getDatatableText = '
		function '.$datatable.'(){
			$this->datatables->select("*")
	    	->from("'.$tableName.'");
	    	echo $this->datatables->generate();
		}';

		$getAllFunText = '
		function '.$getAllFun.'(){
			header("Content-Type: application/json");
			$result = $this->'.$modelName.'->'.$getAllFun.'();
			echo json_encode($result);
		}';

		$getFunText = '
		function '.$getFun.'(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->'.$modelName.'->'.$getFun.'($keyID);
			echo json_encode($result);
		}';

		$saveFunText = '
		function '.$saveFun.'(){
			header("Content-Type: application/json");
			$result = $this->'.$modelName.'->'.$saveFun.'();
			echo json_encode($result);
		}';

		$updateFunText = '
		function '.$updateFun.'(){
			header("Content-Type: application/json");
			$result = $this->'.$modelName.'->'.$updateFun.'();
			echo json_encode($result);
		}';

		$deleteFunText = '
		function '.$deleteFun.'(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->'.$modelName.'->'.$deleteFun.'($keyID);
			echo json_encode($result);
		}
	}
?>';

		$txt = $classDefText.$processFunText.$viewFunText.$addFunText.$editFunText.$getDatatableText.$getAllFunText.$getFunText.$saveFunText.$updateFunText.$deleteFunText;

		$myfile = file_put_contents(CTRLPATH.$ctrlName.'.php', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		// controller creation completed

		// model creation started

		$sql = "select COLUMN_NAME, DATA_LENGTH from ALL_TAB_COLUMNS where TABLE_NAME='$tableName'";
		$resultSql =  $dynamicDB->query($sql)->result_array();
		$params = '';
		$getPostParams = '';
		$commonParams = 'array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)';
		foreach ($resultSql as $key => $value) {
			$getPostParams = $getPostParams . '
			$'.$value['COLUMN_NAME'].' = $this->input->post("dummyNAME")';

			$params = $params .'
				array("name"=>":P_'.$value['COLUMN_NAME'].'", "value"=>$'.$value['COLUMN_NAME'].', "type"=>SQLT_CHR, "length"=>'.$value['DATA_LENGTH'].'),';
		}
	$classDefText = '<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class '.$modelName.' extends CI_Model {';
		

		$getAllFunText = '
		function '.$getAllFun.'(){
			$sql = "SELECT * FROM '.$tableName.' ";
			return $this->db->query($sql)->result_array();
		}';

		$getFunText = '
		function '.$getFun.'($keyID){
			$sql = "SELECT * FROM '.$tableName.' WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
		}';

		$saveFunText = '
		function '.$saveFun.'(){
			'.$getPostParams.'

			$params =   array('.$params.'
				'.$commonParams.'
        	);
	        $this->db->storedProcedure("'.$pkgName.'","INSERT_'.$tableName.'", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}';

		$updateFunText = '
		function '.$updateFun.'(){
			'.$getPostParams.'

			$params =   array('.$params.'
				'.$commonParams.'
        	);
	        $this->db->storedProcedure("'.$pkgName.'","UPDATE_'.$tableName.'", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}';

		$deleteFunText = '
		function '.$deleteFun.'($keyID){

			$params =   array(
				array("name"=>":P_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				'.$commonParams.'
        	);
	        $this->db->storedProcedure("'.$pkgName.'","DELETE_'.$tableName.'", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
	}
?>';

		$txt = $classDefText.$getAllFunText.$getFunText.$saveFunText.$updateFunText.$deleteFunText;
		// model creation
		$myfile = file_put_contents(MODPATH.$modelName.'.php', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		// model creation completed
	}
	
}

function getControllerFunForCI4(){
	$postdata = file_get_contents("php://input");
	$_POST = json_decode($postdata, true);

	$outputArray = array();
	$dbType = $_POST['dbType'];
	$host = $_POST['hostName'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$dbname = $_POST['db'];
	$port = '';
	$dbdriver = $_POST['driver'];
	$tableName = $_POST['tableName'];
	$procedureName = $_POST['procedureName'];
	$remarks = $_POST['remarks'];
	$action = $_POST['action'];
	$strtoupper = $_POST['caps'];
	$output = $_POST['output'];
	
	$bodyContent = '';

	$this->dyDB = array(
		'hostname' => $host,
		'username' => $user,
		'password' => $pass,
		'database' => $dbname,
		'dbdriver' => $dbdriver,
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'port' => $port
		// 'char_set' => 'utf8',
		// 'dbcollat' => 'utf8_general_ci'
		);

	$dynamicDB = $this->load->database($this->dyDB, TRUE);

	$process = $_POST['process'];
	$tableLevel = $_POST['tableLevel'];// first letter alone caps others small //Parent/child
	$tableName = $_POST['tableName'];// first letter alone caps others small
	$processName = $_POST['processName'];// first letter alone caps others small
	$pkgName = $_POST['pkgName'];// package name if not send then empty
	
	$module = $_POST['module'];
	
	$fileName = $processName.'Controller';
	$ctrlName = $processName.'Controller';
	$modelName = $processName.'Model';
	$getAllFun = 'getAll'.$processName.'Fun';
	$getFun = 'get'.$processName.'Fun';
	$saveFun = 'save'.$processName.'Fun';
	$updateFun = 'update'.$processName.'Fun';
	$deleteFun = 'delete'.$processName.'Fun';
	$processFun = $processName.'Process';
	$viewFun = $processName.'_View';
	$datatable = $processName.'_Datatable';
	$addFun = $processName.'_Add';
	$editFun = $processName.'_Edit';



	$sql = "SELECT COLUMN_NAME FROM ALL_TAB_COLUMNS WHERE TABLE_NAME='$tableName' ORDER BY COLUMN_ID";
	$resultSqlColumn =  $dynamicDB->query($sql)->result_array();

	//For fetch columns in query
	$_column_names = '';
	$column_name_array = [];
	foreach ($resultSqlColumn as $key => $value) {
		if($key != 0){
		$_column_names = $_column_names. ', ';
		}
		$_column_names = $_column_names . $value['COLUMN_NAME'];
		$column_name_array[] = $value['COLUMN_NAME'];
	}

	$to_send_value_to_user = '';
	foreach ($column_name_array as $key => $value) {
		$to_send_value_to_user = $to_send_value_to_user.'
						"@user_end_parameter_'.$value.'"	=>	$value["'.$value.'"],';
	}
		// controller creation started
		$classDefText = '<?php
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
use App\Models\Backend-'.$modelName.';

class '.$ctrlName.' extends ResourceController {
	
	use ResponseTrait;

	function __construct()
  {
    $this->db = db_connect();
  }
  ';

	$getAllFunText = '

	private function total_count($_PRIMARY_KEY = "", $_TABLE_NAME = "", $site_column="",$site_column_value){
	  $sql = "SELECT COUNT($_PRIMARY_KEY) AS TOT FROM $_TABLE_NAME  ";
	  if($site_column != ""){
	  	$sql = $sql . "WHERE $site_column = \'$site_column_value\'";
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


			$sql = "SELECT * FROM ( SELECT '.$_column_names.' FROM '.strtoupper($tableName).' )  ";

			if($searching === true){
        $sql = $sql . " WHERE UPPER(".strtoupper($search_column).") LIKE UPPER(\'%$search_value%\') ";
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
						'.$to_send_value_to_user.'
					];
					$data_to_send[] = $name_array;
				}
				$primary_key = "PRIMARY_KEY_NEED_TO_SEND";
        $table_name = "'.strtoupper($tableName).'";
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
	}';

	$createFunText = '

	public function create(){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			if(!($this->validate("'.$processName.'"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			//$this->request->getVar("passing parameter");
			';


	$object_name = 'INSERT_' . $tableName;
	$sql = "SELECT  DISTINCT ARGUMENT_NAME, IN_OUT, NVL(DATA_LENGTH,300) as DATA_LENGTH, POSITION FROM ALL_ARGUMENTS 
			WHERE PACKAGE_NAME = '$pkgName' AND OBJECT_NAME = '$object_name' 
			ORDER BY POSITION";
	$resultSqlProcedure =  $dynamicDB->query($sql)->result_array();

	$get_parameter_value = '';
	foreach ($resultSqlProcedure as $key => $value) {
		$_P_hold = $value['ARGUMENT_NAME'];
		$_P_removed = str_replace('P_', '', $_P_hold);
		$get_parameter_value = $get_parameter_value .'
			'.'$_'.$value['ARGUMENT_NAME'].' = $this->request->getVar("@user_end_parameter_'.$_P_removed.'");';
	}
	$params = '';
	$getPostParams = '';
	$params = $get_parameter_value.'

			$params = array(
			';
	foreach ($resultSqlProcedure as $key => $value) {
		$outParaSymbol = '';
		if($value['IN_OUT'] != 'IN'){
			$outParaSymbol = '&';
		}
		$params = $params .'
				array("name"=>":'.$value['ARGUMENT_NAME'].'", "value"=>'.$outParaSymbol.'$_'.$value['ARGUMENT_NAME'].', "type"=>SQLT_CHR, "length"=>'.$value['DATA_LENGTH'].')';
			if(count($resultSqlProcedure) != ($key + 1)){
				$params = $params .',';
			}
			
	}
	$createFunText = $createFunText . $params .'
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("'.$pkgName.'","'.$object_name.'", $params);

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
	}';
	
	$getNewToShowFunText = '

	public function new(){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			$_CR_DT_COLUMN_NAME = "column@";
			$sql = " SELECT '.$_column_names.' FROM '.strtoupper($tableName).'  
							WHERE :CR_DT:  = (SELECT MAX(:CR_DT:) FROM '.strtoupper($tableName).')";
			$query = $this->db->query($sql,[
								"CR_DT" => $_CR_DT_COLUMN_NAME
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						'.$to_send_value_to_user.'
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
	}';

	//$tableLevel used from here
	$childCondition_1 = '';
	$childCondition_2 = '';
	$childCondition_3 = '';
	$childCondition_4 = '';
	$childCondition_5 = '';
	$childCondition_6 = '';
	$childCondition_7 = '';
	if($tableLevel == 'child'){
		$childCondition_1 = '$_parent_id = $this->request->getVar(":parent_id");';		
		$childCondition_2 = '$_PRIMARY_COLUMN_NAME_3 = "column@";//';
		$childCondition_3 = 'AND :PRIMARY_KEY_3: = :PARENT_ID:';
		$childCondition_4 = '"PRIMARY_KEY_3"     => $_PRIMARY_COLUMN_NAME_3,
							"PARENT_ID"     => $_parent_id,';
		$childCondition_5 = ', $_parent_id = null';
		$childCondition_6 = ', $_parent_id';
		$childCondition_7 = '$_parent_id = $inputs[":parent_id"];';
	}

	$getOneToShowFunText = '

	public function show($_id = null){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			$_logged_site_id = $this->request->getVar("logged_site_id");
			'.$childCondition_1.'

			$_PRIMARY_COLUMN_NAME = "column@";//SITE_ID COLUMN NAME
			$_PRIMARY_COLUMN_NAME_2 = "column@";//
			'.$childCondition_2.'
			$sql = " SELECT '.$_column_names.' FROM '.strtoupper($tableName).'  
							WHERE :PRIMARY_KEY: = :SITE_ID: AND :PRIMARY_KEY_2: = :ID: '.$childCondition_3.'";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"SITE_ID"     => $_logged_site_id,
							"PRIMARY_KEY_2"     => $_PRIMARY_COLUMN_NAME_2,
							"ID"     => $_id,
							'.$childCondition_4.'
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						'.$to_send_value_to_user.'
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
	}';

	$getOneToEditFunText = '

	public function edit($_id = null){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

			$_logged_site_id = $this->request->getVar("logged_site_id");
			'.$childCondition_1.'

			$_PRIMARY_COLUMN_NAME = "column@";//SITE_ID COLUMN NAME
			$_PRIMARY_COLUMN_NAME_2 = "column@";//
			'.$childCondition_2.'
			$sql = " SELECT '.$_column_names.' FROM '.strtoupper($tableName).'  
							WHERE :PRIMARY_KEY: = :SITE_ID: AND :PRIMARY_KEY_2: = :ID: '.$childCondition_3.'";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"SITE_ID"     => $_logged_site_id,
							"PRIMARY_KEY_2"     => $_PRIMARY_COLUMN_NAME_2,
							"ID"     => $_id,
							'.$childCondition_4.'
			])->getResult("array");

			$data_to_send = [];
			if($query){
				$return_status = "0";
				$error_message = "Success";

				foreach ($query as $key => $value) {
					$name_array = [
						'.$to_send_value_to_user.'
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
	}';

	$getOneToFetchFunText = '

	protected function fetch($_id = null, $_logged_site_id = null'.$childCondition_5.'){
		try{

			$_PRIMARY_COLUMN_NAME = "column@";//SITE_ID COLUMN NAME
			$_PRIMARY_COLUMN_NAME_2 = "column@";//
			'.$childCondition_2.'
			$sql = " SELECT '.$_column_names.' FROM '.strtoupper($tableName).'  
							WHERE :PRIMARY_KEY: = :SITE_ID: AND :PRIMARY_KEY_2: = :ID: '.$childCondition_3.'";
			$query = $this->db->query($sql,[
							"PRIMARY_KEY"     => $_PRIMARY_COLUMN_NAME,
							"SITE_ID"     => $_logged_site_id,
							"PRIMARY_KEY_2"     => $_PRIMARY_COLUMN_NAME_2,
							"ID"     => $_id,
							'.$childCondition_4.'
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
	}';


	$to_fetch_value_internal = '';
	foreach ($column_name_array as $key => $value) {
		$to_fetch_value_internal = $to_fetch_value_internal.'
					$_OLD_'.$value.'	=	$value["'.$value.'"];';
	}

	$updateFunText = '

	public function update($_id = null){
		try{
			if(!($this->validate("COMMON_PARAMETER"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}
			if(!($this->validate("'.$processName.'"))){
				$validation_error = $this->validator->getErrors();
				$result = array("return_status"=>"-111","error_message"=>"Error","result"=>$validation_error );
				return $this->respond($result);
			}

      //$this->request->getVar("passing parameter");

      $_exist_data = [];

      $_logged_site_id = $this->request->getVar("logged_site_id");
      '.$childCondition_1.'
      $_fetch_edit = $this->fetch($_id, $_logged_site_id'.$childCondition_6.');

      if($_fetch_edit["return_status"] != "0" || $_fetch_edit["return_status"] != "Success" && count($_fetch_edit["result"]) == 0){
      	$result = array("return_status"=>"-113","error_message"=>"No Data Found","result"=>[] );
      	return $this->respond($result);
      }else{
      	$_exist_data = $_fetch_edit["result"];
      	foreach ($_exist_data as $key => $value) {
		  		'.$to_fetch_value_internal.'
		  	}
		  }
		  ';


	$object_name = 'UPDATE_' . $tableName;
	$sql = "SELECT  DISTINCT ARGUMENT_NAME, IN_OUT, NVL(DATA_LENGTH,300) as DATA_LENGTH, POSITION FROM ALL_ARGUMENTS 
			WHERE PACKAGE_NAME = '$pkgName' AND OBJECT_NAME = '$object_name' 
			ORDER BY POSITION";
	$resultSqlProcedure =  $dynamicDB->query($sql)->result_array();

	$get_parameter_value = '';
	foreach ($resultSqlProcedure as $key => $value) {
		$_P_hold = $value['ARGUMENT_NAME'];
		$_P_removed = str_replace('P_', '', $_P_hold);
		$get_parameter_value = $get_parameter_value .'
			'.'$_'.$value['ARGUMENT_NAME'].' = $this->request->getVar("@user_end_parameter_'.$_P_removed.'");';
	}
	$params = '';
	$getPostParams = '';
	$params = $get_parameter_value.'

			$params = array(
			';
	foreach ($resultSqlProcedure as $key => $value) {
		$outParaSymbol = '';
		if($value['IN_OUT'] != 'IN'){
			$outParaSymbol = '&';
		}
		$params = $params .'
				array("name"=>":'.$value['ARGUMENT_NAME'].'", "value"=>'.$outParaSymbol.'$_'.$value['ARGUMENT_NAME'].', "type"=>SQLT_CHR, "length"=>'.$value['DATA_LENGTH'].')';
			if(count($resultSqlProcedure) != ($key + 1)){
				$params = $params .',';
			}
			
	}
	$updateFunText = $updateFunText . $params .'
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("'.$pkgName.'","'.$object_name.'", $params);

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
	}';

	$deleteFunText = '

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
			'.$childCondition_7.'

      $_fetch_edit = $this->fetch($_id, $_logged_site_id'.$childCondition_6.');


      if($_fetch_edit["return_status"] != "0" || $_fetch_edit["return_status"] != "Success" && count($_fetch_edit["result"]) == 0){
      	$result = array("return_status"=>"-113","error_message"=>"No Data Found","result"=>[] );
      	return $this->respond($result);
      }else{
      	//$_exist_data = $_fetch_edit["result"];
      }

			';


	$object_name = 'DELETE_' . $tableName;
	$sql = "SELECT  DISTINCT ARGUMENT_NAME, IN_OUT, NVL(DATA_LENGTH,300) as DATA_LENGTH, POSITION FROM ALL_ARGUMENTS 
			WHERE PACKAGE_NAME = '$pkgName' AND OBJECT_NAME = '$object_name' 
			ORDER BY POSITION";
	$resultSqlProcedure =  $dynamicDB->query($sql)->result_array();

	$get_parameter_value = '';
	foreach ($resultSqlProcedure as $key => $value) {
		$get_parameter_value = $get_parameter_value .'
			'.'$_'.$value['ARGUMENT_NAME'].' = $this->request->getVar("passing_parameter");';
	}
	$params = '';
	$getPostParams = '';
	$params = $get_parameter_value.'

			$params = array(
			';
	foreach ($resultSqlProcedure as $key => $value) {
		$outParaSymbol = '';
		if($value['IN_OUT'] != 'IN'){
			$outParaSymbol = '&';
		}
		$params = $params .'
				array("name"=>":'.$value['ARGUMENT_NAME'].'", "value"=>'.$outParaSymbol.'$_'.$value['ARGUMENT_NAME'].', "type"=>SQLT_CHR, "length"=>'.$value['DATA_LENGTH'].')';
			if(count($resultSqlProcedure) != ($key + 1)){
				$params = $params .',';
			}
			
	}
	$deleteFunText = $deleteFunText . $params .'
			);

			$this->db->txn_start_now();
			$datatoShow = $this->db->storedProcedure("'.$pkgName.'","'.$object_name.'", $params);

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
	}';

$last_part = '
}

?>';

		$txt = $classDefText.$getAllFunText.$createFunText.$getNewToShowFunText.$getOneToShowFunText.$getOneToEditFunText.$getOneToFetchFunText.$updateFunText.$deleteFunText.$last_part;
		if($output == 'html'){
			echo $txt;exit;	
		}else if($output == 'file'){
			$myfile = file_put_contents(CTRLPATH.$ctrlName.'.php', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
			// controller creation completed
		}else{
			echo "Current Output only for html and file";exit;	
		}
		

		
}

function createModule(){
	$postdata = file_get_contents("php://input");
	$_POST = json_decode($postdata, true);

	$outputArray = array();
	$dbType = $_POST['dbType'];
	$host = $_POST['hostName'];
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$dbname = $_POST['db'];
	$port = '';
	$dbdriver = $_POST['driver'];
	$tableName = $_POST['tableName'];
	$procedureName = $_POST['procedureName'];
	$remarks = $_POST['remarks'];
	$action = $_POST['action'];
	$strtoupper = $_POST['caps'];
	
	$bodyContent = '';

	$this->dyDB = array(
		'hostname' => $host,
		'username' => $user,
		'password' => $pass,
		'database' => $dbname,
		'dbdriver' => $dbdriver,
		'dbprefix' => '',
		'pconnect' => FALSE,
		'db_debug' => TRUE,
		'port' => $port
		// 'char_set' => 'utf8',
		// 'dbcollat' => 'utf8_general_ci'
		);

	$dynamicDB = $this->load->database($this->dyDB, TRUE);

	$process = $_POST['process'];
	$tableName = $_POST['tableName'];// first letter alone caps others small
	$processName = $_POST['processName'];// first letter alone caps others small
	$pkgName = $_POST['pkgName'];// package name if not send then empty
	
	$module = $_POST['module'];
	
	$fileName = $processName.'Ctrl';
	$ctrlName = $processName.'Ctrl';
	$modelName = $processName.'Mod';
	$getAllFun = 'getAll'.$processName.'Fun';
	$getFun = 'get'.$processName.'Fun';
	$saveFun = 'save'.$processName.'Fun';
	$updateFun = 'update'.$processName.'Fun';
	$deleteFun = 'delete'.$processName.'Fun';
	$processFun = $processName.'Process';
	$viewFun = $processName.'_View';
	$addFun = $processName.'_Add';
	$editFun = $processName.'_Edit';
	if($process == 'NEW'){
		
	}

}




}






// if (!file_exists('path/to/directory')) {
//     mkdir('path/to/directory', 0777, true);
// }

?>
