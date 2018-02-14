<?php
    require_once "includes/header.php";
    
    $carData    = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
    
    $nama_merchant    = $carData[0]->nama_merchant;
    $alamat    = $carData[0]->alamat;
   	$problem        = $carData[0]->problem;
    $mid_tid        = $carData[0]->mid_tid;
    $tpic        = $carData[0]->pic;
    $tarea        = $carData[0]->area;
    $problem        = $carData[0]->problem;	
    
    /**
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
    
    $packArray        = explode(",", $pack_list);**/
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
					Step 5 of 6 - Assign Technician
				</div>	
				<div class="panel-body" style="padding: 25px;">
					
					<form class="form-horizontal" action="<?=base_url()?>services/verify_step" method="post">
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Nama Merchant</b>
							</div>
							<div class="col-md-10">
								: <?php echo $nama_merchant; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Alamat</b>
							</div>
							<div class="col-md-10">
								: <?php echo $alamat; ?>
							</div>
						</div>
						
						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>MIDTID</b>
							</div>
							<div class="col-md-10">
								: <?php echo $mid_tid; ?>
							</div>
						</div>

						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>PIC</b>
							</div>
							<div class="col-md-10">
								: <?php echo $tpic; ?>
							</div>
						</div>

						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Area</b>
							</div>
							<div class="col-md-10">
								: <?php echo $tarea; ?>
							</div>
						</div>

						<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
							<div class="col-md-2">
								<b>Problem</b>
							</div>
							<div class="col-md-10">
								: <?php echo $problem; ?>
							</div>
						</div>
						
						
			
						
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-12" style="border-top: 1px solid #ddd;"></div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<h4 style="font-weight: bold; padding-bottom: 10px;">
									Assign Technician
								</h4>
							</div>
						</div>	
						
						
							
						<fieldset>
							<div class="row">
								<div class="col-md-4"></div>
								<div class="col-md-4">
							<div class="table-responsive" style="margin-top: 10px; border-top: 0px solid #ddd;">
								<table class="table">
									<thead>
										<tr>
									    	<th width="5%" style="border-bottom: 1px solid #111; height: 40px;"><span>Choose</span></th>
								            <th width="20%" style="border-bottom: 1px solid #111; height: 40px;"><span>Technician Name</span></th>
									    </tr>
									</thead>
									<tbody>
									<?php
                                        $userDtaResult    = $this->db->query("SELECT * FROM users WHERE role_id = '3' AND status = '1' ");
                                        $userDtaData    = $userDtaResult->result();
                                        
                                        for ($t = 0; $t < count($userDtaData); $t++) {
                                            $tech_id        = $userDtaData[$t]->id;
                                            $tech_fn        = $userDtaData[$t]->fullname; ?>
											<tr>
												<td>
													<input type="radio" name="tech" value="<?php echo $tech_id; ?>" required />
												</td>
												<td>
													<?php echo $tech_fn; ?>
												</td>
												
											</tr>
									<?php
                                            unset($tech_id);
                                            unset($tech_fn);
                                        }
                                        unset($userDtaResult);
                                        unset($userDtaData);
                                    ?>
									</tbody>
								</table>
							</div>
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-8" style="text-align: center;">
														
									<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
										Next
									</button>
								
								</div>
								<div class="col-md-2"></div>
							</div>
								</div>
								<div class="col-md-4"></div>
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