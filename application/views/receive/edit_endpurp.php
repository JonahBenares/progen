<?php foreach($details AS $d){ ?>
<div class="form-group">
	<p style="margin: 0px">Department</p>
	<select class = "form-control" id = "department" name = 'department'>
		<option value = "">--Select Department--</option>
		<?php foreach($dept AS $dep){ ?>
		<option value = "<?php echo $dep->department_id?>" <?php echo (($d['department_id'] == $dep->department_id) ? ' selected' : '');?>><?php echo $dep->department_name?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<p style="margin: 0px">Purpose</p>
	<select class = "form-control" id = "purpose" name = 'purpose'>
		<option value = "">--Select Purpose--</option>
		<?php foreach($purp AS $p){ ?>
		<option value = "<?php echo $p->purpose_id?>" <?php echo (($d['purpose_id'] == $p->purpose_id) ? ' selected' : '');?>><?php echo $p->purpose_desc?></option>
		<?php } ?>
	</select>
</div>
<div class="form-group">
	<input class="form-control" name = "rd_id" type = "hidden" value = "<?php echo $id;?>"/>
	<input class="form-control" name = "rec_id" type = "hidden" value = "<?php echo $rec_id;?>"/>
	<p style="margin: 0px">Enduse</p>
	<select class = "form-control" id = "enduse" name = 'enduse'>	
		<option value = "">--Select Enduse--</option>
		<?php foreach($end AS $e){ ?>
		<option value = "<?php echo $e->enduse_id?>" <?php echo (($d['enduse_id'] == $e->enduse_id) ? ' selected' : '');?>><?php echo $e->enduse_name?></option>
		<?php } ?>
	</select>
</div>
<?php } ?>