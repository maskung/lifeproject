<?php
class Prize extends CI_Model {
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	/***
	 * find the current week and get the day between week
	 */ 
	function getWeekPrize() {

		$sql = "SELECT * FROM prize WHERE created = DATE(NOW())";
		
        $data = $this->db->query($sql);

		return $data->result();
		//return $data->row();
	}

	/***
	 * clear prize
	 */ 
	function clearPrize() {

		$sql = "DELETE FROM prize WHERE created = DATE(NOW())";
		
        $data = $this->db->query($sql);

	}

	/***
	 * insert people who get prize
	 */ 
	function recordPrize($id, $name, $email) {

		$data = array('id'		=> $id,
					   'name'	=> $name,
					   'mission'	=> $email,
					   'created'=> date('Y-m-d'));
		$this->db->insert('prize', $data);
		
	}
}
?>
