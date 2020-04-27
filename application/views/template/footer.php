		<div class="col-sm-12" id="footer">
				<p class="back-link">Warehouse Inventory System || <a href="http://www.cenpripower.com">PROGEN</a></p>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	</div>
	<link href="<?php echo base_url(); ?>assets/Styles/select2.min.css" rel="stylesheet" />
	<script src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>
	<script>
	    $('.select2').select2();
	</script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.1.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/chart-data.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/easypiechart.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/easypiechart-data.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/custom.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
	<script>
		window.onload = function () {
			var	myVar;
			myVar	=setTimeout(showPage,2000);					
					
			/*var chart1 = document.getElementById("line-chart").getContext("2d");
			window.myLine = new Chart(chart1).Line(lineChartData, {
			responsive: true,
			scaleLineColor: "rgba(0,0,0,.2)",
			scaleGridLineColor: "rgba(0,0,0,.05)",
			scaleFontColor: "#c5c7cc"
			});*/
		};

		function showPage() {
			document.getElementById("loader").style.display = "none";
			document.getElementById("itemslist").style.display = "block";
			
		}

		$(document).ready( function () {
		    $('#item_table').DataTable({
		    	"aaSorting": [[ 0, "asc" ]],
		    	"pageLength": 25
		    });
		    $('#aging_table').DataTable({
		    	"aaSorting": [ [ 1, "asc" ]],
		    	"pageLength": 50
		    });
		    $('#aging_table2').DataTable({
		    	"aaSorting": [[ 0, "asc" ]],
		    	"pageLength": 25
		    });
		    
		    $('#received').DataTable({
		    	 "aaSorting": [[ 0, "desc" ] ]
		    });
		    $('#request_datatable').DataTable({
		    	"aaSorting": [[ 0, "desc" ], [ 1, "desc" ]]
		    });
		} );
		function confirmationDelete(anchor){
	        var conf = confirm('Are you sure you want to delete this record?');
	        if(conf)
	        window.location=anchor.attr("href");
    	}
	</script>
	<script type="text/javascript">
		$(document).ready(function () {    
	        $("#submitButton").click(function (e) {  
	            if (($("#file").val() == "")) { 
	                alert("You must not leave the field empty!");  
	            }
	            else {  
	            	$('#loda').modal('show');
					document.getElementById("loading").style.display = "block";
	                $.ajax({  
	                    type: "POST",   
	                    dataType: "json",  
	                    success: function (msg) {  
	                        setTimeout(function () {
				                $('#loading').html('<?php echo base_url();?>index.php/masterfile/import_items');
				            }, 2000);  
	                    },  
	                });  
	            }   
	        });  
	    });
	    $(document).ready(function () {    
	        $("#submit").click(function (e) {  
	            if (($("#file1").val() == "")) { 
	                alert("You must not leave the field empty!");  
	            }
	            else {  
	            	$('#loads').modal('show');
					document.getElementById("loading").style.display = "block";
	                $.ajax({  
	                    type: "POST",   
	                    dataType: "json",  
	                    success: function (msg) {  
	                        setTimeout(function () {
				                $('#loading').html('<?php echo base_url();?>index.php/masterfile/import_items');
				            }, 2000);  
	                    },  
	                });  
	            }   
	        });  
	    });
	    
	</script>
	<script>
		document.getElementById('e').value = new Date().toISOString().substring(0, 10);
		document.getElementById('d').value = new Date().toISOString().substring(0, 10);
	</script>
	<!-- <script type="text/javascript">
		$(document).ready(function(){
	        $('.type').change(function(){
	            if($('.type option:selected').val() ==  'JO / PR' ){
	                $('.t').show();
	            }
	            else{
	                $('.t').slideUp();
	            }
	        });
	    });
	</script> -->
	<script type="text/javascript">
		// Get the modal
		var modal = document.getElementById('myModal1');

		// Get the image and insert it inside the modal - use its "alt" text as a caption
		var img = document.getElementById('pic1');
		var modalImg = document.getElementById("img01");
		var captionText = document.getElementById("caption");
		img.onclick = function(){
		    modal.style.display = "block";
		    modalImg.src = this.src;
		    modalImg.alt = this.alt;
		    captionText.innerHTML = this.alt;
		}
		// When the user clicks on <span> (x), close the modal
		modal.onclick = function() {
		    img01.className += " out";
		    setTimeout(function() {
		       modal.style.display = "none";
		       img01.className = "modal-content-new";
		     }, 400);    
		}

		// Get the modal
		var modal1 = document.getElementById('myModal2');

		// Get the image and insert it inside the modal - use its "alt" text as a caption
		var img1 = document.getElementById('pic2');
		var modalImg1 = document.getElementById("img02");
		var captionText1 = document.getElementById("caption");
		img1.onclick = function(){
		    modal1.style.display = "block";
		    modalImg1.src = this.src;
		    modalImg1.alt = this.alt;
		    captionText1.innerHTML = this.alt;
		}
		// When the user clicks on <span> (x), close the modal
		modal1.onclick = function() {
		    img02.className += " out";
		    setTimeout(function() {
		       modal1.style.display = "none";
		       img02.className = "modal-content-new";
		     }, 400);    
		}


		// Get the modal
		var modal2 = document.getElementById('myModal3');

		// Get the image and insert it inside the modal - use its "alt" text as a caption
		var img2 = document.getElementById('pic3');
		var modalImg2 = document.getElementById("img03");
		var captionText2 = document.getElementById("caption");
		img2.onclick = function(){
		    modal2.style.display = "block";
		    modalImg2.src = this.src;
		    modalImg2.alt = this.alt;
		    captionText2.innerHTML = this.alt;
		}
		// When the user clicks on <span> (x), close the modal
		modal2.onclick = function() {
		    img03.className += " out";
		    setTimeout(function() {
		       modal2.style.display = "none";
		       img03.className = "modal-content-new";
		     }, 400);    
		}

	</script>
	<script type="text/javascript">
		function printDiv(divName) {
		     var printContents = document.getElementById(divName).innerHTML;
		     var originalContents = document.body.innerHTML;
		     document.body.innerHTML = printContents;
		     window.print();
		     document.body.innerHTML = originalContents;
		}
		function showDiv(select){
			if(select.value=='No Left/Right'){
				document.getElementById('a').style.display = "block";
				document.getElementById('b').style.display = "none";
				document.getElementById('c').style.display = "none";
			}
			else if(select.value=='With Left/Right'){
				document.getElementById('a').style.display = "none";
				document.getElementById('b').style.display = "block";
				document.getElementById('c').style.display = "block";
			}
			else{
				document.getElementById('a').style.display = "none";
				document.getElementById('b').style.display = "none";
				document.getElementById('c').style.display = "none";
			}
		}  
	</script>

	<script type="text/javascript">
		function showBank(select){
			if(select.value=='No Left/Right'){
				document.getElementById('a').style.display = "block";
				document.getElementById('b').style.display = "none";
			}
			else if(select.value=='With Left/Right'){
				document.getElementById('a').style.display = "none";
				document.getElementById('b').style.display = "block";
			}
			else{
				document.getElementById('a').style.display = "block";
				document.getElementById('b').style.display = "none";
			}
		}

		function showLoc(select){
			if(select.value=='A'){
				document.getElementById('c').style.display = "block";
				document.getElementById('d').style.display = "none";
			}
			else if(select.value=='B'){
				document.getElementById('c').style.display = "none";
				document.getElementById('d').style.display = "block";
			}
			else{
				document.getElementById('c').style.display = "none";
				document.getElementById('d').style.display = "none";
			}
		}
	</script>
</body>
</html>