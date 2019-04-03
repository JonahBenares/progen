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
            color: #fff!important;
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
                            <td width="11%"></td>
                            <td width="11%"></td>
                            <td width="11%"></td>
                            <td width="11%"></td>
                            <td width="11%"></td>
                            <td width="11%"></td>
                            <td width="11%"></td>
                            <td width="11%"></td>                
                            <td width="11%"></td>
                        </tr>
                        <tr>                            
                            <td width="5%" colspan="3" align="center"><h2 class="nomarg text-blue"><b class=" ptext-white">PROGEN</b></h2></td>
                            <td width="5%" colspan="6"><h3 class="nomarg ptext-white">STOCK CARD (BIN CARD)</h3></td>
                        </tr>
                        <tr>
                            <td width="5%" align="right" class="ptext-white">Item:</td>
                            <td colspan="4" class="text-red">Sorbent Boom, Economical SPC, 8" x 10" ENV810 (Economy Boom w/Blue Sleeve, Lint Free, 4/Bale, Absorbency Capacity : 65ga</td>
                            <td width="5%" class="ptext-white">Part No.:</td>
                            <td colspan="3" class="text-red">PF 1-9</td>
                        </tr>
                        <tr>
                            <td width="5%" align="right" class="ptext-white">Group:</td>
                            <td colspan="4" class="text-red">Main Bearing</td>
                            <td width="5%" class="ptext-white">Location:</td>
                            <td colspan="3" class="text-red">Room 1</td>
                        </tr>
                        <tr>
                            <td width="5%" align="right" class="ptext-white">NKK PN:</td>
                            <td colspan="4" class="text-red">00998387456783</td>
                            <td width="5%" class="ptext-white">Bin No:</td>
                            <td colspan="3" class="text-red">098784789888378.0778494</td>
                        </tr>
                        <tr>
                            <td width="5%" align="right" class="ptext-white">SEMT PN:</td>
                            <td colspan="8" class="text-red"></td>
                        </tr>
                        <tr>
                            <td align="center" colspan="3" class="ptext-white">Received</td>
                            <td align="center" colspan="3" class="ptext-white">Issued</td>
                            <td align="center" rowspan="2" class="ptext-white">Total</td>
                            <td align="center" colspan="2" rowspan="2" class="ptext-white"> Remarks</td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2" class="ptext-white">Date</td>
                            <td align="center" class="ptext-white">Qty</td>
                            <td align="center" colspan="2" class="ptext-white">Date</td>
                            <td align="center" class="ptext-white">Qty</td>
                        </tr>                        
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                        <tr>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center" colspan="2">January 20, 1990</td>
                            <td width="11%" align="center">999</td>
                            <td width="11%" align="center">999</td>
                            <td colspan="2" align="center">begbal</td> 
                        </tr>  
                                              
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