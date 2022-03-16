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

		if(strtolower(trim($row_select['brand_name'])) == strtolower(trim($row_id['brand_name']))){
		//echo $row_select['brand_id'] . " - " .$row_select['brand_name'] . " - " . $row_id['brand_id']. "<br>";

		

		$update_damage =$con_brand->query("UPDATE damage_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_delivery =$con_brand->query("UPDATE delivery_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_issuance =$con_brand->query("UPDATE issuance_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_receive =$con_brand->query("UPDATE receive_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_request =$con_brand->query("UPDATE request_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

        $update_restock =$con_brand->query("UPDATE restock_details SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

         $update_supplier_items =$con_brand->query("UPDATE supplier_items_2 SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'");

         //echo "UPDATE supplier_items_2 SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'<br>";
        // echo "UPDATE supplier_items SET brand_id='$row_select[brand_id]' WHERE brand_id='$row_id[brand_id]'<br>";
		}


	}
}



  $get_items = $con_brand->query("SELECT brand_id, supplier_id, item_id, catalog_no, nkk_no, semt_no FROM supplier_items_2");
  
        while($fetch_items = $get_items->fetch_assoc()){
        

            $all_items[] = array(
                'item_id'=>$fetch_items['item_id'],
                'catalog_no'=>$fetch_items['catalog_no'],
                'supplier_id'=>$fetch_items['supplier_id'],
                'nkk_no'=>$fetch_items['nkk_no'],
                'semt_no'=>$fetch_items['semt_no'],
                'brand_id'=>$fetch_items['brand_id']
               
              
            );
           
        }

   $all_items = array_map("unserialize", array_unique(array_map("serialize", $all_items)));

 

    foreach($all_items AS $k){
   

        $get_sum = $con_brand->query("SELECT *, SUM(quantity) AS qty, AVG(item_cost) AS cost FROM supplier_items_2 WHERE item_id = '$k[item_id]' AND catalog_no = '$k[catalog_no]' AND supplier_id = '$k[supplier_id]' AND nkk_no = '$k[nkk_no]' AND semt_no = '$k[semt_no]' AND brand_id ='$k[brand_id]' GROUP BY brand_id, supplier_id, catalog_no, nkk_no, semt_no ORDER BY item_id ASC");

        $fetch_sum = $get_sum->fetch_assoc();

   /*  
	$old_siid = $fetch_sum['si_id'];

	   $check_rows = $con_brand->query("SELECT * FROM supplier_items_3");
        $rows_s2 = $check_rows->num_rows;
        if($rows_s2==0){
            $new_siid = 1;
        } else {
          $latest = $con_brand->query("SELECT MAX(si_id) AS max FROM supplier_items_3");
          $fetch_latest = $latest->fetch_assoc();
          $new_siid = $fetch_latest['max']+1;

        }
*/

      $insert =  $con_brand->query("INSERT INTO supplier_items_3 (item_id, supplier_id, catalog_no, nkk_no, semt_no, brand_id, serial_id, item_cost, quantity) VALUES ('$fetch_sum[item_id]','$fetch_sum[supplier_id]','$fetch_sum[catalog_no]','$fetch_sum[nkk_no]','$fetch_sum[semt_no]','$fetch_sum[brand_id]','$fetch_sum[serial_id]','$fetch_sum[cost]','$fetch_sum[qty]')");
      
        // $update_serial = $con_brand->query("UPDATE serial_number SET si_id = '$new_siid' WHERE si_id = '$old_siid'");

     }


 

