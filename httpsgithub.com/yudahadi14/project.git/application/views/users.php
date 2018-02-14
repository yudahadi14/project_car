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
			<h1 class="page-header">Users</h1>
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
					
					<?php
                        if ($user_role == "1") {
                            ?>
					<div class="row" style="padding-bottom: 15px;">
						<div class="col-md-6">
							<a href="<?=base_url()?>setting/add_user" style="text-decoration: none;">
								<button type="button" class="btn btn-primary">Add New User</button>
							</a>
						</div>
						<div class="col-md-6"></div>
					</div>
					<?php

                        }
                    ?>
					
					<div class="table-responsive">
					
						<table id="example" class="display" cellspacing="0" width="100%">
						    <thead>
						        <tr>
						            <th width="5%"><span>#</span></th>
						            <th width="15%"><span>Full Name</span></th>
							    	<th width="20%"><span>Email</span></th>
							    	<th width="20%"><span>Role</span></th>
							    	<th width="10%"><span>Status</span></th>
							    	<th width="20%"><span>Action</span></th>
						        </tr>
						    </thead>
							<tbody>
							<?php
                                if ($user_role == 1) {
                                    $userData        = $this->Constant_model->getDataAll("users", "id", "DESC");
                                } else {
                                    $userData        = $this->Constant_model->getDataOneColumn("users", "id", "$user_id");
                                }
                                
                                for ($i = 0; $i < count($userData); $i++) {
                                    $id        = $userData[$i]->id;
                                    $fullname    = $userData[$i]->fullname;
                                    $email        = $userData[$i]->email;
                                    $role_id    = $userData[$i]->role_id;
                                    $status    = $userData[$i]->status;
                                    
                                    
                                    
                                    $role_name    = "";
                                    $roleData    = $this->Constant_model->getDataOneColumn("user_roles", "id", $role_id);
                                    if (count($roleData) == 1) {
                                        $role_name    = $roleData[0]->name;
                                    } ?>
									<tr>
										<td>
											<?php echo $i+1; ?>
										</td>
										<td>
											<?php echo $fullname; ?>
										</td>
										<td>
											<?php 
                                                if (empty($email)) {
                                                    echo "-";
                                                } else {
                                                    echo $email;
                                                } ?>
										</td>
										<td>
											<?php
                                                echo $role_name; ?>
										</td>
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
											<a href="<?=base_url()?>setting/changePassword?id=<?php echo $id; ?>" style="text-decoration: none;">
												<button type="button" class="btn btn-primary">Change Password</button>
											</a>
											
											<a href="<?=base_url()?>setting/edit_user?id=<?php echo $id; ?>" style="text-decoration: none; margin-left: 10px;">
												<button type="button" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>
											</a>
										</td>
									</tr>
							<?php
                                    unset($id);
                                    unset($fullname);
                                    unset($email);
                                    unset($role_id);
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