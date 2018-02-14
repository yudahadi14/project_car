<?php
    require_once "includes/header.php";
    
    $packageData        = $this->Constant_model->getDataOneColumn("service_packages", "id", $pack_id);
    if (count($packageData) == 0) {
        redirect(base_url().'packages/package_lists', 'refresh');
    }
    
    $name        = $packageData[0]->name;
?>
<!-- Select2 -->
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet">

<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(document).on('ready', function() {
		
		$("#btn-todo").click(function () {
			var pack_id 	= document.getElementById("pack_id").value;
			var task_id		= document.getElementById("task").value;
			
			if(task_id.length == 0){
				alert("Please select task to Assign this Service Package : <?php echo $name; ?>!");
			} else {
				var addNewCustomer = $.ajax({
					url		: '<?=base_url()?>packages/assignTask?pack_id='+pack_id+'&task_id='+task_id,
					type	: 'GET',
					cache	: false,
					data	: {
						format: 'json'
					},
					error	: function() {
						//alert("Sorry! we do not have stock!");
					},
					dataType: 'json',
					success	: function(data) {
						var text 	= data.text;
						var errMsg 	= data.errorMsg;
						
						if(errMsg == "failure"){
							alert(text);
						} else {
							alert(text);
						}
						document.getElementById("task").value = "";
					}
				});
			}
		});
		
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Assign Task for Service Package : <?php echo $name; ?></h1>
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
					
					<div class="form-horizontal">
						<fieldset>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name" style="padding-top: 17px;">
									Assign Task <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<div class="panel-footer" style="border-top: 0px;">
										<div class="input-group">
											
											<select name="task" id="task" class="assign_task form-control" style="border-radius: 0px;">
												<option value="">Choose Task For Service Package</option>
											<?php
                                                $taskData        = $this->Constant_model->getDataOneColumnSortColumn("tasks", "status", "1", "name", "ASC");
                                                for ($t = 0; $t < count($taskData); $t++) {
                                                    $task_id    = $taskData[$t]->id;
                                                    $task_name    = $taskData[$t]->name; ?>
													<option value="<?php echo $task_id; ?>">
														<?php echo $task_name; ?>
													</option>
											<?php

                                                }
                                            ?>
											</select>
											
											<input type="hidden" id="pack_id" value="<?php echo $pack_id; ?>" />
											<span class="input-group-btn">
												<button class="btn btn-primary btn-md" id="btn-todo">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
											</span>
										</div>
									</div>
								</div>
								<div class="col-md-3"></div>
							</div>
						
							
						</fieldset>
					</div>
					
				</div>
			</div>
			
			<a href="<?=base_url()?>packages/edit_service_package?id=<?php echo $pack_id; ?>" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<script src="<?=base_url()?>assets/js/select2.full.min.js"></script>
<!-- Select2 -->
<script>
	$(document).ready(function() {
		
		$(".assign_task").select2({
			placeholder: "Choose Task For Service Package",
			allowClear: true
		});
	
	});
</script>
<!-- /Select2 -->

<?php
    require_once "includes/footer.php";
?>