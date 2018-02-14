<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Packages extends CI_Controller
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
        $this->load->model('Packages_model');
        $this->load->model('Constant_model');
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('url');

        $settingResult = $this->db->get_where('site_setting');
        $settingData = $settingResult->row();

        $setting_timezone = $settingData->timezone;

        date_default_timezone_set("$setting_timezone");
    }

    public function index()
    {
        redirect(base_url().'packages/package_lists', 'refresh');
    }
    
    // *************************** View Page -- START *************************** //
    
    // View Package List;
    public function package_lists()
    {
        $this->load->view("packages");
    }
    // View Add Package;
    public function add_service_package()
    {
        $this->load->view("packages_add");
    }
    // View Edit Package;
    public function edit_service_package()
    {
        $id        = $this->input->get("id");
        $data["id"]    = $id;
        $this->load->view("packages_edit", $data);
    }
    // View Assign Task To Package;
    public function packageAssignTask()
    {
        $pack_id            = $this->input->get("pack_id");
        
        $data["pack_id"]    = $pack_id;
        $this->load->view("package_assign_task", $data);
    }
    
    
    
    
    // View Service Task List;
    public function task_lists()
    {
        $this->load->view("tasks");
    }
    // View Add Service Tasks;
    public function add_service_task()
    {
        $this->load->view("tasks_add");
    }
    // View Edit Service Task;
    public function edit_service_task()
    {
        $id        = $this->input->get("id");
        
        $data["id"]    = $id;
        $this->load->view("tasks_edit", $data);
    }
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    // Delete Service Package Task;
    public function deletePackageTask()
    {
        $pack_task_id        = $this->input->post("pack_task_id");
        $pack_id            = $this->input->post("pack_id");
        $task_id            = $this->input->post("task_id");
        
        $taskNameData        = $this->Constant_model->getDataOneColumn("tasks", "id", "$task_id");
        $task_name            = $taskNameData[0]->name;
        
        $packNameData        = $this->Constant_model->getDataOneColumn("service_packages", "id", "$pack_id");
        $pack_name            = $packNameData[0]->name;
        
        if ($this->Constant_model->deleteData("service_package_tasks", $pack_task_id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Delete Service Package Task', "Successfully Deleted Task : $task_name for Service Package : $pack_name."));
            redirect(base_url().'packages/edit_service_package?id='.$pack_id);
        }
    }
    
    // Assign Task to Package;
    public function assignTask()
    {
        $pack_id        = strip_tags($this->input->get("pack_id"));
        $task_id        = strip_tags($this->input->get("task_id"));
        
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        $taskNameData        = $this->Constant_model->getDataOneColumn("tasks", "id", "$task_id");
        $task_name            = $taskNameData[0]->name;
        
        $packNameData        = $this->Constant_model->getDataOneColumn("service_packages", "id", "$pack_id");
        $pack_name            = $packNameData[0]->name;
        
        
        $ckAssignResult    = $this->db->query("SELECT id FROM service_package_tasks WHERE service_package_id = '$pack_id' AND task_id = '$task_id' ");
        $ckAssignRows        = $ckAssignResult->num_rows();
        
        if ($ckAssignRows > 0) {
            $response = array(
                'text'        =>    "Task : $task_name is already existing in this Service Package : $pack_name.",
                'errorMsg'    =>    "failure"
            );
        } else {
            $ins_data    = array(
                      "service_package_id"        =>    $pack_id,
                      "task_id"                    =>    $task_id,
                      "created_user_id"            =>    $us_id,
                      "created_datetime"            =>    $tm,
                      "status"                    =>    "1"
            );
            $this->Constant_model->insertData("service_package_tasks", $ins_data);
            
            $response = array(
                'text'        =>    "Successfully Added Task : $task_name.",
                'errorMsg'    =>    "success"
            );
        }
        echo json_encode($response);
    }
    
    
    // Update Service Package;
    public function updatePackage()
    {
        $id        = $this->input->post("id");
        
        $name        = strip_tags($this->input->post("name"));
        $desc        = strip_tags($this->input->post("description"));
        $price        = strip_tags($this->input->post("price"));
        $car_type    = strip_tags($this->input->post("car_make_type"));
        $discount    = strip_tags($this->input->post("discount_applicable"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Service Package', "Please enter your Service Package Name!"));
            redirect(base_url().'packages/edit_service_package?id='.$id);
        } elseif (empty($price)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Service Package', "Please enter your Service Package Price!"));
            redirect(base_url().'packages/edit_service_package?id='.$id);
        } elseif (empty($car_type)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Service Package', "Please Choose Car Make Type for Service Package!"));
            redirect(base_url().'packages/edit_service_package?id='.$id);
        } else {
            $upd_data    = array(
                      "name"                    =>    $name,
                      "description"            =>    $desc,
                      "price"                    =>    $price,
                      "car_make_type"            =>    $car_type,
                      "discount_applicable"    =>    $discount,
                      "updated_user_id"        =>    $us_id,
                      "updated_datetime"        =>    $tm,
                      "status"                =>    $status
            );
            if ($this->Constant_model->updateData("service_packages", $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Service Package', "Successfully Updated Package Detail."));
                redirect(base_url().'packages/edit_service_package?id='.$id);
            }
        }
    }
    
    // Insert Service Package Name;
    public function insertPackage()
    {
        $name        = strip_tags($this->input->post("name"));
        $desc        = strip_tags($this->input->post("description"));
        $price        = strip_tags($this->input->post("price"));
        $car_type    = strip_tags($this->input->post("car_make_type"));
        $discount    = strip_tags($this->input->post("discount_applicable"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Service Package', "Please enter your Service Package Name!"));
            redirect(base_url().'packages/add_service_package');
        } elseif (empty($price)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Service Package', "Please enter your Service Package Price!"));
            redirect(base_url().'packages/add_service_package');
        } elseif (empty($car_type)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Service Package', "Please Choose Car Make Type for Service Package!"));
            redirect(base_url().'packages/add_service_package');
        } else {
            $ins_data    = array(
                      "name"                    =>    $name,
                      "description"            =>    $desc,
                      "price"                    =>    $price,
                      "car_make_type"            =>    $car_type,
                      "discount_applicable"    =>    $discount,
                      "created_user_id"        =>    $us_id,
                      "created_datetime"        =>    $tm,
                      "status"                =>    $status
            );
            if ($this->Constant_model->insertData("service_packages", $ins_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add New Service Package', "Successfully Added Service Package : $name."));
                redirect(base_url().'packages/package_lists');
            }
        }
    }
    
    
    // Update Task;
    public function updateTask()
    {
        $id        = $this->input->post("id");
        $name        = strip_tags($this->input->post("name"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Service Task', "Please enter your Task Name!"));
            redirect(base_url().'packages/edit_service_task?id='.$id);
        } else {
            $upd_data    = array(
                      "name"                =>    $name,
                      "updated_user_id"    =>    $us_id,
                      "updated_datetime"    =>    $tm,
                      "status"            =>    $status
            );
            if ($this->Constant_model->updateData("tasks", $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Service Task', "Successfully Updated Service Task : $name."));
                redirect(base_url().'packages/edit_service_task?id='.$id);
            }
        }
    }
    
    // Insert Task;
    public function insertTask()
    {
        $name        = strip_tags($this->input->post("name"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Service Task', "Please enter your Task Name!"));
            redirect(base_url().'packages/add_service_task');
        } else {
            $ins_data    = array(
                      "name"                =>    $name,
                      "created_user_id"    =>    $us_id,
                      "created_datetime"    =>    $tm,
                      "status"            =>    $status
            );
            if ($this->Constant_model->insertData("tasks", $ins_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add New Service Task', "Successfully Added Service Task : $name."));
                redirect(base_url().'packages/task_lists');
            }
        }
    }
    
    // *************************** Action to DB -- END *************************** //
}
