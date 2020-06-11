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
			<li class="active"> Delivery Report</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateDelivery">
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
											<select name="item" class="form-control select2">
												<option value = "">-Select Item-</option>
												<?php foreach($item_list AS $it){ ?>
													<option value = "<?php echo $it->item_id; ?>"><?php echo $it->item_name; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td></td>
										<td></td>
										<td>
											<br>
											<input type="submit" name="search_inventory" value='Generate' class="btn btn-warning btn-block" >
										</td>
										<td></td>
										<td></td>
										<td></td>
									</tr>
								</table>
							</form>
							<br>
							<a href = "<?php echo base_url(); ?>index.php/reports/export_delivery/<?php echo $from;?>/<?php echo $to;?>/<?php echo $item; ?>" class = "btn btn-primary pull-right">Export to Excel</a>
							<button id="printReport" class="btn btn-info pull-right " onclick="printDiv('printableArea')">
									<span  class="fa fa-print"></span>
							</button>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $item_name; ?></p>
								<br>
								<div style="overflow-x: scroll;padding-bottom: 20px ">
									<table class="table table-hover table-bordered" id="received" style="font-size: 12px">
										<thead>
											<tr>
												<td align="center"><strong>DR Date</strong></td>
												<td align="center"><strong>DR No.</strong></td>
												<td align="center"><strong>PR#/PO#</strong></td>
												<td align="center"><strong>PO Date</strong></td>
												<td align="center"><strong>Part No.</strong></td>
												<td align="center"><strong>Item Description</strong></td>
												<td align="center"><strong>Qty</strong></td>
												<td align="center"><strong>UoM</strong></td>
											</tr>
										</thead>
										<tbody>
											<?php foreach($report AS $r){ ?>
											<tr>
												<td><?php echo $r['date'];?></td>
												<td><?php echo $r['dr_no'];?></td>
												<td><?php echo $r['pr_no'];?></td>
												<td><?php echo $r['po_date'];?></td>
												<td><?php echo $r['pn_no'];?></td>
												<td><?php echo $r['item'];?></td>
												<td><?php echo $r['qty'];?></td>
												<td><?php echo $r['unit'];?></td>
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
		</div>
	</div>

