<?php foreach($delivery_list AS $list){ ?>
<div class="form-group">
	<p style="margin: 0px">Date</p>
	<input type = "date" name = "date" class = "form-control" value="<?php echo $list['date']; ?>">
	<p style="margin: 0px">Sales PR #</p>
	<input type = "text" name = "pr_no" class = "form-control" value="<?php echo $list['pr_no']; ?>">
	<input class="form-control" name = "delivery_id" type = "hidden" value = "<?php echo $id;?>"/>
</div>
<?php } ?>