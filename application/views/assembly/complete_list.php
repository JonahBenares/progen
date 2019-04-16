<?php
$CI=&get_instance();
?>
<style type="text/css">
	#footer{
		display: none;
	}
	p{
		margin:0px!important;
	}
	table tr td, table tr td p{
		text-align: center;
	}
	 table tr td p.aseem{
		text-align: left;
	}
	.no-pad{
		padding: 0px!important;
	}
	.texvox{
		width:100%;
		height:40px;
		border:0px solid #fff;
		padding:5px;
		text-align: center;
	}
	.lbwidth, .rbwidth{
		width:50px;
	}
	body{
		padding: 0px;
		background: #383838;
	}
	table.table{
		margin-top:20px;
	}
</style>
<?php
if(empty($inventory)){
	$loc = base_url()."index.php/assembly/insert_inventory";
} else {
	$loc = base_url()."index.php/assembly/update_inventory";
}
 ?>

<form method='POST' action="<?php echo $loc; ?>">
<div style="position:fixed;width:100%;margin-left: 25%">
	<div style="width:50%">
		<button type='submit' class="btn btn-lg btn-info btn-block">Save</button>
		<!-- <button class="btn btn-lg btn-info btn-block" onclick="printDiv('printableArea')">Save & Print</button> -->
	</div>
</div>
<div id="printableArea">
	
	<table class="table table-bordered" >
		<tr>
			<td colspan="3" rowspan="2">
				<h2 style="width:500px"><?php echo $engine; ?></h2>
			</td>
			<td></td>
			<td>Qty</td>
			<td>Units</td>		
			<td colspan="<?php echo $left; ?>">A - Bank or Left Bank</td>		
			<td colspan="<?php echo $right; ?>">B - Bank or Right Bank</td>
			<td rowspan="2" align="center" style="padding-top: 30px">Remarks</td>
			<td rowspan="2" align="center" style="padding-top: 30px">Inspected</td>
			<td rowspan="2" align="center" style="padding-top: 30px">Cleaned</td>
			<td rowspan="2" align="center" style="padding-top: 30px">Status</td>
			<td rowspan="2" align="center" style="padding-top: 30px">Location</td>
		</tr>
		<tr>
			<td><p style="width:100px">Part No.</p></td>
			<td></td>
			<td></td>
			<?php foreach($leftbank AS $lb){ ?>
			<td><p class="lbwidth"><?php echo $lb->bank_name; ?></p></td>

			<?php
			 } ?>
			<?php foreach($rightbank AS $rb){ ?>
			<td><p class="rbwidth"><?php echo $rb->bank_name; ?></p></td>
			<?php } ?>
		
		</tr>
		<tr>
			<td>1</td>
			<td colspan="2" >
				<p class="aseem" style="width:300px"><?php echo $assembly; ?></p>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<?php
			$l=0; 
			foreach($leftbank AS $lb){

				$plate = $CI->searchPlate($engine_id,$assembly_id,$lb->bank_id,"plate_no"); 
				//echo $plate;
				?>
			<td class="no-pad"><input type='text' class="texvox" placeholder="Plate No." style='width:70px' name='plate<?php echo $l; ?>' value="<?php echo (!empty($inventory) ? $plate : ''); ?>" ></td>
			<?php
			$l++;
			 } ?>
			<?php 
		
			foreach($rightbank AS $rb){ 
				$plate = $CI->searchPlate($engine_id,$assembly_id,$rb->bank_id,"plate_no"); 
				?>
			<td class="no-pad"><input type='text' class="texvox" placeholder="Plate No." style='width:70px' name='plate<?php echo $l; ?>' value="<?php echo (!empty($inventory) ? $plate : ''); ?>"></td>
			<?php
			$l++;
			 } ?>
			
	
		</tr>
		<!-- LOOP -->
		<?php 
		$x=0;
		
		foreach($items AS $it){
			$qty=array();
			$item=$it['item_id'];
		 ?>
		<tr>
			<td></td>
			<td>1.<?php echo $x; ?></td>
			<td><p class="aseem"><?php echo $it['item_name']; ?></p></td>
			<td><?php echo $it['pn_no']; ?></td>
			<td><?php echo $it['qty']; ?></td>
			<td><?php echo $it['uom']; ?></td>
			<!-- loop 9 times or 18 delete the rest-->
			<?php
			$qty=array();
			$y=0;
			 foreach($leftbank AS $lb){ 
			 	$qty = $CI->searchQty($engine_id,$assembly_id,$lb->bank_id,$item,"qty"); ?>
				
			<td class="no-pad">
				
				<input type="number" class="texvox" max="<?php echo $it['qty']; ?>" name="qty<?php echo $x; ?>[]" value="<?php echo (!empty($inventory) ? $qty : ''); ?>">
				<input type="hidden" class="texvox" name="bank<?php echo $x; ?>[]" value='<?php echo $lb->bank_id; ?>'>
				</td>


			<?php

			$y++;
			 } ?>
			<!-- loop -->

		
			<!-- loop 9 times -->
			<?php foreach($rightbank AS $rb){ 
				$qty = $CI->searchQty($engine_id,$assembly_id,$rb->bank_id,$item,"qty");
				?>
			<td class="no-pad"><input type="number" class="texvox" name="qty<?php echo $x; ?>[]" value="<?php echo (!empty($inventory) ? $qty : ''); ?>">
			<input type="hidden" class="texvox" name="bank<?php echo $x; ?>[]" value='<?php echo $rb->bank_id; ?>'></td>
			<?php
			$y++;

			 } 
			 $remarks =  $CI->searchValue($engine_id,$assembly_id,$item,"remarks"); 
			 $inspected =  $CI->searchValue($engine_id,$assembly_id,$item,"inspected"); 
			 $cleaned =  $CI->searchValue($engine_id,$assembly_id,$item,"cleaned"); 
			 $status =  $CI->searchValue($engine_id,$assembly_id,$item,"status"); 
			 $location =  $CI->searchValue($engine_id,$assembly_id,$item,"location"); 
			?>
			<!-- loop -->

				<td class="no-pad"><input class="texvox" type="text" name='remarks<?php echo $x; ?>' style='width:70px' value="<?php echo (!empty($inventory) ? $remarks : ''); ?>"></td>
			<td class="no-pad"><select class="texvox" name='inspected<?php echo $x; ?>'>
								<option value='' selected></option>
								<option value='Y' <?php echo (!empty($inventory) ? (($inspected=='Y') ? ' selected' : '') : ''); ?>>Y</option>
								<option value='N' <?php echo (!empty($inventory) ? (($inspected=='N') ? ' selected' : '') : ''); ?>>N</option>
								</select>
			</td>
			<td class="no-pad">
				<select class="texvox" name='cleaned<?php echo $x; ?>'>
					<option value='' selected></option>
					<option value='Y' <?php echo (!empty($inventory) ? (($cleaned=='Y') ? ' selected' : '') : ''); ?>>Y</option>
					<option value='N' <?php echo (!empty($inventory) ? (($cleaned=='N') ? ' selected' : '') : ''); ?>>N</option>
				</select>
			</td>
			<td class="no-pad"><input class="texvox" type="hidden" value="<?php echo $it['item_id']; ?>" name='item<?php echo $x; ?>'><input class="texvox" type='text' name='status<?php echo $x; ?>' value="<?php echo (!empty($inventory) ? $status : ''); ?>" style='width:70px'></td>
			<td class="no-pad"><input class="texvox" type='text' name='location<?php echo $x; ?>'  value="<?php echo (!empty($inventory) ? $location : ''); ?>" style='width:70px'></td>
		</tr>
		 
	<?php 
	
	$x++;
	} 

	$count_item = $x-1;
	if(!isset($y)){
		$y=0;
	} else{
		$y=$y;
	}
	?>

		<!-- loop -->	
		<input type='hidden' name='counter' value="<?php echo $y; ?>">
		<input type='hidden' name='counter_item' value="<?php echo $count_item; ?>">
		<input type='hidden' name='engine' value="<?php echo $engine_id; ?>">
		<input type='hidden' name='assembly' value="<?php echo $assembly_id; ?>">
		<input type='hidden' name='userid' value="<?php echo $_SESSION['user_id']; ?>">
	</table>

</div>

</form>

<script type="text/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>