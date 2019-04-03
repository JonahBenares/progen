<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Assembly Receive List</li>
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
						Assembly Receive
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<button class="btn btn-primary btn-md" data-toggle="modal" data-target="#rec_det"><span class="fa fa-plus"></span> Add Receive</button>
							<br>
							<br>
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Receipt No.</th>
										<th>Date Received</th>
										<th>Engine</th>
										<th>Assembly</th>
										<th width="5%">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($info AS $i){ ?>
									<tr>
										<td><?php echo $i['receipt_no']; ?></td>
										<td><?php echo $i['receive_date']; ?></td>
										<td><?php echo $i['engine_name']; ?></td>
										<td><?php echo $i['assembly_name']; ?></td>
										<td>
											<a href = "<?php echo base_url(); ?>index.php/assembly/asrec_form_view/<?php echo $i['id']; ?>" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-eye"></span></a>
											<!-- <a href="<?php echo base_url(); ?>index.php/assembly" return false;" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a> -->
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
		<div class="modal fade" id="rec_det" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add Bank</h4>
					</div>
					<form method="POST" action = "<?php echo base_url();?>index.php/assembly/insert_receive_head">
						<div class="modal-body">
							<label>Received Date:</label>
							<input type="date" name='receive_date' class="form-control"  required="">
							<label>Engine:</label>
							<select class="form-control btn-block" required="" name="engine" id="engine_from" onclick="chooseAssembly2()" > 
								<option value='' selected>-Select-</option>
								<?php foreach($engine AS $eng){ ?>
								<option value="<?php echo $eng->engine_id; ?>"><?php echo $eng->engine_name; ?></option>
								<?php  } ?>
							</select>
							<label>Assembly:</label>
							<select name="assembly" class="form-control btn-block" id="assembly_from"  required="">
							</select>
						</div>
						<div class="modal-footer">
							<input type="submit" name="submit_rec_head" value="Proceed">
							<!-- <a href="<?php echo base_url();?>index.php/assembly/asrec_form" class="btn btn-block btn-info">Proceed</a> -->
						</div>
						<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
					</form>
				</div>
			</div>
		</div>