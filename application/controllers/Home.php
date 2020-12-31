<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	
	public function index() { $this->login(); }

	public function login() {
		$this->load->model('student_model');
		$error['error'] = '';
		// User role is Admin
		if($this->session->userdata('is_logged_in') and ($this->session->userdata('role_id') == 1)) {
			$this->student_model->update_permit_status();
			redirect('admin/dashboard');	// Redict to admin page
		} elseif($this->session->userdata('is_logged_in') and ($this->session->userdata('role_id') == 2)) {
			$this->student_model->update_permit_status();
			redirect('security/dashboard'); 	// Redirect to agent page
		} elseif($this->session->userdata('is_logged_in') and ($this->session->userdata('role_id') == 3)) {
			$this->student_model->update_permit_status();
			redirect('student/dashboard'); 	// Redirect to agent page
		} else {
			$this->student_model->update_permit_status();
			$this->load->view('login2_view', $error); // Load login form with error message
		}
	}

	// Validate login form
	public function login_validation() {
		$this->load->library('form_validation');
		
		// Set form validation rules
		$this->form_validation->set_rules('user_id', 'User ID', 'required|trim|callback_validate_credentials');
		$this->form_validation->set_rules('password', 'Password', 'required|md5|trim');

		// If form validation is false
		if ($this->form_validation->run() == FALSE) {
			$this->index(); 					// Redirect back to login page
		} else {
			// If user role is Admin
			if($this->session->userdata('role_id') == 1) {
				redirect('admin/dashboard');	// Redirect to admin page 
			} elseif($this->session->userdata('role_id') == 2) {
				redirect('security/dashboard');
			} elseif($this->session->userdata('role_id') == 3) {
				redirect('student/dashboard');	// Redirect to student page
			} else { 
				echo "FAILED.";
			}
		}
	}

	// Validate login credentials
	public function validate_credentials() {
		$user_id = $this->input->post('user_id');
		$password = $this->input->post('password');
		
		$this->load->model('user_model');
		
		$result = $this->user_model->is_logged_in($user_id, $password);
		
		if($result) {
			foreach($result as $user) {
				$data = array();
				$data['is_logged_in']   = 1; 		// Only one user can be logged-in at one time
				$data['id']             = $user->id;
				$data['user_id']		= $user->user_id;
				$data['password']       = $user->password;
				$data['name']           = $user->name;
				$data['phone_no']       = $user->phone_no;
				$data['email']          = $user->email;
				$data['date_reg']     	= $user->date_reg;
				$data['status_id']      = $user->status_id;
				$data['permit_id']      = $user->permit_id;
				$data['role_id']        = $user->role_id;
				$this->session->set_userdata($data); // Set user session for each user data
			}
		} else {	// User ID or password does not match
			$this->form_validation->set_message('validate_credentials', '<div style="color:red">Invalid credentials</div>');
			return FALSE;
		}
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('home/login');
	}
	
	public function signup() {
		$this->load->view('signup_view');
	}

	public function signup_validation() {
		$this->load->model('user_model');
		$this->load->library('form_validation'); //load form validation library
            
		// Set form validation rules
		$this->form_validation->set_rules('user_id', 'User ID', 'required|trim|is_unique[user.user_id]');
		$this->form_validation->set_rules('password', 'Password', 'required|trim');
		$this->form_validation->set_rules('name', 'Name', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('phone_no', 'Phone', 'required|trim');
		
		// If email address already exists display message
		$this->form_validation->set_message('is_unique', '<div class="red-text">Email address already exists.</div>');
        if($this->form_validation->run()) {
			$data = array(
                'user_id'	=> $this->input->post('user_id'),
                'password'  => md5($this->input->post('password')),
                'name'      => $this->input->post('name'),
				'email'     => $this->input->post('email'),
				'phone_no'  => $this->input->post('phone_no'),
                'date_reg'	=> date('Y-m-d'),
                'status_id' => 1,
                'role_id'	=> 3
			);

			if($this->user_model->insert_user($data)) {
				$this->session->set_flashdata('signup_success', 'Registration successful! Please log in.');
				redirect('home/login');
			} else {
				$this->session->set_flashdata('signup_failed', 'Registration unsuccessful. Please try again later.');
				redirect('home/signup');
			}
		} else {
			$this->load->view('signup_view');
		}   
	}
}
