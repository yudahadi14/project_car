<?php
    require_once "includes/header.php";
    
    $carData    = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
    
    $car_owner_id    = $carData[0]->owner_id;
    $car_make_id    = $carData[0]->car_make_id;
    $car_model        = $carData[0]->car_model;
    $car_plate        = $carData[0]->plate_number;
    $car_color        = $carData[0]->color;
    
    
    $owner_name    = "";
    $ownerData        = $this->Constant_model->getDataOneColumn("customers", "id", $car_owner_id);
    if (count($ownerData) == 1) {
        $owner_name    = $ownerData[0]->firstname." ".$ownerData[0]->lastname;
    }
    
    $make_type        = "";
    $make_name        = "";
    $makeData        = $this->Constant_model->getDataOneColumn("car_make", "id", $car_make_id);
    if (count($makeData) == 1) {
        $make_name    = $makeData[0]->name;
        $make_type    = $makeData[0]->type;
    }
    
    
    $packArray        = explode(",", $pack_list);
    
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
			<h1 class="page-header">Open New Service</h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					Step 4 of 6 - Reported Defects If you have
				</div>	
				<div class="panel-body" style="padding: 25px;">
					
					<form class="form-horizontal" action="<?=base_url()?>services/fifth_step" method="post">
					
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Car Owner</b>
							</div>
							<div class="col-md-10">
								: <?php echo $owner_name; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Car Plate Number</b>
							</div>
							<div class="col-md-10">
								: <?php echo $car_plate; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Car Make & Model</b>
							</div>
							<div class="col-md-10">
								: <?php echo $make_name." ".$car_model; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Color</b>
							</div>
							<div class="col-md-10">
								: <?php echo $car_color; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Current Mileage</b>
							</div>
							<div class="col-md-10">
								: <?php echo $mileage; ?> km
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Service Package(s)</b>
							</div>
							<div class="col-md-10">
								: <?php 
                                    $pack_list_name    = "";
                                    for ($p = 0; $p < count($packArray); $p++) {
                                        $pack_id        = $packArray[$p];
                                        
                                        if (!empty($pack_id)) {
                                            $packNameData    = $this->Constant_model->getDataOneColumn("service_packages", "id", $pack_id);
                                        
                                            $pack_list_name    .= $packNameData[0]->name.", ";
                                        }
                                    }
                                    $pack_list_name    = trim($pack_list_name, ", ");
                                    
                                    if (empty($pack_list_name)) {
                                        echo "-";
                                    } else {
                                        echo $pack_list_name;
                                    }
                                ?>
							</div>
						</div>
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="border-top: 1px solid #ddd;"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4 style="font-weight: bold; padding-bottom: 10px;">
									Reported Defects
								</h4>
							</div>
						</div>	
						
							
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Tyres <span class="required">*</span>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="tyres" style="width: 100%;" autofocus autocomplete="off" />
								</div>
								<label class="col-md-2 control-label" for="name">
									Steering <span class="required">*</span>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="steering" style="width: 100%;" autofocus autocomplete="off" />
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Engine <span class="required">*</span>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="engine" style="width: 100%;" autofocus autocomplete="off" />
								</div>
								<label class="col-md-2 control-label" for="name">
									Suspension <span class="required">*</span>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="suspension" style="width: 100%;" autofocus autocomplete="off" />
								</div>
							</div>	
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Battery <span class="required">*</span>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="battery" style="width: 100%;" autofocus autocomplete="off" />
								</div>
								<label class="col-md-2 control-label" for="name">
									Others <span class="required">*</span>
								</label>
								<div class="col-md-4">
									<input type="text" class="form-control" name="others" style="width: 100%;" autofocus autocomplete="off" />
								</div>
							</div>	
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-8" style="text-align: center;">
									
									<input type="hidden" name="car_id" value="<?php echo $car_id; ?>" />
									<input type="hidden" name="pack_list" value="<?php echo $pack_list; ?>" />
									<input type="hidden" name="mileage" value="<?php echo $mileage; ?>" />
								
									<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
										Next
									</button>
								
								</div>
								<div class="col-md-2"></div>
							</div>
								
								
						</fieldset>
					</form>
				
					
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>