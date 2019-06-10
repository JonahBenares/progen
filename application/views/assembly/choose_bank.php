<body style="padding:0px 10px">	
	<form method='POST' action="<?php echo base_url(); ?>index.php/assembly/savechoose_bank">
		<div class="border-class shadow" style="background-color: #fff">
			<div class="container">
				<div style="padding: 10px">
					<div class="form-group">
						<p style="margin: 0px">
							<b>Type:</b>
							<select name="type" class="form-control" onchange="showBank(this)">
								<option value = "">--Select type--</option>
								<option value = "No Left/Right">No Left/Right</option>
								<option value = "With Left/Right">With Left/Right</option>
							</select>
						</p>
					</div>
					<?php 
						foreach($bank AS $b){
							$left=$b->left_column;
							$right=$b->right_column;
							$no_col=$b->no_column;
					?>
					<div class="form-group" id = "a" style = "display: none;">
						<?php for($y=1;$y<=$no_col;$y++){ ?>
							<p style="margin: 0px">
								<b>Bank Name:</b>
								<input type="text" name="bank_name<?php echo $y; ?>" class="form-control">
							</p>
						<?php } ?>
					</div>
					<div class="form-group" id = "b" style = "display: none;">
						<p style="margin: 0px">
							<b>Location:</b>
							<select name='bank_location_l' class = "form-control"  onchange="showLoc(this)">
								<option value=''>-Choose Location-</option>
								<option value='A'>A-Bank or Left Bank</option>
								<option value='B'>B-Bank or Right Bank</option>
							</select>
						</p>
					</div>
					<div class = "form-group" id ='c' style = "display: none;">
						<?php for($x=1;$x<=$left;$x++){ ?>
							<b>Bank Name:</b>
							<input type="text" name="bank_name_l<?php echo $x; ?>" class="form-control">
						<?php } ?>
					</div>
					<div class = "form-group" id ='d' style = "display: none;">
						<?php for($z=1;$z<=$right;$z++){ ?>
							<b>Bank Name:</b>
							<input type="text" name="bank_name_r<?php echo $z; ?>" class="form-control">
						<?php } ?>
					</div>
					<input type="hidden" name="left" value = "<?php echo $left;?>" class="form-control">
					<input type="hidden" name="right" value = "<?php echo $right;?>" class="form-control">
					<input type="hidden" name="bh_id" value = "<?php echo $bh_id;?>" class="form-control">
					<input type="hidden" name="no_col" value = "<?php echo $no_col;?>" class="form-control">
					<?php } ?>
					<input class="btn btn-primary btn-md btn-block" type="submit" name="add_item" value="Submit">				
				</div>
			</div>
		</div>
	</form>
</body>