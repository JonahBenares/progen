function choosePR(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getPR';
    var prno = document.getElementById("prno").value;
    $.ajax({
            type: 'POST',
            url: redirect,
            data: 'prno='+prno,
            dataType: 'json',
            success: function(response){
               document.getElementById("department").value  = response.dept;
               document.getElementById("purpose").value  = response.pur;
               document.getElementById("enduse").value  = response.end;
           }
    }); 
}

$(document).on('click', '#getEP', function(e){
    e.preventDefault();
    var uid = $(this).data('id');    
    var loc= document.getElementById("baseurl").value;
    var redirect1=loc+'/index.php/request/edit_endpurp';
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

$(document).ready(function(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/request/itemlist';
 	
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

});


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

function crossreferencing(){
    var itemid= document.getElementById("item_id").value;
     var loc= document.getElementById("baseurl").value;
    var redirectcr=loc+'/index.php/request/crossreflist';
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

function balancePRItem(){
    var itemid= document.getElementById("item_id").value;
    var pr= document.getElementById("reqpr").value;
    var loc= document.getElementById("baseurl").value;
    var redirectcr=loc+'/index.php/request/checkpritem';
    if(itemid!=""){
         $.ajax({
            type: "POST",
            url: redirectcr,
            data:'item='+itemid+'&pr='+pr,
            success: function(output){
                alert(output);
            }
          });
    } 
}



function isNumberKey(evt){
   var charCode = (evt.which) ? evt.which : event.keyCode;
    var number = el.value.split('.');
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    //just one dot (thanks ddlab)
    if(number.length>1 && charCode == 46){
         return false;
    }
    //get the carat position
    var caratPos = getSelectionStart(el);
    var dotPos = el.value.indexOf(".");
    if( caratPos > dotPos && dotPos>-1 && (number[1].length > 1)){
        return false;
    }
    return true;
}

//thanks: http://javascript.nwbox.com/cursor_position/
function getSelectionStart(o) {
    if (o.createTextRange) {
        var r = document.selection.createRange().duplicate()
        r.moveEnd('character', o.value.length)
        if (r.text == '') return o.value.length
        return o.value.lastIndexOf(r.text)
    } else return o.selectionStart
}


function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/request/getitem';


	var itemid =$('#item_id').val();
    var borrowfrom =$('#borrowfrom').val();
    var original_pn =$('#original_pn').val();
    var unit =$('#unit').val();
    /*var invqty =$('#invqty').val();*/
    var quantity =$('#quantity').val();
    var unit_cost =$('#unit_cost').val();
    var siid =$('#siid').val();
    
    var item =$('#item').val();
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");

    if(itemid==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    } else if(siid==''){
         alert('Cross Reference must not be empty.');
    } else if(quantity==''){
         alert('Quantity must not be empty.');
    } else {
    	  var rowCount = $('#item_body tr').length;
    	  count=rowCount+1;
    	  $.ajax({
    	 		type: "POST",
    	 		url:redirect,
    	 		data: "itemid="+itemid+"&siid="+siid+"&original_pn="+original_pn+"&unit="+unit+"&cost="+unit_cost+"&quantity="+quantity+"&item="+item+"&count="+count+"&borrow="+borrowfrom,
                success: function(html){
                	$('#item_body').append(html);
                	$('#itemtable').show();
                	$('#savebutton').show();
                	document.getElementById("item_id").value = '';
                    document.getElementById("original_pn").value = '';
                    document.getElementById("unit").value = '';
                    document.getElementById("unit_cost").value = '';
                    document.getElementById("invqty").value = '';
                    document.getElementById("quantity").value = '';
                    document.getElementById("item").value = '';
                    document.getElementById("siid").value = '';
                    document.getElementById("borrowfrom").value = '';
                    document.getElementById("counter").value = count;
                }
           });
    }
          
}

function saveRequest(){
    var req = $("#Requestfrm").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/insertRequest';
     $.ajax({
            type: "POST",
            url: redirect,
            data: req,
            success: function(output){
                alert("Request successfully Added!");
                /*window.location = loc+'index.php/request/mreqf/'+output;*/
                location.reload();
                window.open(loc+'index.php/request/mreqf/'+output, '_blank');
               //alert(output);
            }
      });
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


function printMReqF(){
    var sign = $("#mreqfsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/printMReqF';
     $.ajax({
            type: "POST",
            url: redirect,
            data: sign,
            success: function(output){
                if(output=='success'){
                    window.print();
                }
                //alert(output);
                
            }
    });
}

function getUnitCost(){
    var siid= document.getElementById("siid").value;
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/getSIDetails';
     $.ajax({
            type: "POST",
            url: redirect,
            data: 'siid='+siid,
            success: function(output){
                document.getElementById("unit_cost").value = output;
            }
    });
}
