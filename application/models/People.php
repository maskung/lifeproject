<?php
class People extends CI_Model {
	
	
	function __construct(){
		parent::__construct();
	}
	
	
	function insert($data = array()){
		$data = array(
			'people_name' => $data['people_name'] ,
			'leader_id' => $data['leader_id'] ,
			'group_id' => $data['group_id'],
			'date_added' => $now,
	
		);
		$this->db->insert('people', $data);		
	}

	function getPeopleByWeek($datestart, $dateend, $interval=0) {
		
		//$array = array('created >=' => $datestart.'+ INTERVAL '.$interval.' DAY', 'created <=' => $dateend.'+ INTERVAL '.$interval.' DAY');
		//$this->db->where($array); 
        //$this->db->order_by("id", "desc"); 
        //$data = $this->db->get('curd');
		$sql = "SELECT * FROM `curd` WHERE `created` >= '".$datestart."' + INTERVAL ".$interval." DAY AND `created` <= '".$dateend."' + INTERVAL ".$interval." DAY ORDER BY `id` DESC"; 
		$data = $this->db->query($sql);

		return $data->result();
	}

	function getPrizeByWeek($datestart, $dateend, $interval=0, $exceptids) {
		
		//$array = array('created >=' => $datestart.'+ INTERVAL '.$interval.' DAY', 'created <=' => $dateend.'+ INTERVAL '.$interval.' DAY');
		//$this->db->where($array); 
        //$this->db->order_by("id", "desc"); 
        //$data = $this->db->get('curd');
		if ($exceptids != "") {
			$sql = "SELECT * FROM `curd` WHERE `created` >= '".$datestart."' + INTERVAL ".$interval." DAY AND `created` <= '".$dateend."' + INTERVAL ".$interval." DAY AND id NOT IN (".$exceptids.") ORDER BY RAND() LIMIT 1" ; 
		} else {
			$sql = "SELECT * FROM `curd` WHERE `created` >= '".$datestart."' + INTERVAL ".$interval." DAY AND `created` <= '".$dateend."' + INTERVAL ".$interval." DAY ORDER BY RAND() LIMIT 1" ; 
		}
		$data = $this->db->query($sql);

		return $data->row();
	}

	function countGroupByWeek($datestart, $dateend, $interval=0) {
		
		$sql = "SELECT email, COUNT(*) AS amount FROM `curd` WHERE `created` >= '".$datestart."' + INTERVAL ".$interval." DAY AND `created` <= '".$dateend."' + INTERVAL ".$interval." DAY GROUP BY `email`"; 
		$data = $this->db->query($sql);

		return $data->result();
	}

}
?>
