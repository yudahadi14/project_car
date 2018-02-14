<?php
    require_once "includes/header.php";
    
    $carData    = $this->Constant_model->getDataOneColumn("cars", "id", $car_id);
    
    $nama_merchant    = $carData[0]->nama_merchant;
    $alamat    = $carData[0]->alamat;
   	$problem        = $carData[0]->problem;
    $mid_tid        = $carData[0]->mid_tid;
    $tpic        = $carData[0]->pic;
    $tarea        = $carData[0]->area;
//    $problem        = $carData[0]->problem;
    
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
    }**/
    
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
					Step 3 of 6 - Choose Servicing Package
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
					
					<form class="form-horizontal" action="<?=base_url()?>services/fourth_step" method="post">
						<input type="hidden" name="car_id" value="<?php echo $car_id; ?>" />
					
					<h4 style="font-weight: bold; padding-bottom: 10px; margin-top: -10px;">
						Silahkan Isi Problem
					</h4>
					
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
							<input type="text" name="problem" class="form-control" style="width: 50%;" autocomplete="off" autofocus required />
						</div>
					</div>
					<tr>
											<td colspan="3" align="center" style="text-align: center;">
												<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
													Next
												</button>
											</td>
										</tr>
				</div>
			</div>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>