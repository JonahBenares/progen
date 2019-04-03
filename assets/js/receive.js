    
    var isOpen = "false";
    var newwindow=null;
function openAddNewPR(baseurl, id) {

if (isOpen == "false") {
        isOpen = "true"; 
	    window.open(baseurl+"index.php/receive/add_receive_second/"+id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=600");
    } else {
        newwindow.location.href = url;
        newwindow.focus();
    }
}

function updateReceivePR(baseurl, id, rdid) {
        window.open(baseurl+"index.php/receive/add_receive_second/"+id+"/"+rdid, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=50,left=25,width=1300,height=500");
}


$(document).ready(function(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/receive/itemlist';
    var rdid= document.getElementById("rdid").value;
    if(rdid==0){
	   $('#savebutton').hide();
    } else {
        $('#savebutton').show();
    }
	/*$('#itemtable').hide();*/
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
        var redirect=loc+'/index.php/receive/supplierlist';
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
        var redirect=loc+'/index.php/receive/brandlist';
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


    /*$("#purpose").keyup(function(){
        document.getElementById("purpose_id").value = "";
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/purposelist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'purpose='+$(this).val(),
            beforeSend: function(){
                $("#purpose").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-purpose").show();
                $("#suggestion-purpose").html(data);
                $("#purpose").css("background","#FFF");
            }
          });
     });*/

     $("#serial").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/seriallist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'serial='+$(this).val(),
            beforeSend: function(){
                $("#serial").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){
                $("#suggestion-serial").show();
                $("#suggestion-serial").html(data);
                $("#serial").css("background","#FFF");
            }
          });
     });

     $("#prno").keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/receive/prnolist';
          $.ajax({
            type: "POST",
            url: redirect,
            data:'prno='+$(this).val(),
            beforeSend: function(){
                $("#prno").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
            },
            success: function(data){


                $("#suggestion-prno").show();
                $("#suggestion-prno").html(data);
                $("#prno").css("background","#FFF");
            }
          });
     });
});

function selectItem(id,val,unit,original_pn) {
    $("#item_id").val(id);
    $("#item").val(val);
    $("#unit").val(unit);
    $("#original_pn1").val(original_pn);
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

function selectSerial(id, val) {
    $("#serial_id").val(id);
    $("#serial").val(val);
    $("#suggestion-serial").hide();
}

/*function selectPurpose(id, val) {
    $("#purpose_id").val(id);
    $("#purpose").val(val);
    $("#suggestion-purpose").hide();
}*/

function selectPRNO(valu,dept,enduse,purposeid,purpose1) {
 
 
    $("#prno").val(valu);
    $("#department").val(dept);
    $("#enduse").val(enduse);
    $("#purpose").val(purposeid);
 //   $("#purpose").val(purpose1);
  
   /* $("#purpose_id").val(purposeid);*/
    
    $("#department").css({"pointer-events": "none"});
    $("#enduse").css({"pointer-events": "none"});
    $("#purpose").css({"pointer-events": "none"});
    /*$("#purpose").attr('disabled','disabled');*/
    $("#suggestion-prno").hide();
}

function add_item(){
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/receive/getitem';

	var supplier =$('#supplier').val();
	var supplierid =$('#supplier_id').val();
	var itemid =$('#item_id').val();
    var brand =$('#brand').val();
    var brandid =$('#brand_id').val();
    var serial =$('#serial').val();
    var serialid =$('#serial_id').val();
    var unitcost =$('#unit_cost').val();
    var catno =$('#catalog_no').val();
    var nkk =$('#nkk_no').val();
    var semt =$('#semt_no').val();
    var unit =$('#unit').val();
    var expqty =$('#exp_qty').val();
    var recqty =$('#rec_qty').val();
    var remarks =$('#remarks').val();
    if ($("input:radio[name=local_mnl]:checked").val() == '1') {
        var local_mnl = '1';
    } 
    else if($("input:radio[name=local_mnl]:checked").val() == '2'){
        var local_mnl = '2';
    }
    /*var local =$('#local').val();
    var manila =$('#manila').val();*/
   /*var q = $("input:radio[name=local_mnl]:checked").val();
   alert(q);*/
    //var local = $("input:radio[name=local_mnl]:checked").val();
    /*alert(local);*/
    /*var inspected =$('#inspected').val();*/
    var item =$('#item').val();
    var i = item.replace(/&/gi,"and");
    var i = i.replace(/#/gi,"");
    var itm = i.replace(/"/gi,"");
    if(supplierid==''){
         alert('Supplier must not be empty. Please choose/click from the suggested supplier list.');
    } else if(itemid==''){
         alert('Item must not be empty. Please choose/click from the suggested item list.');
    }
     else {
    	  var rowCount = $('#item_body tr').length;
    	  count=rowCount+1;
    	  $.ajax({
    	 		type: "POST",
    	 		url:redirect,
    	 		data: "supplier="+supplier+"&supplierid="+supplierid+"&itemid="+itemid+"&brand="+brand+"&brandid="+brandid+"&serial="+serial+"&serialid="+serialid+"&unitcost="+unitcost+"&catno="+catno+"&nkk="+nkk+"&semt="+semt+"&unit="+unit+"&expqty="+expqty+"&recqty="+recqty+"&remarks="+remarks+"&item="+item+"&count="+count+"&local_mnl="+local_mnl,
                success: function(html){
                    //alert(html);
                	$('#item_body').append(html);
                	$('#savebutton').show();
                	$('#itemtable').show();
                	document.getElementById("supplier").value = '';
                    document.getElementById("supplier_id").value = '';
                    document.getElementById("item_id").value = '';
                    document.getElementById("unit").value = '';
                    document.getElementById("exp_qty").value = '';
                    document.getElementById("rec_qty").value = '';
                    document.getElementById("remarks").value = '';
                    document.getElementById("item").value = '';
                    document.getElementById("brand").value = '';
                    document.getElementById("brand_id").value = '';
                    document.getElementById("serial").value = '';
                    document.getElementById("serial_id").value = '';
                    document.getElementById("catalog_no").value = '';
                    document.getElementById("nkk_no").value = '';
                    document.getElementById("semt_no").value = '';
                    document.getElementById("unit_cost").value = '';
                  
                   /* document.getElementById("inspected").value = '';*/
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
    	$('#itemtable').hide();
    } else {
    	$('#savebutton').show();
    	$('#itemtable').show();
    }
     
}

function isNumberKey(txt, evt){
   var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode == 46) {
        //Check if the text already contains the . character
        if (txt.value.indexOf('.') === -1) {
            return true;
        } else {
            return false;
        }
    } else {
        if (charCode > 31
             && (charCode < 48 || charCode > 57))
            return false;
    }
    return true;
}



 function savereceive_PR(){

     var prdata = $("#PRform").serialize();
   
    var prno = document.getElementById('prno').value;
    var department = document.getElementById('department').value;
    var enduse = document.getElementById('enduse').value;
    var purpose = document.getElementById('purpose').value;
    var inspected = document.getElementById('inspected').value;
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/insertReceivePR';
    if(prno==""){
        alert('Please fill out PR number.');
    } else if (department==""){ 
        alert('Please fill out Department.');
    } else if (enduse==""){ 
        alert('Please fill out Enduse.');
    } else if (purpose==""){ 
        alert('Please fill out Purpose.');
    } else if (inspected==""){ 
        alert('Please fill out Inspected By.');
    }else {
         $.ajax({
                type: "POST",
                url: redirect,
                data: prdata,
                success: function(output){
                    alert('PR successfully added.');
                    window.close();
                    window.opener.location.href=loc+'index.php/receive/add_receive_first/'+output;       
                    //alert(output);

                }
          });
    }
     
}

function deleteReceiveDetails(rdid,receiveid,baseurl){
    var redirect = baseurl+'index.php/receive/deleteRecDetails';
    var result = confirm("Are you sure you want to delete received PR?");
    if (result) {
          $.ajax({
                type: "POST",
                url: redirect,
                data: 'rdid='+rdid,
                success: function(output){
                    alert('PR successfully deleted.');
                    location.reload();
                }
          });
    }
}

function removerecitem(riid,baseurl){
    var redirect = baseurl+'index.php/receive/deleteRecItem';
    var result = confirm("Are you sure you want to delete this item?");
    if (result) {
        $.ajax({
                type: "POST",
                url: redirect,
                data: 'riid='+riid,
                success: function(output){
                    alert('Item successfully deleted.');
                    location.reload();
                }
          });
    }
}

function SaveReceive(receiveID,baseurl){
     var redirect = baseurl+'index.php/receive/saveReceive';
     var result = confirm("Are you sure you want to save DR?");
     if(result){
         $.ajax({
                type: "POST",
                url: redirect,
                data: 'receiveID='+receiveID,
                success: function(output){
                     //alert(output);
                    alert('DR successfully saved.');
                    location.reload();
                    
                }
          });
     }
}

function printMRF(){
    var sign = $("#mrfsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/receive/printMRF';
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

function update_prcmrk(id,baseurl) {
    var myWindow = window.open(baseurl+"index.php/receive/update_prc_mrk/"+id, "", "top=100,left=450,width=500,height=350");
}

function update_head(id,baseurl) {
    var myWindow = window.open(baseurl+"index.php/receive/update_headr/"+id, "", "top=100,left=450,width=550,height=400");
}



function closePopup(){
    window.close();
}

