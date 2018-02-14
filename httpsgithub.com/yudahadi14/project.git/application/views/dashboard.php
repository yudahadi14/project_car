<?php
    require_once "includes/header.php";
?>
<style type="text/css">
	.highcharts-container {
	    width:100% !important;
	    height:100% !important;
	}
</style>

<?php
    // Today;
    $cur_today_year        = date("Y", time());
    $cur_today_month        = date("m", time());
    $cur_today_date        = date("d", time());
    
    $iTimestamp = mktime(0, 0, 0, $cur_today_month, $cur_today_date, $cur_today_year);
    
    for ($i = 1; $i < 25; $i++) {
        $todayArray[]        = date('H:i:s', $iTimestamp);
        $iTimestamp        += 3600;
    }
    
    // Daily;
    for ($d = 0; $d < 7; $d++) {
        $date    = new DateTime("$d days ago");
        
        $dailyArray[]        = $date->format('Y-m-d');
    }
    
    // Weekly;
    $w = 0;
    while ($w <= 4) {
        $week_number    = date('W', strtotime("-$w week")); //1 week ago
    
        $weeklyArray[]    = $week_number;
        $weeklyStart[]    = getWeekStartDates("$cur_today_year", "$week_number");
        $weeklyEnd[]    = getWeekEndDates("$cur_today_year", $week_number);
        
        $w++;
    }
    
    function getWeekStartDates($year, $week, $start=true)
    {
        $from    = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
        $to    = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
     
        return $from;
    }
    
    function getWeekEndDates($year, $week, $start=true)
    {
        $from    = date("Y-m-d", strtotime("{$year}-W{$week}-1")); //Returns the date of monday in week
        $to    = date("Y-m-d", strtotime("{$year}-W{$week}-7"));   //Returns the date of sunday in week
     
        return $to;
    }
    
    
    // Monthly;
    for ($i = 0; $i < 12; $i++) {
        $months[] = date("Y-m", strtotime(date('Y-m-01')." -$i months"));
    }
    
    $month_name_array    = array();
    $year_name_array    = array();
    for ($m = 0; $m < count($months); $m++) {
        $year            = date("Y", strtotime($months[$m]));
        $mon            = date("m", strtotime($months[$m]));
        $month_name    = date("M", strtotime($months[$m]));
        
        array_push($month_name_array, $month_name);
        array_push($year_name_array, $year);
    }
    
    
    
    $categoryArray    = array("1");        // 1 : Service Sales;
?>

<script type="text/javascript" src="<?base_url()?>assets/js/charts/highcharts.js"></script>
<script type="text/javascript" src="<?base_url()?>assets/js/charts/exporting.js"></script>
<script type="text/javascript">
	//$(function(){
	$(document).ready(function(){	
		// Today Services -- START;
		$('#todayServices').highcharts({
			title: {
	            text: 'Today Services Amount',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '',
	            x: -20
	        },
	        xAxis: {
	            categories: [
		            <?php
                        for ($tds = 0; $tds < count($todayArray); $tds++) {
                            echo "'".$todayArray[$tds]."',";
                        }
                    ?>
	            ],
	            
	        },
	        yAxis: {
	            title: {
	                text: 'Amount (<?php echo $currency; ?>)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: ''
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	       	series: [
			<?php
                for ($o = 0; $o < count($categoryArray); $o++) {
                    $array_value        = $categoryArray[$o];
            
                    $array_name        = "";
                    if ($array_value == "1") {
                        $array_name    = "Amount";
                    } ?>
	        {
	            name: '<?php echo $array_name; ?>',
	            data: [
		           <?php
                        for ($tds = 0; $tds < count($todayArray); $tds++) {
                            $tds_start            = $todayArray[$tds];
                            $tds_startArray    = explode(":", $tds_start);
                            $tds_end            = $tds_startArray[0].":59:59";
                            
                            $full_tds_start    = $cur_today_year."-".$cur_today_month."-".$cur_today_date." ".$tds_start;
                            $full_tds_end        = $cur_today_year."-".$cur_today_month."-".$cur_today_date." ".$tds_end;
                            
                            $each_row_amt        = 0;
                            
                            $serPayResult    = $this->db->query("SELECT payment_amount FROM service_job_payments WHERE created_datetime >= '$full_tds_start' AND created_datetime <= '$full_tds_end' ");
                            $serPayData    = $serPayResult->result();
                            for ($sp = 0; $sp < count($serPayData); $sp++) {
                                $each_row_amt    += $serPayData[0]->payment_amount;
                            }
                            unset($serPayResult);
                            unset($serPayData);
                            
                            echo $each_row_amt.",";
                        } ?>
	            ]
	        },
	        <?php 
                }
            ?>
	        ] 
		});
		// Today Services -- END;
		
		var height= $("#todayServices").height();
		var width= $("#todayServices").width();
		
		// Daily Services -- START;
		$('#dailyServices').highcharts({
			chart: {
				backgroundColor: 'white',
				width: width,
        	},
			title: {
	            text: 'Daily Services Amount',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '',
	            x: -20
	        },
	        xAxis: {
	            categories: [
		            <?php
                        for ($dls = 0; $dls < count($dailyArray); $dls++) {
                            echo "'".$dailyArray[$dls]."',";
                        }
                    ?>
	            ]
	        },
	        yAxis: {
	            title: {
	                text: 'Amount (<?php echo $currency; ?>)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: ''
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [
	        <?php
                  for ($o = 0; $o < count($categoryArray); $o++) {
                      $array_value        = $categoryArray[$o];
            
                      $array_name        = "";
                      if ($array_value == "1") {
                          $array_name    = "Amount";
                      } ?>
			{
				name: '<?php echo $array_name; ?>',
	            data: [
		            <?php
                          for ($dlr = 0; $dlr < count($dailyArray); $dlr++) {
                              $daily_date    = $dailyArray[$dlr];
                            
                              $daily_start    = $daily_date." 00:00:00";
                              $daily_end        = $daily_date." 23:59:59";
                            
                              $each_total_daily_amt    = 0;
                            
                              $serPayResult    = $this->db->query("SELECT payment_amount FROM service_job_payments WHERE created_datetime >= '$daily_start' AND created_datetime <= '$daily_end' ");
                              $serPayData    = $serPayResult->result();
                              for ($sp = 0; $sp < count($serPayData); $sp++) {
                                  $each_total_daily_amt    += $serPayData[$sp]->payment_amount;
                              }
                              unset($serPayResult);
                              unset($serPayData);
                            
                              echo $each_total_daily_amt.", ";
                          } ?>
	            ]
			},
			<?php

                  }
            ?>
	        ]
	    });
		// Daily Services -- END;
		
		
		
		// Weekly Services -- START;
		$('#weeklyServices').highcharts({
	        chart: {
				backgroundColor: 'white',
				width: width,
        	},
	        title: {
	            text: 'Weekly Services Amount',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '',
	            x: -20
	        },
	        xAxis: {
	            categories: [
		            <?php
                        for ($wls = 0; $wls < count($weeklyArray); $wls++) {
                            echo "'".$weeklyEnd[$wls]." to ".$weeklyStart[$wls]."',";
                        }
                    ?>
	            ]
	        },
	        yAxis: {
	            title: {
	                text: 'Amount (<?php echo $currency; ?>)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: ''
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [
			<?php
                  for ($o = 0; $o < count($categoryArray); $o++) {
                      $array_value        = $categoryArray[$o];
            
                      $array_name        = "";
                      if ($array_value == "1") {
                          $array_name    = "Amount";
                      } ?>
			{
				name: '<?php echo $array_name; ?>',
	            data: [
		            <?php
                        for ($wlr = 0; $wlr < count($weeklyArray); $wlr++) {
                            $weekly_start    = $weeklyStart[$wlr]." 00:00:00";
                            $weekly_end    = $weeklyEnd[$wlr]." 23:59:59";
                            
                            $each_total_weekly_amt    = 0;
                            
                            $weekSerPayResult    = $this->db->query("SELECT payment_amount FROM service_job_payments WHERE created_datetime >= '$weekly_start' AND created_datetime <= '$weekly_end' ");
                            $weekSerPayData    = $weekSerPayResult->result();
                            for ($wp = 0; $wp < count($weekSerPayData); $wp++) {
                                $each_total_weekly_amt    += $weekSerPayData[$wp]->payment_amount;
                            }
                            unset($weekSerPayResult);
                            unset($weekSerPayData);
                            
                            echo $each_total_weekly_amt.", ";
                        } ?>
	            ]
	        },
	        <?php

                  }
            ?>
	        ]
	    });
		// Weekly Services -- END;
		
		
		// Monthly Services -- START;
	    $('#monthlyServices').highcharts({
	        chart: {
				backgroundColor: 'white',
				width: width,
        	},
	        title: {
	            text: 'Monthly Services Amount',
	            x: -20 //center
	        },
	        subtitle: {
	            text: '',
	            x: -20
	        },
	        xAxis: {
	            categories: [
		            <?php
                          for ($mn = 0; $mn < count($month_name_array); $mn++) {
                              echo "'".$month_name_array[$mn]." ".$year_name_array[$mn]."',";
                          }
                    ?>
	            ]
	        },
	        yAxis: {
	            title: {
	                text: 'Amount (<?php echo $currency; ?>)'
	            },
	            plotLines: [{
	                value: 0,
	                width: 1,
	                color: '#808080'
	            }]
	        },
	        tooltip: {
	            valueSuffix: ''
	        },
	        legend: {
	            layout: 'vertical',
	            align: 'right',
	            verticalAlign: 'middle',
	            borderWidth: 0
	        },
	        series: [
			<?php
                  for ($o = 0; $o < count($categoryArray); $o++) {
                      $array_value        = $categoryArray[$o];
            
                      $array_name        = "";
                      if ($array_value == "1") {
                          $array_name    = "Amount";
                      } ?>
			{
				name: '<?php echo $array_name; ?>',
	            data: [
		            <?php
                          for ($m = 0; $m < count($months); $m++) {
                              $year            = date("Y", strtotime($months[$m]));
                              $mon            = date("m", strtotime($months[$m]));
                            
                              $number_of_day    = cal_days_in_month(CAL_GREGORIAN, $mon, $year);
                            
                              $each_total_month_amt    = 0;
                            
                              for ($d = 1; $d <= $number_of_day; $d++) {
                                  if (strlen($d) == 1) {
                                      $d    = "0".$d;
                                  }
                                
                                  $full_date_start    = $year."-".$mon."-".$d." 00:00:00";
                                  $full_date_end        = $year."-".$mon."-".$d." 23:59:59";
                                
                                  $monSerPayResult    = $this->db->query("SELECT payment_amount FROM service_job_payments WHERE created_datetime >= '$full_date_start' AND created_datetime <= '$full_date_end' ");
                                  $monSerPayData        = $monSerPayResult->result();
                                  for ($mp = 0; $mp < count($monSerPayData); $mp++) {
                                      $each_total_month_amt    += $monSerPayData[$mp]->payment_amount;
                                  }
                                  unset($monSerPayResult);
                                  unset($monSerPayData);
                              }
                              echo $each_total_month_amt.", ";
                          } ?>
	            ]
	        },
	        <?php

                  }
            ?>
	        ]
	    });
	    // Monthly Services -- END;
		
		
	});
</script>

<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Dashboard</h1>
		</div>
	</div><!--/.row-->

<script type="text/javascript">
	$(document).on("pageshow", "#monthlyServices", function() {
		alert("A");
	});
</script>
	
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">				
				<div class="panel-heading">
					Dashboard
				</div>
				<div class="panel-body" style="padding: 25px;">
					
					<div class="panel panel-default">
						<div class="panel-body tabs">
						
							<ul class="nav nav-pills" style="padding: 0px;">
								<li class="active"><a href="#pilltab1" data-toggle="tab">Today Services Amount</a></li>
								<li><a href="#pilltab2" data-toggle="tab">Daily Services Amount</a></li>
								<li><a href="#pilltab3" data-toggle="tab">Weekly Services Amount</a></li>
								<li><a href="#pilltab4" data-toggle="tab">Monthly Services Amount</a></li>
							</ul>
			
							<div class="tab-content">
								<div class="tab-pane fade in active" id="pilltab1">
									<div id="todayServices" style="width: 100%; overflow:auto; margin: 0 auto"></div>
								</div>
								<div class="tab-pane fade" id="pilltab2" >
									<div id="dailyServices"></div>
								</div>
								<div class="tab-pane fade" id="pilltab3">
									<div id="weeklyServices" style="margin: 0 auto"></div>
								</div>
								<div class="tab-pane fade" id="pilltab4">
									<div id="monthlyServices" style="margin: 0 auto"></div>
								</div>
								
							</div><!-- tab content // END -->
						</div>
					</div><!--/.panel-->
					
				</div><!-- panel body // END -->
			</div>
		</div>
	</div>
	
</div><!--/.main-->

<?php
    require_once "includes/footer.php";
?>