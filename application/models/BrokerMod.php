<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class BrokerMod extends CI_Model {
		function getAllBrokerFun(){
			$sql = "SELECT * FROM MKTG_BROKER ";
			return $this->db->query($sql)->result_array();
		}
		function getBrokerFun($keyID){
			$sql = "SELECT * FROM MKTG_BROKER WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
		}
		function saveBrokerFun(){
			
			$MB_APPROVE_DT = $this->input->post("dummyNAME")
			$MB_APPROVE_UID = $this->input->post("dummyNAME")
			$MB_APPROVE_COMP_CODE = $this->input->post("dummyNAME")
			$MB_APPROVE_COA_CODE = $this->input->post("dummyNAME")
			$MB_APPROVE_COMMISSION_PCT = $this->input->post("dummyNAME")
			$MB_SYS_ID = $this->input->post("dummyNAME")
			$MB_TITLE = $this->input->post("dummyNAME")
			$MB_NAME = $this->input->post("dummyNAME")
			$MB_EMAIL = $this->input->post("dummyNAME")
			$MB_PASSWD = $this->input->post("dummyNAME")
			$MB_MOBILE = $this->input->post("dummyNAME")
			$MB_ID_NUMBER = $this->input->post("dummyNAME")
			$MB_ID_PATH = $this->input->post("dummyNAME")
			$MB_COMP_NAME = $this->input->post("dummyNAME")
			$MB_COMP_ADDRESS = $this->input->post("dummyNAME")
			$MB_PHONE = $this->input->post("dummyNAME")
			$MB_TAX_REG_YN = $this->input->post("dummyNAME")
			$MB_TAX_REG_NO = $this->input->post("dummyNAME")
			$MB_TAX_REG_EXP_DT = $this->input->post("dummyNAME")
			$MB_TAX_REG_PATH = $this->input->post("dummyNAME")
			$MB_BANK_NAME = $this->input->post("dummyNAME")
			$MB_BANK_ACCOUNT_NUMBER = $this->input->post("dummyNAME")
			$MB_REGISTER_DT = $this->input->post("dummyNAME")
			$MB_STAUS = $this->input->post("dummyNAME")
			$MB_APPROVE_YN = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_MB_APPROVE_DT", "value"=>$MB_APPROVE_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_MB_APPROVE_UID", "value"=>$MB_APPROVE_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_MB_APPROVE_COMP_CODE", "value"=>$MB_APPROVE_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MB_APPROVE_COA_CODE", "value"=>$MB_APPROVE_COA_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MB_APPROVE_COMMISSION_PCT", "value"=>$MB_APPROVE_COMMISSION_PCT, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MB_SYS_ID", "value"=>$MB_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MB_TITLE", "value"=>$MB_TITLE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_MB_NAME", "value"=>$MB_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_EMAIL", "value"=>$MB_EMAIL, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_MB_PASSWD", "value"=>$MB_PASSWD, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_MOBILE", "value"=>$MB_MOBILE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_NUMBER", "value"=>$MB_ID_NUMBER, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_PATH", "value"=>$MB_ID_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_COMP_NAME", "value"=>$MB_COMP_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_COMP_ADDRESS", "value"=>$MB_COMP_ADDRESS, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_PHONE", "value"=>$MB_PHONE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_TAX_REG_YN", "value"=>$MB_TAX_REG_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MB_TAX_REG_NO", "value"=>$MB_TAX_REG_NO, "type"=>SQLT_CHR, "length"=>30),
				array("name"=>":P_MB_TAX_REG_EXP_DT", "value"=>$MB_TAX_REG_EXP_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_MB_TAX_REG_PATH", "value"=>$MB_TAX_REG_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_BANK_NAME", "value"=>$MB_BANK_NAME, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_BANK_ACCOUNT_NUMBER", "value"=>$MB_BANK_ACCOUNT_NUMBER, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_MB_REGISTER_DT", "value"=>$MB_REGISTER_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_MB_STAUS", "value"=>$MB_STAUS, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MB_APPROVE_YN", "value"=>$MB_APPROVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->storedProcedure("SPINE_MKTG","INSERT_MKTG_BROKER", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function updateBrokerFun(){
			
			$MB_APPROVE_DT = $this->input->post("dummyNAME")
			$MB_APPROVE_UID = $this->input->post("dummyNAME")
			$MB_APPROVE_COMP_CODE = $this->input->post("dummyNAME")
			$MB_APPROVE_COA_CODE = $this->input->post("dummyNAME")
			$MB_APPROVE_COMMISSION_PCT = $this->input->post("dummyNAME")
			$MB_SYS_ID = $this->input->post("dummyNAME")
			$MB_TITLE = $this->input->post("dummyNAME")
			$MB_NAME = $this->input->post("dummyNAME")
			$MB_EMAIL = $this->input->post("dummyNAME")
			$MB_PASSWD = $this->input->post("dummyNAME")
			$MB_MOBILE = $this->input->post("dummyNAME")
			$MB_ID_NUMBER = $this->input->post("dummyNAME")
			$MB_ID_PATH = $this->input->post("dummyNAME")
			$MB_COMP_NAME = $this->input->post("dummyNAME")
			$MB_COMP_ADDRESS = $this->input->post("dummyNAME")
			$MB_PHONE = $this->input->post("dummyNAME")
			$MB_TAX_REG_YN = $this->input->post("dummyNAME")
			$MB_TAX_REG_NO = $this->input->post("dummyNAME")
			$MB_TAX_REG_EXP_DT = $this->input->post("dummyNAME")
			$MB_TAX_REG_PATH = $this->input->post("dummyNAME")
			$MB_BANK_NAME = $this->input->post("dummyNAME")
			$MB_BANK_ACCOUNT_NUMBER = $this->input->post("dummyNAME")
			$MB_REGISTER_DT = $this->input->post("dummyNAME")
			$MB_STAUS = $this->input->post("dummyNAME")
			$MB_APPROVE_YN = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_MB_APPROVE_DT", "value"=>$MB_APPROVE_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_MB_APPROVE_UID", "value"=>$MB_APPROVE_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_MB_APPROVE_COMP_CODE", "value"=>$MB_APPROVE_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MB_APPROVE_COA_CODE", "value"=>$MB_APPROVE_COA_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MB_APPROVE_COMMISSION_PCT", "value"=>$MB_APPROVE_COMMISSION_PCT, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MB_SYS_ID", "value"=>$MB_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_MB_TITLE", "value"=>$MB_TITLE, "type"=>SQLT_CHR, "length"=>5),
				array("name"=>":P_MB_NAME", "value"=>$MB_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_EMAIL", "value"=>$MB_EMAIL, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_MB_PASSWD", "value"=>$MB_PASSWD, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_MOBILE", "value"=>$MB_MOBILE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_NUMBER", "value"=>$MB_ID_NUMBER, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_ID_PATH", "value"=>$MB_ID_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_COMP_NAME", "value"=>$MB_COMP_NAME, "type"=>SQLT_CHR, "length"=>100),
				array("name"=>":P_MB_COMP_ADDRESS", "value"=>$MB_COMP_ADDRESS, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_PHONE", "value"=>$MB_PHONE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_TAX_REG_YN", "value"=>$MB_TAX_REG_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_MB_TAX_REG_NO", "value"=>$MB_TAX_REG_NO, "type"=>SQLT_CHR, "length"=>30),
				array("name"=>":P_MB_TAX_REG_EXP_DT", "value"=>$MB_TAX_REG_EXP_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_MB_TAX_REG_PATH", "value"=>$MB_TAX_REG_PATH, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_MB_BANK_NAME", "value"=>$MB_BANK_NAME, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_MB_BANK_ACCOUNT_NUMBER", "value"=>$MB_BANK_ACCOUNT_NUMBER, "type"=>SQLT_CHR, "length"=>25),
				array("name"=>":P_MB_REGISTER_DT", "value"=>$MB_REGISTER_DT, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_MB_STAUS", "value"=>$MB_STAUS, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_MB_APPROVE_YN", "value"=>$MB_APPROVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->storedProcedure("SPINE_MKTG","UPDATE_MKTG_BROKER", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function deleteBrokerFun($keyID){

			$params =   array(
				array("name"=>":P_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->storedProcedure("SPINE_MKTG","DELETE_MKTG_BROKER", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
	}
?>
