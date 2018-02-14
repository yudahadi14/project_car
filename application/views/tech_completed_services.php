<?php
    require_once "includes/header.php";
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Completed Services</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
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
					
					<div class="table-responsive">
					<table id="example" class="display" cellspacing="0" width="100%">
					    <thead>
					        <tr>
					            <th width="5%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Job Id</th>
					            <th width="15%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Service Advisor</th>
						    	<th width="10%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Technician</th>
						    	<th width="12%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Customer</th>
						    	<th width="10%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Car</th>
						    	<th width="10%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Plate No.</th>
						    	<th width="15%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Started Date</th>
						    	<th width="10%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Status</th>
						    	<th width="8%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Action</th>
					        </tr>
					    </thead>
						<tbody>
						<?php
                            if (count($results) > 0) {
                                foreach ($results as $data) {
                                    $job_id        = $data->id;
                                    $plate_numb    = $data->car_plate_number;
                                    $cust_fn        = $data->firstname;
                                    $cust_ln        = $data->lastname;
                                    $cust_mb        = $data->mobile;
                                    $mileage        = $data->mileage_after;
                                    $tech_id        = $data->technician_id;
                                    $advisor_id    = $data->service_advisor_id;
                                    $status_id        = $data->status;
                                    $created_dtm    = date("$dateformat h:i A", strtotime($data->created_datetime));
                                    $car_id        = $data->car_id;
                                    
                                    $tech_name        = "";
                                    $techDtaData    = $this->Constant_model->getDataOneColumn("users", "id", $tech_id);
                                    $tech_name        = $techDtaData[0]->fullname;
                                    
                                    $advisor_name    = "";
                                    $advisorDtaData    = $this->Constant_model->getDataOneColumn("users", "id", $advisor_id);
                                    $advisor_name    = $advisorDtaData[0]->fullname;
                                    
                                    $status_name    = "";
                                    $statusNameData    = $this->Constant_model->getDataOneColumn("service_job_status", "id", $status_id);
                                    $status_name    = $statusNameData[0]->name;
                                    
                                    $carDtaData    = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
                                    $car_model        = $carDtaData[0]->car_model;
                                    $car_make_id    = $carDtaData[0]->car_make_id;
                                    
                                    $carMakeNameData= $this->Constant_model->getDataOneColumn("car_make", "id", $car_make_id);
                                    $car_make_name    = $carMakeNameData[0]->name; ?>
									<tr>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;">#<?php echo $job_id; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $advisor_name; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $tech_name; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $cust_fn." ".$cust_ln; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;">
											<?php echo $car_make_name." ".$car_model; ?>
										</td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $plate_numb; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $created_dtm; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px; font-weight: bold;">
											<?php echo $status_name; ?>
										</td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;">
											<a href="<?=base_url()?>technician_services/tech_completed_services_view?job_id=<?php echo $job_id; ?>" style="text-decoration: none;">
												<div class="btn btn-primary">&nbsp;&nbsp;View&nbsp;&nbsp;</div>
											</a>
										</td>
									</tr>
						<?php
                                    unset($job_id);
                                    unset($plate_numb);
                                    unset($cust_fn);
                                    unset($cust_ln);
                                    unset($cust_mb);
                                    unset($mileage);
                                    unset($tech_id);
                                    unset($advisor_id);
                                    unset($status_id);
                                    unset($created_dtm);
                                    unset($car_id);
                                }
                            }
                        ?>
						</tbody>
					</table>
					</div>
					
					<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
							<?php echo $displayshowingentries; ?>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<?php echo $links; ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    require_once "includes/footer.php";
?>