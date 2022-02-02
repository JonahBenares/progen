<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/request.js"></script>
<script src="<?php echo base_url(); ?>assets/js/restock.js"></script>
<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<script src="<?php echo base_url(); ?>assets/js/delivery.js"></script>
<script type="text/javascript">
	function val_cpass() {
	    var password = $("#newpass").val();
	    var confirm_password = $("#renewpass").val();
	    if(password != confirm_password) {
	        $("#cpass_msg").show();
	        $("#cpass_msg").html("Confirm password not match!");
	        $("#submit_pass").hide();
	    }
	    else{
	        $("#cpass_msg").hide();
	        $("#submit_pass").show();
	    }
	}


	function chooseCategory(){
	    var loc= document.getElementById("baseurl").value;
	    var redirect = loc+'index.php/reports/getCat';
	    var category = document.getElementById("category").value;
	    $.ajax({
	            type: 'POST',
	            url: redirect,
	            data: 'category='+category,
	            success: function(data){
	                $("#subcat").html(data);
	           }
	    }); 
	}
</script>
<body>	

	<!---MODAL-->	
	<div class="modal fade" id="changePass" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-body" style="padding:50px 50px 30px 50px">
					<form method = "POST" action = "<?php echo base_url(); ?>index.php/masterfile/change_pass">
						<table width="100%">
							<tr>
								<td width="20%"><label>Old Password:</label></td>
								<td width="80%"><input type = "password" name = "oldpass" id="oldpass"  class = "form-control" required><br></td>
							</tr>							
							<tr>
								<td width="20%"><br></td>
								<td width="80%"><br></td>
							</tr>
							<tr>
								<td width="20%"><label>New Password:</label></td>
								<td width="80%"><input type = "password" name = "newpass" id = "newpass" class = "form-control" required><br></td>
							</tr>
							<tr>
								<td width="20%"><label>Retype New Password:</label></td>
								<td width="80%"><input onchange="val_cpass()" type = "password" name = "renewpass" id="renewpass" class = "form-control" required><br></td>
							</tr>
							<tr>
								<td></td>
								<td>
									<div class="alert alert-danger alert-shake" id="cpass_msg" style = "display:none;">
	                                   <center>Confirm Password not Match!</center>
	                                </div>
								</td>
							</tr>
						</table>
					
					<div class="modal-footer">
						<button type="button" id="submit_pass" class="btn btn-default" data-dismiss="modal">Close</button>

						<input type='submit' class="btn btn-warning" value='Proceed '> 
						<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
					</div>
				</form>
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal fade" id="receiveModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Receive</h4>
				</div>
				<div class="modal-body" style="padding:30px 50px 30px 50px">
					<form method="POST" action = "<?php echo base_url();?>index.php/Receive/insert_receive_head">
						<table width="100%">
							<tr>
								<td width="15%"><label>Date:</label></td>
								<td width="85%"><input type = "date" name = "receive_date" class = "form-control" id="e"><br></td>
							</tr>
							<tr>
								<td><label>DR#:</label></td>
								<td><input type = "text" name = "dr_no" class = "form-control" autocomplete='off'><br></td>
							</tr>
							<tr>
								<td><label>PO#:</label></td>
								<td><input type = "text" name = "po_no" class = "form-control" autocomplete='off'><br></td>
							</tr>
							<tr>
								<td><label>SI#/OR#:</label></td>
								<td><input type = "text" name = "si_no" class = "form-control" autocomplete='off'><br></td>
							</tr>
							<tr>
								<td><label>PCF:</label></td>
								<td><input type = "checkbox" name = "pcf" value = "1" class = "form-control " style="width:30px"><br></td>
							</tr>
							<tr>
								<td style="vertical-align: text-top;"><label>Overall Remarks:</label></td>
								<td><textarea class="form-control" name="overall_remarks" rows="3"></textarea></td>
							</tr>
						</table>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

							<input type='submit' class="btn btn-warning" value='Proceed '> 
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="deliverModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Sales</h4>
				</div>
				<div class="modal-body" style="padding:30px 50px 30px 50px">
					<form method="POST" action = "<?php echo base_url();?>index.php/delivery/insert_delivery">
						<table width="100%">
							<tr>
								<td width="15%"><label >Date: </label></td>
								<td width="85%"><input type = "date" name = "date" class = "form-control" value="<?php echo date("Y-m-d");?>" <?php echo ($_SESSION['user_id']==5 || $_SESSION['user_id']==13) ? '' : 'style="pointer-events:none;" readonly';?>><br></td>
							</tr>
							<tr>
								<td width="15%"><label>PR/ PO Date:</label></td>
								<td width="85%"><input type = "date" name = "po_date" class = "form-control"><br></td>
							</tr>
							<!--<tr>
								<td width="15%"><label>PR#/PO#:</label></td>
								<td width="85%"><input type = "text" name = "pr_no" class = "form-control"><br></td>
							</tr>-->
							<tr>
								<td width="15%"><label>Source PR No:</label></td>		
								<td width="85%" style ="padding-bottom: 5px;">
									<select name="pr_no" id='prress' class="form-control select2" onchange="choosePRSSS();" style="margin:4px;width:100%">
										<option value="">--Choose Source PR No--</option>
										<?php foreach($pr_list AS $pr){ ?>
										<option value = "<?php echo $pr->pr_no;?>"><?php echo $pr->pr_no;?></option>
										<?php } ?>
									</select>
									<br>
								</td>
							</tr>
							<tr>
								<td width="15%"><label>PGC PR No/ PO No:</label></td>
								<td width="85%"><input type = "text" name = "sales_pr" id="sales_pr" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="15%"><label>Buyer:</label></td>
								<td width="85%">
									<select name = "buyer" id="buyer" class = "form-control" onchange="chooseBuyer();">
										<option value="">--Select Buyer--</option>
										<?php foreach($buyer AS $buy){ ?>
										<option value="<?php echo $buy->buyer_id; ?>"><?php echo $buy->buyer_name; ?></option>
										<?php } ?>
									</select>
									<br>
								</td>
							</tr>
							<tr>
								<td width="15%"><label>Address:</label></td>
								<td width="85%"><input type = "text" name = "address" id="address" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="15%"><label>Contact Person:</label></td>
								<td width="85%"><input type = "text" name = "contact_person" id="contact_person" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="15%"><label>Contact #:</label></td>
								<td width="85%"><input type = "text" name = "contact_no" id="contact_no" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="20%"></td>
								<td width="80%">
									<label style="margin-right:30px">VAT: <input type = "radio" name = "vat" value="1"></label>
									<label>Non-VAT: <input type = "radio" name = "vat" value="0"></label>
								</td>
							</tr>
						</table>
						<div class="modal-footer">
							<div id='alertbuy' style="font-weight:bold;text-align: center"></div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type='submit' class="btn btn-warning" id="procedure" value='Proceed '> 
							<input type="hidden" name="baseurl" id="baseurl11" value="<?php echo base_url(); ?>">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="requestModal" role="dialog" aria-labelledby="requestModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Request</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<form method="POST" action = "<?php echo base_url();?>index.php/Request/insert_request_head">
						<table width="100%">
							<tr>
								<td width="20%"><label>Request Date/Time:</label></td>
								<td width="40%"><input type = "date" name = "request_date" id="d" class = "form-control" style="margin:4px"></td>
								<td width="40%"><input type = "text" placeholder="Time" name = "request_time" class = "form-control" style="margin:4px" value="<?php echo date('H:i'); ?>"></td>
							</tr>
							<tr>
								<td width="20%"><label>Request Type:</label></td>
								<td colspan="2" >
									<select name = "type" class = "form-control type" style="margin:4px">
										<option value="" selected="">-Select Request Type-</option>
										<option value = "JO / PR">JO / PR</option>
										<option value = "Warehouse Stocks">Warehouse Stocks</option>
										<option value = "Damage Items">Damage Items</option>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%" class = "t"><label>JO / PR #:</label></td>
								<td colspan="2" style ="padding-bottom: 5px;padding-left: 4px;" >
									<select name = "prno" id="prno" class = "form-control t select2" onchange="choosePR();" style="margin:4px;width:100%">
										<option value="" selected="">-Select PR-</option>
										<?php 
										$ctpr= count($prno);
										for($q=0;$q<$ctpr;$q++) { ?>
											<option value="<?php echo $prno[$q]; ?>"><?php echo $prno[$q]; ?></option>
										<?php } ?>
									</select></td>
							</tr>
							<tr>
								<td width="20%"><label>Department:</label></td>
								<td colspan="2">
									<select name = "department" class = "form-control" id = "department" style="margin:4px">
										<option value="" selected="" >-Select Department-</option>
										<?php foreach($department AS $dept){ ?>
											<option value="<?php echo $dept->department_id; ?>"><?php echo $dept->department_name; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>Purpose:</label></td>
								<td colspan="2" >
									<select class = "form-control" name="purpose" id = "purpose" style="margin:4px">
										<option value="" selected="">-Select Purpose-</option>
										<?php foreach($purpose AS $purp){ ?>
											<option value="<?php echo $purp->purpose_id; ?>"><?php echo $purp->purpose_desc; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>End-Use:</label></td>
								<td colspan="2" >
									<select name = "enduse" class = "form-control" id = "enduse" style="margin:4px">
										<option value="" selected="">-Select End-Use-</option>
										<?php foreach($enduse AS $end){ ?>
											<option value="<?php echo $end->enduse_id; ?>"><?php echo $end->enduse_name; ?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>Remarks:</label></td>
								<td colspan="2" ><textarea name = "remarks" class = "form-control" style="margin:4px"></textarea></td>
							</tr>
						</table>
						<div class="modal-footer">
							<div id='alerts' style="font-weight:bold;text-align: center"></div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type='submit' class="btn btn-warning" id = "proceeds" value='Proceed '> 
							<input type="hidden" name="baseurl" id="baseurl12" value="<?php echo base_url(); ?>">
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">							
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="issueModal" tabindex="-1" role="dialog" aria-labelledby="issueModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Load MReqF No.</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<table width="100%">
						<tr>
							<td width="30%"><label>Load MReqF No.:</label></td>							
						</tr>
						<tr>
							<td><input type = "type" name = "" class = "form-control" style="margin:4px"></td>
						</tr>
					</table>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
						<a  class="btn btn-warning" href="<?php echo base_url();?>index.php/issue/load_issue">Proceed</a>							
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="restockModal" role="dialog" aria-labelledby="myModalLabel">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Restock</h4>
				</div>
				<div class="modal-body" style="padding:30px 50px 30px 50px">
					<form id='restockdetails' method = "POST">
						<table width="100%">
							<!-- <tr>
								<td width="26%"><label>PR No. :</label></td>		
								<td>
									<input type = "text" name = "prno" id="prres" class = "form-control" style="margin:4px" autocomplete="off">
								</td>	
							</tr> -->
							<tr>
								<td width="26%"><label>PR No. :</label></td>		
								<td style ="padding-bottom: 5px;padding-left: 4px;">
									<!-- <input type = "text" name = "prno" id="prres" class = "form-control" style="margin:4px" autocomplete="off">
									<span id="suggestion-pr1"></span> -->
									<select name="prno" id='prres' class="form-control select2" onchange="choosePRSS()" style="margin:4px;width:100%">
										<option value = "">-Choose PR-</option>
										<?php foreach($pr_list AS $pr){ ?>
										<option value = "<?php echo $pr->pr_no;?>"><?php echo $pr->pr_no;?></option>
										<?php } ?>
									</select>
								</td>	
							</tr>
							<tr>
								<td width="20%"><label>Department:</label></td>		
								<td>
									<select name="department" id='deptres' class="form-control" style="margin:4px">
										<option value = "">-Choose Department-</option>
										<?php foreach($department AS $dep){ ?>
										<option value = "<?php echo $dep->department_id;?>"><?php echo $dep->department_name;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>Purpose:</label></td>		
								<td>
									<select name="purpose" id='purres' class="form-control" style="margin:4px">
										<option value = "">-Choose Purpose-</option>
										<?php foreach($purpose AS $pur){ ?>
										<option value = "<?php echo $pur->purpose_id;?>"><?php echo $pur->purpose_desc;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%"><label>End-Use:</label></td>		
								<td>
									<select name="enduse" id='endres' class="form-control" style="margin:4px">
										<option value = "">-Choose End-Use-</option>
										<?php foreach($enduse AS $end){ ?>
										<option value = "<?php echo $end->enduse_id;?>"><?php echo $end->enduse_name;?></option>
										<?php } ?>
									</select>
								</td>
							</tr>
							<tr>
								<td><label>Returned By:</label></td>		
								<td><select class="form-control" style="margin:4px" name="returned" id="returnedres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp){ ?>
										<option value="<?php echo $emp->employee_id; ?>?"><?php echo $emp->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
							<tr>
								<td><label>Received By:</label></td>		
								<td>
								<select class="form-control" style="margin:4px" name="received" id="received_byres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp1){ ?>
										<option value="<?php echo $emp1->employee_id; ?>?"><?php echo $emp1->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
							<tr>
								<td><label>Acknowledge By:</label></td>		
								<td>
								<select class="form-control" style="margin:4px" name="acknowledge" id="acknowledge_byres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $emp1){ ?>
										<option value="<?php echo $emp1->employee_id; ?>?"><?php echo $emp1->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
							<tr>
								<td><label>Noted By:</label></td>		
								<td><select class="form-control" style="margin:4px" name="noted_by" id="noted_byres">
									<option selected="selected" >-Choose Employee-</option>
									<?php foreach($employee AS $em){ ?>
										<option value="<?php echo $em->employee_id; ?>"><?php echo $em->employee_name; ?></option>
									<?php } ?>
								</select></td>					
							</tr>
						</table>
						<div class="modal-footer">
							<div id='alert' style="font-weight:bold;text-align: center"></div>
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<!-- <input type='submit' class="btn btn-warning" value='Proceed '>  -->
							<input type="button" class="btn btn-warning" id="proceed" onclick='saveRestock1()' value='Proceed'>
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
							<input type="hidden" name="baseurl" id="baseurl1" value="<?php echo base_url(); ?>">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	
	<!-- MODAL -->

	<!-- TOP NAVBAR -->
	<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
		<div class="container-fluid" >
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse"><span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>				
				<ul class="nav navbar-top-links navbar-left">
					<a class="navbar-brand" href="<?php echo base_url(); ?>index.php/masterfile/home"><span >Warehouse</span>Inventory System</a>
				</ul>
				<ul class="nav navbar-top-links navbar-right">
					<li class="category">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/category_list">
							<span class="fa fa-th-large"></span>
							<span class="tooltiptext shadow">Item Category</span>
						</a>
					</li>
					<li class=" supplier">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/group_list">
							<span class="fa fa-th-list"></span>
							<span class="tooltiptext shadow">Group</span>
						</a>
					</li>
					<li class="uom" >
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/uom_list">
							<span class="fa fa-tag"></span>
							<span class="tooltiptext shadow">UOM</span>
						</a>
					</li>	
					<li class="subcategory" >
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/supplier_list">
							<span class="fa fa-truck"></span>
							<span class="tooltiptext shadow">Supplier</span>
						</a>
					</li>
					<li class="buyer">
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/buyer_list">
							<span class="fa fa-shopping-cart"></span>
							<span class="tooltiptext shadow">Buyer</span>
						</a>
					</li>
					<li class="employees">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/department_list">
							<span class="fa fa-building-o"></span>
							<span class="tooltiptext shadow"> Department</span>
						</a>
					</li>

					<li class="purpose">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/purpose_list">
							<span class="fa fa-circle"></span>
							<span class="tooltiptext shadow">Purpose</span>
						</a>
					</li>

					<li class="enduse">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/endUse_list">
							<span class="fa fa-users"></span>
							<span class="tooltiptext shadow">End Use</span>
						</a>
					</li>
					<li class="warehouse">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/warehouse_list">
							<span class="fa fa-home"></span>
							<span class="tooltiptext shadow">Warehouse</span>
						</a>
					</li>
					<li class="location">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/location_list">
							<span class="fa fa-map-marker"></span>
							<span class="tooltiptext shadow">Location</span>
						</a>
					</li>
					<li class="rack" >
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/rack_list">
							<span class="fa fa-tasks"></span>
							<span class="tooltiptext shadow">Rack</span>
						</a>
					</li>
					<li class="department">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/employee_list">
							<span class="fa  fa-user"></span>
							<span class="tooltiptext shadow">Employees</span>
						</a>
					</li>
					<li class="signatories">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/signatory">
							<span class="fa fa-id-badge "></span>
							<span class="tooltiptext shadow">Signatories</span>
						</a>
					</li>
					<li class="brand">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/import_items">
							<span class="fa fa-cloud-upload"></span>
							<span class="tooltiptext shadow">Import Items</span>
						</a>
					</li>
					<?php if($_SESSION['user_id']==5){ ?>
					<li class="user">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/user_reslist">
							<span class="fa fa-user-circle-o"></span>
							<span class="tooltiptext shadow">User Restriction</span>
						</a>
					</li>
					<?php } ?>
					<li class="divider-side" ></li>
					<li class="setting set">
						<a class="dropdown-toggle count-info setting-hover" data-toggle="dropdown" href="#">
							<em class="fa fa-cog"></em>
						</a>
						<ul class="dropdown-menu animated slideInDown" style="top:110%;width:300px;">
							<span class="arrow-bottom"></span>
							<li>
								<div class="">
									<div class="profile-userpic">
										<img src="http://placehold.it/50/30a5ff/fff" class="img-responsive" alt="">
									</div>
									<div class="profile-usertitle">
										<div class="profile-usertitle-name"><?php echo $_SESSION['fullname'];?></div>
										<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<a href="#" class="setting-name"><em class="fa fa-user">&nbsp;</em> Account</a>
							<li class="divider"></li>
							<a href="#"  data-toggle="modal" data-target="#changePass" class="setting-name"><em class="fa fa-key">&nbsp;</em> Change Password</a>
							<li class="divider"></li>
							<a href="<?php echo base_url(); ?>index.php/masterfile/user_logout" class="setting-name"><em class="fa fa-power-off">&nbsp;</em> Logout</a>
							<br>	
						</ul>						
					</li>
				</ul>				
			</div>
		</div><!-- /.container-fluid -->
	</nav>
	<!-- --TOP NAVBAR--- -->
	
	<!-- --SIDE NAVBAR--- -->
	<div id="sidebar-collapse " class="col-sm-3 col-lg-2 sidebar shadow">
		<div class="banner" >
			<div style="position:relative;padding:5px 10px 0px 10px" >
				<h1 style="margin-top: 5px;font-weight: 900;text-align: center;color: #fff;border:1px solid #fff">PROGEN</h1>
			</div>
			<div class="moving-obj" >			
				<span class="fa fa-tasks padding-obj"></span>		
				<span class="infinite-shake fa fa-archive padding-obj"></span>			
				<span class="fa fa-archive padding-obj"></span>
				<span class="fa fa-truck font-truck padding-obj"></span>
			</div>
		</div>
		<ul class="nav menu">
			<li ><a href="<?php echo base_url(); ?>index.php/masterfile/home"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
			<li ><a href="<?php echo base_url(); ?>index.php/masterfile/reminder_list"><em class="fa fa-bell">&nbsp;</em> Reminder</a></li>
			<li><a href="<?php echo base_url(); ?>index.php/items/item_list"><em class="fa fa-calendar">&nbsp;</em> Item List</a></li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-assembly-report">
					<span class="fa fa-cog">&nbsp;</span> Assem Masterfile 
					<span data-toggle="collapse" href="#sub-assembly-report" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-assembly-report">
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/assembly/parts_list">
							<span class="fa fa-arrow-right">&nbsp;</span> Parts
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/assembly/bank_list">
							<span class="fa fa-arrow-right">&nbsp;</span> Default Bank
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/assembly/bank_list_new">
							<span class="fa fa-arrow-right">&nbsp;</span> Customize Bank
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/assembly/condi_list">
							<span class="fa fa-arrow-right">&nbsp;</span> Condition
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/assembly/assem_transfer_list" style="cursor: pointer;">
							<span class="fa fa-arrow-right">&nbsp;</span> Assem Transfer
						</a>
					</li>
					<li>
						<a href="<?php echo base_url(); ?>index.php/assembly/assem_receive_list" class="" style="cursor: pointer;">
							<span class="fa fa-arrow-right">&nbsp;</span> Assem Receive
						</a>
					</li>
				</ul>
			</li>	
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-assembly">
					<span class="fa fa-cog">&nbsp;</span> Assem Report 
					<span data-toggle="collapse" href="#sub-assembly" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-assembly">
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/assembly/issue_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Issue
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/assembly/receive_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Receive
						</a>
					</li>
				</ul>
			</li>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-damage">
					<span class="fa fa-chain-broken">&nbsp;</span> Damage Items 
					<span data-toggle="collapse" href="#sub-damage" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-damage">
					<li>
						<a href="<?php echo base_url(); ?>index.php/damage/add_dmg_item" class="">
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/damage/damage_list">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-1">
					<em class="fa fa-navicon">&nbsp;</em> Transactions 
					<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-item-1">	
					<li class="parent ">
						<a data-toggle="collapse" href="#sub-receiving">
							<span class="fa fa-sign-in">&nbsp;</span> Receive 
						</a>
						<ul class="children collapse" id="sub-receiving">
							<?php if($receive_add == 1){ ?>
							<li>
								<a style="padding-left:60px" class=""  data-toggle="modal" data-target="#receiveModal" >
									<span class="fa fa-arrow-right">&nbsp;</span> Add New
								</a>
							</li>
							<?php } ?>
							<li>
								<a style="padding-left:60px" class="" href="<?php echo base_url(); ?>index.php/receive/receive_list">
									<span class="fa fa-arrow-right">&nbsp;</span> View List
								</a>
							</li>
						</ul>
					</li>				
					<li class="parent ">
						<a data-toggle="collapse" href="#sub-request">
							<span class="fa fa-pencil-square-o">&nbsp;</span> Request 
						</a>
						<ul class="children collapse" id="sub-request">
							<?php if($request_add == 1){ ?>
							<li>
								<a style="padding-left:60px"  data-toggle="modal" data-target="#requestModal" >
									<span class="fa fa-arrow-right">&nbsp;</span> Add New
								</a>
							</li>
							<?php } ?>
							<li>
								<a style="padding-left:60px" class="" href="<?php echo base_url(); ?>index.php/request/request_list">
									<span class="fa fa-arrow-right">&nbsp;</span> View List
								</a>
							</li>
						</ul>
					</li>							
					<li class="parent ">
						<a data-toggle="collapse" href="#sub-issue">
							<span class="fa fa-share-square-o">&nbsp;</span> Issue 
						</a>
						<ul class="children collapse" id="sub-issue">
							<?php if($issue_add == 1){ ?>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/issue/load_issue" >
									<span class="fa fa-arrow-right">&nbsp;</span> Load MRef No.
								</a>
							</li>
							<?php } ?>
							<li>
								<a style="padding-left:60px" class=""  href="<?php echo base_url(); ?>index.php/issue/view_issue">
									<span class="fa fa-arrow-right">&nbsp;</span> View List
								</a>
							</li>
						</ul>
					</li>	
					<li class="parent ">
						<a data-toggle="collapse" href="#sub-restock">
							<span class="fa fa-archive">&nbsp;</span> Restock 
						</a>
						<ul class="children collapse" id="sub-restock">
							<?php if($restock_add == 1){ ?>
							<li>
								<a style="padding-left:60px" class=""  data-toggle="modal" data-target="#restockModal">
									<span class="fa fa-arrow-right">&nbsp;</span> Add New
								</a>
							</li>
							<?php } ?>
							<li>
								<a style="padding-left:60px" class=""  href="<?php echo base_url(); ?>index.php/restock/restock_list">
									<span class="fa fa-arrow-right">&nbsp;</span> View List
								</a>
							</li>
						</ul>
					</li>
					<li class="parent ">
						<a data-toggle="collapse" href="#sub-deliver">
							<span class="fa fa-truck">&nbsp;</span> Sales 
						</a>
						<ul class="children collapse" id="sub-deliver">
							<?php if($_SESSION['user_id']==5 || $_SESSION['user_id']==11 || $_SESSION['user_id']==13){ ?>
							<li>
								<a style="padding-left:60px"  data-toggle="modal" data-target="#deliverModal" >
									<span class="fa fa-arrow-right">&nbsp;</span> Add New
								</a>
							</li>
							<?php } ?>
							<li>
								<a style="padding-left:60px" class="" href="<?php echo base_url(); ?>index.php/delivery/delivery_list">
									<span class="fa fa-arrow-right">&nbsp;</span> View List
								</a>
							</li>
						</ul>
					</li>	
					<?php if($receive_add == 1){ ?>
					<li><a href="<?php echo base_url(); ?>index.php/backorder/back_order"><em class="fa fa-retweet">&nbsp;</em> Back Order</a></li>	
					<?php } ?>
				</ul>
			</li>		
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-2">
					<em class="fa fa-navicon">&nbsp;</em> Report 
					<span data-toggle="collapse" href="#sub-item-2" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-item-2">
					<li class="parent ">
						<a data-toggle="collapse" href="#subsub-item-4">
							<span data-toggle="collapse" href="#subsub-item-4" class="icon">
								<em class="fa fa-plus"></em>
							</span>&nbsp;PR <small>Report</small>							
						</a>
						<ul class="children collapse" id="subsub-item-4">
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/all_pr_report" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Overall
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/pr_report" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Receive
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/pr_report_issue" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Issue
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/pr_report_restock">
									<span class="fa fa-arrow-right">&nbsp;</span> Restock
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/pr_report_sales">
									<span class="fa fa-arrow-right">&nbsp;</span> Sales
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/tagged_as_excess">
									<span class="fa fa-arrow-right">&nbsp;</span> Tagged as Excess
								</a>
							</li>
						</ul>
					</li>
					<!-- <li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/pr_report">
							<span class="fa fa-arrow-right">&nbsp;</span> PR
						</a>
					</li> -->
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/item_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Item PR
						</a>
					</li>
					<li class="parent ">
						<a data-toggle="collapse" href="#subsub-item-1">
							<span data-toggle="collapse" href="#subsub-item-1" class="icon">
								<em class="fa fa-plus"></em>
							</span> Inventory 							
						</a>
						<ul class="children collapse" id="subsub-item-1">
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/aging_report" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> Aging
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/for_accounting" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> For Accounting
								</a>
							</li>
							<li>
								<a style="padding-left:60px;height: 80px" href="<?php echo base_url(); ?>index.php/reports/for_accounting_monthly" target="_blank">
									<span class="fa fa-arrow-right">&nbsp;</span> For Accounting <br> &nbsp;(Range of Date)
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/inventory_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Per Item
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/range_date">
									<span class="fa fa-arrow-right">&nbsp;</span> Range of Date
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/received_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Received
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/issued_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Issued
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/delivery_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Sales
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/restock_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Restock
								</a>
							</li>
							<li>
								<a style="padding-left:60px" href="<?php echo base_url(); ?>index.php/reports/excess_report">
									<span class="fa fa-arrow-right">&nbsp;</span> Excess
								</a>
							</li>
						</ul>
					</li>			
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/stock_card_new">
							<span class="fa fa-arrow-right">&nbsp;</span> Stock Card
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/borrowing_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Borrowing Report
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/whstock_tracking">
							<span class="fa fa-arrow-right">&nbsp;</span> WH Stock Tracking
						</a>
					</li>
				</ul>
			</li>		
		</ul>
		<br>
		<br>
		<br>
	</div>
	<!-- --SIDE NAVBAR--- -->
<script type="text/javascript">
	function choosePR(){
    var loc= document.getElementById("baseurl12").value;
    var redirect = loc+'index.php/request/getPR';
    var prno = document.getElementById("prno").value;
    document.getElementById('alerts').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#proceeds").hide(); 
    setTimeout(function() {
        document.getElementById('alerts').innerHTML=''; 
        $("#proceeds").show(); 
    },5000);
    $.ajax({
            type: 'POST',
            url: redirect,
            data: 'prno='+prno,
            dataType: 'json',
            success: function(response){
               document.getElementById("department").value  = response.dept;
               document.getElementById("purpose").value  = response.pur;
               document.getElementById("enduse").value  = response.end;
           }
    }); 
}
</script>