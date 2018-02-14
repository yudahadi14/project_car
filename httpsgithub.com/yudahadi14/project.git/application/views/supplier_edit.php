<?php
    require_once "includes/header.php";
    
    $supplierData        = $this->Constant_model->getDataOneColumn("suppliers", "id", $id);
    
    if (count($supplierData) == 0) {
        redirect(base_url().'setting/suppliers', 'refresh');
    }
    
    $supplier_name        = $supplierData[0]->name;
    $supplier_email        = $supplierData[0]->email;
    $supplier_tel        = $supplierData[0]->telephone;
    $supplier_fax        = $supplierData[0]->fax;
    $supplier_address    = $supplierData[0]->address;
    $supplier_tax        = $supplierData[0]->tax;
    $supplier_status    = $supplierData[0]->status;
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Supplier : <?php echo $supplier_name; ?></h1>
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
					
					<form class="form-horizontal" action="<?=base_url()?>setting/updateSupplier" method="post" onsubmit="kk()">
						<fieldset>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Name <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" name="name" class="form-control" required autocomplete="off" value="<?php echo $supplier_name; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Email 
								</label>
								<div class="col-md-7">
									<input type="text" name="email" class="form-control" autocomplete="off" value="<?php echo $supplier_email; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Telephone <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" name="tel" class="form-control" required autocomplete="off" value="<?php echo $supplier_tel; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Fax
								</label>
								<div class="col-md-7">
									<input type="text" name="fax" class="form-control" autocomplete="off" value="<?php echo $supplier_fax; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Address <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<textarea name="address" class="form-control" required><?php echo $supplier_address; ?></textarea>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Tax <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" name="tax" class="form-control" required autocomplete="off" placeholder="0.00" value="<?php echo $supplier_tax; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Status <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="status" class="form-control">
										<option value="1" <?php if ($supplier_status == "1") {
                        echo 'selected="selected"';
                    } ?>>Active</option>
										<option value="0" <?php if ($supplier_status == "0") {
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
			
			<a href="<?=base_url()?>setting/suppliers" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>