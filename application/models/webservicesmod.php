<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class WebServicesMod extends CI_Model
{
	public function test()
	{
		$sql="SELECT * FROM aaa";
		$result = $this->db->query($sql)->num_rows();
		echo $result;
		//$query = $this->db->query($sql, $return_object = TRUE);
	}

	public function connectHere()
	{
		$sql="SELECT * FROM aaa";
		return $this->dyDB->query($sql);
		//$query = $this->db->query($sql, $return_object = TRUE);
	}
}
?>