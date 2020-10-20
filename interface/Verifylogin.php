<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class VerifyLogin extends CI_Controller {

 function __construct()
 {
   parent::__construct();
   $this->load->model('user','',TRUE);
   $this->load->helper('security');
 }


 function index()
 {
   //This method will have the credentials validation
   $this->load->library('form_validation');

   $this->form_validation->set_rules('username', 'Email', 'required');
   $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

   if($this->form_validation->run() == FALSE)
   {
     //Field validation failed.  User redirected to login page
    $this->load->view('welcome_message');
    
   }
   else
   {
     
   // print_r($this->session->userdata('logged_in'));
    //Go to private area
    redirect('home', 'refresh');
   }

 }

 function check_database($password)
 {
   //Field validation succeeded.  Validate against database
  $username = $this->input->post('username');
   //query the database
   $result = $this->user->login($username, $password);
  //  var_dump($result);
  //var_dump($result);
   if($result)
   {
     $sess_array = array();
     foreach($result as $row)
     {
       $sess_array = array(
           'id' => $row['id'],
           'name' => $row['name'],
           'email'=>$row['email']
       );
       $this->session->set_userdata('logged_in', $sess_array);
     }

     
     return TRUE;
   }
   else
   {
     $this->form_validation->set_message('check_database', 'Invalid username or password');
     $this->session->set_flashdata('msg', '<div class="alert alert-danger text-center">Invalid Email or Password!.</div>');	
               
     return false;
   }
 }
}
