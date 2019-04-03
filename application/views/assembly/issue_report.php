<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<style type="text/css">
	.issuename{
		margin-bottom: 0px;
		margin-top: 5px
	}
	.marg-cus{
		margin-top:150px 
	}
</style>
<div class="col-sm-12 col-lg-12 main">
	<div class="row" style="position: fixed;width: 100%;background: #fff" >
		<div class="col-lg-12">
			<div >
				<h2>
					<a href="<?php echo base_url(); ?>index.php/masterfile/home" class="btn btn-success" title="Back"><span class="fa fa-home"></span></a>
					<b> Issue Report </b>
					<div class="btn-group pull-right" >					
						<button class="btn btn-success" data-toggle="modal" data-target="#issueFilter" ><span class="fa fa-filter"> </span> Filter</button>
						<?php if(!empty($filter)){ ?>
						<a href = "<?php echo base_url(); ?>index.php/assembly/export_issuance/<?php echo $from;?>/<?php echo $to;?>/<?php echo $item_id;?>/<?php echo $transfer_to;?>/<?php echo $engine_from;?>/<?php echo $assembly_from;?>/<?php echo $engine_to;?>/<?php echo $assembly_to;?>" class="btn btn-success"><span class="fa fa-file-excel-o"> </span> Export To Excel</a>
						<?php } else { ?>
						<a href = "<?php echo base_url(); ?>index.php/assembly/export_issuance/" class="btn btn-success"><span class="fa fa-file-excel-o"> </span> Export To Excel</a>
						<?php } ?>
					</div>
				</h2>	
				<?php if(!empty($filter)){ ?>		
				<div class='alert alert-warning alert-shake'>
					<center>
						<strong>Filters applied:</strong>  <?php echo $filter; ?>
						<a href='<?php echo base_url(); ?>index.php/assembly/issue_report' class='btn alert-link'><span class="fa fa-times"></span></a>
					</center>
				</div>
			<?php } ?>
			</div>
		</div>
	</div>
	
	<!-- add class marg-cus when filter is applied -->
	<!-- add class marg-cus when filter is applied -->
	<!-- add class marg-cus when filter is applied -->
	<!-- add class marg-cus when filter is applied -->

	<div class="marg-cus" style="overflow-y: scroll;width: 150%;">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th width="3%">Issue Date</th>
					<th>Transfer To</th>
					<th>Engine From</th>
					<th>Assembly From</th>
					<th>Bank From</th>
					<th>Engine To</th>
					<th>Assembly To</th>
					<th>Bank To</th>
					<th>Department</th>
					<th width='15%'>Purpose</th>
					<th>Enduse</th>
					<th>Item Description</th>
					<th>Qty</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach($info AS $i){ ?>
				<tr>
					<td><?php echo $i['transfer_date']; ?></td>
					<td><?php echo $i['transfer_to']; ?></td>
					<td><?php echo $i['engine_from']; ?></td>
					<td><?php echo $i['assembly_from']; ?></td>
					<td><?php echo $i['bank_from']; ?></td>
					<td><?php echo $i['engine_to']; ?></td>
					<td><?php echo $i['assembly_to']; ?></td>
					<td><?php echo $i['bank_to']; ?></td>
					<td><?php echo $i['department']; ?></td>
					<td><?php echo $i['purpose']; ?></td>
					<td><?php echo $i['enduse']; ?></td>
					<td><?php echo $i['item_name']; ?></td>
					<td><?php echo $i['transfer_qty']; ?></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
	</div>
	
	<!-- <div class="row">
		<div class="col-md-12">				
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					DEPARTMENT LIST
					<div class="pull-right">
						<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#myModal">
							<span class="fa fa-plus"></span>
						</a>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div style="overflow-y: scroll;width: 2000px">
							<table class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Issue Date</th>
										<th>Transfer To</th>
										<th>Engine From</th>
										<th>Assembly From</th>
										<th>Bank From</th>
										<th>Engine To</th>
										<th>Assembly To</th>
										<th>Bank To</th>
										<th>Department</th>
										<th>Purpose</th>
										<th>Enduse</th>
										<th>Item Description</th>
										<th>Qty</th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td>12/20/10</td>
										<td>Lorem Ipsum</td>
										<td>Lorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem Ipsum</td>
										<td>Lorem Ipsum Lorem Ipsum</td>
										<td>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</td>
										<td>Lorem IpsumLorem IpsumLorem IpsumLorem Ipsum</td>
									</tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div> -->

	<!-- ----------------------MODAL------------------------- -->
	<!-- Modal -->
	<div class="modal fade" id="issueFilter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Filter</h4>
				</div>
				<form method="POST" action = "<?php echo base_url();?>index.php/assembly/filter_issue">
					<div class="modal-body">
						<div class="row">
							<div class = "col-lg-6">
								<p class="issuename">Issue From:</p>
								<input type = "date" name = "from" class = "form-control bor-radius">
							</div>
							<div class = "col-lg-6">
								<p class="issuename">Issue To:</p>
								<input type = "date" name = "to" class = "form-control bor-radius">
							</div>
						</div>
						<p class="issuename">Item Decription:</p>
						<input type = "text" name = "item_name" id="item_name" class = "form-control bor-radius" autocomplete="off">
						<span id="suggestion-item"></span>
						<input type = "hidden" name = "item_id" id='item_id' class = "form-control bor-radius">
						<p class="issuename">Transfer To:</p>
						<select name='transfer_to' class = "form-control bor-radius">
							<option value='' selected>-Select-</option>
							<?php foreach($location AS $lc) { ?>
								<option value="<?php echo $lc->al_id; ?>"><?php echo $lc->location_name; ?></option>
							<?php } ?>
						</select>
						
						<div class="row">
							<div class="col-lg-6">
								<p class="issuename">Engine From:</p>
								<select name='engine_from' class = "form-control bor-radius">
								<option value='' selected>-Select-</option>
								<?php foreach($engine AS $en) { ?>
									<option value="<?php echo $en->engine_id; ?>"><?php echo $en->engine_name; ?></option>
								<?php } ?>
							</select>
							</div>
							<div class="col-lg-6">
								<p class="issuename">Engine To:</p>
								<select name='engine_to' class = "form-control bor-radius">
								<option value='' selected>-Select-</option>
								<?php foreach($engine AS $en) { ?>
									<option value="<?php echo $en->engine_id; ?>"><?php echo $en->engine_name; ?></option>
								<?php } ?>
							</select>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-6">
								<p class="issuename">Assembly From:</p>
								<select name='assembly_from' class = "form-control bor-radius">
								<option value='' selected>-Select-</option>
								<?php foreach($assembly AS $as) { ?>
									<option value="<?php echo $as->assembly_id; ?>"><?php echo $as->assembly_name; ?></option>
								<?php } ?>
							</select>
							</div>
							<div class="col-lg-6">
								<p class="issuename">Assembly To:</p>
								<select name='assembly_to' class = "form-control bor-radius">
								<option value='' selected>-Select-</option>
								<?php foreach($assembly AS $as) { ?>
									<option value="<?php echo $as->assembly_id; ?>"><?php echo $as->assembly_name; ?></option>
								<?php } ?>
							</select>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-info btn-block"><span class="fa fa-filter"></span> Filter</button>
					</div>
				</form>
			</div>
		</div>
	</div>