<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
    
    public function is_logged_in($user_id, $password) {
        $this->db->where('user_id', $user_id); // WHERE user_id is equal to input user ID
        $this->db->where('password', md5($password)); // WHERE password is equal to input password
        $this->db->from('user'); // FROM table user
        $query = $this->db->get(); // Call get function and store in variable query
        
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return FALSE;
        }
    }

    public function get_all_semester() {
        $result = $this->db->select('id, value')->get('semester')->result_array();
        $semester = array();
        
        foreach($result as $row) {
            $semester[$row['id']] = $row['value'];
        }  
        return $semester;
    }

    public function insert_user($data) {
        $query = $this->db->insert('user', $data);
        if($query) {
            return true;
        } else {
            return false; 
        }
    }

    public function get_account_status_by_user_id($id) {
        $query = $this->db->select('status.value')
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
    
    /*
    //Add temporary user and unique key
    public function add_temp_user($key)
    {
        $data = array(
            'email'     => $this->input->post('email'),
            'password'  => md5($this->input->post('password')),
            'key'       => $key,
            'name'      => $this->input->post('name'),
            'user_id'   => $this->input->post('user_id'),
            'phone'     => $this->input->post('phone'),
        );
        
        $query = $this->db->insert('temp_user', $data); //Insert user data into 'temp_user' table
        
        if ($query)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    //Validate unique key
    public function is_valid_key($key)
    {
        $this->db->where('key', $key);
        $query = $this->db->get('temp_user'); //Get user from 'temp_user' table
        
        if ($query->num_rows() == 1) //If unique key is valid 
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }
    
    //Add user with valid key
    public function add_user($key)
    {
        $this->db->where('key', $key); //WHERE key
        $temp_user = $this->db->get('temp_user'); //Get user from 'temp_user' table
        
        if ($temp_user)
        {
            $row = $temp_user->row();
            
            $data = array(
                'email'         => $row->email,
                'password'      => $row->password,
                'name'          => $row->name,
                'user_id'       => $row->user_id,
                'phone'         => $row->phone,
                'level'    => 'User' //Set 'user_level' value as User 
            );
            
            $user_added = $this->db->insert('user', $data); //Insert user data into 'user' table in the database
        }
        //If successfully insert user into user table
        if ($user_added) 
        {
            $this->db->where('key', $key); //WHERE key
            $this->db->delete('temp_user'); //Delete user data from 'temp_user' table
            
            return $data['email'];
        }
        return FALSE;
    }
    
    //Insert user id 
    public function insert_user($data)
    {
        $this->db->insert('user', $data); //Insert data into 'user' table
        $id = $this->db->insert_id(); //Set user id and insert into database
        
        return (isset($id)) ? $id : FALSE;
    }
    
    public function insert_message($data)
    {
        $this->db->insert('message', $data); //Insert data into 'user' table
    }
    
    public function insert_announcement($data)
    {
        $this->db->insert('announcement', $data); //Insert data into 'user' table
    }
    
    public function insert_inquiry($data)
    {
        $this->db->insert('inquiries', $data);
    }
    
    //Count user for pagination
    public function count_user()
    {
        return $this->db->count_all('user'); //Count all user in 'user' table
    }
    
    public function count_announcement()
    {
        return $this->db->count_all('announcement'); //Count all user in 'user' table
    }
    
    public function count_active_agents()
    {
        $this->db->where('status =', 'Active');
        $this->db->from('user');
        return $this->db->count_all_results();
    }
    
    public function User()
    {
        $this->db->where('status =', 'Inactive');
        $this->db->from('user');
        return $this->db->count_all_results();
    }
    
    public function count_probation_agents()
    {
        $this->db->where('status =', 'Probation');
        $this->db->from('user');
        return $this->db->count_all_results();
    }
    
    public function count_local_agents()
    {
        $this->db->where('user_id =', '');
        $this->db->from('user');
        return $this->db->count_all_results();
    }
    
    public function count_international_agents()
    {
        $this->db->where('user_id !=', '');
        $this->db->from('user');
        return $this->db->count_all_results(); //Count all user in 'user' table
    }
    
     public function count_all_mail()
    {
        $this->db->where('receiver_id =', $this->session->userdata('id'));
        $this->db->from('message');
        return $this->db->count_all_results();
    }
    
    public function count_primary_mail()
    {
        $this->db->where('type =', 'Primary');
        $this->db->where('receiver_id =', $this->session->userdata('id'));
        $this->db->from('message');
        return $this->db->count_all_results();
    }
    
    public function count_important_mail()
    {
        $this->db->where('type =', 'Important');
        $this->db->where('receiver_id =', $this->session->userdata('id'));
        $this->db->from('message');
        return $this->db->count_all_results();
    }
    
    public function get_dropdown_list()
    {
        $result = $this->db->select('id, name')->get('user')->result_array();
        $user = array();
        
        foreach ($result as $row)
            {
                $user[$row['id']] = $row['name'];
            }  
        return $user; 
    }
    
    public function get_all_mail()
    {
        $this->db->select('*');
        $this->db->from('message');
        $this->db->where('receiver_id =', $this->session->userdata('id'));
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    public function get_primary_mail()
    {
        $this->db->where('type =', 'Primary');
        $this->db->where('receiver_id =', $this->session->userdata('id'));
        $this->db->from('message');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    public function get_important_mail()
    {
        $this->db->where('type =', 'Important');
        $this->db->where('receiver_id =', $this->session->userdata('id'));
        $this->db->from('message');
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    public function get_announcement()
    {
        $query = $this->db->get('announcement'); //Fetch user from 'user' table
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    public function get_mail_reply($id)
    {
        $this->db->select('*'); //SELECT all          
        $this->db->from('message'); //FROM table user        
        $this->db->where('id', $id ); //WHERE id
        $query = $this->db->get(); //Call get function and store data in variable query
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    //Get user for pagination
    public function get_user($limit, $offset)
    {
        $this->db->limit($limit, $offset);
        $query = $this->db->get('user'); //Fetch user from 'user' table
        
        if($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    //Get user for update process
    public function get_user_update($id)
    {
        $this->db->select('*'); //SELECT all          
        $this->db->from('user'); //FROM table user        
        $this->db->where('id', $id ); //WHERE id
        $query = $this->db->get(); //Call get function and store data in variable query
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    public function get_user_id_from_email($email)
    {
        $this->db->select('id');
        $this->db->from('user');
        $this->db->where('email', $email);
        
        return $this->db->get()->row('id');
    }
    
    public function get_user_id($id)
    {
        $this->db->from('user');
        $this->db->where('id', $id);
        
        return $this->db->get()->row();
    }
    
    public function get_announcement_update($id)
    {
        $this->db->select('*'); //SELECT all          
        $this->db->from('announcement'); //FROM table user        
        $this->db->where('id', $id ); //WHERE id
        $query = $this->db->get(); //Call get function and store data in variable query
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    
    public function update_user_profile($id, $data)
    {
        if (!empty($data))
        {
            $this->db->where('id', $id);
            return $this->db->update('user', $data);
        }
        
        return FALSE;
    }
    
    //Update user data
    public function update_user($user, $id)
    {
        $this->db->where('id', $id); //WHERE id
        $this->db->update('user', $user); //UPDATE 'user' table
    }
    
    public function update_announcement($announcement, $id)
    {
        $this->db->where('id', $id); //WHERE id
        $this->db->update('announcement', $announcement); //UPDATE 'user' table
    }
    
    public function search_name($name)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->like('name', $name);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return $query->result();
        }
    }
    */
}
