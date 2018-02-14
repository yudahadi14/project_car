<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Technician_services extends CI_Controller
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
        $this->load->model('Technicianservices_model');
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
    
    // View Tech Opened Service;
    public function tech_opened_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'technician_services/tech_opened_service/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Technicianservices_model->record_opened_count();
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

        $data['results'] = $this->Technicianservices_model->fetch_opened_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Technicianservices_model->record_opened_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Technicianservices_model->record_opened_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Technicianservices_model->record_opened_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('tech_opened_services', $data);
    }
    
    // View Need to do After Started Job;
    public function tech_opened_services_view()
    {
        $job_id                    = strip_tags($this->input->get("job_id"));
        
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        $data["job_id"]                = $job_id;
        
        $this->load->view("tech_opened_services_view", $data);
    }
    
    // View Requested Material Service Jobs;
    public function tech_requested_inventory_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'technician_services/tech_requested_inventory_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Technicianservices_model->record_requested_material_count();
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

        $data['results'] = $this->Technicianservices_model->fetch_requested_material_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Technicianservices_model->record_requested_material_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Technicianservices_model->record_requested_material_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Technicianservices_model->record_requested_material_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('tech_requested_material_services', $data);
    }
    
    public function tech_requested_inventory_services_view()
    {
        $job_id                    = strip_tags($this->input->get("job_id"));
        
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        $data["job_id"]                = $job_id;
        $this->load->view("tech_requested_material_services_view", $data);
    }
    
    
    // View Drew Out Inventory Service;
    public function tech_drew_out_inventory_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'technician_services/tech_drew_out_inventory_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Technicianservices_model->record_drew_out_material_count();
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

        $data['results'] = $this->Technicianservices_model->fetch_drew_out_material_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Technicianservices_model->record_drew_out_material_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Technicianservices_model->record_drew_out_material_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Technicianservices_model->record_drew_out_material_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('tech_drew_out_material_services', $data);
    }
    // View Drew Out Inventory Service Detail;
    public function tech_drew_out_inventory_services_view()
    {
        $job_id                    = strip_tags($this->input->get("job_id"));
        
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        $data["job_id"]                = $job_id;
        $this->load->view("tech_drew_out_material_services_view", $data);
    }
    
    
    // View Completed Service;
    public function tech_completed_services()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'technician_services/tech_completed_services/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Technicianservices_model->record_completed_service_count();
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

        $data['results'] = $this->Technicianservices_model->fetch_completed_service_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Technicianservices_model->record_completed_service_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Technicianservices_model->record_completed_service_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Technicianservices_model->record_completed_service_count().' entries';
        }

        $data['displayshowingentries'] = $sh_text;
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        
        $this->load->view('tech_completed_services', $data);
    }
    
    // View Completed Service Detail;
    public function tech_completed_services_view()
    {
        $job_id                    = strip_tags($this->input->get("job_id"));
        
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $data["dateformat"]            = $paginationData[0]->datetime_format;
        $data["job_id"]                = $job_id;
        $this->load->view("tech_completed_services_view", $data);
    }
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    // Complete Service;
    public function completeService()
    {
        $job_id        = $this->input->post("job_id");
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        $upd_service_job_data    = array(
                  "ended_user_id"            =>    $us_id,
                  "ended_datetime"            =>    $tm,
                  "status"                    =>    "5"
        );
        $this->Constant_model->updateData("service_jobs", $upd_service_job_data, $job_id);
        
        $packResult    = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $packData        = $packResult->result();
        for ($p = 0; $p < count($packData); $p++) {
            $pack_id    = $packData[$p]->id;
            
            $upd_ser_pack_data    = array(
                      "ended_user_id"            =>    $us_id,
                      "ended_datetime"        =>    $tm
            );
            $this->Constant_model->updateData("service_job_packages", $upd_ser_pack_data, $pack_id);
            
            unset($pack_id);
        }
        unset($packResult);
        unset($packData);
        
        $defectResult        = $this->db->query("SELECT * FROM service_job_defects WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $defectData        = $defectResult->result();
        for ($d = 0; $d < count($defectData); $d++) {
            $defect_id        = $defectData[$d]->id;
            
            $upd_defect_data    = array(
                      "ended_user_id"        =>    $us_id,
                      "ended_datetime"    =>    $tm
            );
            $this->Constant_model->updateData("service_job_defects", $upd_defect_data, $defect_id);
            
            unset($defect_id);
        }
        unset($defectResult);
        unset($defectData);
        
        $this->session->set_flashdata('alert_msg', array('success', 'Complete Service', "Successfully completed Service for Job Id : #$job_id."));
        redirect(base_url().'technician_services/tech_drew_out_inventory_services');
    }
    
    // Start Job;
    public function startJob()
    {
        $job_id        = $this->input->post("job_id");
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        $upd_started_job_data    = array(
                  "updated_user_id"        =>    $us_id,
                  "updated_datetime"        =>    $tm,
                  "status"                =>    "2"
        );
        if ($this->Constant_model->updateData("service_jobs", $upd_started_job_data, $job_id)) {
            
            // Service Package -- START;
            $serpackResult        = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
            $serpackData        = $serpackResult->result();
            for ($sp = 0; $sp < count($serpackData); $sp++) {
                $serpack_id    = $serpackData[$sp]->id;
                
                $upd_ser_pack_data    = array(
                          "started_user_id"        =>    $us_id,
                          "started_datetime"        =>    $tm
                );
                $this->Constant_model->updateData("service_job_packages", $upd_ser_pack_data, $serpack_id);
                
                unset($serpack_id);
            }
            unset($serpackResult);
            unset($serpackData);
            // Service Package -- END;
            
            // Report Defect -- START;
            $defectResult        = $this->db->query("SELECT * FROM service_job_defects WHERE service_job_id = '$job_id' ORDER BY id DESC ");
            $defectData        = $defectResult->result();
            for ($df = 0; $df < count($defectData); $df++) {
                $defect_id        = $defectData[$df]->id;
                
                $upd_defect_data    = array(
                          "started_user_id"        =>    $us_id,
                          "started_datetime"        =>    $tm
                );
                $this->Constant_model->updateData("service_job_defects", $upd_defect_data, $defect_id);
                
                unset($defect_id);
            }
            unset($defectResult);
            unset($defectData);
            // Report Defect -- END;
            
            $this->session->set_flashdata('alert_msg', array('success', 'Start Service', "Successfully Started Service Job : $job_id"));
            redirect(base_url().'technician_services/tech_opened_services_view?job_id='.$job_id);
        }
    }
    
    // Request Materials;
    public function requestMaterial()
    {
        $job_id            = $this->input->post("job_id");
        
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        $defectResult        = $this->db->query("SELECT * FROM service_job_defects WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $defectRows        = $defectResult->num_rows();
        if ($defectRows > 0) {
            $defectData        = $defectResult->result();
            for ($df = 0; $df < count($defectData); $df++) {
                $defect_id        = $defectData[$df]->id;
                $defect_name    = $defectData[$df]->defect_name;
                
                $cap_defect_status        = $this->input->post("defect_status_$defect_id");
                $cap_defect_mat_id        = $this->input->post("defect_req_mat_$defect_id");
                $cap_defect_mat_qty    = $this->input->post("defect_req_mat_qty_$defect_id");
                
                if ($cap_defect_status == "2") {
                    if (!empty($cap_defect_mat_id)) {
                        $matDtaData        = $this->Constant_model->getDataOneColumn("materials", "id", $cap_defect_mat_id);
                        $mat_name            = $matDtaData[0]->name;
                        $mat_sku            = $matDtaData[0]->sku;
                        
                        if ($cap_defect_mat_qty == 0) {
                            $cap_defect_mat_qty    = "1";
                        }
                        
                        $ins_defect_req_mat_data    = array(
                                "service_job_id"                =>    $job_id,
                                "service_job_defects_id"        =>    $defect_id,
                                "material_id"                    =>    $cap_defect_mat_id,
                                "material_name"                    =>    $mat_name,
                                "material_sku"                    =>    $mat_sku,
                                "request_qty"                    =>    $cap_defect_mat_qty,
                                "issued_qty"                    =>    "0",
                                "cost"                            =>    "0.00",
                                "price"                            =>    "0.00",
                                "requested_user_id"                =>    $us_id,
                                "requested_datetime"            =>    $tm,
                                "issued_user_id"                =>    "0",
                                "issued_datetime"                =>    "0000-00-00 00:00:00",
                                "customer_approved"                =>    "0",
                                "status"                        =>    "0"
                        );
                        $this->Constant_model->insertData("service_job_defects_material", $ins_defect_req_mat_data);
                    }
                }
                
                $upd_service_defect_data    = array(
                        "status"            =>    "1"
                );
                $this->Constant_model->updateData("service_job_defects", $upd_service_defect_data, $defect_id);
                
                unset($defect_id);
                unset($defect_name);
            }
            unset($defectData);
        }
        unset($defectResult);
        unset($defectRows);
        
        $packageResult    = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $packageRows    = $packageResult->num_rows();
        
        if ($packageRows > 0) {
            $packageData    = $packageResult->result();
            for ($sp = 0; $sp < count($packageData); $sp++) {
                $serpack_id    = $packageData[$sp]->id;
                $package_id    = $packageData[$sp]->package_id;
                
                $packTaskResult    = $this->db->query("SELECT * FROM service_package_tasks WHERE service_package_id = '$package_id' AND status = '1' ORDER BY id DESC ");
                $packTaskData        = $packTaskResult->result();
                for ($pt = 0; $pt < count($packTaskData); $pt++) {
                    $packTask_id    = $packTaskData[$pt]->id;
                    $task_id        = $packTaskData[$pt]->task_id;
                    
                    $taskNameData    = $this->Constant_model->getDataOneColumn("tasks", "id", $task_id);
                    $task_name        = $taskNameData[0]->name;
                    
                    $comb_two        = $serpack_id."_".$packTask_id;
                    
                    $cap_pack_status        = $this->input->post("package_status_$comb_two");
                    $cap_pack_mat_id        = $this->input->post("package_req_mat_$comb_two");
                    $cap_pack_mat_qty        = $this->input->post("package_req_mat_qty_$comb_two");
                    
                    if ($cap_pack_status == "2") {
                        if (!empty($cap_pack_mat_id)) {
                            $matDtaData        = $this->Constant_model->getDataOneColumn("materials", "id", $cap_pack_mat_id);
                            $mat_name            = $matDtaData[0]->name;
                            $mat_sku            = $matDtaData[0]->sku;
                            
                            if ($cap_pack_mat_qty == 0) {
                                $cap_pack_mat_qty    = "1";
                            }
                            
                            $ins_pack_req_mat_data    = array(
                                    "service_job_id"            =>    $job_id,
                                    "service_job_package_id"    =>    $serpack_id,
                                    "task_id"                    =>    $task_id,
                                    "material_id"                =>    $cap_pack_mat_id,
                                    "material_sku"                =>    $mat_sku,
                                    "material_name"                =>    $mat_name,
                                    "request_qty"                =>    $cap_pack_mat_qty,
                                    "issued_qty"                =>    "0",
                                    "cost"                        =>    "0.00",
                                    "price"                        =>    "0.00",
                                    "requested_user_id"            =>    $us_id,
                                    "requested_datetime"        =>    $tm,
                                    "issued_user_id"            =>    "0",
                                    "issued_datetime"            =>    "0000-00-00 00:00:00",
                                    "request_approved"            =>    "0",
                                    "status"                    =>    "0"
                            );
                            $this->Constant_model->insertData("service_job_package_material", $ins_pack_req_mat_data);
                        }
                    }
                    
                    
                    unset($task_id);
                    unset($packTask_id);
                }
                unset($packTaskResult);
                unset($packTaskData);
                
                $upd_ser_pack_status_data    = array(
                    "status"            =>    "1"
                );
                $this->Constant_model->updateData("service_job_packages", $upd_ser_pack_status_data, $serpack_id);
                
                unset($serpack_id);
                unset($package_id);
            }
            unset($packageData);
        }
        
        unset($packageResult);
        unset($packageRows);
        
        $upd_service_job_data    = array(
                "updated_user_id"            =>    $us_id,
                "updated_datetime"            =>    $tm,
                "status"                    =>    "3"
        );
        $this->Constant_model->updateData("service_jobs", $upd_service_job_data, $job_id);
        
        $this->session->set_flashdata('alert_msg', array('success', 'Request Material', "Successfully Requested Materials for Job Id : #$job_id."));
        redirect(base_url().'technician_services/tech_opened_services');
    }
    
    // *************************** Action to DB -- END *************************** //
}
