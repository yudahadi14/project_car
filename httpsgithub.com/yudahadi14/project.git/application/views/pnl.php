<?php
    require_once "includes/header.php";
    
    $url_start                = "";
    $url_end                = "";
    $start_date            = "";
    $end_date                = "";
    if (isset($_GET["search"])) {
        $url_start            = $_GET["date_from"];
        $url_end            = $_GET["date_to"];
    }
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
	$(document).ready(function() {
	    //$('#example').DataTable();
	    
	    $("#date_from").datepicker({
		    minDate: 0,
		    format: '<?php echo $dateformat; ?>'
	    });
	    $("#date_to").datepicker({
		    minDate: 0,
		    format: '<?php echo $dateformat; ?>'
	    });
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Profit &amp; Loss</h1>
		</div>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-body">
					
					
					<form action="<?=base_url()?>profit_loss/pnl" method="get">
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label>Date From</label>
								<input class="form-control" name="date_from" required id="date_from" value="<?php echo $url_start; ?>" />
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label>Date To</label>
								<input class="form-control" name="date_to" required id="date_to" value="<?php echo $url_end; ?>" />
							</div>
						</div>
						<div class="col-md-2" style="padding-top: 5px;">
							<br />
							<input type="hidden" name="search" value="1" />
							<button type="submit" class="btn btn-primary">&nbsp;&nbsp;&nbsp;Get Report&nbsp;&nbsp;&nbsp;</button>
						</div>
						<div class="col-md-2" style="text-align: right; padding-top: 5px;">
							<br />
							<?php
                                if (isset($_GET["search"])) {
                                    ?>
									<a href="<?=base_url()?>profit_loss/exportPnL?date_from=<?php echo $url_start; ?>&date_to=<?php echo $url_end; ?>" style="text-decoration: none;" target="_blank">
										<button type="button" class="btn btn-primary" style="background-color: #8ad919; border: 1px solid #8ad919; padding: 7px 27px;">
											Export
										</button>
									</a>
							<?php

                                }
                            ?>
						</div>
					</div>
					</form>

<style type="text/css">
	.table_header {
		padding: 10px 10px;
		border-bottom: 1px solid #111;
		font-weight: bold;
	}
	.table_column {
		padding: 10px 10px;
		border-bottom: 1px solid #ddd;
	}
	.table_footer {
		padding: 10px 10px;
		border-top: 1px solid #111 !important;
		font-weight: bold;
	}
</style>
<?php
    if (isset($_GET["search"])) {
        if ($site_dateformat == 'd/m/Y') {
            $startArray    = explode('/', $url_start);
            $endArray        = explode('/', $url_end);

            $start_day        = $startArray[0];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[0];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd.m.Y') {
            $startArray    = explode('.', $url_start);
            $endArray        = explode('.', $url_end);

            $start_day        = $startArray[0];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[0];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'd-m-Y') {
            $startArray    = explode('-', $url_start);
            $endArray        = explode('-', $url_end);

            $start_day        = $startArray[0];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[0];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'm/d/Y') {
            $startArray    = explode('/', $url_start);
            $endArray        = explode('/', $url_end);

            $start_day        = $startArray[1];
            $start_mon        = $startArray[0];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[1];
            $end_mon        = $endArray[0];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm.d.Y') {
            $startArray    = explode('.', $url_start);
            $endArray        = explode('.', $url_end);

            $start_day        = $startArray[1];
            $start_mon        = $startArray[0];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[1];
            $end_mon        = $endArray[0];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'm-d-Y') {
            $startArray    = explode('-', $url_start);
            $endArray        = explode('-', $url_end);

            $start_day        = $startArray[1];
            $start_mon        = $startArray[0];
            $start_yea        = $startArray[2];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[1];
            $end_mon        = $endArray[0];
            $end_yea        = $endArray[2];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }

        if ($site_dateformat == 'Y.m.d') {
            $startArray    = explode('.', $url_start);
            $endArray        = explode('.', $url_end);

            $start_day        = $startArray[2];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[0];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[2];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[0];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y/m/d') {
            $startArray    = explode('/', $url_start);
            $endArray        = explode('/', $url_end);

            $start_day        = $startArray[2];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[0];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[2];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[0];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        if ($site_dateformat == 'Y-m-d') {
            $startArray    = explode('-', $url_start);
            $endArray        = explode('-', $url_end);

            $start_day        = $startArray[2];
            $start_mon        = $startArray[1];
            $start_yea        = $startArray[0];

            $url_start        = $start_yea.'-'.$start_mon.'-'.$start_day;

            $end_day        = $endArray[2];
            $end_mon        = $endArray[1];
            $end_yea        = $endArray[0];

            $url_end        = $end_yea.'-'.$end_mon.'-'.$end_day;
        }
        
        $url_start            = date('Y-m-d', strtotime($url_start));
        $url_end            = date('Y-m-d', strtotime($url_end));

        $start_date        = $url_start.' 00:00:00';
        $end_date            = $url_end.' 23:59:59'; ?>
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table border="0" style="border-collapse: collapse; width: 100%;">
									<tr>
										<td class="table_header" width="7%">Job Id</td>
										<td class="table_header" width="12%">Invoice Numb.</td>
										<td class="table_header" width="15%">Date & Time</td>
										<td class="table_header" width="15%">Customer</td>
										<td class="table_header" width="12%">Plate Number</td>
										<td class="table_header" width="12%">Grand Total</td>
										<td class="table_header" width="12%">Cost Total</td>
										<td class="table_header" width="12%">Profit Total</td>
									</tr>
<?php
    $all_total_grand_amt        = 0;
        $all_total_cost_amt        = 0;
        $all_total_profit_amt        = 0;
    
        $serviceResult        = $this->db->query("SELECT * FROM service_jobs WHERE status = '7' AND vt_Status = '1' AND invoice_datetime >= '$start_date' AND invoice_datetime <= '$end_date' ORDER BY invoice_datetime DESC ");
        $serviceRows        = $serviceResult->num_rows();
        if ($serviceRows > 0) {
            $serviceData    = $serviceResult->result();
            for ($s = 0; $s < count($serviceData); $s++) {
                $job_id        = $serviceData[$s]->id;
                $invoice_numb    = $serviceData[$s]->invoice_number;
                $invoice_dtm    = date("$site_dateformat h:i A", strtotime($serviceData[$s]->invoice_datetime));
                $cust_fn        = $serviceData[$s]->firstname;
                $cust_ln        = $serviceData[$s]->lastname;
                $plate_numb    = $serviceData[$s]->car_plate_number;
                $grandTotal    = $serviceData[$s]->grandtotal_amt;
            
                $total_spm_cost        = 0;
                $serPackMatResult        = $this->db->query("SELECT * FROM service_job_package_material WHERE service_job_id = '$job_id' AND request_approved = '1' AND status = '1' ");
                $serPackMatData        = $serPackMatResult->result();
                for ($spm = 0; $spm < count($serPackMatData); $spm++) {
                    $spm_issued_qty    = $serPackMatData[$spm]->issued_qty;
                    $spm_each_cost        = $serPackMatData[$spm]->cost;
                
                    $total_spm_cost    += ($spm_issued_qty * $spm_each_cost);
                
                    unset($spm_issued_qty);
                    unset($spm_each_cost);
                }
                unset($serPackMatResult);
                unset($serPackMatData);
            
                $total_defect_mat_cost    = 0;
                $defectMatResult        = $this->db->query("SELECT * FROM service_job_defects_material WHERE service_job_id = '$job_id' AND customer_approved = '1' AND status = '1' ");
                $defectMatData            = $defectMatResult->result();
                for ($dfm = 0; $dfm < count($defectMatData); $dfm++) {
                    $dfm_issued_qty    = $defectMatData[$dfm]->issued_qty;
                    $dfm_each_cost        = $defectMatData[$dfm]->cost;
                
                    $total_defect_mat_cost        += ($dfm_issued_qty * $dfm_each_cost);
                
                    unset($dfm_issued_qty);
                    unset($dfm_each_cost);
                }
                unset($defectMatResult);
                unset($defectMatData);
            
                $total_cost        = 0;
                $total_cost        = $total_spm_cost + $total_defect_mat_cost;
            
                $each_row_profit    = 0;
                $each_row_profit    = $grandTotal - $total_cost;
            
            
                $all_total_cost_amt    += $total_cost;
                $all_total_grand_amt    += $grandTotal;
                $all_total_profit_amt    += $each_row_profit; ?>
			<tr>
				<td class="table_column"><?php echo $job_id; ?></td>
				<td class="table_column"><?php echo $invoice_numb; ?></td>
				<td class="table_column"><?php echo $invoice_dtm; ?></td>
				<td class="table_column"><?php echo $cust_fn." ".$cust_ln; ?></td>
				<td class="table_column"><?php echo $plate_numb; ?></td>
				<td class="table_column">$<?php echo number_format($grandTotal, 2); ?></td>
				<td class="table_column">$<?php echo number_format($total_cost, 2); ?></td>
				<td class="table_column">$<?php echo number_format($each_row_profit, 2); ?></td>
			</tr>
<?php
            unset($job_id);
                unset($invoice_numb);
                unset($invoice_dtm);
                unset($cust_fn);
                unset($cust_ln);
                unset($plate_numb);
                unset($grandTotal);
            }
            unset($serviceData); ?>
			<tr>
				<td colspan="8"></td>
			</tr>
			<tr>
				<td class="table_footer" colspan="5" align="center">Total</td>
				<td class="table_footer">$<?php echo number_format($all_total_grand_amt, 2); ?></td>
				<td class="table_footer">$<?php echo number_format($all_total_cost_amt, 2); ?></td>
				<td class="table_footer">$<?php echo number_format($all_total_profit_amt, 2); ?></td>
			</tr>
<?php

        } else {
            ?>
			<tr>
				<td colspan="8" class="table_header" align="center">No match record found!</td>
			</tr>
<?php

        }
        unset($serviceResult);
        unset($serviceRows); ?>
									
								</table>
							</div>
						</div>
					</div>
<?php

    }
?>
					
				</div><!-- Panel Body // END -->
			</div>
		</div>
	</div>
</div>

<?php
    require_once "includes/footer.php";
?>