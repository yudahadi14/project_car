<?php
    require_once "includes/header.php";
    
    $serviceDtaData        = $this->Constant_model->getDataOneColumn("service_jobs", "id", $job_id);
    if (count($serviceDtaData) == 0) {
        redirect(base_url().'services/request_inventory_services', 'refresh');
    }
    
    $cust_fn                = $serviceDtaData[0]->firstname;
    $cust_ln                = $serviceDtaData[0]->lastname;
    $cust_em                = $serviceDtaData[0]->email;
    $cust_mb                = $serviceDtaData[0]->mobile;
    $car_id                = $serviceDtaData[0]->car_id;
    $car_plate_numb        = $serviceDtaData[0]->car_plate_number;
    $car_mileage            = $serviceDtaData[0]->mileage_after;
    $service_advisor_id    = $serviceDtaData[0]->service_advisor_id;
    $service_tech_id        = $serviceDtaData[0]->technician_id;
    $service_date            = date("$dateformat h:i A", strtotime($serviceDtaData[0]->created_datetime));
    $service_status_id        = $serviceDtaData[0]->status;
    
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
    
    $carDtaData            = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
    $car_model                = $carDtaData[0]->car_model;
    $car_make_id            = $carDtaData[0]->car_make_id;
    $car_color                = $carDtaData[0]->color;
    
    $carMakeNameData        = $this->Constant_model->getDataOneColumn("car_make", "id", $car_make_id);
    $car_make_name            = $carMakeNameData[0]->name;
    
    $status_name    = "";
    $statusNameData    = $this->Constant_model->getDataOneColumn("service_job_status", "id", $service_status_id);
    $status_name    = $statusNameData[0]->name;
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
			<h1 class="page-header">Request Inventory for Service : Job Id #<?php echo $job_id; ?></h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					<table border="0" style="border-collapse: collapse; width: 100%; height: auto;">
						<tr>
							<td width="50%">
								Request Inventory for Service : Job Id #<?php echo $job_id; ?>
							</td>
							<td width="50%" style="text-align: right;"></td>
						</tr>
					</table>
				</div>	
				<div class="panel-body" style="padding: 10px 15px 15px 15px;">
					
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
                    
                    <div class="row" style="border-bottom: 1px solid #ddd; padding-bottom: 15px;">
	                    <div class="col-md-6">
		                    
		                    <div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Customer Detail</label>
			                    </div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Customer Name</div>
			                    <div class="col-md-8">: <?php echo $cust_fn." ".$cust_ln; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Customer Mobile</div>
			                    <div class="col-md-8">: <?php echo $cust_mb; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Customer Email</div>
			                    <div class="col-md-8">: <?php echo $cust_em; ?></div>
		                    </div>
		                    
	                    </div><!-- Left // END -->
	                    <div class="col-md-6">
		                    
		                    <div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Car Detail</label>
			                    </div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Car Make</div>
			                    <div class="col-md-8">: <?php echo $car_make_name; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Car Model</div>
			                    <div class="col-md-8">: <?php echo $car_model; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Plate Number</div>
			                    <div class="col-md-8">: <?php echo $car_plate_numb; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Color</div>
			                    <div class="col-md-8">: <?php echo $car_color; ?></div>
		                    </div>
		                    <div class="row" style="padding-top: 5px; padding-bottom: 5px; padding-left: 20px;">
			                    <div class="col-md-4">Current Mileage</div>
			                    <div class="col-md-8">: <?php echo $car_mileage; ?>KM</div>
		                    </div>
		                    
	                    </div><!-- Right // END -->
                    </div>
					
					
					<div class="row" style="border-bottom: 1px solid #ddd; padding-bottom: 15px; padding-top: 15px;">
	                    <div class="col-md-6">
							<div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Service Packages</label>
			                    </div>
		                    </div>
		                    <?php
                                $serpackResult    = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
                                $serpackRows    = $serpackResult->num_rows();
                                
                                if ($serpackRows > 0) {
                                    ?>
		                    <div class="row" style="padding-left: 20px;">
			                    <div class="col-md-12">
				                    <div class="table-responsive">
										<table class="table">
											<tbody>
												<tr>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;">Package Name</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;">Package Price</td>
												</tr>
												<?php
                                                    $serpackData    = $serpackResult->result();
                                    for ($sp = 0; $sp < count($serpackData); $sp++) {
                                        $serpack_name    = $serpackData[$sp]->package_name;
                                        $serpack_price    = $serpackData[$sp]->package_price; ?>
												<tr>
													<td style="border-top: 0px; padding: 5px;"><?php echo $serpack_name; ?></td>
													<td style="border-top: 0px; padding: 5px;">$<?php echo number_format($serpack_price, 2); ?></td>
												</tr>
												<?php
                                                        unset($serpack_name);
                                        unset($serpack_price);
                                    }
                                    unset($serpackData); ?>
											</tbody>
										</table>
				                    </div>
			                    </div>
		                    </div>
							<?php

                                }
                                unset($serpackRows);
                                unset($serpackResult);
                            ?>
							
	                    </div><!-- Left // END -->
	                    <div class="col-md-6">
		                    
		                    <div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Report Defects</label>
			                    </div>
		                    </div>
							<?php
                                $defectResult        = $this->db->query("SELECT * FROM service_job_defects WHERE service_job_id = '$job_id' ORDER BY id DESC ");
                                $defectRows        = $defectResult->num_rows();
                                if ($defectRows > 0) {
                                    ?>
							<div class="row" style="padding-left: 20px;">
			                    <div class="col-md-12">
				                    <div class="table-responsive">
					                    <table class="table">
											<tbody>
												<tr>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;">Name</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;">Remarks</td>
												</tr>
												<?php
                                                    $defectData    = $defectResult->result();
                                    for ($df = 0; $df < count($defectData); $df++) {
                                        $defect_name        = $defectData[$df]->defect_name;
                                        $defect_remark        = $defectData[$df]->remarks; ?>
												<tr>
													<td style="border-top: 0px; padding: 5px;"><?php echo $defect_name; ?></td>
													<td style="border-top: 0px; padding: 5px;"><?php echo $defect_remark; ?></td>
												</tr>
												<?php
                                                        unset($defect_name);
                                        unset($defect_remark);
                                    }
                                    unset($defectData); ?>
											</tbody>
					                    </table>
				                    </div>
			                    </div>
							</div>
							<?php

                                }
                                unset($defectRows);
                                unset($defectRows);
                            ?>
	                    </div><!-- Right // END -->
					</div>	
	
<script type="text/javascript">
	function checkDefectMatQty(qty, eleId){
		var mat_id 	= document.getElementById("sjdm_mat_id_"+eleId).value;
		var mat_sku	= document.getElementById("sjdm_mat_sku_"+eleId).value;
		
		var checkMatQty = $.ajax({
			url		: '<?=base_url()?>services/getMaterialQty?mat_id='+mat_id+'&mat_sku='+mat_sku,
			type	: 'GET',
			cache	: false,
			data	: {
				format: 'json'
			},
			error	: function() {
				//alert("Sorry! we do not have stock!");
			},
			dataType: 'json',
			success	: function(data) {
				var inv_qty 		= data.quantity;
				inv_qty 			= parseFloat(inv_qty);
				
				qty 				= parseFloat(qty);
				
				if(qty > inv_qty){
					document.getElementById("sjdm_mat_qty_"+eleId).value 	= "";
					$('#outofstockwrp').modal('show');
					//alert("Out of Stock! Please update inventory OR make Purchase Order to Supplier!");
				}
			}
		});
	}
</script>
<div id="outofstockwrp" class="modal fade"> 
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-body" style="overflow: visible; background-color: #FFF; border-radius: 12px;">
				
				<div class="row">
					<div class="col-md-12" style="text-align: center; font-size: 25px; padding-top: 20px; padding-bottom: 20px; color: #c72a25;">
						Out of Stock!	
						<br />Please update inventory OR make Purchase Order to Supplier!
					</div>
				</div>
				
			</div>
		</div>
	</div>
</div>
							
					<form action="<?=base_url()?>services/issueMaterial" method="post" onsubmit="return confirm('Are you confirm to Issue below Materials?')">
					<?php
                        $reqDefectResult    = $this->db->query("SELECT * FROM service_job_defects_material WHERE service_job_id = '$job_id' ORDER BY id DESC ");
                        $reqDefectRows        = $reqDefectResult->num_rows();
                        if ($reqDefectRows > 0) {
                            ?>
					<div class="row" style="border-bottom: 1px solid #ddd; padding-bottom: 15px; padding-top: 15px;">
	                    <div class="col-md-12">
							<div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Requested Inventory Lists for Report Defects</label>
			                    </div>
		                    </div>
		                    <div class="row" style="margin-top: 10px;">
			                    <div class="col-md-12">
				                    <div class="table-responsive">
					                    <table class="table">
											<tbody>
												<tr>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Name</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Remarks</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Request Materials</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Request Qty.</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Issue Qty.</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Price (Per Item)</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Action</td>
												</tr>
												<?php
                                                    $reqDefectData    = $reqDefectResult->result();
                            for ($rd = 0; $rd < count($reqDefectData); $rd++) {
                                $sjdm_id                = $reqDefectData[$rd]->id;
                                $reqDefect_id            = $reqDefectData[$rd]->service_job_defects_id;
                                $reqDefect_mat_id        = $reqDefectData[$rd]->material_id;
                                $reqDefect_mat_name        = $reqDefectData[$rd]->material_name;
                                $reqDefect_mat_sku        = $reqDefectData[$rd]->material_sku;
                                $reqDefect_mat_qty        = $reqDefectData[$rd]->request_qty;
                                $reqDefect_status        = $reqDefectData[$rd]->status;
                                $reqDefect_cust_approved= $reqDefectData[$rd]->customer_approved;
                                                        
                                if ($reqDefect_cust_approved == "2") {
                                    continue;
                                }
                                                        
                                $defectDtaData        = $this->Constant_model->getDataOneColumn("service_job_defects", "id", $reqDefect_id);
                                $defect_name        = $defectDtaData[0]->defect_name;
                                $defect_remarks    = $defectDtaData[0]->remarks; ?>
														<tr>
															<td><?php echo $defect_name; ?></td>
															<td><?php echo $defect_remarks; ?></td>
															<td><?php echo $reqDefect_mat_name; ?> (<?php echo $reqDefect_mat_sku; ?>)</td>
															<td><?php echo $reqDefect_mat_qty; ?></td>
															<td>
					<input type="hidden" id="sjdm_mat_id_<?php echo $sjdm_id; ?>" value="<?php echo $reqDefect_mat_id; ?>" />
					<input type="hidden" id="sjdm_mat_sku_<?php echo $sjdm_id; ?>" value="<?php echo $reqDefect_mat_sku; ?>" />
					<input type="text" id="sjdm_mat_qty_<?php echo $sjdm_id; ?>" onkeyup="checkDefectMatQty(this.value, <?php echo $sjdm_id; ?>)" name="sjdm_qty_<?php echo $sjdm_id; ?>" class="form-control" style="width: 80%;" required />
															</td>
															<td>
		<input type="text" name="sjdm_price_<?php echo $sjdm_id; ?>" class="form-control" style="width: 80%;" required />
															</td>
															<td style="font-weight: bold;">
										<a href="<?=base_url()?>services/rejectDefectMaterial?sjdm_id=<?php echo $sjdm_id; ?>&job_id=<?php echo $job_id; ?>" style="text-decoration: none;" onclick="return confirm('Are you confirm to remove this Materal?')">
											<i class="icono-cross" style="color: #990202;"></i>
										</a>
															</td>
														</tr>
												<?php
                                                        unset($sjdm_id);
                                unset($reqDefect_id);
                                unset($reqDefect_mat_id);
                                unset($reqDefect_mat_sku);
                                unset($reqDefect_mat_name);
                                unset($reqDefect_mat_qty);
                                unset($reqDefect_status);
                            }
                            unset($reqDefectData); ?>
											</tbody>
					                    </table>
				                    </div>
			                    </div>
		                    </div>
	                    </div>
					</div>
					<?php

                        }
                        unset($reqDefectResult);
                        unset($reqDefectRows);
                    ?>
					
<script type="text/javascript">
	function checkPackMat(qty, eleId){
		var mat_id 	= document.getElementById("sjm_id_"+eleId).value;
		var mat_sku	= document.getElementById("sjm_sku_"+eleId).value;
		
		var checkMatQty = $.ajax({
			url		: '<?=base_url()?>services/getMaterialQty?mat_id='+mat_id+'&mat_sku='+mat_sku,
			type	: 'GET',
			cache	: false,
			data	: {
				format: 'json'
			},
			error	: function() {
				//alert("Sorry! we do not have stock!");
			},
			dataType: 'json',
			success	: function(data) {
				var inv_qty 		= data.quantity;
				inv_qty 			= parseFloat(inv_qty);
				
				qty 				= parseFloat(qty);
				
				if(qty > inv_qty){
					document.getElementById("sjp_qty_"+eleId).value 	= "";
					$('#outofstockwrp').modal('show');
					//alert("Out of Stock! Please update inventory OR make Purchase Order to Supplier!");
				}
			}
		});
	}
</script>					
					<?php
                        $reqpackageResult    = $this->db->query("SELECT * FROM service_job_package_material WHERE service_job_id = '$job_id' ORDER BY id DESC ");
                        $reqpackageRows    = $reqpackageResult->num_rows();
                        if ($reqpackageRows > 0) {
                            ?>
					<div class="row" style="border-bottom: 1px solid #ddd; padding-bottom: 15px; padding-top: 15px;">
	                    <div class="col-md-12">
							<div class="row">
			                    <div class="col-md-12">
				                    <label style="font-size: 18px;">Requested Inventory Lists for Service Packages</label>
			                    </div>
		                    </div>
		                    <div class="row" style="margin-top: 10px;">
			                    <div class="col-md-12">
				                    <div class="table-responsive">
					                    <table class="table">
											<tbody>
												<tr>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="23%">Task Name</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="23%">Request Materials</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="20%">Request Qty.</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="20%">Issue Qty.</td>
													<td style="font-weight: bold; border-top: 0px; padding: 5px;" width="14%">Action</td>
												</tr>
												<?php
                                                    $reqpackageData            = $reqpackageResult->result();
                            for ($rp = 0; $rp < count($reqpackageData); $rp++) {
                                $sjpm_id                = $reqpackageData[$rp]->id;
                                $task_id                = $reqpackageData[$rp]->task_id;
                                $mat_id                = $reqpackageData[$rp]->material_id;
                                $mat_name                = $reqpackageData[$rp]->material_name;
                                $mat_sku                = $reqpackageData[$rp]->material_sku;
                                $req_qty                = $reqpackageData[$rp]->request_qty;
                                $reqpackage_status        = $reqpackageData[$rp]->status;
                                $reqpackage_approved    = $reqpackageData[$rp]->request_approved;
                                                        
                                if ($reqpackage_approved == "2") {
                                    continue;
                                }
                                                        
                                $taskNameData            = $this->Constant_model->getDataOneColumn("tasks", "id", $task_id);
                                $task_name                = $taskNameData[0]->name; ?>
													<tr>
														<td><?php echo $task_name; ?></td>
														<td><?php echo $mat_name; ?> (<?php echo $mat_sku; ?>)</td>
														<td><?php echo $req_qty; ?></td>
														<td>
				<input type="hidden" id="sjm_id_<?php echo $sjpm_id; ?>" value="<?php echo $mat_id; ?>" />
				<input type="hidden" id="sjm_sku_<?php echo $sjpm_id; ?>" value="<?php echo $mat_sku; ?>" />
				<input type="text" id="sjp_qty_<?php echo $sjpm_id; ?>" onkeyup="checkPackMat(this.value, <?php echo $sjpm_id; ?>)" name="sjpm_qty_<?php echo $sjpm_id; ?>" class="form-control" style="width: 80%;" required />
														</td>
														<td style="font-weight: bold;">
															<a href="<?=base_url()?>services/rejectPackageMaterial?sjpm_id=<?php echo $sjpm_id; ?>&job_id=<?php echo $job_id; ?>" style="text-decoration: none;" onclick="return confirm('Are you confirm to remove this Materal?')">
																<i class="icono-cross" style="color: #990202;"></i>
															</a>
														</td>
													</tr>
												<?php
                                                        unset($sjpm_id);
                                unset($task_id);
                                unset($mat_id);
                                unset($mat_name);
                                unset($mat_sku);
                                unset($req_qty);
                                unset($reqpackage_status);
                            }
                            unset($reqpackageData); ?>
											</tbody>
					                    </table>
				                    </div>
			                    </div>
		                    </div>
	                    </div>
					</div>
					<?php

                        }
                        unset($reqpackageResult);
                        unset($reqpackageRows);
                    ?>
					
					<div class="row" style="padding-top: 30px;">
						<div class="col-md-12" style="text-align: center;">
							<input type="hidden" name="job_id" value="<?php echo $job_id; ?>" />
							<button type="submit" class="btn btn-primary" style="font-size: 22px; padding: 20px;">
								Issue Materials
							</button>
						</div>
					</div>
					</form>
					
				</div>
			</div>
		</div>
	</div>
	
	<a href="<?=base_url()?>services/request_inventory_services" style="text-decoration: none;">
		<div class="btn btn-default" style="background-color: #4a4a4a; color: #FFF; border-radius: 3px; border: 1px solid #111;">
			&nbsp;&nbsp;Back&nbsp;&nbsp;
		</div>
	</a>
	
</div>

<?php
    require_once "includes/footer.php";
?>