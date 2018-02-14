<?php
    require_once "includes/header.php";
    
    $userData        = $this->Constant_model->getDataOneColumn("users", "id", $id);
    
    if (count($userData) == 0) {
        redirect(base_url().'setting/users', 'refresh');
    }
    
    $fn            = $userData[0]->fullname;
    $em            = $userData[0]->email;
    $db_role_id    = $userData[0]->role_id;
    $status        = $userData[0]->status;
?>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Edit User : <?php echo $fn; ?></h1>
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
					
					<form class="form-horizontal" action="<?=base_url()?>setting/updateUser" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Full Name <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="text" class="form-control" name="fullname" required style="width: 100%;" autofocus autocomplete="off" value="<?php echo $fn; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Email <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<input type="email" class="form-control" name="email" required style="width: 100%;" autocomplete="off" value="<?php echo $em; ?>" />
								</div>
								<div class="col-md-3"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="name">
									Role <span class="required">*</span>
								</label>
								<div class="col-md-7">
									<select name="role" class="form-control" required>
									<?php
                                        if ($user_role == "1") {
                                            $roleData    = $this->Constant_model->getDataAll("user_roles", "name", "ASC");
                                        } else {
                                            $roleData    = $this->Constant_model->getDataOneColumn("user_roles", "id", "$user_role");
                                        }
                                        
                                        for ($r = 0; $r < count($roleData); $r++) {
                                            $role_id        = $roleData[$r]->id;
                                            $role_name        = $roleData[$r]->name; ?>
											<option value="<?php echo $role_id; ?>" <?php if ($role_id == $db_role_id) {
                                                echo 'selected="selected"';
                                            } ?>>
												<?php echo $role_name; ?>
											</option>
									<?php
                                            unset($role_id);
                                            unset($role_name);
                                        }
                                    ?>
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
										<?php
                                            if ($user_role == "1") {
                                                ?>
										<option value="1" <?php if ($status == "1") {
                                                    echo 'selected="selected"';
                                                } ?>>Active</option>
										<option value="0" <?php if ($status == "0") {
                                                    echo 'selected="selected"';
                                                } ?>>Inactive</option>
										<?php

                                            } else {
                                                if ($status == "1") {
                                                    ?>
													<option value="1" <?php if ($status == "1") {
                                                        echo 'selected="selected"';
                                                    } ?>>Active</option>
										<?php

                                                } elseif ($status == "0") {
                                                    ?>
													<option value="0" <?php if ($status == "0") {
                                                        echo 'selected="selected"';
                                                    } ?>>Inactive</option>
										<?php

                                                }
                                            }
                                        ?>
										
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
			
			<a href="<?=base_url()?>setting/users" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<?php
    require_once "includes/footer.php";
?>