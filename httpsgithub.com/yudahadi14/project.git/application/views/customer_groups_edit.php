<?php
    require_once "includes/header.php";
    
    $groupData    = $this->Constant_model->getDataOneColumn("customer_groups", "id", $id);
    
    if (count($groupData) == 0) {
        redirect(base_url().'setting/customer_groups', 'refresh');
    }
    
    $name        = $groupData[0]->name;
    $percentage    = $groupData[0]->discount_percentage;
    $status    = $groupData[0]->status;
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Customer Group</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				
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
					
					<form class="form-horizontal" action="<?=base_url()?>setting/updateCustomerGroup" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Group Name <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="name" required style="width: 100%;" autofocus autocomplete="off" value="<?php echo $name; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Discount Percentage <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="percentage" required style="width: 100%;" autofocus autocomplete="off" placeholder="00" value="<?php echo $percentage; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Status <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="status" class="form-control">
										<option value="1" <?php if ($status == "1") {
                        echo 'selected="selected"';
                    } ?>>Active</option>
										<option value="0" <?php if ($status == "0") {
                        echo 'selected="selected"';
                    } ?>>Inactive</option>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-7 widget-left" style="height: auto; padding-top: 0px;">
									
									<input type="hidden" name="id" value="<?php echo $id; ?>" />
									<button type="submit" class="btn btn-primary btn-md pull-left" id="nextGo">&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;</button>
									
									<span id="pwait" style="display: none; font-size: 14px; font-weight: 300; font-family: 'Futura,Trebuchet MS',Arial,sans-serif;">
										<img src="<?=base_url()?>assets/images/loading.gif" />
										&nbsp;Processing.....
									</span>
									
								</div>
								<div class="col-md-3"></div>
							</div>
						</fieldset>
					</form>
					
				</div>
			</div>
			
			<a href="<?=base_url()?>setting/customer_groups" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>