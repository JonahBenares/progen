<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
<style type="text/css">
	body{
		padding:0px;
	}
	#item-check{	
	color:red;
	font-style: italic;
	}
	.img-check{	
		color:red;
		font-style: italic;
	}
	.remove_filter{
		color:red; 
		font-size:10px; 
		font-style:italic;
	}

	#name-item{
	        float:left;
	        list-style:none;
	        margin-top:-3px;
	        padding:0;
	        width:93%;
	        position: absolute;
	        z-index:100;
	    }
	#name-item li:hover {
	    cursor: pointer;
	    font-weight: bold;
	    color: black;
	    text-transform: uppercase;
	    background-position: right center;      
	    box-shadow: 0px 1px 20px 0px #ff8900;
	}
	#name-item li {
	    padding:5px 10px 5px 10px;
	    background-image: linear-gradient(to right, #fbb39e 10%, #fff1c4 50%, #fbb39e 100%);
	    border-bottom: #a88748 2px solid;
	    border-radius: 5px;
	    transition: 0.5s;   
	    background-size: 200% auto;
	}

</style>

<div class="col-sm-12 col-md-12 col-lg-12 main">
	<div class="row">
		<div class="col-lg-12">
			<br>
		</div>
	</div><!--/.row-->
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					Add New PR/JO
					<div class="pull-right">
						<a class="clickable btn-info btn panel-button-tab-right shadow"  href="<?php echo base_url(); ?>index.php/items/add_item_first" target='_blank'>
							<span class="fa fa-plus"></span> Add New Item
						</a>
					</div>
				</div>
				<div class="panel-body">
					<form id='PRform'>
					<div class="canvas-wrapper">
						<div class="row">
							<?php if(!isset($rdid)) { ?>
							<div class="col-lg-2 col-lg-offset-1">
								<h5>PR/JO#: <input type="text" name="prno" id='prno' class="form-control" autocomplete="off">
									<span id="suggestion-prno"></span></h5>
							</div>
							<div class="col-lg-2">
								<h5>Department: 
									<select name="department" id='department' class="form-control">
										<option value = ""></option>
										<?php foreach($department AS $dep){ ?>
										<option value = "<?php echo $dep->department_id;?>"><?php echo $dep->department_name;?></option>
										<?php } ?>
									</select>
								</h5>
							</div>


							<div class="col-lg-2">
								<h5>End-Use: 
									<select name="enduse" id='enduse' class="form-control">
										<option value = ""></option>
										<?php foreach($enduse AS $end){ ?>
										<option value = "<?php echo $end->enduse_id;?>"><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
								</h5>
							</div>	

								<div class="col-lg-2">
								<h5>Purpose: 
									<select name="purpose" id='purpose' class="form-control">
										<option value = ""></option>
										<?php foreach($purpose AS $pur){ ?>
										<option value = "<?php echo $pur->purpose_id;?>"><?php echo $pur->purpose_desc;?></option>
										<?php } ?>
									</select>

							
								</h5>
							</div>	
							
							<div class="col-lg-2">
									<h5>Inspected By:
									<select class="form-control" name='inspected' id='inspected'>
										<option value = ''></option>
										<?php foreach($employee AS $emp){ ?>
										<option value = "<?php echo $emp['empid'];?>"><?php echo $emp['empname'];?></option>
										<?php } ?>
									</select>
									</h5>
								</div>	
						
							<input type="hidden" name="rdid" id='rdid' value='0'>
							<?php } else { 
								foreach($details AS $det) { ?>

								<div class="col-lg-3">
									<h5>PR#:
									<input type="text" name="prno" id='prno' value='<?php echo $det['prno']; ?>' class="form-control"></h5>
								</div>
								<div class="col-lg-3">
									<h5>Department: 
										<select name="department" id='department' class="form-control">
											<option value = ""></option>
											<?php foreach($department AS $dep){ ?>
											<option value = "<?php echo $dep->department_id;?>" <?php echo (($det['department_id'] == $dep->department_id) ? ' selected' : '');?>><?php echo $dep->department_name;?></option>
											<?php } ?>
										</select>
									</h5>
								</div>	
								<div class="col-lg-3">
									<h5>End-Use: 
									<select name="enduse" id='enduse' class="form-control">
										<option value = ""></option>
										<?php foreach($enduse AS $end){ ?>
										<option value = "<?php echo $end->enduse_id;?>" <?php echo (($det['enduse_id'] == $end->enduse_id) ? ' selected' : '');?>><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
									</h5>
								</div>	
								<div class="col-lg-3">
									<h5>Purpose: 
									<select name="purpose" id="purpose" class="form-control">
										<option value = ""></option>
										<?php foreach($purpose AS $pur){ ?>
										<option value = "<?php echo $pur->purpose_id;?>" <?php echo (($det['purpose_id'] == $pur->purpose_id) ? ' selected' : '');?>><?php echo $pur->purpose_desc;?></option>
										<?php } ?>
									</select>
									</h5>
								</div>	
								
								<input type="text" name="rdid" id='rdid' value='<?php echo $rdid; ?>'>
							<?php 
								}
							} ?>
							
						</div>
					
						<div style="background-color: #fbecd0; padding: 15px;border-radius: 10px; box-shadow: inset 0px 0px 5px 1px #c7c4c4;">
							<div class="row" >
								<div class="col-lg-6">
									<p style="margin:0px" for="">Supplier:</p>
									<input class="form-control" name="supplier" id="supplier" autocomplete="off">
									<span id="suggestion-supplier"></span>
									<input type='hidden' name='supplier_id' id='supplier_id'>
								</div>								
								<div class="col-lg-2">
									<p  style="margin:0px" for="">Brand:</p>
									<input type class="form-control" name='brand' id='brand' autocomplete="off">
									<span id="suggestion-brand"></span>
									<input type='hidden' name='brand_id' id='brand_id'>
								</div>	
								<div class="col-lg-2">
									<p style="margin:0px" for="">Catalog No.:</p>
									<input type="text" name="catalog_no" id="catalog_no" class="form-control">
								</div>
								<div class="col-lg-2">
									<p style="margin:0px" for="">NKK No.:</p>
									<input type="text" name="nkk_no" id="nkk_no" class="form-control">
								</div>
																					
							</div>
							<div class="row" >
								<div class="col-lg-6">
									<p style="margin:0px" for="">Item Description:</p>
									<textarea name = "item" id = "item" class="form-control" rows="1" autocomplete="off"></textarea>
									 <span id="suggestion-item"></span>
									 <input type='hidden' name='item_id' id='item_id'>
									 <input type='hidden' name='original_pn' id='original_pn1'>
									 <input type='hidden' name='unit' id='unit'>
								</div>
								<div class="col-lg-2">
									<p style="margin:0px" for="">SEMT No.:</p>
									<input type="text" name="semt_no" id="semt_no" class="form-control">
								</div>
								<div class="col-lg-2">
									<p style="margin:0px" for="">Serial No. :</p>
									<input type="text" name="serial" id="serial" class="form-control">
									<span id="suggestion-serial"></span>
									<input type='hidden' name='serial_id' id='serial_id'>
								</div>
								<div class="col-lg-2">
									<p style="margin:0px" for="">Unit Cost:</p>
									<input type="text" name="unit_cost" id="unit_cost" class="form-control">
								</div>		
																							
							</div>
							<div class="row">
								<div class="col-lg-6">
									<p  style="margin:0px" for="">Remarks:</p>
									<textarea class="form-control" rows="1" name='remarks' id='remarks'></textarea>
								</div>
								<div class="col-lg-2">
									<p style="margin:0px"  for="">Expected Qty:</p>
									<input class="form-control" name='exp_qty' id='exp_qty' onkeypress="return isNumberKey(this, event)" >
								</div>
								<div class="col-lg-2">
									<p  style="margin:0px" for="">Delivered/ Received:</p>
									<input class="form-control" name='rec_qty' id='rec_qty' onkeypress="return isNumberKey(this, event)" >
								</div>
								<div class="col-lg-1">
									<!-- <p  style="margin:0px" for="">Local:</p>
									<input type = "radio" name='local_mnl' id='local_mnl' value = "1">
									<p style="margin:0px" for="">Manila:</p>
									<input type = "radio" name='local_mnl1' id='local_mnl' value = "2"> -->
									<!-- <input type="radio" name="local_mnl" value="1" id = "local_mnl">Local
									<input type="radio" name="local_mnl1" value="2" id = "local_mnl1">Manila -->
									<input type="radio" name="local_mnl" id = 'local' value="1"> Local<br>
  									<input type="radio" name="local_mnl" id = 'manila' value="2"> Manila<br>
								</div>
								
								<!-- <div class="col-lg-2">
									<p style="margin:0px" for="">Inspected By:</p>
									<select class="form-control" name='inspected' id='inspected'>
										<option value = ''></option>
										<?php foreach($employee AS $emp){ ?>
										<option value = "<?php echo $emp['empid'];?>"><?php echo $emp['empname'];?></option>
										<?php } ?>
									</select>
								</div>	
								 -->
								<div class="col-lg-1">
									<br>
									<a class="btn btn-primary btn-outlined btn-md" style="margin-top:5px" onclick='add_item()'><span class="fa fa-plus"></span></a>
								</div>
							</div>	
						</div>
						<br>
						<div style="overflow-y: scroll;position: relative;">
							<table width="100%"  class="table table-bordered " style="font-size: 14px">
								<tr>
									<th class="tr-bottom" width="5%"><center>Item No.</center></th>
									<th class="tr-bottom" width="20%"><center>Supplier</center></th>
									<th class="tr-bottom" width="15%"><center>Description</center></th>
									<th class="tr-bottom" width="10%"><center>Brand</center></th>
									<th class="tr-bottom" width="10%"><center>Cat No.</center></th>
									<th class="tr-bottom" width="10%"><center>NKK No.</center></th>
									<th class="tr-bottom" width="10%"><center>SEMT No.</center></th>
									<th class="tr-bottom" width="10%"><center>Serial No.</center></th>
									<th class="tr-bottom" width="5%"><center>Unit Cost</center></th>
									<th class="tr-bottom" width="5%"><center>Total Cost</center></th>
									<th class="tr-bottom" width="10%"><center>Expt Qty</center></th>
									<th class="tr-bottom" width="10%"><center>Del/Rec</center></th>
									<!-- <th class="tr-bottom" width="10%"><center>Inspected By</center></th> -->
									<th class="tr-bottom" width="5%"><center>UOM</center></th>
									<th class="tr-bottom" width="15%"><center>Remarks</center></th>
									<th class="tr-bottom" width="15%"><center>Loc</center></th>
									<th class="tr-bottom" width="5%"><center>Action</center></th>
								</tr>
								<?php 
								if(isset($rdid)){
									$count= count($receive_items); ?>
									<tbody id="item_body">
									<?php if($count==0) { ?>
										<tr><td colspan='8'><center>No items added.</center></td></tr>
									<?php } else { 
										$x=1;
										foreach($receive_items AS $ri) { ?>
										<tr>
											<td><center><?php echo $x; ?></center></td>
											<td><center><?php echo $ri['supplier']; ?></center></td>
											<td><center><?php echo $ri['item']; ?></center></td>
											<td><center><?php echo $ri['brand']; ?></center></td>
											<td><center><?php echo $ri['catalog_no']; ?></center></td>
											<td><center><?php echo $ri['nkk_no']; ?></center></td>
											<td><center><?php echo $ri['semt_no']; ?></center></td>
											<td><center><?php echo $ri['serial']; ?></center></td>
											<td><center><?php echo $ri['unit_cost']; ?></center></td>
											<td><center><?php echo $ri['total']; ?></center></td>
											<td><center><?php echo $ri['expqty']; ?></center></td>
											<td><center><?php echo $ri['recqty']; ?></center></td>
											<!-- <td><center><?php //echo $ri['inspected']; ?></center></td> -->
											<td><center><?php echo $ri['unit']; ?></center></td>
											<td><center><?php echo $ri['remarks']; ?></center></td>
											<td><center><?php echo $ri['local_mnl']; ?></center></td>
											<td><center> <a class="btn btn-danger table-remove btn-xs" onclick="removerecitem('<?php echo $ri['riid']; ?>','<?php echo base_url(); ?>')"><span class=" fa fa-times"></span></a></center></td>
										</tr>
									<?php $x++; } 
										}	 ?>
									
									</tbody>
								<?php
								} else { ?>
									<tbody id="item_body"></tbody>
								<?php } ?>
							</table>
						</div>
						<input type='hidden' name='receiveid' id='receiveid' value='<?php echo $receiveid; ?>'>
						<input type='hidden' name='counter' id='counter'>
						<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
						<input type='button' class="btn btn-md btn-warning" id='savebutton' onclick='savereceive_PR()' style="width:100%;background: #ff5d00" value='Save'>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>


	