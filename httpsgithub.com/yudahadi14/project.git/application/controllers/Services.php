
<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Services extends CI_Controller
{
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
     *
     * @see http://codeigniter.com/user_guide/general/urls.html
     */
    public function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->library('session');
        $this->load->model('Services_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->library('pagination');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
    }

    public function index()
    {
        redirect(base_url().'dashboard', 'refresh');
    }



    
    // *************************** View Page -- START *************************** //
    
    // Open New Service;
    public function new_service()
    {
        $this->load->view("service_new");
    }
    // View Step 2;
    public function second_step()
    {
        //$cust 		= $this->input->post("customer");
        $nama_merchant        = strip_tags($this->input->get("nama_merchant"));
        
        if (empty($nama_merchant)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Search Cars', "Silakan Isi Nama Merchant!"));
            redirect(base_url().'services/new_service');
        }
        $data["nama_merchant"]        = $nama_merchant;
        
        $this->load->view("service_choose_car", $data);
    }
    // View Step 3;
    
    public function third_step()
    {
        if (isset($_GET["url_car_id"])) {
            $car                = strip_tags($this->input->get("url_car_id"));
        } else {
            $car                = strip_tags($this->input->post("car"));
            //$problem            = strip_tags($this->input->post("problem"));   
        }
        $problem        = strip_tags($this->input->post("problem"));

        
        $data["car_id"]        = $car;
        $data["problem"]    = $problem;
        $this->load->view("service_choose_package", $data);
    }
    // view Fourth Step;
    
    public function fourth_step()
    {
        $car_id        = strip_tags($this->input->post("car_id"));
          // $pack_id        = $this->input->post("pack_id");
        $problem        = strip_tags($this->input->post("problem"));
        
        if (empty($problem)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'New Service', "Please enter your car Mileage!"));
            redirect(base_url().'services/third_step?url_car_id='.$car_id, 'refresh');
            die();
        }
        /*
        $pack_list        = "";
        for ($p = 0; $p < count($pack_id); $p++) {
            if (!empty($pack_id[$p])) {
                $pack_list    .= $pack_id[$p].",";
            }
        }
        $pack_list        = trim($pack_list, ",");
        */
        $data["car_id"]        = $car_id;
        //$data["pack_list"]    = $pack_list;
       $data["problem"]    = $problem;
        
      $this->load->view("service_choose_technician", $data);
   } 
    // View Fifth Step;
    public function fifth_step()
    {
        $car_id        = strip_tags($this->input->post("car_id"));
      //  $pack_list        = strip_tags($this->input->post("pack_list"));
        $problem        = strip_tags($this->input->post("problem"));
        
       // $tyres            = strip_tags($this->input->post("tyres"));
       // $steering        = strip_tags($this->input->post("steering"));
       // $engine        = strip_tags($this->input->post("engine"));
       // $suspension    = strip_tags($this->input->post("suspension"));
       // $battery        = strip_tags($this->input->post("battery"));
       // $others        = strip_tags($this->input->post("others"));  
        
        $data["car_id"]                = $car_id;
      //  $data["pack_list"]            = $pack_list;
        $data["problem"]            = $problem;
      //  $data["tyres"]                = $tyres;
      //  $data["steering"]            = $steering;
      //  $data["engine"]                = $engine;
      //  $data["suspension"]            = $suspension;
      //  $data["battery"]            = $battery;
      //  $data["others"]                = $others;
        
        $this->load->view("service_verify", $data);
    }

    // View Verify Step;
    public function verify_step()
    {
        $car_id        = strip_tags($this->input->post("car_id"));
       // $pack_list        = strip_tags($this->input->post("pack_list"));
        $problem        = strip_tags($this->input->post("problem"));
        
       // $tyres            = strip_tags($this->input->post("tyres"));
       // $steering        = strip_tags($this->input->post("steering"));
       // $engine        = strip_tags($this->input->post("engine"));
       // $suspension    = strip_tags($this->input->post("suspension"));
       // $battery        = strip_tags($this->input->post("battery"));
       // $others        = strip_tags($this->input->post("others"));
        
        $tech            = strip_tags($this->input->post("tech"));
        
        $data["car_id"]                = $car_id;
       // $data["pack_list"]            = $pack_list;
        $data["problem"]            = $problem;
        //$data["tyres"]                = $tyres;
        //$data["steering"]            = $steering;
        //$data["engine"]                = $engine;
        //$data["suspension"]            = $suspension;
        //$data["battery"]            = $battery;
        //$data["others"]                = $others;
        $data["tech"]                = $tech;
        
        $this->load->view("service_verify", $data);
    }
    
    // View Service Confirmation;
    public function service_confirmation()
    {
        $job_id        = strip_tags($this->input->get("job_id"));
        
        $settingResult    = $this->db->get_where('site_setting');
        $settingData    = $settingResult->row();
        
        $data["job_id"]            = $job_id;
        $data["dateformat"]        = $settingData->datetime_format;
        $this->load->view("service_confirmation", $data);
    }
    
    // Print Service Confirmation;
    public function print_service_confirmation()
    {
        $job_id        = strip_tags($this->input->get("job_id"));
        
        $settingResult    = $this->db->get_where('site_setting');
        $settingData    = $settingResult->row();
        
        $data["job_id"]            = $job_id;
        $data["dateformat"]        = $settingData->datetime_format;
        $this->load->view("service_confirmation_print", $data);
    }
    
    // Opened Service;
    public function opened_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'services/opened_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Services_model->record_opened_count();
        $config['per_page']        = $pagination_limit;
        $config['uri_segment']        = 3;

        $config['full_tag_open']    = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close']    = '</ul>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']    = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']    = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']    = '</li>';
        $config['first_tag_open']    = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']    = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Services_model->fetch_opened_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Services_model->record_opened_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Services_model->record_opened_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Services_model->record_opened_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('opened_services', $data);
    }
    
    // View Opened Service;
    public function view_opened_service()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        
        $data["job_id"]            = $job_id;
        $this->load->view("opened_services_view", $data);
    }
    
    // View Request Inventory Service;
    public function request_inventory_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'services/request_inventory_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Services_model->record_request_inventory_count();
        $config['per_page']        = $pagination_limit;
        $config['uri_segment']        = 3;

        $config['full_tag_open']    = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close']    = '</ul>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']    = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']    = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']    = '</li>';
        $config['first_tag_open']    = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']    = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Services_model->fetch_request_inventory_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Services_model->record_request_inventory_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Services_model->record_request_inventory_count().' entries';
        } else {
            $start_sh    = $page + 1;
            $end_sh    = $page + count($data['results']);
            $sh_text    = "Showing $start_sh to $end_sh of ".$this->Services_model->record_request_inventory_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('request_inventory_services', $data);
    }
    // View Requested Inventory;
    public function request_inventory_services_view()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        
        $data["job_id"]            = $job_id;
        $this->load->view('request_inventory_services_view', $data);
    }
    
    
    // View Drew Out Inventory Service;
    public function drew_out_inventory_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'services/drew_out_inventory_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Services_model->record_drew_out_inventory_count();
        $config['per_page']        = $pagination_limit;
        $config['uri_segment']        = 3;

        $config['full_tag_open']    = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close']    = '</ul>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']    = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']    = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']    = '</li>';
        $config['first_tag_open']    = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']    = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Services_model->fetch_drew_out_inventory_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Services_model->record_drew_out_inventory_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Services_model->record_drew_out_inventory_count().' entries';
        } else {
            $start_sh    = $page + 1;
            $end_sh    = $page + count($data['results']);
            $sh_text    = "Showing $start_sh to $end_sh of ".$this->Services_model->record_drew_out_inventory_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('drew_out_inventory_services', $data);
    }
    // View Drew Out Inventory Service View Detail;
    public function drew_out_inventory_services_view()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        
        $data["job_id"]            = $job_id;
        $this->load->view('drew_out_inventory_services_view', $data);
    }
    
    // View Completed Service;
    public function completed_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'services/completed_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Services_model->record_completed_inventory_count();
        $config['per_page']        = $pagination_limit;
        $config['uri_segment']        = 3;

        $config['full_tag_open']    = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close']    = '</ul>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']    = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']    = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']    = '</li>';
        $config['first_tag_open']    = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']    = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Services_model->fetch_completed_inventory_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Services_model->record_completed_inventory_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Services_model->record_completed_inventory_count().' entries';
        } else {
            $start_sh    = $page + 1;
            $end_sh    = $page + count($data['results']);
            $sh_text    = "Showing $start_sh to $end_sh of ".$this->Services_model->record_completed_inventory_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('completed_inventory_services', $data);
    }
    // View Completed Service Detail;
    public function completed_services_view()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        
        $data["job_id"]            = $job_id;
        $this->load->view('completed_inventory_services_view', $data);
    }
    
    // Invoice Services;
    public function invoiced_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'services/invoiced_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Services_model->record_invoiced_services_count();
        $config['per_page']        = $pagination_limit;
        $config['uri_segment']        = 3;

        $config['full_tag_open']    = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close']    = '</ul>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']    = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']    = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']    = '</li>';
        $config['first_tag_open']    = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']    = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Services_model->fetch_invoiced_services_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Services_model->record_invoiced_services_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Services_model->record_invoiced_services_count().' entries';
        } else {
            $start_sh    = $page + 1;
            $end_sh    = $page + count($data['results']);
            $sh_text    = "Showing $start_sh to $end_sh of ".$this->Services_model->record_invoiced_services_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('invoiced_services', $data);
    }
    // View Invoice Service;
    public function invoiced_services_view()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        $data["system_tax"]        = $paginationData[0]->tax;
        
        $data["job_id"]            = $job_id;
        $this->load->view('invoiced_services_view', $data);
    }
    
    // View Closed Service;
    public function closed_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'services/closed_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Services_model->record_closed_services_count();
        $config['per_page']        = $pagination_limit;
        $config['uri_segment']        = 3;

        $config['full_tag_open']    = "<ul class='pagination pagination-right margin-none'>";
        $config['full_tag_close']    = '</ul>';
        $config['num_tag_open']    = '<li>';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']    = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close']    = "<span class='sr-only'></span></a></li>";
        $config['next_tag_open']    = '<li>';
        $config['next_tagl_close']    = '</li>';
        $config['prev_tag_open']    = '<li>';
        $config['prev_tagl_close']    = '</li>';
        $config['first_tag_open']    = '<li>';
        $config['first_tagl_close'] = '</li>';
        $config['last_tag_open']    = '<li>';
        $config['last_tagl_close']    = '</li>';

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['results'] = $this->Services_model->fetch_closed_services_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Services_model->record_closed_services_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Services_model->record_closed_services_count().' entries';
        } else {
            $start_sh    = $page + 1;
            $end_sh    = $page + count($data['results']);
            $sh_text    = "Showing $start_sh to $end_sh of ".$this->Services_model->record_closed_services_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('closed_services', $data);
    }
    
    // View Closed Service View;
    public function closed_services_view()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        $data["system_tax"]        = $paginationData[0]->tax;
        
        $data["job_id"]            = $job_id;
        $this->load->view('closed_services_view', $data);
    }
    
    // View First Before Generate Invoice;
    public function generateInvoice()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        $data["tax_percent"]    = $paginationData[0]->tax;
        
        $data["job_id"]            = $job_id;
        $this->load->view('generate_invoice', $data);
    }
    
    // View To Make Payment;
    public function paymentInvoice()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        
        $data["job_id"]            = $job_id;
        $this->load->view('service_payment', $data);
    }
    
    // Print Invoice;
    public function print_service_invoice()
    {
        $job_id                = strip_tags($this->input->get("job_id"));
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]        = $paginationData[0]->datetime_format;
        
        $data["job_id"]            = $job_id;
        $this->load->view('service_print_invoice', $data);
    }
    
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    // Submit Payment;
    public function submitServicePayment()
    {
        $job_id            = $this->input->post("job_id");
        $invoice_numb        = $this->input->post("invoice_numb");
        $grandTotal        = $this->input->post("grandTotal");
        $payment_action    = $this->input->post("payment_action");
        
        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        if ($payment_action == "1") {                // Full Payment;
            $full_payment_type        = $this->input->post("full_payment_type");
            $full_cheque_numb        = $this->input->post("full_cheque_numb");
            
            $payment_name            = "";
            $paymentNameData        = $this->Constant_model->getDataOneColumn("payment_method", "id", $full_payment_type);
            $payment_name            = $paymentNameData[0]->name;
            
            $ins_payment_data        = array(
                    "service_job_id"            =>    $job_id,
                    "invoice_numb"                =>    $invoice_numb,
                    "payment_type_id"            =>    $full_payment_type,
                    "payment_type_name"            =>    $payment_name,
                    "payment_amount"            =>    $grandTotal,
                    "cheque_number"                =>    $full_cheque_numb,
                    "created_user_id"            =>    $us_id,
                    "created_datetime"            =>    $tm
            );
            $this->Constant_model->insertData("service_job_payments", $ins_payment_data);
        } elseif ($payment_action == "2") {        // Split Payment;
            $split_pay_type_array        = $this->input->post("split_payment_type");
            $split_pay_amt_array        = $this->input->post("split_payment_amt");
            $split_pay_cheque_array    = $this->input->post("split_cheque_numb");
            
            for ($j = 0; $j < count($split_pay_type_array); $j++) {
                $split_pay_type        = $split_pay_type_array[$j];
                $split_pay_amt            = $split_pay_amt_array[$j];
                $split_pay_cheque_numb    = $split_pay_cheque_array[$j];
                
                if (!empty($split_pay_type)) {
                    $split_pay_type_name    = "";
                    $splitPayNameData        = $this->Constant_model->getDataOneColumn("payment_method", "id", $split_pay_type);
                    $split_pay_type_name    = $splitPayNameData[0]->name;
                
                    $ins_split_pay_data    = array(
                            "service_job_id"            =>    $job_id,
                            "invoice_numb"                =>    $invoice_numb,
                            "payment_type_id"            =>    $split_pay_type,
                            "payment_type_name"            =>    $split_pay_type_name,
                            "payment_amount"            =>    $split_pay_amt,
                            "cheque_number"                =>    $split_pay_cheque_numb,
                            "created_user_id"            =>    $us_id,
                            "created_datetime"            =>    $tm
                    );
                    $this->Constant_model->insertData("service_job_payments", $ins_split_pay_data);
                }
            }
        }
        
        // Update Service Job Status;
        $upd_service_job_data        = array(
                "updated_user_id"            =>    $us_id,
                "updated_datetime"            =>    $tm,
                "status"                    =>    "7",
                "payment_action"            =>    "$payment_action",
                "vt_status"                    =>    "1"
        );
        $this->Constant_model->updateData("service_jobs", $upd_service_job_data, $job_id);
        
        $this->session->set_flashdata('alert_msg', array('success', 'Make Payment', "Successfully Made Payment for Job Id : $job_id"));
        redirect(base_url().'services/closed_services_view?job_id='.$job_id);
    }
    
    // Generate Invoice;
    public function submitGenerateInvoice()
    {
        $job_id            = $this->input->post("job_id");
        $discountTotal        = $this->input->post("discountTotal");
        $discount_percent    = $this->input->post("discount_percentage");
        $subTotal            = $this->input->post("subTotal");
        $taxTotal            = $this->input->post("taxTotal");
        $grandTotal        = $this->input->post("grandTotal");
        
        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        $invoice_numb        = "";
        $invoice_numb        = $this->Services_model->GenerateInvoiceNumber();
        
        $upd_service_job_data    = array(
                  "invoice_number"            =>    $invoice_numb,
                  "discount_percentage"        =>    $discount_percent,
                  "discount_amt"                =>    $discountTotal,
                  "subtotal_amt"                =>    $subTotal,
                  "tax_amt"                    =>    $taxTotal,
                  "grandtotal_amt"            =>    $grandTotal,
                  "invoice_user_id"            =>    $us_id,
                  "invoice_datetime"            =>    $tm,
                  "updated_user_id"            =>    $us_id,
                  "updated_datetime"            =>    $tm,
                  "status"                    =>    "6"
        );
        if ($this->Constant_model->updateData("service_jobs", $upd_service_job_data, $job_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Generate Invoice', "Successfully Generated Invoice for Job Id : $job_id"));
            redirect(base_url().'services/invoiced_services_view?job_id='.$job_id);
        }
    }
    
    // Issue Material -- START;
    public function issueMaterial()
    {
        $job_id            = $this->input->post("job_id");
        
        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        $reqDefectResult    = $this->db->query("SELECT * FROM service_job_defects_material WHERE service_job_id = '$job_id' AND customer_approved = '0' ORDER BY id DESC ");
        $reqDefectData        = $reqDefectResult->result();
        for ($rd = 0; $rd < count($reqDefectData); $rd++) {
            $sjdm_id        = $reqDefectData[$rd]->id;
            $mat_id        = $reqDefectData[$rd]->material_id;
            
            $def_qty        = strip_tags($this->input->post("sjdm_qty_$sjdm_id"));
            $def_price        = strip_tags($this->input->post("sjdm_price_$sjdm_id"));
            
            $matDtaData    = $this->Constant_model->getDataOneColumn("materials", "id", $mat_id);
            $mat_cost        = $matDtaData[0]->cost;
            
            // Deduct from Inventory -- START;
            $getInvResult        = $this->db->query("SELECT * FROM inventory WHERE materials_id = '$mat_id' ");
            $getInvRows        = $getInvResult->num_rows();
            if ($getInvRows == 1) {
                $getInvData    = $getInvResult->result();
                
                $get_inv_id    = $getInvData[0]->id;
                $get_inv_qty    = $getInvData[0]->quantity;
                
                unset($getInvData);
                
                $after_deduct    = 0;
                $after_deduct    = $get_inv_qty - $def_qty;
                
                $upd_inv_data    = array(
                        "quantity"        =>    $after_deduct
                );
                $this->Constant_model->updateData("inventory", $upd_inv_data, $get_inv_id);
            } else {
                $after_deduct    = 0;
                $after_deduct    = 0 - $def_qty;
                
                $ins_inv_data    = array(
                        "materials_id"        =>    $mat_id,
                        "quantity"            =>    $after_deduct
                );
                $this->Constant_model->insertData("inventory", $ins_inv_data);
            }
            unset($getInvResult);
            unset($getInvRows);
            // Deduct from Inventory -- END;
            
            $upd_ref_def_mat_data    = array(
                    "issued_qty"                =>    $def_qty,
                    "cost"                        =>    $mat_cost,
                    "price"                        =>    $def_price,
                    "issued_user_id"            =>    $us_id,
                    "issued_datetime"            =>    $tm,
                    "customer_approved"            =>    "1",
                    "status"                    =>    "1"
            );
            $this->Constant_model->updateData("service_job_defects_material", $upd_ref_def_mat_data, $sjdm_id);
            
            unset($sjdm_id);
            unset($mat_id);
        }
        unset($reqDefectData);
        unset($reqDefectResult);
        
        
        $reqpackageResult    = $this->db->query("SELECT * FROM service_job_package_material WHERE service_job_id = '$job_id' AND request_approved = '0' ORDER BY id DESC ");
        $reqpackageData    = $reqpackageResult->result();
        for ($rp = 0; $rp < count($reqpackageData); $rp++) {
            $sjpm_id        = $reqpackageData[$rp]->id;
            $mat_id        = $reqpackageData[$rp]->material_id;
            
            $pack_issue_qty = strip_tags($this->input->post("sjpm_qty_$sjpm_id"));
            
            $matDtaData    = $this->Constant_model->getDataOneColumn("materials", "id", $mat_id);
            $mat_cost        = $matDtaData[0]->cost;
            
            // Deduct from Inventory -- START;
            $getInvResult        = $this->db->query("SELECT * FROM inventory WHERE materials_id = '$mat_id' ");
            $getInvRows        = $getInvResult->num_rows();
            if ($getInvRows == 1) {
                $getInvData    = $getInvResult->result();
                
                $get_inv_id    = $getInvData[0]->id;
                $get_inv_qty    = $getInvData[0]->quantity;
                
                unset($getInvData);
                
                $after_deduct    = 0;
                $after_deduct    = $get_inv_qty - $pack_issue_qty;
                
                $upd_inv_data    = array(
                        "quantity"        =>    $after_deduct
                );
                $this->Constant_model->updateData("inventory", $upd_inv_data, $get_inv_id);
            } else {
                $after_deduct    = 0;
                $after_deduct    = 0 - $pack_issue_qty;
                
                $ins_inv_data    = array(
                        "materials_id"        =>    $mat_id,
                        "quantity"            =>    $after_deduct
                );
                $this->Constant_model->insertData("inventory", $ins_inv_data);
            }
            unset($getInvResult);
            unset($getInvRows);
            // Deduct from Inventory -- END;
            
            $upd_ser_pack_mat_data    = array(
                    "issued_qty"            =>    $pack_issue_qty,
                    "cost"                    =>    $mat_cost,
                    "price"                    =>    "0.00",
                    "issued_user_id"        =>    $us_id,
                    "issued_datetime"        =>    $tm,
                    "request_approved"        =>    "1",
                    "status"                =>    "1"
            );
            $this->Constant_model->updateData("service_job_package_material", $upd_ser_pack_mat_data, $sjpm_id);
            
            unset($sjpm_id);
            unset($mat_id);
        }
        unset($reqpackageResult);
        unset($reqpackageData);
        
        // Update Service Job Status;
        $upd_service_job_data    = array(
                "updated_user_id"            =>    $us_id,
                "updated_datetime"            =>    $tm,
                "status"                    =>    "4"
        );
        if ($this->Constant_model->updateData("service_jobs", $upd_service_job_data, $job_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Issue Material', "Successfully issued Materials for Job Id : #$job_id."));
            redirect(base_url().'services/request_inventory_services');
        }
    }
    // Issue Material -- END;
    
    // Request Request Materials for Packages -- START;
    public function rejectPackageMaterial()
    {
        $sjpm_id            = strip_tags($this->input->get("sjpm_id"));
        $job_id            = strip_tags($this->input->get("job_id"));
        
        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        $ckPackageMaterialResult    = $this->db->query("SELECT * FROM service_job_package_material WHERE service_job_id = '$job_id' AND id = '$sjpm_id' ");
        $ckPackageMaterialRows        = $ckPackageMaterialResult->num_rows();
        if ($ckPackageMaterialRows == 0) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Delete', "Error on deleting Package Request Material! Please try again!"));
            redirect(base_url().'services/request_inventory_services_view?job_id='.$job_id);
        } else {
            $upd_package_material_data    = array(
                      "request_approved"        =>    "2"
            );
            $this->Constant_model->updateData("service_job_package_material", $upd_package_material_data, $sjpm_id);
            
            $this->session->set_flashdata('alert_msg', array('success', 'Delete', "Successfully removed Service Package Request Material."));
            redirect(base_url().'services/request_inventory_services_view?job_id='.$job_id);
        }
        unset($ckPackageMaterialResult);
        unset($ckPackageMaterialRows);
    }
    // Request Request Materials for Packages -- END;
    
    // Reject Request Materials for Report Defects -- START;
    public function rejectDefectMaterial()
    {
        $sjdm_id            = strip_tags($this->input->get("sjdm_id"));
        $job_id            = strip_tags($this->input->get("job_id"));
        
        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        $ckdefectMaterialResult    = $this->db->query("SELECT * FROM service_job_defects_material WHERE id = '$sjdm_id' AND service_job_id = '$job_id' ");
        $ckdefectMaterialRows        = $ckdefectMaterialResult->num_rows();
        if ($ckdefectMaterialRows == 0) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Delete', "Error on deleting Report Defects Request Material! Please try again!"));
            redirect(base_url().'services/request_inventory_services_view?job_id='.$job_id);
        } else {
            $upd_defect_material_data    = array(
                    "customer_approved"        =>    "2"
            );
            $this->Constant_model->updateData("service_job_defects_material", $upd_defect_material_data, $sjdm_id);
            
            $this->session->set_flashdata('alert_msg', array('success', 'Delete', "Successfully removed Report Defects Request Material."));
            redirect(base_url().'services/request_inventory_services_view?job_id='.$job_id);
        }
        unset($ckdefectMaterialResult);
        unset($ckdefectMaterialRows);
    }
    // Reject Request Materials for Report Defects -- END;
    
    // Submit Open New Service;
    public function confirmService()
    {
        $car_id        = strip_tags($this->input->post("car_id"));
        $pack_list    = strip_tags($this->input->post("pack_list"));
        $mileage    = strip_tags($this->input->post("mileage"));
        
        $tyres        = strip_tags($this->input->post("tyres"));
        $steering    = strip_tags($this->input->post("steering"));
        $engine    = strip_tags($this->input->post("engine"));
        $suspension = strip_tags($this->input->post("suspension"));
        $battery    = strip_tags($this->input->post("battery"));
        $others    = strip_tags($this->input->post("others"));
        
        $tech        = strip_tags($this->input->post("tech"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        $carDtaData        = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
        $car_plate_numb    = $carDtaData[0]->plate_number;
        $car_before_mileage    = $carDtaData[0]->mileage;
        $car_owner_id        = $carDtaData[0]->owner_id;
        
        $ownerDtaData        = $this->Constant_model->getDataOneColumn("customers", "id", $car_owner_id);
        $owner_fn            = $ownerDtaData[0]->firstname;
        $owner_ln            = $ownerDtaData[0]->lastname;
        $owner_nric        = $ownerDtaData[0]->nric;
        $owner_email        = $ownerDtaData[0]->email;
        $owner_mobile        = $ownerDtaData[0]->mobile;
        
        $ins_service_data    = array(
                  "invoice_number"            =>    "",
                  "service_advisor_id"        =>    $us_id,
                  "technician_id"                =>    $tech,
                  "customer_id"                =>    $car_owner_id,
                  "firstname"                    =>    $owner_fn,
                  "lastname"                    =>    $owner_ln,
                  "email"                        =>    $owner_email,
                  "mobile"                    =>    $owner_mobile,
                  "car_id"                    =>    $car_id,
                  "car_plate_number"            =>    $car_plate_numb,
                  "mileage_before"            =>    $car_before_mileage,
                  "mileage_after"                =>    $mileage,
                  "created_user_id"            =>    $us_id,
                  "created_datetime"            =>    $tm,
                  "status"                    =>    "1"
        );
        $job_id        = $this->Constant_model->insertDataReturnLastId("service_jobs", $ins_service_data);
        
        // Service Job Package -- START;
        $pack_array    = explode(",", $pack_list);
        for ($p    = 0; $p < count($pack_array); $p++) {
            $pack_id        = $pack_array[$p];
            
            if (!empty($pack_id)) {
                $packDtaData    = $this->Constant_model->getDataOneColumn("service_packages", "id", $pack_id);
                $pack_name        = $packDtaData[0]->name;
                $pack_price    = $packDtaData[0]->price;
                $pack_type        = $packDtaData[0]->car_make_type;
                $pack_discount    = $packDtaData[0]->discount_applicable;
                
                $ins_pack_data    = array(
                          "service_job_id"            =>    $job_id,
                          "package_id"                =>    $pack_id,
                          "package_name"                =>    $pack_name,
                          "package_price"                =>    $pack_price,
                          "package_type"                =>    $pack_type,
                          "discount_applicable"        =>    $pack_discount,
                          "status"                    =>    "0"
                );
                $this->Constant_model->insertData("service_job_packages", $ins_pack_data);
            }
        }
        // Service Job Package -- END;
    
        // Service Job Defects -- START;
        if (!empty($tyres)) {
            $ins_tyres_data    = array(
                    "service_job_id"        =>    $job_id,
                    "defect_id"                =>    "1",
                    "defect_name"            =>    "Tyres",
                    "remarks"                =>    $tyres,
                    "status"                =>    "0"
            );
            $this->Constant_model->insertData("service_job_defects", $ins_tyres_data);
        }
        if (!empty($steering)) {
            $ins_steering_data    = array(
                    "service_job_id"        =>    $job_id,
                    "defect_id"                =>    "2",
                    "defect_name"            =>    "Steering",
                    "remarks"                =>    $steering,
                    "status"                =>    "0"
            );
            $this->Constant_model->insertData("service_job_defects", $ins_steering_data);
        }
        if (!empty($engine)) {
            $ins_engine_data    = array(
                    "service_job_id"        =>    $job_id,
                    "defect_id"                =>    "3",
                    "defect_name"            =>    "Engine",
                    "remarks"                =>    $engine,
                    "status"                =>    "0"
            );
            $this->Constant_model->insertData("service_job_defects", $ins_engine_data);
        }
        if (!empty($suspension)) {
            $ins_suspension_data    = array(
                    "service_job_id"        =>    $job_id,
                    "defect_id"                =>    "4",
                    "defect_name"            =>    "Suspension",
                    "remarks"                =>    $suspension,
                    "status"                =>    "0"
            );
            $this->Constant_model->insertData("service_job_defects", $ins_suspension_data);
        }
        if (!empty($battery)) {
            $ins_battery_data    = array(
                    "service_job_id"        =>    $job_id,
                    "defect_id"                =>    "5",
                    "defect_name"            =>    "Battery",
                    "remarks"                =>    $battery,
                    "status"                =>    "0"
            );
            $this->Constant_model->insertData("service_job_defects", $ins_battery_data);
        }
        if (!empty($others)) {
            $ins_others_data    = array(
                    "service_job_id"        =>    $job_id,
                    "defect_id"                =>    "6",
                    "defect_name"            =>    "Others",
                    "remarks"                =>    $others,
                    "status"                =>    "0"
            );
            $this->Constant_model->insertData("service_job_defects", $ins_others_data);
        }
        // Service Job Defects -- END;
        
        $this->session->set_flashdata('alert_msg', array('success', 'Open New Service', "Successfully Opened New Service for Plate Number : $car_plate_numb"));
        redirect(base_url().'services/service_confirmation?job_id='.$job_id);
    }
    
    
    // Add Customer & Car from Open Service Page -- START;
    public function AddCustomerCar()
    {
        $nric            = strip_tags($this->input->post("nric"));
        $fn            = strip_tags($this->input->post("fn"));
        $ln            = strip_tags($this->input->post("ln"));
        $mb            = strip_tags($this->input->post("mb"));
        
        $plate_numb        = strip_tags($this->input->post("plate_numb"));
        $car_make        = strip_tags($this->input->post("car_make"));
        $car_model        = strip_tags($this->input->post("car_model"));
        $chassis        = strip_tags($this->input->post("chassis"));
        $color            = strip_tags($this->input->post("color"));
        $mileage        = strip_tags($this->input->post("mileage"));
        $transmission    = strip_tags($this->input->post("transmission"));
        
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        // Check Plate Numb;
        $ckPlateResult    = $this->db->query("SELECT * FROM cars WHERE plate_number = '$plate_numb' ");
        $ckPlateRows    = $ckPlateResult->num_rows();
        if ($ckPlateRows == 0) {
            $ckICResult        = $this->db->query("SELECT id FROM customers WHERE nric = '$nric' ");
            $ckICRows            = $ckICResult->num_rows();
            if ($ckICRows == 0) {
                $ins_cust_data    = array(
                        "firstname"            =>    $fn,
                        "lastname"            =>    $ln,
                        "nric"                =>    $nric,
                        "mobile"            =>    $mb,
                        "customer_group"    =>    "1",
                        "created_user_id"    =>    $us_id,
                        "created_datetime"    =>    $tm,
                        "status"            =>    "1"
                );
                $cust_id    = $this->Constant_model->insertDataReturnLastId("customers", $ins_cust_data);
            } else {
                $ckICData    = $ckICResult->result();
                
                $cust_id    = $ckICData[0]->id;
                
                unset($ckICData);
            }
            unset($ckICResult);
            unset($ckICRows);
            
            $ins_car_data    = array(
                    "owner_id"            =>    $cust_id,
                    "car_model"            =>    $car_model,
                    "car_make_id"        =>    $car_make,
                    "plate_number"        =>    $plate_numb,
                    "color"                =>    $color,
                    "chassis_number"    =>    $chassis,
                    "registration_date"    =>    "0000-00-00",
                    "transmission"        =>    $transmission,
                    "mileage"            =>    $mileage,
                    "photo_name"        =>    "no_image.jpg",
                    "created_user_id"    =>    $us_id,
                    "created_datetime"    =>    $tm,
                    "status"            =>    "1"
            );
            $car_id        = $this->Constant_model->insertDataReturnLastId("cars", $ins_car_data);
            
            $this->session->set_flashdata('alert_msg', array('success', 'Open New Service', "Successfully Added Plate Number $plate_numb with Owner $fn $ln."));
            redirect(base_url().'services/second_step?plate='.$plate_numb);
        } else {
            $this->session->set_flashdata('alert_msg', array('success', 'Open New Service', "Plate Number : <b>$plate_numb</b> is already existing in the system!"));
            redirect(base_url().'services/new_service');
        }
        unset($ckPlateResult);
        unset($ckPlateRows);
    }
    // Add Customer & Car from Open Service Page -- END;
    
    // *************************** Action to DB -- END *************************** //
    
    
    public function getMaterialQty()
    {
        $mat_id    = strip_tags($this->input->get("mat_id"));
        $mat_sku    = strip_tags($this->input->get("mat_sku"));
        
        $inv_qty            = 0;
        
        $inventoryResult    = $this->db->query("SELECT * FROM inventory WHERE materials_id = '$mat_id' AND sku = '$mat_sku' ");
        $inventoryRows        = $inventoryResult->num_rows();
        if ($inventoryRows == 1) {
            $inventoryData    = $inventoryResult->result();
            
            $inv_qty        = $inventoryData[0]->quantity;
            
            unset($inventoryData);
        }
        unset($inventoryResult);
        unset($inventoryRows);
        
        $response = array(
            'quantity'    =>    $inv_qty,
            'errorMsg'    =>    'success',
        );
        echo json_encode($response);
    }
}
