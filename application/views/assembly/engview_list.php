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
<!-- <select class="form-control" style="width: 30%">
	<option>---Select--</option>
</select> -->
<div id="printableArea">
	<table class="table table-bordered" style="margin-bottom: 70px" >
		
		<?php 
			$a=1;
			foreach($assembly AS $as){ 
				$bank_type = $CI->getbanktype($as->bh_id);
				$leftbank = $CI->get_left_bank($as->bh_id, $bank_type);
				$rightbank = $CI->get_right_bank($as->bh_id, $bank_type);
				$left= $CI->get_left($as->bh_id, $bank_type);
				$right= $CI->get_right($as->bh_id, $bank_type);
				if(!isset($as->bh_id)){
		?>

		<tr>
			<td colspan="3" rowspan="2">
				<?php ////if($a==1){ ?>
				<h2 style="width:500px"><?php echo $engine_name; ?></h2>
				<?php ////} ?>
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

			<?php  foreach($leftbank AS $lb){ ?>
			<td><p class="lbwidth"><?php echo $lb->bank_name; ?></p></td>
			<?php } 

			foreach($rightbank AS $rb){ ?>
			<td><p class="lbwidth"><?php echo $rb->bank_name; ?></p></td>

			<?php } ?>
			
		</tr>
		<tr>
			<td><?php echo $a; ?></td>
			<td colspan="2" >
				<p class="aseem" style="width:300px"><?php echo $as->assembly_name; ?></p>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<?php  foreach($leftbank AS $lb){ 
				$plate = $CI->searchPlate($engine_id,$as->assembly_id,$lb->bank_id,"plate_no");
				?>
			<td><?php echo $plate; ?></td>
			<?php } 
			foreach($rightbank AS $rb){ 
				$plate = $CI->searchPlate($engine_id,$as->assembly_id,$rb->bank_id,"plate_no"); ?>
			<td><?php echo $plate; ?></td>
			<?php } 

			
			?>
			
			<td></td>
			<td></td>
			<td></td>
			<td></td>	
		</tr>
		<!-- LOOP -->
		<?php
		$i=1; 
		foreach($items AS $it){ 
			if($as->assembly_id == $it['assembly_id']){ ?>
		<tr>
			<td></td>
			<td><?php echo $a.".".$i; ?></td>
			<td><p class="aseem" style="width:300px"><?php echo $it['item_name']; ?></p></td>
			<td><?php echo $it['pn_no']; ?></td>
			<td><?php echo $it['qty']; ?></td>
			<td><?php echo $it['uom']; ?></td>

			<?php  foreach($leftbank AS $lb){ 
				$qty = $CI->searchQty($engine_id,$as->assembly_id,$lb->bank_id,$it['item_id'],"qty"); 
				$req_qty = $CI->getReqQty($engine_id,$as->assembly_id,$it['item_id']); 

				if($req_qty!=0){
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0 && $qty < $req_qty) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					} else if($qty==$req_qty){ 
						$q = "<span class='fa fa-check'></span>";
					} 
				} else {
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					}
				}?>
			<td><?php echo $q; ?></td>
			<?php } 
			foreach($rightbank AS $rb){ 
				$qty = $CI->searchQty($engine_id,$as->assembly_id,$rb->bank_id,$it['item_id'],"qty"); 
				$req_qty = $CI->getReqQty($engine_id,$as->assembly_id,$it['item_id']); 
				if($req_qty!=0){

					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0 && $qty < $req_qty) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					} else if($qty==$req_qty){ 
						$q = "<span class='fa fa-check'></span>";
					} 
				}  else {
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					}
				}?>


			<td><?php echo $q; ?></td>
			<?php } 

			$remarks = $CI->searchQty($engine_id,$as->assembly_id,$lb->bank_id,$it['item_id'],"remarks"); 
			$inspected = $CI->searchQty($engine_id,$as->assembly_id,$lb->bank_id,$it['item_id'],"inspected"); 
			$cleaned = $CI->searchQty($engine_id,$as->assembly_id,$lb->bank_id,$it['item_id'],"cleaned"); 
			$status = $CI->searchQty($engine_id,$as->assembly_id,$lb->bank_id,$it['item_id'],"status"); 
			$location = $CI->searchQty($engine_id,$as->assembly_id,$lb->bank_id,$it['item_id'],"location"); 
			?>
		
			<td><?php echo $remarks; ?></td>
			<td><?php echo $inspected; ?></td>
			<td><?php echo $cleaned; ?></td>
			<td><?php echo $status; ?></td>	
			<td><?php echo $location; ?></td>	
		</tr>
		<?php 
		$i++;
			}

		} ?>
		<!-- loop -->
		<?php }else if(isset($as->bh_id) && $bank_type == 'No Left/Right'){
		/*echo "hello hello hello";*/
		
		 ?>
		<tr>
			<td colspan="3" rowspan="2">
				<?php //if($a==1){ ?>
				<h2 style="width:500px"><?php echo $engine_name; ?></h2>
				<?php //} ?>
			</td>
			<td></td>
			<td>Qty</td>
			<td>Units</td>		
			<td colspan="<?php echo $left; ?>">A - Bank or Left Bank</td>		
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
			<?php  foreach($leftbank AS $lb){ ?>
			<td><p class="lbwidth"><?php echo $lb->bank_name; ?></p></td>
			<?php } ?>
			<!-- <td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>			
			<td><p class="lbwidth"></p></td> -->			
			
		</tr>
		<tr>
			<td><?php echo $a; ?></td>
			<td colspan="2" >
				<p class="aseem" style="width:300px"><?php echo $as->assembly_name; ?></p>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<?php  foreach($leftbank AS $lb){ 
				$plate = $CI->searchNolrplate($engine_id,$as->assembly_id,$lb->bd_id,"plate_no");
			?>		
			<td align="center"><?php echo $plate; ?></td>
			<?php } ?>
			<td></td>
			<td></td>
			<td></td>
			<td></td>

		</tr>
		<!-- LOOP -->
		<?php
			$i=1; 
			foreach($items AS $it){ 
				if($as->assembly_id == $it['assembly_id']){ ?>
		<tr>
			<td></td>
			<td><?php echo $a.".".$i; ?></td>
			<td><p class="aseem" style="width:300px"><?php echo $it['item_name']; ?></p></td>
			<td><?php echo $it['pn_no']; ?></td>
			<td><?php echo $it['qty']; ?></td>
			<td><?php echo $it['uom']; ?></td>
			<?php  foreach($leftbank AS $lb){ 
				$qty = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"qty"); 
				$req_qty = $CI->getReqQty($engine_id,$as->assembly_id,$it['item_id']); 
				if($req_qty!=0){
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0 && $qty < $req_qty) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					} else if($qty==$req_qty){ 
						$q = "<span class='fa fa-check'></span>";
					} 
				} else {
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					}
				}
			?>
			<td><?php echo $q; ?></td>
			<?php 
				}
				$remarks = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"remarks"); 
				$inspected = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"inspected"); 
				$cleaned = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"cleaned"); 
				$status = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"status"); 
				$location = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"location"); 
			?>
			<td><?php echo $remarks; ?></td>
			<td><?php echo $inspected; ?></td>
			<td><?php echo $cleaned; ?></td>	
			<td><?php echo $status; ?></td>	
			<td><?php echo $location; ?></td>	
		</tr>
		<!-- loop -->
		<?php $i++; } } ?>
		<?php } else if(isset($as->bh_id) && $bank_type == 'With Left/Right'){ ?>
		<tr>
			<td colspan="3" rowspan="2">
				<?php //if($a==1){ ?>
				<h2 style="width:500px"><?php echo $engine_name; ?></h2>
				<?php //} ?>
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
			<?php  foreach($leftbank AS $lb){ ?>
			<td><p class="lbwidth"><?php echo $lb->bank_name; ?></p></td>
			<?php } foreach($rightbank AS $rb){ ?>
			<td><p class="lbwidth"><?php echo $rb->bank_name; ?></p></td>
			<?php } ?>	
		</tr>
		<tr>
			<td><?php echo $a; ?></td>
			<td colspan="2" >
				<p class="aseem" style="width:300px"><?php echo $as->assembly_name; ?></p>
			</td>
			<td></td>
			<td></td>
			<td></td>
			<?php  foreach($leftbank AS $lb){ 
				$plate = $CI->searchNolrplate($engine_id,$as->assembly_id,$lb->bd_id,"plate_no");
			?>
			<td align="center"><?php echo $plate; ?></td>
			<?php } 
				foreach($rightbank AS $rb){ 
				$plate = $CI->searchNolrplate($engine_id,$as->assembly_id,$rb->bd_id,"plate_no"); 
			?>
			<td align="center"><?php echo $plate; ?></td>
			<?php } ?>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
		</tr>
		<!-- LOOP -->
		<?php
			$i=1; 
			foreach($items AS $it){ 
				if($as->assembly_id == $it['assembly_id']){ 
		?>
		<tr>
			<td></td>
			<td><?php echo $a.".".$i; ?></td>
			<td><p class="aseem" style="width:300px"><?php echo $it['item_name']; ?></p></td>
			<td><?php echo $it['pn_no']; ?></td>
			<td><?php echo $it['qty']; ?></td>
			<td><?php echo $it['uom']; ?></td>

			<?php  foreach($leftbank AS $lb){ 
				$qty = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"qty"); 
				$req_qty = $CI->getReqQty($engine_id,$as->assembly_id,$it['item_id']); 

				if($req_qty!=0){
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0 && $qty < $req_qty) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					} else if($qty==$req_qty){ 
						$q = "<span class='fa fa-check'></span>";
					} 
				} else {
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					}
				}?>
			<td><?php echo $q; ?></td>
			<?php } 
			foreach($rightbank AS $rb){ 
				$qty = $CI->searchNolrqty($engine_id,$as->assembly_id,$rb->bd_id,$it['item_id'],"qty"); 
				$req_qty = $CI->getReqQty($engine_id,$as->assembly_id,$it['item_id']); 
				if($req_qty!=0){

					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0 && $qty < $req_qty) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					} else if($qty==$req_qty){ 
						$q = "<span class='fa fa-check'></span>";
					} 
				}  else {
					if($qty == 0){
						$q = "<span style='color:red; font-weight:bold'>0</span>";
					} else if($qty>0) {
						$q = "<span style='color:red; font-weight:bold'>".$qty."</span>";
					}
				}?>


			<td><?php echo $q; ?></td>
			<?php } 

			$remarks = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"remarks"); 
			$inspected = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"inspected"); 
			$cleaned = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"cleaned"); 
			$status = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"status"); 
			$location = $CI->searchNolrqty($engine_id,$as->assembly_id,$lb->bd_id,$it['item_id'],"location"); 
			?>
		
			<td><?php echo $remarks; ?></td>
			<td><?php echo $inspected; ?></td>
			<td><?php echo $cleaned; ?></td>
			<td><?php echo $status; ?></td>	
			<td><?php echo $location; ?></td>	
		</tr>
		<?php $i++; } } ?>
		<?php } ?>
		<tr>
			<td colspan="29"><br></td>
		</tr>
		<?php 
		$a++;
		} ?>
		

	</table>
</div>
<div style="position:fixed;width:100%;margin-left: 25%;bottom: 0;margin-bottom: 5px">
	<div style="width:50%">
		<button class="btn btn-lg btn-info btn-block" onclick="printDiv('printableArea')">Print</button>
	</div>
</div>

<script type="text/javascript">
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     document.body.innerHTML = printContents;
     window.print();
     document.body.innerHTML = originalContents;
}
</script>