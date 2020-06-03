<!DOCTYPE html>
<head>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/request.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
</head>
<style type="text/css">
        @media print {
            body { font-size: 10pt }
          }
          @media screen {
            body { font-size: 13px }
          }
          @media screen, print {
            body { line-height: 1.2 }
          }
        body{
            font-family:  Montserrat, Helvetica Neue, Helvetica, Arial, sans-serif;/*(Arial, Helvetica, sans-serif;)*/
        }
        small{ 
            margin-left:5px;
            font-size: 13px;
        }
        h6{
            margin:0px;
            font-weight: ;
        }
        tbody{
            padding: 20px!important;
        }
        .table-bordered>tbody>tr>td, 
        .table-bordered>tbody>tr>th, 
        .table-bordered>tfoot>tr>td, 
        .table-bordered>tfoot>tr>th, 
        .table-bordered>thead>tr>td, 
        .table-bordered>thead>tr>th {
            border: 1px solid #000!important;
        }
        .table-condensed>tbody>tr>td, 
        .table-condensed>tbody>tr>th, 
        .table-condensed>tfoot>tr>td, 
        .table-condensed>tfoot>tr>th, 
        .table-condensed>thead>tr>td, 
        .table-condensed>thead>tr>th {
            padding: 0px!important;
        }
        .table-bordered1 {
            border: 2px solid #444!important;
        }
        .logo-sty{
            margin-top: 10px;
            width:15%;
        }
        .company-name{
            margin:1px 0px 1px 0px;
            font-size:30px;
        }
        .name-sheet{
            margin:5px 0px 5px 0px;
        }
        .table-main{
            border:2px solid black;
            border-bottom:0px solid black;
        }
        .table-secondary{
            border:1px solid #999;
        }
        .paded-20{
            padding:20px;
        }
        .paded-top-10{
            padding-top:10px;
        }
        .paded-top-20{
            padding-top:20px;
        }
        .paded-top-30{
            padding-top:30px;
        }
        .undline-tab{
            border-bottom:1px solid black;
        }
        .marg-under{
            margin-bottom:10px;
        }
        .xs-small {
            font-size: 60%;
        }
        td{
            font-size: 1vmax
        }
        .borderrside{
            border-right: 1px solid #000;
            border-bottom: 1px solid #000;
        }
        .borderb{
            border-bottom:1px solid black; 
        }
        @media print(){
            #head{
                font-size: 5px!important;
            }
        }
        #head{
                font-size: 10px;
            }
        .select {
           text-align-last: center;
           text-align: center;
           -ms-text-align-last: center;
           -moz-text-align-last: center;
            padding: 5px 0px!important;
            width:100%;
            border:0px;
            background:none;
            text-align:center;
            -webkit-appearance: none;
        }
         #print1{
            position: relative;
            margin: 4% 4% 10px 35%;            
        }
        #print{
            width: 50%;
        }
        @media print{
            #print1 {
                display: none;
            }
            .nomarg{
                font-size: 12px!important;
            }
        }
        .shadow{
            box-shadow: 0px 2px 1px 1px #dadada;
        }
</style>
<!-- <body style="padding-top:20px">
    <div class="container">
        <table class = "table-main " style = "width:100%">
            <tr>
                <td style="padding:5px;border-bottom: 2px solid #000" width="15%">
                        <h1 style="margin-top: 5px;font-weight: 900;text-align: center;color: #000;"><b>PROGEN</b></h1>
                </td>
                <td style="padding:10px;border-bottom: 2px solid #000;"  width="35%" >
                   <p id="head" style="margin: 0px"> <strong>PROGEN DIESEL TECH</strong></p>
                    <p id="head" style="margin: 0px">Purok San Jose, Brgy. Calumangan, Bago City</p>
                    <p id="head" style="margin: 0px">Tel. No. 476-7382</p>
                </td> -->
                <td style="padding:10px;border-bottom: 2px solid #000;border-left: 2px solid #000" width="50%" align="center">
                    <h5><strong>DELIVERY RECEIPT</strong></h5>
                </td>
            </tr>
        </table>
        <div class="col-lg-12" style="margin:10px 0px 10px">
            <table width="100%">
                <tr>
                    <td width="16%"><strong><h6 class="nomarg">Buyer</h6></strong></td>
                    <td width="40%" style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><input type="" class="form-control" style="width:95%;display: unset;height: 25px" name=""></td>
                    <td width="7%"></td>
                    <td width="10%"><strong><h6 class="nomarg pull-right">DR No. &nbsp</h6></strong></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">:</label></td>                    
                </tr>
                <tr>
                    <td><strong><h6 class="nomarg">Address</h6></strong></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><input type="" class="form-control" style="width:95%;display: unset;height: 25px" name=""></td>
                    <td></td>
                    <td><strong><h6 class="nomarg pull-right">Date &nbsp</h6></strong></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">:</label></td>  
                    
                </tr>
                <tr>
                    <td><strong><h6 class="nomarg">Contact Person</h6></strong></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><input type="" class="form-control" style="width:95%;display: unset;height: 25px" name=""></td>
                    <td></td>
                </tr>  
                <tr>
                    <td><strong><h6 class="nomarg">Contact Number</h6></strong></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><input type="" class="form-control" style="width:95%;display: unset;height: 25px" name=""></td>
                    <td></td>
                </tr>    
                <tr>
                    <td><strong><h6 class="nomarg">PR# /PO#</h6></strong></td>
                    <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label></td>
                    <td></td>
                    <td><strong><h6 class="nomarg pull-right">PO Date &nbsp</h6></strong></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">:</label></td>  
                </tr>            
            </table>
            
        </div>
        <div class="col-lg-12">
            <table width="100%" class="table-bordered">
                <tr>
                    <td width="1%" align="center"><strong>#</strong></td>
                    <td width="30%" align="center"><strong>Item Description</strong></td>                    
                    <td width="20%" align="center"><strong>Part No.</strong></td>
                    <td width="5%" align="center"><strong>Qty</strong></td>
                    <td width="10%" align="center"><strong>U/M</strong></td>
                    <!-- <td width="10%" align="center"><strong>Inv.Bal.*</strong></td> -->
                </tr>
                <tr>
                    <tr>                        
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="center"></td>
                        <td align="left">&nbsp;</td>
                       <!--  <td align="center"><?php echo $req['invqty'];?></td> -->
                    </tr>
                    <tr>
                        <td align="center" colspan='10'><center>No Data Available.</center></td>
                    </tr>
                </tr>
                <tr>
                    <td colspan="6"><center>***nothing follows***</center></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%">Remarks:</td>
                    <td style="border-bottom: 1px solid #999">
                        
                    </td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%">Shipped Via:</td>
                    <td style="border-bottom: 1px solid #999"></td>
                    <td width="10%">Waybill No:</td>
                    <td style="border-bottom: 1px solid #999"></td>
                </tr>

            </table>
            <br>
            <form method='POST' id='mreqfsign'>
            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="35%">Prepared and Released by:</td>
                    <td width="10%"></td>
                    <td width="35%">Verified by:</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='acknowledged'>
                            <option></option>
                            <option value = "" ></option>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='noted'>
                            <option></option>
                            <option value = "" ></option>
                        </select>
                    </td>
                    <td></td>                
                </tr>
                <tr>
                    <td></td>
                    <td><center>Warehouse Personnel</center></td>
                    <td></td>
                    <td><center>Warehouse In-Charge</center></td>
                    <td></td>                
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="35%">Noted by:</td>
                    <td width="10%"></td>
                    <td width="35%">Received the above items in good condition</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='acknowledged'>
                            <option></option>
                            <option value = "" ></option>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='noted'>
                            <option></option>
                            <option value = "" ></option>
                        </select>
                    </td>
                    <td></td>                
                </tr>
                <tr>
                    <td></td>
                    <td style="vertical-align: top"><center>Plant Director</center></td>
                    <td></td>
                    <td><center>Signature over Printed Name<br></center>Date/Time:</td>
                    <td></td>                
                </tr>
            </table>
            <br>
            <br>
            <table width="100%">
                <tr>                 
                    <!-- <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td> -->
                </tr>
            </table>
            <div style="border-bottom: 1px solid #e8e8e8;width: 100%">&nbsp</div>        
            <div class="print" id="print1">        
                <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printDR()" /><br>
                <h5>After Clicking this Button. <br>Configure your <strong>Margin</strong> into <i>none</i></h5>
                <p>____________________________________________________</p>
                <li>Click <a><span class="fa fa-plus"></span> More Settings</a> at the right side of the screen</li>
                <li>Click and Choose<a> None from Margins </a> </li>
                <select class="form-control " style="width: 100px">
                    <option>none</option>
                </select>
            </div>
        </div>    
        <input type="hidden" name="baseurl" id="baseurl" value="">
        <input type='hidden' name='mreqfid' id='mreqfid' value="" >
        </form>           
    </div>
</body>
<script type="text/javascript">
function printDR(){
    var sign = $("#mreqfsign").serialize();
    var loc= document.getElementById("baseurl").value;
    var redirect = loc+'index.php/request/printDR';
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
</script>
</html>