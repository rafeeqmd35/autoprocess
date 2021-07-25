<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class CustomerCtrl extends CI_Controller {
		
		function CustomerCtrl(){
			parent::__construct();
			$this->load->model("CustomerMod");
		}
		function CustomerProcess($mode="View"){
			if($mode == "Add"){
				$this->Customer_Add();
			}else if($mode == "Edit"){
				$this->Customer_Edit();
			}else{
				$this->Customer_View();
			}
		}
		function Customer_View(){
			$data["mode"] = "view";
			$this->load->view("Application/CustomerProcess_View",$data);
		}
		function Customer_Add(){
			$data["mode"] = "add";
			$this->load->view("Application/CustomerProcess",$data);
		}
		function Customer_Edit(){
			$data["mode"] = "edit";
			$this->load->view("Application/CustomerProcess",$data);
		}
		function Customer_Datatable(){
			$this->datatables->select("*")
	    	->from("SITE_M_CUSTOMER");
	    	echo $this->datatables->generate();
		}
		function getAllCustomerFun(){
			header("Content-Type: application/json");
			$result = $this->CustomerMod->getAllCustomerFun();
			echo json_encode($result);
		}
		function getCustomerFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->CustomerMod->getCustomerFun($keyID);
			echo json_encode($result);
		}
		function saveCustomerFun(){
			header("Content-Type: application/json");
			$result = $this->CustomerMod->saveCustomerFun();
			echo json_encode($result);
		}
		function updateCustomerFun(){
			header("Content-Type: application/json");
			$result = $this->CustomerMod->updateCustomerFun();
			echo json_encode($result);
		}
		function deleteCustomerFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->CustomerMod->deleteCustomerFun($keyID);
			echo json_encode($result);
		}
	}
?>
