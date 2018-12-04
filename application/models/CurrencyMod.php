<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class CurrencyMod extends CI_Model {
		function getAllCurrencyFun(){
			$sql = "SELECT * FROM SALE_M_CURRENCY ";
			return $this->db->query($sql)->result_array();
		}
		function getCurrencyFun($keyID){
			$sql = "SELECT * FROM SALE_M_CURRENCY WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
		}
		function saveCurrencyFun(){
			
			$CCY_COMP_CODE = $this->input->post("dummyNAME")
			$CCY_CODE = $this->input->post("dummyNAME")
			$CCY_DESC = $this->input->post("dummyNAME")
			$CCY_SYMBOL = $this->input->post("dummyNAME")
			$CCY_PRECISION = $this->input->post("dummyNAME")
			$CCY_FORMAT = $this->input->post("dummyNAME")
			$CCY_FROM_DT = $this->input->post("dummyNAME")
			$CCY_UPTO_DT = $this->input->post("dummyNAME")
			$CCY_ACTIVE_YN = $this->input->post("dummyNAME")
			$CCY_LANG_CODE = $this->input->post("dummyNAME")
			$CCY_CR_UID = $this->input->post("dummyNAME")
			$CCY_CR_DT = $this->input->post("dummyNAME")
			$CCY_UPD_UID = $this->input->post("dummyNAME")
			$CCY_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_CCY_COMP_CODE", "value"=>$CCY_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CODE", "value"=>$CCY_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_DESC", "value"=>$CCY_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CCY_SYMBOL", "value"=>$CCY_SYMBOL, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_PRECISION", "value"=>$CCY_PRECISION, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CCY_FORMAT", "value"=>$CCY_FORMAT, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_CCY_FROM_DT", "value"=>$CCY_FROM_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPTO_DT", "value"=>$CCY_UPTO_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_ACTIVE_YN", "value"=>$CCY_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_CCY_LANG_CODE", "value"=>$CCY_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CR_UID", "value"=>$CCY_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_CR_DT", "value"=>$CCY_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPD_UID", "value"=>$CCY_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_UPD_DT", "value"=>$CCY_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_SALE","INSERT_SALE_M_CURRENCY", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function updateCurrencyFun(){
			
			$CCY_COMP_CODE = $this->input->post("dummyNAME")
			$CCY_CODE = $this->input->post("dummyNAME")
			$CCY_DESC = $this->input->post("dummyNAME")
			$CCY_SYMBOL = $this->input->post("dummyNAME")
			$CCY_PRECISION = $this->input->post("dummyNAME")
			$CCY_FORMAT = $this->input->post("dummyNAME")
			$CCY_FROM_DT = $this->input->post("dummyNAME")
			$CCY_UPTO_DT = $this->input->post("dummyNAME")
			$CCY_ACTIVE_YN = $this->input->post("dummyNAME")
			$CCY_LANG_CODE = $this->input->post("dummyNAME")
			$CCY_CR_UID = $this->input->post("dummyNAME")
			$CCY_CR_DT = $this->input->post("dummyNAME")
			$CCY_UPD_UID = $this->input->post("dummyNAME")
			$CCY_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_CCY_COMP_CODE", "value"=>$CCY_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CODE", "value"=>$CCY_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_DESC", "value"=>$CCY_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CCY_SYMBOL", "value"=>$CCY_SYMBOL, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_PRECISION", "value"=>$CCY_PRECISION, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CCY_FORMAT", "value"=>$CCY_FORMAT, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_CCY_FROM_DT", "value"=>$CCY_FROM_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPTO_DT", "value"=>$CCY_UPTO_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_ACTIVE_YN", "value"=>$CCY_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_CCY_LANG_CODE", "value"=>$CCY_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CR_UID", "value"=>$CCY_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_CR_DT", "value"=>$CCY_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPD_UID", "value"=>$CCY_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_UPD_DT", "value"=>$CCY_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_SALE","UPDATE_SALE_M_CURRENCY", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function deleteCurrencyFun($keyID){

			$params =   array(
				array("name"=>":P_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_SALE","DELETE_SALE_M_CURRENCY", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
	}
?>
<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class CurrencyMod extends CI_Model {
		function getAllCurrencyFun(){
			$sql = "SELECT * FROM SALE_M_CURRENCY ";
			return $this->db->query($sql)->result_array();
		}
		function getCurrencyFun($keyID){
			$sql = "SELECT * FROM SALE_M_CURRENCY WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
		}
		function saveCurrencyFun(){
			
			$CCY_COMP_CODE = $this->input->post("dummyNAME")
			$CCY_CODE = $this->input->post("dummyNAME")
			$CCY_DESC = $this->input->post("dummyNAME")
			$CCY_SYMBOL = $this->input->post("dummyNAME")
			$CCY_PRECISION = $this->input->post("dummyNAME")
			$CCY_FORMAT = $this->input->post("dummyNAME")
			$CCY_FROM_DT = $this->input->post("dummyNAME")
			$CCY_UPTO_DT = $this->input->post("dummyNAME")
			$CCY_ACTIVE_YN = $this->input->post("dummyNAME")
			$CCY_LANG_CODE = $this->input->post("dummyNAME")
			$CCY_CR_UID = $this->input->post("dummyNAME")
			$CCY_CR_DT = $this->input->post("dummyNAME")
			$CCY_UPD_UID = $this->input->post("dummyNAME")
			$CCY_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_CCY_COMP_CODE", "value"=>$CCY_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CODE", "value"=>$CCY_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_DESC", "value"=>$CCY_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CCY_SYMBOL", "value"=>$CCY_SYMBOL, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_PRECISION", "value"=>$CCY_PRECISION, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CCY_FORMAT", "value"=>$CCY_FORMAT, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_CCY_FROM_DT", "value"=>$CCY_FROM_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPTO_DT", "value"=>$CCY_UPTO_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_ACTIVE_YN", "value"=>$CCY_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_CCY_LANG_CODE", "value"=>$CCY_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CR_UID", "value"=>$CCY_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_CR_DT", "value"=>$CCY_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPD_UID", "value"=>$CCY_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_UPD_DT", "value"=>$CCY_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_SALE","INSERT_SALE_M_CURRENCY", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function updateCurrencyFun(){
			
			$CCY_COMP_CODE = $this->input->post("dummyNAME")
			$CCY_CODE = $this->input->post("dummyNAME")
			$CCY_DESC = $this->input->post("dummyNAME")
			$CCY_SYMBOL = $this->input->post("dummyNAME")
			$CCY_PRECISION = $this->input->post("dummyNAME")
			$CCY_FORMAT = $this->input->post("dummyNAME")
			$CCY_FROM_DT = $this->input->post("dummyNAME")
			$CCY_UPTO_DT = $this->input->post("dummyNAME")
			$CCY_ACTIVE_YN = $this->input->post("dummyNAME")
			$CCY_LANG_CODE = $this->input->post("dummyNAME")
			$CCY_CR_UID = $this->input->post("dummyNAME")
			$CCY_CR_DT = $this->input->post("dummyNAME")
			$CCY_UPD_UID = $this->input->post("dummyNAME")
			$CCY_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_CCY_COMP_CODE", "value"=>$CCY_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CODE", "value"=>$CCY_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_DESC", "value"=>$CCY_DESC, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CCY_SYMBOL", "value"=>$CCY_SYMBOL, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_PRECISION", "value"=>$CCY_PRECISION, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CCY_FORMAT", "value"=>$CCY_FORMAT, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_CCY_FROM_DT", "value"=>$CCY_FROM_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPTO_DT", "value"=>$CCY_UPTO_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_ACTIVE_YN", "value"=>$CCY_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_CCY_LANG_CODE", "value"=>$CCY_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CCY_CR_UID", "value"=>$CCY_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_CR_DT", "value"=>$CCY_CR_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CCY_UPD_UID", "value"=>$CCY_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CCY_UPD_DT", "value"=>$CCY_UPD_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_SALE","UPDATE_SALE_M_CURRENCY", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function deleteCurrencyFun($keyID){

			$params =   array(
				array("name"=>":P_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->stored_procedure("SPINE_SALE","DELETE_SALE_M_CURRENCY", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
	}
?>
