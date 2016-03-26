
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller 
{

	public function __construct()
 	{
 		parent::__construct();
 		$this->load->model("Admin/Da_TIN_influencer");
 	
 	}

 	/* check if user login
     *
 	 */
 	private function check_isvalidated()
 	{

 		// if user has login session return true
		if(isset($_SESSION['admin_name']))
		{
			return true;
		} 
		else 
		{
			return false;
		}

			
		
	}
	public function index()
	{	
		
 		if ($this->check_isvalidated() == true)
 		{
 			redirect('admin/influencer');
 		}
 		else
 		{
 			//$this->session->set_flashdata('msg1', '<div class="alert alert-danger text-center">Pless login!</div>');
 			redirect('admin/login_form');

 		}
    }
    public function login_form()
	{	
		
	 	// set page title
		$data['title'] = "TIN | HOME";
		//$this->load->view('header',$data);
		$this->load->view('admin/login',$data);
		//$this->load->view('footer');
 	
    }
    public function login()
    {
    	//get the posted values
		$data = array(
        	$admin_name = $this->input->post("admin_name"),
       		$admin_password = $this->input->post("admin_password"),
		);

		//set validations
        $this->form_validation->set_rules("admin_name", "Username", "trim|required");
        $this->form_validation->set_rules("admin_password", "Password", "trim|required");
        $this->form_validation->set_message("required","กรุณากรอกข้อมูล %s");

         // if form login is null
        if ($this->form_validation->run() == FALSE)
        {
 			
 			//validation fails
		    $data['title'] = "TIN | HOME";
			$this->load->view('header',$data);
			$this->load->view('admin/login_view',$data);
			$this->load->view('footer');
        }
        // if form login is not null
        else
        {
			//check if username and password is correct

                $usr_result = $this->Da_TIN_influencer->get_user($admin_name, $admin_password);
                if ($usr_result > 0) //active user record is present
                {
                    //set the session variables
                    $sessiondata = array(
                        'admin_name' => $admin_name,
                        'loginuser' => TRUE
                    );
                    // Add user data in session
                    $this->session->set_userdata($sessiondata); 
                    //$this->influencer();
               		redirect('/admin/influencer');
                   
                }
                else
                {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid username and password!</div>');
                    redirect('/admin/index');
                }

        }
    
    }  

    // Logout from admin page
	public function logout() 
	{
		
		$sess_array = array
		(
			'admin_name' ,
			'loginuser' 
		);
		// removing session data
		$this->session->unset_userdata($sess_array);
		redirect('/admin/index');
        
	} 



}
?>
