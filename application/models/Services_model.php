<?php
//defined('BASEPATH') OR exit('No direct script access allowed');

class Services_model extends CI_Model
{
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->database();
    }
    
    public function record_opened_count()
    {
        $this->db->where('status <', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_opened_data($limit, $start)
    {
        $this->db->where('status <', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    
    
    public function record_request_inventory_count()
    {
        $this->db->where('status =', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_request_inventory_data($limit, $start)
    {
        $this->db->where('status =', '3');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    
    public function record_drew_out_inventory_count()
    {
        $this->db->where('status =', '4');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_drew_out_inventory_data($limit, $start)
    {
        $this->db->where('status =', '4');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    
    public function record_completed_inventory_count()
    {
        $this->db->where('status =', '5');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_completed_inventory_data($limit, $start)
    {
        $this->db->where('status =', '5');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    public function record_invoiced_services_count()
    {
        $this->db->where('status =', '6');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_invoiced_services_data($limit, $start)
    {
        $this->db->where('status =', '6');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    
    public function record_closed_services_count()
    {
        $this->db->where('status =', '7');
        $this->db->order_by('created_datetime', 'DESC');
        $query = $this->db->get('service_jobs');
        $this->db->save_queries = false;
        
        return $query->num_rows();
    }
    public function fetch_closed_services_data($limit, $start)
    {
        $this->db->where('status =', '7');
        $this->db->order_by('created_datetime', 'DESC');
        $this->db->limit($limit, $start);
        $query = $this->db->get('service_jobs');
        $result = $query->result();
        $this->db->save_queries = false;
        
        return $result;
    }
    
    
    // Generate Invoice Number -- START;
    public function GenerateInvoiceNumber()
    {
        $orderQuery    = $this->db->query("SELECT * FROM service_jobs WHERE invoice_number != '' AND invoice_datetime != '0000-00-00 00:00:00' ORDER BY invoice_number DESC LIMIT 0, 1");
        $orderRows    = $orderQuery->num_rows();
        
        if ($orderRows == 1) {
            
            // Get Last Order Number;
            $orderData_Array    = $orderQuery->result();
            $orderData            = $orderData_Array[0];
            $last_order_numb    = $orderData->invoice_number;
            
            // Get Year and Month from last PO Number;
            $position_date    = 6;
            $last_or_date    = substr($last_order_numb, 0, $position_date);
            
            // Get Current Year and Month;
            $current_or_date = date("ymd", time());
            
            // If it is the same month;
            if ($last_or_date == $current_or_date) {
                
                // Make Number Only;
                $position            = 4; // Define how many character you want to display.
                $last_four_digit    = substr($last_order_numb, 7, $position);
                
                $final_four_digit    = $last_four_digit + 1;
                
                $final_po_date            = date("ymd", time());
                $final_po_last_four    = str_pad($final_four_digit, 4, "0", STR_PAD_LEFT);
    
                $order_no = $final_po_date."-".$final_po_last_four;
            } else {
                $date = date("ymd", time());
                $input = 1;
                $num = str_pad($input, 4, "0", STR_PAD_LEFT);
        
                $order_no = $date."-".$num;
            }
        } else {
            $date = date("ymd", time());
            $input = 1;
            $num = str_pad($input, 4, "0", STR_PAD_LEFT);
    
            $order_no = $date."-".$num;
        }
        
        return $order_no;
    }
    // Generate Invoice Number -- END;
}
