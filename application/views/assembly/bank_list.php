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
										<th>Location</th>
										<th>Bank Name</th>
										
										<th width="5%">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($bank AS $b) { ?>
									<tr>
										<td><?php echo $b->bank_location; ?></td>
										<td><?php echo $b->bank_name; ?></td>
										
										<td>
											<a href = "<?php echo base_url(); ?>index.php/assembly/update_bank/<?php echo $b->bank_id; ?>" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-pencil-square-o"></span></a>
											<a href="<?php echo base_url(); ?>index.php/assembly/delete_bank/<?php echo $b->bank_id; ?>"  onclick="confirmationDelete(this);return false;" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a>
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

		<!-- Modal -->
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add Bank</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/assembly/insert_bank">
							<label>Location</label>
							<select name='bank_location' class = "form-control">
								<option value='' selected>-Choose Location-</option>
								<option value='A'>A-Bank or Left Bank</option>
								<option value='B'>B-Bank or Right Bank</option>
							</select>
							<label>Bank Name</label>
							<input type = "text" name = "bank_name" class = "form-control">
						
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>