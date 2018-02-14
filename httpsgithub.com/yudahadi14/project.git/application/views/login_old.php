<?php
    $alert_msg            = $this->session->flashdata('alert_msg');

    $settingResult        = $this->db->get_where('site_setting');
    $settingData        = $settingResult->row();

    $setting_logo        = $settingData->site_logo;
    $setting_site_name    = $settingData->site_name;
    $setting_timezone    = $settingData->timezone;
    $setting_pagination = $settingData->pagination;
    $setting_tax        = $settingData->tax;
    $setting_currency    = $settingData->currency;
    $setting_date        = $settingData->datetime_format;

    date_default_timezone_set("$setting_timezone");
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
    <!-- Animate.css -->
    <link href="<?=base_url()?>assets/vendors/animate.css/animate.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?=base_url()?>assets/build/css/custom.min.css" rel="stylesheet">
  </head>

	<body class="login">
		<div>
			<div class="login_wrapper">
				<div class="animate form login_form">
					
					<div class="row" style="padding-bottom: 30px;">
						<div class="col-md-12" style="text-align: center;">
							<h1 style="font-size: 32px;"><?php echo $setting_site_name; ?></h1>
						</div>
					</div>
						
					<section class="login_content">
					
						<form action="<?=base_url()?>auth/login" method="post">
							<h1>Account Access</h1>
							<div>
								<input type="text" name="email" class="form-control" placeholder="Email Address" required autofocus autocomplete="off" />
							</div>
							<div>
								<input type="password" name="password" class="form-control" placeholder="Password" required autocomplete="off" />
							</div>
							<div class="row">
								<div class="col-md-12" style="text-align: center;">
									<input type="submit" name="sp_login" class="buttonPrevious btn btn-primary" value="Log In" />
								</div>
							</div>
							
							<?php
                                if (!empty($alert_msg)) {
                                    $flash_status = $alert_msg[0];
                                    $flash_header = $alert_msg[1];
                                    $flash_desc = $alert_msg[2];

                                    if ($flash_status == 'failure') {
                                        ?>
	                        <div class="row">
								<div class="col-md-12" style="text-align: center; color: #c72a25; margin-top: 10px;">
									<?php echo $flash_desc; ?>
								</div>
							</div>
	                        <?php 
                                    }
                                }
                            ?>
							
							<div class="separator">
								<div>
									<p>&copy; <?php echo date('Y', time()); ?> - <?php echo $setting_site_name; ?> - All Rights Reserved.</p>
								</div>
							</div>
						</form>
						
					</section>
				</div>
			</div>
		</div>
	</body>
</html>
