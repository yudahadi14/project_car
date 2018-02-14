<?php
    require_once "includes/header.php";
    
    $siteDtaData        = $this->Constant_model->getDataOneColumn('site_setting', 'id', '1');
    
    $site_name            = $siteDtaData[0]->site_name;
    $timezone            = $siteDtaData[0]->timezone;
    $pagination        = $siteDtaData[0]->pagination;
    $tax                = $siteDtaData[0]->tax;
    $currency            = $siteDtaData[0]->currency;
    $dtm_format        = $siteDtaData[0]->datetime_format;
    $site_logo            = $siteDtaData[0]->site_logo;
    $address            = $siteDtaData[0]->address;
    $tel                = $siteDtaData[0]->telephone;
    $fax                = $siteDtaData[0]->fax;
?>
<!-- Select2 -->
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet">

<style type="text/css">
	.fileUpload {
	    position: relative;
	    overflow: hidden;
	    border-radius: 0px;
	    margin-left: -4px;
	    margin-top: -2px;
	}
	.fileUpload input.upload {
	    position: absolute;
	    top: 0;
	    right: 0;
	    margin: 0;
	    padding: 0;
	    font-size: 20px;
	    cursor: pointer;
	    opacity: 0;
	    filter: alpha(opacity=0);
	}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		document.getElementById("uploadBtn").onchange = function () {
			document.getElementById("uploadFile").value = this.value;
		};
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">System Setting</h1>
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
					
					<form class="form-horizontal" enctype="multipart/form-data" action="<?=base_url()?>setting/updateSystemSetting" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Logo <span class="required">*</span>
								</label>
								<div class="col-md-7">
									
									<div class="row">
										<div class="col-md-12">
											<img src="<?=base_url()?>assets/images/logo/<?php echo $site_logo; ?>" height="100px" style="border: 1px solid #ddd;" />
										</div>
									</div>
									
									<div class="row" style="margin-top: 4px;">
										<div class="col-md-12">
											<input id="uploadFile" readonly style="height: 40px; width: 0px; border: 0px solid #ccc" />
											<div class="fileUpload btn btn-primary" style="padding: 9px 30px; margin-left: -5px;">
											    <span>Browse</span>
											    <input id="uploadBtn" name="uploadFile" type="file" class="upload" />
											</div>
										</div>
									</div>
									
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Workshop Name <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="site_name" required style="width: 100%;" value="<?php echo $site_name; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Address
								</label>
								<div class="col-md-7">
									<textarea name="address" class="form-control" style="width: 100%; height: 120px;"><?php echo $address; ?></textarea>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Telephone
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="tel" style="width: 100%;" value="<?php echo $tel; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Fax
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="fax" style="width: 100%;" value="<?php echo $fax; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
						
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Tax <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="tax" required style="width: 100%;" value="<?php echo $tax; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="message">
									Timezone <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select class="select2_single form-control" name="timezone" tabindex="-1" style="width: 100%;">
										<?php
                                            $timezoneData            = $this->Constant_model->getDataAll("timezones", "timezone", "ASC");
                                            for ($t = 0; $t < count($timezoneData); $t++) {
                                                $timezone_name        = $timezoneData[$t]->timezone; ?>
												<option value="<?php echo $timezone_name; ?>" <?php if ($timezone_name == $timezone) {
                                                    echo 'selected="selected"';
                                                } ?>>
													<?php echo $timezone_name; ?>
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
									Pagination Per Page <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select class="pagination form-control" name="pagination" tabindex="-1" style="width: 100%;">
										<option value="10" <?php if ($pagination == "10") {
                                            echo 'selected="selected"';
                                        } ?>>10</option>
										<option value="20" <?php if ($pagination == "20") {
                                            echo 'selected="selected"';
                                        } ?>>20</option>
										<option value="50" <?php if ($pagination == "50") {
                                            echo 'selected="selected"';
                                        } ?>>50</option>
										<option value="100" <?php if ($pagination == "100") {
                                            echo 'selected="selected"';
                                        } ?>>100</option>
										<option value="200" <?php if ($pagination == "100") {
                                            echo 'selected="selected"';
                                        } ?>>200</option>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Currency <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select class="setting_currency form-control" name="currency" tabindex="-1" style="width: 100%;">
									<?php
                                        $currencyData        = $this->Constant_model->getDataAll("currency", "name", "ASC");
                                        for ($c = 0; $c < count($currencyData); $c++) {
                                            $currency_iso        = $currencyData[$c]->iso;
                                            $currency_name        = $currencyData[$c]->name; ?>
											<option value="<?php echo $currency_iso; ?>" <?php if ($currency_iso == $currency) {
                                                echo 'selected="selected"';
                                            } ?>>
												<?php echo $currency_name; ?> (<?php echo $currency_iso; ?>)
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
									System Date Format <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="dateformat" class="setting_date_format form-control" required style="width: 100%">
										<option value="Y-m-d" <?php if ($dtm_format == 'Y-m-d') {
                                        echo 'selected="selected"';
                                    } ?>>yyyy-mm-dd</option>
										<option value="Y.m.d" <?php if ($dtm_format == 'Y.m.d') {
                                        echo 'selected="selected"';
                                    } ?>>yyyy.mm.dd</option>
										<option value="Y/m/d" <?php if ($dtm_format == 'Y/m/d') {
                                        echo 'selected="selected"';
                                    } ?>>yyyy/mm/dd</option>
										<option value="m-d-Y" <?php if ($dtm_format == 'm-d-Y') {
                                        echo 'selected="selected"';
                                    } ?>>mm-dd-yyyy</option>
										<option value="m.d.Y" <?php if ($dtm_format == 'm.d.Y') {
                                        echo 'selected="selected"';
                                    } ?>>mm.dd.yyyy</option>
										<option value="m/d/Y" <?php if ($dtm_format == 'm/d/Y') {
                                        echo 'selected="selected"';
                                    } ?>>mm/dd/yyyy</option>
										<option value="d-m-Y" <?php if ($dtm_format == 'd-m-Y') {
                                        echo 'selected="selected"';
                                    } ?>>dd-mm-yyyy</option>
										<option value="d.m.Y" <?php if ($dtm_format == 'd.m.Y') {
                                        echo 'selected="selected"';
                                    } ?>>dd.mm.yyyy</option>
										<option value="d/m/Y" <?php if ($dtm_format == 'd/m/Y') {
                                        echo 'selected="selected"';
                                    } ?>>dd/mm/yyyy</option>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-7 widget-left" style="height: auto;">
									
									<button type="submit" class="btn btn-primary btn-md pull-left" id="nextGo">Update System Setting</button>
									
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
		</div>
	</div>
	
</div>

<script src="<?=base_url()?>assets/js/select2.full.min.js"></script>
<!-- Select2 -->
<script>
	$(document).ready(function() {
		$(".select2_single").select2({
			placeholder: "Select system timezone",
			allowClear: true
		});
		
		$(".pagination").select2({
			placeholder: "Select Pagination Limit",
			allowClear: true
		});
		
		$(".setting_currency").select2({
			placeholder: "Select System Currency",
			allowClear: true
		});
		
		$(".setting_date_format").select2({
			placeholder: "Select System Date Format",
			allowClear: true
		});
		
		$(".add_cust_country").select2({
			placeholder: "Select Your Country",
			allowClear: true
		});
		
		$(".add_cust_group").select2({
			placeholder: "Select Your Customer Group",
			allowClear: true
		});
		
		$(".add_car_owner").select2({
			placeholder: "Choose Your Car Owner",
			allowClear: true
		});
		
		$(".add_car_make").select2({
			placeholder: "Choose Your Car Make",
			allowClear: true
		});
		
		$(".assign_task").select2({
			placeholder: "Choose Task For Service Package",
			allowClear: true
		});
	
	});
</script>
<!-- /Select2 -->

<?php
    require_once "includes/footer.php";
?>

