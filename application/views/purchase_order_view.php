<?php
    require_once 'includes/header.php';
    
    $poDtaData        = $this->Constant_model->getDataOneColumn("purchase_order", "id", $po_id);
    if (count($poDtaData) == 0) {
        redirect(base_url().'purchase_order/po_view', 'refresh');
    }
    
    $po_numb        = $poDtaData[0]->po_number;
    $po_supplier    = $poDtaData[0]->supplier_id;
    $po_date        = date($site_dateformat, strtotime($poDtaData[0]->po_date));
    $po_note        = $poDtaData[0]->note;
    $po_status        = $poDtaData[0]->status;
    $po_supplier_name    = $poDtaData[0]->supplier_name;
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.11.0.js"></script>
<script src="<?=base_url()?>assets/js/jquery.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/typeahead.min.js"></script>

<!-- Select2 -->
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet">

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">View Purchase Order : <?php echo $po_numb; ?></h1>
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
					
					<?php
                        if ($po_status != '1') {
                            ?>
						<div class="row">
							<div class="col-md-8"></div>
							<div class="col-md-4" style="text-align: right;">
								<a href="<?=base_url()?>purchase_order/printPurchaseOrder?po_id=<?php echo $po_id; ?>" style="text-decoration: none;" target="_blank">
									<button type="button" class="btn btn-success" style="background-color: #5cb85c; border-color: #4cae4c;">
										Print Purchase Order
									</button>
								</a>
							</div>
						</div>
					<?php

                        }
                    ?>
					
					<div class="row" style="padding-bottom: 10px;">
						<div class="col-md-4">
							<label style="font-weight: bold;">Purchase Order Number <span style="color: #F00">*</span></label>
							<br />
							<?php echo $po_numb; ?>
						</div>
						<div class="col-md-4">
							<label style="font-weight: bold;">Supplier <span style="color: #F00">*</span></label>
							<br />
							<?php echo $po_supplier_name; ?>
						</div>
						<div class="col-md-4">
							<label style="font-weight: bold;">Created Date <span style="color: #F00">*</span></label>
							<br />
							<?php echo $po_date; ?>
						</div>
					</div>
					
					<div class="row" style="padding-bottom: 10px;">
						<div class="col-md-8">
							<label style="font-weight: bold;">Note</label>
							<br />
							<?php echo nl2br($po_note); ?>
						</div>
						<div class="col-md-4"></div>
					</div>
					
					<div class="row" style="padding-bottom: 20px; border-bottom: 1px solid #ddd;">
						<div class="col-md-4">
							<label style="color: #c72a25; font-weight: bold;">Purchase Order Status <span style="color: #F00">*</span></label>
							<br />
							<span style="color: #c72a25">
							<?php
                                $poStatusData = $this->Constant_model->getDataOneColumn('purchase_order_status', 'id', $po_status);
                                echo $poStatusData[0]->name;
                            ?>
							</span>
						</div>
						<div class="col-md-8"></div>
					</div>
					
					<div class="row" style="margin-top: 15px;">
						<div class="col-md-12">
<div class="table-responsive">
	<table class="table">
		<thead>
			<tr>
		    	<th width="30%" height="35px" style="background-color: #686868; color: #FFF; font-weight: normal; height: 35px !important;">SKU</th>
		    	<th width="30%" height="35px" style="background-color: #686868; color: #FFF; font-weight: normal; height: 35px !important;">Material Name</th>
		    	<th width="30%" height="35px" style="background-color: #686868; color: #FFF; font-weight: normal; height: 35px !important;">Ordered Qty.</th>
			    <th width="10%" height="35px" style="background-color: #686868; color: #FFF; font-weight: normal; height: 35px !important;">Action</th>
			</tr>
		</thead>
		<?php
            $poItemData = $this->Constant_model->getDataOneColumnSortColumn('purchase_order_items', 'purchase_order_id', $po_id, 'id', 'ASC');
            for ($pi = 0; $pi < count($poItemData); ++$pi) {
                $po_item_id        = $poItemData[$pi]->id;
                $po_item_sku        = $poItemData[$pi]->material_sku;
                $po_item_qty        = $poItemData[$pi]->ordered_qty;

                $mat_name            = "";
                $matDtaData        = $this->Constant_model->getDataOneColumn("materials", "sku", $po_item_sku);
                $mat_name            = $matDtaData[0]->name; ?>
				<tr>
					<td><?php echo $po_item_sku; ?></td>
					<td><?php echo $mat_name; ?></td>
					<td>
						<?php echo $po_item_qty; ?>
					</td>
					<td>
						-
					</td>
				</tr>
		<?php
                unset($po_item_id);
                unset($po_item_sku);
                unset($po_item_qty);
            }
        ?>
		<tbody id="addItemWrp">
		
		</tbody>
	</table>
</div>
						</div>
					</div>
					<!-- Product List // END -->
					
					
					
				</div><!-- Panel Body // END -->
			</div><!-- Panel Default // END -->
			
			<a href="<?=base_url()?>purchase_order/po_view" style="text-decoration: none;">
				<div class="btn btn-success" style="background-color: #999; color: #FFF; padding: 0px 12px 0px 2px; border: 1px solid #999;"> 
					<i class="icono-caretLeft" style="color: #FFF;"></i> Back
				</div>
			</a>
			
		</div><!-- Col md 12 // END -->
	</div><!-- Row // END -->
	
	<br /><br /><br /><br /><br />
	
</div><!-- Right Colmn // END -->
	
	
<?php
    require_once 'includes/footer.php';
?>

<script src="<?=base_url()?>assets/js/select2.full.min.js"></script>
<!-- Select2 -->
<script>
	$(document).ready(function() {
		$(".add_product_po").select2({
			placeholder: "Search Material by Name / SKU",
			allowClear: true
		});
	});
</script>
