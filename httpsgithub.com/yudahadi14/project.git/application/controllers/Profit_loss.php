<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Profit_loss extends CI_Controller
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
        $this->load->model('Profitloss_model');
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
        redirect(base_url().'profit_loss/pnl', 'refresh');
    }
    
    // *************************** View Page -- START *************************** //
    
    // View Profit & Loss;
    public function pnl()
    {
        $siteSettingData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat = $siteSettingData[0]->datetime_format;
        $siteSetting_currency    = $siteSettingData[0]->currency;
        
        if ($siteSetting_dateformat == 'Y-m-d') {
            $dateformat = 'yyyy-mm-dd';
        }
        if ($siteSetting_dateformat == 'Y.m.d') {
            $dateformat = 'yyyy.mm.dd';
        }
        if ($siteSetting_dateformat == 'Y/m/d') {
            $dateformat = 'yyyy/mm/dd';
        }
        if ($siteSetting_dateformat == 'm-d-Y') {
            $dateformat = 'mm-dd-yyyy';
        }
        if ($siteSetting_dateformat == 'm.d.Y') {
            $dateformat = 'mm.dd.yyyy';
        }
        if ($siteSetting_dateformat == 'm/d/Y') {
            $dateformat = 'mm/dd/yyyy';
        }
        if ($siteSetting_dateformat == 'd-m-Y') {
            $dateformat = 'dd-mm-yyyy';
        }
        if ($siteSetting_dateformat == 'd.m.Y') {
            $dateformat = 'dd.mm.yyyy';
        }
        if ($siteSetting_dateformat == 'd/m/Y') {
            $dateformat = 'dd/mm/yyyy';
        }

        $data['site_dateformat']    = $siteSetting_dateformat;
        $data['site_currency']        = $siteSetting_currency;
        $data['dateformat']        = $dateformat;
        
        $this->load->view("pnl", $data);
    }
    
    
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    
    
    // *************************** Action to DB -- END *************************** //
    
    
    // *************************** Export Action -- START *************************** //
    
    // Export Profit & Loss Excel -- START;
    public function exportPnL()
    {
        $url_start                = strip_tags($this->input->get("date_from"));
        $url_end                = strip_tags($this->input->get("date_to"));
        
        $first_url_start        = $url_start;
        $first_url_end            = $url_end;
        
        $paginationData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $site_dateformat        = $paginationData[0]->datetime_format;
        
        if ($site_dateformat == 'd/m/Y') {
            $startArray    = explode('/', $url_start);
            $endArray        = explode('/', $url_end);

            $start_day        = $startArray[0];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[0];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd.m.Y') {
            $startArray    = explode('.', $url_start);
            $endArray        = explode('.', $url_end);

            $start_day        = $startArray[0];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[0];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd-m-Y') {
            $startArray    = explode('-', $url_start);
            $endArray        = explode('-', $url_end);

            $start_day        = $startArray[0];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[0];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'm/d/Y') {
            $startArray    = explode('/', $url_start);
            $endArray        = explode('/', $url_end);

            $start_day        = $startArray[1];
            $start_mon        = $startArray[0];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[1];
            $end_mon        = $endArray[0];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm.d.Y') {
            $startArray    = explode('.', $url_start);
            $endArray        = explode('.', $url_end);

            $start_day        = $startArray[1];
            $start_mon        = $startArray[0];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[1];
            $end_mon        = $endArray[0];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm-d-Y') {
            $startArray    = explode('-', $url_start);
            $endArray        = explode('-', $url_end);

            $start_day        = $startArray[1];
            $start_mon        = $startArray[0];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[1];
            $end_mon        = $endArray[0];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'Y.m.d') {
            $startArray    = explode('.', $url_start);
            $endArray        = explode('.', $url_end);

            $start_day        = $startArray[2];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[0];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[2];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[0];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y/m/d') {
            $startArray    = explode('/', $url_start);
            $endArray        = explode('/', $url_end);

            $start_day        = $startArray[2];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[0];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[2];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[0];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y-m-d') {
            $startArray    = explode('-', $url_start);
            $endArray        = explode('-', $url_end);

            $start_day        = $startArray[2];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[0];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[2];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[0];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        
        $url_start            = date('Y-m-d', strtotime($url_start));
        $url_end            = date('Y-m-d', strtotime($url_end));
        
        $start_date        = $url_start.' 00:00:00';
        $end_date            = $url_end.' 23:59:59';
        
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
        $style_second_header = array(
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
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
        
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "Profit & Lost Report from $first_url_start to $first_url_end");

        $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($style_header);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($style_header);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('1')->setRowHeight(30);

        $objPHPExcel->getActiveSheet()->setCellValue('A2', "Job Id");
        $objPHPExcel->getActiveSheet()->setCellValue('B2', "Invoice Number");
        $objPHPExcel->getActiveSheet()->setCellValue('C2', "Date & Time");
        $objPHPExcel->getActiveSheet()->setCellValue('D2', "Customer");
        $objPHPExcel->getActiveSheet()->setCellValue('E2', "Plate Number");
        $objPHPExcel->getActiveSheet()->setCellValue('F2', "Grand Total");
        $objPHPExcel->getActiveSheet()->setCellValue('G2', "Cost Total");
        $objPHPExcel->getActiveSheet()->setCellValue('H2', "Profit Total");
        
        $objPHPExcel->getActiveSheet()->getStyle('A2')->applyFromArray($style_second_header);
        $objPHPExcel->getActiveSheet()->getStyle('B2')->applyFromArray($style_second_header);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->applyFromArray($style_second_header);
        $objPHPExcel->getActiveSheet()->getStyle('D2')->applyFromArray($style_second_header);
        $objPHPExcel->getActiveSheet()->getStyle('E2')->applyFromArray($style_second_header);
        $objPHPExcel->getActiveSheet()->getStyle('F2')->applyFromArray($style_second_header);
        $objPHPExcel->getActiveSheet()->getStyle('G2')->applyFromArray($style_second_header);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->applyFromArray($style_second_header);
        
        $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(10);
        $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
        $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
        $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
        $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
        
        $objPHPExcel->getActiveSheet()->getRowDimension('2')->setRowHeight(30);
        
        $jj        = 3;
        
        $all_total_grand_amt        = 0;
        $all_total_cost_amt        = 0;
        $all_total_profit_amt        = 0;
        
        $serviceResult        = $this->db->query("SELECT * FROM service_jobs WHERE status = '7' AND vt_Status = '1' AND invoice_datetime >= '$start_date' AND invoice_datetime <= '$end_date' ORDER BY invoice_datetime DESC ");
        $serviceRows        = $serviceResult->num_rows();
        if ($serviceRows > 0) {
            $serviceData    = $serviceResult->result();
            for ($s = 0; $s < count($serviceData); $s++) {
                $job_id        = $serviceData[$s]->id;
                $invoice_numb    = $serviceData[$s]->invoice_number;
                $invoice_dtm    = date("$site_dateformat h:i A", strtotime($serviceData[$s]->invoice_datetime));
                $cust_fn        = $serviceData[$s]->firstname;
                $cust_ln        = $serviceData[$s]->lastname;
                $plate_numb    = $serviceData[$s]->car_plate_number;
                $grandTotal    = $serviceData[$s]->grandtotal_amt;
                
                $total_spm_cost        = 0;
                $serPackMatResult        = $this->db->query("SELECT * FROM service_job_package_material WHERE service_job_id = '$job_id' AND request_approved = '1' AND status = '1' ");
                $serPackMatData        = $serPackMatResult->result();
                for ($spm = 0; $spm < count($serPackMatData); $spm++) {
                    $spm_issued_qty    = $serPackMatData[$spm]->issued_qty;
                    $spm_each_cost        = $serPackMatData[$spm]->cost;
                    
                    $total_spm_cost    += ($spm_issued_qty * $spm_each_cost);
                    
                    unset($spm_issued_qty);
                    unset($spm_each_cost);
                }
                unset($serPackMatResult);
                unset($serPackMatData);
                
                $total_defect_mat_cost    = 0;
                $defectMatResult        = $this->db->query("SELECT * FROM service_job_defects_material WHERE service_job_id = '$job_id' AND customer_approved = '1' AND status = '1' ");
                $defectMatData            = $defectMatResult->result();
                for ($dfm = 0; $dfm < count($defectMatData); $dfm++) {
                    $dfm_issued_qty    = $defectMatData[$dfm]->issued_qty;
                    $dfm_each_cost        = $defectMatData[$dfm]->cost;
                    
                    $total_defect_mat_cost        += ($dfm_issued_qty * $dfm_each_cost);
                    
                    unset($dfm_issued_qty);
                    unset($dfm_each_cost);
                }
                unset($defectMatResult);
                unset($defectMatData);
                
                $total_cost        = 0;
                $total_cost        = $total_spm_cost + $total_defect_mat_cost;
                
                $each_row_profit    = 0;
                $each_row_profit    = $grandTotal - $total_cost;
                
                $all_total_cost_amt    += $total_cost;
                $all_total_grand_amt    += $grandTotal;
                $all_total_profit_amt    += $each_row_profit;
                
                
                $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "$job_id");
                $objPHPExcel->getActiveSheet()->setCellValue("B$jj", "$invoice_numb");
                $objPHPExcel->getActiveSheet()->setCellValue("C$jj", "$invoice_dtm");
                $objPHPExcel->getActiveSheet()->setCellValue("D$jj", "$cust_fn $cust_ln");
                $objPHPExcel->getActiveSheet()->setCellValue("E$jj", "$plate_numb");
                $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$".number_format($grandTotal, 2));
                $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$".number_format($total_cost, 2));
                $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$".number_format($each_row_profit, 2));
                
                $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($text_cell_style);
                $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($text_cell_style);
    
                unset($job_id);
                unset($invoice_numb);
                unset($invoice_dtm);
                unset($cust_fn);
                unset($cust_ln);
                unset($plate_numb);
                unset($grandTotal);
                
                $jj++;
            }
            unset($serviceData);
            
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:E$jj");
            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "Total");
            $objPHPExcel->getActiveSheet()->setCellValue("F$jj", "$".number_format($all_total_grand_amt, 2));
            $objPHPExcel->getActiveSheet()->setCellValue("G$jj", "$".number_format($all_total_cost_amt, 2));
            $objPHPExcel->getActiveSheet()->setCellValue("H$jj", "$".number_format($all_total_profit_amt, 2));
            
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($style_header);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($style_header);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($style_header);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($style_header);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($style_header);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($style_second_header);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($style_second_header);
            $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($style_second_header);
            
            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);
            
            $jj++;
        } else {
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells("A$jj:H$jj");
            $objPHPExcel->getActiveSheet()->setCellValue("A$jj", "No match record found!");
            
            $objPHPExcel->getActiveSheet()->getStyle("A$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("B$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("C$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("D$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("E$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("F$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("G$jj")->applyFromArray($text_cell_style);
            $objPHPExcel->getActiveSheet()->getStyle("H$jj")->applyFromArray($text_cell_style);
            
            $objPHPExcel->getActiveSheet()->getRowDimension("$jj")->setRowHeight(30);
            
            $jj++;
        }
        unset($serviceResult);
        unset($serviceRows);
        
        // Redirect output to a client’s web browser (Excel5)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Profit_and_Loss_Report.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
    }
    // Export Profit & Loss Excel -- END;
    
    // *************************** Export Action -- END *************************** //
}
