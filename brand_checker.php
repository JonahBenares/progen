<?php

$con_brand=mysqli_connect("localhost","root","","db_progen");

$brand_empty = $con_brand->query("SELECT * FROM brand WHERE brand_name = '' OR brand_name IS NULL");
$rows_brand = $brand_empty->num_rows;
$brands = "";
if($rows_brand != 0) {
		while($row = $brand_empty->fetch_assoc()){
        $update_damage =$con_brand->query("UPDATE damage_items SET brand_id='0' WHERE brand_id='$row[brand_id]'");

        $update_delivery =$con_brand->query("UPDATE delivery_details SET brand_id='0' WHERE brand_id='$row[brand_id]'");

        $update_issuance =$con_brand->query("UPDATE issuance_details SET brand_id='0' WHERE brand_id='$row[brand_id]'");

        $update_receive =$con_brand->query("UPDATE receive_items SET brand_id='0' WHERE brand_id='$row[brand_id]'");

        $update_request =$con_brand->query("UPDATE request_items SET brand_id='0' WHERE brand_id='$row[brand_id]'");

        $update_restock =$con_brand->query("UPDATE restock_details SET brand_id='0' WHERE brand_id='$row[brand_id]'");


        $brands.=$row['brand_id'] .", ";


    	}
}
$brands = substr($brands,0,-2);
//echo $brands;
//print_r($brands);
  

        $get_items = $con_brand->query("SELECT brand_id, supplier_id, item_id, catalog_no, nkk_no, semt_no FROM supplier_items WHERE brand_id IN ($brands)");
  
        while($fetch_items = $get_items->fetch_assoc()){
            //echo $fetch_items['item_id'] . " - " .$fetch_items['brand_id'] . " - ".$fetch_items['catalog_no'] . " - ". $fetch_items['supplier_id'] . "<br>";

            $all_items[] = array(
                'item_id'=>$fetch_items['item_id'],
                'catalog_no'=>$fetch_items['catalog_no'],
                'supplier_id'=>$fetch_items['supplier_id'],
                'nkk_no'=>$fetch_items['nkk_no'],
                'semt_no'=>$fetch_items['semt_no'],
               
              
            );
           
        }

       
     $all_items = array_map("unserialize", array_unique(array_map("serialize", $all_items)));
    
     foreach($all_items AS $k){
   

        $get_sum = $con_brand->query("SELECT *, SUM(quantity) AS qty, AVG(item_cost) AS cost FROM supplier_items WHERE item_id = '$k[item_id]' AND catalog_no = '$k[catalog_no]' AND supplier_id = '$k[supplier_id]' AND nkk_no = '$k[nkk_no]' AND semt_no = '$k[semt_no]' AND brand_id IN ($brands) GROUP BY supplier_id, catalog_no, nkk_no, semt_no ORDER BY item_id ASC");

        $fetch_sum = $get_sum->fetch_assoc();

      /* echo $fetch_sum['item_id'] ." - " .$fetch_sum['catalog_no'] . " - ". $fetch_sum['supplier_id'] . " - " . $fetch_sum['qty'] . " - " . $fetch_sum['cost'] . "<br>";*/

      $insert =  $con_brand->query("INSERT INTO supplier_items_2 (item_id, supplier_id, catalog_no, nkk_no, semt_no, brand_id, serial_id, item_cost, quantity) VALUES ('$fetch_sum[item_id]','$fetch_sum[supplier_id]','$fetch_sum[catalog_no]','$fetch_sum[nkk_no]','$fetch_sum[semt_no]','0','$fetch_sum[serial_id]','$fetch_sum[cost]','$fetch_sum[qty]')");
      
     }


  

        $get_with_brand = $con_brand->query("SELECT * FROM supplier_items WHERE brand_id NOT IN ($brands)");

  
        while($fetch_with_brand = $get_with_brand->fetch_assoc()){

      
      $insert =  $con_brand->query("INSERT INTO supplier_items_2 (item_id, supplier_id, catalog_no, nkk_no, semt_no, brand_id, serial_id, item_cost, quantity) VALUES ('$fetch_with_brand[item_id]','$fetch_with_brand[supplier_id]','$fetch_with_brand[catalog_no]','$fetch_with_brand[nkk_no]','$fetch_with_brand[semt_no]','$fetch_with_brand[brand_id]','$fetch_with_brand[serial_id]','$fetch_with_brand[item_cost]','$fetch_with_brand[quantity]')");
        
     }


     $brand_empty = $con_brand->query("SELECT * FROM brand WHERE brand_name = '' OR brand_name IS NULL");
     while($row = $brand_empty->fetch_assoc()){
        $delete = $con_brand->query("DELETE FROM brand WHERE brand_id = '$row[brand_id]'");
     }


     
?>