<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Cars extends CI_Controller
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
        $this->load->model('Cars_model');
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
        redirect(base_url().'cars/car_lists', 'refresh');
    }
    
    // *************************** View Page -- START *************************** //
    
    // View Cars List;
    public function car_lists()
    {
        $this->load->view("cars");
    }
    
    // View Add Car;
    public function add_car()
    {
        $this->load->view("cars_add");
    }
    
    // View Edit Car;
    public function edit_car()
    {
        $id        = $this->input->get("id");
        
        $data["id"]    = $id;
        $this->load->view("cars_edit", $data);
    }
    
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    // Update Car;
    public function updateCar()
    {
        $id                = strip_tags($this->input->post("id"));
        $owner                = strip_tags($this->input->post("owner"));
        $plate                = strip_tags($this->input->post("plate"));
        $car_make            = strip_tags($this->input->post("car_make"));
        $car_model            = strip_tags($this->input->post("car_model"));
        $chassis            = strip_tags($this->input->post("chassis"));
        $color                = strip_tags($this->input->post("color"));
        $mileage            = strip_tags($this->input->post("mileage"));
        $transmission        = strip_tags($this->input->post("transmission"));
        $nama_merchant        = strip_tags($this->input->post("nama_merchant"));

        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        if (empty($owner)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Choose Car Owner!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } elseif (empty($plate)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Enter Car Plate Number!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } elseif (empty($car_make)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Choose Car Make!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } elseif (empty($car_model)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Enter Car Model!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } elseif (empty($chassis)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Enter Car Chassis Number!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } elseif (empty($color)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Enter Car Color!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } elseif (empty($mileage)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Enter Car Mileage!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } elseif (empty($transmission)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Please Select Car Transmission!"));
            redirect(base_url().'cars/edit_car?id='.$id);
        } else {
            $ckPlateResult    = $this->db->query("SELECT id FROM cars WHERE plate_number = '$plate' AND id != '$id' ");
            $ckPlateRows    = $ckPlateResult->num_rows();
            
            if ($ckPlateRows > 0) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Update Car', "Plate Number $plate is already existing in the system!"));
                redirect(base_url().'cars/edit_car?id='.$id);
                die();
            }
            unset($ckPlateResult);
            unset($ckPlateRows);
        
            $upd_data        = array(
                    "owner_id"            =>    $owner,
                    "car_model"            =>    $car_model,
                    "car_make_id"        =>    $car_make,
                    "alamat"        =>    $alamat,
                    "pic"                =>    $pic,
                    "chassis_number"    =>    $chassis,
                    "transmission"        =>    $transmission,
                    "mileage"            =>    $mileage,
                    "updated_user_id"    =>    $us_id,
                    "updated_datetime"    =>    $tm
            );
            $this->Constant_model->updateData("cars", $upd_data, $id);
            
            $car_id        = $id;
            
            $field = $_FILES['files'];
            if (is_array($field) && in_array($field, $_FILES)) {
                $this->field = $field;
                $this->field['Field_Name'] = array_search($field, $_FILES);
                $this->field['Field_Type'] = 'input';
                
                if (!is_array($this->field['name'])) {
                    $this->field = array_merge($this->field, array("name" => array($this->field['name']), "tmp_name"=>array($this->field['tmp_name']), "type"=>array($this->field['type']), "error"=>array($this->field['error']), "size"=>array($this->field['size'])));
                }
                
                foreach ($this->field['name'] as $key=>$value) {
                    $add_more_ph_name        = $this->field['name'][$key];
                    
                    if (!empty($add_more_ph_name)) {
                        $file_size            = $this->field['size'][$key];
                        $others_ext        = pathinfo($add_more_ph_name, PATHINFO_EXTENSION);
                        
                        $others_fn            = $car_id."_".time();
                        $others_name        = $others_fn.".$others_ext";
                        
                        // Upload Original Image;
                        move_uploaded_file($this->field['tmp_name'][$key], "./assets/upload/car_register/".$others_name);
                        
                        $width_array    = array(200, 400, 600);
                        $height_array    = array(200, 400, 600);
                        $dir_array        = array("xsmall", "small", "medium");
                        
                        $this->load->library('image_lib');
                    
                        for ($i = 0; $i < count($width_array); $i++) {
                            $config['image_library']        = 'gd2';
                            $config['source_image']         = "./assets/upload/car_register/$others_name";
                            $config['maintain_ratio']    = true;
                            $config['width']                = $width_array[$i];
                            $config['height']               = $height_array[$i];
                            $config['quality']            = "100%";
                           
                            if (!file_exists("./assets/upload/car_register/".$dir_array[$i]."/".$car_id)) {
                                mkdir("./assets/upload/car_register/".$dir_array[$i]."/".$car_id, 0777, true);
                            }
                           
                            $config['new_image']            = './assets/upload/car_register/'.$dir_array[$i]."/".$car_id."/".$others_name;
                           
                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                        
                        $this->load->helper("file");
                        $path    = "./assets/upload/car_register/".$others_name;
                        
                        if (unlink($path)) {
                        }
                        
                        $upd_data    = array(
                                "photo_name"        =>    $others_name
                        );
                        $this->Constant_model->updateData("cars", $upd_data, $id);
                    }
                }
            }
            
            $this->session->set_flashdata('alert_msg', array('success', 'Update Car', "Successfully Updated Car Detail : $plate"));
            redirect(base_url().'cars/edit_car?id='.$id);
        }
    }
    
    // Insert New Car;
    public function insertCar()
    {
        $owner                = strip_tags($this->input->post("owner"));
        $alamat                = strip_tags($this->input->post("alamat"));
        $car_make            = strip_tags($this->input->post("car_make"));
        $pic            = strip_tags($this->input->post("pic"));
        $no_merchant            = strip_tags($this->input->post("no_merchant"));
        $area                = strip_tags($this->input->post("area"));
        $mid_tid            = strip_tags($this->input->post("mid_tid"));
        $transmission        = strip_tags($this->input->post("transmission"));
        $nama_merchant        = strip_tags($this->input->post("nama_merchant"));
        $problem        = strip_tags($this->input->post("problem"));
        
        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        if //(empty($owner)) {
           // $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Please Choose Car Owner!"));
            //redirect(base_url().'cars/add_car');
        //} elseif 
        (empty($alamat)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Silahkan Isi Alamat"));
            redirect(base_url().'cars/add_car');
        } elseif (empty($car_make)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Please Choose Car Make!"));
            redirect(base_url().'cars/add_car');
        } elseif (empty($pic)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Please Enter Car Model!"));
            redirect(base_url().'cars/add_car');
        } elseif (empty($no_merchant)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Silahkan Isi No Merchant!"));
            redirect(base_url().'cars/add_car');
        } elseif (empty($area)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Please Enter Car Color!"));
            redirect(base_url().'cars/add_car');
        } elseif (empty($mid_tid)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Silahkan Isi MIDTID"));
            redirect(base_url().'cars/add_car');
        } elseif (empty($transmission)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Please Select Car Transmission!"));
            redirect(base_url().'cars/add_car');
        } else {
            $ckPlateResult    = $this->db->query("SELECT id FROM cars WHERE nama_merchant = '$nama_merchant' ");
            $ckPlateRows    = $ckPlateResult->num_rows();
            
         /*   if ($ckPlateRows > 0) {
                $this->session->set_flashdata('alert_msg', array('failure', 'Add New Car', "Plate Number $nama_merchant is already existing in the system!"));
                redirect(base_url().'cars/add_car');
                
                die();
            }**/
            unset($ckPlateResult);
            unset($ckPlateRows);
            
            $ins_data    = array(
                    "owner_id"            =>    $owner,
                    "nama_merchant"       =>    $nama_merchant,
                    "pic"            =>    $pic,
                    "car_make_id"        =>    $car_make,
                    "alamat"        =>    $alamat,
                    "area"                =>    $area,
                    "no_merchant"    =>    $no_merchant,
                    "transmission"        =>    $transmission,
                    "mid_tid"            =>    $mid_tid,
                    "photo_name"        =>    "no_image.jpg",
                    "created_user_id"    =>    $us_id,
                    "created_datetime"    =>    $tm,
                    "problem"           => $problem,
                    "status"            =>    "1"
            );
            $car_id    = $this->Constant_model->insertDataReturnLastId("cars", $ins_data);
            
            $field = $_FILES['files'];
            if (is_array($field) && in_array($field, $_FILES)) {
                $this->field = $field;
                $this->field['Field_Name'] = array_search($field, $_FILES);
                $this->field['Field_Type'] = 'input';
                
                if (!is_array($this->field['name'])) {
                    $this->field = array_merge($this->field, array("name" => array($this->field['name']), "tmp_name"=>array($this->field['tmp_name']), "type"=>array($this->field['type']), "error"=>array($this->field['error']), "size"=>array($this->field['size'])));
                }
                
                foreach ($this->field['name'] as $key=>$value) {
                    $add_more_ph_name        = $this->field['name'][$key];
                    
                    if (!empty($add_more_ph_name)) {
                        $file_size            = $this->field['size'][$key];
                        $others_ext        = pathinfo($add_more_ph_name, PATHINFO_EXTENSION);
                        
                        $others_fn            = $car_id."_".time();
                        $others_name        = $others_fn.".$others_ext";
                        
                        // Upload Original Image;
                        move_uploaded_file($this->field['tmp_name'][$key], "./assets/upload/car_register/".$others_name);
                        
                        $width_array    = array(200, 400, 600);
                        $height_array    = array(200, 400, 600);
                        $dir_array        = array("xsmall", "small", "medium");
                        
                        $this->load->library('image_lib');
                    
                        for ($i = 0; $i < count($width_array); $i++) {
                            $config['image_library']        = 'gd2';
                            $config['source_image']         = "./assets/upload/car_register/$others_name";
                            $config['maintain_ratio']    = true;
                            $config['width']                = $width_array[$i];
                            $config['height']               = $height_array[$i];
                            $config['quality']            = "100%";
                           
                            if (!file_exists("./assets/upload/car_register/".$dir_array[$i]."/".$car_id)) {
                                mkdir("./assets/upload/car_register/".$dir_array[$i]."/".$car_id, 0777, true);
                            }
                           
                            $config['new_image']            = './assets/upload/car_register/'.$dir_array[$i]."/".$car_id."/".$others_name;
                           
                            $this->image_lib->clear();
                            $this->image_lib->initialize($config);
                            $this->image_lib->resize();
                        }
                        
                        $this->load->helper("file");
                        $path    = "./assets/upload/car_register/".$others_name;
                        
                        if (unlink($path)) {
                        }
                        
                        $upd_data    = array(
                                "photo_name"        =>    $others_name
                        );
                        $this->Constant_model->updateData("cars", $upd_data, $car_id);
                    }
                }
            }
            $this->session->set_flashdata('alert_msg', array('success', 'Add New Car', "Successfully Added New Car : $plate."));
            redirect(base_url().'cars/car_lists');
        }
    }
    
    // *************************** Action to DB -- END *************************** //
    
    
    // *************************** Export Excel -- START *************************** //
    
    // Export Cars Lists -- START;
    public function exportCarsList()
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
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Cars List");

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

        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Plate Number");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "Owner");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Mobile");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "Car Make");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Car Model");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Color");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Mileage");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "Chassis Number");
        $objPHPExcel->getActiveSheet()->setCellValue('I2', "Transmission");
        
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
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        
        $jj                = 3;
        
        $carData            = $this->Constant_model->getDataAll("cars", "id", "DESC");
        for ($i = 0; $i < count($carData); $i++) {
            $id            = $carData[$i]->id;
            $plate            = $carData[$i]->plate_number;
            $make_id        = $carData[$i]->car_make_id;
            $model            = $carData[$i]->car_model;
            $owner_id        = $carData[$i]->owner_id;
            $mileage        = $carData[$i]->mileage;
            $color            = $carData[$i]->color;
            $transmission    = $carData[$i]->transmission;
            $chassis        = $carData[$i]->chassis_number;
            
            $owner_name    = "";
            $owner_mobile    = "";
            $ownerData        = $this->Constant_model->getDataOneColumn("customers", "id", $owner_id);
            if (count($ownerData) == 1) {
                $owner_name    = $ownerData[0]->firstname." ".$ownerData[0]->lastname;
                $owner_mobile    = $ownerData[0]->mobile;
            }
            
            $make_name        = "";
            $makeData        = $this->Constant_model->getDataOneColumn("car_make", "id", $make_id);
            if (count($makeData) == 1) {
                $make_name    = $makeData[0]->name;
            }
            
            $transmission_name    = "";
            if ($transmission == "1") {
                $transmission_name    = "Auto";
            } elseif ($transmission == "2") {
                $transmission_name    = "Manual";
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$plate");
            $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$owner_name");
            $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$owner_mobile");
            $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$make_name");
            $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$model");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$color");
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", number_format($mileage, 2)."km");
            $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$chassis");
            $objPHPExcel->getActiveSheet()->setCellValue("I$jj", "$transmission_name");
            
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("I$jj")->applyFromArray($text_cell_style);
            
            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(18);
            
            
            unset($id);
            unset($plate);
            unset($make_id);
            unset($model);
            unset($owner_id);
            unset($mileage);
            unset($color);
            unset($transmission);
            unset($chassis);
            
            $jj++;
        }
        unset($carData);
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Cars_list.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    // Export Cars Lists -- END;


    // *************************** Export Excel -- END *************************** //
}
