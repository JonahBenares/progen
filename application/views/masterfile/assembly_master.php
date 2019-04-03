<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Assembly</li>
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
					<div class="panel-heading">
						Assembly Masterfile
						<div class="pull-right">
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#addItem_assem" title="Add Item" alt='Add Item'>
								<span class="fa fa-plus"></span>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" >
								<tr>
									<th width="30%">Item Description</th>
									<th>PN</th>
									<th width="8%">Qty</th>
									<th width="5%">UOM</th>
									<th>Bank</th>
									<th>Plate No.</th>
									<th width="5%">Action</th>
								</tr>
								<tbody>
									<tr>
										<td style="padding: 0px"><input type="text" class="form-control" name="" readonly=""></td>
										<td style="padding: 0px"><input type="text" class="form-control" name="" readonly=""></td>
										<td style="padding: 0px"><input type="text" class="form-control" name="" readonly=""></td>
										<td style="padding: 0px"><input type="text" class="form-control" name="" readonly=""></td>
										<td style="padding: 0px"><input type="text" class="form-control" name="" readonly=""></td>
										<td style="padding: 0px"><input type="text" class="form-control" name="" readonly=""></td>
										<td style="padding: 0px" align="center">
											<a href="" class="btn btn-danger btn-sm" title="Remove" alt='Remove'><span class="fa fa-times"></span></a>
										</td>
									</tr>
								</tbody>
							</table>
							<br>
							<center>
								<a href="" class="btn btn-info btn-lg">Save</a>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="addItem_assem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add Item</h4>
					</div>
					<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_enduse">
						<div class="modal-body" style="padding:30px">
							<label>Item Description</label>
							<input type = "text" name = "" class = "form-control">
							<label>PN</label>
							<input type = "text" name = "" class = "form-control">
							<div class="row">
								<div class="col-lg-6">
									<label>Quantity</label>
									<input type = "text" name = "" class = "form-control">
								</div>
								<div class="col-lg-6">
									<label>UOM</label>
									<input type = "text" name = "" class = "form-control">
								</div>
							</div>
							<label>Bank</label>
							<input type = "text" name = "" class = "form-control">
							<label>Plate No.</label>
							<input type = "text" name = "" class = "form-control">							
						</div>
						<div class="modal-footer" style="padding:30px">
							<button type="submit" class="btn btn-warning btn-block">Add</button>
						</div>
					</form>
				</div>
			</div>
		</div>