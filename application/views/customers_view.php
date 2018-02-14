<?php
    require_once "includes/header.php";
    
    $custData        = $this->Constant_model->getDataOneColumn("customers", "id", $id);
    
    if (count($custData) == 0) {
        redirect(base_url().'customers/customer_lists', 'refresh');
    }
    
    $cust_fn                = $custData[0]->firstname;
    $cust_ln                = $custData[0]->lastname;
    $nric                    = $custData[0]->nric;
    $email                    = $custData[0]->email;
    $mb                    = $custData[0]->mobile;
    $address                = $custData[0]->address;
    $postal                = $custData[0]->postal_code;
    $cust_country_code        = $custData[0]->country;
    $cust_customer_group    = $custData[0]->customer_group;
    $status                = $custData[0]->status;
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">View Customer Detail : <?php echo $cust_fn." ".$cust_ln; ?></h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				
				<div class="panel-heading">Customer Detail</div>
				<div class="panel-body form-horizontal" style="padding: 25px;">
					<fieldset>
						<div class="form-group">
							<label class="col-md-2 control-label" for="name">
								<b>NIRC</b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: <?php echo $nric; ?>
							</div>
							<label class="col-md-3 control-label" for="name">
								<b>Full Name</b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: <?php echo $cust_fn." ".$cust_ln; ?>
							</div>
							<div class="col-md-1"></div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label" for="name">
								<b>Email </b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: 
								<?php
                                    if (empty($email)) {
                                        echo "-";
                                    } else {
                                        echo $email;
                                    }
                                ?>
							</div>
							<label class="col-md-3 control-label" for="name">
								<b>Mobile</b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: <?php echo $mb; ?>
							</div>
							<div class="col-md-1"></div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label" for="name">
								<b>Address </b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: 
								<?php
                                    if (empty($address)) {
                                        echo "-";
                                    } else {
                                        echo $address;
                                    }
                                ?>
							</div>
							<label class="col-md-3 control-label" for="name">
								<b>Postal</b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: 
								<?php
                                    if (empty($postal)) {
                                        echo "-";
                                    } else {
                                        echo $postal;
                                    }
                                ?>
							</div>
							<div class="col-md-1"></div>
						</div>
						
						<div class="form-group">
							<label class="col-md-2 control-label" for="name">
								<b>Country </b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: 
								<?php
                                    $country_name    = "";
                                    if (!empty($cust_country_code)) {
                                        $countryData        = $this->Constant_model->getDataOneColumn("countries", "code", $cust_country_code);
                                        if (count($countryData) == 1) {
                                            $country_name    = $countryData[0]->name;
                                        }
                                    }
                                    
                                    if (!empty($country_name)) {
                                        echo $country_name;
                                    } else {
                                        echo "-";
                                    }
                                ?>
							</div>
							<label class="col-md-3 control-label" for="name">
								<b>Customer Group</b>
							</label>
							<div class="col-md-3" style="padding-top: 8px;">
								: <?php
                                    $group_name    = "";
                                    if (!empty($cust_customer_group)) {
                                        $groupData        = $this->Constant_model->getDataOneColumn("customer_groups", "id", $cust_customer_group);
                                        if (count($groupData) == 1) {
                                            $group_name    = $groupData[0]->name;
                                        }
                                        
                                        echo $group_name;
                                    } else {
                                        echo "-";
                                    }
                                ?>
							</div>
							<div class="col-md-1"></div>
						</div>
					</fieldset>
				</div>
			</div>
			
			<div class="panel panel-default">
				<div class="panel-heading"><?php echo $cust_fn." ".$cust_ln; ?> Cars Detail</div>
				<div class="panel-body form-horizontal" style="padding: 5px 25px 25px 25px;">
					
					<div class="table-responsive">
						
						<table class="table">
							<thead>
								<tr>
							    	<th width="5%" style="border-bottom: 1px solid #111; height: 40px;"><span>#</span></th>
						            <th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Plate No.</span></th>
							    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Owner</span></th>
							    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Car Make</span></th>
							    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Car Model</span></th>
							    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Color</span></th>
							    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Mileage</span></th>
								</tr>
							</thead>
							<tbody>
								<?php
                                    $carData    = $this->Constant_model->getDataOneColumn("cars", "owner_id", "$id");
                                    
                                    if (count($carData) > 0) {
                                        for ($i = 0; $i < count($carData); $i++) {
                                            $id        = $carData[$i]->id;
                                            $plate        = $carData[$i]->plate_number;
                                            $make_id    = $carData[$i]->car_make_id;
                                            $model        = $carData[$i]->car_model;
                                            $owner_id    = $carData[$i]->owner_id;
                                            $mileage    = $carData[$i]->mileage;
                                            $color        = $carData[$i]->color;
                                            
                                            $owner_name    = "";
                                            $ownerData        = $this->Constant_model->getDataOneColumn("customers", "id", $owner_id);
                                            if (count($ownerData) == 1) {
                                                $owner_name    = $ownerData[0]->firstname." ".$ownerData[0]->lastname;
                                            }
                                            
                                            $make_name        = "";
                                            $makeData        = $this->Constant_model->getDataOneColumn("car_make", "id", $make_id);
                                            if (count($makeData) == 1) {
                                                $make_name    = $makeData[0]->name;
                                            } ?>
											<tr>
												<td><?php echo $i+1; ?></td>
												<td><?php echo $plate; ?></td>
												<td><?php echo $owner_name; ?></td>
												<td><?php echo $make_name; ?></td>
												<td><?php echo $model; ?></td>
												<td><?php echo $color; ?></td>
												<td><?php echo $mileage; ?> km</td>
											</tr>
								<?php
                                            unset($id);
                                            unset($plate);
                                            unset($make_id);
                                            unset($model);
                                            unset($owner_id);
                                            unset($mileage);
                                            unset($color);
                                        }
                                    } else {
                                        ?>
										<tr>
											<td align="center" colspan="7">
												No matching records found!
											</td>
										</tr>
								<?php	
                                    }
                                ?>
							</tbody>
						</table>
					</div><!-- End of Responsive DIV -->
					
				</div>
			</div>
			
			<a href="<?=base_url()?>customers/customer_lists" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>