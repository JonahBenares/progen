<?php

$con_brand=mysqli_connect("localhost","root","","db_progen");


$brands =  $con_brand->query("SELECT distinct brand_name FROM brand");
while($row = $brands->fetch_assoc()){

	//$insert = $con_brand->query("INSERT INTO brand_2 (brand_name) VALUES ('$row[brand_name]')");
}

$select_brand = $con_brand->query("SELECT * FROM brand_2");
while($row_select = $select_brand->fetch_assoc()){

	$get_id = $con_brand->query("SELECT * FROM brand WHERE brand_name = '$row_select[brand_name]'");
	while($row_id = $get_id->fetch_assoc()){

		if($row_select['brand_name'] == $row_id['brand_name']){
		//echo $row_select['brand_id'] . " - " .$row_select['brand_name'] . " - " . $row_id['brand_id']. "<br>";



		$update_damage =$con_brand->query("UPDATE damage_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_delivery =$con_brand->query("UPDATE delivery_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_issuance =$con_brand->query("UPDATE issuance_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_receive =$con_brand->query("UPDATE receive_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_request =$con_brand->query("UPDATE request_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_restock =$con_brand->query("UPDATE restock_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

		}


	}
}