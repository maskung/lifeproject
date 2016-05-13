<?php
class Surveycare extends CI_Model {
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	/***
	 * find all survery data
	 */ 
	function getSurveys() {

		$sql = "SELECT * FROM surveycare ";
		
        $data = $this->db->query($sql);

		return $data->result();
		//return $data->row();
	}

	/***
	 * find  survey data by the id
	 */ 
	function getWeekByID($id) {

		$sql = "SELECT * FROM surveycare WHERE survey_id = ".$id;
		
        $data = $this->db->query($sql);

		//return $data->result();
		return $data->row();
	}

	/***
	 * insert survey data
	 */
	function insert() {
		$data = array('sex'=>  $this->input->post('sex'),
					  'church'=>$this->input->post('church'),
					  'role'=>$this->input->post('role'),
					  'q1'=>$this->input->post('q1'),
					  'q2'=>$this->input->post('q2'),
					  'q3'=>$this->input->post('q3'),
					  'q4'=>$this->input->post('q4'),
					  'q5'=>$this->input->post('q5'),
					  'q6'=>$this->input->post('q6'),
					  'q7'=>$this->input->post('q7'),
					  'q8'=>$this->input->post('q8'),
					  'q9'=>$this->input->post('q9'),
					  'q10'=>$this->input->post('q10'),
					  'suggest'=>$this->input->post('suggest'),
					  'date_added'=>date('Y-m-d H:m:s'));

		$this->db->insert('surveycare', $data);
	}

	/***
	 * find amount of people survey group by sex
	 */ 
    function countBySex() {

        $sql = "SELECT sex, COUNT(*) AS amount FROM `surveycare` GROUP BY sex";
		$data = $this->db->query($sql);
        return $data->result();
	}

	/***
	 * find amount of people survey group by area
	 */ 
    function countByArea() {

        $sql = "SELECT church, COUNT(*) AS amount FROM `surveycare` GROUP BY church";
		$data = $this->db->query($sql);
        return $data->result();
	}
	
	/***
	 * find  all people who subit survey
	 */ 
    function countByAll() {

        $sql = "SELECT COUNT(*) AS amount FROM `surveycare` ";
		$data = $this->db->query($sql);
        return $data->row();
	}

	/***
	 * find all comments 
	 */ 
    function getAllComments() {

        $sql = "SELECT survey_id, sex, church, suggest, date_added  FROM `surveycare` WHERE suggest <> '' ";
		$data = $this->db->query($sql);
        return $data->result();
	}

}
?>
