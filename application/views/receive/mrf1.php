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
            font-family: Arial, Helvetica, sans-serif;
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
            border:2px solid black;border-top:0px;
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
        #print1{
            position: absolute;
            right: 120px;
            top: 15px;
        }
        @media print{
            #print1 {
                display: none;
            }
        }
</style>
<body>
    <div class="print" id="print1">        
        <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printF()" /><br>
    </div>
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
                    <h5><strong>MATERIAL RECEIVING FORM</strong></h5>
                </td>
            </tr>
        </table>
        <br> 
        <?php 
            foreach($heads AS $hd){ 
                foreach($details AS $det){ 
                    foreach($items AS $it){ 
                        switch($it){
                            case($det['rdid'] == $it['rdid']):
        ?>
        <table  width="100%" >
            <tr>
                <td><strong>Supplier</strong></td>
                <td colspan="3" style="border-bottom:1px solid #000"><?php echo $it['supplier'];?></td>

                <td><strong class="pull-right">MRecF No.&nbsp</strong></td>
                <td style="border-bottom:1px solid #000"><?php echo $hd->mrecf_no;?></td>
            </tr>           
            <tr>
                <td width="7%"><strong>DR No.&nbsp</strong></td>
                <td width="18%" style="border-bottom:1px solid #000"> <?php echo $hd->dr_no;?></td>
                <td width="7%"><strong class="pull-right">PO No.&nbsp</strong></td>
                <td width="18%" style="border-bottom:1px solid #000"><?php echo $hd->po_no;?></td>
                <td width="7%"><strong class="pull-right">Date&nbsp</strong></td>
                <td style="border-bottom:1px solid #000"><?php echo $hd->receive_date;?></td>
            </tr>
            <tr>
                <td><strong>JO No.</strong></td>
                <td style="border-bottom:1px solid #000"><?php echo $hd->jo_no;?></td>
                <td><strong class="pull-right">SI No.&nbsp</strong></td>
                <td style="border-bottom:1px solid #000"><?php echo $hd->si_no;?></td>
                <td><strong class="pull-right">Time&nbsp</strong></td>
                <td style="border-bottom:1px solid #000"></td>
            </tr>       
        </table>
        <br>
        <table class="table-bordered" width="100%">
            <tr>
                <td><center><strong>Qty.</strong></center></td>
                <td><center><strong>U/M</strong></center></td>
                <td><center><strong>Part No.</strong></center></td>
                <td><center><strong>Item Description</strong></center></td>
                <td><center><strong>Cat No.</strong></center></td>
                <td><center><strong>Brand</strong></center></td>
                <td><center><strong>Unit Cost</strong></center></td>
                <td><center><strong>Department</strong></center></td>
                <td><center><strong>Purpose</strong></center></td>
                <td><center><strong>End Use</strong></center></td>
                <td><center><strong>PR No.</strong></center></td>
                <td><center><strong>Inspected By</strong></center></td>
            </tr> 
      
            <tr>
                <td style="font-size: 11px;padding:2px"><center><?php echo $it['recqty']?></center></td>
                <td style="font-size: 11px;padding:2px"><center><?php echo $it['unit'];?></center></td>
                <td style="font-size: 11px;padding:2px"><center>23124545</center></td>
                <td style="font-size: 11px;padding:2px"><center><?php echo $it['item'];?></center></td>
                <td style="font-size: 11px;padding:2px"><center>324235512</center></td>
                <td style="font-size: 11px;padding:2px"><center>asdasdasffas</center></td>
                <td style="font-size: 11px;padding:2px"><center>3</center></td>
                <td style="font-size: 11px;padding:2px"><center>pcs</center></td>
                <td style="font-size: 11px;padding:2px"><center><?php echo $det['purpose']?></center></td>
                <td style="font-size: 11px;padding:2px"><center>aslksald</center></td>
                <td style="font-size: 11px;padding:2px"><center><?php echo $det['prno']?></center></td>
                <td style="font-size: 11px;padding:2px"><center>asdasdasffas</center></td>
            </tr>
            <tr>
                <td colspan="12"><center>>>>nothing follows<<<</center></td>
            </tr>
        </table><br>
        <?php  
            break;
            default: 
            } } } }  
        ?> 
        <br>
        <table width="100%">
            <tr>
                <td width="7%">Remarks:</td>
                <td style="border-bottom:1px solid #000"></td>
            </tr>
            <tr>
                <td ></td>
                <td style="border-bottom:1px solid #000"><br></td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="26%">Delivered by:</td>
                <td width="10%"></td>
                <td width="26%">Received by:</td>
                <td width="10%"></td>
                <td>Inspected by:</td>
            </tr>
            <tr>
                <td style="border-bottom:1px solid #000"><input type="text" style="width:100%;border:0px;background:none;text-align:center;"></td>
                <td></td>
                <td style="border-bottom:1px solid #000"><input type="text" style="width:100%;border:0px;background:none;text-align:center;"></td>
                <td></td>
                <td style="border-bottom:1px solid #000"><input type="text" style="width:100%;border:0px;background:none;text-align:center;"></td>
            </tr>
            <tr>
                <td><center>Supplier/Driver</center></td>
                <td></td>
                <td><center>Warehouse Personnel</center></td>
                <td></td>
                <td><center>End-User/Requester</center></td>
            </tr>
        </table>
        <br>
        <table width="100%">
            <tr>
                <td width="10%"></td>
                <td width="35%">Acknowledged by:</td>
                <td width="10%"></td>
                <td width="35%">Noted by:</td>
                <td width="10%"></td>
            </tr>
            <tr>
                <td></td>
                <td style="border-bottom:1px solid #000">
                    <input type="text" style="width:100%;border:0px;background:none;text-align:center;" value="">
                </td>
                <td></td>
                <td style="border-bottom:1px solid #000">
                    <input type="text" style="width:100%;border:0px;background:none;text-align:center;" value="">
                </td>
                <td></td>                
            </tr>
            <tr>
                <td></td>
                <td><center>Warehouse In-Charge</center></td>
                <td></td>
                <td><center>Plant Manager</center></td>
                <td></td>                
            </tr>
        </table>
        <br> 
        <table width="100%">
            <tr>
                <td style="font-size:9px">Warehouse Form: Material Receiving Form (Effective June 2018)</td>
                <td style="font-size:9px" align="right">*Warehouse copy</td>
            </tr>
        </table>       
    </div>
</body>
<script type="text/javascript">
    function printF() {
        window.print();
    }
</script>
</html>