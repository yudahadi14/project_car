<?php
    require_once "includes/header.php";
?>
<script type="text/javascript">
	$(document).ready(function() {
	    $('#example').DataTable();
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Materials List</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
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
					
					<div class="row" style="padding-bottom: 15px;">
						<div class="col-md-6">
							<a href="<?=base_url()?>materials/add_material" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New Material</button>
							</a>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<a href="<?=base_url()?>materials/exportMaterialsList" style="text-decoration: none;" target="_blank">
								<div class="btn btn-success">Export Materials List</div>
							</a>
						</div>
					</div>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
						            <th width="10%"><span>SKU</span></th>
						            <th width="20%"><span>Material Name</span></th>
						            <th width="15%"><span>Material Type</span></th>
							    	<th width="10%"><span>Cost</span></th>
							    	<th width="10%"><span>Price</span></th>
							    	<th width="10%"><span>Existing Qty.</span></th>
							    	<th width="10%"><span>Status</span></th>
							    	<th width="10%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                $jj            = 1;
                                
                                $matData        = $this->Constant_model->getDataAll("materials", "id", "DESC");
                                
                                for ($m = 0; $m < count($matData); $m++) {
                                    $mat_id    = $matData[$m]->id;
                                    $mat_sku    = $matData[$m]->sku;
                                    $mat_name    = $matData[$m]->name;
                                    $mat_type    = $matData[$m]->material_type;
                                    $mat_cost    = $matData[$m]->cost;
                                    $mat_price    = $matData[$m]->price;
                                    $mat_status    = $matData[$m]->status;
                                    
                                    $mat_type_name    = "";
                                    $matTypeData    = $this->Constant_model->getDataOneColumn("material_type", "id", $mat_type);
                                    $mat_type_name    = $matTypeData[0]->name;
                                    
                                    $inv_qty        = 0;
                                    $inventoryResult    = $this->db->query("SELECT quantity FROM inventory WHERE materials_id = '$mat_id' AND sku = '$mat_sku' ");
                                    $inventoryRows        = $inventoryResult->num_rows();
                                    if ($inventoryRows == 1) {
                                        $inventoryData    = $inventoryResult->result();
                                        
                                        $inv_qty        = $inventoryData[0]->quantity;
                                        
                                        unset($inventoryData);
                                    }
                                    unset($inventoryResult);
                                    unset($inventoryRows); ?>
									<tr>
										<td><?php echo $jj; ?></td>
										<td><?php echo $mat_sku; ?></td>
										<td><?php echo $mat_name; ?></td>
										<td><?php echo $mat_type_name; ?></td>
										<td>$<?php echo number_format($mat_cost, 2); ?></td>
										<td>$<?php echo number_format($mat_price, 2); ?></td>
										<td><?php echo $inv_qty; ?></td>
										<td style="font-weight: bold;">
											<?php
                                                if ($mat_status == "1") {
                                                    echo '<span style="color: #090;">Active</span>';
                                                } elseif ($mat_status == "0") {
                                                    echo '<span style="color: #F00;">Inactive</span>';
                                                } ?>
										</td>
										<td>
											<a href="<?=base_url()?>materials/edit_material?id=<?php echo $mat_id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php
                                    unset($mat_id);
                                    unset($mat_sku);
                                    unset($mat_name);
                                    unset($mat_type);
                                    unset($mat_cost);
                                    unset($mat_price);
                                    unset($mat_status);
                                    
                                    $jj++;
                                }
                            ?>
							</tbody>
						</table>
					
					</div><!-- End of Responsive DIV -->
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    require_once "includes/footer.php";
?>