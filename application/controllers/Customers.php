<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Customers extends CI_Controller
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
        $this->load->model('Customers_model');
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
        redirect(base_url().'customers/customer_lists', 'refresh');
    }
    
    // *************************** View Page -- START *************************** //
    
    // View Customer List;
    public function customer_lists()
    {
        $this->load->view("customers");
    }
    
    // View Add Customer;
    public function add_customer()
    {
        $this->load->view("customers_add");
    }
    
    // Edit Customer;
    public function edit_customer()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("customers_edit", $data);
    }
    
    // View Customer;
    public function view_customer()
    {
        $id        = $this->input->get("id");
        
        $data["id"]    = $id;
        $this->load->view("customers_view", $data);
    }
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    // Update Customer;
    public function updateCustomer()
    {
        $id            = strip_tags($this->input->post("id"));
        $nric            = strip_tags($this->input->post("nric"));
        $fn            = strip_tags($this->input->post("fn"));
        $ln            = strip_tags($this->input->post("ln"));
        $em            = strip_tags($this->input->post("em"));
        $mb            = strip_tags($this->input->post("mb"));
        $address        = strip_tags($this->input->post("address"));
        $postal        = strip_tags($this->input->post("postal"));
        $country        = strip_tags($this->input->post("country"));
        $customer_group    = strip_tags($this->input->post("customer_group"));
        $status        = strip_tags($this->input->post("status"));
    
        if (empty($fn)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer', "Please enter First Name!"));
            redirect(base_url().'customers/edit_customer?id='.$id);
        } elseif (empty($nric)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer', "Please enter NRIC!"));
            redirect(base_url().'customers/edit_customer?id='.$id);
        } elseif (empty($mb)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer', "Please enter Mobile Number!"));
            redirect(base_url().'customers/edit_customer?id='.$id);
        } elseif (empty($customer_group)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer', "Please select Customer Group!"));
            redirect(base_url().'customers/edit_customer?id='.$id);
        } else {
            $ckNRICResult    = $this->db->query("SELECT id FROM customers WHERE nric = '$nric' AND id != '$id' ");
            $ckNRICRows    = $ckNRICResult->num_rows();
            if ($ckNRICRows > 0) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Update Customer', "NRIC : $nric is already existing at the system! Please try another one!"));
                redirect(base_url().'customers/edit_customer?id='.$id);
            } else {
                $us_id        = $this->session->userdata('user_id');
                $tm        = date('Y-m-d H:i:s', time());
                
                $upd_data    = array(
                    "firstname"                =>    $fn,
                    "lastname"                =>    $ln,
                    "nric"                    =>    $nric,
                    "email"                    =>    $em,
                    "mobile"                =>    $mb,
                    "address"                =>    $address,
                    "postal_code"            =>    $postal,
                    "country"                =>    $country,
                    "customer_group"        =>    $customer_group,
                    "updated_user_id"        =>    $us_id,
                    "updated_datetime"        =>    $tm,
                    "status"                =>    $status
                );
                if ($this->Constant_model->updateData("customers", $upd_data, $id)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Update Customer', "Successfully Updated Customer Detail."));
                    redirect(base_url().'customers/edit_customer?id='.$id);
                }
            }
        }
    }
    
    // Insert Customer;
    public function insertCustomer()
    {
        $nric            = strip_tags($this->input->post("nric"));
        $fn            = strip_tags($this->input->post("fn"));
        $ln            = strip_tags($this->input->post("ln"));
        $em            = strip_tags($this->input->post("em"));
        $mb            = strip_tags($this->input->post("mb"));
        $address        = strip_tags($this->input->post("address"));
        $postal        = strip_tags($this->input->post("postal"));
        $country        = strip_tags($this->input->post("country"));
        $customer_group    = strip_tags($this->input->post("customer_group"));
        $status        = strip_tags($this->input->post("status"));
        
        if (empty($fn)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Customer', "Please enter First Name!"));
            redirect(base_url().'customers/add_customer');
        } elseif (empty($nric)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Customer', "Please enter NRIC!"));
            redirect(base_url().'customers/add_customer');
        } elseif (empty($mb)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Customer', "Please enter Mobile Number!"));
            redirect(base_url().'customers/add_customer');
        } elseif (empty($customer_group)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Customer', "Please select Customer Group!"));
            redirect(base_url().'customers/add_customer');
        } else {
            $ckNRICResult    = $this->db->query("SELECT id FROM customers WHERE nric = '$nric' ");
            $ckNRICRows    = $ckNRICResult->num_rows();
            if ($ckNRICRows > 0) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Customer', "NRIC : $nric is already existing at the system! Please try another one!"));
                redirect(base_url().'customers/add_customer');
            } else {
                $us_id        = $this->session->userdata('user_id');
                $tm        = date('Y-m-d H:i:s', time());
                
                $ins_data    = array(
                        "firstname"                =>    $fn,
                        "lastname"                =>    $ln,
                        "nric"                    =>    $nric,
                        "email"                    =>    $em,
                        "mobile"                =>    $mb,
                        "address"                =>    $address,
                        "postal_code"            =>    $postal,
                        "country"                =>    $country,
                        "customer_group"        =>    $customer_group,
                        "created_user_id"        =>    $us_id,
                        "created_datetime"        =>    $tm,
                        "status"                =>    $status
                );
                
                if ($this->Constant_model->insertData("customers", $ins_data)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Add New Customer', "Successfully Added New Customer : $fn $ln."));
                    redirect(base_url().'customers/customer_lists');
                }
            }
            unset($ckNRICResult);
            unset($ckNRICRows);
        }
    }
    
    // *************************** Action to DB -- END *************************** //
    
    
    // *************************** Export Excel -- START *************************** //
    
    // Export Customer Lists;
    public function exportCustomersList()
    {
        // START Export Excel;
        $this->load->library('excel');

        require_once './application/third_party/PHPExcel.php';
        require_once './application/third_party/PHPExcel/IOFactory.php';

        // Create new PHPExcel object
        $objPHPExcel = new PHPExcel();

        $default_border = array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '000000'),
        );
        $style_header = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'ffff03'),
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
                'bold' => true,
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        $text_cell_style = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
            ),
        );
        $text_cell_center_style = array(
            'borders' => array(
                'bottom' => $default_border,
                'left' => $default_border,
                'top' => $default_border,
                'right' => $default_border,
            ),
            'font' => array(
                'color' => array('rgb' => '000000'),
                'size' => 12,
                'name' => 'Arial',
            ),
            'alignment' => array(
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
        );
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Customers List");

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($style_header);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', "First Name");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "Last Name");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "NRIC");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "Email");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Mobile");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Customer Group");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Address");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "Postal Code");
        $objPHPExcel->getActiveSheet()->setCellValue('I2', "Country");
        
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('I2')->applyFromArray($style_header);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(35);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        
        $jj                = 3;
        
        $customerData        = $this->Constant_model->getDataAll("customers", "id", "DESC");
        for ($c = 0; $c < count($customerData); $c++) {
            $cust_id        = $customerData[$c]->id;
            $cust_fn        = $customerData[$c]->firstname;
            $cust_ln        = $customerData[$c]->lastname;
            $cust_nric        = $customerData[$c]->nric;
            $cust_mb        = $customerData[$c]->mobile;
            $cust_group_id    = $customerData[$c]->customer_group;
            $cust_em        = $customerData[$c]->email;
            $cust_address    = $customerData[$c]->address;
            $cust_postal    = $customerData[$c]->postal_code;
            $cust_country    = $customerData[$c]->country;
            
            if (empty($cust_ln)) {
                $cust_ln    = "-";
            }
            if (empty($cust_em)) {
                $cust_em    = "-";
            }
            if (empty($cust_address)) {
                $cust_address    = "-";
            }
            if (empty($cust_postal)) {
                $cust_postal    = "-";
            }
            
            $cust_group_name    = "-";
            $groupData            = $this->Constant_model->getDataOneColumn("customer_groups", "id", $cust_group_id);
            if (count($groupData) == 1) {
                $cust_group_name    = $groupData[0]->name;
            }
            
            $country_name        = "-";
            $countryData        = $this->Constant_model->getDataOneColumn("countries", "code", $cust_country);
            if (count($countryData) == 1) {
                $country_name    = $countryData[0]->name;
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$cust_fn");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$cust_ln");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$cust_nric");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$cust_em");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$cust_mb");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$cust_group_name");
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$cust_address");
            $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$cust_postal");
            $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$country_name");
            
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->getAlignment()->setWrapText(true);
            
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($text_cell_style);
            
            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(28);
        
            $jj++;
        }
        unset($customerData);
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Customers_list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    // *************************** Export Excel -- END *************************** //
}
