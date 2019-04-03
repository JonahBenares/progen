$(document).ready(function(){
	$("#display_mreqf").hide();

    var loc= document.getElementById("baseurl").value;

    var redirect=loc+'index.php/issue/mreqflist';

	$("#mreqf").keyup(function(){

	      $.ajax({
	        type: "POST",
	        url: redirect,
	        data:'mreqf='+$(this).val(),
	        beforeSend: function(){
	            $("#mreqf").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
	        },
	        success: function(data){

	            $("#suggestion-mreqf").show();
	            $("#suggestion-mreqf").html(data);
	            $("#mreqf").css("background","#FFF");
	        }
	      });
	 });
});

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

function selectMreqF(no,id) {
    $("#mreqf").val(no);
    $("#request_id").val(id);
    $("#suggestion-mreqf").hide();
}

function loadIssuance(){
	var id= document.getElementById("request_id").value;	
	var loc= document.getElementById("baseurl").value;
	window.location.href = loc+'index.php/issue/load_issue/'+id;

}

function loadBackOrder(){
	var id= document.getElementById("mreqf").value;	
	var loc= document.getElementById("baseurl").value;
	window.location.href = loc+'index.php/backorder/back_order/'+id;

}

function saveIssue(){
	var reqid= document.getElementById("request_id").value;
	var issuedata = $("#issueform").serialize();
	var loc= document.getElementById("baseurl").value;
	var redirect = loc+'index.php/issue/saveIssuance';

      	  $.ajax({
	        type: "POST",
	        url: redirect,
	        data: issuedata,
	        success: function(output){
                //alert(output);
              // console.log(output);
	        	window.location.href = loc+'index.php/issue/view_issue';
	        	window.open( loc+'index.php/issue/mif/'+output,'_blank');
	         
	        }
	      });
      
}

function saveBackorder(){
	
	var issuedata = $("#issueform").serialize();
	var loc= document.getElementById("baseurl").value;
	var redirect = loc+'index.php/backorder/saveBackorder';

      	  $.ajax({
	        type: "POST",
	        url: redirect,
	        data: issuedata,
	        success: function(output){

	        //window.location.href = loc+'index.php/receive/view_';
	        window.open( loc+'index.php/receive/mrf/'+output,'_blank');
	         
	        }
	      });
      
}

function reprintIssue(issueid){
	var loc= document.getElementById("baseurl").value;

	window.open( loc+'index.php/issue/mif/'+issueid,'_blank');
	         
	    
      
}


function printMIF(){
    var sign = $("#mifsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/printMIF';
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


function printGP(){
    var sign = $("#gpsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/issue/printGP';
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