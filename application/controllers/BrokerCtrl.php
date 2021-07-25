<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class BrokerCtrl extends CI_Controller {
		
		function BrokerCtrl(){
			parent::__construct();
			$this->load->model("BrokerMod");
		}
		function BrokerProcess($mode="View"){
			if($mode == "Add"){
				$this->Broker_Add();
			}else if($mode == "Edit"){
				$this->Broker_Edit();
			}else{
				$this->Broker_View();
			}
		}
		function Broker_View(){
			$data["mode"] = "view";
			$this->load->view("Application/BrokerProcess_View",$data);
		}
		function Broker_Add(){
			$data["mode"] = "add";
			$this->load->view("Application/BrokerProcess",$data);
		}
		function Broker_Edit(){
			$data["mode"] = "edit";
			$this->load->view("Application/BrokerProcess",$data);
		}
		function Broker_Datatable(){
			$this->datatables->select("*")
	    	->from("MKTG_BROKER");
	    	echo $this->datatables->generate();
		}
		function getAllBrokerFun(){
			header("Content-Type: application/json");
			$result = $this->BrokerMod->getAllBrokerFun();
			echo json_encode($result);
		}
		function getBrokerFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->BrokerMod->getBrokerFun($keyID);
			echo json_encode($result);
		}
		function saveBrokerFun(){
			header("Content-Type: application/json");
			$result = $this->BrokerMod->saveBrokerFun();
			echo json_encode($result);
		}
		function updateBrokerFun(){
			header("Content-Type: application/json");
			$result = $this->BrokerMod->updateBrokerFun();
			echo json_encode($result);
		}
		function deleteBrokerFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->BrokerMod->deleteBrokerFun($keyID);
			echo json_encode($result);
		}
	}
?>
