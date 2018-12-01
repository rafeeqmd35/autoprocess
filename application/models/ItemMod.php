<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class ItemMod extends CI_Model {
		function getItemFun(){
			$sql = "SELECT * FROM INVT_M_ITEM ";
			return $this->db->query($sql)->result_array();
		}
		function getItemFun($keyID){
			$sql = "SELECT * FROM INVT_M_ITEM WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
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
