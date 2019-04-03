<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/reports.js"></script>
<style type="text/css">
	    #name-item li {width: 50%}
</style>	
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">Item Report</li>
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
					<div class="canvas-wrapper">
						<div class="col-lg-12">
							<form method="POST" action="<?php echo base_url(); ?>index.php/reports/generateItemReport">
								<table width="100%">
									<tr>
										<td width="15%"><p class="pull-right">Search Item:</p></td>
										<td>
											<input type="text" name="item" id="item" class="form-control" autocomplete='off'>
											<span id="suggestion-item"></span>
											<input type="hidden" name="item_id" id="item_id">
										</td>
										<td>
											<input type="submit" name="search_inventory" value='Generate Report' class="btn btn-warning" >
										</td>
									</tr>
								</table>
							</form>
							<br>
							<p class="pname"><?php echo $itemdesc; ?></p>
							<?php if(!empty($list)){ ?>
							<table class="table table-hover table-bordered">
								<thead>
									<tr>
										<td align="center"><strong>PR No.</strong></td>
										<td align="center"><strong>Received Quantity</strong></td>
										<td align="center"><strong>Issued Quantity</strong></td>
										<td align="center"><strong>Balance</strong></td>
									</tr>
								</thead>
								<tbody>		
								<?php 
								
								foreach($list AS $li){ ?>							
									<tr>
										<td align="center"><strong><?php echo $li['prno']; ?></strong></td>
										<td align="center"><strong><?php echo $li['recqty']; ?></strong></td>	
										<td align="center"><strong><?php echo $li['issueqty']; ?></strong></td>		
										<td align="center"><strong><?php echo $li['total']; ?></strong></td>						
									</tr>
								<?php 
								} ?>
								</tbody>
							</table>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript"></script>