<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Student_model extends CI_Model {

    public function has_no_permit($id) {
        $this->db->where('user_id', $id);
        $this->db->from('permit');
        $query = $this->db->get();
        if($query->num_rows() == 1) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    public function get_permit_by_user_id($id) {
        $query = $this->db->select('permit.id')
            ->from('permit')
            ->where('user_id', $id)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_permit_semester_by_user_id($id) {
        $query = $this->db->select('semester.value, semester.start_date, semester.end_date')
            ->from('permit')
            ->where('user_id', $id)
            ->join('semester', 'semester.id = permit.semester_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_permit_id_by_user_id($id) {
        $permit = $this->db->select('id')
            ->where('user_id', $id)
            ->get('permit')
            ->row();
        return (isset($permit->id)) ? $permit->id : null;
    }

    public function get_parking_num_by_user_id($id) {
        $permit_id = $this->get_permit_id_by_user_id($id);
        $query = $this->db->select('parking_no')
            ->from('parking')
            ->where('permit_id', $permit_id)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_permit_status_by_user_id($id) {
        $query = $this->db->select('status.value')
            ->from('permit')
            ->where('user_id', $id)
            ->join('status', 'status.id = permit.status_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function insert_permit($data) {
        $this->db->where('status_id', 4);   // WHERE status_id = vacant
        $this->db->from('parking');         // FROM table parking
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            if($this->db->insert('permit', $data)) {
                return $this->db->insert_id();
            } else {
                return FALSE;
            }
        } else {
            return FALSE;
        }
    }

    public function update_parking_status($data) {
        $permit_id = $this->insert_permit($data);
        if($permit_id) {
            $query = $this->db->get('parking');
            $parking_id = 0;
            foreach ($query->result() as $row) {
                if($row->status_id == 4) {
                    $parking_id = $row->id;
                    break;
                }
            }
            $this->db->set('permit_id', $permit_id);
            $this->db->set('status_id', 5);
            $this->db->where('id', $parking_id);
            $this->db->update('parking');
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function update_permit_status() {
        $result = $this->db->select('id')
            ->order_by('id', 'asc')
            ->get('permit')->result_array();
        $permit_ids = array();
        foreach($result as $row) {
            $permit_ids[$row['id']] = $row['id'];
        }

        $this->db->join('semester', 'semester.id = permit.semester_id');
        $query = $this->db->get('permit');
        $curr_date = date('Y-m-d');
        $i = 1;
        foreach($query->result() as $row) {
            $end_date = $row->end_date;
            $this->db->where('permit.id', $permit_ids[$i]);
            if(strtotime($curr_date) > strtotime($end_date)) {
                $this->db->set('status_id', 3);
                $this->db->update('permit');
            }
            $i++;
        }
    }

    public function get_parking_id_by_user_id($id) {
        $permit_id = $this->get_permit_id_by_user_id($id);
        $parking = $this->db->select('id')
            ->where('permit_id', $permit_id)
            ->get('parking')
            ->row();
        return (isset($parking->id)) ? $parking->id : null;
    }

    public function get_profile_by_user_id($id) {
        $query = $this->db->select('user.user_id, user.name, user.email, user.phone_no, date_reg, status.value')
            ->from('user')
            ->where('user.id', $id)
            ->join('status', 'status.id = user.status_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function update_profile_by_user_id($id, $data) {
        $this->db->where('id', $id);
        if($this->db->update('user', $data)) {
            return true;
        } else {
            return false;
        }
    }
    public function has_no_pending_report($id) {
        $this->db->where('user_id', $id);
        $this->db->where('status_id', 6);
        $this->db->from('report');
        $query = $this->db->get();
        if($query->num_rows() > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function generate_report_number() {
        do {
            $pass1 = strtoupper(md5(rand(0, 1000000)));
            $rand_start = rand(5,strlen($pass1));
            if($rand_start == strlen($pass1)) {
                $rand_start = 1;
            }
            $report_no = strtoupper(substr(md5($pass1), $rand_start, 8));
            
            $this->db->where('report_no', $report_no);
            $this->db->from('report');
            $query = $this->db->get();
        } while($query->num_rows() > 0);
        return $report_no;
    }

    public function insert_report($data) {
        $query = $this->db->insert('report', $data);
        if($query) {
            return true;
        } else {
            return false; 
        }
    }
    
}