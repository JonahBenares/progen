<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/request.js"></script>
<body>	

	<!-- -----MODAL----- -->	
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
								<td width="10%"><label>Date:</label></td>
								<td width="90%"><input type = "date" name = "receive_date" class = "form-control" id="e"><br></td>
							</tr>
							<tr>
								<td width="10%"><label>DR#:</label></td>
								<td width="90%"><input type = "text" name = "dr_no" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="10%"><label>PO#:</label></td>
								<td width="90%"><input type = "text" name = "po_no" class = "form-control"><br></td>
							</tr>
							<tr>
								<td width="10%"><label>SI#:</label></td>
								<td width="90%"><input type = "text" name = "si_no" class = "form-control"><br></td>
							</tr>
							<tr>
								<td><label>PCF:</label></td>
								<td><input type = "checkbox" name = "pcf" value = "1" class = "form-control " style="width:30px"></td>
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
	<div class="modal fade" id="requestModal" tabindex="-1" role="dialog" aria-labelledby="requestModal">
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
									</select>
								</td>
							</tr>
							<tr>
								<td width="20%" class = "t"><label>JO / PR #:</label></td>
								<td colspan="2" >
									<select name = "prno" id="prno" class = "form-control t" onChange="choosePR();" style="margin:4px">
										<option value="" selected="">-Select PR-</option>
										<?php 
										$ctpr= $count=count($prno);
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
							<!-- <tr>
								<td width="20%"><label>Borrow from PR#:</label></td>
								<td colspan="2" >
									<select name = "borrow_pr" class = "form-control" style="margin:4px">
										<option value="" selected="">-Select PR-</option>
										<?php foreach($prno AS $pr){ ?>
											<option value="<?php echo $pr->pr_no; ?>"><?php echo $pr->pr_no; ?></option>
										<?php } ?>
									</select>
									</td>
							</tr> -->
							<tr>
								<td width="20%"><label>Remarks:</label></td>
								<td colspan="2" ><textarea name = "remarks" class = "form-control" style="margin:4px"></textarea></td>
							</tr>
						</table>
						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type='submit' class="btn btn-warning" value='Proceed '> 
							<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
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
					<a class="navbar-brand" href="#"><span >Warehouse</span>Inventory System</a>
				</ul>
				<ul class="nav navbar-top-links navbar-right">
					<li class="subcategory" >
						<a class="dropdown-toggle count-info " href="<?php echo base_url(); ?>index.php/masterfile/supplier_list">
							<span class="fa fa-truck"></span>
							<span class="tooltiptext shadow">Supplier</span>
						</a>
					</li>
					<li class="category"">
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

					<li class="employees">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/department_list">
							<span class="fa fa-building-o"></span>
							<span class="tooltiptext shadow"> Department</span>
						</a>
					</li>

					<li class="enduse">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/purpose_list">
							<span class="fa fa-circle"></span>
							<span class="tooltiptext shadow">Purpose</span>
						</a>
					</li>

					<li class="purpose">
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
					<li class="user">
						<a class="dropdown-toggle count-info" href="<?php echo base_url(); ?>index.php/masterfile/user_reslist">
							<span class="fa fa-user-circle-o"></span>
							<span class="tooltiptext shadow">User Restriction</span>
						</a>
					</li>
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
										<div class="profile-usertitle-name">Username</div>
										<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
									</div>
								</div>
							</li>
							<li class="divider"></li>
							<a href="#" class="setting-name"><em class="fa fa-user">&nbsp;</em> Account</a>
							<li class="divider"></li>
							<a href="#" class="setting-name"><em class="fa fa-key">&nbsp;</em> Change Password</a>
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
				<a data-toggle="collapse" href="#sub-request">
					<span class="fa fa-pencil-square-o">&nbsp;</span> Request 
					<span data-toggle="collapse" href="#sub-request" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-request">
					<?php if($request_add == 1){ ?>
					<li>
						<a  data-toggle="modal" data-target="#requestModal" >
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<?php } ?>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/request/request_list">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-receiving">
					<span class="fa fa-sign-in">&nbsp;</span> Receive 
					<span data-toggle="collapse" href="#sub-receiving" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-receiving">
					<?php if($receive_add == 1){ ?>
					<li>
						<a class=""  data-toggle="modal" data-target="#receiveModal" >
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<?php } ?>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/receive/receive_list">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	
			<!-- <li><a href="<?php echo base_url(); ?>index.php/issue/load_issue"><em class="fa fa-share-square-o">&nbsp;</em> Issue</a></li> -->
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-issue">
					<span class="fa fa-share-square-o">&nbsp;</span> Issue 
					<span data-toggle="collapse" href="#sub-issue" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-issue">
					<?php if($issue_add == 1){ ?>
					<li>
						<a href="<?php echo base_url(); ?>index.php/issue/load_issue" >
							<span class="fa fa-arrow-right">&nbsp;</span> Load MRef No.
						</a>
					</li>
					<?php } ?>
					<li>
						<a class=""  href="<?php echo base_url(); ?>index.php/issue/view_issue">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-restock">
					<span class="fa fa-archive">&nbsp;</span> Restock 
					<span data-toggle="collapse" href="#sub-restock" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-restock">
					<?php if($restock_add == 1){ ?>
					<li>
						<a href="<?php echo base_url(); ?>index.php/restock/add_restock">
							<span class="fa fa-arrow-right">&nbsp;</span> Add New
						</a>
					</li>
					<?php } ?>
					<li>
						<a class=""  href="<?php echo base_url(); ?>index.php/restock/restock_list">
							<span class="fa fa-arrow-right">&nbsp;</span> View List
						</a>
					</li>
				</ul>
			</li>	
			<?php if($receive_add == 1){ ?>
			<li><a href="<?php echo base_url(); ?>index.php/backorder/back_order"><em class="fa fa-retweet">&nbsp;</em> Back Order</a></li>	
			<?php } ?>
			<li class="parent ">
				<a data-toggle="collapse" href="#sub-item-1">
					<em class="fa fa-navicon">&nbsp;</em> Report 
					<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right">
						<em class="fa fa-plus"></em>
					</span>
				</a>
				<ul class="children collapse" id="sub-item-1">
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/pr_report">
							<span class="fa fa-arrow-right">&nbsp;</span> PR
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/inventory_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Inventory
						</a>
					</li>					
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/stock_card">
							<span class="fa fa-arrow-right">&nbsp;</span> Stock Card
						</a>
					</li>
					<li>
						<a class="" href="<?php echo base_url(); ?>index.php/reports/borrowing_report">
							<span class="fa fa-arrow-right">&nbsp;</span> Borrowing Report
						</a>
					</li>
				</ul>
			</li>		
		</ul>
	</div>
	<!-- --SIDE NAVBAR--- -->
