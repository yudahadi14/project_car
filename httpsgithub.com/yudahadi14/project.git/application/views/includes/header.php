<?php
    $user_id        = $this->session->userdata('user_id');
    $user_em        = $this->session->userdata('user_email');
    $user_role        = $this->session->userdata('user_role');
    
    if (empty($user_id)) {
        redirect(base_url(), 'refresh');
    }
    
    $tk_c        = $this->router->class;
    $tk_m        = $this->router->method;

    $alert_msg    = $this->session->flashdata('alert_msg');
    
    $settingResult            = $this->db->get_where('site_setting');
    $settingData            = $settingResult->row();

    $setting_site_name        = $settingData->site_name;
    $setting_pagination    = $settingData->pagination;
    $setting_tax            = $settingData->tax;
    $setting_currency        = $settingData->currency;
    $setting_date            = $settingData->datetime_format;
    
    $login_name = '';
    $this->db->where('id', $user_id);
    $query            = $this->db->get('users');
    $result        = $query->result();

    $login_name    = $result[0]->fullname;
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php echo $setting_site_name; ?></title>

<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/datepicker3.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet">

<!--Icons-->
<script src="<?=base_url()?>assets/js/lumino.glyphs.js"></script>

<link href="<?=base_url()?>assets/css/icono.min.css" rel="stylesheet">

<!--[if lt IE 9]>
<script src="<?=base_url()?>assets/js/html5shiv.js"></script>
<script src="<?=base_url()?>assets/js/respond.min.js"></script>
<![endif]-->

	<script src="<?=base_url()?>assets/js/jquery.min.js"></script>
	
	<!-- Data Table // START -->
	<script type="text/javascript" src="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.js"></script>
	<link href="<?=base_url()?>assets/js/datatables/jquery.dataTables.min.css" rel="stylesheet">
	
	

		
	<script type="text/javascript">
		$(document).ready(function(){
		    $("#closeAlert").click(function(){
		        $("#notificationWrp").fadeToggle(1000);
		    });
		});
		
		function kk(){
			document.getElementById("nextGo").style.display = "none";
			document.getElementById("pwait").style.display = "block";
		}
	</script>

</head>

<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php
                    if ($user_role == "3") {
                        ?>
				<a class="navbar-brand" href="<?=base_url()?>technician_services/tech_opened_services"><span><?php echo $setting_site_name; ?></span></a>
				<?php

                    } else {
                        ?>
				<a class="navbar-brand" href="<?=base_url()?>"><span><?php echo $setting_site_name; ?></span></a>
				<?php

                    }
                ?>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> <?php echo $login_name; ?> <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="<?=base_url()?>setting/edit_user?id=<?php echo $user_id; ?>"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Profile</a></li>
							<li><a href="<?=base_url()?>setting/users"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"></use></svg> Settings</a></li>
							<li><a href="<?=base_url()?>auth/logout"><svg class="glyph stroked cancel"><use xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
							
		</div><!-- /.container-fluid -->
	</nav>
		
	<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
		
		<!-- Admin // START -->
		<?php
            if ($user_role == "1") {
                ?>
		<ul class="nav menu">
			<li <?php if ($tk_c == "dashboard") {
                    ?> class="active" <?php 
                } ?>>
				<a href="<?=base_url()?>dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a>
			</li>
			
			<li <?php if ($tk_c == "services") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#services">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Services
				</a>
				<ul class="children <?php if ($tk_c != "services") {
                    ?> collapse <?php 
                } ?>" id="services">
					<li>
						<a <?php if (($tk_m == "new_service") || ($tk_m == "second_step") || ($tk_m == "third_step") || ($tk_m == "fourth_step") || ($tk_m == "fifth_step") || ($tk_m == "verify_step") || ($tk_m == "service_confirmation")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/new_service">
							New Service
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "opened_services") || ($tk_m == "view_opened_service")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/opened_services">
							Opened Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "request_inventory_services") || ($tk_m == "request_inventory_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/request_inventory_services">
							Requested Inventory Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "drew_out_inventory_services") || ($tk_m == "drew_out_inventory_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/drew_out_inventory_services">
							Drew Out Inventory Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "completed_services") || ($tk_m == "completed_services_view") || ($tk_m == "generateInvoice")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/completed_services">
							Completed Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "invoiced_services") || ($tk_m == "invoiced_services_view") || ($tk_m == "paymentInvoice")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/invoiced_services">
							Invoiced Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "closed_services") || ($tk_m == "closed_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/closed_services">
							Closed Services
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "cars") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#cars">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Cars
				</a>
				<ul class="children <?php if ($tk_c != "cars") {
                    ?> collapse <?php 
                } ?>" id="cars">
					<li>
						<a <?php if (($tk_m == "car_lists") || ($tk_m == "add_car") || ($tk_m == "edit_car")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>cars/car_lists">
							Cars
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "customers") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#customers">
					<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"/></svg>  Customers
				</a>
				<ul class="children <?php if ($tk_c != "customers") {
                    ?> collapse <?php 
                } ?>" id="customers">
					<li>
						<a <?php if (($tk_m == "customer_lists") || ($tk_m == "add_customer") || ($tk_m == "edit_customer") || ($tk_m == "view_customer")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>customers/customer_lists">
							Customers
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "materials") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#materials">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Materials
				</a>
				<ul class="children <?php if ($tk_c != "materials") {
                    ?> collapse <?php 
                } ?>" id="materials">
					<li>
						<a <?php if (($tk_m == "materials") || ($tk_m == "add_material") || ($tk_m == "edit_material")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>materials/materials_list">
							Materials List
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "packages") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#service_packages">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Service Packages
				</a>
				<ul class="children <?php if ($tk_c != "packages") {
                    ?> collapse <?php 
                } ?>" id="service_packages">
					<li>
						<a <?php if (($tk_m == "package_lists") || ($tk_m == "add_service_package") || ($tk_m == "edit_service_package") || ($tk_m == "packageAssignTask")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>packages/package_lists">
							Packages
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "task_lists") || ($tk_m == "add_service_task") || ($tk_m == "edit_service_task")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>packages/task_lists">
							Tasks
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "profit_loss") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#profit_loss">
					<svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"/></svg>  Profit &amp; Loss
				</a>
				<ul class="children <?php if ($tk_c != "profit_loss") {
                    ?> collapse <?php 
                } ?>" id="profit_loss">
					<li>
						<a <?php if (($tk_m == "pnl_monthly")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>profit_loss/pnl">
							Profit &amp; Loss
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "purchase_order") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#po">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Purchase Order
				</a>
				<ul class="children <?php if ($tk_c != "purchase_order") {
                    ?> collapse <?php 
                } ?>" id="po">
					<li>
						<a <?php if (($tk_m == "purchase_order") || ($tk_m == "create_purchase_order") || ($tk_m == "view_purchase_order") || ($tk_m == "edit_purchase_order") || ($tk_m == "po_view") || ($tk_m == "receive_purchase_order")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>purchase_order/po_view">
							Purchase Order
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "setting") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#setting">
					<svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg>  Setting
				</a>
				<ul class="children <?php if ($tk_c != "setting") {
                    ?> collapse <?php 
                } ?>" id="setting">
					<li>
						<a <?php if ($tk_m == "system_setting") {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/system_setting">
							System Setting
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "payment_methods") || ($tk_m == "edit_payment_method") || ($tk_m == "add_payment_method")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/payment_methods">
							Payment Methods
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "users") || ($tk_m == "edit_user") || ($tk_m == "add_user") || ($tk_m == "changePassword")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/users">
							Users
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "car_make") || ($tk_m == "edit_car_make") || ($tk_m == "add_car_make")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/car_make">
							Car Make
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "customer_groups") || ($tk_m == "edit_customer_groups") || ($tk_m == "add_customer_groups")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/customer_groups">
							Customer Groups
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "suppliers") || ($tk_m == "add_supplier") || ($tk_m == "edit_supplier")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/suppliers">
							Suppliers
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<?php

            }
        ?>
		<!-- Admin // End -->
		
		<!-- Service Advisor // START -->
		<?php
            if ($user_role == "2") {
                ?>
		<ul class="nav menu">
			<li <?php if ($tk_c == "dashboard") {
                    ?> class="active" <?php 
                } ?>>
				<a href="<?=base_url()?>dashboard"><svg class="glyph stroked dashboard-dial"><use xlink:href="#stroked-dashboard-dial"></use></svg> Dashboard</a>
			</li>
			
			<li <?php if ($tk_c == "services") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#services">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Services
				</a>
				<ul class="children <?php if ($tk_c != "services") {
                    ?> collapse <?php 
                } ?>" id="services">
					<li>
						<a <?php if (($tk_m == "new_service") || ($tk_m == "second_step") || ($tk_m == "third_step") || ($tk_m == "fourth_step") || ($tk_m == "fifth_step") || ($tk_m == "verify_step") || ($tk_m == "service_confirmation")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/new_service">
							New Service
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "opened_services") || ($tk_m == "view_opened_service")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/opened_services">
							Opened Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "request_inventory_services") || ($tk_m == "request_inventory_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/request_inventory_services">
							Requested Inventory Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "drew_out_inventory_services") || ($tk_m == "drew_out_inventory_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/drew_out_inventory_services">
							Drew Out Inventory Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "completed_services") || ($tk_m == "completed_services_view") || ($tk_m == "generateInvoice")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/completed_services">
							Completed Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "invoiced_services") || ($tk_m == "invoiced_services_view") || ($tk_m == "paymentInvoice")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/invoiced_services">
							Invoiced Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "closed_services") || ($tk_m == "closed_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>services/closed_services">
							Closed Services
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "cars") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#cars">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Cars
				</a>
				<ul class="children <?php if ($tk_c != "cars") {
                    ?> collapse <?php 
                } ?>" id="cars">
					<li>
						<a <?php if (($tk_m == "car_lists") || ($tk_m == "add_car") || ($tk_m == "edit_car")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>cars/car_lists">
							Cars
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "customers") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#customers">
					<svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"/></svg>  Customers
				</a>
				<ul class="children <?php if ($tk_c != "customers") {
                    ?> collapse <?php 
                } ?>" id="customers">
					<li>
						<a <?php if (($tk_m == "customer_lists") || ($tk_m == "add_customer") || ($tk_m == "edit_customer") || ($tk_m == "view_customer")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>customers/customer_lists">
							Customers
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "materials") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#materials">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Materials
				</a>
				<ul class="children <?php if ($tk_c != "materials") {
                    ?> collapse <?php 
                } ?>" id="materials">
					<li>
						<a <?php if (($tk_m == "materials") || ($tk_m == "add_material") || ($tk_m == "edit_material")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>materials/materials_list">
							Materials List
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "packages") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#service_packages">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Service Packages
				</a>
				<ul class="children <?php if ($tk_c != "packages") {
                    ?> collapse <?php 
                } ?>" id="service_packages">
					<li>
						<a <?php if (($tk_m == "package_lists") || ($tk_m == "add_service_package") || ($tk_m == "edit_service_package") || ($tk_m == "packageAssignTask")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>packages/package_lists">
							Packages
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "task_lists") || ($tk_m == "add_service_task") || ($tk_m == "edit_service_task")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>packages/task_lists">
							Tasks
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "purchase_order") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#po">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Purchase Order
				</a>
				<ul class="children <?php if ($tk_c != "purchase_order") {
                    ?> collapse <?php 
                } ?>" id="po">
					<li>
						<a <?php if (($tk_m == "purchase_order") || ($tk_m == "create_purchase_order") || ($tk_m == "view_purchase_order") || ($tk_m == "edit_purchase_order") || ($tk_m == "po_view") || ($tk_m == "receive_purchase_order")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>purchase_order/po_view">
							Purchase Order
						</a>
					</li>
				</ul>
			</li>
			
			<li <?php if ($tk_c == "setting") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#setting">
					<svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg>  Setting
				</a>
				<ul class="children <?php if ($tk_c != "setting") {
                    ?> collapse <?php 
                } ?>" id="setting">
					<li>
						<a <?php if (($tk_m == "users") || ($tk_m == "edit_user") || ($tk_m == "add_user") || ($tk_m == "changePassword")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/users">
							Users
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "car_make") || ($tk_m == "edit_car_make") || ($tk_m == "add_car_make")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/car_make">
							Car Make
						</a>
					</li>
				</ul>
			</li>
		</ul>
		<?php

            }
        ?>
		<!-- Service Advisor // END -->
		
		<!-- Technician // START -->
		<?php
            if ($user_role == "3") {
                ?>
		<ul class="nav menu">
			<li <?php if ($tk_c == "technician_services") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#technician_services">
					<svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg>  Services
				</a>
				<ul class="children <?php if ($tk_c != "technician_services") {
                    ?> collapse <?php 
                } ?>" id="technician_services">
					<li>
						<a <?php if (($tk_m == "tech_opened_services") || ($tk_m == "tech_opened_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>technician_services/tech_opened_services">
							Opened Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "tech_requested_inventory_services") || ($tk_m == "tech_requested_inventory_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>technician_services/tech_requested_inventory_services">
							Requested Inventory Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "tech_drew_out_inventory_services") || ($tk_m == "tech_drew_out_inventory_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>technician_services/tech_drew_out_inventory_services">
							Drew Out Inventory Services
						</a>
					</li>
					<li>
						<a <?php if (($tk_m == "tech_completed_services") || ($tk_m == "tech_completed_services_view")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>technician_services/tech_completed_services">
							Completed Service
						</a>
					</li>
				</ul>
			</li>
			<li <?php if ($tk_c == "setting") {
                    ?> class="parent active" <?php 
                } else {
                    ?> class="parent" <?php 
                } ?>>
				<a data-toggle="collapse" href="#setting">
					<svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg>  Setting
				</a>
				<ul class="children <?php if ($tk_c != "setting") {
                    ?> collapse <?php 
                } ?>" id="setting">
					<li>
						<a <?php if (($tk_m == "users") || ($tk_m == "edit_user") || ($tk_m == "add_user") || ($tk_m == "changePassword")) {
                    ?> style="background-color: #e9ecf2;" <?php 
                } ?> href="<?=base_url()?>setting/users">
							Users
						</a>
					</li>
				</ul>
			</li>
		</ul>
		
		<?php	
            }
        ?>
		<!-- Technician // END -->

	</div><!--/.sidebar-->