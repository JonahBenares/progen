$(document).ready(function(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/reports/itemlist';
	$("#item").keyup(function(){
	      $.ajax({
	        type: "POST",
	        url: redirect,
	        data:'item='+$(this).val(),
	        beforeSend: function(){
	            $("#item").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
	        },
	        success: function(data){
	            $("#suggestion-item").show();
	            $("#suggestion-item").html(data);
	            $("#item").css("background","#FFF");
	        }
	      });
	 });
	$("#supplier").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/reports/supplierlist';
	      $.ajax({
	        type: "POST",
	        url: redirect,
	        data:'supplier='+$(this).val(),
	        beforeSend: function(){
	            $("#supplier").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
	        },
	        success: function(data){
	            $("#suggestion-supplier").show();
	            $("#suggestion-supplier").html(data);
	            $("#supplier").css("background","#FFF");
	        }
	      });
	 });

    $("#brand").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/reports/brandlist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'brand='+$(this).val(),
            beforeSend: function(){
                $("#brand").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-brand").show();
                $("#suggestion-brand").html(data);
                $("#brand").css("background","#FFF");
            }
          });
     });

	$("#pr").keyup(function(){
	var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/reports/prlist';
	      $.ajax({
	        type: "POST",
	        url: redirect,
	        data:'pr='+$(this).val(),
	        beforeSend: function(){
	            $("#pr").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
	        },
	        success: function(data){
	            $("#suggestion-pr").show();
	            $("#suggestion-pr").html(data);
	            $("#pr").css("background","#FFF");
	        }
	      });
	 });
});

function selectPr(id,val) {
    $("#prid").val(id);
    $("#pr").val(val);
    $("#suggestion-pr").hide();
}

function selectItem(id,val,unit) {
    $("#item_id").val(id);
    $("#item").val(val);
    $("#unit").val(unit);
    $("#suggestion-item").hide();
}

function selectSupplier(id, val) {
    $("#supplier_id").val(id);
    $("#supplier").val(val);
    $("#suggestion-supplier").hide();
}

function selectBrand(id, val) {
    $("#brand_id").val(id);
    $("#brand").val(val);
    $("#suggestion-brand").hide();
}

function inventoryReport(){
	var id= document.getElementById("item_id").value;
	
	var loc= document.getElementById("baseurl").value;

	window.location.href = loc+'/index.php/reports/inventoryReport/'+id;
}

function replenishBorrow(id, baseurl){
	
	if(confirm("Are you sure you want to replenish?")){
		var redirect=baseurl+'/index.php/reports/replenishborrow';
		$.ajax({
		    type: "POST",
		    url: redirect,
		    data:'id='+id,
		    success: function(output){
		        if(output=='ok'){
		        	alert('Product successfully replenished!');
		        	window.location.href = baseurl+'index.php/reports/borrowing_report';
		        }
		    }
		});
	} 
}

function chooseCategory(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/reports/getCat';
    var category = document.getElementById("category").value;
    $.ajax({
            type: 'POST',
            url: redirect,
            data: 'category='+category,
            success: function(data){
                $("#subcat").html(data);
           }
    }); 
}