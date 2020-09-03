<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
<script>
    $('.select2').select2();
</script>

<div class="container">
    <div class="card" style="background: #fff; padding: 30px 20px;box-shadow: 1px 1px 1px 1px #eaeaea; border-radius: 10px  ">
        <h4 style="margin-top: 0px"><span class="fa fa-pencil"></span> Edit PR Number </h4>
        <div class="card-body">
        	<form method='POST' action="<?php echo base_url(); ?>index.php/Issue/updatePRIssuance">
            <div class="form-group">
                <select class='select2' name='pr_no'>
                	<option></option>
                	<?php 
                
                	foreach($pr_list AS $pr){ ?>
                		<option value='<?php echo $pr->pr_no; ?>'><?php echo $pr->pr_no; ?></option>
                	<?php } ?>
                </select>
            </div>
            <input type='hidden' name='issuance_id' value="<?php echo $issue_id; ?>">
            <input type="submit" class="btn btn-primary" style="width: 100%" name="edit_pr" value="Save">
        </div>
    	</form>
    </div>
</div>
<div style="margin-bottom: 10px "></div>