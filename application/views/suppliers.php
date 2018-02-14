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
			<h1 class="page-header">Suppliers</h1>
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
                        if ($user_role < 3) {
                            ?>
					<div class="row" style="padding-bottom: 15px;">
						<div class="col-md-6">
							<a href="<?=base_url()?>setting/add_supplier" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New Supplier</button>
							</a>
						</div>
						<div class="col-md-6"></div>
					</div>
					<?php

                        }
                    ?>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
						            <th width="13%"><span>Name</span></th>
							    	<th width="13%"><span>Email</span></th>
							    	<th width="13%"><span>Telephone</span></th>
							    	<th width="13%"><span>Address</span></th>
							    	<th width="13%"><span>Status</span></th>
							    	<th width="13%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                $jj                    = 1;
                                $supplierData            = $this->Constant_model->getDataAll("suppliers", "id", "DESC");
                                for ($s = 0; $s < count($supplierData); $s++) {
                                    $supplier_id        = $supplierData[$s]->id;
                                    $supplier_name        = $supplierData[$s]->name;
                                    $supplier_email        = $supplierData[$s]->email;
                                    $supplier_tel        = $supplierData[$s]->telephone;
                                    $supplier_address    = $supplierData[$s]->address;
                                    $supplier_status    = $supplierData[$s]->status; ?>
									<tr>
										<td><?php echo $jj; ?></td>
										<td><?php echo $supplier_name; ?></td>
										<td>
											<?php
                                                if (empty($supplier_email)) {
                                                    echo "-";
                                                } else {
                                                    echo $supplier_email;
                                                } ?>
										</td>
										<td>
											<?php
                                                if (empty($supplier_tel)) {
                                                    echo "-";
                                                } else {
                                                    echo $supplier_tel;
                                                } ?>
										</td>
										<td>
											<?php
                                                if (empty($supplier_address)) {
                                                    echo "-";
                                                } else {
                                                    echo $supplier_address;
                                                } ?>
										</td>
										<td style="font-weight: bold">
											<?php
                                                if ($supplier_status == "0") {
                                                    echo '<span style="color: #F00;">Inactive</span>';
                                                }
                                    if ($supplier_status == "1") {
                                        echo '<span style="color: #090;">Active</span>';
                                    } ?>
										</td>
										<td>
											<a href="<?=base_url()?>setting/edit_supplier?id=<?php echo $supplier_id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php
                                    unset($supplier_id);
                                    unset($supplier_name);
                                    unset($supplier_email);
                                    unset($supplier_tel);
                                    unset($supplier_address);
                                    unset($supplier_status);
                                    
                                    $jj++;
                                }
                                unset($supplierData);
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