<?php
    $serviceDtaData        = $this->Constant_model->getDataOneColumn("service_jobs", "id", $job_id);
    
    $cust_fn                = $serviceDtaData[0]->firstname;
    $cust_ln                = $serviceDtaData[0]->lastname;
    $cust_em                = $serviceDtaData[0]->email;
    $cust_mb                = $serviceDtaData[0]->mobile;
    $car_id                = $serviceDtaData[0]->car_id;
    $car_plate_numb        = $serviceDtaData[0]->car_plate_number;
    $car_mileage            = $serviceDtaData[0]->mileage_after;
    $service_advisor_id    = $serviceDtaData[0]->service_advisor_id;
    $service_tech_id        = $serviceDtaData[0]->technician_id;
    $service_date            = date("$dateformat", strtotime($serviceDtaData[0]->created_datetime));
    
    $advisor_fullname        = "";
    $advisorDtaData        = $this->Constant_model->getDataOneColumn("users", "id", $service_advisor_id);
    $advisor_fullname        = $advisorDtaData[0]->fullname;
    
    $technician_name        = "";
    $techDtaData            = $this->Constant_model->getDataOneColumn("users", "id", $service_tech_id);
    $technician_name        = $techDtaData[0]->fullname;
    
    
    $siteDtaResult            = $this->db->get_where('site_setting');
    $siteDtaData            = $siteDtaResult->row();
    
    $siteDta_name            = $siteDtaData->site_name;
    $siteDta_address        = $siteDtaData->address;
    $siteDta_tel            = $siteDtaData->telephone;
    $siteDta_fax            = $siteDtaData->fax;
    $siteData_logo            = $siteDtaData->site_logo;
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Print Service Confirmation</title>
		<script src="<?=base_url()?>assets/js/jquery-1.7.2.min.js"></script>
		
<style type="text/css" media="all">
	body { 
		max-width: 950px; 
		margin:0 auto; 
		text-align:center; 
		color:#000; 
		font-family: Arial, Helvetica, sans-serif; 
		font-size:12px; 
	}
	#wrapper { 
		min-width: 950px; 
		margin: 0px auto; 
	}
	#wrapper img { 
		max-width: 300px; 
		width: auto; 
	}

	h2, h3, p { 
		margin: 5px 0;
	}
	.left { 
		width:100%; 
		float:left; 
		text-align:left; 
		margin-bottom: 3px;
		margin-top: 3px;
	}
	.right { 
		width:40%; 
		float:right; 
		text-align:right; 
		margin-bottom: 3px; 
	}
	.table, .totals { 
		width: 100%; 
		margin:10px 0; 
	}
	.table th { 
		border-top: 1px solid #000; 
		border-bottom: 1px solid #000; 
		padding-top: 4px;
		padding-bottom: 4px;
	}
	.table td { 
		padding:0; 
	}
	.totals td { 
		width: 24%; 
		padding:0; 
	}
	.table td:nth-child(2) { 
		overflow:hidden; 
	}

	@media print {
		body { text-transform: uppercase; }
		#buttons { display: none; }
		#wrapper { width: 100%; margin: 0; font-size:9px; }
		#bkpos_wrp{
			display: none;
		}
	}
</style>
</head>

<body>
<div id="wrapper">
    
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px;" width="100%" height="auto">
		<tr>
			<td width="100%" height="auto" align="center">
				<h1 style="font-size: 40px; color: #005b8a;">Service Confirmation</h1>
			</td>
		</tr>
	</table>
	
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 10px; border-top: 0px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="100%" align="left">
							<img src="<?=base_url()?>assets/images/logo/<?php echo $siteData_logo; ?>" />
						</td>
					</tr>
					<tr>
						<td width="100%" align="left" style="font-size: 18px;" style="padding-top: 3px; padding-bottom: 3px;"><?php echo $siteDta_name; ?></td>
					</tr>
					<?php
                        if (!empty($siteDta_address)) {
                            ?>
							<tr>
								<td width="100%" align="left" style="padding-top: 3px; padding-bottom: 3px; line-height: 20px;">
									<?php echo nl2br($siteDta_address); ?>
								</td>
							</tr>
					<?php	
                        }
                        
                        if (!empty($siteDta_tel)) {
                            ?>
							<tr>
								<td width="100%" align="left" style="padding-top: 3px; padding-bottom: 3px;">Tel : <?php echo $siteDta_tel; ?></td>
							</tr>
					<?php

                        }
                        if (!empty($siteDta_fax)) {
                            ?>
							<tr>
								<td width="100%" align="left" style="padding-top: 3px; padding-bottom: 3px;">Fax : <?php echo $siteDta_fax; ?></td>
							</tr>
					<?php

                        }
                    ?>
				</table>
			</td>
			<td width="10%" height="auto" align="right" valign="top"></td>
			<td width="40%" height="auto" align="right" valign="top">
				<table border="0" style="border-collapse: collapse; margin-top: 50px;" width="100%" height="auto">
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Service Job Id :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;#<?php echo $job_id; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Service Date :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $service_date; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Plate Number :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $car_plate_numb; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Current Mileage :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $car_mileage; ?> KM</td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Customer Name :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $cust_fn." ".$cust_ln; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Customer Mobile :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $cust_mb; ?></td>
					</tr>
					<tr>
						<td width="60%" style="padding-top: 3px; padding-bottom: 3px; text-align: right;">Technician Name :</td>
						<td width="40%" style="padding-top: 3px; padding-bottom: 3px;">&nbsp;&nbsp;&nbsp;<?php echo $technician_name; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	
	<?php
        $total_package_price= 0;
        
        $serpackResult        = $this->db->query("SELECT * FROM service_job_packages WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $serpackRows        = $serpackResult->num_rows();
        if ($serpackRows > 0) {
            ?>
			<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 10px; border-top: 0px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
				<tr>
					<td colspan="2" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 5px;" align="left">
						<label>Service Package</label>
					</td>
				</tr>
				<tr>
		            <th width="80%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-weight: bold; padding-left: 10px;" align="left"><span>Package Name</span></th>
			    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-weight: bold;" align="left"><span>Package Price</span></th>
				</tr>
				<?php
                    $serpackData    = $serpackResult->result();
            for ($sp = 0; $sp < count($serpackData); $sp++) {
                $serpack_name        = $serpackData[$sp]->package_name;
                $serpack_price        = $serpackData[$sp]->package_price; ?>
						<tr>
							<td style="padding-left: 10px; border-bottom: 1px solid #ddd;" height="35px" align="left"><?php echo $serpack_name; ?></td>
							<td align="left" style="border-bottom: 1px solid #ddd"><?php echo "$".number_format($serpack_price, 2); ?></td>
						</tr>
				<?php
                        $total_package_price    += $serpack_price;
                    
                unset($serpack_name);
                unset($serpack_price);
            }
            unset($serpackData); ?>
			</table>		
	<?php

        }
        unset($serpackResult);
        unset($serpackRows);
    ?>
	
	
	<?php
        $defectResult        = $this->db->query("SELECT * FROM service_job_defects WHERE service_job_id = '$job_id' ORDER BY id DESC ");
        $defectRows        = $defectResult->num_rows();
        if ($defectRows > 0) {
            ?>
			<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 20px; border-top: 0px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
				<tr>
					<td colspan="2" width="100%" style="border-top: 0px; padding-left: 0px; font-size: 18px; padding-bottom: 5px;" align="left">
						<label>Reported Defects</label>
					</td>
				</tr>
				<tr>
		            <th width="80%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-weight: bold; padding-left: 10px;" align="left"><span>Name</span></th>
			    	<th width="20%" style="border-top: 1px solid #ddd !important; border-bottom: 1px solid #ddd; height: 35px; border-top: 0px; color: #000; font-weight: bold;" align="left"><span>Remarks</span></th>
				</tr>
				<?php
                    $defectData    = $defectResult->result();
            for ($df = 0; $df < count($defectData); $df++) {
                $defect_name        = $defectData[$df]->defect_name;
                $defect_remark        = $defectData[$df]->remarks; ?>
						<tr>
							<td style="padding-left: 10px; border-bottom: 1px solid #ddd;" height="35px" align="left"><?php echo $defect_name; ?></td>
							<td align="left" style="border-bottom: 1px solid #ddd"><?php echo $defect_remark; ?></td>
						</tr>
				<?php
                        unset($defect_name);
                unset($defect_remark);
            }
            unset($defectData); ?>
			</table>
	<?php

        }
        unset($defectResult);
        unset($defectRows);
    ?>
</div>

<script src="<?=base_url()?>assets/js/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(window).load(function() { window.print(); });
</script>
</body>
</html>
