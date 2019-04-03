    <!DOCTYPE html>
<head>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
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
       
        @media print{
            #print1 {
                display: none;
            }
        }
        .shadow{
            box-shadow: 0px 2px 1px 1px #dadada;
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
                    <h5><strong>MATERIAL RECEIVING FORM</strong></h5>
                </td>
            </tr>
        </table>
        <div class="container">
            <?php 
               foreach($heads AS $hd){  
                    $date=$hd->receive_date;
                    $mrec=$hd->mrecf_no;
                    $dr= $hd->dr_no;
                    $po= $hd->po_no;
                    $jo= $hd->jo_no;
                    $si= $hd->si_no;
                    $delivered= $hd->delivered_by;
                    $received= $hd->received_by;
                    $acknowledged= $hd->acknowledged_by;
                    $noted= $hd->noted_by;
               }
            ?>
            <table width="100%">
                <tr>
                    <td width="5%"><h6 style="margin-bottom:0px"><strong>Date:   </strong></h6></td>
                    <td width="15%"><h6 style="margin-bottom:0px"><?php echo $date?></h6></td>
                    <td width="10%"><h6 class="pull-right" style="margin-bottom:0px"><strong>MRF NO.  :   </strong></h6></td>
                    <td width="70%"> <h6 style="margin-bottom:0px">&nbsp <?php echo $mrec; ?></h6></td>
                </tr>
                <tr>
                    <td><strong><label class="nomarg">DR #:</label></strong></td>
                    <td> <h6 class="nomarg"><?php echo $dr;?></h6></td>
                    <td><strong><label class="nomarg pull-right">PO #:</label></strong></td>
                    <td> <h6 class="nomarg">&nbsp <?php echo $po;?></h6></td>
                </tr>
                <tr>
                    <td><strong><label class="nomarg">JO #:</label></strong></td>
                    <td> <h6 class="nomarg"><?php echo $jo;?></h6></td>
                    <td><strong><label class="nomarg pull-right">SI #:</label></strong></td>
                    <td> <h6 class="nomarg">&nbsp <?php echo $si;?></h6></td>
                </tr>
            </table>
                
        </div>
        <br>
        <div class="col-lg-12">
            <?php 
                foreach($details AS $det){ 
            ?>
            <table class="table-secondary shadow" width="100%">
                <tr>
                    <td width="5%" style="padding-left: 5px"><label style="font-size:16px">PR No. :</label></td>
                    <td width="20%"><?php echo $det['prno'];?></td>
                    <td width="10%" style="padding-left: 5px">End-Use:</td>
                    <td><?php echo $det['enduse'];?></td>
                </tr>
                <tr>
                    
                    <td width="10%" style="padding-left: 5px">Department:</td>
                    <td><?php echo $det['department'];?></td>
                    <td width="10%" style="padding-left: 5px">Purpose:</td>
                    <td><?php echo $det['purpose'];?></td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 5px">
                        <table width="100%" class="table-bordered">
                            <tr>
                                <td width="5%" align="center"><strong>Qty</strong></td>
                                <td width="30%" align="center"><strong>Item Description</strong></td>
                                <td width="20%" align="center"><strong>Supplier</strong></td>
                                <td width="10%" align="center"><strong>Catalog No.</strong></td>
                                <td width="10%" align="center"><strong>Brand</strong></td>
                                <td width="10%" align="center"><strong>Cost</strong></td>
                                <td width="15%" align="center"><strong>Inspected By</strong></td>
                            </tr>
                            <?php 
                                foreach($items AS $it){ 
                                    switch($it){
                                        case($det['rdid'] == $it['rdid']):
                            ?>
                            <tr>
                                <td align="center"><?php echo $it['recqty']; ?></td>
                                <td align="center"><?php echo $it['item']; ?></td>
                                <td align="center"><?php echo $it['supplier'];?></td>
                                <td align="center"><?php echo $it['catno'];?></td>
                                <td align="center"><?php echo $it['brand'];?></td>
                                <td align="center"><?php echo $it['unit'];?></td>
                                <td align="center"><?php echo $it['inspected'];?></td>
                            </tr>
                            <?php  
                                break;
                                default: 
                                } }  
                            ?> 
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <?php } ?>
            <br>
            <form method='POST' id='mrfsign'>
            <table width="100%">
                <tr>
                    <td width="10%"></td>
                    <td width="35%">Delivered by:</td>
                    <td width="10%"></td>
                    <td width="35%">Received by:</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='delivered'>
                            <option></option>
                            <?php foreach($delivered_emp AS $del){ ?>
                            <option value = "<?php echo $del['empid'];?>" <?php echo (($del['empid'] == $delivered) ?  ' selected' : ''); ?>><?php echo $del['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='received'>
                            <option></option>
                            <?php foreach($received_emp AS $recei){ ?>
                            <option value = "<?php echo $recei['empid'];?>" <?php echo (($recei['empid'] == $received) ?  ' selected' : ''); ?>><?php echo $recei['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>                
                </tr>
                <tr>
                    <td></td>
                    <td><center>Supplier/Driver</center></td>
                    <td></td>
                    <td><center>Warehouse Personnel</center></td>
                    <td></td>                
                </tr>
            </table>
            <br>
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
                        <select class="select" type="text" name='acknowledged'>
                            <option></option>
                            <?php foreach($acknowledged_emp AS $ackno){ ?>
                            <option value = "<?php echo $ackno['empid'];?>" <?php echo (($ackno['empid'] == $acknowledged) ?  ' selected' : ''); ?>><?php echo $ackno['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='noted'>
                            <option></option>
                            <<?php foreach($noted_emp AS $not){ ?>
                            <option value = "<?php echo $not['empid'];?>" <?php echo (($not['empid'] == $noted) ?  ' selected' : ''); ?>><?php echo $not['empname'];?></option>
                            <?php } ?>
                        </select>
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
        <div style="border-bottom: 1px solid #e8e8e8;width: 100%">&nbsp</div>
        <div class="print" id="print1">        
            <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printMRF()" /><br>
            <h5>After Clicking this Button. <br>Configure your <strong>Margin</strong> into <i>none</i></h5>
            <p>____________________________________________________</p>
            <li>Click <a><span class="fa fa-plus"></span> More Settings</a> at the right side of the screen</li>
            <li>Click and Choose<a> None from Margins </a> </li>
            <select class="form-control " style="width: 100px">
                <option>none</option>
            </select>
        </div>     
        <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
        <input type='hidden' name='recid' id='recid' value="<?php echo $id; ?>" >
        </form>    
    </div>
</body>
</html>