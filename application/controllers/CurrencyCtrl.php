<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class CurrencyCtrl extends CI_Controller {
		
		function CurrencyCtrl(){
			parent::__construct();
			$this->load->model("CurrencyMod");
		}
		function CurrencyProcess($mode="View"){
			if($mode == "Add"){
				$this->Currency_Add();
			}else if($mode == "Edit"){
				$this->Currency_Edit();
			}else{
				$this->Currency_View();
			}
		}
		function Currency_View(){
			$data["mode"] = "view";
			$this->load->view("Sale/CurrencyProcess_View",$data);
		}
		function Currency_Add(){
			$data["mode"] = "add";
			$this->load->view("Sale/CurrencyProcess",$data);
		}
		function Currency_Edit(){
			$data["mode"] = "edit";
			$this->load->view("Sale/CurrencyProcess",$data);
		}
		function getAllCurrencyFun(){
			header("Content-Type: application/json");
			$result = $this->CurrencyMod->getAllCurrencyFun();
			echo json_encode($result);
		}
		function getCurrencyFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->CurrencyMod->getCurrencyFun($keyID);
			echo json_encode($result);
		}
		function saveCurrencyFun(){
			header("Content-Type: application/json");
			$result = $this->CurrencyMod->saveCurrencyFun();
			echo json_encode($result);
		}
		function updateCurrencyFun(){
			header("Content-Type: application/json");
			$result = $this->CurrencyMod->updateCurrencyFun();
			echo json_encode($result);
		}
		function deleteCurrencyFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->CurrencyMod->deleteCurrencyFun($keyID);
			echo json_encode($result);
		}
	}
?>
<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class CurrencyCtrl extends CI_Controller {
		
		function CurrencyCtrl(){
			parent::__construct();
			$this->load->model("CurrencyMod");
		}
		function CurrencyProcess($mode="View"){
			if($mode == "Add"){
				$this->Currency_Add();
			}else if($mode == "Edit"){
				$this->Currency_Edit();
			}else{
				$this->Currency_View();
			}
		}
		function Currency_View(){
			$data["mode"] = "view";
			$this->load->view("Sales/CurrencyProcess_View",$data);
		}
		function Currency_Add(){
			$data["mode"] = "add";
			$this->load->view("Sales/CurrencyProcess",$data);
		}
		function Currency_Edit(){
			$data["mode"] = "edit";
			$this->load->view("Sales/CurrencyProcess",$data);
		}
		function getAllCurrencyFun(){
			header("Content-Type: application/json");
			$result = $this->CurrencyMod->getAllCurrencyFun();
			echo json_encode($result);
		}
		function getCurrencyFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->CurrencyMod->getCurrencyFun($keyID);
			echo json_encode($result);
		}
		function saveCurrencyFun(){
			header("Content-Type: application/json");
			$result = $this->CurrencyMod->saveCurrencyFun();
			echo json_encode($result);
		}
		function updateCurrencyFun(){
			header("Content-Type: application/json");
			$result = $this->CurrencyMod->updateCurrencyFun();
			echo json_encode($result);
		}
		function deleteCurrencyFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->CurrencyMod->deleteCurrencyFun($keyID);
			echo json_encode($result);
		}
	}
?>
