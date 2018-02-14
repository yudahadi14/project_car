<?php
    require_once "includes/header.php";
    
    $custData        = $this->Constant_model->getDataOneColumn("customers", "id", $id);
    
    if (count($custData) == 0) {
        redirect(base_url().'customers/customer_lists', 'refresh');
    }
    
    $cust_fn                = $custData[0]->firstname;
    $cust_ln                = $custData[0]->lastname;
    $nric                    = $custData[0]->nric;
    $email                    = $custData[0]->email;
    $mb                    = $custData[0]->mobile;
    $address                = $custData[0]->address;
    $postal                = $custData[0]->postal_code;
    $cust_country_code        = $custData[0]->country;
    $cust_customer_group    = $custData[0]->customer_group;
    $status                = $custData[0]->status;
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Customer</h1>
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
					
					<form class="form-horizontal" action="<?=base_url()?>customers/updateCustomer" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									NIRC <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="nric" required style="width: 100%;" autofocus autocomplete="off" value="<?php echo $nric; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
						
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									First Name <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="fn" required style="width: 100%;" autocomplete="off" value="<?php echo $cust_fn; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Last Name 
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="ln" style="width: 100%;" autocomplete="off" value="<?php echo $cust_ln; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Email Address
								</label>
								<div class="col-md-7">
									<input type="email" class="form-control" name="em" style="width: 100%;" autocomplete="off" value="<?php echo $email; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Mobile <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="mb" required style="width: 100%;" autocomplete="off" value="<?php echo $mb; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Address
								</label>
								<div class="col-md-7">
									<textarea name="address" class="form-control"><?php echo $address; ?></textarea>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Postal Code
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="postal" style="width: 100%;" autocomplete="off" value="<?php echo $postal; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Country
								</label>
								<div class="col-md-7">
									<select class="add_cust_country form-control" name="country" tabindex="-1" style="width: 100%;">
										<option value="">Choose Country</option>
									<?php
                                        $countryData        = $this->Constant_model->getDataAll("countries", "name", "ASC");
                                        for ($c = 0; $c < count($countryData); $c++) {
                                            $country_code        = $countryData[$c]->code;
                                            $country_name        = $countryData[$c]->name; ?>
											<option value="<?php echo $country_code; ?>" <?php if ($country_code == $cust_country_code) {
                                                echo 'selected="selected"';
                                            } ?>>
												<?php echo $country_name; ?>
											</option>
									<?php

                                        }
                                    ?>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Customer Group
								</label>
								<div class="col-md-7">
									<select class="add_cust_group form-control" name="customer_group" tabindex="-1" style="width: 100%;" required>
									<?php
                                        $groupData        = $this->Constant_model->getDataOneColumnSortColumn("customer_groups", "status", "1", "id", "ASC");
                                        for ($g = 0; $g < count($groupData); $g++) {
                                            $group_id        = $groupData[$g]->id;
                                            $group_name    = $groupData[$g]->name; ?>
											<option value="<?php echo $group_id; ?>" <?php if ($group_id == $cust_customer_group) {
                                                echo 'selected="selected"';
                                            } ?>>
												<?php echo $group_name; ?>
											</option>
									<?php

                                        }
                                    ?>
									</select>	
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
			
			<a href="<?=base_url()?>customers/customer_lists" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>