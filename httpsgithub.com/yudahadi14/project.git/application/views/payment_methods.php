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
			<h1 class="page-header">Payment Methods</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					<div class="row" style="padding-bottom: 15px;">
						<div class="col-md-6">
							<a href="<?=base_url()?>setting/add_payment_method" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New Payment Method</button>
							</a>
						</div>
						<div class="col-md-6"></div>
					</div>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
						            <th width="20%"><span>Name</span></th>
							    	<th width="10%"><span>Status</span></th>
							    	<th width="10%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                $paymentData    = $this->Constant_model->getDataAll("payment_method", "id", "DESC");
                                for ($p = 0; $p < count($paymentData); $p++) {
                                    $pay_id        = $paymentData[$p]->id;
                                    $pay_name        = $paymentData[$p]->name;
                                    $pay_status    = $paymentData[$p]->status; ?>
									<tr>
										<td>
											<?php echo $p+1; ?>
										</td>
										<td>
											<?php echo $pay_name; ?>
										</td>
										<td style="font-weight: bold;">
											<?php
                                                if ($pay_status == "0") {
                                                    echo '<span style="color: #F00;">Inactive</span>';
                                                }
                                    if ($pay_status == "1") {
                                        echo '<span style="color: #090;">Active</span>';
                                    } ?>
										</td>
										<td>
											<a href="<?=base_url()?>setting/edit_payment_method?id=<?php echo $pay_id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php
                                    unset($pay_id);
                                    unset($pay_name);
                                    unset($pay_status);
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