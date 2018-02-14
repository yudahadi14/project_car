<?php
    require_once "includes/header.php";
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Purchase Order</h1>
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
							<a href="<?=base_url()?>purchase_order/create_purchase_order" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Create Purchase Order</button>
							</a>
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="table-responsive">
					<table id="example" class="display" cellspacing="0" width="100%">
					    <thead>
					        <tr>
					            <th width="25%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Purchase Order Number</th>
					            <th width="20%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Supplier</th>
						    	<th width="15%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Created Date</th>
						    	<th width="15%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Status</th>
						    	<th width="30%" style="padding: 7px 7px; border-bottom: 1px solid #111; letter-spacing: 0.3px;">Action</th>
					        </tr>
					    </thead>
						<tbody>
						<?php
                            if (count($results) > 0) {
                                foreach ($results as $data) {
                                    $id            = $data->id;
                                    $po_numb        = $data->po_number;
                                    $supplier_name    = $data->supplier_name;
                                    $po_date        = date("$dateformat", strtotime($data->created_datetime));
                                    $po_status        = $data->status;
                                    
                                    $po_status_name    = "";
                                    $poStatusNameData    = $this->Constant_model->getDataOneColumn("purchase_order_status", "id", $po_status);
                                    $po_status_name    = $poStatusNameData[0]->name; ?>
									<tr>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $po_numb; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $supplier_name; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;"><?php echo $po_date; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px; font-weight: bold;"><?php echo $po_status_name; ?></td>
										<td style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px;">
				<?php
                    if ($po_status == "1") {
                        ?>
						<a href="<?=base_url()?>purchase_order/edit_purchase_order?po_id=<?php echo $id; ?>" style="text-decoration: none;">
							<button type="button" class="btn btn-primary">&nbsp;&nbsp;Edit&nbsp;&nbsp;</button>
						</a>
						<a href="<?=base_url()?>purchase_order/deletePO?id=<?php echo $id; ?>&po_numb=<?php echo $po_numb; ?>" style="text-decoration: none; margin-left: 10px;" onclick="return confirm('Are you sure to delete this Purchase Order : <?php echo $po_numb; ?>?')">
							<i class="icono-cross" style="color:#F00;"></i>
						</a>
				<?php

                    } ?>
				<?php
                    if ($po_status == "2") {
                        ?>
				<a href="<?=base_url()?>purchase_order/receive_purchase_order?po_id=<?php echo $id; ?>" style="text-decoration: none;">
					<button type="button" class="btn btn-primary">&nbsp;&nbsp;Receive&nbsp;&nbsp;</button>
				</a>
				<a href="<?=base_url()?>purchase_order/view_purchase_order?po_id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 10px;">
					<button type="button" class="btn btn-primary">&nbsp;&nbsp;View&nbsp;&nbsp;</button>
				</a>
				<?php
                    if ($user_role == "1") {
                        ?>
				<a href="<?=base_url()?>purchase_order/deletePO?id=<?php echo $id; ?>&po_numb=<?php echo $po_numb; ?>" style="text-decoration: none; margin-left: 10px;" onclick="return confirm('Are you sure to delete this Purchase Order : <?php echo $po_numb; ?>?')">
					<i class="icono-cross" style="color:#F00;"></i>
				</a>
				<?php

                    } ?>
				<?php

                    } ?>
				<?php
                    if ($po_status == "3") {
                        ?>
				<a href="<?=base_url()?>purchase_order/receive_purchase_order?po_id=<?php echo $id; ?>" style="text-decoration: none;">
					<button type="button" class="btn btn-primary">&nbsp;&nbsp;View&nbsp;&nbsp;</button>
				</a>
				<?php

                    } ?>
				
										</td>
									</tr>
						<?php	
                                    unset($id);
                                    unset($po_numb);
                                    unset($supplier_name);
                                    unset($po_date);
                                    unset($po_status);
                                }
                            } else {
                                ?>
								<tr>
									<td colspan="9" style="padding: 7px 7px; border-bottom: 1px solid #ddd; letter-spacing: 0.3px; text-align: center;">
										No match record found!
									</td>
								</tr>
						<?php

                            }
                        ?>
						</tbody>
					</table>
					</div>
					
					<div class="row">
						<div class="col-md-6" style="float: left; padding-top: 10px;">
							<?php echo $displayshowingentries; ?>
						</div>
						<div class="col-md-6" style="text-align: right;">
							<?php echo $links; ?>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>

<?php
    require_once "includes/footer.php";
?>