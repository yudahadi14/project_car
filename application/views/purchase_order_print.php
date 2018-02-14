<?php
    $settingResult        = $this->db->get_where('site_setting');
    $settingData        = $settingResult->row();
    $setting_dateformat = $settingData->datetime_format;
    
    $site_name            = $settingData->site_name;
    $site_address        = $settingData->address;
    $site_tel            = $settingData->telephone;
    $site_fax            = $settingData->fax;

    $poDtaData            = $this->Constant_model->getDataOneColumn('purchase_order', 'id', $po_id);
    if (count($poDtaData) == 0) {
        redirect(base_url().'purchase_order/po_view', 'refresh');
    }

    $po_numb            = $poDtaData[0]->po_number;
    $po_supplier_id    = $poDtaData[0]->supplier_id;
    $po_date            = date("$setting_dateformat", strtotime($poDtaData[0]->po_date));
    $po_note            = $poDtaData[0]->note;
    $po_status            = $poDtaData[0]->status;
    $supplier_name        = $poDtaData[0]->supplier_name;
    $supplier_address    = $poDtaData[0]->supplier_address;
    $supplier_email    = $poDtaData[0]->supplier_email;
    $supplier_tel        = $poDtaData[0]->supplier_tel;
    $supplier_fax        = $poDtaData[0]->supplier_fax;
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Print Purchase Order</title>
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
		#wrapper img { max-width:300px; width: 80%; }
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
				<h1 style="font-size: 40px; color: #005b8a;">Purchase Order</h1>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 10px; border-bottom: 1px solid #656563; padding-bottom: 10px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="30%" style="font-size: 15px;" align="left">Supplier</td>
						<td width="70%" style="font-size: 15px;" align="left">: <?php echo $supplier_name; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Address</td>
						<td width="70%" align="left">: <?php echo $supplier_address; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Email</td>
						<td width="70%" align="left">: <?php echo $supplier_email; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Telephone</td>
						<td width="70%" align="left">: <?php echo $supplier_tel; ?></td>
					</tr>
					<tr>
						<td width="30%" height="20px" align="left">Fax</td>
						<td width="70%" align="left">: <?php echo $supplier_fax; ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" height="auto" align="right" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="60%" height="20px" align="right" style="font-size: 15px; color: #005b8a;">
							Purchase Order Number&nbsp;&nbsp;
						</td>
						<td width="40%" style="font-size: 15px; color: #005b8a;">: &nbsp;<?php echo $po_numb; ?></td>
					</tr>
					<tr>
						<td width="60%" height="20px" align="right" style="font-size: 15px; color: #005b8a;">
							Purchase Order Date&nbsp;&nbsp;
						</td>
						<td width="40%" style="font-size: 15px; color: #005b8a;">: &nbsp;<?php echo $po_date; ?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 11px; margin-top: -5px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left">
				<h1 style="font-size: 15px; color: #005b8a;">Ship To</h1>
			</td>
		</tr>
	</table>
	<table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 0px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" valign="top">
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="40%" height="20px" align="left">Name</td>
						<td width="60%" align="left">: <?php echo $site_name; ?></td>
					</tr>
					<tr>
						<td width="40%" height="20px" align="left" valign="top">Address</td>
						<td width="60%" align="left">: <?php echo $site_address; ?></td>
					</tr>
					<tr>
						<td width="40%" height="20px" align="left">Telephone</td>
						<td width="60%" align="left">: <?php echo $site_tel; ?></td>
					</tr>
				</table>
			</td>
			<td width="50%" height="auto" align="right" valign="top">&nbsp;</td>
		</tr>
	</table>
    <table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 20px;" width="100%" height="auto">
		<tr>
			<td width="40%" height="25px" style="padding-left: 10px; font-weight: bold; border-bottom: 1px solid #656563;" align="left">
				SKU
			</td>
			<td width="40%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">
				Material Name
			</td>
			<td width="20%" height="25px" style="font-weight: bold; border-bottom: 1px solid #656563;" align="left">
				Ordered Qty.
			</td>
		</tr>
	<?php
        $poItemData        = $this->Constant_model->getDataOneColumnSortColumn('purchase_order_items', 'purchase_order_id', $po_id, 'id', 'ASC');
        for ($pi = 0; $pi < count($poItemData); ++$pi) {
            $po_item_id    = $poItemData[$pi]->id;
            $po_item_sku    = $poItemData[$pi]->material_sku;
            $po_item_qty    = $poItemData[$pi]->ordered_qty;

            $poNameResult    = $this->db->query("SELECT * FROM materials WHERE sku = '$po_item_sku' ");
            $poNameData    = $poNameResult->result();

            $mat_name        = $poNameData[0]->name; ?>
			<tr>
				<td height="25px" style="padding-left: 10px; border-bottom: 1px solid #656563;" align="left"><?php echo $po_item_sku; ?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?php echo $mat_name; ?></td>
				<td style="border-bottom: 1px solid #656563;" align="left"><?php echo $po_item_qty; ?></td>
			</tr>
	<?php	
        }
    ?>
    </table>
    
    <table border="0" style="border-collapse: collapse; font-family: arial; font-size: 13px; margin-top: 30px;" width="100%" height="auto">
		<tr>
			<td width="50%" height="auto" align="left" valign="top">
			
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="20%" valign="top" align="left"><b>Note</b> :</td>
						<td width="80%" align="left"><?php echo nl2br($po_note); ?></td>
					</tr>
				</table>
			
			</td>
			<td width="50%" height="auto" align="right" valign="top">
				
				<table border="0" style="border-collapse: collapse;" width="100%" height="auto">
					<tr>
						<td width="40%" align="right"><b>Authorized By</b></td>
						<td width="60%" style="border-bottom: 1px solid #656563"></td>
					</tr>
					<tr>
						<td colspan="2" height="30px"></td>
					</tr>
					<tr>
						<td width="40%" align="right"><b>Signature</b></td>
						<td width="60%" style="border-bottom: 1px solid #656563"></td>
					</tr>
				</table>
				
			</td>
		</tr>
	</table>
</div>

<script src="<?=base_url()?>assets/js/jquery-1.10.2.js"></script>
<script type="text/javascript">
	$(window).load(function() { window.print(); });
</script>
</body>
</html>
