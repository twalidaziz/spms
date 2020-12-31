<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student extends CI_Controller {

    // Load admin dashboard
    public function dashboard() {
        // User role is admin
        if($this->session->userdata('is_logged_in') and $this->session->userdata('role_id') == 3) {
            $this->load->view('student/dashboard_view');
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

    public function my_permit() {
        $this->load->model('student_model');
        $id = $this->session->userdata('id');
        $data['parking'] = $this->student_model->get_parking_num_by_user_id($id);
        $data['permit'] = $this->student_model->get_permit_by_user_id($id);
        $data['semester'] = $this->student_model->get_permit_semester_by_user_id($id);
        $data['status'] = $this->student_model->get_permit_status_by_user_id($id);
        $this->load->view('student/my_permit_view', $data);
    }

    public function apply_permit() {
        $this->load->model('user_model');
        $data['semester'] = $this->user_model->get_all_semester();
        $this->load->view('student/apply_permit_view', $data);
    }

    public function apply_permit_validation() {
        $this->load->model('student_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('semester_id', 'Semester', 'required');
        if($this->form_validation->run()) {
            $data = array(
                'user_id'       => $this->session->userdata('id'),
                'semester_id'   => $this->input->post('semester_id'),
                'status_id'     => 1
            );
            $user_id = $this->session->userdata('id');
            // Check user currently has no permit
            if($this->student_model->has_no_permit($user_id)) {
                // Permit application successful
                if($this->student_model->update_parking_status($data)) {
                    $this->session->set_flashdata('apply_success', 'Your permit application was successful!');
                    redirect('student/apply_permit');
                // All parking spots occupied
                } else {
                    $this->session->set_flashdata('apply_failed', 'No parking spots available.');
                    redirect('student/apply_permit');
                }
            // User already have a permit
            } else {
                $this->session->set_flashdata('has_permit', 'You already have a permit.');
                redirect('student/apply_permit');
            }
        } else {
            $this->load->view('student/apply_permit_view');
        }
    }

    public function profile($id) {
        $this->load->model('student_model');
        $id = $this->session->userdata('id');
        $data['user'] = $this->student_model->get_profile_by_user_id($id);
        $this->load->view('student/edit_profile_view', $data);
    }

    public function edit_profile_validation() {
        $this->load->model('student_model');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('phone_no', 'Phone', 'required|trim');
        $id = $this->session->userdata('id');

        if($this->form_validation->run()) {
            $data = array(
                'email'     => $this->input->post('email'),
                'phone_no'  => $this->input->post('phone_no')
            );
            if($this->student_model->update_profile_by_user_id($id, $data)) {
                $this->session->set_userdata($data);
                $this->session->set_flashdata('update_success', 'Your profile was updated.');
                redirect('student/profile/'.$id);
            } else {
                $this->session->set_flashdata('db_error', 'Oops! Something went wrong. PLease try again later.');
                $this->profile($id);
            }
        } else {
            $this->session->set_flashdata('update_failed', 'Could not update profile.');
            $this->profile($id);
        }
    }

    public function file_report() {
        $this->load->model('student_model');
        $user_id = $this->session->userdata('id');
        if($this->student_model->has_no_pending_report($user_id)) {
            $this->load->view('student/file_report_view');
        } else {
            $this->session->set_flashdata('has_pending_report', 'You have a pending report that is still ongoing');
            redirect('student/dashboard');
        }
    }

    public function file_report_validation() {
        $this->load->model('student_model');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('description', 'Description', 'required');
        if($this->form_validation->run()) {
            $id = $this->session->userdata('id');
            $data = array(
                'user_id'       => $id,
                'report_no'     => $this->student_model->generate_report_number(),
                'description'   => $this->input->post('description'),
                'date'          => date('Y-m-d'),
                'parking_id'    => $this->student_model->get_parking_id_by_user_id($id),
                'status_id'     => 6
            );
            if($this->student_model->insert_report($data)) {
                $this->session->set_flashdata('file_report_success', 'Your report have been submitted.');
                $this->load->view('student/file_report_view');
            } else {
                $this->session->set_flashdata('file_report_failed', 'Oops! Something went wrong. PLease try again later.');
                $this->load->view('student/file_report_view');
            }
        } else {
            $this->load->view('student/file_report_view');
        }
    }
}