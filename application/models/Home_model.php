<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Home_model extends CI_Model {
    
    public function fillgrid(){
		//$array = array('created >=' => $startdate+$interval, 'created <=' => $enddate+$interval, 'email' => $this->session->userdata('groupname'));
		//$this->db->where($array); 
        //$this->db->order_by("id", "desc"); 
        //$data = $this->db->get('curd');

		//$sql = "SELECT * FROM `curd` WHERE `created` >= '".$datestart."' + INTERVAL ".$interval." DAY AND `created` <= '".$dateend."' + INTERVAL ".$interval." DAY AND `email` = '".$this->session->userdata('groupname')."' ORDER BY `id` DESC"; 
		$sql = "SELECT * FROM `curd` LEFT JOIN church USING (church_id) WHERE `email` = '".$this->session->userdata('groupname')."' ORDER BY `id` DESC"; 
		$data = $this->db->query($sql);

        foreach ($data->result() as $row){
            $edit = base_url().'home/edit/';
            $delete = base_url().'home/delete/';
            echo "<tr>
                        <td>$row->id</td>
                        <td class=\"text-left\">$row->name</td>
                        <td class=\"text-left\">$row->church_name</td>
                        <td>$row->created</td>
                        <td><!--a href='$edit' data-id='$row->id' class='btnedit' title='edit'><i class='glyphicon glyphicon-pencil' title='edit'></i></a-->&nbsp;&nbsp;&nbsp;&nbsp;<a href='$delete' data-id='$row->id' class='btndelete' title='delete'><i class='glyphicon glyphicon-remove'></i></a></td>    
                    </tr>";
             
        }
        exit;
    }
 
    public function create(){

		$this->db->select('*')->from('curd')->where(email, $this->session->userdata('groupname')); 
		$q = $this->db->get(); 
		$amount = $q->num_rows();


        $data = array('name'=>  $this->input->post('name'),
                'email'=>$this->input->post('email'),
                'contact'=> '',
                'facebook_link'=>'',
                'course_id'=>$this->input->post('courseid'),
                'church_id'=>$this->input->post('church'),
                'created'=>date('Y-m-d'));



			if ($amount < 20 || $this->session->userdata('course_id') == 8) { 
				$this->db->insert('curd', $data);
				echo'<div class="alert alert-success">ข้อมูลถูกบันทึกเรียบร้อยแล้ว</div>';
			} else {
				echo'<div class="alert alert-danger">ห้องเรียนนี้เต็มแล้ว</div>';
			}

            exit;
    }

    /**
     * getAllStudent - get all student
     */

    public function getAllStudent() {
        //return $this->db->get('curd')->result();
        $sql = "SELECT * FROM `curd` LEFT JOIN church USING (church_id)";
		$data = $this->db->query($sql);
        return $data->result();
    }

	public function  countPeopleRegist($id) {
		$sql = "SELECT COUNT(*) as amount FROM `curd` WHERE course_id = ".$id;  
		$data = $this->db->query($sql);
        return $data->row();
	}

    public function countByChurch() {

        $sql = "SELECT church_name,COUNT(*) AS amount FROM `curd` LEFT JOIN church USING (church_id) GROUP BY church_id";
		$data = $this->db->query($sql);
        return $data->result();
    }
     
    public function countByCourse() {

        $sql = "SELECT groups.group_name, groups.topic, COUNT(*) AS amount FROM `curd` LEFT  OUTER JOIN groups ON curd.course_id = groups.group_id GROUP BY groups.group_id";
		$data = $this->db->query($sql);
        return $data->result();
    }

    public function countByAll() {

        $sql = "SELECT COUNT(*) AS amount FROM `curd` ";
		$data = $this->db->query($sql);
        return $data->row();
    }
}
 
?>
