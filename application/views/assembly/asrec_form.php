<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Assembly Receive</li>
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
						<?php foreach($info AS $i) {?>
						<table  width="100%">
							<tr>
								<td width="10%"><h5 class="nomarg">Engine</h5></td>
								<td width="1%">:</td>
								<td width="39%"><h5 class="nomarg"><b><?php echo $i['engine_name']; ?></b></h5></td>
								<td width="10%"><h5 class="nomarg">Receive Date</h5></td>
								<td width="1">:</td>
								<td width="39%"><h5 class="nomarg"><b><?php echo $i['receive_date']; ?></b></h5></td>
							</tr>
							<tr>
								<td><h5 class="nomarg">Assembly</h5></td>
								<td>:</td>
								<td><h5 class="nomarg"><b><?php echo $i['assembly_name']; ?></b></h5></td>
								<td><h5 class="nomarg">Receipt No.</h5></td>
								<td>:</td>
								<td><h5 class="nomarg"><b><?php echo $i['receipt_no']; ?></b></h5></td>
							</tr>
						</table>
					<?php } ?>
						<br>
						<!-- <a href="<?php echo base_url();?>index.php/assembly/asrec_form_det/<?php echo $id; ?>" class="btn btn-warning btn-md">
							<span class="fa fa-plus"></span> Add Item
						</a> -->
						<br>
						<br>
						<div class="canvas-wrapper">
							<form method='POST' action='<?php echo base_url(); ?>/index.php/assembly/receive_details'>
							<table class="table table-bordered table-hover" >
								<thead>
									<tr>
										<th width="40%">Item Description</th>
										<th>PN No.</th>
										<th>Bank</th>
										<th>Exp. Qty</th>
										<th>Curr. Qty</th>
										<th width="15%">Qty Received</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$x=1;
									
									foreach($items AS $i){ ?>
									<tr>
										<td><?php echo $i['item_name']; ?></td>
										<td><?php echo $i['pn_no']; ?></td>
										<td><?php echo $i['bank_name']; ?></td>
										<td><?php echo $i['exp_qty']; ?></td>
										<td><?php echo $i['curr_qty']; ?></td>
										<td><input type="number" class="form-control nomarg" name="rec_qty<?php echo $x; ?>" max="<?php echo $i['exp_qty']; ?>"></td>
									</tr>
									<input type="hidden" class="form-control nomarg" name="inventory_id<?php echo $x; ?>" value="<?php echo $i['inv_id']; ?>">

								<?php

								$x++; 
								}	?>
								<input type='hidden' name='count' value="<?php echo $x; ?>">
								</tbody>
							</table>
							<input type="hidden" class="form-control nomarg" name="id" value="<?php echo $id; ?>">
							<input type="hidden" class="form-control nomarg" name="engine" value="<?php echo $engine; ?>">
							<input type="hidden" class="form-control nomarg" name="assembly" value="<?php echo $assembly; ?>">
							<center>
								<input type='submit' class="btn btn-primary btn-md btn-block" value="Save">
							</center>
						</form> 	
						</div>
					</div>
				</div>
			</div>
		</div>