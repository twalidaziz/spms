<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function get_users($limit, $offset) {
        $this->db->limit($limit, $offset);
        $query = $this->db->select('*')
            ->from('user')
            ->order_by('id', 'asc')
            ->get();
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_users_with_status($limit, $offset) {
        $this->db->limit($limit, $offset);
        $query = $this->db->select('*')
            ->from('user')
            ->order_by('user.id', 'asc')
            ->join('status', 'status.id = user.status_id')
            ->get();
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function count_users() {
        return $this->db->count_all('user');
    }

    public function count_active_users() {
        $this->db->from('user');
        $this->db->where('status_id', 1);
        return $this->db->count_all_results();
    }

    public function count_inactive_users() {
        $this->db->from('user');
        $this->db->where('status_id', 2);
        return $this->db->count_all_results();
    }

    public function count_permits() {
        return $this->db->count_all('permit');
    }

    public function get_user_by_id($id) {
        $query = $this->db->select('*')
            ->from('user')
            ->where('id', $id)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_user_status_by_id($id) {
        $query = $this->db->select('status.value')
            ->from('user')
            ->where('user.id', $id)
            ->join('status', 'status.id = user.status_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_user_role_by_id($id) {
        $query = $this->db->select('role.value')
            ->from('user')
            ->where('user.id', $id)
            ->join('role', 'role.id = user.role_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_permit_by_user_id($id) {
        $query = $this->db->select('semester.value, semester.start_date, semester.end_date')
            ->from('permit')
            ->where('permit.user_id', $id)
            ->join('semester', 'semester.id = permit.semester_id')
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
            ->where('permit.user_id', $id)
            ->join('status', 'status.id = permit.status_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_permit_id_by_user_id($id) {
        $permit = $this->db->select('id')
            ->where('user_id', $id)
            ->get('permit')
            ->row();
        return (isset($permit->id)) ? $permit->id : null;
    }

    public function get_parking_number_by_user_id($id) {
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

    public function update_user($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('user', $data);
    }

    public function get_roles() {
        $query = $this->db->select('*')
            ->from('role')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_permits_with_user_id($limit, $offset) {
        $this->db->limit($limit, $offset);
        $query = $this->db->select('permit.id, user.user_id, semester.value')
            ->from('permit')
            ->order_by('permit.id', 'asc')
            ->join('user', 'user.id = permit.user_id')
            ->join('semester', 'semester.id = permit.semester_id')
            ->get();
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_permit_status($limit, $offset) {
        $this->db->limit($limit, $offset);
        $query = $this->db->select('status.value')
            ->from('permit')
            ->order_by('permit.id', 'asc')
            ->join('status', 'status.id = permit.status_id')
            ->get();
        if($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_permit_by_id($id) {
        $query = $this->db->select('user.user_id, semester.value, semester.start_date, semester.end_date')
            ->from('permit')
            ->where('permit.id', $id)
            ->join('user', 'user.id = permit.user_id')
            ->join('semester', 'semester.id = permit.semester_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_permit_status_by_permit_id($id) {
        $query = $this->db->select('status.value')
            ->from('permit')
            ->where('permit.id', $id)
            ->join('status', 'status.id = permit.status_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_parking_number_by_permit_id($id) {
        $query = $this->db->select('parking_no')
            ->from('parking')
            ->where('permit_id', $id)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_user_by_permit_id($id) {
        $query = $this->db->select('user.user_id, user.name, user.phone_no, user.email, user.date_reg')
            ->from('permit')
            ->where('permit.id', $id)
            ->join('user', 'user.id = permit.user_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function get_user_table_id_by_permit_id($id) {
        $permit = $this->db->select('user_id')
            ->where('permit.id', $id)
            ->get('permit')
            ->row();
        return (isset($permit->user_id)) ? $permit->user_id : null;
    }

    public function get_user_status_by_permit_id($id) {
        $user_id = $this->get_user_table_id_by_permit_id($id);
        $query = $this->db->select('status.value')
            ->from('user')
            ->where('user.id', $user_id)
            ->join('status', 'status.id = user.status_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_user_role_by_permit_id($id) {
        $user_id = $this->get_user_table_id_by_permit_id($id);
        $query = $this->db->select('role.value')
            ->from('user')
            ->where('user.id', $user_id)
            ->join('role', 'role.id = user.role_id')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_semesters() {
        $query = $this->db->select('*')
            ->from('semester')
            ->order_by('id', 'asc')
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return null;
        }
    }

    public function get_semester_by_id($id) {
        $query = $this->db->select('*')
            ->from('semester')
            ->where('id', $id)
            ->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return $query->result();
        }
    }

    public function update_semester($data, $id) {
        $this->db->where('id', $id);
        $this->db->update('semester', $data);
    }
}