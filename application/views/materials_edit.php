<?php
    require_once "includes/header.php";
    
    $matDtaData        = $this->Constant_model->getDataOneColumn("materials", "id", $id);
    
    if (count($matDtaData) == 0) {
        redirect(base_url().'materials/materials_list');
    }
    $mat_sku            = $matDtaData[0]->sku;
    $mat_name            = $matDtaData[0]->name;
    $mat_type            = $matDtaData[0]->material_type;
    $mat_cost            = $matDtaData[0]->cost;
    $mat_price            = $matDtaData[0]->price;
    $mat_status        = $matDtaData[0]->status;
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Material : <?php echo $mat_name; ?></h1>
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
					
					<form enctype="multipart/form-data" class="form-horizontal" action="<?=base_url()?>materials/updateMaterial" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									SKU <span class="required">*</span><br />
									<span style="color: #808080; font-size: 12px;">Stock Keeping Unit</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="sku" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" value="<?php echo $mat_sku; ?>" readonly />
								</div>
								<div class="col-md-7"></div>
							</div>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Material Name <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="material_name" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" value="<?php echo $mat_name; ?>" />
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
											<option value="<?php echo $matType_id; ?>" <?php if ($mat_type == $matType_id) {
                                                echo 'selected="selected"';
                                            } ?>>
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
									<input type="text" name="cost" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" value="<?php echo $mat_cost; ?>" />
								</div>
								<div class="col-md-7"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Price <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="price" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" value="<?php echo $mat_price; ?>" />
								</div>
								<div class="col-md-7"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Status <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<select name="status" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;">
										<option value="1" <?php if ($mat_status == "1") {
                                        echo 'selected="selected"';
                                    } ?>>Active</option>
										<option value="0" <?php if ($mat_status == "0") {
                                        echo 'selected="selected"';
                                    } ?>>Inactive</option>
									</select>
								</div>
								<div class="col-md-7"></div>
							</div>
							
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-3 widget-left" style="height: auto; padding-top: 0px;">
									<input type="hidden" name="id" value="<?php echo $id; ?>" />
									<button type="submit" class="btn btn-primary btn-md pull-left" id="nextGo">&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;</button>
									
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
			
			<div class="panel panel-default">
				<div class="panel-body" style="padding: 25px;">
					<div class="row">
						<div class="col-md-12">
							<table border="0" style="border-collapse: collapse; width: 100%;">
								<tr>
									<td width="50%" align="left">
										<h5 style="font-size: 24px;">Inventory Quantity : <?php echo $mat_name; ?></h5>
									</td>
									<td width="50%" align="right">
										<?php
                                            if ($user_role == "1") {
                                                ?>
										<a href="<?=base_url()?>materials/exportUpdatedHistory?mat_id=<?php echo $id; ?>" style="text-decoration: none;" target="_blank">
											<div class="btn btn-success">Export Updated History</div>
										</a>
										<?php

                                            }
                                        ?>
									</td>
								</tr>
							</table>
						</div>
					</div>	
					
					<?php
                        $inv_qty        = 0;
                        $inventoryResult    = $this->db->query("SELECT quantity FROM inventory WHERE materials_id = '$id' ");
                        $inventoryRows        = $inventoryResult->num_rows();
                        if ($inventoryRows == 1) {
                            $inventoryData    = $inventoryResult->result();
                            
                            $inv_qty        = $inventoryData[0]->quantity;
                            
                            unset($inventoryData);
                        }
                        unset($inventoryResult);
                        unset($inventoryRows);
                    ?>
					
					<div class="row" style="padding-top: 10px; padding-bottom: 10px;">
						<div class="col-md-3">
							<label>Current Inventory Quantity</label>
						</div>
						<div class="col-md-9">: <?php echo $inv_qty; ?></div>
					</div>
					
					<form action="<?=base_url()?>materials/updateInventory" method="post" onsubmit="return confirm('Are you confirm to update Inventory Quantity?')">
					<div class="row" style="border-top: 1px solid #ddd; padding-top: 10px; padding-bottom: 10px;">
						<div class="col-md-3"></div>
						<div class="col-md-6" style="text-align: center;">
							<h5 style="font-size: 24px;">Update Inventory Qty.</h5>
						</div>
						<div class="col-md-3"></div>
					</div>
					<div class="row" style="padding-top: 5px; padding-bottom: 5px;">
						<div class="col-md-3"></div>
						<div class="col-md-3" style="padding-top: 7px; text-align: right;">
							<label>Inventory Quantity *</label>
						</div>
						<div class="col-md-3">
							<input type="text" name="qty" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required autocomplete="off" />
						</div>
						<div class="col-md-3"></div>
					</div>
					<div class="row" style="padding-top: 10px; padding-bottom: 5px;">
						<div class="col-md-3"></div>
						<div class="col-md-3"></div>
						<div class="col-md-3" style="text-align: left;">
							<input type="hidden" name="mat_id" value="<?php echo $id; ?>" />
							<input type="hidden" name="mat_sku" value="<?php echo $mat_sku; ?>" />
							<button type="submit" class="btn btn-primary btn-md">
								Update Quantity
							</button>
						</div>
						<div class="col-md-3"></div>
					</div>
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