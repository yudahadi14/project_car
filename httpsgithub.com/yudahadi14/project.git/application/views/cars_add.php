<?php
    require_once "includes/header.php";
?>
<!-- Select2 -->
<link href="<?=base_url()?>assets/css/select2.min.css" rel="stylesheet">

<!-- Multiple File Upload -->
<!--Stylesheets-->
<link href="<?=base_url()?>assets/multiplefile_js/jquery.filer.css" type="text/css" rel="stylesheet" />
<link href="<?=base_url()?>assets/multiplefile_js/themes/jquery.filer-dragdropbox-theme.css" type="text/css" rel="stylesheet" />

<!--jQuery-->
<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/multiplefile_js/jquery.filer.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
			$('.file_input').filer({
            showThumbs: true,
            templates: {
                box: '<ul class="jFiler-item-list"></ul>',
                item: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <li><span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span></li>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                itemAppend: '<li class="jFiler-item">\
                            <div class="jFiler-item-container">\
                                <div class="jFiler-item-inner">\
                                    <div class="jFiler-item-thumb">\
                                        <div class="jFiler-item-status"></div>\
                                        <div class="jFiler-item-info">\
                                            <span class="jFiler-item-title"><b title="{{fi-name}}">{{fi-name | limitTo: 25}}</b></span>\
                                        </div>\
                                        {{fi-image}}\
                                    </div>\
                                    <div class="jFiler-item-assets jFiler-row">\
                                        <ul class="list-inline pull-left">\
                                            <span class="jFiler-item-others">{{fi-icon}} {{fi-size2}}</span>\
                                        </ul>\
                                        <ul class="list-inline pull-right">\
                                            <li><a class="icon-jfi-trash jFiler-item-trash-action"></a></li>\
                                        </ul>\
                                    </div>\
                                </div>\
                            </div>\
                        </li>',
                progressBar: '<div class="bar"></div>',
                itemAppendToEnd: true,
                removeConfirmation: true,
                _selectors: {
                    list: '.jFiler-item-list',
                    item: '.jFiler-item',
                    progressBar: '.bar',
                    remove: '.jFiler-item-trash-action',
                }
            },
            addMore: false

        });
	});
</script>
<style>
    .file_input{
        display: inline-block;
        padding: 10px 16px;
        outline: none;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        white-space: nowrap;
        font-family: sans-serif;
        font-size: 11px;
        font-weight: bold;
        border-radius: 3px;
        color: #008BFF;
        border: 1px solid #008BFF;
        vertical-align: middle;
        background-color: #fff;
        margin-bottom: 10px;
        box-shadow: 0px 1px 5px rgba(0,0,0,0.05);
        -webkit-transition: all 0.2s;
        -moz-transition: all 0.2s;
        transition: all 0.2s;
    }
    .file_input:hover,
    .file_input:active {
        background: #008BFF;
        color: #fff;
    }
</style>


<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Add New Car</h1>
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
					
					<form enctype="multipart/form-data" class="form-horizontal" action="<?=base_url()?>cars/insertCar" method="post" onsubmit="kk()">
						<fieldset>
							<div class="form-group">
								
								<label class="col-md-3 control-label" for="name">
									Nama Merchant <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="nama_merchant" class="form-control" required autocomplete="off" />
								</div>
								<div class="col-md-1"></div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="name">
									Alamat <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="alamat" class="form-control" required autocomplete="off" />
								</div>
								<div class="col-md-1"></div>
							</div>
							<div class="form-group">
							<label class="col-md-3 control-label" for="name">
									MIDTID <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="mid_tid" class="form-control" required autocomplete="off" />
								</div>
								<div class="col-md-1"></div>
							</div>
							<div class="form-group">

							<label class="col-md-3 control-label" for="name">
									No Telp Merchant <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="no_merchant" class="form-control" required autocomplete="off" />
								</div>
								<div class="col-md-1"></div>
							</div>
							<div class="form-group">
							<label class="col-md-3 control-label" for="email">
									PIC <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="pic" class="form-control" required autocomplete="off" />
								</div>
								<div class="col-md-1"></div>
							</div>
							<div class="form-group">
								<label class="col-md-3 control-label" for="email">
									Area <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<input type="text" name="area" class="form-control" required autocomplete="off" />
								</div>
								<div class="col-md-1"></div>
							</div>

						
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Car Make <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<select name="car_make" class="add_car_make form-control" required>
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
								
							
							
							
							<div class="form-group">
								<label class="col-md-3 control-label" for="email">
									Transmission <span class="required">*</span>
								</label>
								<div class="col-md-3">
									<select name="transmission" class="form-control" required>
										<option value="">Choose your car Transmission</option>
										<option value="1">Automatic</option>
										<option value="2">Manual</option>
									</select>
								</div>
								<div class="col-md-1"></div>
							</div>
							
							<div class="form-group">
								<label class="col-md-2 control-label" for="email">
									Car Photo
								</label>
								<div class="col-md-3">
									<a class="file_input" data-jfiler-name="files" data-jfiler-extensions="jpg, jpeg, png, gif"><i class="icon-jfi-paperclip"></i> Attach a file</a>
								</div>
								<label class="col-md-3 control-label" for="email">&nbsp;</label>
								<div class="col-md-3"></div>
								<div class="col-md-1"></div>
							</div>
							
							<div class="form-group">
								<div class="col-md-2"></div>
								<div class="col-md-7 widget-left" style="height: auto; padding-top: 0px;">
									
									<button type="submit" class="btn btn-primary btn-md pull-left" id="nextGo">&nbsp;&nbsp;&nbsp;Add&nbsp;&nbsp;&nbsp;</button>
									
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
			
			<a href="<?=base_url()?>cars/car_lists" style="text-decoration: none;">
				<button type="reset" class="btn btn-default" style="background-color: #747274; color: #FFF;">&nbsp;&nbsp;&nbsp;&nbsp;Back&nbsp;&nbsp;&nbsp;&nbsp;</button>
			</a>
		</div>
	</div>
	
</div>

<script src="<?=base_url()?>assets/js/select2.full.min.js"></script>
<!-- Select2 -->
<script>
	$(document).ready(function() {
		$(".add_car_owner").select2({
			placeholder: "Choose Your Car Owner",
			allowClear: true
		});
		
		$(".add_car_make").select2({
			placeholder: "Choose Your Car Make",
			allowClear: true
		});
		
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