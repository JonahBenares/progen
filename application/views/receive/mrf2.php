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
       
        @media print{
            #print1 {
                display: none;
            }
        }
        .shadow{
            box-shadow: 0px 2px 1px 1px #dadada;
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
            margin: 30% 4% 10px 35%;            
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
            ?>
            <table width="100%">
                <tr>
                    <td width="5%"><h4 style="margin-bottom:0px"><strong>Date:   </strong></h4></td>
                    <td width="15%"><h4 style="margin-bottom:0px"><?php echo $hd->receive_date?></h4></td>
                    <td width="10%"><h4 class="pull-right" style="margin-bottom:0px"><strong>MRF NO.  :   </strong></h4></td>
                    <td width="70%"> <h4 style="margin-bottom:0px">&nbsp <?php echo $hd->mrecf_no?></h4></td>
                </tr>
                <tr>
                    <td><strong><label class="nomarg">DR #:</label></strong></td>
                    <td> <h5 class="nomarg"><?php echo $hd->dr_no;?></h5></td>
                    <td><strong><label class="nomarg pull-right">PO #:</label></strong></td>
                    <td> <h5 class="nomarg">&nbsp <?php echo $hd->po_no;?></h5></td>
                </tr>
                <tr>
                    <td><strong><label class="nomarg">JO #:</label></strong></td>
                    <td> <h5 class="nomarg"><?php echo $hd->jo_no;?></h5></td>
                    <td><strong><label class="nomarg pull-right">SI #:</label></strong></td>
                    <td> <h5 class="nomarg">&nbsp <?php echo $hd->si_no;?></h5></td>
                </tr>
            </table>
            <?php } ?>            
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
                    <td width="10%" style="padding-left: 5px">Purpose:</td>
                    <td><?php echo $det['purpose'];?></td>
                    <td></td>
                    <td></td>
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
                                <td align="center"></td>
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
            <table width="100%">
                <tr>
                    <td width="26%">Delivered by:</td>
                    <td width="10%"></td>
                    <td width="26%">Received by:</td>
                    <td width="10%"></td>
                    <td>Inspected by:</td>
                </tr>
                <tr>
                    <td style="border-bottom:1px solid #000">
                    <select type="text">
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                    <select type="text">
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                    <select type="text">
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
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
                        <select type="text">
                            <option></option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                            <option>Cenpri</option>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select type="text">
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
        <div class="print" id="print1">        
            <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printF()" /><br>
        </div>           
    </div>
</body>
<script type="text/javascript">
    function printF() {
        window.print();
    }
</script>
</html>