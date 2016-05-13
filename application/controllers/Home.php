<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Home controller - realete with the main page
 *
 * This file is main controll of main page TIN project 
 * @author Suphanut Thanyaboon <suphanut@gmail.com>
 * @version 0.0.1
 *
 */

class Home extends CI_Controller {

	public function __construct(){
		parent::__construct();
        // Load all needed model
        $this->load->model('home_model');
        $this->load->library('form_validation');
        $this->load->Model('Auth_model');
        $this->load->Model('Week');
        $this->load->Model('People');
        $this->load->Model('Groups');
        $this->load->Model('Church');
        $this->load->Model('Survey');
        $this->load->Model('Surveycare');
		
	}
	/**
 	 * index page show on default
     */
	public function index() {
		$data['title'] = "หน้าหลัก";

        //check user logged in or not
        $this->Auth_model->isLoggedIn();
		//$this->load->view('login',$data);

        //get all chruch
        $data['churches'] = $this->Church->getChurches();
        $data['course'] = $this->Groups->getGroupByID($this->session->userdata('course_id')); 

		//count amount of people who register this subject
		$amount	= $this->home_model->countPeopleRegist($this->session->userdata('course_id')); 
        $data['amount'] = $amount->amount;

        $this->load->view('header',$data);
        $this->load->view('dashboard',$data);
        $this->load->view('footer',$data);
        
	}

    /**
     * servey - show servey form 
     */
	public function survey() {
		$data['title'] = "สำรวจความพึงพอใจ";

        //get all groups
        $data['allgroups'] = $this->Groups->getGroups(); 

        $this->load->view('header',$data);
        $this->load->view('surveyform',$data);
        $this->load->view('footer',$data);
	}

    /**
     * servey - show servey form 
     */
	public function serveyaction() {
		$data['title'] = "บันทึกข้อมูลแบบสำรวจ";

		$this->Survey->insert();

        $this->load->view('header',$data);
        $this->load->view('surveysuccess',$data);
        $this->load->view('footer',$data);

	}

    /**
     * serveycare - show servey form 
     */
	public function surveycare() {
		$data['title'] = "สำรวจความพึงพอใจ";

        //get all groups
        $data['allgroups'] = $this->Groups->getGroups(); 

        $this->load->view('header',$data);
        $this->load->view('surveycareform',$data);
        $this->load->view('footer',$data);
	}

    /**
     * servey - show servey form 
     */
	public function serveycareaction() {
		$data['title'] = "บันทึกข้อมูลแบบสำรวจ";

		$this->Surveycare->insert();

        $this->load->view('header',$data);
        $this->load->view('surveycaresuccess',$data);
        $this->load->view('footer',$data);

	}

    /**
     * courselist - show list of student in multi table
     */
	public function courselist() {
		$data['title'] = "รายชื่อนักเรียน";

        //get all groups
        $allgroups = $this->Groups->getGroups(); 

        // add to student to courses
        $allcourse = array();
        
        foreach ($allgroups as $group) {
            $allcourse[$group->group_id] = array('course_name' => $group->group_name,
                                                 'teacher' => $group->teacher,
                                                 'church' => $group->church,
                                                 'topic' => $group->topic,
                                                 'students' => array()
                    );
        }
        

        $allstudents = $this->home_model->getAllStudent(); 

        foreach ($allstudents as $student) {
            $allcourse[$student->course_id]['students'][] = $student;
        }

        //do_dump($allstudents,'allstudents');

        //do_dump($allcourse,'allcourse');

        $data['allcourses'] = $allcourse;

        $this->load->view('header',$data);
        $this->load->view('courselist',$data);
        $this->load->view('footer',$data);
	}

    /**
     * proportion - show proportion by church
     */
	public function proportion() {
		$data['title'] = "จำนวนนักเรียนแยกตามคริสตจักร";


        $data['amountbychurch'] = $this->home_model->countByChurch(); 
        $data['amountbyCourse'] = $this->home_model->countByCourse(); 
        $data['totalamount'] = $this->home_model->countByAll();

        $this->load->view('header',$data);
        $this->load->view('proportion',$data);
        $this->load->view('footer',$data);
    }

    /**
     * surveyresult - show  survey result in chart
     */
	public function surveyresult() {
		$data['title'] = "รายงานผลความพึงพอใจ";

        // get raw survey data
        $allsurveys = $this->Survey->getSurveys();
        //do_dump($allsurveys,'allsurveys');

        $ranks = array(

            1 => array(0,0,0,0,0,0,0,0,0,0,0),
            2 => array(0,0,0,0,0,0,0,0,0,0,0),
            3 => array(0,0,0,0,0,0,0,0,0,0,0),
            4 => array(0,0,0,0,0,0,0,0,0,0,0),
            5 => array(0,0,0,0,0,0,0,0,0,0,0),
        );

        // remove the 0 element off
        unset($ranks[1][0]);
        unset($ranks[2][0]);
        unset($ranks[3][0]);
        unset($ranks[4][0]);
        unset($ranks[5][0]);

        // re-arrange the data for chart 
        foreach ($allsurveys as  $survey) {
            
            for ($i=1; $i <= 10; $i++) {
                $survey->{'q'.$i}==1?$ranks[1][$i]++:$ranks[1][$i];
                $survey->{'q'.$i}==2?$ranks[2][$i]++:$ranks[2][$i];
                $survey->{'q'.$i}==3?$ranks[3][$i]++:$ranks[3][$i];
                $survey->{'q'.$i}==4?$ranks[4][$i]++:$ranks[4][$i];
                $survey->{'q'.$i}==5?$ranks[5][$i]++:$ranks[5][$i];
            }

        }


        $totalamount = $this->Survey->countByAll();

        //find average love
        $love = array();
        $sd = array();
        for ($i = 1; $i <= 10; $i++) {

            $x = ($ranks[5][$i]*5 + $ranks[4][$i]*4 + $ranks[3][$i]*3 + $ranks[2][$i]*2 + $ranks[1][$i]*1);
            $xbar = $x/$totalamount->amount;

            $sd[$i] = number_format(sqrt(($ranks[5][$i]*25 + $ranks[4][$i]*16 + $ranks[3][$i]*9 + $ranks[2][$i]*4 + $ranks[1][$i]*1)/$totalamount->amount - pow($xbar,2)),2,'.',''); 

            $love[$i] =  $xbar;
            
        }

        //do_dump($love,'love');
        //do_dump($sd,'sd');
        //find standard deviation

        $data['ranks'] = $ranks;
        $data['love'] = $love;
        $data['sd'] = $sd; 
        $data['amountbysex'] = $this->Survey->countBySex(); 
        $data['amountbyarea'] = $this->Survey->countByArea(); 
        $data['totalamount'] = $totalamount;
        $data['suggests'] = $this->Survey->getAllComments();

        $this->load->view('header',$data);
        $this->load->view('surveyresult',$data);
        $this->load->view('footer',$data);



    }

    /**
     * surveycareresult - show  survey care result in chart
     */
	public function surveycareresult() {
		$data['title'] = "รายงานผลความพึงพอใจ";

        // get raw survey data
        $allsurveys = $this->Surveycare->getSurveys();
        //do_dump($allsurveys,'allsurveys');

        $ranks = array(

            1 => array(0,0,0,0,0,0,0,0,0,0,0),
            2 => array(0,0,0,0,0,0,0,0,0,0,0),
            3 => array(0,0,0,0,0,0,0,0,0,0,0),
            4 => array(0,0,0,0,0,0,0,0,0,0,0),
            5 => array(0,0,0,0,0,0,0,0,0,0,0),
        );

        // remove the 0 element off
        unset($ranks[1][0]);
        unset($ranks[2][0]);
        unset($ranks[3][0]);
        unset($ranks[4][0]);
        unset($ranks[5][0]);

        // re-arrange the data for chart 
        foreach ($allsurveys as  $survey) {
            
            for ($i=1; $i <= 10; $i++) {
                $survey->{'q'.$i}==1?$ranks[1][$i]++:$ranks[1][$i];
                $survey->{'q'.$i}==2?$ranks[2][$i]++:$ranks[2][$i];
                $survey->{'q'.$i}==3?$ranks[3][$i]++:$ranks[3][$i];
                $survey->{'q'.$i}==4?$ranks[4][$i]++:$ranks[4][$i];
                $survey->{'q'.$i}==5?$ranks[5][$i]++:$ranks[5][$i];
            }

        }


        $totalamount = $this->Surveycare->countByAll();

        //find average love
        $love = array();
        $sd = array();
        for ($i = 1; $i <= 10; $i++) {

            $x = ($ranks[5][$i]*5 + $ranks[4][$i]*4 + $ranks[3][$i]*3 + $ranks[2][$i]*2 + $ranks[1][$i]*1);
            $xbar = $x/$totalamount->amount;

            $sd[$i] = number_format(sqrt(($ranks[5][$i]*25 + $ranks[4][$i]*16 + $ranks[3][$i]*9 + $ranks[2][$i]*4 + $ranks[1][$i]*1)/$totalamount->amount - pow($xbar,2)),2,'.',''); 

            $love[$i] =  $xbar;
            
        }

        //do_dump($love,'love');
        //do_dump($sd,'sd');
        //find standard deviation

        $data['ranks'] = $ranks;
        $data['love'] = $love;
        $data['sd'] = $sd; 
        $data['amountbysex'] = $this->Surveycare->countBySex(); 
        $data['amountbyarea'] = $this->Surveycare->countByArea(); 
        $data['totalamount'] = $totalamount;
        $data['suggests'] = $this->Surveycare->getAllComments();

        $this->load->view('header',$data);
        $this->load->view('surveycareresult',$data);
        $this->load->view('footer',$data);



    }



        public function fillgrid(){
            $this->home_model->fillgrid();
        }
 
 
        public function create(){
            $this->form_validation->set_rules('name', 'Name', 'required');
            //$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
            //$this->form_validation->set_rules('contact', 'Contact Number', 'required|numeric|max_length[10]|min_length[10]');
            if ($this->form_validation->run() == FALSE){
               echo'<div class="alert alert-danger">'.validation_errors().'</div>';
               exit;
            }
            else{
                $this->home_model->create();
            }
        }
         
        public function edit(){
            $id =  $this->uri->segment(3);
            $this->db->where('id',$id);
            $data['query'] = $this->db->get('curd');
            $data['id'] = $id;
            $this->load->view('edit', $data);
            }
             
        public function update(){
                $res['error']="";
                $res['success']="";
                $this->form_validation->set_rules('name', 'Name', 'required');
                //$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
                //$this->form_validation->set_rules('contact', 'Contact Number', 'required|numeric|max_length[10]|min_length[10]');
                if ($this->form_validation->run() == FALSE){
                $res['error']='<div class="alert alert-danger">'.validation_errors().'</div>';    
                }           
            else{
                $data = array('name'=>  $this->input->post('name'),
                'email'=>$this->input->post('email'),
                'contact'=>$this->input->post('contact'),
                'facebook_link'=>$this->input->post('facebook'));
                $this->db->where('id', $this->input->post('hidden'));
                $this->db->update('curd', $data);
                $data['success'] = '<div class="alert alert-success">ข้อมูลถูกบันทึกเรียบร้อยแล้ว</div>';
            }
            header('Content-Type: application/json');
            echo json_encode($res);
            exit;
        }
 
 
        public function delete(){
            $id =  $this->input->POST('id');
            $this->db->where('id', $id);
            $this->db->delete('curd');
            echo'<div class="alert alert-success">ข้อมูลถูกลบแล้ว</div>';
            exit;
        }

         
       			
}
