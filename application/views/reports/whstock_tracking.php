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
							<form method="POST" >
								<table width="100%">
									<tr>
										<td width="17%"><p class="pull-right">Search Item: &nbsp;</p></td>
										<td width="50%">
											<select name="item" id='item' class="form-control select2" >
												<option value = "" style="width:100%"></option>
											</select>
										</td>
										<td>
											<input type="submit" name="search_inventory" id ="submit" value='Generate Report' class="btn btn-warning" >
										</td>
									</tr>
								</table>
							</form>
							<br>
							<br>
							<div id="printableArea">
								<p class="pname">Item Name <button id="printReport" class="btn btn-md btn-primary pull-right " onclick="printDiv('printableArea')">Print</button></p>
								<br>
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
										<tr>
											<td style="padding:3px" align="center"></td>
											<td style="padding:3px" align="center"></td>
											<td style="padding:3px" align="center"></td>
											<td style="padding:3px" align="center"></td>
											<td style="padding:3px" align="center"></td>
											<td style="padding:3px" align="center"></td>
											<td style="padding:3px" align="center"></td>
											<td style="padding:3px" align="center"></td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


