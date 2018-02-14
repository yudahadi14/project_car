<?php
    require_once "includes/header.php";
?>
<script src="<?=base_url()?>assets/multisteps/jquery-1.8.2.min.js"></script>
<script src="<?=base_url()?>assets/multisteps/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/multisteps/jquery.wizard.js"></script>
<!-- <link href="<?=base_url()?>assets/multisteps/bootstrap.min.css" rel="stylesheet" media="screen"> -->
<link href="<?=base_url()?>assets/multisteps/jquery.wizard.css" rel="stylesheet">
<style type="text/css">
  
  .sidebar-nav {
    padding: 9px 0;
  }

  [data-wizard-init] {
	margin: auto;
	width: 600px;
  }
</style>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Open New Service</h1>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					Step 2 of 6 - Choose a Car
				</div>	
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
					
					<h4 style="font-weight: bold; padding-bottom: 10px; margin-top: -10px;">
						Choose car to do Servicing
					</h4>
					
					<form class="form-horizontal" action="<?=base_url()?>services/third_step" method="post">
						<fieldset>
							
							<div class="table-responsive">
								<table class="table">
									<thead>
										<tr>
									    	<th width="5%" style="border-bottom: 1px solid #111; height: 40px;"><span>Choose</span></th>
									    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Nama Merchant</span></th>
								            <th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Alamat</span></th> <th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>MIDTID</span></th>
								            <th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>No Telp Merchant</span></th>
								            <th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>PIC</span></th>
								            <th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Area</span></th>
									    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Owner</span></th>
									    	
									    	
									    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Color</span></th>
									    	
									    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Transmission</span></th>
										</tr>
									</thead>
									<tbody>
		<?php
            $searchResult    = $this->db->query("SELECT * FROM cars WHERE nama_merchant LIKE '%$nama_merchant%' ORDER BY id DESC ");
            $searchRows    = $searchResult->num_rows();
            if ($searchRows > 0) {
                $searchData    = $searchResult->result();
                
                for ($s = 0; $s < count($searchData); $s++) {
                    $car_id        = $searchData[$s]->id;
                    $alamat        = $searchData[$s]->alamat;
                    $mid_tid    = $searchData[$s]->mid_tid;
                    $car_make_id    = $searchData[$s]->car_make_id;
                    $tpic        = $searchData[$s]->pic;
                    $car_owner_id    = $searchData[$s]->owner_id;
                    $tarea        = $searchData[$s]->area;
                    $car_trans        = $searchData[$s]->transmission;
                    $tno_merchant    = $searchData[$s]->no_merchant;
                    $nama_merchant    = $searchData[$s]->nama_merchant;
                    
                    $owner_name    = "";
                    $ownerData        = $this->Constant_model->getDataOneColumn("customers", "id", $car_owner_id);
                    if (count($ownerData) == 1) {
                        $owner_name    = $ownerData[0]->firstname." ".$ownerData[0]->lastname;
                    }
                    
                    $make_name        = "";
                    $makeData        = $this->Constant_model->getDataOneColumn("car_make", "id", $car_make_id);
                    if (count($makeData) == 1) {
                        $make_name    = $makeData[0]->name;
                    } ?>
					<tr>
						<td>
							<input type="radio" name="car" value="<?php echo $car_id; ?>" />
						</td>
						<td>
							<?php echo $nama_merchant; ?>
						</td>
						<td>
							<?php echo $alamat; ?>
						</td>
						<td>
							<?php echo $mid_tid; ?>
						</td>
						<td>
							<?php echo $tno_merchant; ?>
						</td>
						<td>
							<?php echo $tpic; ?>
						</td>
						<td>
							<?php echo $tarea; ?>
						</td>
						<td>
							<?php echo $owner_name; ?>
						</td>
						<td>
							<?php echo $make_name; ?>
						</td>
						
						
						<td>
							<?php
                                if ($car_trans == "1") {
                                    echo "Automatic";
                                } elseif ($car_trans == "2") {
                                    echo "Manual";
                                } ?>
						</td>
					</tr>
		<?php
                    unset($car_id);
                    unset($alamat);
                    unset($car_make_id);
                    unset($tpic);
                    unset($car_owner_id);
                    unset($mid_tid);
                    unset($tarea);
                    unset($car_trans);
                    unset($tno_merchant);
                    unset($nama_merchant);
                } ?>
					<tr>
						<td colspan="9" align="center" style="text-align: center;">
							<button type="submit" class="btn btn-primary btn-md" style="padding-left: 30px; padding-right: 30px;">
								Next
							</button>
						</td>
					</tr>
		<?php
                unset($searchData);
            } else {
                ?>
				<tr>
					<td colspan="9" align="center" style="text-align: center; font-weight: bold; font-size: 15px; height: 40px">
						No record found for this Car Plate Number : <?php echo $nama_merchant; ?>
					</td>
				</tr>
		<?php

            }
            unset($searchResult);
            unset($searchRows);
        ?>
									</tbody>
								</table>
							</div>
							
							
						</fieldset>
					</form>
				
				<div class="row" style="border-top: 1px solid #ddd; padding-top: 20px;">
					<div class="col-md-12" style="text-align: center;">
						<div class="btn btn-primary" style="padding: 15px 25px; font-size: 20px; border-radius: 3px; cursor: pointer;" id="openToAdd">
							Click To Add New Car
						</div>
					</div>
				</div>
		
<script type="text/javascript">
	$(document).ready(function() {
		$("#openToAdd").click(function(){
			$('#calendarModal').modal();
		});
	});
</script>

<div id="calendarModal" class="modal fade">
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only">close</span></button>
            <h4 id="modalTitle" class="modal-title">Add New Car Detail</h4>
        </div>
        <div id="modalBody" class="modal-body">
	    <form action="<?=base_url()?>services/AddCustomerCar" method="post">
	        <!-- Customer // START -->
	        <div class="row">
		        <div class="col-md-12">
			        <label style="font-size: 15px; font-weight: bold;">Customer Detail</label>
		        </div>
	        </div>
	        <div class="row" style="padding-top: 5px; padding-bottom: 5px;">
		        <div class="col-md-3" style="padding-top: 8px;">NIRC *</div>
		        <div class="col-md-9">
			        <input type="text" name="nric" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
	        </div>
	        <div class="row" style="padding-top: 5px; padding-bottom: 5px;">
		        <div class="col-md-3" style="padding-top: 8px;">First Name *</div>
		        <div class="col-md-3">
			        <input type="text" name="fn" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
		        <div class="col-md-2" style="padding-top: 8px;">Last Name</div>
		        <div class="col-md-4">
			        <input type="text" name="ln" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" />
		        </div>
	        </div>
	        <div class="row" style="padding-top: 5px; padding-bottom: 5px;">
		        <div class="col-md-3" style="padding-top: 8px;">Mobile *</div>
		        <div class="col-md-9">
			        <input type="text" name="mb" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
	        </div>
	        <!-- Customer // END -->
	        
	        <!-- Car // START -->
	        <div class="row">
		        <div class="col-md-12">
			        <label style="font-size: 15px; font-weight: bold;">Car Detail</label>
		        </div>
	        </div>
	        <div class="row" style="padding-top: 5px; padding-bottom: 5px;">
		        <div class="col-md-3" style="padding-top: 8px;">
			        Car Plate No. *
		        </div>
		        <div class="col-md-9">
			        <input type="text" name="plate_numb" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
		    </div>
		    <div class="row" style="padding-top: 5px; padding-bottom: 5px;">
		        <div class="col-md-3" style="padding-top: 8px;">
			        Car Make *
		        </div>
		        <div class="col-md-3">
			        <select name="car_make" class="add_car_make form-control" required style="border: 1px solid #3a3a3a; color: #010101;">
						<option value="">Choose your car make</option>
					<?php
                        $carMakeData    = $this->Constant_model->getDataAll("car_make", "name", "ASC");
                        for ($c = 0; $c < count($carMakeData); $c++) {
                            $car_make_id    = $carMakeData[$c]->id;
                            $car_make_name    = $carMakeData[$c]->name; ?>
							<option value="<?php echo $car_make_id; ?>">
								<?php echo $car_make_name; ?>
							</option>
					<?php

                        }
                    ?>
					</select>
		        </div>
		        <div class="col-md-2" style="padding-top: 8px;">
			        Car&nbsp;Model&nbsp;*
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="car_model" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
		    </div>
		    <div class="row" style="padding-top: 5px; padding-bottom: 5px;">
		        <div class="col-md-3" style="padding-top: 8px;">
			        Chassis No. *
		        </div>
		        <div class="col-md-3">
			        <input type="text" name="chassis" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
		        <div class="col-md-2" style="padding-top: 8px;">
			        Color * 
		        </div>
		        <div class="col-md-4">
			        <input type="text" name="color" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
		    </div>
		    
		    <div class="row" style="padding-top: 5px; padding-bottom: 5px;">
		        <div class="col-md-3" style="padding-top: 8px;">
			        Mileage (km) *
		        </div>
		        <div class="col-md-3">
			        <input type="text" name="mileage" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required />
		        </div>
		        <div class="col-md-2" style="padding-top: 8px;">
			        Transmission * 
		        </div>
		        <div class="col-md-4">
			        <select name="transmission" class="form-control" style="border: 1px solid #3a3a3a; color: #010101;" required>
						<option value="">Choose your car Transmission</option>
						<option value="1">Automatic</option>
						<option value="2">Manual</option>
					</select>
		        </div>
		    </div>
	        <!-- Car // END -->
	        
        </div>
        <div class="modal-footer">
            <div class="row">
	            <div class="col-md-6" style="text-align: left;">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	            </div>
	            <div class="col-md-6" style="text-align: right;">
		            <button type="submit" class="btn btn-primary">Submit</button>
	            </div>
            </div>
        </div>
        </form>
    </div>
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