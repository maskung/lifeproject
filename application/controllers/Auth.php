<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//location: application/controller/auth.php
 
class Auth extends CI_Controller {
        public function __construct() {
            parent::__construct();
            $this->load->Model('Auth_model');
            $this->load->Model('Week');
        }
 
        public function index()
    {
		    $week = $this->Week->getWeek();
			$data['week'] = $week; 
			$this->load->model('People');
			//$data['peoples'] = $this->People->getPeopleByWeek($week->week_start,$week->week_end);
			$data['peoples'] = $this->People->getPeopleByWeek('2016-03-12','2016-12-31');
			//do_dump($data);
            $this->load->view('login',$data);
    }
         
        public function logout(){
            $this->session->sess_destroy();
            redirect('/' ,'refresh');
            exit;
        }
         
        public function login(){
            $username =  $this->input->post('username');
            $password =  $this->input->post('password');
             
            //call the model for auth
            if($this->Auth_model->login($username, $password)){
            }
            else{
                echo'something went wrong';
            }
        }
         
         
}
 
/* End of file auth.php */
/* Location: ./application/controllers/auth.php */
