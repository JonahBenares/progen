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
			<li class="active"> Request Report</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateRequest">
								<table width="100%" style="font-size: 12px">
									<tr>
										<td width="10%">Search Item:</td>
										<td width="30%">
											From:
											<input type="date" class="form-control" name="from">
										</td>
										<td width="30%">
											To:
											<input type="date" class="form-control" name="to">
										</td>									
										<td width="30%">
											<br>
											<select name="item" class="form-control select2" >
												<option value="" selected="">-Item-</option>
												<?php foreach($item AS $it){ ?>
													<option value="<?php echo $it->item_id; ?>"><?php echo $it->item_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<br>
											<input type="submit" name="search_inventory" value='Generate' class="btn btn-warning btn-block" >
										</td>
									</tr>
								</table>
							</form>
							<br>
							<?php if(!empty($req)){ ?>
							<a href = "<?php echo base_url(); ?>index.php/reports/export_req/<?php echo $from;?>/<?php echo $to;?>/<?php echo $item1;?>" class = "btn btn-primary pull-right">Export to Excel</a>
							<button id="printReport" class="btn btn-info pull-right " onclick="printDiv('printableArea')">
									<span  class="fa fa-print"></span>
							</button>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $c; ?> - <small class="main_cat"><?php echo $s; ?></small></p>
								<div style="overflow-x: scroll;padding-bottom: 20px ">
									<table class="table table-hover table-bordered" id="received"  style="font-size: 12px">
										<thead>
											<tr>
												
												<th align="center"><strong>Request Date</strong></th>
												<th align="center"><strong>MRIF No.</strong></th>
												<th align="center"><strong>PR No.</strong></th>
												<th align="center"><strong>Item Part No.</strong></th>
												<th align="center"><strong>Item Description</strong></th>
												<th align="center"><strong>Total Qty Received</strong></th>
												<th align="center"><strong>UoM</strong></th>
												<th align="center"><strong>Unit Cost</strong></th>
												<th align="center"><strong>Total Cost</strong></th>
												<th align="center"><strong>Supplier</strong></th>
												<th align="center"><strong>Department</strong></th>
												<th align="center"><strong>Purpose</strong></th>
												<th align="center"><strong>End Use</strong></th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($req as $req){ ?>
											<tr>
												<td align="center"><?php echo date('d-M-Y',strtotime($req['req_date']));?></td>
												<td align="center"><?php echo $req['mreqf_no']?></td>
												<td align="center"><?php echo $req['pr_no']?></td>
												<td align="center"><?php echo $req['pn']?></td>
												<td align="center"><?php echo $req['item']?></td>
												<td align="center"><?php echo $req['quantity']?></td>
												<td align="center"><?php echo $req['unit']?></td>
												<td align="center"><?php echo number_format($req['unit_cost'],2)?></td>
												<td align="center"><?php echo number_format($req['total_cost'],2)?></td>
												<td align="center"><?php echo $req['supplier']?></td>
												<td align="center"><?php echo $req['department']?></td>
												<td align="center"><?php echo $req['purpose']?></td>
												<td align="center"><?php echo $req['enduse']?></td>
											</tr>
											<?php } ?>
										</tbody>
									</table>
								</div>
								<table width="100%" id="prntby">
					                <tr>
					                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
					                </tr>
					            </table> 
							</div>
						<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
