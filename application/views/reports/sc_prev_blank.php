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
            color: red;
            -webkit-print-color-adjust: exact;
        }
        .text-blue{
            color: blue;
            -webkit-print-color-adjust: exact;            
        }
        #print-btn{
            display: none;
        }
    }
    p{
        color: #000
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
                    <table class="table-bordered" width="100%" style="border:2px solid #000;">
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
                            <td width="5%" colspan="3" align="center"><h2 class="nomarg " style="color: blue"><b>PROGEN</b></h2></td>
                            <td width="5%" colspan="5"><h4 class="nomarg">STOCK CARD (BIN CARD)</h4></td>
                            <td  colspan="3" align="center"><small id="prntd"></small></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right"><p class="nomarg" style="height: 50px">Item:</p></td>
                            <!-- <td colspan="9" class="text-red"><p class="nomarg" style="">Sorbent Boom, Economical SPC, 8" x 10" ENV810 (Economy Boom w/Blue Sleeve, Lint Free, 4/Bale, Absorbency Capacity: 65ga)<br><br></p></td> -->
                            <td colspan="9" class="text-red"><p class="nomarg"><br><br><br></p></td>
                            
                        </tr>
                        <tr>
                            <td colspan="2" align="right">Group:</td>
                            <td colspan="4" class="text-red"></td>
                            <td width="5%">Part No.:</td>
                            <td colspan="4" class="text-red"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">NKK PN:</td>
                            <td colspan="4" class="text-red"></td>
                            <td width="5%">Location:</td>
                            <td colspan="4" class="text-red"></td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right">SEMT PN:</td>
                            <td colspan="4" class="text-red"></td>
                            <td width="5%">Bin No:</td>
                            <td colspan="4" class="text-red"></td>                            
                        </tr>
                        <tr>
                            <td align="center" colspan="3">Received</td>
                            <td align="center" colspan="3">Issued</td>
                            <td align="center" colspan="3">Restock</td>
                            <td align="center" rowspan="2">Total</td>
                            <td align="center" colspan="1" rowspan="2">Remarks</td>
                        </tr>
                        <tr>
                            <td align="center" colspan="2">Date</td>
                            <td align="center">Qty</td>
                            <td align="center" colspan="2">Date</td>
                            <td align="center">Qty</td>
                            <td align="center" colspan="2">Date</td>
                            <td align="center">Qty</td>
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr> 
                        <tr>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center" colspan="2"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td>
                            <td align="center"><br></td> 
                        </tr>                                   
                    </table>
                </td>
                <td colspan="10" align="center">
                    <div class="btn-group"  id="print-btn" style="position: fixed;top:10px">
                        <button  class="btn btn-primary" onclick="window.print()">Print <u><b>Stock Card</b></u></button>
                        <a href=""></a>
                    </div>
                </td>
            </tr>
        </table>

</body>
</html>