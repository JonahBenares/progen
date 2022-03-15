<?php

$con_serial=mysqli_connect("localhost","root","","db_progen");

$serial_empty = $con_serial->query("SELECT * FROM serial_number WHERE serial_no = '' OR serial_no IS NULL");
$rows_serial = $serial_empty->num_rows;

if($rows_serial != 0) {
		while($row = $serial_empty->fetch_assoc()){
    
        $update_issuance =$con_serial->query("UPDATE issuance_details SET serial_id='0' WHERE serial_id='$row[serial_id]'");

        $update_receive =$con_serial->query("UPDATE receive_items SET serial_id='0' WHERE serial_id='$row[serial_id]'");

        $update_restock =$con_serial->query("UPDATE restock_details SET serial_id='0' WHERE serial_id='$row[serial_id]'");

        $delete = $con_serial->query("DELETE FROM serial_number WHERE serial_id='$row[serial_id]'");
    

    	}
}

     
?>