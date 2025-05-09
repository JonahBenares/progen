<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/masterfile/buyer_list">Buyer </a></li>
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
							<form method='POST' action="<?php echo base_url(); ?>index.php/masterfile/edit_buyer">
								<?php foreach($buyer AS $buy){ ?>
								<div class="col-lg-6">
									<div class="form-group"></div>
									<label>Buyer</label>
									<input class="form-control" type="text" name="buyer" value="<?php echo $buy->buyer_name;?>">
					
									<label>Address</label>
									<input class="form-control" type="text" name="address" value="<?php echo $buy->address;?>">
							
									<label>Contact Person</label>
									<input class="form-control" type="text" name="contact_person" value="<?php echo $buy->contact_person;?>">
						
									<label>Contact No</label>
									<input class="form-control" type="text" name="contact_no" value="<?php echo $buy->contact_no;?>">
									<br>
									<input type='hidden' name='buyer_id' value='<?php echo $id; ?>'>
									<input class="btn btn-primary btn-md" type="submit" name="add_item" value="Submit">			
								</div>
								<?php } ?>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>


