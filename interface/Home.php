<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	
	public function index()
	{
		
		if($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data['name'] = $session_data['name'];
            
			$this->load->model('Searchexport','',TRUE);
			$data['record'] = $this->Searchexport->getRecord($session_data['id']);
            $this->load->view('common/header');
            $this->load->view('dashboard', $data);
            $this->load->view('common/footer');
            }
            else{
                redirect('welcome', 'refresh');
        }
        
	}
}
