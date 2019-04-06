<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	#name-item{
		width: 35%!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active"> Stock Card</li>
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
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateStkcrd">
								<table width="100%">
									<tr>
										<td width="15%"><p>Item Description:</p></td>
										<td width="40%">
											<input type="text" class="form-control" name="item" id = "item" autocomplete="off">
											<span id="suggestion-item"></span>
										</td>
										<td width="10%"><p class="pull-right">Catalog No.:</p></td>
										<td width="30%"><input type="text" class="form-control" name="catalog_no" id = "catalog_no"></td>
										<td width="10%" rowspan="2">
											<input style="margin:10px" type="submit" name="search_stockcard" value='Generate Report' class="btn btn-warning btn-sm" >
											<!-- <a  href="" class="btn btn-warning ">Generate Report</a> -->
										</td>
									</tr>
									<tr>
										<td width="15%"><p>NKK No.:</p></td>
										<td width="40%">
											<input type="text" class="form-control" name="nkk" id = "nkk" autocomplete="off">
											<span id="suggestion-item"></span>
										</td>
										<td width="10%"><p class="pull-right">SEMT No.:</p></td>
										<td width="30%"><input type="text" class="form-control" name="semt" id = "semt"></td>
										<td width="10%" rowspan="2">
											<!-- <a  href="" class="btn btn-warning ">Generate Report</a> -->
										</td>
									</tr>
									<tr>
										<td><p>Supplier:</p></td>
										<td>
											<input type="text" class="form-control" name="supplier" id = "supplier" autocomplete="off">
											<span id="suggestion-supplier"></span>
										</td>
										<td><p class="pull-right">Brand:</p></td>
										<td>
											<input type="text" class="form-control" name="brand" id = "brand" autocomplete="off">
											<span id="suggestion-brand"></span>
										</td>
									</tr>
								</table>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type="hidden" name="item_id" id="item_id">
								<input type="hidden" name="supplier_id" id="supplier_id">
								<input type="hidden" name="brand_id" id="brand_id">
							</form>
							<br>
							<p class="pname"><?php echo $itemdesc; ?>
								<a href="" class="btn btn-info pull-right">Overall Quantity: <span style="font-size: 25px" class="badge animated rubberBand "><?php echo $total; ?></span></a>
								<a href="<?php echo base_url(); ?>index.php/reports/stock_card_preview/<?php echo $id; ?>/<?php echo $sup; ?>/<?php echo $cat; ?>/<?php echo $nkk; ?>/<?php echo $semt; ?>/<?php echo $brand; ?>" class="btn btn-primary btn-sm pull-right" style="margin-top: 7px;margin-right: 5px" target="_blank">Print Stock Card</a>
							</p>
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<th style="text-align: center" width="30%">Supplier</th>
										<th style="text-align: center" width="16%">Catalog No.</th>
										<th style="text-align: center" width="16%">NKK No.</th>
										<th style="text-align: center" width="16%">SEMT No.</th>
										<th style="text-align: center" width="30%">Brand</th>
										<th style="text-align: center" width="6%">Unit Cost</th>
										<th style="text-align: center" width="0%">Qty Received</th>
										<th style="text-align: center" width="6%">Qty Issued</th>
										<th style="text-align: center" width="6%">Qty Restocked</th>
										<th style="text-align: center" width="12%">Date</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										if(!empty($rec_itm)){
											//print_r($rec_itm);
										foreach($rec_itm as $rec){
									?>
									<tr>										
										<td align="center"><?php echo $rec['supplier'];?></td>
										<td align="center"><?php if($rec['catalog_no']!='null'){ echo $rec['catalog_no']; } else { echo ''; }?></td>
										<td align="center"><?php if($rec['nkk']!='null'){ echo $rec['nkk']; } else { echo ''; }?></td>
										<td align="center"><?php if($rec['semt']!='null'){ echo $rec['semt']; } else { echo ''; }?></td>
										<td align="center"><?php echo $rec['brand'];?></td>
										<td align="center"><?php echo $rec['item_cost'];?></td>
										<td align="center"><?php echo $rec['receive_qty'];?></td>							
										<td align="center"><?php echo $rec['issueqty'];?></td>
										<td align="center"><?php echo $rec['restockqty'];?></td>
										<td align="center"><?php echo $rec['date'];?></td>							
									</tr>
									<?php } }else { ?>
									<tr>
										<td align="center" colspan='10'><center>No Data Available.</center></td>
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
	<script type="text/javascript"></script>
