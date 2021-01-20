<!-- <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/item.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<style type="text/css">
	.label-info {
    background-color: #5bc0de;
}
</style>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
<div class="row">
	<ol class="breadcrumb">
		<li><a href="#">
			<em class="fa fa-home"></em>
		</a></li>
		<li class="active">Sales</li>
	</ol>
</div><!--/.row-->
<div class="row">
	<div class="col-lg-12">
		<br>
	</div>
</div><!--/.row-->
<!-- Modal -->		
<div id="loader">
  	<figure class="one"></figure>
  	<figure class="two">loading</figure>
</div>
<di id="itemslist" style="display: none">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default shadow">
				<div class="panel-heading">
					SALES
					<div class="pull-right">
						<!-- <a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#search">
							<span class="fa fa-search"></span>
						</a> -->
						<a class="clickable panel-toggle panel-button-tab-right shadow"   data-toggle="modal" data-target="#deliverModal">
							<span class="fa fa-plus"></span></span>
						</a>
					</div>
				</div>
				<div class="modal fade" id="updatePR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header modal-headback">
								<h4 class="modal-title" id="myModalLabel">Update Delivery
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</h4>															
							</div>
							<form method="POST" action = "<?php echo base_url(); ?>/index.php/delivery/update_purend">
								<div class="modal-body">
									<div id = 'ep'></div>
								</div>
								<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
								<div class="modal-footer">
									<button type="submit" class="btn btn-primary btn-block">Save changes</button>
								</div>
							</form>
						</div>
					</div>
				</div>
				<div class="panel-body">
					<div class="canvas-wrapper">
						<div class="row" style="padding:0px 10px 0px 10px">
							<!-- <?php 
								if(!empty($_POST)){
								
									?> -->
									
									<div class='alert alert-warning alert-shake'>
										<center>
											<strong>Filters applied:</strong> <!-- <?php echo  $filter; ?> -->.
											<a href='<?php echo base_url(); ?>index.php/delivery/delivery_list' class='remove_filter alert-link'>Remove Filters</a>. 
										</center>
									</div>
							<!-- <?php  }?> -->
						</div>
						<table class="table-bordered table-hover" id="received" width="100%" style="font-size: 15px">
							<thead>
								<tr>
									<td align="center"><strong>DR Date</strong></td>
									<td align="center"><strong>DR No.</strong></td>
									<td align="center"><strong>Buyer</strong></td>
									<td align="center"><strong>Address</strong></td>
									<td align="center"><strong>Shipped Via</strong></td>
									<td width="20%" align="center"><strong>Waybill No.</strong></td>									
									<td width="20%" align="center"><strong>PR# / PO#</strong></td>									
									<td width="5%" align="center" ><strong>Action</strong></td>
								</tr>
							</thead>
							<tbody>
								<?php if(!empty($heads)){ foreach($heads AS $h){ ?>
								<tr>
									<td style="padding:3px" align="center"><?php echo $h['date'];?></td>
									<td style="padding:3px" align="center"><?php echo $h['dr_no'];?></td>
									<td style="padding:3px" align="center"><?php echo $h['buyer_name'];?></td>
									<td style="padding:3px" align="center"><?php echo $h['address'];?></td>
									<td style="padding:3px" align="center"><?php echo $h['shipped_via'];?></td>
									<td style="padding:3px" align="center"><?php echo $h['waybill_no'];?></td>
									<td style="padding:3px"><?php echo $h['pr_no'];?></td>
									<td style="padding:3px" align="center">
										<?php if($_SESSION['user_id'] == '5'){ ?>
										<a class="btn btn-info btn-xs" data-toggle="modal" data-target="#updatePR" id = 'getD' data-id="<?php echo $h['delivery_id']; ?>" title="Update Restock">
											<span class="fa fa-pencil"></span>
										</a>	
										<?php } ?>
										<a  href="<?php echo base_url();?>index.php/delivery/delivery_receipt/<?php echo $h['delivery_id']; ?>" target = "_blank" class="btn btn-warning btn-xs" title="VIEW" alt='VIEW'><span class="fa fa-eye"></span></a>
									</td>
								</tr>
								<?php } } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!---MO-D-A-L-->
	<div class="modal fade" id="modal_delete_item" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="alert alert-danger">
				<center>
				  	<h2 class="alert-link"><strong><span class="fa fa-exclamation-triangle" aria-hidden="true"></span> DANGER!</strong></h2>
				  	<hr>
				  	Are you sure you want to delete this?
				  	<br>
				  	<br>					  	
				  	<a href="#" class="btn btn-default " data-dismiss="modal">NO</a>&nbsp<a href="#" class="btn btn-danger">YES</a>.
			  	</center>
			</div>
		</div>
	</div>
