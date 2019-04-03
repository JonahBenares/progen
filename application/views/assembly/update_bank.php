<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/assembly/bank_list">Bank </a></li>
			<li class="active"> Update</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<br>
		</div>
	</div><!--/.row-->
	<!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Modal title</h4>
				</div>
				<div class="modal-body">
				...
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary">Save changes</button>
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading panel-heading-update" style="height:20px">
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="col-lg-12">
							<form method='POST' action="<?php echo base_url(); ?>index.php/assembly/edit_bank">
							
								<div class="col-lg-6">
									<div class="form-group"></div>
									<?php foreach($bank AS $b){ ?>	
									<label>Location</label>
									<select name='bank_location' class = "form-control">
										<option value='A' <?php echo (($b->bank_location == 'A') ? ' selected' : ''); ?>>A-Bank or Left Bank</option>
										<option value='B' <?php echo (($b->bank_location == 'B') ? ' selected' : ''); ?>>B-Bank or Right Bank</option>
									</select>
									<label>Bank Name</label>
									<input type = "text" name = "bank_name" class = "form-control" value="<?php echo $b->bank_name; ?>">
									<label>Bank Plate</label>
									<input type = "text" name = "bank_plate" class = "form-control" value="<?php echo $b->bank_plate; ?>">
									<br>
									<input type='hidden' name='bank_id' value='<?php echo $b->bank_id; ?>'>
									<input class="btn btn-primary btn-md" type="submit" name="add_item" value="Submit">		
									<?php } ?>	
								</div>
							
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


