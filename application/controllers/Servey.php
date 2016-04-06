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

class Servey extends CI_Controller {

	public function __construct(){
		parent::__construct();
        $this->load->model('home_model');
        $this->load->library('form_validation');
        $this->load->Model('Auth_model');
        $this->load->Model('Week');
        $this->load->Model('People');
		
	}
	/**
 	 * index page show on default
     */
	public function index() {
		$data['title'] = "แบบสำรวจความพึงพอใจในกลุ่มแคร์";

        //check user logged in or not
        //$this->Auth_model->isLoggedIn();
	    $week = $this->Week->getWeek();
		$data['week'] = $week; 
		//$this->load->view('home',$data);
        
        $this->load->view('servey',$data);
        
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
 
 
        

				
         
       			
}
