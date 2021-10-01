 
 <tr id='item_row<?php echo $list['count']; ?>'>  
    <td style="padding: 0px "><center><?php echo $list['count']; ?></center></td>
    <td style="padding: 0px "><input type = "text" name = "original_pn[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['original_pn']; ?>" ></td>
    <td style="padding: 0px "><textarea  rows="3" type = "text" name = "item[]" style = "text-align:center;width:100%;border:1px transparent;"><?php echo $list['item']; ?></textarea></td>
        <td style="padding: 0px "><textarea  rows="3" type = "text" name = "crossref[]" style = "text-align:center;width:100%;border:1px transparent;" readonly><?php echo $list['supplier'] . " - " . $list['catalog_no'] . " - " . $list['brand']; ?></textarea></td>
     <td style="padding: 0px "><input type = "text" name = "serial[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['serial']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "quantity[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['quantity']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "unit[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['unit_name']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "selling[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['selling']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "discount[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['discount']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "shipping[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['shipping']; ?>"></td>
    <td style="padding: 0px "><input rows="3" type = "text" name = "total[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['total']; ?>" readonly></td>
    <td>
        <center>
        <a class="btn btn-danger table-remove btn-xs" onclick="remove_item(<?php echo $list['count']; ?>)"><span class=" fa fa-times"></span></a></center>    
    </td>
    <input type="hidden" name="item_id[]" value="<?php echo $list['itemid']; ?>">
    <input type="hidden" name="unit_id[]" value="<?php echo $list['unit']; ?>">
        <input type="hidden" name="siid[]" value="<?php echo $list['siid']; ?>">
    <input type="hidden" name="supplier_id[]" value="<?php echo $list['supplier_id']; ?>">
    <input type="hidden" name="catalog_no[]" value="<?php echo $list['catalog_no']; ?>">
    <input type="hidden" name="nkk_no[]" value="<?php echo $list['nkk_no']; ?>">
    <input type="hidden" name="semt_no[]" value="<?php echo $list['semt_no']; ?>">
    <input type="hidden" name="brand_id[]" value="<?php echo $list['brand_id']; ?>">
</tr>