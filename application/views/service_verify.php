<?php
    require_once "includes/header.php";
    
    $carData    = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
    
     $nama_merchant    = $carData[0]->nama_merchant;
    $alamat    = $carData[0]->alamat; 
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
					Step 6 of 6 - Verify New Service
				</div>	
				<div class="panel-body" style="padding: 25px;">
					
					<form class="form-horizontal" action="<?=base_url()?>services/confirmService" method="post" onsubmit="return confirm('Are you confirm to Open New Service for Plate Number : <?php echo $nama_merchant; ?>?')" onsubmit="kk()">
						
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
								<h4 style="font-weight: bold; padding-top: 10px;">
									Technician
								</h4>
							</div>
						</div>
						<div class="row">
							<div class="col-md-3"></div>
							<div class="col-md-6">
								<div class="table-responsive">
									<table class="table">
										<tr>
								            <th width="20%" style="border-bottom: 1px solid #111; height: 40px; border-top: 0px;"><span>Technician Name</span></th>
									    </tr>
									    <tr>
										    <td>
										<?php
                                            $userDtaResult    = $this->db->query("SELECT * FROM users WHERE id = '$tech' ");
                                            $userDtaData    = $userDtaResult->result();
                                        
                                            echo $userDtaData[0]->fullname;
                                            
                                            unset($userDtaResult);
                                            unset($userDtaData);
                                        ?>
										    </td>
									    </tr>
									</table>
								</div>
							</div>
							<div class="col-md-3"></div>
						</div>
						
						
						
						
						
						
						
							
						<fieldset>
							
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-8" style="text-align: center;">
									
									<input type="hidden" name="tech" value="<?php echo $tech; ?>" />
								
									<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
										Submit
									</button>
									
									<span id="pwait" style="display: none; font-size: 14px; font-weight: 300; font-family: 'Futura,Trebuchet MS',Arial,sans-serif;">
										<img src="<?=base_url()?>assets/images/loading.gif" />
										&nbsp;Processing.....
									</span>
									
								</div>
								<div class="col-md-2"></div>
							</div>
								</div>
								<div class="col-md-3"></div>
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