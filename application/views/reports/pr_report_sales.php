<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	#name-item{
		width: 94%!important;
	}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">PR Report (Sales)</li>
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
					<div class="panel-body">
						<div class="canvas-wrapper">
							<form method="POST" action ="<?php echo base_url();?>index.php/reports/generatePrDelivered">
								<div class="col-lg-3"> <h5 class="pull-right">Enter PR:</h5> </div>
								<div class="col-lg-5">
									<!-- <input type="text" name="pr" id="pr" class="form-control" autocomplete='off'>
									<span id="suggestion-pr"></span> -->
									<select name="pr" id='pr' class="form-control select2" style="margin:4px;width:100%">
										<option value = "">-Choose PR-</option>
										<?php foreach($pr_rep AS $p){ ?>
										<option value = "<?php echo $p->pr_no; ?>"><?php echo $p->pr_no; ?></option>
										<?php } ?>
									</select>
								</div>
								<div id='alrt' style="font-weight:bold"></div>
								<div class="col-lg-4"><input type="submit" class="btn btn-warning" id="submit" name="search_pr" Value="Find"></div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading" >
					<button class="btn btn-md btn-primary pull-right " onclick="printDiv('printableArea')">Print</button>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div id="printableArea">
							<?php foreach($head AS $h) { ?>
							<div style="padding:10px; margin-bottom: 20px;border-radius: 10px;box-shadow: 0px 0px 5px 2px #b9b9b9;border: 1px solid #b9b9b9;border: 1px solid #b9b9b9">								
								<table width="100%" class="table-borddered">
									
									<tr>
										<td width="15%"><p class="nomarg">Buyer:</p></td>
										<td width="40%"> <h5 class="nomarg"><?php echo $h['buyer_name']; ?></h5></td>
										<td width="10%"><p class="nomarg">DR No.:</p></td>
										<td ><h5 class="nomarg"><?php echo $h['dr_no']; ?></h5></td>
										
									</tr>
									<tr>
										<td><p class="nomarg">Contact Person:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['contact_person']; ?></h5></td>
										<td><p class="nomarg">Date:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['date']; ?></h5></td>
										
									</tr>
									<tr>
										<td><p class="nomarg">Contact Number:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['contact_no']; ?></h5></td>
										<td ><p class="nomarg">PO Date:</p></td>
										<td > <h5 class="nomarg"><?php echo $h['po_date']; ?></h5></td>
									</tr>
									<tr>
										<td><p class="nomarg">PR# / PO#:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['pr_no']; ?></h5></td>
										<td ><p class="nomarg">VAT:</p></td>
										<td > <h5 class="nomarg"><?php echo ($h['vat']==1) ? 'Vatable' : 'Non-Vatable'; ?></h5></td>
									</tr>
									<tr>
										<td><p class="nomarg">Sales PR No.:</p></td>
										<td> <h5 class="nomarg"><?php echo $h['sales_pr']; ?></h5></td>
									</tr>
								</table>
								<div class="row">
									<div class="col-lg-12">
										<table width="100%" class="table table-bordered " >
												<tr >
													<th class="tr-bottom" width="5%"><center>Item No.</center></th>
													<th class="tr-bottom" width="15%"><center>Part No.</center></th>
													<th class="tr-bottom" width="15%"><center>Description</center></th>

													<th class="tr-bottom" width="10%"><center>Serial No.</center></th>
													<th class="tr-bottom" width="5%"><center>Qty</center></th>
													<th class="tr-bottom" width="5%"><center>UOM</center></th>

													<th class="tr-bottom" width="10%"><center>Selling Price</center></th>
													<th class="tr-bottom" width="5%"><center>Discount</center></th>
													<th class="tr-bottom" width="20%"><center>Shipping Fee</center></th>
												</tr>
												<?php 
													$x=1;
													foreach($details AS $det){ 
														if($h['delivery_id'] == $det['delivery_id']) {
												?>
												<tr>
													<td><center><?php echo $x; ?></center></td>
													<td><?php echo $det['pn_no']; ?></td>
													<td><?php echo $det['item']; ?></td>
													<td><?php echo $det['serial']; ?></td>
													<td><?php echo $det['qty']; ?></td>
													<td><?php echo $det['unit']; ?></td>
													<td><center><?php echo $det['selling_price']; ?></center></td>
													<td><center><?php echo $det['discount']; ?></center></td>
													<td><?php echo $det['shipping_fee']; ?></td>
												</tr>	
												<?php } $x++; } ?>					
										</table>
									</div>
								</div>
							</div>
							<?php } ?>
							<table width="100%" id="prntby">
				                <tr>
				                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?></td>
				                </tr>
				            </table> 
						</div>
						<!-- end loop -->
					</div>
				</div>
			</div>
		</div>
	</div>