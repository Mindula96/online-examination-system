<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		
		$this->load->library('form_validation');
		$this->load->view('register');
	}

	public function createAccount(){
			
			$this->load->library('form_validation');
			$this->form_validation->set_rules('fullname', 'Full Name', 'required');
			$this->form_validation->set_rules('password', 'Password', 'trim|required',
					array('required' => 'You must provide a %s.')
			);
			$this->form_validation->set_rules('cpassword', 'Password Confirmation', 'trim|required|matches[password]');
			$this->form_validation->set_rules('email', 'Email Address', 'trim|required|valid_email');

			if ($this->form_validation->run() == FALSE)
			{
					$this->load->view('register');
			}
			else
			{
				$data = array(
					'name' => $this->input->post('fullname'),
					'email' => $this->input->post('email'),
					'password' => $this->input->post('password')
				);
				$this->load->model('user', '', TRUE);
				$email = $this->input->post('email');
				if (!$this->form_validation->is_unique($email, 'tbl_users.email')) {
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">The email is already taken, choose another one.</div>');
					redirect('register', $data);
				}else{
					$this->user->create($data);
					$this->session->set_flashdata('msg', '<div class="alert alert-success text-center">Account is created successfully Please Login!.</div>');
					redirect('welcome', $data);
				}

			}
		}
	}

