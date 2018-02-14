<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Materials extends CI_Controller
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
        $this->load->model('Materials_model');
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
        redirect(base_url().'materials/materials_list', 'refresh');
    }
    
    // *************************** View Page -- START *************************** //
    
    // View Materials List;
    public function materials_list()
    {
        $this->load->view("materials_list");
    }
    
    // Add Material;
    public function add_material()
    {
        $this->load->view("materials_add");
    }
    
    // Edit Material;
    public function edit_material()
    {
        $id        = strip_tags($this->input->get("id"));
        
        $data["id"]    = $id;
        $this->load->view("materials_edit", $data);
    }
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    // Insert New Material;
    public function insertMaterial()
    {
        $sku            = strip_tags($this->input->post("sku"));
        $material_name    = strip_tags($this->input->post("material_name"));
        $material_type    = strip_tags($this->input->post("material_type"));
        $cost            = strip_tags($this->input->post("cost"));
        $price            = strip_tags($this->input->post("price"));
        $status        = strip_tags($this->input->post("status"));
        
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        if (empty($sku)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Material', "Please enter SKU!"));
            redirect(base_url().'materials/add_material');
        } elseif (empty($material_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Material', "Please enter Material Name!"));
            redirect(base_url().'materials/add_material');
        } elseif (empty($material_type)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Material', "Please enter Material Type!"));
            redirect(base_url().'materials/add_material');
        } else {
            $ckSKUResult    = $this->db->query("SELECT id FROM materials WHERE sku = '$sku' ");
            $ckSKURows        = $ckSKUResult->num_rows();
            if ($ckSKURows == 0) {
                $ins_material_data    = array(
                        "sku"                =>    $sku,
                        "name"                =>    $material_name,
                        "material_type"        =>    $material_type,
                        "cost"                =>    $cost,
                        "price"                =>    $price,
                        "created_user_id"    =>    $us_id,
                        "created_datetime"    =>    $tm,
                        "status"            =>    "1"
                );
                if ($this->Constant_model->insertData("materials", $ins_material_data)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Add New Material', "Successfully Added New Material : $material_name."));
                    redirect(base_url().'materials/materials_list');
                }
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Material', "SKU : <b>$sku</b> is already existing in the system! Please try another one!"));
                redirect(base_url().'materials/add_material');
            }
            unset($ckSKUResult);
            unset($ckSKURows);
        }
    }
    
    // Update Material;
    public function updateMaterial()
    {
        $id            = $this->input->post("id");
        $sku            = strip_tags($this->input->post("sku"));
        $material_name    = strip_tags($this->input->post("material_name"));
        $material_type    = strip_tags($this->input->post("material_type"));
        $cost            = strip_tags($this->input->post("cost"));
        $price            = strip_tags($this->input->post("price"));
        $status        = strip_tags($this->input->post("status"));
        
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        if (empty($sku)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Material', "Please enter SKU!"));
            redirect(base_url().'materials/edit_material?id='.$id);
        } elseif (empty($material_name)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Material', "Please enter Material Name!"));
            redirect(base_url().'materials/edit_material?id='.$id);
        } elseif (empty($material_type)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Material', "Please enter Material Type!"));
            redirect(base_url().'materials/edit_material?id='.$id);
        } else {
            $ckSKUResult    = $this->db->query("SELECT id FROM materials WHERE sku = '$sku' AND id != '$id' ");
            $ckSKURows        = $ckSKUResult->num_rows();
            if ($ckSKURows == 0) {
                $upd_material_data    = array(
                        "sku"                =>    $sku,
                        "name"                =>    $material_name,
                        "material_type"        =>    $material_type,
                        "cost"                =>    $cost,
                        "price"                =>    $price,
                        "updated_user_id"    =>    $us_id,
                        "updated_datetime"    =>    $tm,
                        "status"            =>    $status
                );
                if ($this->Constant_model->updateData("materials", $upd_material_data, $id)) {
                    $this->session->set_flashdata('alert_msg', array('success', 'Update Material', "Successfully Updated Material : $material_name."));
                    redirect(base_url().'materials/edit_material?id='.$id);
                }
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Update Material', "SKU : <b>$sku</b> is already existing in the system! Please try another one!"));
                redirect(base_url().'materials/edit_material?id='.$id);
            }
            unset($ckSKUResult);
            unset($ckSKURows);
        }
    }
    
    // Update Inventory;
    public function updateInventory()
    {
        $mat_id            = $this->input->post("mat_id");
        $mat_sku            = $this->input->post("mat_sku");
        $qty                = strip_tags($this->input->post("qty"));
        
        $us_id            = $this->session->userdata('user_id');
        $tm            = date('Y-m-d H:i:s', time());
        
        if (!is_numeric($qty)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Inventory Quantity', "Please type numeric number for Inventory Quantity!"));
            redirect(base_url().'materials/edit_material?id='.$mat_id);
        } else {
            $ckInvResult        = $this->db->query("SELECT * FROM inventory WHERE sku = '$mat_sku' ");
            $ckInvRows            = $ckInvResult->num_rows();
            if ($ckInvRows == 0) {
                $ins_inv_data    = array(
                        "materials_id"            =>    $mat_id,
                        "sku"                    =>    $mat_sku,
                        "quantity"                =>    $qty
                );
                $inv_id        = $this->Constant_model->insertDataReturnLastId("inventory", $ins_inv_data);
                
                // Log -- START;
                $ins_log_data    = array(
                        "inventory_id"        =>    $inv_id,
                        "material_id"        =>    $mat_id,
                        "sku"                =>    $mat_sku,
                        "before_qty"        =>    "0",
                        "update_qty"        =>    $qty,
                        "after_qty"            =>    $qty,
                        "created_user_id"    =>    $us_id,
                        "created_datetime"    =>    $tm
                );
                $this->Constant_model->insertData("inventory_updated_logs", $ins_log_data);
                // Log -- END;
            } else {
                $ckInvData        = $ckInvResult->result();
                
                $ckInv_id        = $ckInvData[0]->id;
                $ckInv_qty        = $ckInvData[0]->quantity;
                
                unset($ckInvData);
                
                $add_qty        = 0;
                $add_qty        = $ckInv_qty + $qty;
                
                $upd_inv_data    = array(
                        "quantity"        =>    $add_qty
                );
                $this->Constant_model->updateData("inventory", $upd_inv_data, $ckInv_id);
                
                // Log -- START;
                $ins_log_data    = array(
                        "inventory_id"            =>    $ckInv_id,
                        "material_id"            =>    $mat_id,
                        "sku"                    =>    $mat_sku,
                        "before_qty"            =>    $ckInv_qty,
                        "update_qty"            =>    $qty,
                        "after_qty"                =>    $add_qty,
                        "created_user_id"        =>    $us_id,
                        "created_datetime"        =>    $tm
                );
                $this->Constant_model->insertData("inventory_updated_logs", $ins_log_data);
                // Log -- END;
            }
            unset($ckInvResult);
            unset($ckInvRows);
            
            $this->session->set_flashdata('alert_msg', array('success', 'Update Inventory Quantity', "Successfully Updated Inventory Quantity."));
            redirect(base_url().'materials/edit_material?id='.$mat_id);
        }
    }
    
    // *************************** Action to DB -- END *************************** //
    
    
    
    // *************************** Export Excel -- START *************************** //
    
    // Export Material Lists -- START;
    public function exportMaterialsList()
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
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:G1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Materals List");

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_header);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', "SKU");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "Material Name");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Material Type");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "Cost");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Price");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Existing Qty.");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Status");
        
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_header);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        
        $jj            = 3;
        
        $matData        = $this->Constant_model->getDataAll("materials", "id", "DESC");
        for ($m = 0; $m < count($matData); $m++) {
            $mat_id    = $matData[$m]->id;
            $mat_sku    = $matData[$m]->sku;
            $mat_name    = $matData[$m]->name;
            $mat_type    = $matData[$m]->material_type;
            $mat_cost    = $matData[$m]->cost;
            $mat_price    = $matData[$m]->price;
            $mat_status    = $matData[$m]->status;
            
            $mat_type_name    = "";
            $matTypeData    = $this->Constant_model->getDataOneColumn("material_type", "id", $mat_type);
            $mat_type_name    = $matTypeData[0]->name;
            
            $inv_qty        = 0;
            $inventoryResult    = $this->db->query("SELECT quantity FROM inventory WHERE materials_id = '$mat_id' AND sku = '$mat_sku' ");
            $inventoryRows        = $inventoryResult->num_rows();
            if ($inventoryRows == 1) {
                $inventoryData    = $inventoryResult->result();
                
                $inv_qty        = $inventoryData[0]->quantity;
                
                unset($inventoryData);
            }
            unset($inventoryResult);
            unset($inventoryRows);
            
            $status_name        = "";
            if ($mat_status == "1") {
                $status_name    = "Active";
            } else {
                $status_name    = "Inactive";
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$mat_sku");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$mat_name");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$mat_type_name");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$mat_cost");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$mat_price");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$inv_qty");
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$status_name");
            
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_cell_center_style);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($text_cell_center_style);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($text_cell_center_style);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($text_cell_center_style);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($text_cell_center_style);
            
            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(18);
            
            unset($mat_id);
            unset($mat_sku);
            unset($mat_name);
            unset($mat_type);
            unset($mat_cost);
            unset($mat_price);
            unset($mat_status);
            unset($mat_type_name);
            
            $jj++;
        }
        unset($matData);
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Materials_list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    // Export Material Lists -- START;
   
    
    // Export History for Updated;
    public function exportUpdatedHistory()
    {
        $mat_id                = strip_tags($this->input->get("mat_id"));
        
        $matDtaResult            = $this->db->query("SELECT * FROM materials WHERE id = '$mat_id' ");
        $matDtaRows            = $matDtaResult->num_rows();
        if ($matDtaRows == 0) {
            redirect(base_url().'materials/materials_list');
            die();
        }
        $matDtaData            = $matDtaResult->result();
        
        $mat_name                = $matDtaData[0]->name;
        $mat_sku                = $matDtaData[0]->sku;
        
        unset($matDtaResult);
        unset($matDtaRows);
        unset($matDtaData);
        
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $setting_dateformat        = $paginationData[0]->datetime_format;

        $user_role                = $this->session->userdata('user_role');

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
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Updated History for : $mat_name (SKU : $mat_sku)");

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_header);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Updated Date & Time");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "Before Update");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Update Quantity");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "After Updated");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Staff Name");
        
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_header);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        
        $jj        = 3;
        
        $invUpdResult        = $this->db->query("SELECT * FROM inventory_updated_logs WHERE material_id = '$mat_id' ORDER BY created_datetime DESC ");
        $invUpdRows        = $invUpdResult->num_rows();
        if ($invUpdRows > 0) {
            $invUpdData    = $invUpdResult->result();
            
            for ($i = 0; $i < count($invUpdData); $i++) {
                $before_qty        = $invUpdData[$i]->before_qty;
                $update_qty        = $invUpdData[$i]->update_qty;
                $after_qty            = $invUpdData[$i]->after_qty;
                $updated_dtm        = date("$setting_dateformat h:i A", strtotime($invUpdData[$i]->created_datetime));
                $updated_us_id        = $invUpdData[$i]->created_user_id;
                
                $staff_name        = "";
                $staffNameData        = $this->Constant_model->getDataOneColumn("users", "id", $updated_us_id);
                $staff_name        = $staffNameData[0]->fullname;
                
                $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$updated_dtm");
                $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$before_qty");
                $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$update_qty");
                $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$after_qty");
                $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$staff_name");
                
                $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($text_cell_style);
                
                $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(18);
                
                unset($before_qty);
                unset($update_qty);
                unset($after_qty);
                unset($updated_dtm);
                unset($updated_us_id);
                
                $jj++;
            }
            
            unset($invUpdData);
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:E$jj");
            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "No match history found!");
            
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($text_cell_style);
            
            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(18);
            
            $jj++;
        }
        unset($invUpdResult);
        unset($invUpdRows);

        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Updated_Inventory_History.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    
    // *************************** Export Excel -- END *************************** //
}
