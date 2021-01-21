<?php foreach($delivery_list AS $list){ ?>
<div class="form-group">
	<p style="margin: 0px">PR</p>
	<input type = "text" name = "pr_no" class = "form-control" value="<?php echo $list['pr_no']; ?>">
	<input class="form-control" name = "delivery_id" type = "hidden" value = "<?php echo $id;?>"/>
</div>
<?php } ?>