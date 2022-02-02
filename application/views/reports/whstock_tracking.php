<style type="text/css">
	.label-info {
    background-color: #5bc0de;
}
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
<!-- Modal -->		
<div id="loader">
  	<figure class="one"></figure>
  	<figure class="two">loading</figure>
</div>
<di id="itemslist" style="display: none">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					WH Stock Tracking
					<div class="pull-right">
						<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#modal_addnew">
							<span class="fa fa-search"></span>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">									
							<!-- <div class='alert alert-warning alert-shake'>
								<center>
									<strong>Filters applied:</strong> .
									<a href='<?php echo base_url(); ?>index.php/delivery/delivery_list' class='remove_filter alert-link'>Remove Filters</a>. 
								</center>
							</div> -->
						</div>
						<table class="table-bordered table-hover" id="received" width="100%" style="font-size: 15px">
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
									<td><b>Action</b></td>
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
									<td style="padding:3px" align="center"></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="modal_addnew" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
		<div class="modal-dialog" role="document">
			<div class="modal-content modbod">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel" style="color:#000">Search</h4>
				</div>
				<form method="POST" action = "<?php echo base_url(); ?>index.php/items/search_item" role="search">
					<div class="modal-body">
						<table style="width:100%">
							<tr>
								<td width="25%" class="td-sclass"><label for="category">Date:</label></td>
								<td width="75%"class="td-sclass"><input type="date" class="form-control" name="item_desc"></td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="sub">PR No.:</label></td>
								<td class="td-sclass"><input class="form-control" ></td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="sub">PO No.:</label></td>
								<td class="td-sclass"><input class="form-control" ></td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="desc">Resource PR:</label></td>
								<td class="td-sclass"><input class="form-control" ></td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="pn">Transaction Type.:</label></td>
								<td class="td-sclass"><input class="form-control" name="pn"></td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="pn">Transaction Type.:</label></td>
								<td class="td-sclass"><input class="form-control" name="pn"></td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="pn">Quantity:</label></td>
								<td class="td-sclass"><input class="form-control" name="pn"></td>
							</tr>
							<tr>
								<td class="td-sclass"><label for="pn">Running Balance:</label></td>
								<td class="td-sclass"><input class="form-control" name="pn"></td>
							</tr>
						</table>
					</div>
					<div class="modal-footer">
						<input type="submit" name="searchbtn" class="search-btn btn btn-default shadow" value="Search">
					</div>
					<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
				</form>
			</div>
		</div>
	</div>