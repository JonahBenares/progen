<!DOCTYPE html>
<head>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/request.js"></script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print</title>
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
                    <h5><strong>DELIVERY RECEIPT</strong></h5>
                </td>
            </tr>
        </table>
        <?php foreach($heads as $det){ ?>
        <form method='POST' id='drsign'>
            <div class="col-lg-12" style="margin:10px 0px 10px">
                <table width="100%" class="main-tab">
                    <tr>
                        <td width="16%"><strong><h6 class="nomarg">Buyer</h6></strong></td>
                        <td width="40%" style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><?php echo $det['buyer_name'];?></td>
                        <td width="7%"></td>
                        <td width="10%"><strong><h6 class="nomarg pull-right">DR No. &nbsp</h6></strong></td>
                        <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['dr_no']; ?></label></td>
                    </tr>
                    <tr>
                        <td><strong><h6 class="nomarg">Address</h6></strong></td>
                        <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><?php echo $det['address'];?></td>
                        <td></td>
                        <td><strong><h6 class="nomarg pull-right">Date &nbsp</h6></strong></td>
                        <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo date("d-M-y",strtotime($det['date'])); ?></label></td> 
                    </tr>
                    <tr>
                        <td><strong><h6 class="nomarg">Contact Person</h6></strong></td>
                        <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><?php echo $det['contact_person'];?></td>
                        <td></td>
                    </tr>  
                    <tr>
                        <td><strong><h6 class="nomarg">Contact Number</h6></strong></td>
                        <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label><?php echo $det['contact_no']; ?></td>
                        <td></td>
                    </tr>
                    <tr>   
                        <td><strong><h6 class="nomarg">PGC PR No /PO No</h6></strong></td>
                        <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['sales_pr']?></label></td>
                        <td></td>
                        <td><strong><h6 class="nomarg">PR/ PO Date &nbsp</h6></strong></td>
                        <td colspan="3" style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['po_date']?></label></td>  
                        <!-- <td><strong><h6 class="nomarg">Source PR No</h6></strong></td>
                        <td style="border-bottom: 1px solid #999"> <label class="nomarg">: <?php echo $det['pr_no']; ?></label></td> -->
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td><strong><h6 class="nomarg pull-right">VAT</h6></strong></td>
                        <td style="border-bottom: 1px solid #999"> <label class="nomarg">: </label> <?php echo ($det['vat']==1) ? 'Vatable' : 'Non-Vatable'; ?></td>
                        <td></td>
                    </tr>           
                </table>
                
            </div>
            <div class="col-lg-12">
                <table width="100%" class="table-bordered main-tab">
                    <tr>
                        <td width="1%" align="center"><strong>#</strong></td>
                        <td width="20%" align="center"><strong>Part No.</strong></td>
                        <td width="30%" align="center"><strong>Item Description</strong></td>                    
                        <td width="5%" align="center"><strong>Serial No.</strong></td>
                        <td width="5%" align="center"><strong>Qty</strong></td>
                        <td width="10%" align="center"><strong>UOM</strong></td>
                        <td width="5%" align="center"><strong>Selling Price</strong></td>
                        <td width="5%" align="center"><strong>Discount</strong></td>
                        <td width="5%" align="center"><strong>Shipping Fee</strong></td>
                        <td width="5%" align="center"><strong>Total Price</strong></td>
                    </tr>
                    <tr>
                        <?php 
                            $x =1; 
                            if(!empty($details)){
                                foreach($details as $buyitm){
                        ?>
                        <tr>                        
                            <td align="center"><?php echo $x; ?></td>
                            <td align="center"><?php echo $buyitm['pn_no']; ?></td>
                            <td><?php echo $buyitm['item_name']; ?></td>
                            <td align="center"><?php echo $buyitm['serial_no']; ?></td>
                            <td align="center"><?php echo $buyitm['qty']; ?></td>
                            <td align="center">&nbsp;<?php echo $buyitm['unit']; ?></td>
                            <td align="center"><?php echo $buyitm['selling_price']; ?></td>
                            <td align="center"><?php echo $buyitm['discount']; ?></td>
                            <td align="center"><?php echo $buyitm['shipping_fee']; ?></td>
                            <td align="center"><?php echo number_format($buyitm['total_price'],2); ?></td>
                        </tr>
                        <?php $x++; } }else {?>
                        <tr>
                            <td align="center" colspan='10'><center>No Data Available.</center></td>
                        </tr>
                        <?php } ?>
                    </tr>
                    <tr>
                        <td colspan="12"><center>***nothing follows***</center></td>
                    </tr>
                </table>
                <br>
                <table width="100%" class="main-tab">
                    <tr>
                        <td width="10%" style="vertical-align: top">Remarks:</td>
                        <td style="border-bottom: 1px solid #999">
                            <textarea class="form-control" name ="remarks" rows="1" style="width:100%;border: 0px;background:unset; "><?php echo $det['remarks']?></textarea>  
                        </td>
                    </tr>
                </table>
                <br>
                <table width="100%" class="main-tab">
                    <tr>
                        <td width="10%">Shipped Via:</td>
                        <td style="border-bottom: 1px solid #999"><input type="text" class="form-control" style="width:100%;height: 25px;border: 0px;background:unset; " name="shipped" value="<?php echo $det['shipped_via'];?>"></td>
                        <td width="10%">Waybill No:</td>
                        <td style="border-bottom: 1px solid #999"><input type="text" class="form-control" style="width:100%;height: 25px;border: 0px;background:unset; " name="waybill_no" value="<?php echo $det['waybill_no'];?>"></td>
                    </tr>

                </table>
                <br>
                <form method='POST' id='mreqfsign'>
                <table width="100%" class="main-tab">
                    <tr>
                        <td width="30%">Prepared by:</td>
                        <td width="5%"></td>
                        <td width="30%">Released by:</td>
                        <td width="5%"></td>
                        <td width="30%">Verified by:</td>
                    </tr>
                    <?php foreach($username AS $us) ?>
                    <tr>
                        <td style="border-bottom:1px solid #000">
                            <input class="select" type="" name="" value="<?php echo (!empty($det['user_id'])) ? $det['prepared_by'] : $_SESSION['username']; ?>">
                        </td> 

                        <td></td>  
                        <td style="border-bottom:1px solid #000">
                            <?php if($det['released_id']==0){ ?>
                            <select class="select" type="text" name='released_by' id="released_by" onchange="chooseEmprel()" required>
                                <option></option>
                                <?php foreach($released_emp AS $rel){ ?>
                                <option value = "<?php echo $rel['empid']; ?>"<?php echo (( $rel['empid'] == '64') ?  ' selected' : ''); ?>><?php echo $rel['empname']; ?></option>
                                <?php } ?>
                            </select>
                            <?php } else{ ?>
                            <select class="select" type="text" name='released_by' id="released_by" onchange="chooseEmprel()" required>
                                <option></option>
                                <?php foreach($released_emp AS $rel){ ?>
                                <option value = "<?php echo $rel['empid']; ?>"<?php echo (( $rel['empid'] == $det['released_id']) ?  ' selected' : ''); ?>><?php echo $rel['empname']; ?></option>
                                <?php } ?>
                            </select>  
                            <?php } ?>
                        </td>    

                        <td></td>            
                        <td style="border-bottom:1px solid #000">
                            <?php if($det['verified_id']==0){ ?>
                            <select class="select" type="text" name='verified_by' id="verified_by" onchange="chooseEmpver()" required>
                                <option></option>
                                <?php foreach($reviewed_emp AS $rev){ ?>
                                <option value = "<?php echo $rev['empid']; ?>"<?php echo (( $rev['empid'] == '103') ?  ' selected' : ''); ?>><?php echo $rev['empname']; ?></option>
                                <?php } ?>
                            </select>
                            <?php } else { ?>
                            <select class="select" type="text" name='verified_by' id="verified_by" onchange="chooseEmpver()" required>
                            <option></option>
                            <?php foreach($reviewed_emp AS $rev){ ?>
                            <option value = "<?php echo $rev['empid']; ?>"<?php echo (( $rev['empid'] == $det['verified_id']) ?  ' selected' : ''); ?>><?php echo $rev['empname']; ?></option>
                            <?php } ?>
                            </select>
                            <?php } ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <center>
                                <select class="select animated headShake">
                                    <option value="">--Select Position--</option>
                                    <?php foreach($position AS $p){ ?>
                                    <option value="<?php echo $p->position; ?>"><?php echo $p->position; ?></option>
                                    <?php } ?>
                                </select>
                            </center>
                        </td>
                        <td></td>
                        <td>
                            <center>
                                <div id='alts' style="font-weight:bold"></div>
                                <input id="positionrel" class="select" style="pointer-events:none" value="<?php echo $us['positionrel'];?>">    
                            </center>
                        </td>
                        <td></td>
                        <td><center>
                                <div id='altss' style="font-weight:bold"></div>
                                <input id="positionver" class="select" style="pointer-events:none" value="<?php echo $us['positionver'];?>">    
                            </center></td>
                    </tr>
                </table>
                <br>
                <table width="100%" class="main-tab">
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
                            <?php if($det['noted_id']==0){ ?>
                            <select class="select" type="text" name='noted_by' id="noted_by" onchange="chooseEmpnote()" required>
                                <option></option>
                                <?php foreach($noted_emp AS $note){ ?>
                                <option value = "<?php echo $note['empid']; ?>"<?php echo (( $note['empid'] == '10') ?  ' selected' : ''); ?>><?php echo $note['empname']; ?></option>
                                <?php } ?>
                            </select>
                            <?php } else { ?>
                            <select class="select" type="text" name='noted_by' id="noted_by" onchange="chooseEmpnote()" required>
                            <option></option>
                            <?php foreach($noted_emp AS $note){ ?>
                            <option value = "<?php echo $note['empid']; ?>"<?php echo (( $note['empid'] == $det['noted_id']) ?  ' selected' : ''); ?>><?php echo $note['empname']; ?></option>
                            <?php } ?>
                            </select>
                            <?php } ?>
                        </td>
                        <td></td>
                        <td style="border-bottom:1px solid #000">
                            <input class="select" name='received_by' id='received_by' value = "<?php echo $det['received_by']; ?>" required>
                        </td>
                        <td></td>                
                    </tr>
                    <tr>
                        <td></td>
                        <td style="vertical-align: top"><center>
                                <div id='altsss' style="font-weight:bold"></div>
                                <input id="positionnote" class="select" style="pointer-events:none" value="<?php echo $us['positionnote'];?>">    
                            </center></td>
                        <td></td>
                        <td><center>Signature over Printed Name<br></center>Date/Time:</td>
                        <td></td>                
                    </tr>
                </table>
                <br>
                <table width="100%">
                    <tr>                 
                        <!-- <td style="font-size:12px">Printed By: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?> </td> -->
                    </tr>
                </table>
                <div style="border-bottom: 1px solid #e8e8e8;width: 100%">&nbsp</div>        
                <div class="print" id="print1">        
                    <input class="btn btn-warning btn-md " id="print" type="button" value="Print" onclick="printDR()" /><br>
                    <div style="margin-top: 2px">
                        <a class="btn btn-primary btn-md" id="printgpass" href="<?php echo base_url(); ?>index.php/delivery/gatepass/<?php echo $id; ?>" style="width: 50%">Print Gate Pass</a>
                    </div>
                    <h5>After Clicking this Button. <br>Configure your <strong>Margin</strong> into <i>none</i></h5>
                    <p>____________________________________________________</p>
                    <li>Click <a><span class="fa fa-plus"></span> More Settings</a> at the right side of the screen</li>
                    <li>Click and Choose<a> None from Margins </a> </li>
                    <select class="form-control " style="width: 100px">
                        <option>none</option>
                    </select>
                </div>
            </div>    
            <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
            <input type='hidden' name='delivery_id' id='delivery_id' value="<?php echo $id; ?>" >
        </form>   
        <?php } ?>        
    </div>
</body>
<script type="text/javascript">
    function chooseEmprel(){
        var loc= document.getElementById("baseurl").value;
        var redirect = loc+'index.php/delivery/getEmprel';
        var released_by = document.getElementById("released_by").value;
        document.getElementById('alts').innerHTML='<b>Please wait, Loading data...</b>'; 
        $.ajax({
            type: 'POST',
            url: redirect,
            data: 'employee_id='+released_by,
            dataType: 'json',
            success: function(response){
                $("#alts").hide();
                $("#positionrel").val(response.position);
            }
        }); 
    }

    function chooseEmpver(){
        var loc= document.getElementById("baseurl").value;
        var redirect = loc+'index.php/delivery/getEmpver';
        var verified_by = document.getElementById("verified_by").value;
        document.getElementById('altss').innerHTML='<b>Please wait, Loading data...</b>'; 
        $.ajax({
            type: 'POST',
            url: redirect,
            data: 'employee_id='+verified_by,
            dataType: 'json',
            success: function(response){
                $("#altss").hide();
                $("#positionver").val(response.position);
            }
        }); 
    }

    function chooseEmpnote(){
        var loc= document.getElementById("baseurl").value;
        var redirect = loc+'index.php/delivery/getEmpnote';
        var noted_by = document.getElementById("noted_by").value;
        document.getElementById('altsss').innerHTML='<b>Please wait, Loading data...</b>'; 
        $.ajax({
            type: 'POST',
            url: redirect,
            data: 'employee_id='+noted_by,
            dataType: 'json',
            success: function(response){
                $("#altsss").hide();
                $("#positionnote").val(response.position);
            }
        }); 
    }

    window.onload = function(){
       chooseEmprel();
       chooseEmpver();
       chooseEmpnote();
    }
    
    function printDR(){
        var sign = $("#drsign").serialize();
        var loc= document.getElementById("baseurl").value;
        var redirect = loc+'index.php/delivery/printDR';
        $.ajax({
            type: "POST",
            url: redirect,
            data: sign,
            success: function(output){
                if(output=='success'){
                    window.print();
                }
            }
        });
    }
</script>
</html>