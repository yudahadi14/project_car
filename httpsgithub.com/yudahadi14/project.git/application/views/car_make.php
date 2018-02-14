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
			<h1 class="page-header">Car Make</h1>
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
							<a href="<?=base_url()?>setting/add_car_make" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New Car Make</button>
							</a>
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
						            <th width="25%"><span>Car Make Name</span></th>
							    	<th width="25%"><span>Type</span></th>
							    	<th width="10%"><span>Status</span></th>
							    	<th width="10%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                $makeData        = $this->Constant_model->getDataAll("car_make", "id", "DESC");
                                for ($i = 0; $i < count($makeData); $i++) {
                                    $make_id        = $makeData[$i]->id;
                                    $make_name        = $makeData[$i]->name;
                                    $make_type        = $makeData[$i]->type;
                                    $make_status    = $makeData[$i]->status; ?>
									<tr>
										<td>
											<?php echo $i+1; ?>
										</td>
										<td>
											<?php echo $make_name; ?>
										</td>
										<td>
											<?php
                                                if ($make_type == "1") {
                                                    echo "Japanese & Korean";
                                                } elseif ($make_type == "2") {
                                                    echo "Continental";
                                                } ?>
										</td>
										<td style="font-weight: bold;">
											<?php
                                                if ($make_status == 0) {
                                                    echo '<span style="color: #F00;">Inactive</span>';
                                                } elseif ($make_status == "1") {
                                                    echo '<span style="color: #090;">Active</span>';
                                                } ?>
										</td>
										<td>
											<a href="<?=base_url()?>setting/edit_car_make?id=<?php echo $make_id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php
                                    unset($make_id);
                                    unset($make_name);
                                    unset($make_type);
                                    unset($make_status);
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