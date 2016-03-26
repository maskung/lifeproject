<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//location: application/models/auth_model.php
class Auth_model extends CI_Model {
     
     
    public function login($name, $password){
    $password = sha1($password);
	    $this->db->join('groups', 'auth.group_id = groups.group_id');
        $this->db->where('username',$name);
        $this->db->where('password',$password);
        $query = $this->db->get('auth');
        if($query->num_rows()==1){
            foreach ($query->result() as $row){
                $data = array(
                            'username'=> $row->username,
                            'groupname'=> $row->group_name,
                            'logged_in'=>TRUE
                        );
            }
            $this->session->set_userdata($data);
            return TRUE;
        }
        else{
            return FALSE;
      }    
    }
     
    public function isLoggedIn(){
            header("cache-Control: no-store, no-cache, must-revalidate");
            header("cache-Control: post-check=0, pre-check=0", false);
            header("Pragma: no-cache");
            header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
            $is_logged_in = $this->session->userdata('logged_in');
 
            if(!isset($is_logged_in) || $is_logged_in!==TRUE)
            {
                redirect('/Auth');
                exit;
            }
    }
     
}
