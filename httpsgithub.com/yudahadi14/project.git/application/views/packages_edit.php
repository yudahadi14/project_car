<?php
    require_once "includes/header.php";
    
    $packageData        = $this->Constant_model->getDataOneColumn("service_packages", "id", $id);
    if (count($packageData) == 0) {
        redirect(base_url().'packages/package_lists', 'refresh');
    }
    
    $name        = $packageData[0]->name;
    $desc        = $packageData[0]->description;
    $price        = $packageData[0]->price;
    $type        = $packageData[0]->car_make_type;
    $dis        = $packageData[0]->discount_applicable;
    $status    = $packageData[0]->status;
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit Service Package</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				
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
					
					<form class="form-horizontal" action="<?=base_url()?>packages/updatePackage" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Package Name <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="name" required style="width: 100%;" autofocus autocomplete="off" value="<?php echo $name; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Package Description
								</label>
								<div class="col-md-7">
									<textarea name="description" class="form-control"><?php echo $desc; ?></textarea>
								</div>
								<div class="col-md-3"></div>
							</div>
						
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Package Price <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="price" required style="width: 100%;" autofocus autocomplete="off" value="<?php echo $price; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Car Make Type <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="car_make_type" class="form-control" required>
										<option value="">Choose Car Make Type for Service Package</option>
										<option value="1" <?php if ($type == "1") {
                        echo 'selected="selected"';
                    } ?>>Japanese & Korean</option>
										<option value="2" <?php if ($type == "2") {
                        echo 'selected="selected"';
                    } ?>>Continental</option>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Discount Applicable <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="discount_applicable" class="form-control">
										<option value="0" <?php if ($dis == "0") {
                        echo 'selected="selected"';
                    } ?>>No</option>
										<option value="1" <?php if ($dis == "1") {
                        echo 'selected="selected"';
                    } ?>>Yes</option>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Status <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="status" class="form-control">
										<option value="1" <?php if ($status == "1") {
                        echo 'selected="selected"';
                    } ?>>Active</option>
										<option value="0" <?php if ($status == "0") {
                        echo 'selected="selected"';
                    } ?>>Inactive</option>
									</select>
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-7 widget-left" style="height: auto; padding-top: 0px;">
									
									<input type="hidden" name="id" value="<?php echo $id; ?>" />
									<button type="submit" class="btn btn-primary btn-md pull-left" id="nextGo">&nbsp;&nbsp;&nbsp;Update&nbsp;&nbsp;&nbsp;</button>
									
									<span id="pwait" style="display: none; font-size: 14px; font-weight: 300; font-family: 'Futura,Trebuchet MS',Arial,sans-serif;">
										<img src="<?=base_url()?>assets/images/loading.gif" />
										&nbsp;Processing.....
									</span>
									
								</div>
								<div class="col-md-3"></div>
							</div>
						</fieldset>
					</form>
					
				</div>
			</div>
			
			
			<div class="panel panel-default">
				<div class="panel-heading">
					Service Package : <?php echo $name; ?>'s Tasks
					
					&nbsp;&nbsp;
					<a href="<?=base_url()?>packages/packageAssignTask?pack_id=<?php echo $id; ?>" style="text-decoration: none;">
						<button type="button" class="btn btn-primary btn-md">&nbsp;&nbsp;&nbsp;Assign Task&nbsp;&nbsp;&nbsp;</button>
					</a>
					
				</div>
				<div class="panel-body form-horizontal" style="padding: 5px 25px 25px 25px;">
					<div class="table-responsive">
						
						<table class="table" style="width: 50%;">
							<thead>
								<tr>
							    	<th width="5%" style="border-bottom: 1px solid #111; height: 40px;"><span>#</span></th>
						            <th width="10%" style="border-bottom: 1px solid #111; height: 40px;"><span>Task Name</span></th>
							    	<th width="10%" style="border-bottom: 1px solid #111; height: 40px; text-align: center;"><span>Action</span></th>
								</tr>
							</thead>
							<tbody>
							<?php
                                $taskData    = $this->Constant_model->getDataOneColumnSortColumn("service_package_tasks", "service_package_id", $id, "id", "DESC");
                                if (count($taskData) > 0) {
                                    for ($t = 0; $t < count($taskData); $t++) {
                                        $pack_task_id        = $taskData[$t]->id;
                                        $task_id            = $taskData[$t]->task_id;
                                        
                                        $taskNameData        = $this->Constant_model->getDataOneColumn("tasks", "id", "$task_id");
                                        $task_name            = $taskNameData[0]->name; ?>
										<tr>
											<td><?php echo $t+1; ?></td>
											<td><?php echo $task_name; ?></td>
											<td align="center">
												<form action="<?=base_url()?>packages/deletePackageTask" method="post" onsubmit="return confirm('Are you confirm to delete this Task : <?php echo $task_name; ?>?')">
													<input type="hidden" name="pack_task_id" value="<?php echo $pack_task_id; ?>" />
													<input type="hidden" name="pack_id" value="<?php echo $id; ?>" />
													<input type="hidden" name="task_id" value="<?php echo $task_id; ?>" />
													<button type="submit" style="border: 0px; background-color: #FFF;">
														<i class="icono-cross" style="color: #900; cursor: pointer; width: 20px; height: 20px;"></i>
													</button>
												</form>
											</td>
										</tr>
							<?php

                                    }
                                } else {
                                    ?>
									<tr>
										<td align="center" colspan="3">
											No Task yet for this Service Package : <?php echo $name; ?>!
										</td>
									</tr>
							<?php

                                }
                            ?>
							</tbody>
						</table>
						
					</div>
				</div>
			</div>
			
			<a href="<?=base_url()?>packages/package_lists" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>