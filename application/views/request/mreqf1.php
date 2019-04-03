    <!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
        <!-- Core CSS - Include with every page -->
        <!-- <link href="assets/plugins/bootstrap/bootstrap.css" rel="stylesheet" />
        <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
        <link href="assets/plugins/pace/pace-theme-big-counter.css" rel="stylesheet" />
        <link href="assets/css/style.css" rel="stylesheet" />
        <link href="assets/css/main-style.css" rel="stylesheet" /> -->
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
        h5{
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
         select {
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
            margin: 10% 4% 10px 35%;            
        }
        #print{
            width: 50%;
        }
        @media print{
            #print1 {
                display: none;
            }
        }
        .shadow{
            box-shadow: 0px 2px 1px 1px #dadada;
        }
</style>
<body style="padding-top:20px">
    <div class="container">
        <table class = "table-main " style = "width:100%">
            <tr>
                <td style="padding:10px;border-bottom: 2px solid #000" width="15%">
                    <img src="<?php echo base_url(); ?>assets/default/logo_cenpri.png" width="100%" height="auto">
                </td>
                <td style="padding:10px;border-bottom: 2px solid #000;"  width="35%" >
                   <p id="head" style="margin: 0px"> <strong>CENTRAL NEGROS POWER RELIABILITY INC.</strong></p>
                    <p id="head" style="margin: 0px">Purok San Jose, Brgy. Calumangan, Bago City</p>
                    <p id="head" style="margin: 0px">Tel. No. 476-7382</p>
                </td>
                <td style="padding:10px;border-bottom: 2px solid #000;border-left: 2px solid #000" width="50%" align="center">
                    <h5><strong>MATERIAL REQUEST FORM</strong></h5>
                </td>
            </tr>
        </table>
        <div class="col-lg-12" style="margin:10px 0px 10px">
            <?php 
               foreach($req AS $rq){  
            ?>
            <table width="100%">
                <tr>
                    <td width="10%"><strong><label class="nomarg">Department</label></strong></td>
                    <td width="40%"   style="border-bottom: 1px solid #999"> <h5 class="nomarg">: <?php echo $rq['department'];?>asdass</h5></td>
                    <td width="7%"></td>
                    <td width="10%"><strong><label class="nomarg pull-right">MReqF No. &nbsp</label></strong></td>
                    <td colspan="3" style="border-bottom: 1px solid #999"> <h5 class="nomarg">:</h5></td>
                </tr>
                <tr>
                    <td><strong><label class="nomarg">Purpose</label></strong></td>
                    <td style="border-bottom: 1px solid #999"> <h5 class="nomarg">:</h5></td>
                    <td></td>
                    <td><strong><label class="nomarg pull-right">Date &nbsp</label></strong></td>
                    <td width="10%" style="border-bottom: 1px solid #999"> <h5 class="nomarg">:</h5></td>
                    <td width="10%" ><strong><label class="nomarg pull-right">Time &nbsp</label></strong></td>
                    <td width="10%"  style="border-bottom: 1px solid #999"> <h5 class="nomarg">:</h5></td>
                </tr>
                <tr>
                    <td><strong><label class="nomarg">End Use</label></strong></td>
                    <td style="border-bottom: 1px solid #999"> <h5 class="nomarg">:</h5></td>
                    <td></td>
                </tr>
                <tr>
                    <td><strong><label class="nomarg">JO / PR #</label></strong></td>
                    <td style="border-bottom: 1px solid #999"> <h5 class="nomarg">:</h5></td>
                    <td></td>
                </tr>
            </table>
            <?php } ?>
        </div>
        <div class="col-lg-12">
            <table width="100%" class="table-bordered">
                <tr>
                    <td width="5%" align="center"><strong>Qty</strong></td>
                    <td width="10%" align="center"><strong>U/M</strong></td>
                    <td width="20%" align="center"><strong>Part No.</strong></td>
                    <td width="30%" align="center"><strong>Item Description</strong></td>                    
                    <td width="10%" align="center"><strong>Inv.Bal.*</strong></td>
                </tr>
                <tr>
                    <td align="center">dasdasd sadasdsad</td>
                    <td align="center">dasdasd sadasdsad</td>
                    <td align="center">dasdasd sadasdsad</td>
                    <td align="center">dasdasd sadasdsad</td>
                    <td align="center">dasdasd sadasdsad</td>
                </tr>
                <tr>
                    <td colspan="5"><center>***nothing follows***</center></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%">Remarks:</td>
                    <td style="border-bottom: 1px solid #999"></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="26%">Requested by:</td>
                    <td width="10%"></td>
                    <td width="26%">Recommending Approval:</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" style="width:100%;border:0px;background:none;text-align:center;-webkit-appearance: none;" >
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" style="width:100%;border:0px;background:none;text-align:center;-webkit-appearance: none;" >
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><center>End-User/Requester</center></td>
                    <td></td>
                    <td><center>Department Head</center></td>
                    <td></td>
                </tr>
            </table>
            <br>
            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="26%">Reviewed by:</td>
                    <td width="10%"></td>
                    <td width="26%">Aprroved by:</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" style="width:100%;border:0px;background:none;text-align:center;-webkit-appearance: none;" >
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text" style="width:100%;border:0px;background:none;text-align:center;-webkit-appearance: none;" >
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
                    <td></td>
                </tr>
                <tr>
                    <td></td>
                    <td><center>O & M Planner</center></td>
                    <td></td>
                    <td><center>Plant Director</center></td>
                    <td></td>
                </tr>
            </table>             
            <div class="print" id="print1">        
                <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printF()" /><br>
            </div>
        </div>
        


           
    </div>
</body>
<script type="text/javascript">
    function printF() {
        window.print();
    }
</script>
</html>