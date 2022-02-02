<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Supplier</li>
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
						SUPPLIER LIST
						<div class="pull-right">
							<?php if($access['masterfile_add'] == 1){ ?>
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#myModal">
								<span class="fa fa-plus"></span>
							</a>
							<?php } ?>
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#viewSupplier">
								<span class="fa fa-lock"></span>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Supplier Code</th>
										<th>Supplier Name</th>
										<th>Address</th>
										<th>Contact Number</th>
										<th>Terms</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($list AS $li) {
									
									?>
									<tr>
										<td><?php echo $li->supplier_code; ?></td>
										<td><?php echo $li->supplier_name; ?></td>
										<?php if(!empty($password)){?>
										<td><span class="restrict"><?php echo $li->address; ?></span></td>
										<td><span class="restrict"><?php echo $li->contact_number; ?></span></td>
										<td><span class="restrict"><?php echo $li->terms; ?></span></td>
										<?php } else { ?>
										<td><span style="color:red; font-size: 11px;">Unavailable Content</span></td>
										<td><span style="color:red; font-size: 11px;">Unavailable Content</span></td>
										<td><span style="color:red; font-size: 11px;">Unavailable Content</span></td>
										<?php } ?>
										<?php if($li->active == '1') { ?>
										<td><?php echo '<span class = "label label-success label-xs">Active</span>'; ?></td>
										<?php } else { ?>
										<td><?php echo '<span class = "label label-danger label-xs">Inactive</span>'; ?></td>
										<?php } ?>
										<td>
											<?php if($access['masterfile_edit'] == 1){ ?>
											<a href = "<?php echo base_url(); ?>index.php/masterfile/update_supplier/<?php echo $li->supplier_id;?>" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-pencil-square-o"></span></a>
											<?php } //if($access['masterfile_delete'] == 1){ ?>
											<!-- <a href="<?php echo base_url(); ?>index.php/masterfile/delete_list/<?php echo $li->supplier_id;?>" onclick="confirmationDelete(this);return false;" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a> -->
											<?php //} ?>
										</td>
									</tr>
									<?php } ?>
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
						<h4 class="modal-title" id="myModalLabel">Add New Supplier</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_list">
							<label>Supplier Code</label>
							<input type = "text" name = "supplier_code" class = "form-control">
							<label>Supplier Name</label>
							<input type = "text" name = "supplier_name" class = "form-control">
							<label>Address</label>
							<input type = "text" name = "address" class = "form-control">
							<label>Contact Number</label>
							<input type = "text" name = "contact_number" class = "form-control">
							<label>Terms</label>
							<input type = "text" name = "terms" class = "form-control">
							<label>Status</label>
							<div class = "row">
								<div class = "col-md-6">
									<label class="btn btn-primary"><input type="radio" name = "active" value="1" required=""> Active</label>
									<label class="btn btn-danger"><input type="radio" name = "active" value="0" required=""> Inactive</label>
								</div>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<div class="modal fade" id="viewSupplier" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">View Supplier</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/view_supplier">
							<input type = "hidden" name = "username" id="username" class = "form-control" value="<?php echo $_SESSION['username'];?>">
							<label>Password</label>
							<input type = "password" name = "password" id="password" class = "form-control">
							<div class="modal-footer">
								<input type = "hidden" name = "baseurl" id="baseurl" class = "form-control" value="<?php echo base_url();?>">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning" id="save">Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>