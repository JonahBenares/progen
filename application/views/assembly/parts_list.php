<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">Assembly</li>
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
					ASSEMBLY LIST
					<div class="btn-group pull-right">
						<!-- <a class=" clickable panel-toggle panel-button-tab-right shadow" href="<?php  echo base_url();?>index.php/assembly/complete_list ">
							<span class="fa fa-eye"></span>
						</a> -->
						<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#addEngine" title="Add Engine">
							<span class="fa fa-plus"></span>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="accordion " id="accordionExample">
							<!-- Looop -->
							<?php 
							$e=1;
							$ass=1;
							foreach($engine AS $en){
							  ?>
							<div class="card m-b-5 " id="engines">
								<div class="btn-group btn-block bor-radius100"> 
								    <button class="btn btn-default border-acc" type="button" data-toggle="collapse" data-target="#collapseEngine<?php echo $e; ?>" aria-expanded="true" aria-controls="collapseEngine<?php echo $e; ?>" style="width: 85%">
										<div class="card-header" id="headingOne">
									      	<h4 class="mb-0 pull-left">
										          <b><?php echo $en->engine_name; ?></b>
									      	</h4>
										</div>
							        </button>
							        <a href="<?php  echo base_url();?>index.php/assembly/engview_list/<?php echo $en->engine_id; ?>" target="_blank" class="btn btn-success" type="button" style="width: 5%" title="View Report">
										<div class="card-header" id="headingOne">
											<h4 class="mb-0">
												<span class="fa fa-eye text-white"></span>
									      	</h4>
										</div>
							        </a>
							        <a href="" class="btn btn-success" type="button"data-toggle="modal" id="updateEngine_button" data-id="<?php echo $en->engine_id; ?>" data-trigger="<?php echo $en->engine_name; ?>" data-target="#updateEngine" style="width: 5%"  title="Update Engine">
										<div class="card-header" id="headingOne">
											<h4 class="mb-0">
												<span class="fa fa-pencil text-white"></span>
									      	</h4>
										</div>
							        </a>
							        <a href="" class="btn btn-success" type="button" data-toggle="modal" data-trigger="<?php echo $en->engine_id; ?>" data-target="#addAssembly" id='addAssembly_button' style="width: 5%"  title="Add Assembly">
										<div class="card-header" id="headingOne">
											<h4 class="mb-0">
												<span class="fa fa-plus text-white"></span>
									      	</h4>
										</div>
							        </a>
								</div>
							    <div id="collapseEngine<?php echo $e; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
							      	<div class="card-body p-l-60  p-t-5 ">
							      		<!-- LOOP -->
							      		<?php 
							      		$a=1;
							      		foreach($assembly AS $as){ 
							      			if($en->engine_id == $as['engine_id']) { ?>
							        	<div class="card m-b-5" id="engines_sub">
											<div class="btn-group btn-block ">
												<button class="btn btn-sm btn-info" type="button" style="width:5%">
													<div class="card-header" id="headingOne">
														<h5 class="mb-0">
															<span class="text-white"><?php echo $a; ?></span>
												      	</h5>
													</div>
										        </button>
											    <button class="btn btn-sm btn-default border-acc"  type="button" data-toggle="collapse" data-target="#collapseAssembly<?php echo $ass; ?>" aria-expanded="true" aria-controls="collapseAssembly<?php echo $ass; ?>" <?php echo (($as['locked'] == '1') ? "style='width:75%'" : "style='width:80%'") ?> >
													<div class="card-header" id="headingOne">
												      	<h5 class="mb-0 pull-left">
													          <?php echo $as['assembly_name']; ?>
												      	</h5>
													</div>
										        </button>
										        
												<?php if($as['locked'] == '1'){ ?>
												 <a href="" class="btn btn-sm btn-danger" type="button" style="width:5%" title="Locked">
													<div class="card-header">
														<h5 class="mb-0">
															<span class="fa fa-lock text-white"></span>
												      	</h5>
													</div>
										        </a>
											     <?php } ?>
												<?php if($as['bh_id'] == 0){ ?>
											        <a href="<?php  echo base_url();?>index.php/assembly/complete_list/<?php echo $en->engine_id; ?>/<?php echo $as['assembly_id']; ?>/<?php echo $as['bh_id']; ?>" target="_blank" class="btn btn-sm btn-info" type="button" style="width:5%" title="Add Beginning Balance">
														<div class="card-header">
															<h5 class="mb-0">
																<span class="fa fa-table text-white"></span>
													      	</h5>
														</div>
											        </a>
										    	<?php } else if($as['bank_type'] == 'No Left/Right'){ ?>
										    		<a href="<?php  echo base_url();?>index.php/assembly/complete_list_nolr/<?php echo $en->engine_id; ?>/<?php echo $as['assembly_id']; ?>/<?php echo $as['bh_id']; ?>" target="_blank" class="btn btn-sm btn-info" type="button" style="width:5%" title="Add Beginning Balance">
														<div class="card-header">
															<h5 class="mb-0">
																<span class="fa fa-table text-white"></span>
													      	</h5>
														</div>
											        </a>
										    	<?php } else if($as['bank_type'] == 'With Left/Right'){ ?>
										    		<a href="<?php  echo base_url();?>index.php/assembly/complete_list_wlr/<?php echo $en->engine_id; ?>/<?php echo $as['assembly_id']; ?>/<?php echo $as['bh_id']; ?>" target="_blank" class="btn btn-sm btn-info" type="button" style="width:5%" title="Add Beginning Balance">
														<div class="card-header">
															<h5 class="mb-0">
																<span class="fa fa-table text-white"></span>
													      	</h5>
														</div>
											        </a>
										    	<?php } ?>
										        <a class="btn btn-sm btn-info" type="button" data-toggle="modal" id="updateAssembly_button" data-target="#updateAssembly" data-id="<?php echo $as['assembly_id']; ?>" data-trigger="<?php echo $as['assembly_name']; ?>"  style="width:5%" title="Update Assembly">
													<div class="card-header">
														<h5 class="mb-0">
															<span class="fa fa-pencil text-white"></span>
												      	</h5>
													</div>
										        </a>
										        <a class="btn btn-sm btn-info" type="button" data-toggle="modal" data-target="#addItem"  data-trigger="<?php echo $as['assembly_id']; ?>" id='addItem_button' style="width:5%" title="Add Item">
													<div class="card-header" >
														<h5 class="mb-0">
															<span class="fa fa-plus text-white"></span>
												      	</h5>
													</div>
										        </a>
											</div>
										    <div id="collapseAssembly<?php echo $ass; ?>" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
										      	<div class="card-body">
										      		<div>
											      		<table class="table table-bordered table-hover">
											      			<tr>
											      				<th align="center" width="3%">#</th>
											      				<th>Item Desc</th>
											      				<th>PN</th>
											      				<th>UOM</th>
											      				<th>Qty</th>
											      				<th>Unit Price</th>
											      				<th width="10%"><center><span class="fa fa-bars"></span></center></th>
											      			</tr>
											      			<tbody>
											      			   <?php 
											      			   $ic=1;
											      			   foreach($items AS $i){ 
											      			   	if($en->engine_id == $i['engine_id'] && $as['assembly_id'] == $i['assembly_id']){ ?>
												      			<tr>
												      				<td align="center" width="3%"><?php echo $ic; ?></td>
												      				<td><?php echo $i['item']; ?></td>
												      				<td><?php echo $i['pn']; ?></td>
												      				<td><?php echo $i['uom']; ?></td>
												      				<td><?php echo $i['qty']; ?></td>
												      				<td><?php echo $i['unit_price']; ?></td>
												      				<td align="center">
												      					<a title="Update item" href="javascript:void(0)" class="btn btn-xs btn-info" onclick="updateItemAssem('<?php echo base_url(); ?>', '<?php echo $i['id']; ?>')" ><span class="fa fa-pencil"></span></a>
												      					<a onclick="return confirm('Are you sure you want to delete it?')" title="Remove Item" href="<?php echo base_url(); ?>index.php/assembly/deleteitem/<?php echo $i['id']; ?>" class="btn btn-xs btn-danger"><span class="fa fa-times"></span></a>
												      				</td>
												      			</tr>

												      		<?php 
												      			$ic++;
												      			}
												      		} ?>
												      		</tbody>
											      		</table>
										      		</div>
										      	</div>
										    </div>
										</div>		
										<?php
										$a++;
										$ass++;
											 } 
									 	} ?>									
										<!-- LOOP -->
							      	</div>
							    </div>
							</div>
						<?php 
						$e++;
						} ?>
							<!-- loop -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!--Add Modal -->
	<div class="modal fade" id="addEngine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Engine</h4>
				</div>
				<form method="POST" action = "<?php echo base_url(); ?>/index.php/assembly/insert_engine">
					<div class="modal-body">
							<label>Engine Name</label>
							<input type = "text" name = "engine_name" class = "form-control" autocomplete="off">
							
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary btn-block">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addAssembly" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Assembly</h4>
				</div>
				<form method="POST" action = "<?php echo base_url(); ?>/index.php/assembly/insert_assembly">
					<div class="modal-body">
						<label>Assembly Name</label>
						<input type = "text" name = "assembly_name" class = "form-control" autocomplete="off">
					</div>
					<div class="modal-footer"> 
						<input type = "hidden" name = "engine_id" id='engine_id' class = "form-control">
						<button type="submit" class="btn btn-info btn-block">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Item</h4>
				</div>
				<form method="POST" action = "<?php echo base_url(); ?>/index.php/assembly/insert_item">		
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-12">
								<label>Item Name</label>
								<input type = "text" name = "item_name" id="item_name" class = "form-control" autocomplete="off">
								<span id="suggestion-item"></span>
                                
								<label>Part Number</label>
								<input type = "text" name = "pn_no" id="pn_no" class = "form-control" style='pointer-events: none'>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<label>UOM</label>
								<input type = "text" name = "uom" id="uom" class = "form-control" style='pointer-events: none'>
							</div>
							<div class="col-lg-6">
								<label>Quantity</label>
								<input type = "Number" name = "qty" class = "form-control">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<input type="hidden" name="uom_id" id="uom_id" >
						<input type="hidden" name="item_id" id="item_id" >
						<input type = "hidden" name = "assembly_id" id='assembly_id' class = "form-control">
						<button type="submit" class="btn btn-info btn-block">Save changes</button>
					</div>
				</form>
			</div>
		</div>
	</div>


	<!-- Updates Modal -->

	<div class="modal fade" id="updateEngine" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Engine</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action = "<?php echo base_url(); ?>/index.php/assembly/edit_engine">
						<label>Engine Name</label>
						<input type = "text" name = "enginename" id="enginename" class = "form-control">
						<div class="modal-footer">
							<input type="hidden" name="engineid" id="engineid" >
							<button type="submit" class="btn btn-success btn-block">Save changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="updateAssembly" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Assembly</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action = "<?php echo base_url(); ?>/index.php/assembly/edit_assembly">
						<label>Assembly Name</label>
						<input type = "text" name = "assemblyname" id="assemblyname" class = "form-control">
						<div class="modal-footer">
							<input type="hidden" name="assemblyid" id="assemblyid" >
							<button type="submit" class="btn btn-info btn-block">Save changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="updateItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Item</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action = "">
						<label>Item Name</label>
						<input type = "text" name = "end_name" class = "form-control">
						<div class="modal-footer">
							<button type="submit" class="btn btn-info btn-block">Save changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>


	<!-- Delete MOdal -->

	<div class="modal fade" id="updateItem" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Delete Item</h4>
				</div>
				<div class="modal-body">
					<form method="POST" action = "">
					</form>
				</div>
			</div>
		</div>
	</div>