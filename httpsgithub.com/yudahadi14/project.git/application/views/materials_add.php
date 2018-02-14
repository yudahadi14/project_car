<?php
    require_once "includes/header.php";
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add Material</h1>
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
					
					<form enctype="multipart/form-data" class="form-horizontal" action="<?=base_url()?>materials/insertMaterial" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									SKU <span class="required">*</span><br />
									<span style="color: #808080; font-size: 12px;">Stock Keeping Unit</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="sku" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" />
								</div>
								<div class="col-md-7"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Material Name <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="material_name" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" />
								</div>
								<div class="col-md-7"></div>
							</div>
						
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Material Type <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<select name="material_type" class="form-control" required style="border: 1px solid #3a3a3a; color: #010101;">
										<option value="">Choose Material Type</option>
									<?php
                                        $matTypeData    = $this->Constant_model->getDataAll("material_type", "id", "ASC");
                                        for ($c = 0; $c < count($matTypeData); $c++) {
                                            $matType_id    = $matTypeData[$c]->id;
                                            $matType_name    = $matTypeData[$c]->name; ?>
											<option value="<?php echo $matType_id; ?>">
												<?php echo $matType_name; ?>
											</option>
									<?php
                                            unset($matType_id);
                                            unset($matType_name);
                                        }
                                    ?>
									</select>
								</div>
								<div class="col-md-7"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Cost <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="cost" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" />
								</div>
								<div class="col-md-7"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Price <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="price" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" />
								</div>
								<div class="col-md-7"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Status <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<select name="status" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;">
										<option value="1">Active</option>
										<option value="0">Inactive</option>
									</select>
								</div>
								<div class="col-md-7"></div>
							</div>
							
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-3 widget-left" style="height: auto; padding-top: 0px;">
									
									<button type="submit" class="btn btn-primary btn-md pull-left" id="nextGo">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
									
									<span id="pwait" style="display: none; font-size: 14px; font-weight: 300; font-family: 'Futura,Trebuchet MS',Arial,sans-serif;">
										<img src="<?=base_url()?>assets/images/loading.gif" />
										&nbsp;Processing.....
									</span>
									
								</div>
								<div class="col-md-7"></div>
							</div>
						</fieldset>
					</form>
					
				</div>
			</div>
			
			<a href="<?=base_url()?>materials/materials_list" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>


<?php
    require_once "includes/footer.php";
?>