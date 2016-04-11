<?php
class Groups extends CI_Model {
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	/***
	 * find all group data
	 */ 
	function getGroups() {

		$sql = "SELECT * FROM groups";
		
        $data = $this->db->query($sql);

		return $data->result();
		//return $data->row();
	}

	/***
	 * find  the day between week by the id
	 */ 
	function getGroupByID($id) {

		$sql = "SELECT * FROM groups WHERE group_id = ".$id;
		
        $data = $this->db->query($sql);

		//return $data->result();
		return $data->row();
	}
}
?>
