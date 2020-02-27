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
			<li class="active"> Issued Report</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateIssue">
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
											<select name="item" class="form-control">
												<option value = "" selected="">-Item-</option>
												<?php foreach($item AS $it){ ?>
													<option value="<?php echo $it->item_id; ?>"><?php echo $it->item_name; ?></option>
												<?php } ?>
											</select>
										</td>
									</tr>
									<tr>
										<td></td>
										<td>
											<br>
											<select name="category" class="form-control" id="category" onChange="chooseCategory();">
												<option value = "" selected="">-Category-</option>
												<?php foreach($category AS $cat){ ?>
													<option value="<?php echo $cat->cat_id; ?>"><?php echo $cat->cat_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td>
											<br>
											<select name="subcat" class="form-control btn-block" id="subcat">
												
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
							<?php if(!empty($issue)){ ?>
							<a href = "<?php echo base_url(); ?>index.php/reports/export_issue/<?php echo $from;?>/<?php echo $to;?>/<?php echo $catt;?>/<?php echo $subcat1;?>/<?php echo $item1;?>" class = "btn btn-primary pull-right">Export to Excel</a>
							<button id="printReport" class="btn btn-info pull-right " onclick="printDiv('printableArea')">
									<span  class="fa fa-print"></span>
							</button>
							<br>
							<div id="printableArea">
								<p class="pname"><?php echo $c; ?> - <small class="main_cat"><?php echo $s; ?></small></p>
								<table class="table table-hover table-bordered" id="received" style="font-size: 12px">
									<thead>
										<tr>
											<td align="center"><strong>Issue Date</strong></td>
											<td align="center"><strong>PR No.</strong></td>
											<td align="center"><strong>Item Part No.</strong></td>
											<td align="center"><strong>Item Description</strong></td>
											<td align="center"><strong>UoM</strong></td>
											<td align="center"><strong>Total Qty Issued</strong></td>
											<td align="center"><strong>Supplier</strong></td>
											<td align="center"><strong>Department</strong></td>
											<td align="center"><strong>Purpose</strong></td>
											<td align="center"><strong>End Use</strong></td>
											<td style="width:2%" align="center"><strong>Freq</strong></td>
										</tr>
									</thead>
									<tbody>
										<?php foreach($issue AS $is){ ?>
										<tr>
											<td align="center"><?php echo  date('d-M-Y',strtotime($is['issue_date']));?></td>
											<td align="center"><?php echo $is['pr']?></td>
											<td align="center"><?php echo $is['pn'];?></td>
											<td align="center"><?php echo $is['item'];?></td>
											<td align="center"><?php echo $is['unit'];?></td>
											<td align="center"><?php echo $is['issqty'];?></td>
											<td align="center"><?php echo $is['supplier'];?></td>
											<td align="center"><?php echo $is['department'];?></td>
											<td align="center"><?php echo $is['purpose'];?></td>
											<td align="center"><?php echo $is['enduse'];?></td>
											<td align="center"><?php ?></td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

