<?php
    require_once "includes/header.php";
    
    $serviceDtaData        = $this->Constant_model->getDataOneColumn("service_jobs", "id", $job_id);
    
    $cust_id                = $serviceDtaData[0]->customer_id;
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
    $service_status        = $serviceDtaData[0]->status;
    
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
    
    $custDtaData            = $this->Constant_model->getDataOneColumn("customers", "id", $cust_id);
    $cust_group_id            = $custDtaData[0]->customer_group;
    
    $group_percent            = 0;
    $group_name            = "";
    
    $groupData                = $this->Constant_model->getDataOneColumn("customer_groups", "id", $cust_group_id);
    $group_percent            = $groupData[0]->discount_percentage;
    $group_name            = $groupData[0]->name;
?>
<script src="<?=base_url()?>assets/multisteps/jquery-1.8.2.min.js"></script>
<script src="<?=base_url()?>assets/multisteps/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/multisteps/jquery.wizard.js"></script>
<!-- <link href="<?=base_url()?>assets/multisteps/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<link href="<?=base_url()?>assets/multisteps/jquery.wizard.css" rel="stylesheet">
<style type="text/css">
  
  .sidebar-nav {
    padding: 9px 0;
  }

  [data-wizard-init] {
	margin: auto;
	width: 600px;
  }
</style>
<script type="text/javascript">
	function kk(){
		var status 	= confirm('Are you confirm to generate Invoice for Job Id : <?php echo $job_id; ?>?');
		
		if(status == true){
			document.getElementById("nextGo").style.display = "none";
			document.getElementById("pwait").style.display = "block";	
			
			return true;
		} else {
			return false;
		}
	}
</script>

<form action="<?=base_url()?>services/submitGenerateInvoice" method="post" onsubmit="return kk()">
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Verify Generate Invoice for : Job Id <?php echo $job_id; ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					<table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
						<tr>
							<td width="50%">
								Verify Generate Invoice for : Job Id <?php echo $job_id; ?>
							</td>
							<td width="50%" style="text-align: right;"></td>
						</tr>
					</table>
				</div>	
				<div class="panel-body" style="padding: 25px;">
					
					<?php
                        if (!empty($alert_msg)) {
                            $flash_status = $alert_msg[0];
                            $flash_header = $alert_msg[1];
                            $flash_desc = $alert_msg[2];

                            if ($flash_status == 'failure') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-warning" role="alert">
										<i class="icono-exclamationCircle" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php	
                            }
                            if ($flash_status == 'success') {
                                ?>
							<div class="row" id="notificationWrp">
								<div class="col-md-12">
									<div class="alert bg-success" role="alert">
										<i class="icono-check" style="color: #FFF;"></i> 
										<?php echo $flash_desc; ?> <i class="icono-cross" id="closeAlert" style="cursor: pointer; color: #FFF; float: right;"></i>
									</div>
								</div>
							</div>
					<?php

                            }
                        }
                    ?>
					
					<div class="row">
						<div class="col-md-6">
							<div class="row">
								<div class="col-md-12">
									<img src="<?=base_url()?>assets/images/logo/<?php echo $siteData_logo; ?>" height="100px" />
								</div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 3px;">
								<div class="col-md-12" style="font-size: 18px;">
									<?php echo $siteDta_name; ?>
								</div>
							</div>
							<?php
                                if (!empty($siteDta_address)) {
                                    ?>
									<div class="row" style="padding-top: 3px; padding-bottom: 3px;">
										<div class="col-md-12">
											<?php echo nl2br($siteDta_address); ?>	
										</div>
									</div>		
							<?php

                                }
                                
                                if (!empty($siteDta_tel)) {
                                    ?>
									<div class="row" style="padding-top: 3px; padding-bottom: 3px;">
										<div class="col-md-12">
											Tel : <?php echo $siteDta_tel; ?>	
										</div>
									</div>
							<?php

                                }
                                
                                if (!empty($siteDta_fax)) {
                                    ?>
									<div class="row" style="padding-top: 3px; padding-bottom: 3px;">
										<div class="col-md-12">
											Fax : <?php echo $siteDta_fax; ?>	
										</div>
									</div>
							<?php

                                }
                            ?>
						</div>
						<div class="col-md-2"></div>
						<div class="col-md-4">
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Invoice Number :</div>
								<div class="col-md-5"></div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Service Job Id :</div>
								<div class="col-md-5">#<?php echo $job_id; ?></div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Service Date :</div>
								<div class="col-md-5"><?php echo $service_date; ?></div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Plate Number :</div>
								<div class="col-md-5"><?php echo $car_plate_numb; ?></div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Current Mileage :</div>
								<div class="col-md-5"><?php echo $car_mileage; ?> KM</div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Customer Name :</div>
								<div class="col-md-5"><?php echo $cust_fn." ".$cust_ln; ?></div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Customer Mobile :</div>
								<div class="col-md-5"><?php echo $cust_mb; ?></div>
							</div>
							<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
								<div class="col-md-7" style="text-align: right;">Technician Name :</div>
								<div class="col-md-5"><?php echo $technician_name; ?></div>
							</div>
						</div>
					</div>
						
					<?php
                        $total_all_price    = 0;
                        
                        $total_package_price= 0;
                        
                        $serpackResult        = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
                        $serpackRows        = $serpackResult->num_rows();
                        
                        if ($serpackRows > 0) {
                            ?>
					<div class="row" style="margin-top: 30px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<tr>
										<td colspan="2" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 0px;">
											<label>Service Package</label>
										</td>
									</tr>
									<tr>
							            <th width="80%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Package Name</span></th>
								    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF; text-align: right;"><span>Package Price</span></th>
									</tr>
									<?php
                                        $serpackData    = $serpackResult->result();
                            for ($sp = 0; $sp < count($serpackData); $sp++) {
                                $serpack_name        = $serpackData[$sp]->package_name;
                                $serpack_price        = $serpackData[$sp]->package_price; ?>
											<tr>
												<td><?php echo $serpack_name; ?></td>
												<td style="text-align: right;"><?php echo "$".number_format($serpack_price, 2); ?></td>
											</tr>
									<?php
                                            $total_package_price    += $serpack_price;
                                            
                                $total_all_price        += $serpack_price;
                                        
                                unset($serpack_name);
                                unset($serpack_price);
                            }
                            unset($serpackData); ?>
								</table>
							</div>
						</div>
					</div>
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
							<div class="row" style="margin-top: 0px;">
								<div class="col-md-12">
									<div class="table-responsive">
										<table class="table">
											<tr>
												<td colspan="3" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 0px;">
													<label>Reported Defects Materials</label>
												</td>
											</tr>
											<tr>
									            <th width="40%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Reported Defects (Remarks)</span></th>
									            <th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Material</span></th>
									            <th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Qty.</span></th>
									            <th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Per Item</span></th>
										    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Price</span></th>
											</tr>
											<?php
                                                $defectData    = $defectResult->result();
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
                                                        
                                    $each_row_price = 0;
                                    $each_row_price = $mat_issued_qty * $mat_price;
                                                        
                                    $total_all_price    += $each_row_price; ?>
											<tr>
												<td>
													<?php
                                                        if ($dfm == 0) {
                                                            echo $defect_name;
                                                        
                                                            if (!empty($defect_remark)) {
                                                                echo "(".$defect_remark.")";
                                                            }
                                                        } ?>
												</td>
												<td><?php echo $mat_name; ?></td>
												<td><?php echo $mat_issued_qty; ?></td>
												<td><?php echo "$".number_format($mat_price, 2); ?></td>
												<td style="text-align: right;"><?php echo "$".number_format($each_row_price, 2); ?></td>
											</tr>	
											<?php
                                                        unset($mat_name);
                                    unset($mat_issued_qty);
                                    unset($mat_price);
                                }
                                unset($defectMatResult);
                                unset($defectMatData);

                                unset($defect_id);
                                unset($defect_name);
                                unset($defect_remark);
                            }
                            unset($defectData); ?>
										</table>
									</div>
								</div>
							</div>
					<?php

                        }
                        unset($defectResult);
                        unset($defectRows);
                    ?>
					
					<?php
                        $subTotal_amt        = 0;
                        $taxTotal_amt        = 0;
                        $grandTotal_amt    = 0;
                        
                        $discount_amt        = 0;
                        if ($group_percent > 0) {
                            $discount_amt        = number_format(($total_all_price * ($group_percent/100)), 2, '.', '');
                            
                            $total_all_price    = $total_all_price - $discount_amt;
                        }
                        
                        $subTotal_amt        = $total_all_price;
                        $taxTotal_amt        = number_format(($subTotal_amt * ($tax_percent / 100)), 2, '.', '');
                        $grandTotal_amt    = number_format(($subTotal_amt + $taxTotal_amt), 2, '.', '');
                    ?>
					
					<div class="row" style="border-top: 1px solid #ddd; padding-top: 10px;">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table">
									<?php
                                        if ($group_percent > 0) {
                                            ?>
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;" valign="middle">
											<label style="font-weight: bold;">Discount (<?php echo $group_name; ?> <?php echo $group_percent; ?>%) :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold;">-$<?php echo number_format($discount_amt, 2); ?></label>
										</td>
									</tr>
									<?php

                                        }
                                    ?>
									
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;" valign="middle">
											<label style="font-weight: bold;">Sub Total :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold;">$<?php echo number_format($subTotal_amt, 2); ?></label>
										</td>
									</tr>
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;">
											<label style="font-weight: bold;">Tax (<?php echo $tax_percent; ?>%) :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold;">$<?php echo number_format($taxTotal_amt, 2); ?></label>
										</td>
									</tr>
									<tr>
										<td width="50%" height="30px" style="border-top: 0px; padding: 0px;"></td>
										<td width="30%" style="text-align: right; border-top: 0px; padding: 0px;">
											<label style="font-weight: bold;">Grand Total :</label>
										</td>
										<td width="20%" style="border-top: 0px; text-align: right; padding: 0px;">
											<label style="font-weight: bold;">$<?php echo number_format($grandTotal_amt, 2); ?></label>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
					
					<?php
                        if ($service_status == "5") {
                            ?>
					<div class="row" style="padding-top: 20px; padding-bottom: 20px;">
						<div class="col-md-12" style="text-align: center;">
							<input type="hidden" name="job_id" value="<?php echo $job_id; ?>" />
							<input type="hidden" name="discountTotal" value="-<?php echo $discount_amt; ?>" />
							<input type="hidden" name="discount_percentage" value="<?php echo $group_percent; ?>" />
							<input type="hidden" name="subTotal" value="<?php echo $subTotal_amt; ?>" />
							<input type="hidden" name="taxTotal" value="<?php echo $taxTotal_amt; ?>" />
							<input type="hidden" name="grandTotal" value="<?php echo $grandTotal_amt; ?>" />
							
							<button type="submit" class="btn btn-primary" style="padding: 14px 30px; font-size: 20px;" id="nextGo">
								Generate Invoice
							</button>
							
							<span id="pwait" class="pull-left" style="font-size: 13px; color: #4a4a4a; margin-top: 7px; display: none; width: 100%;">
		                    	<center><img src="<?=base_url()?>assets/images/loading.gif" /> Processing ..........</center>
		                    </span>
						</div>	
					</div>
					<?php

                        }
                    ?>
					
					<div class="row">
						<div class="col-md-12" style="text-align: left;">
							<a href="<?=base_url()?>services/completed_services_view?job_id=<?php echo $job_id; ?>" style="text-decoration: none;">
								<div class="btn btn-default" style="background-color: #4a4a4a; color: #FFF; border-radius: 3px; border: 1px solid #111;">
									&nbsp;&nbsp;Back&nbsp;&nbsp;
								</div>
							</a>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
	
</div>
</form>

<?php
    require_once "includes/footer.php";
?>