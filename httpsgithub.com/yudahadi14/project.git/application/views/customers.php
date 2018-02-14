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
			<h1 class="page-header">Customers</h1>
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
							<a href="<?=base_url()?>customers/add_customer" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New Customer</button>
							</a>
						</div>
						<div class="col-md-6" style="text-align: right">
							<a href="<?=base_url()?>customers/exportCustomersList" style="text-decoration: none;" target="_blank">
								<div class="btn btn-success">Export Customers List</div>
							</a>
						</div>
					</div>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
						            <th width="15%"><span>Full Name</span></th>
							    	<th width="10%"><span>NRIC</span></th>
							    	<th width="10%"><span>Email</span></th>
							    	<th width="10%"><span>Mobile</span></th>
							    	<th width="10%"><span>Customer Group</span></th>
							    	<th width="20%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                $customerData        = $this->Constant_model->getDataAll("customers", "id", "DESC");
                                for ($c = 0; $c < count($customerData); $c++) {
                                    $cust_id        = $customerData[$c]->id;
                                    $cust_fn        = $customerData[$c]->firstname;
                                    $cust_ln        = $customerData[$c]->lastname;
                                    $cust_nric        = $customerData[$c]->nric;
                                    $cust_mb        = $customerData[$c]->mobile;
                                    $cust_group_id    = $customerData[$c]->customer_group;
                                    $cust_em        = $customerData[$c]->email;
                                    
                                    $cust_group_name    = "";
                                    $groupData            = $this->Constant_model->getDataOneColumn("customer_groups", "id", $cust_group_id);
                                    if (count($groupData) == 1) {
                                        $cust_group_name    = $groupData[0]->name;
                                    } ?>
									<tr>
										<td><?php echo $c+1; ?></td>
										<td><?php echo $cust_fn." ".$cust_ln; ?></td>
										<td><?php echo $cust_nric; ?></td>
										<td>
											<?php
                                                if (empty($cust_em)) {
                                                    echo "-";
                                                } else {
                                                    echo $cust_em;
                                                } ?>
										</td>
										<td><?php echo $cust_mb; ?></td>
										<td><?php echo $cust_group_name; ?></td>
										<td>
											<a href="<?=base_url()?>customers/view_customer?id=<?php echo $cust_id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;View&nbsp;&nbsp;&nbsp;</button>
											</a>
											&nbsp;&nbsp;&nbsp;
											<a href="<?=base_url()?>customers/edit_customer?id=<?php echo $cust_id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php	
                                    unset($cust_id);
                                    unset($cust_fn);
                                    unset($cust_ln);
                                    unset($cust_nric);
                                    unset($cust_mb);
                                    unset($cust_group_id);
                                    unset($cust_em);
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