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
			<h1 class="page-header">Customer Groups</h1>
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
							<a href="<?=base_url()?>setting/add_customer_groups" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New Customer Group</button>
							</a>
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
						            <th width="25%"><span>Customer Group Name</span></th>
							    	<th width="25%"><span>Discount Percentage</span></th>
							    	<th width="10%"><span>Status</span></th>
							    	<th width="10%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                $groupData        = $this->Constant_model->getDataAll("customer_groups", "id", "DESC");
                                for ($g = 0; $g < count($groupData); $g++) {
                                    $id        = $groupData[$g]->id;
                                    $name        = $groupData[$g]->name;
                                    $percentage    = $groupData[$g]->discount_percentage;
                                    $status    = $groupData[$g]->status; ?>
									<tr>
										<td><?php echo $g+1; ?></td>
										<td><?php echo $name; ?></td>
										<td><?php echo $percentage; ?></td>
										<td style="font-weight: bold;">
											<?php
                                                if ($status == "0") {
                                                    echo '<span style="color: #F00;">Inactive</span>';
                                                }
                                    if ($status == "1") {
                                        echo '<span style="color: #090;">Active</span>';
                                    } ?>
										</td>
										<td>
											<a href="<?=base_url()?>setting/edit_customer_groups?id=<?php echo $id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php
                                    unset($id);
                                    unset($name);
                                    unset($percentage);
                                    unset($status);
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