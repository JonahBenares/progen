<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<style type="text/css">
	.label-info {
    	background-color: #5bc0de;
	}
	#name-item{
		width:36%!important;
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
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Assembly Transfer</li>
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
						ASSEMBLY TRANSFER
					</div>
					<div class="panel-body">
						<?php foreach($info AS $i){
						$location =$i['location'];
						$location_id =$i['location_id'];
						$engine_id =$i['engine_id']; 
						$engine_to =$i['engine_to']; 
						$assembly_to =$i['assembly_to']; 
						$assembly_id =$i['assembly_id'];
						$department =$i['department']; 
						$purpose =$i['purpose']; 
						$enduse =$i['enduse']; 

						//echo $location_id;
						} ?>
						
						<div class="canvas-wrapper">
							<table>
								<tr>
									<td width="9%"><h5>Department:</h5></td>
									<td width="25%" style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $department; ?></b></h5></td>
									<td width="1%"></td>
									<td width="7%"><h5>Purpose:</h5></td>
									<td width="1%"></td>
									<td width="25%" style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $purpose; ?></b></h5></td>
									<td width="1%"></td>
									<td width="5%"><h5>Enduse:</h5></td>
									<td width="1%"></td>
									<td width="24%" style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $enduse; ?></b></h5></td>
								</tr>
								<tr>
									<td><h5>Transfer to:</h5></td>
									<td style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $location; ?></b></h5></td>
									<td></td>
									<?php if($location_id == '4'){ ?>
										<td><h5>Engine(to):</td>
										<td></td>
										<td  style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $engine_to; ?></b></h5></td> 
									<?php } 
									 if($location_id == '4'){ ?>
										<td></td>
										<td><h5>Assembly (to):</h5></td>
										<td></td>
										
										<td style="border-bottom:1px solid #aeaeae"><h5><b><?php echo $assembly_to; ?></b></h5></td> 
									<?php } ?>
									<td></td>
								</tr>
							</table>
							<br>
							<table width="100%">
								<tr>
									<td></td>
									<td><h5><b>Engine (from):</b></h5></td>
									<td></td>
									<td><h5><b>Assembly (from):</b></h5></td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td width="5%"></td>
									<td width="37%">
										<select class="form-control" name='engine' id='engine_from'  onChange="chooseAssembly2();">
											<option value="<?php echo (!empty($engine) ? $engine : ' '); ?>" selected><?php echo (!empty($engine) ? $engine_name : '-Select Engine-'); ?></option>
											<?php foreach($engine_all  AS $eng){ ?>
												<option value="<?php echo $eng->engine_id; ?>"><?php echo $eng->engine_name; ?></option>
											<?php } ?>
										</select>
									</td>
									<td width="1%"></td>
									<td width="36%">
										<select name="assembly" class="form-control btn-block" id="assembly_from" >
											<?php if(!empty($assembly)) { ?>
												<option value="<?php echo $assembly; ?>" selected><?php echo $assembly_name; ?></option>
											<?php } ?>
										</select>
									</td>
									<td width="1%"></td>
									<td width="15%" ><center><button class="btn btn-md btn-block btn-primary" onclick='generateAssembly()'>Generate</button></center></td>
									<td width="5%"></td>
								</tr>
							</table>
							<hr>
							<form method='POST' action='<?php echo base_url(); ?>/index.php/assembly/insert_issue_details'>
							
							<br>
						
							<table class="table table-bordered table-hover" >
								<thead>
									<tr>
										<th width="30%">Item Description/PN</th>										
										<th width="10%">Bank</th>
										<th width="10%">Plate #</th>
										<th width="8%">Avail Qty</th>
										<th width="8%">Transfer Qty</th>
										<?php if($location_id == '4'){ ?>
											<th width="15%">Transfer Bank</th>
										<?php } else { ?>
										<th width="15%">Location to</th>
									<?php } ?>
									</tr>
								</thead>
								<tbody>
									<?php
									$i=1; 
									foreach($inventory AS $inv){ ?>
										<tr>
											<td><?php echo $inv['item_name']; ?><input type='hidden' name='item_from<?php echo $i; ?>' id='item_from<?php echo $i; ?>' value='<?php echo $inv['item_id']; ?>'></td>
											<td><?php echo $inv['bank_name']; ?><input type='hidden' name='bank_from<?php echo $i; ?>' id='bank_from<?php echo $i; ?>' value='<?php echo $inv['bank_id']; ?>'></td>
											<td><?php echo $inv['plate_no']; ?></td>
											<td><?php echo $inv['qty']; ?></td>
											<td><input type="number" name="trans_qty<?php echo $i; ?>" id="trans_qty<?php echo $i; ?>" class="form-control" max="<?php echo $inv['qty']; ?>"></td>
											<?php if($location_id == '4'){ ?>
											<td><input type='hidden' id='trans_bank_id<?php echo $i; ?>' name='trans_bank_id<?php echo $i; ?>'><input type="text"  autocomplete="off" name="trans_bank<?php echo $i; ?>" id="trans_bank<?php echo $i; ?>" data-count="<?php echo $i; ?>" class="form-control bank"><span id="suggestion-bank<?php echo $i; ?>"></span></td>

											<?php } else { ?>
											<td><input type="text"  autocomplete="off" name="location_to<?php echo $i; ?>" id="location_to<?php echo $i; ?>" data-count="" class="form-control"></td>
										<?php } ?>
											
										</tr>
										
										
									<?php

									$i++;
									 } ?> 
									 <input type='hidden' name='counter' id='counter' value='<?php echo $i; ?>'>

								</tbody>
							</table>
							<br>
							<input type='submit' name='insert_details' class="btn btn-success btn-block btn-lg" value='Issue Items'>
						</div>
					</div>
				</div>
			</div>
		</div>
		<input type='hidden' name='baseurl' id='baseurl' value="<?php echo base_url(); ?>">
		<input type='hidden' name='engine_to' id='engine_to' value="<?php echo $engine_id; ?>">
		<input type='hidden' name='assembly_to' id='assembly_to' value="<?php echo $assembly_id; ?>">
		<input type='hidden' name='engine_from' id='engine_fr' value="<?php echo $engine; ?>">
		<input type='hidden' name='assembly_from' id='assembly_fr' value="<?php echo $assembly; ?>">
		<input type='hidden' name='id' id='id' value="<?php echo $id; ?>">
		<input type='hidden' name='location_id' id='location_id' value="<?php echo $location_id; ?>">
		<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
	</form>
		<!-- Modal -->
<!-- 		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add Bank</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/assembly/insert_bank">
							<label>Location</label>
							<select name='bank_location' class = "form-control">
								<option value='' selected>-Choose Location-</option>
								<option value='A'>A-Bank or Left Bank</option>
								<option value='B'>B-Bank or Right Bank</option>
							</select>
							<label>Bank Name</label>
							<input type = "text" name = "bank_name" class = "form-control">
							<label>Bank Plate</label>
							<input type = "text" name = "bank_plate" class = "form-control">
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div> -->