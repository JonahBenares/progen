  
  <?php 
  foreach($this->super_model->custom_query("SELECT DISTINCT item_id, supplier_id, brand_id, catalog_no FROM receive_items") as $items){
                $data['item_info'][] = array(
                    'item'=>$items->item_id,
                    'supplier'=>$items->supplier_id,
                    'brand'=>$items->brand_id,
                    'catalog_no'=>$items->catalog_no,
                    'item_desc'=>$this->super_model->select_column_where('items', 'item_name', 'item_id', $items->item_id),
                    'supplier_name'=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $items->supplier_id),
                    'brand_name'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $items->brand_id),
                );
            }

            foreach($this->super_model->custom_query("SELECT DISTINCT item_id, supplier_id, brand_id, catalog_no FROM receive_items") as $items){
                $item[] = array(
                    'item'=>$items->item_id,
                    'supplier'=>$items->supplier_id,
                    'brand'=>$items->brand_id,
                    'catalog_no'=>$items->catalog_no
                );
            }

           foreach($item AS $i){
                $a=1;
                foreach($this->super_model->custom_query("SELECT DISTINCT receive_id FROM receive_items WHERE item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'") AS $q){

                    $unit_cost = $this->super_model->select_column_custom_where("receive_items", "item_cost", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");
                   // $qty = $this->super_model->select_sum_where("receive_items", "received_qty", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");
                    $rec_qty = $this->super_model->custom_query_single("received_qty","SELECT ri.received_qty FROM receive_items ri INNER JOIN receive_details rd ON ri.receive_id = rd.receive_id WHERE ri.item_id = '$i[item]' AND ri.supplier_id = '$i[supplier]' AND ri.brand_id = '$i[brand]' AND ri.catalog_no = '$i[catalog_no]' GROUP BY rd.receive_id");
                  
                    $restock_qty = $this->qty_restocked($i['item'],$i['supplier'],$i['brand'],$i['catalog_no']);
                    $iss_qty =  $this->super_model->custom_query_single("quantity","SELECT quantity FROM issuance_details WHERE item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'");

                    $count_issue = $this->super_model->count_custom_where("issuance_details","item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'");

                    if($a<=$count_issue){
                        if($rec_qty == $iss_qty){
                         /*   echo $a ."/" . $count_issue ."=".$i['item'] . ", ".$i['supplier'].", ".$i['brand'].", ".$i['catalog_no']."=". $rec_qty . " - " . $iss_qty . "<br>";*/
                            $issue_qty  = $iss_qty;

                        } else {
                            $new_iss = $rec_qty - $iss_qty;
                             $issue_qty  = $new_iss;
                             /*echo $a ."/" . $count_issue ."=".$i['item'] . ", ".$i['supplier'].", ".$i['brand'].", ".$i['catalog_no']."=". $rec_qty . " - " . $new_iss . "<br>";*/
                        }
                    } else {

                            $new_iss = $rec_qty - $iss_qty;
                            $issue_qty  = $new_iss;
                           /*  echo $a ."/" . $count_issue ."=".$i['item'] . ", ".$i['supplier'].", ".$i['brand'].", ".$i['catalog_no']."=". $rec_qty . " - " . $new_iss . "<br>";*/
                        

                    }
                   
                    
                    $qty = ($rec_qty+$restock_qty) -  $issue_qty;
                    $unit_x = $qty * $unit_cost;
                  //  echo $unit_x."<br>";
                    if($qty!=0){
                    $data['total'][]=$unit_x;
                    
                    }
                    $receive_date = $this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $q->receive_id);
                   
                    $data['info'][]=array(
                        'receive_id'=>$q->receive_id,
                        'receive_date'=>$receive_date,
                        'unit_cost'=>$unit_cost,
                        'qty'=>$qty,
                        'unit_x'=>$unit_x,
                        'item'=>$i['item'],
                        'supplier'=>$i['supplier'],
                        'brand'=>$i['brand'],
                        'catalog_no'=>$i['catalog_no']
                    );
                    $a++;
                }

    ?>
          