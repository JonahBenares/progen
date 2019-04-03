<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Assembly Transfer View</li>
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
						ASSEMBLY TRANSFER VIEW
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<?php foreach($head AS $h){ ?>
							<table>
								<tr>
									<td width="9%"><h5>Department:</h5></td>
									<td width="25%" style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $h['department']; ?></b></h5></td>
									<td width="1%"></td>
									<td width="7%"><h5>Purpose:</h5></td>
									<td width="1%"></td>
									<td width="25%" style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $h['purpose']; ?></b></h5></td>
									<td width="1%"></td>
									<td width="5%"><h5>Enduse:</h5></td>
									<td width="1%"></td>
									<td width="24%" style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $h['enduse']; ?></b></h5></td>
								</tr>
								<tr>
									<td><h5>Transfer to:</h5></td>
									<td style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $h['transfer_to']; ?></b></h5></td>
									<?php if($h['transfer_id'] == '4'){ ?>
									<td></td>
									<td><h5>Engine(to):</td>
									<td></td>
									<td  style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $h['engine_to']; ?></b></h5></td>
									<td></td>
									<td><h5>Assembly (to):</h5></td>
									<td></td>
									<td style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $h['assembly_to']; ?></b></h5></td>
									<td></td>
									<?php } ?>
								</tr>
							</table>
							<br>
							<table width="100%" >
								<tr>
									<td></td>
									<td><h5><b>Engine (from):</b></h5></td>
									<td></td>
									<td><h5><b>Assembly (from):</b></h5></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td width="9%"></td>
									<td width="40%"  style="border-bottom:1px solid #aeaeae"><?php echo $h['engine_from']; ?></td>
									<td width="2%"></td>
									<td width="40%"  style="border-bottom:1px solid #aeaeae"><?php echo $h['assembly_from']; ?></td>
									<td width="9%"></td>
								</tr>
							</table>
							<?php } ?>
							<br>
						
							<table class="table table-bordered table-hover" id="item_table" >
								<thead>
									<tr>
										<th width="30%">Item Description</th>
										<th width="10%">Bank Origin</th>
										<th width="8%">Transfer Qty</th>
										<?php if($h['transfer_id'] == '4'){ ?>
										<th width="15%">Transfer Bank</th>
										<?php } else { ?>
											<th width="15%">Location to</th>
										<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php foreach($details AS $det){ ?>
									<tr>
										<td><?php echo $det['item_name']; ?></td>
										<td><?php echo $det['bank_from']; ?></td>
										<td><?php echo $det['transfer_qty']; ?></td>
										<?php if($h['transfer_id'] == '4'){ ?>
											<td><?php echo $det['bank_to']; ?></td>
										<?php } else { ?>
											<td><?php echo $det['location_to']; ?></td>
										<?php } ?>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>