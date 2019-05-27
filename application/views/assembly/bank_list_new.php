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
										<th>Bank Category</th>
										<th>Type</th>
										<th>Column No.</th>
										<th>Left</th>
										<th>Right</th>
										
										<th width="5%"><span class="fa fa-bars"></span></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($banks AS $b){ ?>
									<tr>
										<td><?php echo $b->bank_category;?></td>
										<td><?php echo $b->bank_type;?></td>
										<td><?php echo $b->no_column;?></td>
										<td><?php echo $b->left_column;?></td>
										<td><?php echo $b->right_column;?></td>
										<td>
											<a href="<?php echo base_url(); ?>index.php/assembly/delete_bank_head/<?php echo $b->bh_id;?>"  onclick="confirmationDelete(this);return false;" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a>
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
						<h4 class="modal-title" id="myModalLabel">Add Bank Category
							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/assembly/insert_bank_head">
							<div class="form-group">
								<p style="margin: 0px">
									<b>Bank Category:</b>
									<input type="text" name="category" class="form-control">
								</p>
							</div>
							<div class="form-group">
								<p style="margin: 0px">
									<b>Type:</b>
									<select name="type" class="form-control" onchange="showDiv(this)">
										<option value = "">--Select type--</option>
										<option value = "No Left/Right">No Left/Right</option>
										<option value = "With Left/Right">With Left/Right</option>
									</select>
								</p>
							</div>
							<div class="form-group" id = "a" style = "display: none;">
								<p style="margin: 0px">
									<b>No of Column:</b>
									<input type="text" name="nocol" class="form-control">
								</p>
							</div>
							<div class="form-group" id = "b" style = "display: none;">
								<p style="margin: 0px">
									<b>No of Left Column:</b>
									<input type="text" name="leftcol" class="form-control">
								</p>
							</div>
							<div class="form-group" id = "c" style = "display: none;">
								<p style="margin: 0px">
									<b>No of Right Column:</b>
									<input type="text" name="rightcol" class="form-control">
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