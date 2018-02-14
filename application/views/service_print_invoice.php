<?php
    $serviceDtaData        = $this->Constant_model->getDataOneColumn("service_jobs", "id", $job_id);
    
    $invoice_numb            = $serviceDtaData[0]->invoice_number;
    $cust_fn                = $serviceDtaData[0]->firstname;
    $cust_ln                = $serviceDtaData[0]->lastname;
    $cust_em                = $serviceDtaData[0]->email;
    $cust_mb                = $serviceDtaData[0]->mobile;
    $car_id                = $serviceDtaData[0]->car_id;
    $car_plate_numb        = $serviceDtaData[0]->car_plate_number;
    $car_mileage            = $serviceDtaData[0]->mileage_after;
    $service_advisor_id    = $serviceDtaData[0]->service_advisor_id;
    $service_tech_id        = $serviceDtaData[0]->technician_id;
    $service_date            = date("$dateformat", strtotime($serviceDtaData[0]->created_datetime));
    $dis_amt                = $serviceDtaData[0]->discount_amt;
    $dis_percent            = $serviceDtaData[0]->discount_percentage;
    $subTotal                = $serviceDtaData[0]->subtotal_amt;
    $taxTotal                = $serviceDtaData[0]->tax_amt;
    $grandTotal            = $serviceDtaData[0]->grandtotal_amt;
    
    $advisor_fullname        = "";
    $advisorDtaData        = $this->Constant_model->getDataOneColumn("users", "id", $service_advisor_id);
    $advisor_fullname        = $advisorDtaData[0]->fullname;
    
    $technician_name        = "";
    $techDtaData            = $this->Constant_model->getDataOneColumn("users", "id", $service_tech_id);
    $technician_name        = $techDtaData[0]->fullname;
    
    
    $siteDtaResult            = $this->db->get_where('site_setting');
    $siteDtaData            = $siteDtaResult->row();
    
    $siteDta_name            = $siteDtaData->site_name;
    $siteDta_address        = $siteDtaData->address;
    $siteDta_tel            = $siteDtaData->telephone;
    $siteDta_fax            = $siteDtaData->fax;
    $siteData_logo            = $siteDtaData->site_logo;
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Print Invoice</title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 950px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 950px; 
		margin: 0px auto; 
	}
	#wrapper img { 
		max-width: 300px; 
		width: auto; 
	}

	h2, h3, p { 
		margin: 5px 0;
	}
	.left { 
		width:100%; 
		float:left; 
		text-align:left; 
		margin-bottom: 3px;
		margin-top: 3px;
	}
	.right { 
		width:40%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px; 
	}
	.table, .totals { 
		width: 100%; 
		margin:10px 0; 
	}
	.table th { 
		border-top: 1px solid #000; 
		border-bottom: 1px solid #000; 
		padding-top: 4px;
		padding-bottom: 4px;
	}
	.table td { 
		padding:0; 
	}
	.totals td { 
		width: 24%; 
		padding:0; 
	}
	.table td:nth-child(2) { 
		overflow:hidden; 
	}

	@media print {
		body { text-transform: uppercase; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:9px; }
		#bkpos_wrp{
			display: none;
		}
	}
</style>
<script type="text/javascript">
	function printByClick(){
		window.print();
	}
</script>
</head>

<body>
<div id="wrapper">
    
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px;" width="100%" height="auto">
		<tr>
			<td width="100%" height="auto" align="center">
				<h1 style="font-size: 40px; color: #005b8a;">Service Invoice</h1>
			</td>
		</tr>
	</table>
	
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 0px; border-top: 0px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="100%" align="left">
							<img src="<?=base_url()?>assets/images/logo/<?php echo $siteData_logo; ?>" />
						</td>
					</tr>
					<tr>
						<td height="0px">&nbsp;</td>
					</tr>
					<tr>
						<td width="100%" align="left" style="font-size: 18px;" style="padding-top: 3px; padding-bottom: 3px;"><?php echo $siteDta_name; ?></td>
					</tr>
					<?php
                        if (!empty($siteDta_address)) {
                            ?>
							<tr>
								<td width="100%" align="left" style="padding-top: 3px; padding-bottom: 3px; line-height: 20px;">
									<?php echo nl2br($siteDta_address); ?>
								</td>
							</tr>
					<?php	
                        }
                        
                        if (!empty($siteDta_tel)) {
                            ?>
							<tr>
								<td width="100%" align="left" style="padding-top: 3px; padding-bottom: 3px;">Tel : <?php echo $siteDta_tel; ?></td>
							</tr>
					<?php

                        }
                        if (!empty($siteDta_fax)) {
                            ?>
							<tr>
								<td width="100%" align="left" style="padding-top: 3px; padding-bottom: 3px;">Fax : <?php echo $siteDta_fax; ?></td>
							</tr>
					<?php

                        }
                    ?>
				</table>
			</td>
			<td width="10%" height="auto" align="right" valign="top"></td>
			<td width="40%" height="auto" align="right" valign="top">
				<table border="0" style="border-collapse: collapse; margin-top: 50px;" width="100%" height="auto">
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Invoice :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $invoice_numb; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Service Job Id :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;#<?php echo $job_id; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Service Date :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $service_date; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Plate Number :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $car_plate_numb; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Current Mileage :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $car_mileage; ?> KM</td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Customer Name :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $cust_fn." ".$cust_ln; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Customer Mobile :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $cust_mb; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Service Advisor Name :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $advisor_fullname; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Technician Name :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $technician_name; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<?php
        $serpackResult        = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $serpackRows        = $serpackResult->num_rows();
        
        if ($serpackRows > 0) {
            ?>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 20px; border-top: 0px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
		<tr>
			<td colspan="2" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 5px; font-weight: bold;" align="left">
				<label>Service Package</label>
			</td>
		</tr>
		<tr>
            <th width="80%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-size: 15px;" align="left"><span>Package Name</span></th>
	    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-size: 15px; padding-right: 10px;" align="right"><span>Package Price</span></th>
		</tr>
		<?php
            $serpackData    = $serpackResult->result();
            for ($sp = 0; $sp < count($serpackData); $sp++) {
                $serpack_name        = $serpackData[$sp]->package_name;
                $serpack_price        = $serpackData[$sp]->package_price; ?>
		<tr>
			<td style="border-bottom: 1px solid #ddd !important; height: 35px; font-size: 13px;" align="left">
				<?php echo $serpack_name; ?>
			</td>
			<td style="border-bottom: 1px solid #ddd !important; height: 35px; font-size: 13px; padding-right: 10px;" align="right">
				$<?php echo number_format($serpack_price, 2); ?>
			</td>
		</tr>
		<?php
                unset($serpack_name);
                unset($serpack_price);
            }
            unset($serpackData); ?>
	</table>
	<?php

        }
        unset($serpackResult);
        unset($serpackRows);
    ?>
	
	<?php
        $defectResult        = $this->db->query("SELECT * FROM service_job_defects WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $defectRows        = $defectResult->num_rows();
        if ($defectRows > 0) {
            ?>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 20px; border-top: 0px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
		<tr>
			<td colspan="5" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 5px; font-weight: bold;" align="left">
				<label>Reported Defects Materials</label>
			</td>
		</tr>
		<tr>
			<th width="30%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-size: 15px;" align="left"><span>Reported Defects (Remarks)</span></th>
			<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-size: 15px;" align="left"><span>Material</span></th>
			<th width="10%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-size: 15px;" align="center"><span>Qty.</span></th>
			<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-size: 15px;" align="right"><span>Per Item</span></th>
			<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-size: 15px; padding-right: 10px;" align="right"><span>Price</span></th>
		</tr>
		<?php
            $defectData            = $defectResult->result();
            for ($df = 0; $df < count($defectData); $df++) {
                $defect_id            = $defectData[$df]->id;
                $defect_name        = $defectData[$df]->defect_name;
                $defect_remark        = $defectData[$df]->remarks;
                
                $defectMatResult    = $this->db->query("SELECT * FROM service_job_defects_material WHERE service_job_defects_id = '$defect_id' AND customer_approved = '1' AND status = '1' ");
                $defectMatData        = $defectMatResult->result();
                for ($dfm = 0; $dfm < count($defectMatData); $dfm++) {
                    $mat_name        = $defectMatData[$dfm]->material_name;
                    $mat_issued_qty    = $defectMatData[$dfm]->issued_qty;
                    $mat_price        = $defectMatData[$dfm]->price;
                    
                    $each_row_price    = 0;
                    $each_row_price = $mat_issued_qty * $mat_price; ?>
					<tr>
						<td style="border-bottom: 1px solid #ddd !important; height: 35px; font-size: 13px;" align="left">
							<?php
                                if ($dfm == 0) {
                                    echo $defect_name;
                                    if (!empty($defect_remark)) {
                                        echo " ($defect_remark)";
                                    }
                                } ?>
						</td>
						<td style="border-bottom: 1px solid #ddd !important; height: 35px; font-size: 13px;" align="left">
							<?php echo $mat_name; ?>
						</td>
						<td style="border-bottom: 1px solid #ddd !important; height: 35px; font-size: 13px;" align="center">
							<?php echo $mat_issued_qty; ?>
						</td>
						<td style="border-bottom: 1px solid #ddd !important; height: 35px; font-size: 13px;" align="right">
							$<?php echo number_format($mat_price, 2); ?>
						</td>
						<td style="border-bottom: 1px solid #ddd !important; height: 35px; font-size: 13px; padding-right: 10px;" align="right">
							$<?php echo number_format($each_row_price, 2); ?>
						</td>
					</tr>
		<?php

                    unset($mat_name);
                    unset($mat_issued_qty);
                    unset($mat_price);
                }
                unset($defectMatData);
                unset($defectMatResult);
                
                unset($defect_id);
                unset($defect_name);
                unset($defect_remark);
            }
            unset($defectData); ?>
	</table>
	<?php

        }
        unset($defectResult);
        unset($defectRows);
    ?>
	
	<table border="0" style="border-collapse: collapse; width: 100%; margin-top: 0px;">
		<tr>
			<td width="50%" valign="top">
				
				<table border="0" style="border-collapse: collapse; width: 100%; margin-top: 10px;">
				<?php
                    $payMethResult    = $this->db->query("SELECT * FROM service_job_payments WHERE service_job_id = '$job_id' AND invoice_numb = '$invoice_numb' ");                        $payMethRows    = $payMethResult->num_rows();
                    if ($payMethRows > 0) {
                        $payMethData    = $payMethResult->result();
                        
                        for ($pm = 0; $pm < count($payMethData); $pm++) {
                            $payMeth_key        = $payMethData[$pm]->payment_type_id;
                            $payMeth_name        = $payMethData[$pm]->payment_type_name;
                            $payMeth_amt        = $payMethData[$pm]->payment_amount;
                            $payMeth_cheque    = $payMethData[$pm]->cheque_number; ?>
				<tr>
					<td width="33%" style="font-weight: bold; height: 30px; font-size: 15px;" align="left">
						<?php
                            if ($pm == "0") {
                                echo "PAYMENT METHOD :";
                            } ?>
					</td>
					<td width="33%" align="right" style="font-size: 15px; padding-right: 20px;">
						<?php echo $payMeth_name; ?>
						<?php 
                            if (!empty($payMeth_cheque)) {
                                echo "(".$payMeth_cheque.")";
                            } ?>
					</td>
					<td width="33%" align="left" style="padding-left: 20px; font-size: 15px;">
						$<?php echo number_format($payMeth_amt, 2); ?>
					</td>
				</tr>
				<?php
                            unset($payMeth_key);
                            unset($payMeth_name);
                            unset($payMeth_amt);
                            unset($payMeth_cheque);
                        }
                        
                        unset($payMethData);
                    }
                    unset($payMethRows);
                    unset($payMethResult);
                ?>
					
				</table>
				
			</td>
			<td width="50%" valign="top">
				
				<table border="0" style="border-collapse: collapse; width: 100%; margin-top: 10px;">
					<?php
                        if ($dis_percent > 0) {
                            ?>
					<tr>
						<td width="20%"></td>
						<td width="40%" style="height: 30px; font-weight: bold; font-size: 15px;" align="right">
							Discount (<?php echo $dis_percent; ?>%):
						</td>
						<td width="40%" align="right" style="padding-right: 10px; font-size: 15px; font-weight: bold;">
							<?php echo "-$".number_format(abs($dis_amt), 2); ?>
						</td>
					</tr>
					<?php

                        }
                    ?>
					
					<tr>
						<td width="20%"></td>
						<td width="40%" style="height: 30px; font-weight: bold; font-size: 15px;" align="right">
							Sub Total :
						</td>
						<td width="40%" align="right" style="padding-right: 10px; font-size: 15px; font-weight: bold;">
							$<?php echo number_format($subTotal, 2); ?>
						</td>
					</tr>
					<tr>
						<td width="20%"></td>
						<td width="40%" style="height: 30px; font-weight: bold; font-size: 15px;" align="right">
							Tax :
						</td>
						<td width="40%" align="right" style="padding-right: 10px; font-size: 15px; font-weight: bold;">
							$<?php echo number_format($taxTotal, 2); ?>
						</td>
					</tr>
					<tr>
						<td width="20%"></td>
						<td width="40%" style="height: 30px; font-weight: bold; font-size: 15px;" align="right">
							Grand Total :
						</td>
						<td width="40%" align="right" style="padding-right: 10px; font-size: 15px; font-weight: bold;">
							$<?php echo number_format($grandTotal, 2); ?>
						</td>
					</tr>
					
				</table>
				
			</td>
		</tr>
	</table>
	
	<table border="0" style="border-collapse: collapse; margin-top: 20px; width: 100%; height: auto">
		<tr>
			<td width="30%"></td>
			<td width="40%">
				<div id="bkpos_wrp">
			    	<span class="left">
			    		<div style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#000; background-color:#FFA93C; border:1px solid #FFA93C; padding: 10px 0px; font-weight:bold; margin-top: 6px; cursor: pointer;" onclick="printByClick()">
				    		Print
				    	</div>
				    </span>
			    </div>
			</td>
			<td width="30%"></td>
		</tr>
		<tr>
			<td width="30%"></td>
			<td width="40%">
				<div id="bkpos_wrp">
			    	<a href="<?=base_url()?>services/closed_services_view?job_id=<?php echo $job_id; ?>" style="width:100%; display:block; font-size:12px; text-decoration: none; text-align:center; color:#FFF; background-color:#005b8a; border:0px solid #007FFF; padding: 10px 1px; margin: 5px auto 10px auto; font-weight:bold;">Back</a>
			    </div>
			</td>
			<td width="30%"></td>
		</tr>
	</table>
	
	
	
	<br /><br />
	
	
	
</div>

<script src="<?=base_url()?>assets/js/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(window).load(function() { window.print(); });
</script>
</body>
</html>
