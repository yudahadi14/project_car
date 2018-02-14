<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Setting extends CI_Controller
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
        $this->load->model('Setting_model');
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
    }
    
    // ****************************** View Page -- START ****************************** //
    
    // View System Setting;
    public function system_setting()
    {
        $this->load->view("system_setting");
    }
    
    // View Payment Methods;
    public function payment_methods()
    {
        $this->load->view("payment_methods");
    }
    
    // View Edit Payment Method;
    public function edit_payment_method()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("payment_methods_edit", $data);
    }
    
    // View Add Payment Method;
    public function add_payment_method()
    {
        $this->load->view("paymethod_methods_add");
    }
    
    
    // View Users;
    public function users()
    {
        $this->load->view("users");
    }
    
    // View Add User;
    public function add_user()
    {
        $this->load->view("users_add");
    }
    
    // View Edit User;
    public function edit_user()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("users_edit", $data);
    }
    
    
    // View Car Make;
    public function car_make()
    {
        $this->load->view("car_make");
    }
    
    // View Add Car Make;
    public function add_car_make()
    {
        $this->load->view("car_make_add");
    }
    
    // Edit Car Make;
    public function edit_car_make()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("car_make_edit", $data);
    }
    
    // View Customer Groups;
    public function customer_groups()
    {
        $this->load->view("customer_groups");
    }
    
    // View Add Customer Groups;
    public function add_customer_groups()
    {
        $this->load->view("customer_groups_add");
    }
    
    // View Edit Customer Group;
    public function edit_customer_groups()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("customer_groups_edit", $data);
    }
    
    // View suppliers;
    public function suppliers()
    {
        $this->load->view("suppliers");
    }
    
    // Add New Supplier;
    public function add_supplier()
    {
        $this->load->view("supplier_add");
    }
    
    // Edit Supplier;
    public function edit_supplier()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("supplier_edit", $data);
    }
    
    // Change Password;
    public function changePassword()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("change_password", $data);
    }
    
    // ****************************** View Page -- END ****************************** //
    
    
    
    
    // ****************************** Database Action -- START ****************************** //
    
    // Update New Password;
    public function updateNewPassword()
    {
        $id        = $this->input->post("id");
        $new_pass    = strip_tags($this->input->post("new_password"));
        $con_pass    = strip_tags($this->input->post("confirm_password"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($new_pass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update New Password', "Please enter New Password!"));
            redirect(base_url().'setting/changePassword?id='.$id);
        } elseif (empty($con_pass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update New Password', "Please enter Confirm Password!"));
            redirect(base_url().'setting/changePassword?id='.$id);
        } elseif ($new_pass != $con_pass) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update New Password', "New Password & Confirm Password must be the same!"));
            redirect(base_url().'setting/changePassword?id='.$id);
        } else {
            $password        = $this->encryptPassword($new_pass);
            $upd_data        = array(
                    "password"            =>    $password,
                    "updated_user_id"    =>    $us_id,
                    "updated_datetime"    =>    $tm
            );
            
            if ($this->Constant_model->updateData("users", $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update New Password', "Successfully changed New Password!"));
                redirect(base_url().'setting/changePassword?id='.$id);
            }
        }
    }
    
    // Update Supplier;
    public function updateSupplier()
    {
        $id        = $this->input->post("id");
        $name        = strip_tags($this->input->post("name"));
        $email        = strip_tags($this->input->post("email"));
        $tel        = strip_tags($this->input->post("tel"));
        $fax        = strip_tags($this->input->post("fax"));
        $address    = strip_tags($this->input->post("address"));
        $tax        = strip_tags($this->input->post("tax"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Supplier', "Please enter supplier name!"));
            redirect(base_url().'setting/edit_supplier?id='.$id);
        } elseif (empty($tel)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Supplier', "Please enter supplier telephone number!"));
            redirect(base_url().'setting/edit_supplier?id='.$id);
        } elseif (empty($address)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Supplier', "Please enter supplier address!"));
            redirect(base_url().'setting/edit_supplier?id='.$id);
        } elseif (empty($tax)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Supplier', "Please enter supplier tax!"));
            redirect(base_url().'setting/edit_supplier?id='.$id);
        } else {
            $upd_data    = array(
                    "name"                =>    $name,
                    "email"                =>    $email,
                    "telephone"            =>    $tel,
                    "fax"                =>    $fax,
                    "address"            =>    $address,
                    "tax"                =>    $tax,
                    "updated_user_id"    =>    $us_id,
                    "updated_datetime"    =>    $tm,
                    "status"            =>    $status
            );
            if ($this->Constant_model->updateData("suppliers", $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Supplier', "Successfully updated Supplier : $name."));
                redirect(base_url().'setting/edit_supplier?id='.$id);
            }
        }
    }
    
    // Insert Supplier;
    public function insertNewSupplier()
    {
        $name        = strip_tags($this->input->post("name"));
        $email        = strip_tags($this->input->post("email"));
        $tel        = strip_tags($this->input->post("tel"));
        $fax        = strip_tags($this->input->post("fax"));
        $address    = strip_tags($this->input->post("address"));
        $tax        = strip_tags($this->input->post("tax"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Supplier', "Please enter supplier name!"));
            redirect(base_url().'setting/add_supplier');
        } elseif (empty($tel)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Supplier', "Please enter supplier telephone number!"));
            redirect(base_url().'setting/add_supplier');
        } elseif (empty($address)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Supplier', "Please enter supplier address!"));
            redirect(base_url().'setting/add_supplier');
        } elseif (empty($tax)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Supplier', "Please enter supplier tax!"));
            redirect(base_url().'setting/add_supplier');
        } else {
            $ins_data    = array(
                      "name"                =>    $name,
                      "email"                =>    $email,
                      "telephone"            =>    $tel,
                      "fax"                =>    $fax,
                      "address"            =>    $address,
                      "tax"                =>    $tax,
                      "created_user_id"    =>    $us_id,
                      "created_datetime"    =>    $tm,
                      "status"            =>    $status
            );
            if ($this->Constant_model->insertData("suppliers", $ins_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add New Supplier', "Successfully Added New Supplier : $name."));
                redirect(base_url().'setting/suppliers');
            }
        }
    }
    
    // Update Customer Group;
    public function updateCustomerGroup()
    {
        $id        = strip_tags($this->input->post("id"));
        
        $name        = strip_tags($this->input->post("name"));
        $percentage    = strip_tags($this->input->post("percentage"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer Group', "Please enter your Customer Group Name!"));
            redirect(base_url().'setting/edit_customer_groups?id='.$id);
        } elseif (strlen($percentage) <= 0) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer Group', "Please enter Customer Group Percentage!"));
            redirect(base_url().'setting/edit_customer_groups?id='.$id);
        } else {
            if (!is_numeric($percentage)) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer Group', "Discount Percentage must be Numeric Number!"));
                redirect(base_url().'setting/edit_customer_groups?id='.$id);
            } else {
                $upd_data    = array(
                        "name"                    =>    $name,
                        "discount_percentage"    =>    $percentage,
                        "updated_user_id"        =>    $us_id,
                        "updated_datetime"        =>    $tm,
                        "status"                =>    $status
                );
                if ($this->Constant_model->updateData("customer_groups", $upd_data, $id)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Update Customer Group', "Successfully Updated Customer Group Detail!"));
                    redirect(base_url().'setting/edit_customer_groups?id='.$id);
                }
            }
        }
    }
    
    // Insert Customer Group;
    public function insertCustomerGroup()
    {
        $name        = strip_tags($this->input->post("name"));
        $percentage    = strip_tags($this->input->post("percentage"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Customer Group', "Please enter your Customer Group Name!"));
            redirect(base_url().'setting/add_customer_groups');
        } elseif (strlen($percentage) <= 0) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Customer Group', "Please enter Customer Group Percentage!"));
            redirect(base_url().'setting/add_customer_groups');
        } else {
            if (!is_numeric($percentage)) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add Customer Group', "Discount Percentage must be Numeric Number!"));
                redirect(base_url().'setting/add_customer_groups');
            } else {
                $ins_data    = array(
                        "name"                    =>    $name,
                        "discount_percentage"    =>    $percentage,
                        "created_user_id"        =>    $us_id,
                        "created_datetime"        =>    $tm,
                        "status"                =>    $status
                );
                if ($this->Constant_model->insertData("customer_groups", $ins_data)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Add Customer Group', "Successfully Added New Customer Group : $name!"));
                    redirect(base_url().'setting/customer_groups');
                }
            }
        }
    }
    
    
    // Update Car Make;
    public function updateCarMake()
    {
        $id        = strip_tags($this->input->post("id"));
        $name        = strip_tags($this->input->post("name"));
        $type        = strip_tags($this->input->post("type"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car Make', "Please enter your Car Make Name!"));
            redirect(base_url().'setting/edit_car_make?id='.$id);
        } else {
            $upd_data    = array(
                    "name"                =>    $name,
                    "type"                =>    $type,
                    "status"            =>    $status,
                    "updated_user_id"    =>    $us_id,
                    "updated_datetime"    =>    $tm
            );
            if ($this->Constant_model->updateData("car_make", $upd_data, $id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Car Make', "Successfully updated Car Make Detail!"));
                redirect(base_url().'setting/edit_car_make?id='.$id);
            }
        }
    }
    
    // Insert Car Make;
    public function insertCarMake()
    {
        $name        = strip_tags($this->input->post("name"));
        $type        = strip_tags($this->input->post("type"));
        $status    = $this->input->post("status");
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car Make', "Please enter your Car Make Name!"));
            redirect(base_url().'setting/add_car_make');
        } else {
            $ckMakeResult        = $this->db->query("SELECT * FROM car_make WHERE name = '$name' ");
            $ckMakeRows        = $ckMakeResult->num_rows();
            
            if ($ckMakeRows == 0) {
                $ins_data        = array(
                          "name"                =>    $name,
                          "type"                =>    $type,
                          "created_user_id"    =>    $us_id,
                          "created_datetime"    =>    $tm,
                          "status"            =>    $status
                );
                if ($this->Constant_model->insertData("car_make", $ins_data)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Car Make', "Successfully Added New Car Make : $name."));
                    redirect(base_url().'setting/car_make');
                }
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car Make', "Car Make Name : $name is already existing in the system! Please try another!"));
                redirect(base_url().'setting/add_car_make');
            }
        }
    }
    
    // Update User;
    public function updateUser()
    {
        $id        = $this->input->post("id");
        
        $fn        = strip_tags($this->input->post("fullname"));
        $em        = strip_tags($this->input->post("email"));
        $role        = strip_tags($this->input->post("role"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($fn)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update User', "Please enter your First Name!"));
            redirect(base_url().'setting/edit_user?id='.$id);
        } elseif (empty($em)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update User', "Please enter your Email Address!"));
            redirect(base_url().'setting/edit_user?id='.$id);
        } elseif (filter_var($em, FILTER_VALIDATE_EMAIL) === false) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update User', "Invalid Email Address!"));
            redirect(base_url().'setting/edit_user?id='.$id);
        } else {
            $ckEmailResult        = $this->db->query("SELECT * FROM users WHERE email = '$em' AND id != '$id' ");
            $ckEmailRows        = $ckEmailResult->num_rows();
            
            if ($ckEmailRows > 0) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Update User', "Email Address $em is already existing in the system! Please try another email address!"));
                redirect(base_url().'setting/edit_user?id='.$id);
            } else {
                $upd_data        = array(
                        "fullname"        =>    $fn,
                        "email"            =>    $em,
                        "role_id"        =>    $role,
                        "status"        =>    $status
                );
                if ($this->Constant_model->updateData("users", $upd_data, $id)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Update User', "Successfully Updated User Detail for $fn."));
                    redirect(base_url().'setting/edit_user?id='.$id);
                }
            }
        }
    }
    
    
    // Insert User;
    public function insertUser()
    {
        $fn        = strip_tags($this->input->post("fullname"));
        $em        = strip_tags($this->input->post("email"));
        $pass        = strip_tags($this->input->post("pass"));
        $conpass    = strip_tags($this->input->post("conpass"));
        $role        = strip_tags($this->input->post("role"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($fn)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Please enter Full Name!", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
            redirect(base_url().'setting/add_user');
        } elseif (empty($em)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Please enter Your Email Address!", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
            redirect(base_url().'setting/add_user');
        } elseif (filter_var($em, FILTER_VALIDATE_EMAIL) === false) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Invalid Email Address", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
            redirect(base_url().'setting/add_user');
        } elseif (empty($pass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Please enter Your Password!", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
            redirect(base_url().'setting/add_user');
        } elseif (empty($conpass)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Please enter Your Confirm Password!", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
            redirect(base_url().'setting/add_user');
        } elseif ($pass != $conpass) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "New Password & Confirm Password must be the same!", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
            redirect(base_url().'setting/add_user');
        } elseif (empty($role)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Please select user role!", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
            redirect(base_url().'setting/add_user');
        } else {
            $ckEmailData    = $this->Constant_model->getDataOneColumn("users", "email", "$em");
            if (count($ckEmailData) == 0) {
                $password        = $this->encryptPassword($pass);
                
                $ins_data        = array(
                        "fullname"            =>    $fn,
                        "email"                =>    $em,
                        "password"            =>    $password,
                        "role_id"            =>    $role,
                        "created_user_id"    =>    $us_id,
                        "created_datetime"    =>    $tm,
                        "status"            =>    $status
                );
                if ($this->Constant_model->insertData("users", $ins_data)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Add New User', "Successfully Added User : $fn."));
                    redirect(base_url().'setting/users');
                }
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New User', "Email Address : $email is already registered at the system! Please try another Email Address!", "$fn", "$em", "$pass", "$conpass", "$role", "$status"));
                redirect(base_url().'setting/adduser');
            }
        }
    }
    
    // Insert Paymethod Method;
    public function insertPaymentMethod()
    {
        $name        = strip_tags($this->input->post("name"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add Payment Method', "Please enter payment method name!"));
            redirect(base_url().'setting/add_payment_method');
        } else {
            $ins_data    = array(
                    "name"                =>    $name,
                    "created_user_id"    =>    $us_id,
                    "created_datetime"    =>    $tm,
                    "status"            =>    $status
            );
            if ($this->Constant_model->insertData("payment_method", $ins_data)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Add Payment Method', "Successfully Added New Payment Method : $name."));
                redirect(base_url().'setting/add_payment_method');
            }
        }
    }
    
    // Update Payment Method;
    public function updatePaymentMethod()
    {
        $id        = $this->input->post("id");
        $name        = strip_tags($this->input->post("name"));
        $status    = strip_tags($this->input->post("status"));
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        $upd_data    = array(
                "name"                =>    $name,
                "updated_user_id"    =>    $us_id,
                "updated_datetime"    =>    $tm,
                "status"            =>    $status
        );
        if ($this->Constant_model->updateData("payment_method", $upd_data, $id)) {
            $this->session->set_flashdata('alert_msg', array('success', 'Update Payment Method', "Successfully updated Payment Method : $name."));
            redirect(base_url().'setting/edit_payment_method?id='.$id);
        }
    }
    
    // Update System Setting;
    public function updateSystemSetting()
    {
        $site_name        = strip_tags($this->input->post("site_name"));
        $tax            = strip_tags($this->input->post("tax"));
        $timezone        = strip_tags($this->input->post("timezone"));
        $pagination    = strip_tags($this->input->post("pagination"));
        $currency        = strip_tags($this->input->post("currency"));
        $dateformat    = strip_tags($this->input->post("dateformat"));
        $address        = strip_tags($this->input->post("address"));
        $tel            = strip_tags($this->input->post("tel"));
        $fax            = strip_tags($this->input->post("fax"));
        
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        if (empty($site_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Site Setting', 'Please enter your Site Name!'));
            redirect(base_url().'setting/system_setting');
        } else {
            
            // Upload Logo -- START;
            $temp_fn = $_FILES['uploadFile']['name'];
            if (!empty($temp_fn)) {
                $temp_fn_ext = pathinfo($temp_fn, PATHINFO_EXTENSION);

                if (($temp_fn_ext == 'jpg') || ($temp_fn_ext == 'png') || ($temp_fn_ext == 'jpeg')) {
                    if ($_FILES['uploadFile']['size'] > 500000) {
                        $this->session->set_flashdata('alert_msg', array('failure', 'Update Site Setting', 'Upload file size must be less than 500KB!'));
                        redirect(base_url().'setting/system_setting');

                        die();
                    }
                } else {
                    $this->session->set_flashdata('alert_msg', array('failure', 'Update Product', 'Invalid File Format! Please upload JPG, PNG, JPEG File Format for Log In Logo!'));
                    redirect(base_url().'setting/system_setting');

                    die();
                }
            }
            
            $mainPhoto_fn = $_FILES['uploadFile']['name'];
            if (!empty($mainPhoto_fn)) {
                $main_ext        = pathinfo($mainPhoto_fn, PATHINFO_EXTENSION);
                $mainPhoto_name = "logo.$main_ext";
                
                // Main Photo -- START;
                $config['upload_path'] = './assets/images/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['file_name'] = $mainPhoto_name;
                $this->load->library('upload', $config);

                if (!$this->upload->do_upload('uploadFile')) {
                    $error = array('error' => $this->upload->display_errors());
                } else {
                    $width_array = array(100);
                    $height_array = array(100);
                    $dir_array = array('logo');

                    $this->load->library('image_lib');

                    for ($i = 0; $i < count($width_array); ++$i) {
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = "./assets/images/$mainPhoto_name";
                        $config['maintain_ratio'] = true;
                        $config['width'] = $width_array[$i];
                        $config['height'] = $height_array[$i];
                        $config['quality'] = '100%';

                        $config['new_image'] = './assets/images/logo/'.$mainPhoto_name;

                        $this->image_lib->clear();
                        $this->image_lib->initialize($config);
                        $this->image_lib->resize();
                    }

                    $this->load->helper('file');
                    $path = './assets/images/'.$mainPhoto_name;

                    if (unlink($path)) {
                    }
                }
                
                $upd_logo_data    = array(
                          "site_logo"        =>    $mainPhoto_name
                );
                $this->Constant_model->updateData('site_setting', $upd_logo_data, '1');
            }
            
            // Upload Logo -- END;
            
            if (empty($tax)) {
                $tax    = 0;
            }
            
            $upd_data    = array(
                    "site_name"            =>    $site_name,
                    "address"            =>    $address,
                    "telephone"            =>    $tel,
                    "fax"                =>    $fax,
                    "timezone"            =>    $timezone,
                    "pagination"        =>    $pagination,
                    "tax"                =>    $tax,
                    "currency"            =>    $currency,
                    "datetime_format"    =>    $dateformat,
                    "updated_user_id"    =>    $us_id,
                    "updated_datetime"    =>    $tm
            );
            if ($this->Constant_model->updateData('site_setting', $upd_data, '1')) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Site Setting', 'Successfully updated Site Setting.'));
                redirect(base_url().'setting/system_setting');
            }
        }
    }
    
    // ****************************** Database Action -- END ****************************** //
    
    public function encryptPassword($password)
    {
        return md5("$password");
    }
}
