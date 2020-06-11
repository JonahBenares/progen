<script src="<?php echo base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo base_url(); ?>assets/js/assembly.js"></script>
<style>
    body{
        padding-top:20px;
    }
</style>
    <div class="container-fluid">
        <div class="row">                
            <div class="col-lg-6 offset-lg-3">
                <div class="card  bor-radius10 shadow  p-l-20 p-t-20 p-r-20 p-b-20">
                    <form action="<?php echo base_url(); ?>/index.php/assembly/update_assem_item" method="POST">
                        <div class="modal-header modal-headback">                           
                            <h4 class="modal-title" id="myModalLabel">Update Item</h4>
                        </div>
                        <div class="card-body card-block">
                            <div class=" m-l-20 m-t-20 m-r-20 m-b-20">
                            <?php foreach($items AS $i){ ?>
                                <table width="100%">
                                    <tr>
                                        <td width="20%"><p class="p-b-2">Item Name</p></td>
                                        <td width="5%"><p class="p-b-2">:</p></td>
                                        <td><p class="p-b-2"><input class="form-control mb-1" name = "item_name" id="item_name" style="color:#18a2b8;text-transform: uppercase;font-weight:bold;font-size:19px" 
                                        value = "<?php echo $i['item']; ?>" >
                                        <span id="suggestion-item"></span></p></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><p class="p-b-2">Part Number</p></td>
                                        <td width="5%"><p class="p-b-2">:</p></td>
                                        <td><p class="p-b-2"><input type="text" name = "pn_no" id="pn_no" class="form-control " value="<?php echo $i['pn']; ?>"></p></td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><p class="p-b-2">Unit Price</p></td>
                                        <td width="5%"><p class="p-b-2">:</p></td>
                                        <td>                                        
                                            <p class="p-b-2"><input type="text" id = "unit_price" name = "unit_price" class="form-control " value="<?php echo $i['unit_price']; ?>"></p>                                     
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><p class="p-b-2">Qty</p></td>
                                        <td width="5%"><p class="p-b-2">:</p></td>
                                        <td>                                        
                                            <p class="p-b-2"><input type="number" id = "qty" name = "qty" class="form-control " value="<?php echo $i['qty']; ?>"></p>                                     
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="20%"><p class="p-b-2">UOM</p></td>
                                        <td width="5%"><p class="p-b-2">:</p></td>
                                        <td><p class="p-b-2"><input type="text" name = "uom" id="uom" class="form-control " value = "<?php echo $i['uom']; ?>"></p></td>
                                    </tr>
                                   
                                </table>
                           
                            </div>
                        </div>
                        <div class="card-footer">
                            <center>
                            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
                            <input type="hidden" name="uom_id" id="uom_id" value="<?php echo $i['uom_id']; ?>">
                            <input type="hidden" name="item_id" id="item_id"  value="<?php echo $i['item_id']; ?>">
                            <input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url(); ?>">
                                <input type = "submit" class="btn btn-info btn-sm  btn-block" placeholder="Save" value="Save"> 
                            </center>
                        </div>
                         <?php } ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- END MAIN CONTENT-->
<!-- END PAGE CONTAINER-->