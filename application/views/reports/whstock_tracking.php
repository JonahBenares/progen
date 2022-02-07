<?php 
if(!empty($stockcard)){
	foreach ($stockcard as $key => $row) {
	    $date[$key]  = $row['date'];
	    $series[$key] = $row['series'];
	    $cdate[$key] = $row['create_date'];
	}

	array_multisort(array_map('strtotime',array_column($stockcard,'create_date')),SORT_ASC, $stockcard);
	//array_multisort($date, SORT_ASC,  $cdate, SORT_ASC, $stockcard);

	foreach ($balance as $key => $rows) {
	    $dates[$key]  = $rows['date'];
	    $series[$key] = $rows['series'];
	    $cdates[$key] = $rows['create_date'];
	}

	array_multisort(array_map('strtotime',array_column($balance,'create_date')),SORT_ASC, $balance);
	//array_multisort($dates, SORT_ASC, $cdates, SORT_ASC, $balance);
}

if(!empty($stockcard)){
	$run_bal=0;
	foreach($balance AS $s){
		if($s['method'] == 'Beginning Balance' || $s['method'] == 'Receive' || $s['method'] == 'Restock'){ 
			$run_bal += $s['quantity'];
		} else if($s['method'] == 'Issuance' || $s['method'] == 'Delivered') {
			$run_bal -= $s['quantity'];
		} 
		$bal[] = $run_bal;
	}
}else {
	$run_bal=0;
}
?>
<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	    #name-item li {width: 50%}
</style>	
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">WH Stock Tracking</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateWstock">
								<table width="100%">
									<tr>
										<td width="17%"><p class="pull-right">Search Item: &nbsp;</p></td>
										<td width="50%">
											<select name="item" id='item' class="form-control select2" onchange="chooseItem()">
												<option value = ""></option>
												<?php foreach($item_list AS $itm){ ?>
												<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->original_pn." - ".$itm->item_name;?></option>
												<?php } ?>
											</select>
											<input type="hidden" name="item_id" id="item_id">
											<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
										</td>
										<td align="center"><div id='alrt' style="font-weight:bold"></div></td>
										<td>
											<input type="submit" name="search_inventory" id ="submit" value='Generate Report' class="btn btn-warning" >
										</td>
									</tr>
								</table>
							</form>
							<br>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $itemdesc; ?> <button id="printReport" class="btn btn-md btn-primary pull-right " onclick="printDiv('printableArea')">Print</button></p>
								<br>
								<?php 
									/*if(!empty($stockcard)){
										$run_bal=0;
										foreach($balance AS $s){
											if($s['method'] == 'Beginning Balance' || $s['method'] == 'Receive' || $s['method'] == 'Restock'){ 
												$run_bal += $s['quantity'];
											} else if($s['method'] == 'Issuance' || $s['method'] == 'Delivered') {
												$run_bal -= $s['quantity'];
											} 
											$bal[] = $run_bal;
										}
									}*/
								?>
								<table class="table-bordered table-hover" width="100%" style="font-size: 15px">
									<thead>
										<tr>
											<td><b>Date</b></td>
											<td><b>PR#</b></td>
											<td><b>PO#</b></td>
											<td><b>Resource PR</b></td>
											<td><b>Transaction Type</b></td>
											<td><b>Transaction No</b></td>
											<td><b>Qty</b></td>
											<td><b>Running Bal</b></td>
										</tr>
									</thead>
									<tbody>
										<?php 
											if(!empty($stockcard)){
												$count = count($stockcard)-1;
												$run_bal=0;
												for($x=$count; $x>=0;$x--){ 
										?>								
										<tr>
											<td style="padding:3px" align="center"><?php echo (!empty($stockcard[$x]['date']) ? date('Y-m-d', strtotime($stockcard[$x]['date'])) : ''); ?></td>
											<td style="padding:3px" align="center"><?php echo ($stockcard[$x]['method']=='Restock' || $stockcard[$x]['method']=='Excess') ? '' : $stockcard[$x]['pr_no']; ?></td>
											<td style="padding:3px" align="center"><?php echo $stockcard[$x]['po_no']; ?></td>
											<td style="padding:3px" align="center"><?php echo ($stockcard[$x]['method']=='Restock' || $stockcard[$x]['method']=='Excess') ? $stockcard[$x]['pr_no'] : ''; ?></td>
											<td style="padding:3px" align="center"><?php echo $stockcard[$x]['method']; ?></td>
											<td style="padding:3px" align="center"><?php echo $stockcard[$x]['transaction_no']; ?></td>
											<td style="padding:3px" align="center"><?php echo (($stockcard[$x]['method']== 'Issuance' || $stockcard[$x]['method'] == 'Delivered') ? "-" : "") . $stockcard[$x]['quantity']; ?></td>
											<td style="padding:3px" align="center"><?php echo $bal[$x]; ?></td>
										</tr>
										<?php } } ?>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


