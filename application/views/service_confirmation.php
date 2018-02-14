<?php
    require_once "includes/header.php";
    
    $serviceDtaData        = $this->Constant_model->getDataOneColumn("service_jobs", "id", $job_id);
    
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

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">New Service Confirmation : Job Id <?php echo $job_id; ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					<table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
						<tr>
							<td width="50%">
								New Service Confirmation : Job Id <?php echo $job_id; ?>
							</td>
							<td width="50%" style="text-align: right;">
								<a href="<?=base_url()?>services/print_service_confirmation?job_id=<?php echo $job_id; ?>" style="text-decoration: none;" target="_blank">
									<div class="btn btn-success">Print Confirmation</div>
								</a>
							</td>
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
								    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Package Price</span></th>
									</tr>
									<?php
                                        $serpackData    = $serpackResult->result();
                            for ($sp = 0; $sp < count($serpackData); $sp++) {
                                $serpack_name        = $serpackData[$sp]->package_name;
                                $serpack_price        = $serpackData[$sp]->package_price; ?>
											<tr>
												<td><?php echo $serpack_name; ?></td>
												<td><?php echo "$".number_format($serpack_price, 2); ?></td>
											</tr>
									<?php
                                            $total_package_price    += $serpack_price;
                                        
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
												<td colspan="2" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 0px;">
													<label>Reported Defects</label>
												</td>
											</tr>
											<tr>
									            <th width="80%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Name</span></th>
										    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 40px; border-top: 0px; background-color: #9b9b9b; color: #FFF;"><span>Remarks</span></th>
											</tr>
											<?php
                                                $defectData    = $defectResult->result();
                            for ($df = 0; $df < count($defectData); $df++) {
                                $defect_name        = $defectData[$df]->defect_name;
                                $defect_remark        = $defectData[$df]->remarks; ?>
													<tr>
														<td><?php echo $defect_name; ?></td>
														<td><?php echo $defect_remark; ?></td>
													</tr>
											<?php
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
						
							
						
					
					
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>