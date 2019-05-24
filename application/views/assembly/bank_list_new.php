<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Bank List</li>
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
						BANK LIST
						<div class="pull-right">
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#myModal">
								<span class="fa fa-plus"></span>
							</a>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Bank Name</th>
										<th>Type</th>
										<th>Column No.</th>
										<th>Left</th>
										<th>Right</th>
										
										<th width="5%"><span class="fa fa-bars"></span></th>
									</tr>
								</thead>
								<tbody>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										
										<td>
											<a href="<?php echo base_url(); ?>index.php/assembly/delete_bank"  onclick="confirmationDelete(this);return false;" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<h4 class="modal-title" id="myModalLabel">Add Bank
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/assembly/">
							<div class="form-group">
								<p style="margin: 0px">
									<b>Bank Name:</b>
									<input type="text" name="" class="form-control">
								</p>
							</div>
							<div class="form-group">
								<p style="margin: 0px">
									<b>Type:</b>
									<select name="" class="form-control">
										<option>--Select type--</option>
										<option>No Left/Right</option>
										<option>With Left/Right</option>
									</select>
								</p>
							</div>
							<div class="form-group">
								<p style="margin: 0px">
									<b>No of Left Column:</b>
									<input type="text" name="" class="form-control">
								</p>
							</div>
							<div class="form-group">
								<p style="margin: 0px">
									<b>No of Right Column:</b>
									<input type="text" name="" class="form-control">
								</p>
							</div>							
							<div class="modal-footer">
								<button type="submit" class="btn btn-warning btn-block">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>