<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Security extends CI_Controller {

    public function dashboard() {
        if($this->session->userdata('is_logged_in') and $this->session->userdata('role_id') == 2) {
            $this->load->view('security/dashboard_view');
            $this->load->model('user_model');
            /*
            $data['announcement'] = $this->user_model->get_announcement();
            $this->load->view('user/nav_bar');
            $this->load->view('user/index', $data);
            $this->load->view('user/footer');
            */
        } else {
            $error['error'] = '<div class="alert alert-danger">You we\'re away for some time. Please login again.</div>';
            $this->load->view('login2_view', $error);
        }
    }

    public function permits() {
        $this->load->library('pagination');
        $this->load->model('security_model');

        $config = array();
        $config['base_url']         =   base_url('admin/permits');
        $config['total_rows']       =   $this->security_model->count_permits();
        $config['per_page']         =   $this->security_model->count_permits();

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
        $data['permit'] = $this->security_model->get_permits_with_user_id($config['per_page'], $this->uri->segment(3));
        $data['status'] = $this->security_model->get_permit_status($config['per_page'], $this->uri->segment(3));
        $data['links']  = $this->pagination->create_links();
        $this->load->view('security/permits_view', $data);
    }

    public function semesters() {
        $this->load->model('security_model');
        $data['semester'] = $this->security_model->get_all_semesters();
        $this->load->view('security/semesters_view', $data);
    }

    public function students() {
        $this->load->library('pagination');
        $this->load->model('security_model');

        $config = array();
        $config['base_url']         =   base_url('security/students');
        $config['total_rows']       =   $this->security_model->count_num_students();
        $config['per_page']         =   $this->security_model->count_num_students();

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
        $data['student'] = $this->security_model->get_all_students($config['per_page'], $this->uri->segment(3));
        $data['status'] = $this->security_model->get_students_status($config['per_page'], $this->uri->segment(3));
        $data['links']  = $this->pagination->create_links();
        $this->load->view('security/students_view', $data);
    }

    public function view_student($id) {
        $this->load->model('security_model');
        $data['student'] = $this->security_model->get_student_by_id($id);
        $data['status'] = $this->security_model->get_student_status_by_id($id);
        $data['permit'] = $this->security_model->get_permit_by_user_id($id);
        $data['permit_status'] = $this->security_model->get_permit_status_by_user_id($id);
        $data['parking'] = $this->security_model->get_parking_num_by_user_id($id);
        $this->load->view('security/view_student_view', $data);
    }

    public function view_permit($id) {
        $this->load->model('security_model');
        $data['permit'] = $this->security_model->get_permit_by_id($id);
        $data['permit_status'] = $this->security_model->get_permit_status_by_permit_id($id);
        $data['parking'] = $this->security_model->get_parking_number_by_permit_id($id);
        $data['student'] = $this->security_model->get_user_by_permit_id($id);
        $data['student_status'] = $this->security_model->get_user_status_by_permit_id($id);
        $this->load->view('security/view_permit_view', $data);
    }

    public function parking() {
        $this->load->library('pagination');
        $this->load->model('security_model');

        $config = array();
        $config['base_url']         =   base_url('security/students');
        $config['total_rows']       =   $this->security_model->count_num_students();
        $config['per_page']         =   $this->security_model->count_num_students();

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
        $data['parking'] = $this->security_model->get_all_parking($config['per_page'], $this->uri->segment(3));
        $data['parking_status'] = $this->security_model->get_parking_status($config['per_page'], $this->uri->segment(3));
        $data['links']  = $this->pagination->create_links();
        $this->load->view('security/parking_view', $data);
    }

    public function reports() {
        $this->load->library('pagination');
        $this->load->model('security_model');
        $num_reports = $this->security_model->count_num_reports();
        $config = array();

        $config['base_url']         =   base_url('security/reports');
        $config['total_rows']       =   $num_reports;
        $config['per_page']         =   $num_reports;

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
        $data['report'] = $this->security_model->get_all_reports($config['per_page'], $this->uri->segment(3));
        $data['user'] = $this->security_model->get_all_user_id($config['per_page'], $this->uri->segment(3));
        $data['parking'] = $this->security_model->get_all_parking($config['per_page'], $this->uri->segment(3));
        $data['status'] = $this->security_model->get_all_report_status($config['per_page'], $this->uri->segment(3));
        $data['links']  = $this->pagination->create_links();
        $this->load->view('security/reports_view', $data);
    }

    public function view_report($id) {
        $this->load->model('security_model');
        $data['report'] = $this->security_model->get_report_by_id($id);
        $data['user'] = $this->security_model->get_user_by_report_id($id);
        $data['parking'] = $this->security_model->get_parking_num_by_report_id($id);
        $data['status'] = $this->security_model->get_report_status_by_report_id($id);
        $this->load->view('security/view_report_view', $data);
    }

    public function edit_report_status_validation() {
        $this->load->model('security_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id', 'Report ID', 'required');
        $id = $this->input->post('id');
        if($this->form_validation->run()) {
            $data = array(
                'status_id' => 7
            );
            if($this->security_model->update_report_status_by_id($data, $id)) {
                $this->session->set_flashdata('update_success', 'Report have been updated.');
                redirect('security/view_report/'.$id);
            } else {
                $this->session->set_flashdata('db_error', 'Oops! something went wrong.');
                $this->view_report($id);
            }
        } else {
            $this->session->set_flashdata('update_failed', 'Could not update report status.');
            $this->view_report($id);
        }
    }
}