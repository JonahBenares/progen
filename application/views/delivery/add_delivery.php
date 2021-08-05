<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/delivery.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class=""><a href="<?php echo base_url(); ?>index.php/request/request_list">Deliver </a></li>
			<li class="active"> Add Delivery</li>
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
				<div class="panel-heading" style="height:20px">
				</div>
				<div class="panel-body">
					<?php foreach($heads AS $h){ ?>
					<form id='Buyerfrm' method = "POST">
					<div class="canvas-wrapper">
						<table width="100%" class="table-bordersded">
							<tr>
								<td width="12%"><p class="nomarg">Buyer:</p></td>
								<td width="40%"><label class="labelStyle"><?php echo $h['buyer_name']; ?></label></td>
								<td width="7%"><p class="nomarg pull-right">DR No:</p></td>
								<td width="30%" colspan="4"><label class="labelStyle">&nbsp <?php echo $h['dr_no']; ?></label></td>
								
							</tr>
							<tr>
								<td><p class="nomarg">Address:</p></td>
								<td > <h5 class="nomarg"><?php echo $h['address']; ?></h5></td>
								<td><p class="nomarg pull-right">Date:</p></td>
								<td><h5 class="nomarg">&nbsp <?php echo $h['date']; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">Contact Person:</p></td>
								<td> <h5 class="nomarg"><?php echo $h['contact_person']; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">Contact No:</p></td>
								<td> <h5 class="nomarg"><?php echo $h['contact_no']; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">Source PR No.:</p></td>
								<td> <h5 class="nomarg"><?php echo $h['pr_no']; ?></h5></td>
								<td><p class="nomarg pull-right">PR/ PO Date:</p></td>
								<td colspan="4"><h5 class="nomarg">&nbsp<?php echo $h['po_date']; ?></h5></td>
							</tr>
							<tr>
								<td><p class="nomarg">PGC PR No/ PO No:</p></td>
								<td> <h5 class="nomarg"><?php echo $h['sales_pr']; ?></h5></td>
								<td><p class="nomarg pull-right">VAT:</p></td>
								<td colspan="4"><h5 class="nomarg"><?php echo ($h['vat']==1) ? 'Vatable' : 'Non-Vatable'; ?></h5></td>
							</tr>
						</table>
						<hr>
						<div class="row">
							<div class="col-lg-2">
								<p>
									Item
									<select name="item" id='item' class="form-control select2" onchange="chooseItem()">
										<option value = "">--Select Item--</option>
										<?php foreach($item_list AS $itm){ ?>
										<option value = "<?php echo $itm->item_id;?>"><?php echo $itm->original_pn." - ".$itm->item_name;?></option>
										<?php } ?>
									</select>
									<input type='hidden' name='item_id' id='item_id'>
									<input type='hidden' name='item_name' id='item_name'>
									<input type='hidden' name='original_pn' id='original_pn'>
									<input type='hidden' name='unit' id='unit'>
									<input type='hidden' name='invqty' id='invqty'>
									<input type='hidden' name='reqpr' id='reqpr' value='<?php echo $h['pr_no']; ?>'>
								</p>
							</div>
							<div class="col-lg-2">
								<p>				
									<br>
									<span id='crossreference_list'>Please choose item.</span>
									<input type="hidden" name="unit_cost" id="unit_cost" >
								</p>
							</div>
							<div class="col-lg-1">
								Serial #
								<input type="text" class="form-control" name="serial" id="serial" placeholder="Serial No." style="width:100%">
							</div>
							<div class="col-lg-1">	
								Quantity						
								<input type="text" class="form-control" name="qty" id="qty" placeholder="Quantity" style="width:100%">
								<input type='hidden' name='maxqty' id = "maxqty">
							</div>
							<div class="col-lg-2">
								Selling Price
								<input type="text" class="form-control" name="selling" id="selling" placeholder="Selling Price" style="width:100%">
							</div>
							<div class="col-lg-1">
								Discount
								<input type="text" class="form-control" name="discount" id="discount" placeholder="Discount" style="width:100%">
							</div>
							<div class="col-lg-2">
								Shipping Fee
								<input type="text" class="form-control" name="shipping" id="shipping" placeholder="Shipping Fee" style="width:100%">
							</div>
							<br>
							<div class="col-lg-1">
								<div id='alrt' style="font-weight:bold"></div>
								<p>				
									<a type="button" onclick='add_item()' id = "submit" class="btn btn-warning btn-md"><span class="fa fa-plus"></span></a>
								</p>
							</div>
							<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
						</div>
						<div class="row">
							<div class="col-lg-12">
								<table class="table table-bordered table-hover">
									<tr>
										<th style='text-align: center;'>#</th>
										<th style='text-align: center;'>Part No.</th>
										<th style='text-align: center;'>Item Description</th>
										<th style='text-align: center;'>Cross Reference</th>
										<th style='text-align: center;'>Serial No.</th>
										<th style='text-align: center;'>Qty</th>
										<th style='text-align: center;'>UOM</th>
										<th style='text-align: center;'>Selling Price</th>
										<th style='text-align: center;'>Discount</th>
										<th style='text-align: center;'>Shipping Fee</th>
										<th style='text-align: center;'>Total Cost</th>
										<th style='text-align: center;' width="1%"><span class="fa fa-bars"></span></th>
									</tr>
									<?php 
										if(!isset($details)){
									?>
									<tbody id="item_body"></tbody>
									<?php } else { ?>
									<tbody id="item_body">
										<?php
											$x=1; 
											foreach($details AS $det) { 
										?>	
										<tr>
											<td><center><?php echo $x; ?></center></td>
											<td><center><?php echo $det['pn_no'];?></center></td>
											<td><center><?php echo $det['item_name'];?></center></td>
											<td><center><?php echo $det['cross']; ?></center></td>
											<td><center><?php echo $det['serial_no'];; ?></center></td>
											<td><center><?php echo $det['qty'];; ?></center></td>
											<td><center><?php echo $det['unit'];; ?></center></td>
											<td><center><?php echo $det['selling_price'];; ?></center></td>
											<td><center><?php echo $det['discount'];; ?></center></td>
											<td><center><?php echo $det['shipping_fee'];; ?></center></td>
											<td><center><?php echo $det['total'];; ?></center></td>
											<td><center></center></td>
										</tr>
										<?php $x++; } ?>
									</tbody>
									<?php } ?>
								</table>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<input type='hidden' name='delivery_id' id='delivery_id' value='<?php echo $id; ?>'>
								<input type='hidden' name='counter' id='counter'>
								<input type='hidden' name='total' id='total'>
								<center><div id='alt' style="font-weight:bold"></div></center>
								<?php if($h['saved']==0){ ?>
								<input type='button' class="btn btn-md btn-warning" id='savebutton' onclick='saveBuyer()' style="width:100%;background: #ff5d00" value='Save and Print'>
								<?php } ?>
							</div>
							</form>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<script>
    $('.select2').select2();
</script>