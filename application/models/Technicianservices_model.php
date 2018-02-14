<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Technicianservices_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    public function record_opened_count()
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status <', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }

    public function fetch_opened_data($limit, $start)
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status <', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    public function record_requested_material_count()
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status = ', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_requested_material_data($limit, $start)
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status = ', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    
    public function record_drew_out_material_count()
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status = ', '4');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_drew_out_material_data($limit, $start)
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status = ', '4');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    
    
    public function record_completed_service_count()
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status >= ', '5');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_completed_service_data($limit, $start)
    {
        $temp_user_id        = $this->session->userdata('user_id');
        $temp_user_role    = $this->session->userdata('user_role');
        
        if ($temp_user_role == 3) {
            $this->db->where('technician_id = ', $temp_user_id);
        }
        
        $this->db->where('status >= ', '5');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
}
