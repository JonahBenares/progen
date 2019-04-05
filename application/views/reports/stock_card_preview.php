<?php $CI =& get_instance(); ?>
    <!DOCTYPE html>
<head>
    <script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
    <script src="<?php echo base_url(); ?>assets/js/receive.js"></script>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Print Stock Card</title>
        </head>
<style type="text/css">
    .nomarg{
        margin:0px;
    }
    tr>td.dashed, 
    tr>th.dashed {
        border-right: 2px dashed #000!important;
    }
    body{
        font-size: 12px!important;
    }
    .text-red{
        color: red;
        -webkit-print-color-adjust: exact;
    }
    .text-blue{
        color: blue;
        -webkit-print-color-adjust: exact;
    }
    @media print{
        .text-red{
            color: #fff;
            -webkit-print-color-adjust: exact;
        }
        #print-btn, #print-btn1{
            display: none;
        }
        .table-bordered>tbody>tr>td, 
        .table-bordered>tbody>tr>th, 
        .table-bordered>tfoot>tr>td, 
        .table-bordered>tfoot>tr>th, 
        .table-bordered>thead>tr>td, 
        .table-bordered>thead>tr>th {
            border: 1px solid #fff!important;
        }
        .ptext-white{
            color: #fff0!important;
        }
    }
    p{
        color: #000
    }
    small {
        font-size: 70%;
    }
    #prntd{
        display: none;
    }
    @media print{
        #prntd{
            display: block;
        }
    }
</style>
<body style="padding-top:0px">    
    <div>
        <table class="table-bordsered" width="100%" >
            <tr class="hidden-tr">
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>                
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
                <td width="5%"></td>
            </tr>
            <tr>                
                <td colspan="10" align="center" style="padding-right: 65px">
                    <table class="table-bordered" width="100%" style="border:2px solid #fff;">
                        <tr>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>                
                            <td width="9%"></td>
                            <td width="9%"></td>
                            <td width="9%"></td>
                        </tr>
                        <tr>                            
                            <td  colspan="3" align="center"><h2 class="nomarg text-blue"><b class=" ptext-white">PROGEN</b></h2></td>
                            <td  colspan="5"><h4 class="nomarg ptext-white">STOCK CARD (BIN CARD)</h4></td>
                            <td  colspan="3" align="center"><small id="prntd">Printed by: <?php echo $printed.' / '. date("Y-m-d"). ' / '. date("h:i:sa")?></small></td>
                        </tr>
                        <?php foreach($item AS $i){ ?>
                        <tr>
                            <td colspan="2" align="right"><p class="nomarg ptext-white" style="height: 50px">Item:</p></td>
                            <td colspan="9" class="text-red"><p class="nomarg" style="height: 50px">&nbsp;<?php echo $i['item'];?></p></td><!--  -->
                            <!--<td colspan="9" class="text-red"><p class="nomarg" style="height: 50px">Sorbent Boom, Economical SPC, 8" x 10" ENV810 (Economy Boom w/Blue Sleeve, Lint Free, 4/Bale, Absorbency Capacity: 65ga) </p></td>
                              -->
                            
                        </tr>
                        <tr>
                            <td colspan="2" align="right" class="ptext-white">Group:</td>
                            <td colspan="4" class="text-red">&nbsp;<?php echo $i['group'];?></td>
                            <td ><p class="nomarg ptext-white">Part No.:</p></td>
                            <td colspan="4" class="text-red"><p class="nomarg">&nbsp;<?php echo $i['pn'];?></p></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right" class="ptext-white">NKK PN:</td>
                            <td colspan="4" class="text-red">&nbsp;<?php echo $i['nkk'];?></td>
                            <td class="ptext-white">Location:</td>
                            <td colspan="4" class="text-red">&nbsp;<?php echo $i['location'];?></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right" class="ptext-white">SEMT PN:</td>
                            <td colspan="4" class="text-red">&nbsp;<?php echo $i['semt'];?></td>
                            <td class="ptext-white">Bin No:</td>
                            <td colspan="4" class="text-red">&nbsp;<?php echo $i['bin'];?></td>
                        </tr>
                        <?php } ?>

                     
                        <tr>
                            <td align="center" colspan="2" class="ptext-white"></td>
                            <td align="center" colspan="2" class="ptext-white">Received</td>
                            <td align="center" colspan="2" class="ptext-white">Issued</td>
                            <td align="center" colspan="2" class="ptext-white">Restock</td>
                            <td align="center" class="ptext-white">Total</td>
                            <td align="center" colspan="2" class="ptext-white">Remarks</td>
                        </tr>  
                        <?php
                        $x=1;
                         foreach(array_unique($date) AS $dt){ 
                            if($x==1){
                                $line_total = ($CI->stockcard_qty($query, 'receive', $dt) + $CI->stockcard_qty($query, 'restock', $dt)) - $CI->stockcard_qty($query, 'issue', $dt);
                            } else {
                                $line_total = ($line_total + $CI->stockcard_qty($query, 'receive', $dt) + $CI->stockcard_qty($query, 'restock', $dt)) - $CI->stockcard_qty($query, 'issue', $dt);
                            }

                            ?>
                        <tr>
                            <td align="center" colspan="2"><?php echo $dt; ?></td>
                            <td align="center" colspan="2"><?php echo $CI->stockcard_qty($query, 'receive', $dt); ?></td>
                            <td align="center" colspan="2"><?php echo $CI->stockcard_qty($query, 'issue', $dt); ?></td>
                            <td align="center" colspan="2"><?php echo $CI->stockcard_qty($query, 'restock', $dt); ?></td>
                            <td align="center"><?php echo $line_total; ?></td>
                            <td align="center" colspan="2"></td> 
                        </tr>               
                        <?php 
                        $x++; } ?>                            
                    </table>
                </td>
                <td colspan="10" align="center">
                    <div class="btn-group" style="position: fixed;top:10px" id="print-btn">
                    <button class="btn btn-primary" onclick="window.print()">Print <u><b>Stock Card</b></u></button>
                    <a class="btn btn-warning" target="_blank" id="print-btn1" href = "<?php echo base_url(); ?>index.php/reports/sc_prev_blank"> Print <u><b>Blank</b></u> Stock Card</a>
                </div>
                </td>
            </tr>
        </table>

</body>
</html>