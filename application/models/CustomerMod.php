<?php
	defined("BASEPATH") OR exit("No direct script access allowed");

	class CustomerMod extends CI_Model {
		function getAllCustomerFun(){
			$sql = "SELECT * FROM SITE_M_CUSTOMER ";
			return $this->db->query($sql)->result_array();
		}
		function getCustomerFun($keyID){
			$sql = "SELECT * FROM SITE_M_CUSTOMER WHERE id = ".$keyID;
			return $this->db->query($sql)->result_array();
		}
		function saveCustomerFun(){
			
			$CUST_SYS_ID = $this->input->post("dummyNAME")
			$CUST_EMAIL_ID = $this->input->post("dummyNAME")
			$CUST_TITLE = $this->input->post("dummyNAME")
			$CUST_FIRST_NAME = $this->input->post("dummyNAME")
			$CUST_LAST_NAME = $this->input->post("dummyNAME")
			$CUST_PASSWORD = $this->input->post("dummyNAME")
			$CUST_DOB = $this->input->post("dummyNAME")
			$CUST_NATIONALITY = $this->input->post("dummyNAME")
			$CUST_CITY = $this->input->post("dummyNAME")
			$CUST_MOBILE = $this->input->post("dummyNAME")
			$CUST_PHONE_NUMBER = $this->input->post("dummyNAME")
			$CUST_PHOTO = $this->input->post("dummyNAME")
			$CUST_GENDER = $this->input->post("dummyNAME")
			$CUST_TYPE = $this->input->post("dummyNAME")
			$CUST_COMP_NAME = $this->input->post("dummyNAME")
			$CUST_COMP_TAX_NO = $this->input->post("dummyNAME")
			$CUST_COMP_TAX_DT = $this->input->post("dummyNAME")
			$CUST_KEY_TYPE = $this->input->post("dummyNAME")
			$CUST_KEY_VALUE = $this->input->post("dummyNAME")
			$CUST_LAST_LOGIN = $this->input->post("dummyNAME")
			$CUST_FAILED_ACCESS_ATTEMPTS = $this->input->post("dummyNAME")
			$CUST_CAD_SYS_ID = $this->input->post("dummyNAME")
			$CUST_REF_COMP_CODE = $this->input->post("dummyNAME")
			$CUST_REF_CUST_ID = $this->input->post("dummyNAME")
			$CUST_ACTIVE_YN = $this->input->post("dummyNAME")
			$CUST_LANG_CODE = $this->input->post("dummyNAME")
			$CUST_CR_UID = $this->input->post("dummyNAME")
			$CUST_CR_DT = $this->input->post("dummyNAME")
			$CUST_UPD_UID = $this->input->post("dummyNAME")
			$CUST_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_CUST_SYS_ID", "value"=>$CUST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CUST_EMAIL_ID", "value"=>$CUST_EMAIL_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CUST_TITLE", "value"=>$CUST_TITLE, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_CUST_FIRST_NAME", "value"=>$CUST_FIRST_NAME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_LAST_NAME", "value"=>$CUST_LAST_NAME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_PASSWORD", "value"=>$CUST_PASSWORD, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CUST_DOB", "value"=>$CUST_DOB, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CUST_NATIONALITY", "value"=>$CUST_NATIONALITY, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_CITY", "value"=>$CUST_CITY, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_MOBILE", "value"=>$CUST_MOBILE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_CUST_PHONE_NUMBER", "value"=>$CUST_PHONE_NUMBER, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_CUST_PHOTO", "value"=>$CUST_PHOTO, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CUST_GENDER", "value"=>$CUST_GENDER, "type"=>SQLT_CHR, "length"=>6),
				array("name"=>":P_CUST_TYPE", "value"=>$CUST_TYPE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_COMP_NAME", "value"=>$CUST_COMP_NAME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_COMP_TAX_NO", "value"=>$CUST_COMP_TAX_NO, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_COMP_TAX_DT", "value"=>$CUST_COMP_TAX_DT, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_KEY_TYPE", "value"=>$CUST_KEY_TYPE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_CUST_KEY_VALUE", "value"=>$CUST_KEY_VALUE, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CUST_LAST_LOGIN", "value"=>$CUST_LAST_LOGIN, "type"=>SQLT_CHR, "length"=>11),
				array("name"=>":P_CUST_FAILED_ACCESS_ATTEMPTS", "value"=>$CUST_FAILED_ACCESS_ATTEMPTS, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CUST_CAD_SYS_ID", "value"=>$CUST_CAD_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CUST_REF_COMP_CODE", "value"=>$CUST_REF_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_REF_CUST_ID", "value"=>$CUST_REF_CUST_ID, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_ACTIVE_YN", "value"=>$CUST_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_CUST_LANG_CODE", "value"=>$CUST_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_CR_UID", "value"=>$CUST_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CUST_CR_DT", "value"=>$CUST_CR_DT, "type"=>SQLT_CHR, "length"=>11),
				array("name"=>":P_CUST_UPD_UID", "value"=>$CUST_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CUST_UPD_DT", "value"=>$CUST_UPD_DT, "type"=>SQLT_CHR, "length"=>11),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->storedProcedure("SPINE_SITE","INSERT_SITE_M_CUSTOMER", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function updateCustomerFun(){
			
			$CUST_SYS_ID = $this->input->post("dummyNAME")
			$CUST_EMAIL_ID = $this->input->post("dummyNAME")
			$CUST_TITLE = $this->input->post("dummyNAME")
			$CUST_FIRST_NAME = $this->input->post("dummyNAME")
			$CUST_LAST_NAME = $this->input->post("dummyNAME")
			$CUST_PASSWORD = $this->input->post("dummyNAME")
			$CUST_DOB = $this->input->post("dummyNAME")
			$CUST_NATIONALITY = $this->input->post("dummyNAME")
			$CUST_CITY = $this->input->post("dummyNAME")
			$CUST_MOBILE = $this->input->post("dummyNAME")
			$CUST_PHONE_NUMBER = $this->input->post("dummyNAME")
			$CUST_PHOTO = $this->input->post("dummyNAME")
			$CUST_GENDER = $this->input->post("dummyNAME")
			$CUST_TYPE = $this->input->post("dummyNAME")
			$CUST_COMP_NAME = $this->input->post("dummyNAME")
			$CUST_COMP_TAX_NO = $this->input->post("dummyNAME")
			$CUST_COMP_TAX_DT = $this->input->post("dummyNAME")
			$CUST_KEY_TYPE = $this->input->post("dummyNAME")
			$CUST_KEY_VALUE = $this->input->post("dummyNAME")
			$CUST_LAST_LOGIN = $this->input->post("dummyNAME")
			$CUST_FAILED_ACCESS_ATTEMPTS = $this->input->post("dummyNAME")
			$CUST_CAD_SYS_ID = $this->input->post("dummyNAME")
			$CUST_REF_COMP_CODE = $this->input->post("dummyNAME")
			$CUST_REF_CUST_ID = $this->input->post("dummyNAME")
			$CUST_ACTIVE_YN = $this->input->post("dummyNAME")
			$CUST_LANG_CODE = $this->input->post("dummyNAME")
			$CUST_CR_UID = $this->input->post("dummyNAME")
			$CUST_CR_DT = $this->input->post("dummyNAME")
			$CUST_UPD_UID = $this->input->post("dummyNAME")
			$CUST_UPD_DT = $this->input->post("dummyNAME")

			$params =   array(
				array("name"=>":P_CUST_SYS_ID", "value"=>$CUST_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CUST_EMAIL_ID", "value"=>$CUST_EMAIL_ID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CUST_TITLE", "value"=>$CUST_TITLE, "type"=>SQLT_CHR, "length"=>10),
				array("name"=>":P_CUST_FIRST_NAME", "value"=>$CUST_FIRST_NAME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_LAST_NAME", "value"=>$CUST_LAST_NAME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_PASSWORD", "value"=>$CUST_PASSWORD, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CUST_DOB", "value"=>$CUST_DOB, "type"=>SQLT_CHR, "length"=>7),
				array("name"=>":P_CUST_NATIONALITY", "value"=>$CUST_NATIONALITY, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_CITY", "value"=>$CUST_CITY, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_MOBILE", "value"=>$CUST_MOBILE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_CUST_PHONE_NUMBER", "value"=>$CUST_PHONE_NUMBER, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_CUST_PHOTO", "value"=>$CUST_PHOTO, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CUST_GENDER", "value"=>$CUST_GENDER, "type"=>SQLT_CHR, "length"=>6),
				array("name"=>":P_CUST_TYPE", "value"=>$CUST_TYPE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_COMP_NAME", "value"=>$CUST_COMP_NAME, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_COMP_TAX_NO", "value"=>$CUST_COMP_TAX_NO, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_COMP_TAX_DT", "value"=>$CUST_COMP_TAX_DT, "type"=>SQLT_CHR, "length"=>50),
				array("name"=>":P_CUST_KEY_TYPE", "value"=>$CUST_KEY_TYPE, "type"=>SQLT_CHR, "length"=>20),
				array("name"=>":P_CUST_KEY_VALUE", "value"=>$CUST_KEY_VALUE, "type"=>SQLT_CHR, "length"=>250),
				array("name"=>":P_CUST_LAST_LOGIN", "value"=>$CUST_LAST_LOGIN, "type"=>SQLT_CHR, "length"=>11),
				array("name"=>":P_CUST_FAILED_ACCESS_ATTEMPTS", "value"=>$CUST_FAILED_ACCESS_ATTEMPTS, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CUST_CAD_SYS_ID", "value"=>$CUST_CAD_SYS_ID, "type"=>SQLT_CHR, "length"=>22),
				array("name"=>":P_CUST_REF_COMP_CODE", "value"=>$CUST_REF_COMP_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_REF_CUST_ID", "value"=>$CUST_REF_CUST_ID, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_ACTIVE_YN", "value"=>$CUST_ACTIVE_YN, "type"=>SQLT_CHR, "length"=>1),
				array("name"=>":P_CUST_LANG_CODE", "value"=>$CUST_LANG_CODE, "type"=>SQLT_CHR, "length"=>12),
				array("name"=>":P_CUST_CR_UID", "value"=>$CUST_CR_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CUST_CR_DT", "value"=>$CUST_CR_DT, "type"=>SQLT_CHR, "length"=>11),
				array("name"=>":P_CUST_UPD_UID", "value"=>$CUST_UPD_UID, "type"=>SQLT_CHR, "length"=>32),
				array("name"=>":P_CUST_UPD_DT", "value"=>$CUST_UPD_DT, "type"=>SQLT_CHR, "length"=>11),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->storedProcedure("SPINE_SITE","UPDATE_SITE_M_CUSTOMER", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
		function deleteCustomerFun($keyID){

			$params =   array(
				array("name"=>":P_SYS_ID", "value"=>$keyID, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_LANG_CODE", "value"=>substr($_SERVER["HTTP_ACCEPT_LANGUAGE"], 0, 2), "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_USER_ID", "value"=>$this->sessionUser, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_NUM", "value"=>&$return_status, "type"=>SQLT_CHR, "length"=>300),
				array("name"=>":P_ERR_MSG", "value"=>&$error_message, "type"=>SQLT_CHR, "length"=>300)
        	);
	        $this->db->storedProcedure("SPINE_SITE","DELETE_SITE_M_CUSTOMER", $params);
	        $result = array("return_status"=>$return_status,"error_message"=>$error_message );
	        return $result;
		}
	}
?>
