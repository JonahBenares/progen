<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Assembly Transfer List</li>
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
						Assembly Transfer
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<button class="btn btn-primary btn-md" data-toggle="modal" data-target="#tranferTo"><span class="fa fa-plus"></span> Transfer</button>
							<br>
							<br>
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Transfer Date</th>
										<th>Engine (from)</th>
										<th>Assembly (from)</th>
										<th>Transfer To</th>
										<th width="30%">Item Description</th>
										<th width="2%">Qty</th>
										<th>Enduse</th>
										<th width="1%"><span class="fa fa-bars"></span></th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($info AS $i){ ?>
									<tr>
										<td><?php echo $i['transfer_date']; ?></td>
										<td><?php echo $i['engine_from']; ?></td>
										<td><?php echo $i['assembly_from']; ?></td>
										<td><?php echo $i['transfer_to'];?>
										<?php if($i['transfer_to'] == 'Engine Inventory'){ ?>
										- (<?php echo $i['engine_to'];?>) <?php } ?></td>
										<td><?php echo $i['item'];?></td>
										<td><?php echo $i['qty'];?></td>
										<td><?php echo $i['enduse']; ?></td>
										<td>
											<a href = "<?php echo base_url(); ?>index.php/assembly/assem_transfer_view/<?php echo $i['id']; ?>" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-eye"></span></a>
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
		<div class="modal fade" id="tranferTo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel"></h4>
					</div>
					<form id='' method = "POST" action="<?php echo base_url(); ?>index.php/assembly/insert_issue">
						<div class="modal-body" style="padding:30px 50px 30px 50px">
							<table width="100%">
								<tr>
									<td width="20%">Transfer Date:</td>	
									<td>
										<input type='date' name='transfer_date' class="form-control btn-block">
										<br>
									</td>	
								</tr>
								<tr>
									<td width="20%">Transfer to:</td>	
									<td>
										<select class="form-control btn-block" required="" name="location" id="location" onchange ='enableEngine()'> 
											<option value='' selected>-Select-</option>
											<?php foreach($assembly_loc AS $al){ ?>
											<option value="<?php echo $al->al_id; ?>"><?php echo $al->location_name; ?></option>
											<?php } ?> 
										</select>
										<br>
									</td>	
								</tr>
								<tr id='engine_div' style='display:none'>	
									<td width="20%">Engine (to):</td>
									<td>
										<select class="form-control btn-block" required="" name="engine_to" id="engine" onclick="chooseAssembly()" > 
											<option value='' selected>-Select-</option>
											<?php foreach($engine AS $eng){ ?>
											<option value="<?php echo $eng->engine_id; ?>"><?php echo $eng->engine_name; ?></option>
											<?php  } ?>
										</select>
										<br>
									</td>	
								</tr>	
								<tr id='assembly_div' style='display:none'>	
									<td width="20%">Assembly (to):</td>
									<td>
										<select name="assembly_to" class="form-control btn-block" id="assembly" >
										</select>
										<br>
									</td>	
								</tr>	
								<tr>
									<td colspan='2'><hr></td>
								</tr>	

								<tr>	
									<td width="20%">Department:</td>
									<td>
										<select class="form-control btn-block" required="" name='department'> 
											<option value='' selected>-Select-</option>
											<?php foreach($department AS $dept){ ?>
											<option value="<?php echo $dept->department_id; ?>"><?php echo $dept->department_name; ?></option>
											<?php } ?>
										</select>
										<br>
									</td>	
								</tr>
								<tr>	
									<td width="20%">Purpose:</td>
									<td>
										<select class="form-control btn-block" required="" name='purpose'> 
											<option value='' selected>-Select-</option>
											<?php foreach($purpose AS $purp){ ?>
											<option value="<?php echo $purp->purpose_id; ?>"><?php echo $purp->purpose_desc; ?></option>
											<?php } ?>
										</select>
										<br>
									</td>	
								</tr>
								<tr>	
									<td width="20%">End Use:</td>
									<td>
										<select class="form-control btn-block" required="" name='enduse'> 
											<option value='' selected>-Select-</option>
											<?php foreach($enduse AS $end){ ?>
											<option value="<?php echo $end->enduse_id; ?>"><?php echo $end->enduse_name; ?></option>
											<?php } ?>
										</select>
										<br>
									</td>	
								</tr>
							</table>
						
							<table width="100%">
								<tr>	
									<td colspan="2">
										<input type='submit' class="btn btn-block btn-info btn-md" value='Proceed'>
									</td>	
								</tr>
							</table>				
						</div>
						<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
					</form>
				</div>
			</div>
		</div>