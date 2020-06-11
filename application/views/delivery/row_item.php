 
 <tr id='item_row<?php echo $list['count']; ?>'>  
    <td style="padding: 0px "><center><?php echo $list['count']; ?></center></td>
    <td style="padding: 0px "><input type = "text" name = "original_pn[]" style = "text-align:center;width:100%;border:1px transparent;" value = "<?php echo $list['original_pn']; ?>" ></td>
    <td style="padding: 0px "><textarea  rows="3" type = "text" name = "item[]" style = "text-align:center;width:100%;border:1px transparent;"><?php echo $list['item']; ?></textarea></td>
     <td style="padding: 0px "><input type = "text" name = "quantity[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['quantity']; ?>"></td>
    <td style="padding: 0px "><input type = "text" name = "unit[]" style = "text-align:center;width:100%;border:1px transparent;" value="<?php echo $list['unit_name']; ?>"></td>
    <td>
        <center>
        <a class="btn btn-danger table-remove btn-xs" onclick="remove_item(<?php echo $list['count']; ?>)"><span class=" fa fa-times"></span></a></center>    
    </td>
    <input type="hidden" name="item_id[]" value="<?php echo $list['itemid']; ?>">
    <input type="hidden" name="unit_id[]" value="<?php echo $list['unit']; ?>">
</tr>