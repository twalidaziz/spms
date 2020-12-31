<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    // Load admin dashboard
    public function dashboard() {
        // User role is admin
        if($this->session->userdata('is_logged_in') and $this->session->userdata('role_id') == 1) {
            $this->load->view('admin/dashboard_view');
            $this->load->model('user_model');
            /*
            $data['announcement'] = $this->user_model->get_announcement();
            $this->load->view('user/nav_bar');
            $this->load->view('user/index', $data);
            $this->load->view('user/footer');
            */
        } elseif($this->session->userdata('is_logged_in') and $this->session->userdata('role_id') == 3) {
            redirect('student/dashboard_view');
        } else {
            $error['error'] = '<div class="alert alert-danger">You we\'re away for some time. Please login again.</div>';
            $this->load->view('login2_view', $error);
        }
    }

    public function users() {
        $this->load->library('pagination');
        $this->load->model('admin_model');

        $config = array();
        $config['base_url']         =   base_url('admin/users');
        $config['total_rows']       =   $this->admin_model->count_users();
        $config['per_page']         =   $this->admin_model->count_users();

        $config['full_tag_open']    =   '<ul class="pagination pagination-md">';
        $config['full_tag_close']   =   '</ul>';
        $config['num_tag_open']     =   '<li>';
        $config['num_tag_close']    =   '</li>';
        $config['cur_tag_open']     =   '<li class="disabled"><li class="active"><a href="#">';
        $config['cur_tag_close']    =   '<span class="sr-only"></span></a></li>';
        $config['next_tag_open']    =   '<li>';
        $config['next_tag_close']   =   '</li>';
        $config['prev_tag_open']    =   '<li>';
        $config['prev_tag_close']   =   '</li>';
        $config['first_tag_open']   =   '<li>';
        $config['first_tag_close']  =   '</li>';
        $config['last_tag_open']    =   '<li>';
        $config['last_tag_close']   =   '</li>';

        $this->pagination->initialize($config);
        $data['role'] = $this->admin_model->get_roles();
        $data['user']   = $this->admin_model->get_users_with_status($config['per_page'], $this->uri->segment(3));
        $data['table'] = $this->admin_model->get_users($config['per_page'], $this->uri->segment(3));
        $data['num_users'] = $this->admin_model->count_users();
        $data['num_active_users'] = $this->admin_model->count_active_users();
        $data['num_inactive_users'] = $this->admin_model->count_inactive_users();
        $data['links']  = $this->pagination->create_links();
        $this->load->view('admin/users_view', $data);
    }

    public function edit_user($id) {
        $this->load->model('admin_model');
        $data['user'] = $this->admin_model->get_user_by_id($id);
        $data['status'] = $this->admin_model->get_user_status_by_id($id);
        $data['role'] = $this->admin_model->get_user_role_by_id($id);
        $data['permit'] = $this->admin_model->get_permit_by_user_id($id);
        $data['permit_status'] = $this->admin_model->get_permit_status_by_user_id($id);
        $data['parking'] = $this->admin_model->get_parking_number_by_user_id($id);
        $this->load->view('admin/edit_user_view', $data);
    }

    public function edit_user_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|trim');
        $this->form_validation->set_rules('phone_no', 'Phone', 'required|trim');
        $id = $this->input->post('id');
        
        if ($this->form_validation->run()) {
            $data = array(
                'name'      => $this->input->post('name'),
                'email'     => $this->input->post('email'),
                'phone_no'  => $this->input->post('phone_no')
            );
            $this->load->model('admin_model');
            $this->admin_model->update_user($data, $id); // Call update user function with user id and data
            $this->session->set_flashdata('update_success', 'User details updated.');
            redirect('admin/edit_user/'.$id);
        } else {
            $this->session->set_flashdata('update_failed', 'Could not update user details.');
            $this->edit_user($id); // Load and display edit form
        }
    }

    public function add_user_validation() {
        $this->load->model('user_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('user_id', 'User ID', 'required|trim|is_unique[user.user_id]');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('phone_no', 'Phone', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]');
        $this->form_validation->set_rules('role_id', 'Role', 'required');

        if($this->form_validation->run()) {
            $data = array(
                'user_id'   => $this->input->post('user_id'),
                'password'  => md5($this->input->post('password')),
                'name'      => $this->input->post('name'),
                'phone_no'  => $this->input->post('phone_no'),
                'email'     => $this->input->post('email'),
                'role_id'   => $this->input->post('role_id'),
                'date_reg'  => date('Y-m-d'),
                'status_id' => 1
            );

            if($this->user_model->insert_user($data)) {
                $this->session->set_flashdata('add_success', 'User successfully added.');
				redirect('admin/users');
            } else {
                $this->session->set_flashdata('add_failed', 'Oops! something went wrong. Please try again later.');
				redirect('admin/users');
            }
        } else {
            $this->load->view('admin/users_view');
        }
    }

    public function permits() {
        $this->load->library('pagination');
        $this->load->model('admin_model');

        $config = array();
        $config['base_url']         =   base_url('admin/permits');
        $config['total_rows']       =   $this->admin_model->count_permits();
        $config['per_page']         =   $this->admin_model->count_permits();

        $config['full_tag_open']    =   '<ul class="pagination pagination-md">';
        $config['full_tag_close']   =   '</ul>';
        $config['num_tag_open']     =   '<li>';
        $config['num_tag_close']    =   '</li>';
        $config['cur_tag_open']     =   '<li class="disabled"><li class="active"><a href="#">';
        $config['cur_tag_close']    =   '<span class="sr-only"></span></a></li>';
        $config['next_tag_open']    =   '<li>';
        $config['next_tag_close']   =   '</li>';
        $config['prev_tag_open']    =   '<li>';
        $config['prev_tag_close']   =   '</li>';
        $config['first_tag_open']   =   '<li>';
        $config['first_tag_close']  =   '</li>';
        $config['last_tag_open']    =   '<li>';
        $config['last_tag_close']   =   '</li>';

        $this->pagination->initialize($config);
        $data['permit'] = $this->admin_model->get_permits_with_user_id($config['per_page'], $this->uri->segment(3));
        $data['status'] = $this->admin_model->get_permit_status($config['per_page'], $this->uri->segment(3));
        $data['links']  = $this->pagination->create_links();
        $this->load->view('admin/permits_view', $data);
    }

    public function view_permit($id) {
        $this->load->model('admin_model');
        $data['permit'] = $this->admin_model->get_permit_by_id($id);
        $data['permit_status'] = $this->admin_model->get_permit_status_by_permit_id($id);
        $data['parking'] = $this->admin_model->get_parking_number_by_permit_id($id);
        $data['user'] = $this->admin_model->get_user_by_permit_id($id);
        $data['user_status'] = $this->admin_model->get_user_status_by_permit_id($id);
        $data['user_role'] = $this->admin_model->get_user_role_by_permit_id($id);
        $this->load->view('admin/edit_permit_view', $data);
    }

    public function semesters() {
        $this->load->model('admin_model');
        $data['semester'] = $this->admin_model->get_semesters();
        $this->load->view('admin/semesters_view', $data);
    }

    public function edit_semester($id) {
        $this->load->model('admin_model');
        $data['semester'] = $this->admin_model->get_semester_by_id($id);
        $this->load->view('admin/edit_semester_view', $data);
    }

    public function edit_semester_validation() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'required');
        $this->form_validation->set_rules('start_date', 'Start Date', 'required');
        $this->form_validation->set_rules('end_date', 'End Date', 'required');
        $id = $this->input->post('id');
        
        if ($this->form_validation->run()) {
            $data = array(
                'value'         => $this->input->post('name'),
                'start_date'    => $this->input->post('start_date'),
                'end_date'      => $this->input->post('end_date')
            );
            $this->load->model('admin_model');
            $this->admin_model->update_semester($data, $id); // Call update user function with user id and data
            $this->session->set_flashdata('update_success', 'Semester details updated.');
            redirect('admin/edit_semester/'.$id);
        } else {
            $this->session->set_flashdata('update_failed', 'Could not update semester details.');
            $this->edit_semester($id); // Load and display edit form
        }
    }
}