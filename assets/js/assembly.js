$(document).on("click", "#addAssembly_button", function () {
     var engineid = $(this).attr("data-trigger");
     $("#engine_id").val(engineid);

});


$(document).on("click", "#addItem_button", function () {
	 var assemblyid = $(this).attr("data-trigger");
	 $("#assembly_id").val(assemblyid);

});

$(document).on("click", "#updateEngine_button", function () {
     var engineid = $(this).attr("data-id");
     var enginename = $(this).attr("data-trigger");
     $("#engineid").val(engineid);
     $("#enginename").val(enginename);

});


$(document).on("click", "#updateAssembly_button", function () {
     var assemblyid = $(this).attr("data-id");
     var assemblyname = $(this).attr("data-trigger");
     $("#assemblyid").val(assemblyid);
     $("#assemblyname").val(assemblyname);

});

$( document ).ready(function() {
        $('#item_name').keyup(function(){
        var loc= document.getElementById("baseurl").value;
        var redirect=loc+'/index.php/assembly/itemlist';
            $.ajax({
                type: "POST",
                url: redirect,
                data:'item='+$(this).val(),
                beforeSend: function(){
                    $("#item_name").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
                    $("#suggestion-item").show();
                    $("#suggestion-item").html(data);
                    $("#item_name").css("background","#FFF");
                }
            });
        });
});


function selectItem(id, val, uom, uomid, pn) {  
    $("#item_id").val(id);
    $("#item_name").val(val);
    $("#uom").val(uom);
    $("#uom_id").val(uomid);
    $("#pn_no").val(pn);
    $("#suggestion-item").hide();
}


function chooseAssembly(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/assembly/getAssembly';
    var engine = document.getElementById("engine").value;
    //alert(engine);
    $.ajax({
            type: 'POST',
            url: redirect,
            data: 'engine='+engine,
            success: function(data){
                $("#assembly").html(data);
           }
    }); 
}

function chooseAssembly2(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/assembly/getAssembly';
    var engine = document.getElementById("engine_from").value;
    $.ajax({
            type: 'POST',
            url: redirect,
            data: 'engine='+engine,
            success: function(data){
                $("#assembly_from").html(data);
           }
    }); 
}





function generateAssembly(){
     var engine = document.getElementById("engine_from").value;
     var assembly = document.getElementById("assembly_from").value;
     var id = document.getElementById("id").value;
     var baseurl= document.getElementById("baseurl").value;
    // alert(engine);
     if(engine ==""){
        alert('Error: Please choose engine.');
     }
     else if(assembly ==""){
        alert('Error: Please choose assembly.');
     } else {
     window.location.href = baseurl+'index.php/assembly/transfer_form/'+id+'/'+engine+'/'+assembly;
    }
}

$(document).ready(function(){
    var counter= document.getElementById("counter").value;
    var eng_to= document.getElementById("engine_to").value;
    var ass_to= document.getElementById("assembly_to").value;
    var loc= document.getElementById("baseurl").value;
    var redirect=loc+'/index.php/assembly/banklist';
    /*for(var x=1;x<=counter;x++){*/
        $(".bank").keyup(function(){
            var count = $(this).attr("data-count");

              $.ajax({
                type: "POST",
                url: redirect,
                data:'bank='+$(this).val()+'&engine='+eng_to+'&assembly='+ass_to+'&count='+count,
                beforeSend: function(){
                    $("#trans_bank"+count).css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
                },
                success: function(data){
               //alert(data);
                    $("#suggestion-bank"+count).show();
                    $("#suggestion-bank"+count).html(data);
                    $("#trans_bank"+count).css("background","#FFF");
                }
              });
         });
    /*}*/
});

function selectBank(id,val,count) {

    $("#trans_bank_id"+count).val(id);
    $("#trans_bank"+count).val(val);
    $("#suggestion-bank"+count).hide();
}

function chooseCategory(){
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/Assembly/getCat';
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

    function enableEngine(){
    
        var location = document.getElementById('location').value;
         document.getElementById("engine").disabled = true;
         document.getElementById("assembly").disabled = true;
      
        if(location=='4'){
           $("#engine").removeAttr('disabled');
           $("#assembly").removeAttr('disabled');
            $("#engine_div").show();
            $("#assembly_div").show();
            
        } else {
            /*$('#engine').val('0');
            $('#assembly').val('0');*/
            /*document.getElementById("engine").disabled = true;
            document.getElementById("assembly").disabled = true;*/
             document.getElementById("engine").disabled = true;
             document.getElementById("assembly").disabled = true;
            $("#engine_div").hide();
            $("#assembly_div").hide();
        }
    }

function updateItemAssem(baseurl, id){
     window.open(baseurl+'index.php/assembly/update_item/'+id,'_blank', 'top=100px,left=400px,width=600,height=450');
}
