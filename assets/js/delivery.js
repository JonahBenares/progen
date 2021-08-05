function chooseBuyer(){
    var loc= document.getElementById("baseurl11").value;
    var redirect = loc+'index.php/delivery/getBuyer';
    var buyer = document.getElementById("buyer").value;
    document.getElementById('alertbuy').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#procedure").hide(); 
    setTimeout(function() {
        document.getElementById('alertbuy').innerHTML=''; 
        $("#procedure").show(); 
    },5000);
    $.ajax({
            type: 'POST',
            url: redirect,
            data: 'buyer='+buyer,
            dataType: 'json',
            success: function(response){
               document.getElementById("address").value  = response.address;
               document.getElementById("contact_person").value  = response.contact_person;
               document.getElementById("contact_no").value  = response.contact_no;
           }
    }); 
}

function choosePRSSS(){
    var loc= document.getElementById("baseurl11").value;
    var redirect = loc+'index.php/delivery/getPRinformation';
    var prno = document.getElementById("prress").value;
    document.getElementById('alert').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#proceed").hide(); 
    setTimeout(function() {
        document.getElementById('alert').innerHTML=''; 
        $("#proceed").show(); 
    },5000);
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'prno='+prno,
        dataType: 'json',
        success: function(response){
            $("#prress").val(response.pr_no);
            $("#endres").val(response.enduse);
            $("#deptres").val(response.department);
            $("#purres").val(response.purpose);
        }
    }); 
}

function chooseItem(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/delivery/getIteminformation';
    var item = document.getElementById("item").value;
    document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
    $("#submit").hide(); 
    setTimeout(function() {
        document.getElementById('alrt').innerHTML=''; 
        //$("#submit").show(); 
    },5000);
    $.ajax({
        type: 'POST',
        url: redirect,
        data: 'item='+item,
        dataType: 'json',
        success: function(response){
            $("#item_id").val(response.item_id);
            $("#item_name").val(response.item_name);
            $("#unit").val(response.unit);
            $("#original_pn").val(response.pn);
            $("#invqty").val(response.recqty);
            crossreferencing();
            balancePRItem();
        }
    }); 
}

function crossreferencing(){
    var itemid= document.getElementById("item_id").value;
     var loc= document.getElementById("baseurl").value;
    var redirectcr=loc+'/index.php/delivery/crossreflist';
    if(itemid!=""){
         $.ajax({
            type: "POST",
            url: redirectcr,
            data:'item='+itemid,
            success: function(data){
                $("#crossreference_list").html(data);
            }
          });
    } 
}

function getUnitCost(){
    var siid= document.getElementById("siid").value;
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getSIDetails';
     $.ajax({
            type: "POST",
            url: redirect,
            data: 'siid='+siid,
            beforeSend: function(){
                document.getElementById('alrt').innerHTML='<b>Please wait, Loading data...</b>'; 
                $("#submit").hide(); 
            },
            success: function(output){
                $("#submit").show(); 
                $('#alrt').hide();
                document.getElementById("unit_cost").value = output;
            }
    });
}


$(document).ready(function(){
    $("#quantity").keyup(function(){
        var x = document.getElementById("quantity").value;
        $('input[name="getmax"]').val(x);
    });
});

function balancePRItem(){
    var itemid= document.getElementById("item_id").value;
    var pr= document.getElementById("reqpr").value;
    var loc= document.getElementById("baseurl").value;
    var redirectcr=loc+'/index.php/delivery/checkpritem';
    if(itemid!=""){
         $.ajax({
            type: "POST",
            url: redirectcr,
            data:'item='+itemid+'&pr='+pr,
            success: function(output){
                alert("Available Balance for this Item: " + output);
                document.getElementById("maxqty").value = output;
            }
          });
    } 
}

function selectItem(id,val,unit,original_pn,qty) {
    $("#item_id").val(id);
    $("#item").val(val);
    $("#unit").val(unit);
    $("#original_pn").val(original_pn);
    $("#invqty").val(qty);
   
     crossreferencing();
     balancePRItem();
     $("#suggestion-item").hide();
}

function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/delivery/getitem';
	var itemid =$('#item_id').val();
    var itemname =$('#item_name').val();
    var original_pn =$('#original_pn').val();
    var unit =$('#unit').val();
    var serial =$('#serial').val();
    var quantity =parseFloat($('#qty').val());
    var selling =parseFloat($('#selling').val());
    var discount =parseFloat($('#discount').val());
    var shipping =parseFloat($('#shipping').val());
    var maxqty = parseFloat(document.getElementById("maxqty").value);
    var siid =$('#siid').val();
    var total =  (parseFloat(selling) * parseFloat(quantity)) - parseFloat(discount);
    
    var item =$('#item').val();
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");

    if(itemid==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    } else if(siid==''){
         alert('Cross Reference must not be empty.');
    }else if(quantity==''){
         alert('Quantity must not be empty.');
    }else if(quantity>invqty){
         alert('Cannot request more than existing quantity!');
    } else {
		var rowCount = $('#item_body tr').length;
		count=rowCount+1;
		$.ajax({
				type: "POST",
				url:redirect,
				data: "itemid="+itemid+"&itemname="+itemname+"&siid="+siid+"&original_pn="+original_pn+"&unit="+unit+"&quantity="+quantity+"&item="+item+"&count="+count+"&selling="+selling+"&discount="+discount+"&shipping="+shipping+"&total="+total+"&serial="+serial,
		    	success: function(html){
		    	$('#item_body').append(html);
		    	$('#itemtable').show();
		    	$('#savebutton').show();
                $('.select2-selection__rendered').empty();
		    	document.getElementById("item_id").value = '';
		        document.getElementById("item_name").value = '';
		        document.getElementById("original_pn").value = '';
                document.getElementById("unit").value = '';
		        document.getElementById("serial").value = '';
                document.getElementById("qty").value = '';
                document.getElementById("selling").value = '';
                document.getElementById("discount").value = '';
		        document.getElementById("shipping").value = '';
                document.getElementById("total").value = '';
		        document.getElementById("item").value = '';
                document.getElementById("siid").value = '';
		        document.getElementById("counter").value = count;
		    }
		});
    }     
}

function remove_item(i){
    $('#item_row'+i).remove();
    var rowCount = $('#item_body tr').length;
    if(rowCount==0){
    	$('#savebutton').hide();
    } else {
    	$('#savebutton').show();
    }
     
}

function saveBuyer(){
    var req = $("#Buyerfrm").serialize();
    var loc= document.getElementById("baseurl").value;
    //var redirect = loc+'index.php/request/insertRequest';
    var conf = confirm('Are you sure you want to save this record?');
    if(conf==true){
        var redirect = loc+'index.php/delivery/insertBuyer';
    }else {
        var redirect = '';
    }
     $.ajax({
            type: "POST",
            url: redirect,
            data: req,
            beforeSend: function(){
                document.getElementById('alt').innerHTML='<b>Please wait, Saving Data...</b>'; 
                $("#savebutton").hide(); 
            },
            success: function(output){
                //var conf = confirm('Are you sure you want to save this record?');
                if(conf==true){
                    alert("Successfully Saved!");
                    location.reload();
                    window.open(loc+'index.php/delivery/delivery_receipt/'+output, '_blank');
                }
            }
      });
}

$(document).on('click', '#getD', function(e){
    e.preventDefault();
    var uid = $(this).data('id');    
    var loc= document.getElementById("baseurl").value;
    var redirect1=loc+'/index.php/delivery/edit_endpurp';
    $.ajax({
          url: redirect1,
          type: 'POST',
          data: 'id='+uid,
        beforeSend:function(){
            $("#ep").html('Please wait ..');
        },
        success:function(data){
           $("#ep").html(data);
        },
    })
});