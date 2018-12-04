<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class WebServices extends CI_Controller {
	public $dyDB;
	function WebServices()
	{
	    parent::__construct();
	    $this->load->model('WebServicesMod');
	}
	public function index()
	{
		$this->WebServicesMod->test();
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
						$inputs = 'IN p_'.$value['COLUMN_NAME'].' '.$value['DATA_TYPE'];
						break;
					}
				}
			}else if($action == 'INSERT'){
				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$inputs = '<br> IN p_'.$value['COLUMN_NAME'].' '.$value['DATA_TYPE'];
					}else{
						$inputs = $inputs.',<br> IN p_'.$value['COLUMN_NAME'].' '.$value['DATA_TYPE'];
					}
					
				}
			}else if($action == 'UPDATE'){
				$inputs = '';
				foreach ($resultSql as $key => $value) {
					if($key == 0){
						$inputs = ' <br> IN p_'.$value['COLUMN_NAME'].' '.$value['DATA_TYPE'];
					}else{
						$inputs = $inputs.',<br> IN p_'.$value['COLUMN_NAME'].' '.$value['DATA_TYPE'];
					}
					
				}
			}
			if($strtoupper == 'Y'){
				$sqlAction = '('.strtoupper($inputs).')';	
			}else{
				$sqlAction = '('.$inputs.')';
			}
			
			$sql = " CREATE PROCEDURE `$procedureName` ".$sqlAction;
			$sql = $sql." IS E_CUST_ERROR EXCEPTION; BEGIN ";
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
			$sql = $sql." END; ";
			//$result =  $dynamicDB->query($sql);
		}
		
		
		$outputArray['query'] = $sql;
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
	$process = $_POST['process'];
	$tableName = $_POST['tableName'];// first letter alone caps others small
	$processName = $_POST['processName'];// first letter alone caps others small
	$fileName = $processName.'Ctrl';
	$ctrlName = $processName.'Ctrl';
	$modelName = $processName.'Mod';
	$getAllFun = 'getAll'.$processName.'Fun';
	$getFun = 'get'.$processName.'Fun';
	$saveFun = 'save'.$processName.'Fun';
	$updateFun = 'update'.$processName.'Fun';
	$deleteFun = 'delete'.$processName.'Fun';
	if($process == 'NEW'){
		// controller creation started
		$classDefText = '<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class '.$ctrlName.' extends CI_Controller {
		
		function '.$ctrlName.'(){
			parent::__construct();
			$this->load->model("'.$modelName.'");
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

		$txt = $classDefText.$getAllFunText.$getFunText.$saveFunText.$updateFunText.$deleteFunText;

		$myfile = file_put_contents(CTRLPATH.$ctrlName.'.php', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		// controller creation completed

		// model creation started
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

		$txt = $classDefText.$getAllFunText.$getFunText.$saveFunText.$updateFunText.$deleteFunText;
		// model creation
		$myfile = file_put_contents(MODPATH.$modelName.'.php', $txt.PHP_EOL , FILE_APPEND | LOCK_EX);
		// model creation completed
	}
	
}
}
