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
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php echo $setting_site_name; ?></title>

		<link href="<?=base_url()?>assets/css/bootstrap.min.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/datepicker3.css" rel="stylesheet">
		<link href="<?=base_url()?>assets/css/styles.css" rel="stylesheet">
		
		<!--[if lt IE 9]>
		<script src="<?=base_url()?>assets/js/html5shiv.js"></script>
		<script src="<?=base_url()?>assets/js/respond.min.js"></script>
		<![endif]-->

	</head>

<body>

	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="row">
					<div class="col-lg-12">
						<h1 class="page-header" style="text-align: center;"><?php echo $setting_site_name; ?></h1>
					</div>
				</div>
				<div class="panel-heading" style="text-align: center; font-size: 22px;">Account Access</div>
				<div class="panel-body">
					
					<form action="<?=base_url()?>auth/login" method="post">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail Address" name="email" type="email" required autofocus autocomplete="off" />
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="password" type="password" required autocomplete="off" />
							</div>
							<input type="submit" value="Login" class="btn btn-primary" name="sp_login" style="padding: 6px 25px;" />
							
							<?php
                                if (!empty($alert_msg)) {
                                    $flash_status = $alert_msg[0];
                                    $flash_header = $alert_msg[1];
                                    $flash_desc = $alert_msg[2];

                                    if ($flash_status == 'failure') {
                                        ?>
							<div class="form-group" style="text-align: center; color: #c72a25; margin-top: 15px;">
								<?php echo $flash_desc; ?>
							</div>
							<?php

                                    }
                                }
                            ?>
                            
						</fieldset>
					</form>
					
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	
		

	<script src="<?=base_url()?>assets/js/jquery-1.11.1.min.js"></script>
	<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
</body>

</html>
