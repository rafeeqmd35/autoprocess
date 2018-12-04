<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class ItemMod extends CI_Model {
		function getAllItemFun(){
			$sql = "SELECT * FROM INVT_M_ITEM_COLOR ";
			return $this->db->query($sql)->result_array();
		}
		function getItemFun($keyID){
			$sql = "SELECT * FROM INVT_M_ITEM_COLOR WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
		}
		function saveItemFun(){
			
			$IC_CODE = $this->input->post("dummyNAME")
			$IC_DESC = $this->input->post("dummyNAME")
			$IC_IF_CODE = $this->input->post("dummyNAME")
			$IC_ACTIVE_YN = $this->input->post("dummyNAME")
			$IC_LANG_CODE = $this->input->post("dummyNAME")
			$IC_CR_UID = $this->input->post("dummyNAME")
			$IC_CR_DT = $this->input->post("dummyNAME")
			$IC_UPD_UID = $this->input->post("dummyNAME")
			$IC_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_IC_CODE", "value"=>$IC_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_DESC", "value"=>$IC_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_IC_IF_CODE", "value"=>$IC_IF_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_ACTIVE_YN", "value"=>$IC_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_IC_LANG_CODE", "value"=>$IC_LANG_CODE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_IC_CR_UID", "value"=>$IC_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_CR_DT", "value"=>$IC_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_IC_UPD_UID", "value"=>$IC_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_UPD_DT", "value"=>$IC_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_INVT","INSERT_INVT_M_ITEM_COLOR", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function updateItemFun(){
			
			$IC_CODE = $this->input->post("dummyNAME")
			$IC_DESC = $this->input->post("dummyNAME")
			$IC_IF_CODE = $this->input->post("dummyNAME")
			$IC_ACTIVE_YN = $this->input->post("dummyNAME")
			$IC_LANG_CODE = $this->input->post("dummyNAME")
			$IC_CR_UID = $this->input->post("dummyNAME")
			$IC_CR_DT = $this->input->post("dummyNAME")
			$IC_UPD_UID = $this->input->post("dummyNAME")
			$IC_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_IC_CODE", "value"=>$IC_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_DESC", "value"=>$IC_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_IC_IF_CODE", "value"=>$IC_IF_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_ACTIVE_YN", "value"=>$IC_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_IC_LANG_CODE", "value"=>$IC_LANG_CODE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_IC_CR_UID", "value"=>$IC_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_CR_DT", "value"=>$IC_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_IC_UPD_UID", "value"=>$IC_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_UPD_DT", "value"=>$IC_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_INVT","UPDATE_INVT_M_ITEM_COLOR", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function deleteItemFun($keyID){

			$params =   array(
				array("name"=>":P_PARA_METER_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_INVT","DELETE_INVT_M_ITEM_COLOR", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
	}
?>
<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class ItemMod extends CI_Model {
		function getAllItemFun(){
			$sql = "SELECT * FROM INVT_M_ITEM_COLOR ";
			return $this->db->query($sql)->result_array();
		}
		function getItemFun($keyID){
			$sql = "SELECT * FROM INVT_M_ITEM_COLOR WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
		}
		function saveItemFun(){
			
			$IC_CODE = $this->input->post("dummyNAME")
			$IC_DESC = $this->input->post("dummyNAME")
			$IC_IF_CODE = $this->input->post("dummyNAME")
			$IC_ACTIVE_YN = $this->input->post("dummyNAME")
			$IC_LANG_CODE = $this->input->post("dummyNAME")
			$IC_CR_UID = $this->input->post("dummyNAME")
			$IC_CR_DT = $this->input->post("dummyNAME")
			$IC_UPD_UID = $this->input->post("dummyNAME")
			$IC_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_IC_CODE", "value"=>$IC_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_DESC", "value"=>$IC_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_IC_IF_CODE", "value"=>$IC_IF_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_ACTIVE_YN", "value"=>$IC_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_IC_LANG_CODE", "value"=>$IC_LANG_CODE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_IC_CR_UID", "value"=>$IC_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_CR_DT", "value"=>$IC_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_IC_UPD_UID", "value"=>$IC_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_UPD_DT", "value"=>$IC_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_INVT","INSERT_INVT_M_ITEM_COLOR", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function updateItemFun(){
			
			$IC_CODE = $this->input->post("dummyNAME")
			$IC_DESC = $this->input->post("dummyNAME")
			$IC_IF_CODE = $this->input->post("dummyNAME")
			$IC_ACTIVE_YN = $this->input->post("dummyNAME")
			$IC_LANG_CODE = $this->input->post("dummyNAME")
			$IC_CR_UID = $this->input->post("dummyNAME")
			$IC_CR_DT = $this->input->post("dummyNAME")
			$IC_UPD_UID = $this->input->post("dummyNAME")
			$IC_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_IC_CODE", "value"=>$IC_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_DESC", "value"=>$IC_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_IC_IF_CODE", "value"=>$IC_IF_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_IC_ACTIVE_YN", "value"=>$IC_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_IC_LANG_CODE", "value"=>$IC_LANG_CODE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_IC_CR_UID", "value"=>$IC_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_CR_DT", "value"=>$IC_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_IC_UPD_UID", "value"=>$IC_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_IC_UPD_DT", "value"=>$IC_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_INVT","UPDATE_INVT_M_ITEM_COLOR", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function deleteItemFun($keyID){

			$params =   array(
				array("name"=>":P_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_INVT","DELETE_INVT_M_ITEM_COLOR", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
	}
?>
