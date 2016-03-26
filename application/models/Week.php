<?php
class Week extends CI_Model {
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	/***
	 * find the current week and get the day between week
	 */ 
	function getWeek() {

		$sql = "SELECT * FROM week WHERE NOW() >= week_start AND NOW() <= week_end";
		
        $data = $this->db->query($sql);

		//return $data->result();
		return $data->row();
	}

	/***
	 * find  the day between week by the id
	 */ 
	function getWeekByID($id) {

		$sql = "SELECT * FROM week WHERE week_id = ".$id;
		
        $data = $this->db->query($sql);

		//return $data->result();
		return $data->row();
	}
}
?>
