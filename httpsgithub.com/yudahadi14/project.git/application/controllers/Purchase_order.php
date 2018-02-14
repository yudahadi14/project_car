<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Purchase_order extends CI_Controller
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
        $this->load->model('Purchaseorder_model');
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
        redirect(base_url().'purchase_order/po_view', 'refresh');
    }
    
    // *************************** View Page -- START *************************** //
    
    // Purchase Order View;
    public function po_view()
    {
        $paginationData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $pagination_limit            = $paginationData[0]->pagination;

        $config                    = array();
        $config['base_url']        = base_url().'purchase_order/po_view/';

        $config['display_pages']    = true;
        $config['first_link']        = 'First';

        $config['total_rows']        = $this->Purchaseorder_model->record_po_count();
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

        $data['results'] = $this->Purchaseorder_model->fetch_po_data($config['per_page'], $page);

        $data['links'] = $this->pagination->create_links();

        if ($page == 0) {
            $have_count = $this->Purchaseorder_model->record_po_count();
            
            $start_point        = 0;
            if ($have_count > 0) {
                $start_point    = 1;
            }
            
            $sh_text = "Showing $start_point to ".count($data['results']).' of '.$this->Purchaseorder_model->record_po_count().' entries';
        } else {
            $start_sh = $page + 1;
            $end_sh = $page + count($data['results']);
            $sh_text = "Showing $start_sh to $end_sh of ".$this->Purchaseorder_model->record_po_count().' entries';
        }

        $data['displayshowingentries']    = $sh_text;
        $data["dateformat"]                = $paginationData[0]->datetime_format;
        
        $this->load->view('purchase_order', $data);
    }
    
    // View Create Purchase Order;
    public function create_purchase_order()
    {
        $siteSettingData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat        = $siteSettingData[0]->datetime_format;
        $siteSetting_currency        = $siteSettingData[0]->currency;
        $data['site_dateformat']    = $siteSetting_dateformat;
        
        $this->load->view("purchase_order_create", $data);
    }
    
    // Edit Purchase Order;
    public function edit_purchase_order()
    {
        $po_id        = strip_tags($this->input->get("po_id"));
        
        $siteSettingData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat        = $siteSettingData[0]->datetime_format;
        $siteSetting_currency        = $siteSettingData[0]->currency;
        $data['site_dateformat']    = $siteSetting_dateformat;
        $data["po_id"]                = $po_id;
        
        $this->load->view("purchase_order_edit", $data);
    }
    
    // Print Purchase Order;
    public function printPurchaseOrder()
    {
        $po_id            = strip_tags($this->input->get("po_id"));
        
        $data["po_id"]    = $po_id;
        
        $this->load->view("purchase_order_print", $data);
    }
    
    // View Purchase Order;
    public function view_purchase_order()
    {
        $po_id            = strip_tags($this->input->get("po_id"));
        
        $siteSettingData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat        = $siteSettingData[0]->datetime_format;
        $siteSetting_currency        = $siteSettingData[0]->currency;
        $data['site_dateformat']    = $siteSetting_dateformat;
        $data["po_id"]                = $po_id;
        
        $this->load->view("purchase_order_view", $data);
    }
    
    // Receive Purchase Order;
    public function receive_purchase_order()
    {
        $po_id            = strip_tags($this->input->get("po_id"));
        
        $siteSettingData            = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
        $siteSetting_dateformat        = $siteSettingData[0]->datetime_format;
        $siteSetting_currency        = $siteSettingData[0]->currency;
        $data['site_dateformat']    = $siteSetting_dateformat;
        $data["po_id"]                = $po_id;
        
        $this->load->view("purchase_order_receive", $data);
    }
    
    // *************************** View Page -- END *************************** //
    
    
    
    // *************************** Action to DB -- START *************************** //
    
    // Receive Purchase Order;
    public function receiveItemsPO()
    {
        $id                = $this->input->post("id");
        $discount            = strip_tags($this->input->post("discount"));
        $subTotal            = strip_tags($this->input->post("subTotal"));
        $tax                = strip_tags($this->input->post("tax"));
        $grandTotal        = strip_tags($this->input->post("grandTotal"));
        
        $supplier_tax_per    = strip_tags($this->input->post("dbtax"));

        $us_id                = $this->session->userdata('user_id');
        $tm                = date('Y-m-d H:i:s', time());
        
        $existItemResult    = $this->db->query("SELECT * FROM purchase_order_items WHERE purchase_order_id = '$id' ORDER BY id ASC ");
        $existItemData        = $existItemResult->result();
        for ($ex = 0; $ex < count($existItemData); ++$ex) {
            $ex_item_id    = $existItemData[$ex]->id;
            $ex_mat_id        = $existItemData[$ex]->material_id;
            $ex_mat_sku    = $existItemData[$ex]->material_sku;

            if (isset($_POST["receiveQty_$ex_item_id"]) && isset($_POST["receiveCost_$ex_item_id"])) {
                $receive_qty        = strip_tags($this->input->post("receiveQty_$ex_item_id"));
                $receive_cost        = strip_tags($this->input->post("receiveCost_$ex_item_id"));
                
                if ($receive_qty > 0) {
                    $upd_po_item_data    = array(
                            "received_qty"        =>    $receive_qty,
                            "cost"                =>    $receive_cost
                    );
                    $this->Constant_model->updateData('purchase_order_items', $upd_po_item_data, $ex_item_id);
                    
                    // Update Material Cost;
                    $upd_mat_cost_data    = array(
                            "cost"                =>    $receive_cost
                    );
                    $this->Constant_model->updateData("materials", $upd_mat_cost_data, $ex_mat_id);
                    
                    // Update Inventory -- START;
                    $ckInvResult        = $this->db->query("SELECT * FROM inventory WHERE sku = '$ex_mat_sku' ");
                    $ckInvRows            = $ckInvResult->num_rows();
                    if ($ckInvRows == 0) {
                        $ins_inv_data    = array(
                            "materials_id"            =>    $ex_mat_id,
                            "sku"                    =>    $ex_mat_sku,
                            "quantity"                =>    $receive_qty
                        );
                        $this->Constant_model->insertData("inventory", $ins_inv_data);
                    } else {
                        $ckInvData        = $ckInvResult->result();
                        
                        $ckInv_id        = $ckInvData[0]->id;
                        $ckInv_qty        = $ckInvData[0]->quantity;
                        
                        unset($ckInvData);
                        
                        $add_qty        = 0;
                        $add_qty        = $ckInv_qty + $receive_qty;
                        
                        $upd_inv_data    = array(
                                "quantity"        =>    $add_qty
                        );
                        $this->Constant_model->updateData("inventory", $upd_inv_data, $ckInv_id);
                    }
                    unset($ckInvResult);
                    unset($ckInvRows);
                    // Update Inventory -- END;
                }
            }

            unset($ex_item_id);
            unset($ex_mat_id);
            unset($ex_mat_sku);
        }
        unset($existItemResult);
        unset($existItemData);
        
        // Update Purchase Order Table -- START;
        $ckAllItemResult = $this->db->query("SELECT * FROM purchase_order_items WHERE purchase_order_id = '$id' AND received_qty = '0' ");
        $ckAllItemRows = $ckAllItemResult->num_rows();
        if ($ckAllItemRows == 0) {
            $upd_purchase_order_data    = array(
                      "discount_amount"            =>    $discount,
                      "subTotal"                    =>    $subTotal,
                      "tax"                        =>    $tax,
                      "grandTotal"                =>    $grandTotal,
                      "received_user_id"            =>    $us_id,
                      "received_datetime"            =>    $tm,
                      "status"                    =>    "3"
            );
            $this->Constant_model->updateData("purchase_order", $upd_purchase_order_data, $id);
        }
        unset($ckAllItemResult);
        unset($ckAllItemRows);
        // Update Purchase Order Table -- END;
        
        $this->session->set_flashdata('alert_msg', array('success', 'Update Purchase Order', 'Successfully Received Item(s) from Supplier.'));
        redirect(base_url().'purchase_order/receive_purchase_order?po_id='.$id);
    }
    
    // Delete Purchase Order Item;
    public function deletePOItem()
    {
        $po_item_id    = strip_tags($this->input->get('po_item_id'));
        $po_id            = strip_tags($this->input->get('po_id'));

        $ckFirstData = $this->Constant_model->getDataOneColumn('purchase_order_items', 'id', $po_item_id);
        if (count($ckFirstData) == 1) {
            if ($this->Constant_model->deleteData('purchase_order_items', $po_item_id)) {
                $this->session->set_flashdata('alert_msg', array('success', 'Update Purchase Order', 'Successfully Deleted Purchase Order Item.'));
                redirect(base_url().'purchase_order/edit_purchase_order?po_id='.$po_id);
            }
        } else {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', 'Error on deleting Purchase Order Item!'));
            redirect(base_url().'purchase_order/edit_purchase_order?po_id='.$po_id);
        }
    }
    
    // Delete Purchase Order;
    public function deletePO()
    {
        $id        = strip_tags($this->input->get('id'));
        $po_numb    = strip_tags($this->input->get('po_numb'));

        $ckExistResult = $this->db->query("SELECT * FROM purchase_order WHERE id = '$id' ");
        $ckExistRows = $ckExistResult->num_rows();

        if ($ckExistRows == 1) {
            if ($this->Constant_model->deleteData('purchase_order', $id)) {
                $this->Constant_model->deleteByColumn('purchase_order_items', 'purchase_order_id', $id);

                $this->session->set_flashdata('alert_msg', array('success', 'Delete Purchase Order', "Successfully Deleted Purchase Order : $po_numb"));
                redirect(base_url().'purchase_order/po_view');
            }
        }
        unset($ckExistResult);
        unset($ckExistRows);
    }
    
    // Update Purchase Order;
    public function updatePurchaseOrder()
    {
        $po_id        = $this->input->post("po_id");
        $po_numb    = strip_tags($this->input->post("po_numb"));
        $supplier    = strip_tags($this->input->post("supplier"));
        $note        = strip_tags($this->input->post("note"));
        $po_status    = $this->input->post("po_status");
        
        $row_count    = $this->input->post('row_count');
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
         
        if (empty($po_numb)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', 'Please enter Purchase Order Number!'));
            redirect(base_url().'purchase_order/edit_purchase_order?po_id='.$po_id);
        } elseif (empty($supplier)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', 'Please select Supplier for Purchase Order!'));
            redirect(base_url().'purchase_order/edit_purchase_order?po_id='.$po_id);
        } else {
            $ckPONumbResult        = $this->db->query("SELECT id FROM purchase_order WHERE po_number = '$po_numb' AND id != '$po_id' ");
            $ckPONumbRows            = $ckPONumbResult->num_rows();
            if ($ckPONumbRows == 0) {
                $supplierData        = $this->Constant_model->getDataOneColumn("suppliers", "id", $supplier);
                $supplier_name        = $supplierData[0]->name;
                $supplier_email    = $supplierData[0]->email;
                $supplier_tel        = $supplierData[0]->telephone;
                $supplier_fax        = $supplierData[0]->fax;
                $supplier_address    = $supplierData[0]->address;
                $supplier_tax        = $supplierData[0]->tax;
                
                $upd_data            = array(
                        "po_number"                =>    $po_numb,
                        "supplier_id"            =>    $supplier,
                        "supplier_name"            =>    $supplier_name,
                        "supplier_email"        =>    $supplier_email,
                        "supplier_tel"            =>    $supplier_tel,
                        "supplier_fax"            =>    $supplier_fax,
                        "supplier_address"        =>    $supplier_address,
                        "supplier_tax"            =>    $supplier_tax,
                        "note"                    =>    $note,
                        "updated_user_id"        =>    $us_id,
                        "updated_datetime"        =>    $tm,
                        "status"                =>    $po_status
                );
                $this->Constant_model->updateData("purchase_order", $upd_data, $po_id);
                
                // Update Existing Item -- START;
                $existItemResult    = $this->db->query("SELECT * FROM purchase_order_items WHERE purchase_order_id = '$po_id' ORDER BY id ASC ");
                $existItemData        = $existItemResult->result();
                for ($ex = 0; $ex < count($existItemData); ++$ex) {
                    $ex_item_id    = $existItemData[$ex]->id;

                    $ex_upd_qty    = strip_tags($this->input->post("existQty_$ex_item_id"));

                    $upd_po_item_data = array(
                            'ordered_qty' => $ex_upd_qty,
                    );
                    $this->Constant_model->updateData('purchase_order_items', $upd_po_item_data, $ex_item_id);
                }
                unset($existItemResult);
                unset($existItemData);
                // Update Existing Item -- END;
                
                // New Item -- START;
                for ($i = 1; $i <= $row_count; $i++) {
                    $sku        = $this->input->post("sku_".$i);
                    $qty        = $this->input->post("qty_".$i);
                    
                    if ($qty > 0) {
                        $matDtaData    = $this->Constant_model->getDataOneColumn("materials", "sku", $sku);
                        $mat_id        = $matDtaData[0]->id;
                    
                        $ins_po_item_data    = array(
                                "purchase_order_id"        =>    $po_id,
                                "material_id"            =>    $mat_id,
                                "material_sku"            =>    $sku,
                                "ordered_qty"            =>    $qty,
                                "received_qty"            =>    "0",
                                "cost"                    =>    "0.00"
                        );
                        $this->Constant_model->insertData("purchase_order_items", $ins_po_item_data);
                    }
                }
                // New Item -- END;
                
                if ($po_status == "2") {
                    $this->session->set_flashdata('alert_msg', array('success', 'Update Purchase Order', "Successfully Sent Purchase Order : $po_numb to Supplier."));
                    redirect(base_url().'purchase_order/view_purchase_order?po_id='.$po_id);
                } else {
                    $this->session->set_flashdata('alert_msg', array('success', 'Update Purchase Order', "Successfully Updated Purchase Order : $po_numb"));
                    redirect(base_url().'purchase_order/edit_purchase_order?po_id='.$po_id);
                }
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Update Purchase Order', "Purchase Order Number : <b>$po_numb</b> is already existing in the system! Please try another one!"));
                redirect(base_url().'purchase_order/edit_purchase_order?po_id='.$po_id);
            }
            unset($ckPONumbResult);
            unset($ckPONumbRows);
        }
    }
    
    // Insert Purchase Order;
    public function insertPurchaseOrder()
    {
        $po_numb    = strip_tags($this->input->post("po_numb"));
        $supplier    = strip_tags($this->input->post("supplier"));
        $note        = strip_tags($this->input->post("note"));
        
        $po_date    = date("Y-m-d", time());
        $row_count    = $this->input->post('row_count');
        
        $us_id        = $this->session->userdata('user_id');
        $tm        = date('Y-m-d H:i:s', time());
        
        if (empty($po_numb)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Create Purchase Order', 'Please enter Purchase Order Number!'));
            redirect(base_url().'purchase_order/create_purchase_order');
        } elseif (empty($supplier)) {
            $this->session->set_flashdata('alert_msg', array('failure', 'Create Purchase Order', 'Please select Supplier for Purchase Order!'));
            redirect(base_url().'purchase_order/create_purchase_order');
        } else {
            $ckPONumbResult        = $this->db->query("SELECT id FROM purchase_order WHERE po_number = '$po_numb' ");
            $ckPONumbRows            = $ckPONumbResult->num_rows();
            if ($ckPONumbRows == 0) {
                $supplierData        = $this->Constant_model->getDataOneColumn("suppliers", "id", $supplier);
                $supplier_name        = $supplierData[0]->name;
                $supplier_email    = $supplierData[0]->email;
                $supplier_tel        = $supplierData[0]->telephone;
                $supplier_fax        = $supplierData[0]->fax;
                $supplier_address    = $supplierData[0]->address;
                $supplier_tax        = $supplierData[0]->tax;
                
                $ins_data            = array(
                        "po_number"                =>    $po_numb,
                        "discount_amount"        =>    "0.00",
                        "discount_percentage"    =>    "",
                        "subTotal"                =>    "0.00",
                        "tax"                    =>    "0.00",
                        "grandTotal"            =>    "0.00",
                        "supplier_id"            =>    $supplier,
                        "supplier_name"            =>    $supplier_name,
                        "supplier_email"        =>    $supplier_email,
                        "supplier_tel"            =>    $supplier_tel,
                        "supplier_fax"            =>    $supplier_fax,
                        "supplier_address"        =>    $supplier_address,
                        "supplier_tax"            =>    $supplier_tax,
                        "po_date"                =>    $po_date,
                        "note"                    =>    $note,
                        "created_user_id"        =>    $us_id,
                        "created_datetime"        =>    $tm,
                        "status"                =>    "1"
                );
                $po_id    = $this->Constant_model->insertDataReturnLastId("purchase_order", $ins_data);
                
                // Items;
                for ($i = 1; $i <= $row_count; $i++) {
                    $sku        = $this->input->post("sku_".$i);
                    $qty        = $this->input->post("qty_".$i);
                    
                    if ($qty > 0) {
                        $matDtaData    = $this->Constant_model->getDataOneColumn("materials", "sku", $sku);
                        $mat_id        = $matDtaData[0]->id;
                    
                        $ins_po_item_data    = array(
                                "purchase_order_id"        =>    $po_id,
                                "material_id"            =>    $mat_id,
                                "material_sku"            =>    $sku,
                                "ordered_qty"            =>    $qty,
                                "received_qty"            =>    "0",
                                "cost"                    =>    "0.00"
                        );
                        $this->Constant_model->insertData("purchase_order_items", $ins_po_item_data);
                    }
                }
                
                $this->session->set_flashdata('alert_msg', array('success', 'Create Purchase Order', "Successfully Created Purchase Order : $po_numb"));
                redirect(base_url().'purchase_order/po_view');
            } else {
                $this->session->set_flashdata('alert_msg', array('failure', 'Create Purchase Order', "Purchase Order Number : <b>$po_numb</b> is already existing in the system! Please try another one!"));
                redirect(base_url().'purchase_order/create_purchase_order');
            }
            unset($ckPONumbResult);
            unset($ckPONumbRows);
        }
    }
    
    
    // *************************** Action to DB -- END *************************** //
    
    
    // *************************** Export Action -- START *************************** //
    
   
    
    // *************************** Export Action -- END *************************** //
    
    
    public function checkPcode()
    {
        $sku            = $this->input->get('sku');

        $ckPcodeResult = $this->db->query("SELECT * FROM materials WHERE sku = '$sku' ");
        $ckPcodeRows = $ckPcodeResult->num_rows();

        if ($ckPcodeRows == 0) {
            $response = array(
                'errorMsg' => 'failure',
                'name' => '',
            );
        } else {
            $ckPcodeData = $ckPcodeResult->result();
            $ckPcode_name = $ckPcodeData[0]->name;

            $response = array(
                'errorMsg'    => 'success',
                'name'        => $ckPcode_name,
            );
        }
        echo json_encode($response);
    }
}
