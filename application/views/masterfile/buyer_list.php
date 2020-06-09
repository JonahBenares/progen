<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Buyer</li>
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
						BUYER LIST
						<div class="pull-right">
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#myModal">
								<span class="fa fa-plus"></span>
							</a>
							<!-- <?php if($access['masterfile_add'] == 1){ ?> -->
							<!-- <?php } ?> -->
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Buyer</th>
										<th>Address</th>
										<th>Contact Person</th>
										<th>Contact No.</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td width="1%">
											<a href = "<?php echo base_url(); ?>index.php/masterfile/update_buyer/" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-pencil-square-o"></span></a>
											<!-- <?php if($access['masterfile_edit'] == 1){ ?> -->
											<!-- <?php } if($access['masterfile_delete'] == 1){ ?> -->
											<!-- <?php } ?> -->
											<a href="<?php echo base_url(); ?>index.php/masterfile/delete_buyer/" onclick="confirmationDelete(this);return false;" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- ----------------------MODAL------------------------- -->
		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add New Buyer</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_buyer">
							<label>Buyer</label>
							<input type = "text" name = "buyer" class = "form-control">

							<label>Address</label>
							<input type = "text" name = "address" class = "form-control">

							<label>Contact Person</label>
							<input type = "text" name = "contact_person" class = "form-control">

							<label>Contact No.</label>
							<input type = "text" name = "contactno" class = "form-control">
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>