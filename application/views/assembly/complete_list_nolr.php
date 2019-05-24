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

<div id="printableArea">	
	<table class="table table-bordered" style="margin-bottom: 70px">
		<tr>
			<td colspan="3" rowspan="2">
				<h2 style="width:500px">ENGINE NAME HERE</h2>
			</td>
			<td></td>
			<td>Qty</td>
			<td>Units</td>		
			<td colspan="18">DIGIMON</td>	
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
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>
			<td><p class="lbwidth"></p></td>

			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>
			<td><p class="rbwidth"></p></td>


		</tr>

		<tr>
			<td>1</td>
			<td colspan="2" >
				<p class="aseem" style="width:300px">ASSEMBLY NAME HERE</p>
			</td>
			<td></td>
			<td></td>
			<td></td>

			<!-- loop here and add colspan 2 upto 18	start -->
			<td class="no-pad" colspan="18"><input type='text' class="texvox" placeholder="Plate No." style='width:100%' name='' value="" ></td>
			<!-- loop here and add colspan 2 upto 18	end -->
			
		</tr>
		<tr>

			<td></td>
			<td>1.5</td>
			<td><p class="aseem">23 Stud Bolt PF 10-25</p></td>
			<td></td>
			<td></td>
			<td></td>

			<!-- loop here and add colspan 2 upto 18	start -->	
			<td class="no-pad" align="center" colspan="18"><input type="number" class="texvox" max="" name="" value=""></td>
			<!-- loop here and add colspan 2 upto 18	end -->


			<td class="no-pad"><input class="texvox" type="text" name='' style='width:70px' value=""></td>
			<td class="no-pad">
				<select class="texvox" name=''>
					<option value='' selected></option>
					<option value='Y' >Y</option>
					<option value='N' >N</option>
				</select>
			</td>
			<td class="no-pad">
				<select class="texvox" name='cleaned<?php echo $x; ?>'>
					<option value='' selected></option>
					<option value='Y' >Y</option>
					<option value='N' >N</option>
				</select>
			</td>
			<td class="no-pad"><input class="texvox" type="hidden" value="" name=''><input class="texvox" type='text' name='' value="" style='width:70px'></td>
			<td class="no-pad"><input class="texvox" type='text' name=''  value="" style='width:70px'></td>
		</tr>

		<!-- loop -->	
	</table>
</div>
<div style="position:fixed;width:100%;margin-left: 25%;bottom: 0;margin-bottom: 5px">
	<div style="width:50%">
		<button type='submit' class="btn btn-lg btn-info btn-block">Save</button>
		<!-- <button class="btn btn-lg btn-info btn-block" onclick="printDiv('printableArea')">Save & Print</button> -->
	</div>
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