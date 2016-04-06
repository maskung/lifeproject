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
        $this->load->model('home_model');
        $this->load->library('form_validation');
        $this->load->Model('Auth_model');
        $this->load->Model('Week');
        $this->load->Model('People');
        $this->load->Model('Prize');
		
	}
	/**
 	 * index page show on default
     */
	public function index() {
		$data['title'] = "บันทึการเฝ้าเดี่ยวแห่งคริสตจักรพันธสัญญากรุงเทพ";

        //check user logged in or not
        //$this->Auth_model->isLoggedIn();
	    $week = $this->Week->getWeek();
		$data['week'] = $week; 
		//$this->load->view('home',$data);
        
        $this->load->view('addstudent',$data);
        
	}

        public function fillgrid(){
		    $week = $this->Week->getWeek();
			$data['week'] = $week; 
            $this->home_model->fillgrid($week->week_start,$week->week_end);
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

		public function fortune() {

			// find current week  id
			$week = $this->Week->getWeek();

			// get days of last 
			$lastweek = $this->Week->getWeekByID($week->week_id-1);
			$data['week'] = $lastweek; 

			//get people who already get prize in this week
			$peoplewon = $this->Prize->getWeekPrize();
			$data['peoplewons'] = $peoplewon;

			//make string exception for prize
			$exceptids = "";
			$lastarray = end($peoplewon);
			foreach ($peoplewon as $peoplew) {

				$exceptids .= $peoplew->id;
			    if ($lastarray->id != $peoplew->id) {
					$exceptids .= ",";
				} 
			}

			//$data['people'] = $this->People->getPrizeByWeek('2016-02-28', '2016-03-04');
			$won = $this->People->getPrizeByWeek($lastweek->week_start, $lastweek->week_end, 0, $exceptids);
			$data['people'] = $won;
			//do_dump($data['peoples']);
			// insert people to prize hall
			$this->Prize->recordPrize($won->id, $won->name, $won->email);

			
			$this->load->view('prize',$data);

		}

		public function p() {

			// find current week  id
			$week = $this->Week->getWeek();

			//get people who already get prize in this week
			$peoplewon = $this->Prize->getWeekPrize();
			$data['peoplewons'] = $peoplewon;

			// get days of last 
			$lastweek = $this->Week->getWeekByID($week->week_id-1);
			$data['week'] = $lastweek; 

			$data['weekcounts'] = $this->People->countGroupByWeek($lastweek->week_start, $lastweek->week_end, 0 );
			//find amount of people in week by group	

			$this->load->view('preprize',$data);
		}

		public function clear() {

			$this->Prize->clearPrize();

			$this->p();

		}
         
       			
}
