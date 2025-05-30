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
                <td style="padding:5px;border-bottom: 2px solid #000" width="15%">
                        <h1 style="margin-top: 5px;font-weight: 900;text-align: center;color: #000;"><b>PROGEN</b></h1>
                </td>
                <td style="padding:10px;border-bottom: 2px solid #000;"  width="35%" >
                   <p id="head" style="margin: 0px"> <strong>PROGEN DIESEL TECH</strong></p>
                    <p id="head" style="margin: 0px">Purok San Jose, Brgy. Calumangan, Bago City</p>
                    <p id="head" style="margin: 0px">Tel. No. 476-7382</p>
                </td> -->
                <td style="padding:10px;border-bottom: 2px solid #000;border-left: 2px solid #000" width="50%" align="center">
                    <h5><strong>MATERIAL RECEIVING & INSPECTION FORM</strong></h5>
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
                    $pcf= $hd->pcf;
                    $si= $hd->si_no;
                    $delivered= $hd->delivered_by;
                    $received= $hd->received_by;
                    $acknowledged= $hd->acknowledged_by;
                    $noted= $hd->noted_by;
                    $overall_remarks= $hd->overall_remarks;
               }
            ?>
            <table width="100%" class="main-tab">
                <tr>
                    <td width="5%"><h6 class="nomarg">Date</h6></td>
                    <td width="15%" ><label class="nomarg">:&nbsp;<?php echo $date?></label></td>
                    <td width="10%"><h6 class="nomarg pull-right">MRF NO.  &nbsp </h6></td>
                    <td width="70%" > <label class="nomarg">:&nbsp;<?php echo $mrec; ?></label></td>
                </tr>
                <tr>
                    <td><h6 class="nomarg">DR #&nbsp</h6></td>
                    <td><label class="nomarg">:&nbsp;<?php echo $dr;?></label></td>
                    <td><h6 class="nomarg pull-right">PO #&nbsp</h6></td>
                    <td><label class="nomarg">:&nbsp;<?php echo $po;?></label></td>
                </tr>
                <tr>
                    <td><h6 class="nomarg ">SI #&nbsp </h6></td>
                    <td><label class="nomarg">:&nbsp;<?php echo $si;?></label></td>
                    <td><h6 class="nomarg pull-right">PCF #&nbsp </h6></td>
                    <td><label class="nomarg">:&nbsp;<?php if ($pcf == 1) {echo 'Yes';};?></label></td>
                </tr>
            </table>
                
        </div
        <br>
        <div class="col-lg-12">
            <?php 

                foreach($details AS $det){ 
                    $inspected = $det['inspected'];
                    
            ?>
            <table class="table-secondary shadow main-tab" width="100%">
                <tr>
                    <td class="main-tab" width="5%" style="padding-left: 5px">PR/JO No. :</td>
                    <td class="main-tab" width="20%"><b><?php echo $det['prno'];?></b></td>
                    <td class="main-tab" width="10%" style="padding-left: 5px">Purpose:</td>
                    <td class="main-tab"><b><?php echo $det['purpose'];?></b></td>
                </tr>
                <tr>
                    
                    <td class="main-tab" width="10%" style="padding-left: 5px">Department:</td>
                    <td class="main-tab"><b><?php echo $det['department'];?></b></td>
                    <td class="main-tab" width="10%" style="padding-left: 5px">End-Use:</td>
                    <td class="main-tab"><b><?php echo $det['enduse'];?></b></td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 5px">
                        <table width="100%" class="table-bordered">
                            <tr>
                                <td class="main-tab" width="2%" align="center"><strong>#</strong></td>
                                <td class="main-tab" width="5%" align="center"><strong>Qty</strong></td>
                                <td class="main-tab" width="2%" align="center"><strong>U/M</strong></td>
                                <td class="main-tab" width="5%" align="center"><strong>Part No.</strong></td>
                                <td class="main-tab" width="20%" align="center"><strong>Item Description</strong></td>
                                <td class="main-tab" width="20%" align="center"><strong>Supplier</strong></td>
                                <td class="main-tab" width="10%" align="center"><strong>Cat No. / NKK No. / SEMT No.</strong></td>
                                <td class="main-tab" width="10%" align="center"><strong>Brand</strong></td>
                                <td class="main-tab" width="8%" align="center"><strong>Cost</strong></td>
                                <td class="main-tab" width="8%" align="center"><strong>Shipping Fee</strong></td>
                                <td class="main-tab" width="7%" align="center"><strong>Total Cost</strong></td>
                                <!-- <td class="main-tab" width="15%" align="center"><strong>Inspected By</strong></td> -->
                            </tr>
                            <?php
                             $x =1; 
                             $total_cost=array();
                                foreach($items AS $it){ 
                                    switch($it){
                                        case($det['rdid'] == $it['rdid']):
                                            if($it['recqty']!=0){
                                                $total_cost[]=$it['total'];
                            ?>
                            <tr>
                                <td class="main-tab" align="center"><?php echo $x; ?></td>
                                <td class="main-tab" align="center"><?php echo $it['recqty']; ?></td>
                                <td class="main-tab" align="center"><?php echo $it['unit']; ?></td>
                                <td class="main-tab" align="center"><?php echo $it['part']; ?></td>
                                <td class="main-tab" align="left">&nbsp;<?php echo $it['item']; ?></td>
                                <td class="main-tab" align="center"><?php echo $it['supplier'];?></td>
                                <td class="main-tab" align="center"><?php echo $it['catno']." / ". $it['nkk_no']." / ". $it['semt_no'];?></td>
                                <td class="main-tab" align="center"><?php echo $it['brand'];?></td>
                                <td class="main-tab" align="center"><?php echo $it['unitcost'];?></td>
                                <td class="main-tab" align="center"><?php echo $it['shipping_fee'];?></td>
                                <td class="main-tab" align="center"><?php echo number_format($it['total'],2);?></td>
                               <!--  <td class="main-tab" align="center"><?php echo $it['inspected'];?></td> -->
                            </tr>
                            <?php  
                                            }
                                $x++;
                                break;
                                default: 
                                }  }  
                            ?>  
                            <tr>
                                <td colspan='10' align='right'><b>Total: </b></td>
                                <td colspan='1' align='center'><b><?php echo number_format(array_sum($total_cost),2); ?></b></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding: 5px">
                        <table width="100%" class="main-tab">
                            <tr>
                                <td width="15%">Remarks:</td>                    
                                <td style="border-bottom: 1px solid #999">
                                    <?php 
                                        if($overall_remarks!=''){
                                            echo "<b>Overall Remarks</b> -".$overall_remarks.", "; 
                                        }
                                    ?>
                                    <?php
                                    foreach($remarks_it AS $rem){ 
                                        switch($rem){
                                            case($det['rdid'] == $rem['rdid']):
                                    ?>
                                    <?php if($rem['remarks'] != '' && $overall_remarks==''){ ?>   
                                        <?php echo $rem['item']; ?></b> - <?php echo $rem['remarks']; ?> ,
                                    <?php } else { ?>
                                        <?php if($rem['remarks'] != ''){ ?> <b><?php echo $rem['item']; ?></b> - <?php echo $rem['remarks']; ?> <?php }  ?>
                                    <?php }?>
                                    <?php  
                                        break;
                                        default: 
                                        } }  
                                    ?> 
                                </td>
                            </tr>
                            <tr>
                                <td colspan='2'><br></td>
                               
                            </tr>
                            <tr>
                                <td>Inspected by:</td>
                                <td><?php echo $inspected; ?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <br>
            <?php } ?>
            <form method='POST' id='mrfsign'>
            <table width="100%" class="main-tab">
                <tr>
                    <td width="30%">Prepared By:</td>
                    <td width="5%"></td>                    
                    <td width="30%">Delivered by:</td>
                    <td width="5%"></td>
                    <td width="30%">Received by:</td>
                </tr>
                <tr>
                    <?php foreach($username AS $us) ?>
                    <td style="border-bottom:1px solid #000">
                        <input class="select" type="" name="" value="<?php echo $us['user'];?>">
                    </td>     
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <textarea class="select" rows="2" name="delivered" style="word-wrap:break-word;"><?php echo $delivered; ?></textarea>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='received' id ="received" onchange="chooseEmprec()">
                            <option></option>
                            <?php foreach($received_emp AS $recei){ ?>
                            <option value = "<?php echo $recei['empid'];?>" <?php echo (($recei['empid'] == $received) ?  ' selected' : ''); ?>><?php echo $recei['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>           
                </tr>
                <tr>
                    <td><!-- <input class="select animated headShake" type="" name="" placeholder="Type Designation Here.." > -->
                        <select class="select animated headShake" type="text"  style="white-space: break-spaces;">
                            <option value = "">Select Your Designation Here..</option>
                            <!-- <?php foreach($designation AS $d){ ?>
                            <option value = ""><?php echo $d->position; ?></option>
                            <?php } ?> -->
                            <option value = "">Asset and Warehouse Manager</option>
                            <option value = "">Commercial Asst. & Parts Analyst</option>
                            <option value = "">Warehouse Assistant</option>
                            <!-- <option value = "">Accounting Staff</option>
                            <option value = "">Asset and Warehouse Manager</option>
                            <option value = "">Commercial Asst. & Parts Analyst</option>
                            <option value = "">Material Receiving - Asset and Warehouse Manager</option>
                            <option value = "">Parts Inventory Assistant</option>
                            <option value = "">Projects and Asset Management Assistant</option>
                            <option value = "">Warehouse Assistant</option>
                            <option value = "">Warehouse Supervisor</option> -->
                            <!-- <option value = "">Accounting Staff</option>
                            <option value = "">Asset and Warehouse Manager</option>
                            <option value = "">Parts Inventory Assistant</option>
                            <option value = "">Projects and Asset Management Assistant</option>
                            <option value = "">Warehouse Assistant</option>
                            <option value = "">Warehouse Supervisor</option> -->
                        </select>
                    </td>  
                    <td></td>
                    <td style='vertical-align:top'><center>Supplier/Driver</center></td>
                    <td></td>
                    <td style='vertical-align:top'>
                        <center><div id='alt' style="font-weight:bold"></div></center>
                        <input id="position" class="select" style="pointer-events:none" value="<?php echo $us['positionrec'];?>">
                    </td>
                    <!-- <td><center>Warehouse Personnel</center></td> -->
                                  
                </tr>
            </table>
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
                        <select class="select" type="text" name='acknowledged' id="acknowledged" onchange="chooseEmpack()">
                            <option></option>
                            <?php foreach($acknowledged_emp AS $ackno){ ?>
                            <option value = "<?php echo $ackno['empid'];?>" <?php echo (($ackno['empid'] == $acknowledged) ?  ' selected' : ''); ?>><?php echo $ackno['empname'];?></option>
                            <?php } ?>
                        </select>
                    </td>
                    <td></td>
                    <td style="border-bottom:1px solid #000">
                        <select class="select" type="text" name='noted' id='noted' onchange="chooseEmpnoted()">
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
                   <!--  <td><center>Warehouse In-Charge</center></td> -->
                    <td>
                        <center><div id='alts' style="font-weight:bold"></div></center>
                        <input id="positionack" class="select" style="pointer-events:none" value="<?php echo $us['positionack'];?>">
                    </td>
                    <td></td>
                    <td>
                        <center><div id='altss' style="font-weight:bold"></div></center>
                        <input id="positionnoted" class="select" style="pointer-events:none" value="<?php echo $us['positionnote'];?>">
                    </td>
                    <!-- <td><center>Plant Director</center></td> -->
                    <td></td>                
                </tr>
            </table>
            <br><br>
            <table width="100%">
                <tr>
                    <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td>
                </tr>
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