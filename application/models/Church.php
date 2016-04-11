<?php
class Church extends CI_Model {
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	/***
	 * find all group data
	 */ 
	function getChurches() {

		$sql = "SELECT * FROM church";
		
        $data = $this->db->query($sql);

		return $data->result();
		//return $data->row();
	}

	/***
	 * find  the day between week by the id
	 */ 
	function getChurchByID($id) {

		$sql = "SELECT * FROM church WHERE church_id = ".$id;
		
        $data = $this->db->query($sql);

		//return $data->result();
		return $data->row();
	}
}
?>
