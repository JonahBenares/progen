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
<!-- <body style="padding-top:20px">    
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
                </td> -->
                <td style="padding:10px;border-bottom: 2px solid #000;border-left: 2px solid #000" width="50%" align="center">
                    <h5><strong>MATERIAL RESTOCK TO WAREHOUSE FORM</strong></h5>
                </td>
            </tr>
        </table>
        <div class="container">
            <br>
            <?php foreach($restock as $res){ ?>
            <table width="100%" class="main-tab">
                <tr >
                    <td style="font-size: 12px!important" width="13%">PR No.  </td>
                    <td style="font-size: 12px!important" width=40%"><strong>: <?php echo $res['prno'];?></strong>  </td>
                    <td style="font-size: 12px!important" width="5%">MRWF  </td>
                    <td style="font-size: 12px!important" width="30%"><strong>: <?php echo $res['mrwf_no'];?></strong>  </td>
                </tr>
                <tr>
                    <td style="font-size: 12px!important">Department  </td>
                    <td style="font-size: 12px!important"><strong>: <?php echo $res['department'];?></strong>  </td>
                    <td style="font-size: 12px!important">Date </td>
                    <td style="font-size: 12px!important"><strong>: <?php echo date('Y-m-d',strtotime($res['date']));?></strong> &nbsp;&nbsp; Time : <strong> <?php echo date('h:i:s',strtotime($res['date']));?> </strong></td>
                    <td style="font-size: 12px!important"></td>
                    <td style="font-size: 12px!important"><strong></strong> </td>
                </tr>
                <tr>
                    <td style="font-size: 12px!important">Purpose </td>
                    <td style="font-size: 12px!important"><strong>: <?php echo $res['purpose'];?></strong> </td>
                </tr>
                <tr>
                    <td style="font-size: 12px!important">EndUse </td>
                    <td style="font-size: 12px!important"><strong>: <?php echo $res['enduse'];?></strong> </td>
                </tr>
            </table> 
        </div>
        <br>
        <div class="col-lg-12">
            <table width="100%" class="  table-bordered main-tab">
                <tr>
                    <td width="5%" align="center"><strong>Item #</strong></td>
                    <td width="5%" align="center"><strong>Qty</strong></td>
                    <td width="5%" align="center"><strong>U/M</strong></td>
                    <td width="5%" align="center"><strong>Item Part No</strong></td>
                    <td width="30%" align="center"><strong>Item Description</strong></td>
                    <td width="5%" align="center"><strong>S/N</strong></td>
                    <!-- <td width="20%" align="center"><strong>Supplier</strong></td> -->
                    <td width="10%" align="center"><strong>Brand</strong></td>
                    <td width="10%" align="center"><strong>Cat. No. / NKK No. / SEMT No. </strong></td>
                    <td width="10%" align="center"><strong>Reason</strong></td>
                </tr>
                <?php $x = 1; foreach($details AS $det){ ?>
                <tr>
                    <td align="center"><?php echo $x;?></td>
                    <td align="center"><?php echo $det['qty'];?></td>
                    <td align="center"><?php echo $det['unit'];?></td>
                    <td align="center"><?php echo $det['pno'];?></td>
                    <td align="center"><?php echo $det['item'];?></td>
                    <td align="center"><?php echo $det['serial'];?></td>
                    <!-- <td align="center"><?php echo $det['supplier'];?></td> -->
                    <td align="center"><?php echo $det['brand'];?></td>
                    <td align="center"><?php echo $det['catno']." / ".$det['nkkno']." / ".$det['semtno'];?></td>
                    <td align="center"><?php echo $det['reason'];?></td>
                </tr>
                <?php  $x++; } ?>
            </table>            
            <br>
            <table width="100%" class="main-tab">
                <tr>
                    <td width="10%">Remarks:</td>                    
                    <td style="border-bottom: 1px solid #999"><?php echo $det['remarks'];?></tr>
            </table>
            <br>
            <form method='POST' id='mrfsign'>
            <table width="100%" class="main-tab">
                <tr>
                    <td width="10%"></td>
                    <td width="35%">Returned by:</td>
                    <td width="10%"></td>
                    <td width="35%">Inspected & Received by:</td>
                    <td width="10%"></td>
                </tr>
                <tr>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <input type="text" name="returned" value="<?php echo $res['returned'];?>"  class="select">
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <input type="text" name="received" value="<?php echo $res['received'];?>"  class="select">
                    </td>
                    <td></td>                
                </tr>
                <tr>
                    <td></td>
                    <!-- <td><center><input type="text" class="select" value = "End User/Requester"></center></td> -->
                    <td><center><input type="text" class="select" value = "<?php echo $res['positionret'];?>"></center></td>
                    <td></td>
                    <td><center><input type="text" class="select" value = "<?php echo $res['positionrec'];?>"></center></td>   
                    <!-- <td><center><input type="text" class="select" value = "Warehouse Personnel"></center></td> -->                    
                    <td></td>                
                </tr>
            </table>
            <br>
            <br>
            
            <table width="100%" class="main-tab">
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
                        <input type="text" name="acknowledge" value="<?php echo $res['acknowledge'];?>"  class="select">
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <input type="text" name="noted" value="<?php echo $res['noted_by'];?>"  class="select">
                    </td>
                    <td></td>                
                </tr>
                <tr>
                    <td></td>
                    <td><center><input type="text" class="select" value = "<?php echo $res['positionack'];?>"></center></td>
                    <!-- <td><center><input type="text" class="select" value = "Warehouse Supervisor"></center></td> -->
                    <td></td>
                    <td><center><input type="text" class="select" value = "<?php echo $res['positionnoted'];?>"></center></td>
                    <!-- <td><center><input type="text" class="select" value = "Plant Directory"></center></td>  -->                   
                    <td></td>                
                </tr>
            </table> 
            <?php } ?>
            <br> 
            <!-- <table width="100%">
                <tr>
                    <td style="font-size:9px">Warehouse Form: Material Receiving Form (Effective June 2018)</td>
                    <td style="font-size:9px" align="right">*Warehouse copy</td>
                </tr>
            </table>   -->  
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