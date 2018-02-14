<?php
    require_once "includes/header.php";
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
					Step 1 of 6 - Search Car by Plate Number
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
					
					<!--
					<div class="container-fluid">
						<div data-wizard-init>
							<ul class="steps">
								<li data-step="1">Details</li>
								<li data-step="2">Address</li>
								<li data-step="3">Template</li>
								<li data-step="4">Delivery</li>
								<li data-step="5">Payment</li>
								<li data-step="6">Special needs</li>
								<li data-step="7">Comments</li>
								<li data-step="8">Images</li>
							</ul>
						</div>
					</div>
					-->
					<h4 style="font-weight: bold; padding-bottom: 10px; margin-top: -10px;">
						Search car by Plate Number
					</h4>
					<form class="form-horizontal" action="<?=base_url()?>services/second_step" method="get">
						<fieldset>
							<!--
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Customer Name / NRIC
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="customer" style="width: 100%;" autofocus autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
							-->
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Car Plate Number
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="nama_merchant" style="width: 100%;" autofocus autocomplete="off" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									&nbsp;
								</label>
								<div class="col-md-7">
									<button type="submit" class="btn btn-primary btn-md pull-left">
										Search Car
									</button>	
								</div>
								<div class="col-md-3">
									
								</div>
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