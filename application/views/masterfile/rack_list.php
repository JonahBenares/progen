<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Rack</li>
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
						RACK LIST	
						<?php if($access['masterfile_add'] == 1){ ?>				
						<div class="pull-right">
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#addCategory">
								<span class="fa fa-plus"></span>
							</a>
						</div>
						<?php } ?>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Rack Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
								<?php foreach($rack AS $rack){ ?>
									<tr>
										<td><?php echo $rack->rack_name;?></td>
										<td>
											<?php if($access['masterfile_edit'] == 1){ ?>
											<a href = "<?php echo base_url(); ?>index.php/masterfile/update_rack/<?php echo $rack->rack_id;?>" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-pencil-square-o"></span></a>
											<?php } ?>
											<!-- <?php if($access['masterfile_delete'] == 1){ ?>
											<a  href="<?php echo base_url(); ?>index.php/masterfile/delete_rack/<?php echo $rack->rack_id;?>" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a>
											<?php } ?> -->
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
		<!-- MODAL -->
		<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add New Rack</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_rack">
							<label>Rack Name</label>
							<input type = "text" name = "rack" class = "form-control">
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
