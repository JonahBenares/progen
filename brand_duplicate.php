<?php

$con_brand=mysqli_connect("localhost","root","","db_progen");


$brands =  $con_brand->query("SELECT distinct brand_name FROM brand");
while($row = $brands->fetch_assoc()){

	$insert = $con_brand->query("INSERT INTO brand_2 (brand_name) VALUES ('$row[brand_name]')");
}

$select_brand = $con_brand->query("SELECT * FROM brand_2");
while($row_select = $select_brand->fetch_assoc()){
	$bname = trim($row_select['brand_name']);
	$get_id = $con_brand->query("SELECT * FROM brand WHERE brand_name = '$bname'");
	while($row_id = $get_id->fetch_assoc()){

		if(trim($row_select['brand_name']) == trim($row_id['brand_name'])){
		//echo $row_select['brand_id'] . " - " .$row_select['brand_name'] . " - " . $row_id['brand_id']. "<br>";



		$update_damage =$con_brand->query("UPDATE damage_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_delivery =$con_brand->query("UPDATE delivery_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_issuance =$con_brand->query("UPDATE issuance_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_receive =$con_brand->query("UPDATE receive_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_request =$con_brand->query("UPDATE request_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_restock =$con_brand->query("UPDATE restock_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

         $update_supplier_items =$con_brand->query("UPDATE supplier_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

         //echo "UPDATE supplier_items_2 SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'<br>";
		}


	}
}

$select_supplier_items = $con_brand->query("SELECT brand_id FROM supplier_items");
while($row_items = $select_supplier_items->fetch_assoc()){

	$select_b =  $con_brand->query("SELECT brand_id FROM brand WHERE brand_id = '$row_items[brand_id]'");
	$rows_brand = $select_b->num_rows;
	$fetch =  $select_b->fetch_assoc();

	if($row_items['brand_id'] !=0 && $rows_brand==0){

		  $update_supplier_items =$con_brand->query("UPDATE supplier_items SET brand_id='0' WHERE brand_id='$fetch[brand_id]'");
	}
}