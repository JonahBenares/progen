<?php

$con_serial=mysqli_connect("localhost","root","","db_progen");

$get_supplier3 = $con_serial->query("SELECT * FROM supplier_items");
while($fetch_supplier3 = $get_supplier3->fetch_assoc()){

    $get_brand = $con_serial->query("SELECT brand_name FROM brand WHERE brand_id = '$fetch_supplier3[brand_id]'");
    $fetch_brand = $get_brand->fetch_assoc();
    $brand_name= $fetch_brand['brand_name'];

	$get_supplier = $con_serial->query("SELECT si.* FROM supplier_items_3 si INNER JOIN brand_2 ON si.brand_id = brand_2.brand_id WHERE item_id = '$fetch_supplier3[item_id]' AND supplier_id ='$fetch_supplier3[supplier_id]' AND catalog_no = '$fetch_supplier3[catalog_no]' AND nkk_no =  '$fetch_supplier3[nkk_no]' AND semt_no =  '$fetch_supplier3[semt_no]' AND brand_name = '$brand_name'");
	$fetch_supplier = $get_supplier->fetch_assoc();
	$rows_supplier = $get_supplier->num_rows;


	//echo "UPDATE serial_number SET si_id = '$fetch_supplier3[si_id]' WHERE si_id = '$fetch_supplier[si_id]'<br>";
	if($rows_supplier!=0){
	$update  = $con_serial->query("UPDATE serial_number SET si_id = '$fetch_supplier[si_id]' WHERE si_id = '$fetch_supplier3[si_id]'");
	}

	$get_supplier2 = $con_serial->query("SELECT * FROM supplier_items_3 WHERE item_id = '$fetch_supplier3[item_id]' AND supplier_id ='$fetch_supplier3[supplier_id]' AND catalog_no = '$fetch_supplier3[catalog_no]' AND nkk_no =  '$fetch_supplier3[nkk_no]' AND semt_no =  '$fetch_supplier3[semt_no]' AND brand_id ='0'");
	$fetch_supplier2 = $get_supplier2->fetch_assoc();
	$rows_supplier2 = $get_supplier2->num_rows;


	//echo "UPDATE serial_number SET si_id = '$fetch_supplier3[si_id]' WHERE si_id = '$fetch_supplier[si_id]'<br>";
	if($rows_supplier2!=0){
	$update2  = $con_serial->query("UPDATE serial_number SET si_id = '$fetch_supplier2[si_id]' WHERE si_id = '$fetch_supplier3[si_id]'");
	}


}