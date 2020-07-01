<script src="<?php echo base_url(); ?>assets/js/dashboard/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/dashboard/jquery.min.js"></script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main" >
	<div class="row">
		<ol class="breadcrumb">
			<li><a href="#">
				<em class="fa fa-home"></em>
			</a></li>
			<li class="active">Dashboard</li>
		</ol>
	</div><!--/.row-->
	
	<div class="row">
		<div class="col-lg-12">
			<h1 class="page-header">Dashboard</h1>
		</div>
	</div><!--/.row-->
	<div class="col-lg-7">
	<?php if(!empty($list)){ ?>
		<div class="panel panel-default animated fadeInLeft" style="border: 1px solid #ffcbaa;">
			<div class="panel-body">
				<center>
					<h3>
						<span class="fa fa-retweet"></span>
						<strong> Back Order</strong>
					</h3>
				</center>
				<table class="table table-bordered table-hover shadow-dash">
					<tr style="background-color: #ffe0a7; font-weight: 600">
						<td align="center">PR#</td>
						<td align="center">Item</td>
						<td align="center">Expected Qty</td>
						<td align="center">Received Qty</td>
						<td align="center"><span class="fa fa-cog"></span></td>
					</tr>
					<?php 
				


						 //print_r($list);
					

					foreach($list AS $li){ 
							if($li['received']!=0){
						 ?>
					<tr>
						<td align="center"><?php echo $li['pr_no']; ?></td>
						<td align="center"><?php echo $li['item']; ?></td>
						<td align="center"><?php echo $li['expected']; ?></td>
						<td align="center"><?php echo $li['received']; ?></td>
						<td align="center">
							<a href="<?php echo base_url(); ?>index.php/backorder/back_order/<?php echo $li['rdid']; ?>" class="btn btn-warning btn-xs">Receive</a>
						</td>
					</tr>
					<?php } }
				 ?>
				</table> 
			</div>
		</div> 
		<?php } else { ?>
		<div class="panel panel-default animated fadeInLeft itemSubBevel itemSubColor1" >
			<div class="panel-body">
				<center>
					<h1 class="subFcolor"><span class="fa fa-retweet rotate"></span> </h1><h2 class="subColored" style="margin: 0px">Back Order</h2>
				</center>
			</div>
		</div>
		<?php } ?>
		<?php if(!empty($nto)){ ?>
		<div class="panel panel-default animated fadeInRight " style="border: 1px solid #ffcbaa;">
			<div class="panel-body">
				<center>
					<h3>
						<span class="fa fa-shopping-cart"></span>
						<strong> Need to Reorder</strong>
					</h3>
				</center>
				<table class="table table-bordered table-hover shadow-dash">
					<tr style="background-color: #ffe0a7; font-weight: 600">
						<td align="center" width="60%">Item</td>
						<td align="center" width="20%">MOQ</td>
						<td align="center" width="20%">Cur. Inv.</td>
					</tr>
					<?php 
					if(!empty($nto)){
					foreach($nto AS $n) { ?>
					<tr>
						<td align="center"><?php echo $n['item']; ?></td>
						<td align="center"><?php echo $n['moq']; ?></td>
						<td align="center"><?php echo $n['currentinv']; ?></td>
						
					</tr>
					<?php }
					} ?>
				</table>
			</div>
		</div>
		<?php } else { ?>
		<div class="panel panel-default animated fadeInRight itemSubBevel itemSubColor2" >
			<div class="panel-body">
				<center>
					<h1 class="subFcolor"><span class="fa fa-shopping-cart animated fadeInLeft infinite"></span> </h1><h2 class="subColored" style="margin: 0px">Need to Reorder</h2>
				</center>
			</div>
		</div>
		<?php } ?>
	</div>

	<div class="modal fade" id="reminderModal" tabindex="-1" role="dialog" aria-labelledby="reminderModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Add Reminder</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<form method="POST" action="<?php echo base_url() ?>index.php/masterfile/addreminder">
						<table class="table" width="100%">
								<tr>
									<td width="20%" class="td-sclass">Reminder Date</td>
									<td><input type="date" name='reminder_date' class="form-control"></td>
								</tr>
								<tr>
									<td width="20%" class="td-sclass">Title</td>
									<td><input type="text" name='reminder_title' class="form-control"></td>
								</tr>
								<tr>
									<td width="20%" class="td-sclass">Notes</td>
									<td><textarea name='reminder_notes' class="form-control"></textarea></td>
								</tr>
								<tr>
									<td width="20%" class="td-sclass">Remind who?</td>
									<td><select name='remind_person' class="form-control">
										<option value='' selected>-Choose who to remind-</option>
										<?php 
										
										foreach($employee AS $emp) { ?>
											<option value="<?php echo $emp->employee_id; ?>"><?php echo $emp->employee_name; ?></option>
										<?php } ?>
									</select></td>
								</tr>

								
							</table>
						<div class="modal-footer">
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type='submit' class="btn btn-warning" value='Proceed '> 					
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade" id="UpreminderModal" tabindex="-1" role="dialog" aria-labelledby="UpreminderModal">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header modal-headback">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" id="myModalLabel">Update Reminder</h4>
				</div>
				<div class="modal-body" style="padding:30px 20px 30px 20px">
					<form method="POST" action="<?php echo base_url() ?>index.php/masterfile/update_reminder">
						<table class="table" width="100%">
								<tr>
									<td width="20%" class="td-sclass">Reminder Date</td>
									<td><input type="date" id = "reminder_date" name='reminder_date' class="form-control"></td>
								</tr>
								<tr>
									<td width="20%" class="td-sclass">Title</td>
									<td><input type="text" id = "reminder_title" name='reminder_title' class="form-control"></td>
								</tr>
								<tr>
									<td width="20%" class="td-sclass">Notes</td>
									<td><textarea name='reminder_notes' id = "reminder_notes" class="form-control"></textarea></td>
								</tr>
								<tr>
									<td width="20%" class="td-sclass">Remind who?</td>
									<td><select name='remind_person' id = "remind_person" class="form-control">
										<option value='' selected>-Choose who to remind-</option>
										<?php 
										
										foreach($employee AS $emp) { ?>
											<option value="<?php echo $emp->employee_id; ?>"><?php echo $emp->employee_name; ?></option>
										<?php } ?>
									</select></td>
								</tr>

								
							</table>
						<div class="modal-footer">
							<input type='hidden' name='reminder_id' id="reminder_id">
							<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
							<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							<input type='submit' class="btn btn-warning" value='Proceed '> 					
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-lg-5" >
	<?php if(!empty($reminders)){ ?>
		<div class="panel panel-default animated fadeInDown" style="border: 1px solid #4ab3f5;">
			<div class="panel-heading" >
				<span class="fa fa-bell bell" style="color:#fff"></span>
				REMINDER
				<a class="pull-right clickable panel-toggle panel-button-tab-left"  data-toggle="modal" data-target="#reminderModal">
					<em class="fa fa-plus"></em>
				</a>
			</div>
			<div class="panel-body">
				<?php 	
				$space = '&#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13';
				$space2 = '&#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13 &#13';
				if(!empty($reminders)){
				foreach($reminders AS $rem) { ?>
				
				<ul class="todo-list" style="padding-bottom: 10px;list-style: none">
					<li class="todo-list-item">
						<a style="text-decoration: none;"  data-toggle="popover" title="Notes: <?php echo $space; ?>  <?php echo $rem['notes']; ?>" data-content="Person to remind: <?php echo $space2; ?> <?php echo $rem['employee']; ?>" data-placement="left">
							<table width="100%">
								<tr>
									<td  width="90%">
										<h4 style="margin:0px">
											<small><span class="fa fa-circle"></span></small> 
											<?php echo date('d-M-Y',strtotime($rem['reminder_date'])); ?>
										</h4>
										<p style="padding-left: 17px;padding-right: 20px;padding-top: 5px"><?php echo $rem['title']; ?></p>
									</td>
									<td>
										<a class='btn btn-primary btn-xs' id="UpRem" data-id = "<?php echo $rem['reminder_id'];?>" data-date="<?php echo $rem['reminder_date']; ?>" data-title="<?php echo $rem['title']; ?>" data-notes="<?php echo $rem['notes']; ?>" data-remind="<?php echo $rem['remind_employee']; ?>" data-toggle="modal" data-target="#UpreminderModal">Edit</a>
										<a href="<?php echo base_url(); ?>index.php/masterfile/reminderdone/<?php echo $rem['reminder_id']; ?>" onclick="return confirm('Are you sure?')" class='btn btn-warning btn-xs'>Done</a>
									</td>
								</tr>
							</table>
						</a>
					</li>
				</ul>
				<?php }
				} ?>
			</div>
		</div> 
		<?php } else { ?>
		<div class="panel panel-default animated fadeInDown itemSubBevel itemSubColor2" >
			<div class="panel-bell" >
				<a class="pull-right clickable panel-toggle panel-button-tab-left"  data-toggle="modal" data-target="#reminderModal">
					<em class="fa fa-plus"></em>
				</a>
			</div>
			<div class="panel-body panel-bell-body">
				<center>
					<h1 class="subFcolor"><span class="fa fa-bell bell"></span> </h1><h2 class="subColored" style="margin: 0px">Reminder</h2>
				</center>
			</div>
		</div>
		<?php } ?>
	</div>
	
	
	<script>
		$(document).ready(function(){
		    $('[data-toggle="popover"]').popover();   
		});

		$(document).on("click", "#UpRem", function () {
		     var reminder_id = $(this).attr("data-id");
		     var reminder_date = $(this).attr("data-date");
		     var reminder_title = $(this).attr("data-title");
		     var reminder_notes = $(this).attr("data-notes");
		     var remind_person = $(this).attr("data-remind");
		     $("#reminder_id").val(reminder_id);
		     $("#reminder_date").val(reminder_date);
		     $("#reminder_title").val(reminder_title);
		     $("#reminder_notes").val(reminder_notes);
		     $("#remind_person").val(remind_person);
		});
	</script>