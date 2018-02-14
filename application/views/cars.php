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
			<h1 class="page-header">Cars</h1>
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
							<a href="<?=base_url()?>cars/add_car" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New Car</button>
							</a>
						</div>
						<div class="col-md-6" style="text-align: right">
							<a href="<?=base_url()?>cars/exportCarsList" style="text-decoration: none;" target="_blank">
								<div class="btn btn-success">Export Cars List</div>
							</a>
						</div>
					</div>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
   							    	<th width="10%"><span>Nama Merchant</span></th>
						            <th width="10%"><span>Alamat</span></th>
						            <th width="10%"><span>MIDTID</span></th>	
							    	<th width="10%"><span>No Telp Merchant</span></th>
							    	<th width="10%"><span>PIC</span></th>
							    	<th width="10%"><span>Area</span></th>
							    	<th width="10%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                $carData    = $this->Constant_model->getDataAll("cars", "id", "DESC");
                                
                                for ($i = 0; $i < count($carData); $i++) {
                                    $id        = $carData[$i]->id;
                                    $nama_merchant = $carData[$i]->nama_merchant;
                                    $alamat        = $carData[$i]->alamat;
                                    $mid_tid    = $carData[$i]->mid_tid;
                                    $no_merchant = $carData[$i]->no_merchant;
                                    $problem        = $carData[$i]->problem;
                                    $make_id    = $carData[$i]->car_make_id;
                                    $pic        = $carData[$i]->pic;
                                    $owner_id    = $carData[$i]->owner_id;
                                    $area        = $carData[$i]->area;
                                    /**
                                    $owner_name    = "";
                                    $ownerData        = $this->Constant_model->getDataOneColumn("customers", "id", $owner_id);
                                    if (count($ownerData) == 1) {
                                        $owner_name    = $ownerData[0]->firstname." ".$ownerData[0]->lastname;
                                    }
                                    
                                    $make_name        = "";
                                    $makeData        = $this->Constant_model->getDataOneColumn("car_make", "id", $make_id);
                                    if (count($makeData) == 1) {
                                        $make_name    = $makeData[0]->name;
                                    }*/ 
                                    ?>
									<tr>
										<td><?php echo $i+1; ?></td>
										<td><?php echo $nama_merchant; ?></td>
										<td><?php echo $alamat; ?></td>
										<td><?php echo $mid_tid; ?></td>
										<td><?php echo $no_merchant; ?></td>
										<td><?php echo $pic; ?></td>
										<td><?php echo $area; ?></td>
										<td>
											<a href="<?=base_url()?>cars/edit_car?id=<?php echo $id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php
                                    unset($id);
                                    unset($nama_merchant);
                                    unset($alamat);	
                                    unset($mid_tid);
                                    unset($no_merchant);
                                    unset($make_id);
                                    unset($pic);
                                    unset($owner_id);
                                    unset($area);
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