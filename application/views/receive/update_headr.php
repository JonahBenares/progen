<body style="padding:0px 10px">	
<form method='POST' action="<?php echo base_url(); ?>index.php/receive/edit_head">
	<div class="border-class shadow" style="background-color: #fff">
		<div class="container">
			<div style="padding: 10px">
				<table>
				<?php foreach($head AS $h){ ?>
					<tr>
						<td width="15%"><label>Date:</label></td>
						<td width="85%"><input type = "date" disabled="" name = "receive_date" class = "form-control" value ="<?php echo $h->receive_date; ?>"><br></td>
					</tr>
					<tr>
						<td width="15%"><label>DR#:</label></td>
						<td width="85%"><input type = "text" name = "dr_no" class = "form-control" value = "<?php echo $h->dr_no;?>" autocomplete='off'><br></td>
					</tr>
					<tr>
						<td width="15%"><label>PO#:</label></td>
						<td width="85%"><input type = "text" name = "po_no" class = "form-control" value = "<?php echo $h->po_no;?>" autocomplete='off'><br></td>
					</tr>
					<tr>
						<td width="15%"><label>SI#/OR#:</label></td>
						<td width="85%"><input type = "text" name = "si_no" class = "form-control" value = "<?php echo $h->si_no;?>" autocomplete='off'><br></td>
					</tr>
					<tr>
						<td><label>PCF:</label></td>
						<?php if($h->pcf == '0'){ ?>
						<td><input type = "checkbox" name = "pcf" value = "1" class = "form-control " style="width:30px"><br></td>
						<?php } else{ ?>
						<td><input style="width:30px" type="checkbox" name="pcf" value = "1" <?php echo ((strpos($h->pcf, "1") !== false) ? ' checked' : '');?> class="form-control" ><br></td>
						<?php } ?>
					</tr>
					<tr>
						<td style="vertical-align: text-top;"><label>Overall Remarks:</label></td>
						<td><textarea class="form-control" name="overall_remarks" rows="3"><?php echo $h->overall_remarks;?></textarea></td>
					</tr>
				<?php } ?>
				</table>
				<br>
				<input type='hidden' name='id' value='<?php echo $id;?>'>
				<input class="btn btn-primary btn-md btn-block" type="submit" name="add_item" value="Submit">				
			</div>
		</div>
	</div>
</form>
</body>