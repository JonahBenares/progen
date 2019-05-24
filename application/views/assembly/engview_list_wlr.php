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
<div id="printableArea">
	<table class="table table-bordered" style="margin-bottom: 70px" >
			<tr>
			<td colspan="3" rowspan="2">
				<h2 style="width:500px">DG1 Pielstick</h2>
			</td>
			<td></td>
			<td>Qty</td>
			<td>Units</td>		
			<td colspan="10">A - Bank or Left Bank</td>		
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
			<td><p class="lbwidth"></p></td>			
			
		</tr>
		<tr>
			<td>2</td>
			<td colspan="2" >
				<p class="aseem" style="width:300px">Rocker Arm Assembly</p>
			</td>
			<td></td>
			<td></td>
			<td></td>
						
			<td colspan="10" align="center">Plate Number na d</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>

		</tr>
		<!-- LOOP -->
			<td></td>
			<td>1.2</td>
			<td><p class="aseem" style="width:300px">23 Stud Bolt PF 10-25</p></td>
			<td></td>
			<td>6</td>
			<td>kg</td>


			<td colspan="10"><span class='fa fa-check'></span></td>


			<td></td>
			<td></td>
			<td></td>
			<td></td>	
			<td></td>	
		</tr>
		<!-- loop -->

		<tr>
			<td colspan="29"><br></td>
		</tr>

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