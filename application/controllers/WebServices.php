<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebServices extends CI_Controller {
	public $dyDB;
	public $sessionUser;
	function WebServices()
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
	        $this->db->stored_procedure("'.$pkgName.'","INSERT_'.$tableName.'", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}';

		$updateFunText = '
		function '.$updateFun.'(){
			'.$getPostParams.'

			$params =   array('.$params.'
				'.$commonParams.'
        	);
	        $this->db->stored_procedure("'.$pkgName.'","UPDATE_'.$tableName.'", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}';

		$deleteFunText = '
		function '.$deleteFun.'($keyID){

			$params =   array(
				array("name"=>":P_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				'.$commonParams.'
        	);
	        $this->db->stored_procedure("'.$pkgName.'","DELETE_'.$tableName.'", $params);
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
