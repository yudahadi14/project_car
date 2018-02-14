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
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
	
		<title><?php echo $setting_site_name; ?></title>
	
		<!-- Bootstrap -->
		<link href="<?=base_url()?>assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
		<!-- Font Awesome -->
		<link href="<?=base_url()?>assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
		<!-- NProgress -->
		<link href="<?=base_url()?>assets/vendors/nprogress/nprogress.css" rel="stylesheet">
		
		<!-- iCheck -->
	    <link href="<?=base_url()?>assets/vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	    <!-- bootstrap-wysiwyg -->
	    <link href="<?=base_url()?>assets/vendors/google-code-prettify/bin/prettify.min.css" rel="stylesheet">
	    <!-- Select2 -->
	    <link href="<?=base_url()?>assets/vendors/select2/dist/css/select2.min.css" rel="stylesheet">
	    <!-- Switchery -->
	    <link href="<?=base_url()?>assets/vendors/switchery/dist/switchery.min.css" rel="stylesheet">
	    <!-- starrr -->
	    <link href="<?=base_url()?>assets/vendors/starrr/dist/starrr.css" rel="stylesheet">
		
		<!-- Custom Theme Style -->
		<link href="<?=base_url()?>assets/build/css/custom.min.css" rel="stylesheet">
		
<script type="text/javascript">
	function kk(){
		document.getElementById("nextGo").style.display = "none";
		document.getElementById("pwait").style.display = "block";
	}
</script>

	</head>

	<body class="nav-md">
    	<div class="container body">
			<div class="main_container">
				<div class="col-md-3 left_col">
					<div class="left_col scroll-view">
			            
			            <div class="navbar nav_title" style="border: 0;">
			            	<a href="<?=base_url()?>" class="site_title"><span><?php echo $setting_site_name; ?></span></a>
			            </div>

						<div class="clearfix"></div>

						<!-- menu profile quick info -->
						<div class="profile">
							<div class="profile_pic">
								<img src="<?=base_url()?>assets/images/profile.png" alt="..." class="img-circle profile_img">
							</div>
							<div class="profile_info">
								<span>Welcome,</span>
								<h2><?php echo $login_name; ?></h2>
							</div>
						</div>
						<!-- /menu profile quick info -->

						<br />

						<!-- sidebar menu -->
						<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
							<div class="menu_section">
								<h3>&nbsp;</h3>
								
								<ul class="nav side-menu">
									<li>
										<a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li><a href="index.html">Dashboard</a></li>
											<li><a href="index2.html">Dashboard2</a></li>
											<li><a href="index3.html">Dashboard3</a></li>
										</ul>
									</li>
						
									<li>
										<a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li><a href="form.html">General Form</a></li>
											<li><a href="form_advanced.html">Advanced Components</a></li>
											<li><a href="form_validation.html">Form Validation</a></li>
											<li><a href="form_wizards.html">Form Wizard</a></li>
											<li><a href="form_upload.html">Form Upload</a></li>
											<li><a href="form_buttons.html">Form Buttons</a></li>
										</ul>
									</li>
									
									<li>
										<a><i class="fa fa-cog"></i> Setting <span class="fa fa-chevron-down"></span></a>
										<ul class="nav child_menu">
											<li><a href="<?=base_url()?>setting/system_setting">System Setting</a></li>
											<li><a href="<?=base_url()?>setting/payment_methods">Payment Methods</a></li>
											<li><a href="<?=base_url()?>setting/users">Users</a></li>
										</ul>
									</li>
									<!--
									<li>
										<a href="javascript:void(0)"><i class="fa fa-laptop"></i> Landing Page </a>
									</li>
									-->
								</ul>
							</div>
						</div>
						<!-- /sidebar menu -->

						
					</div>
				</div>

				<!-- top navigation -->
				<div class="top_nav">
					<div class="nav_menu">
						<nav>
							<div class="nav toggle">
								<a id="menu_toggle"><i class="fa fa-bars"></i></a>
							</div>
				
							<ul class="nav navbar-nav navbar-right">
								<li class="">
									<a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
										<img src="<?=base_url()?>assets/images/profile.png" alt=""><?php echo $login_name; ?>&nbsp;
										<span class=" fa fa-angle-down"></span>
									</a>
									<ul class="dropdown-menu dropdown-usermenu pull-right">
										<li><a href="javascript:;"> Profile</a></li>
										<li><a href="<?=base_url()?>auth/logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
									</ul>
								</li>
							</ul>
						</nav>
					</div>
				</div>
				<!-- /top navigation -->