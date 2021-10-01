<?php foreach($delivery_list AS $list){ ?>
<div class="form-group">
	<p style="margin: 0px">Date</p>
	<input type = "date" name = "date" class = "form-control" value="<?php echo $list['date']; ?>">
	<p style="margin: 0px">PGC PR No/ PO No.</p>
	<input type = "text" name = "sales_pr" class = "form-control" value="<?php echo $list['sales_pr']; ?>">
	<input class="form-control" name = "delivery_id" type = "hidden" value = "<?php echo $id;?>"/>
</div>
<?php } ?>