<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	#name-item{
		width: 50%!important;
	}
	.arrow-top2{
	    content: "";
	    position: absolute;
	    top: -10%;
	    left: 10%;
	    transform: rotate(180deg);
	    margin-left: -5px;
	    border-width: 5px;
	    border-style: solid;
	    border-color: #e66513 transparent transparent transparent;
	}
</style>
<?php
	function dateDifference($date_1 , $date_2){
		$datetime2 = date_create($date_2);
		$datetime1 = date_create($date_1 );
		$interval = date_diff($datetime2, $datetime1);
		return $interval->format('%R%a');
	}
	$now = date('Y-m-d');
?>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"> Aging Report</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<br>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading" style="height:20px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						
						<div class="col-lg-12">
							<div class="col-lg-3">
								<form method = "POST">
									<select class="form-control animated rubberBand" onchange="get_age()" id = "age">
										<option value = "">--Select Range of Age--</option>
										<option value = "30">1-30</option>
										<option value = "60">31-60</option>
										<option value = "90">61-90</option>
										<option value = "120">91-120</option>
										<option value = "121">120+</option>
									</select>
								</form>
							</div>
						
							<div class="pull-right ">
								<!-- <a href="" class="btn btn-info">Export to Excel</a> -->
								<a href = "<?php echo base_url(); ?>index.php/reports/export_aging" class = "btn btn-info">Export to Excel</a>
							</div>
							<br>
							<hr>
							<br>
							<table class="table table-hover table-bordered" id="item_table" >
								<thead>
									<tr>
										<td>Count</td>
										<td>Item Name</td>
										<td>Supplier</td>
										<td>Brand</td>
										<td>Catalog</td>
										<td>Unit Cost</td>
										<td>Quantity</td>
										<td>Receive ID</td>
										<td>Receive Date</td>
										<td>1-30</td>
										<td>31-60</td>
										<td>61-90</td>
										<td>91-120</td>
										<td>120+</td>
										
									</tr>
								</thead>
								<tbody>

									 <?php 
									 	foreach($info AS $i){ 
									 	$diff = dateDifference($now,$i['receive_date']);
									 ?>
										<tr>
										<td><?php echo $i['count']; ?></td>
										<td><?php echo $i['item']; ?></td>
										<td><?php echo $i['supplier']; ?></td>
										<td><?php echo $i['brand']; ?></td>
										<td><?php echo $i['catalog_no']; ?></td>
										<td><?php echo $i['unit_cost']; ?></td>
										<td><?php echo $i['qty']; ?></td>
										<td><?php echo $i['receive_id']; ?></td>
										<td><?php echo $i['receive_date']; ?></td>
										<?php 
											if($diff >= 1 && $diff<=30){
										?>
											<td><?php echo number_format($i['unit_x'],2); ?></td>
										<?php } else { ?>
											<td></td>
										<?php } ?>
										<?php 
											if($diff >= 31 && $diff<=60){ 
										?>
											<td><?php echo number_format($i['unit_x'],2); ?></td>
										<?php } else { ?>
											<td></td>
										<?php } ?>
										<?php if($diff >= 61 && $diff <=90){ ?>
											<td><?php echo number_format($i['unit_x'],2); ?></td>
										<?php } else { ?>
											<td></td>
										<?php } ?>
										<?php if($diff >= 91 && $diff<=120){ ?>
											<td><?php echo number_format($i['unit_x'],2); ?></td>
										<?php } else { ?>
											<td></td>
										<?php } ?>
										<?php if($diff>120){ ?>
											<td><?php echo number_format($i['unit_x'],2); ?></td>
										<?php } else { ?>
											<td></td>
										<?php } ?>
										
									</tr>
									<?php } ?> 
								</tbody>
						</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
        function get_age(){
            var age = $('#age').val();
            var loc= document.getElementById("baseurl").value;
            window.location.href = loc+"index.php/reports/aging_report/"+age;
        }
    </script>