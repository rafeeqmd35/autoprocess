<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class ItemCtrl extends CI_Controller {
		
		function ItemCtrl(){
			parent::__construct();
			$this->load->model("ItemMod");
		}
		function getAllItemFun(){
			header("Content-Type: application/json");
			$result = $this->ItemMod->getAllItemFun();
			echo json_encode($result);
		}
		function getItemFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->ItemMod->getItemFun($keyID);
			echo json_encode($result);
		}
		function saveItemFun(){
			header("Content-Type: application/json");
			$result = $this->ItemMod->saveItemFun();
			echo json_encode($result);
		}
		function updateItemFun(){
			header("Content-Type: application/json");
			$result = $this->ItemMod->updateItemFun();
			echo json_encode($result);
		}
		function deleteItemFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->ItemMod->deleteItemFun($keyID);
			echo json_encode($result);
		}
	}
?>
<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class ItemCtrl extends CI_Controller {
		
		function ItemCtrl(){
			parent::__construct();
			$this->load->model("ItemMod");
		}
		function ItemProcess($mode="View"){
			if($mode == "Add"){
				$this->Item_Add();
			}else if($mode == "Edit"){
				$this->Item_Edit();
			}else{
				$this->Item_View();
			}
		}
		function Item_View(){
			$data["mode"] = "view";
			$this->load->view("Sales/ItemProcess_View",$data);
		}
		function Item_Add(){
			$data["mode"] = "add";
			$this->load->view("Sales/ItemProcess",$data);
		}
		function Item_Edit(){
			$data["mode"] = "edit";
			$this->load->view("Sales/ItemProcess",$data);
		}
		function getAllItemFun(){
			header("Content-Type: application/json");
			$result = $this->ItemMod->getAllItemFun();
			echo json_encode($result);
		}
		function getItemFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->ItemMod->getItemFun($keyID);
			echo json_encode($result);
		}
		function saveItemFun(){
			header("Content-Type: application/json");
			$result = $this->ItemMod->saveItemFun();
			echo json_encode($result);
		}
		function updateItemFun(){
			header("Content-Type: application/json");
			$result = $this->ItemMod->updateItemFun();
			echo json_encode($result);
		}
		function deleteItemFun(){
			header("Content-Type: application/json");
			$keyID = $_POST["keyID"];
			$result = $this->ItemMod->deleteItemFun($keyID);
			echo json_encode($result);
		}
	}
?>
