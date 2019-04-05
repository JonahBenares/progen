<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/restock.js"></script>
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
					Add New Restock
					<div class="pull-right">
						<!-- <a class="clickable btn-info btn panel-button-tab-right shadow"  href="<?php echo base_url(); ?>index.php/items/add_item_first" target='_blank'>
							<span class="fa fa-plus"></span> Add New Item
						</a> -->
					</div>
				</div>
				<div class="panel-body">
					<form id='Restock'>
					<div class="canvas-wrapper">
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
									<p style="margin:0px" for="">Quantity:</p>
									<input type="text" name="quantity" id="quantity" class="form-control" onkeypress="return isNumberKey(event)">
								</div>									
								<div class="col-lg-2">
									<p style="margin:0px" for="">Serial No. :</p>
									<input type="text" name="serial" id="serial" class="form-control">
									<span id="suggestion-serial"></span>
									<input type='hidden' name='serial_id' id='serial_id'>
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
									<p style="margin:0px" for="">Catalog No.:</p>
									<input type="text" name="catalog_no" id="catalog_no" class="form-control">
								</div>
								<div class="col-lg-2">
									<p style="margin:0px" for="">NKK No.:</p>
									<input type="text" name="nkk_no" id="nkk_no" class="form-control">
								</div>
								<div class="col-lg-2">
									<p style="margin:0px" for="">SEMT No.:</p>
									<input type="text" name="semt_no" id="semt_no" class="form-control">
								</div>								
																						
							</div>
							<div class="row">
								<div class="col-lg-6">
									<p  style="margin:0px" for="">Remarks:</p>
									<textarea class="form-control" rows="1" name='remarks' id='remarks'></textarea>
								</div>
								<div class="col-lg-4">
									<p  style="margin:0px" for="">Reason:</p>
									<textarea class="form-control" rows="1" name='reason' id='reason'></textarea>
									<span id="suggestion-reason"></span></td>
								</div>
								<div class="col-lg-1">
									<br>
									<a class="btn btn-primary btn-outlined btn-md" style="margin-top:5px" onclick='add_item()'><span class="fa fa-plus"></span></a>
								</div>
							</div>	
						</div>
						<br>
						<table width="100%"  class="table table-bordered " style="font-size: 14px">
							<tr>
								<th class="tr-bottom" width="5%"><center>Item No.</center></th>
								<th class="tr-bottom" width="20%"><center>Quantity</center></th>
								<th class="tr-bottom" width="20%"><center>Supplier</center></th>
								<th class="tr-bottom" width="15%"><center>Description</center></th>
								<th class="tr-bottom" width="10%"><center>Brand</center></th>
								<th class="tr-bottom" width="10%"><center>Cat No.</center></th>
								<th class="tr-bottom" width="10%"><center>NKK No.</center></th>
								<th class="tr-bottom" width="10%"><center>SEMT No.</center></th>
								<th class="tr-bottom" width="10%"><center>Serial No.</center></th>
								<th class="tr-bottom" width="5%"><center>Reason</center></th>
								<th class="tr-bottom" width="15%"><center>Remarks</center></th>
								<th class="tr-bottom" width="5%"><center>Action</center></th>
							</tr>
							<?php 
								if(isset($rdetails_id)){
								$count= count($details); 
							?>
								<tbody id="item_body">
									<?php if($count==0) { ?>
										<tr><td colspan='8'><center>No items added.</center></td></tr>
									<?php } else { 
										$x=1;
										foreach($details AS $ri) { ?>
										<tr>
											<td><center><?php echo $x; ?></center></td>
											<td><center><?php echo $ri['qty']; ?></center></td>
											<td><center><?php echo $ri['supplier']; ?></center></td>
											<td><center><?php echo $ri['item']; ?></center></td>
											<td><center><?php echo $ri['brand']; ?></center></td>
											<td><center><?php echo $ri['catalog_no']; ?></center></td>
											<td><center><?php echo $ri['nkk_no']; ?></center></td>
											<td><center><?php echo $ri['semt_no']; ?></center></td>
											<td><center><?php echo $ri['serial']; ?></center></td>
											<td><center><?php echo $ri['reason']; ?></center></td>
											<td><center><?php echo $ri['remarks']; ?></center></td>
											<td><center> <a class="btn btn-danger table-remove btn-xs" onclick="removeresitem('<?php echo $ri['rdetails_id']; ?>','<?php echo base_url(); ?>')"><span class=" fa fa-times"></span></a></center></td>
										</tr>
									<?php $x++; } } ?>
								</tbody>
							<?php } else { ?>
								<tbody id="item_body"></tbody>
							<?php } ?>
						</table>
						<input type='hidden' name='rhead_id' id='rhead_id' value='<?php echo $rhead_id; ?>'>
						<input type='hidden' name='counter' id='counter'>
						<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
						<input type="hidden" name="userid" id="userid" value="<?php echo $_SESSION['user_id']; ?>">
						<input type='button' class="btn btn-md btn-warning" id='savebutton' onclick='saveRestock()' style="width:100%;background: #ff5d00" value='Save'>
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">
		function removeresitem(rdetails_id,baseurl){
		    var redirect = baseurl+'index.php/restock/deleteResItem';
		    var result = confirm("Are you sure you want to delete this item?");
		    if (result) {
		        $.ajax({
		                type: "POST",
		                url: redirect,
		                data: 'rdetails_id='+rdetails_id,
		                success: function(output){
		                    alert('Item successfully deleted.');
		                    location.reload();
		                }
		          });
		    }
		}
	</script>


	