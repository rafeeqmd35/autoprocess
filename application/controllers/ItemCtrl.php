<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class ItemCtrl extends CI_Controller {
		
		function ItemCtrl(){
			parent::__construct();
			$this->load->model("ItemMod");
		}
		function getAllItemFun(){
			header("Content-Type: application/json");
			$result = $this->ItemMod->getAllItemFun($keyID);
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
