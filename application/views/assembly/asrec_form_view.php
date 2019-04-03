<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Receive Details</li>
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
						
							<table class="table table-bordered table-hover" >
								<thead>
									<tr>
										<th width="40%">Item Description</th>
										<th>PN No.</th>
										<th>Bank</th>
										<th width="15%">Qty Received</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									$x=1;
									if(!empty($items)){
									foreach($items AS $i){ ?>
									<tr>
										<td><?php echo $i['item_name']; ?></td>
										<td><?php echo $i['pn_no']; ?></td>
										<td><?php echo $i['bank_name']; ?></td>
										<td><?php echo $i['rec_qty']; ?></td>
									</tr>
								
								<?php

								$x++; } 
							} else { ?>
								<tr>
										<td colspan='4'><center>No data available.</center></td>
									</tr>
							<?php } ?>
								
								</tbody>
							</table>
						
					
						</div>
					</div>
				</div>
			</div>
		</div>