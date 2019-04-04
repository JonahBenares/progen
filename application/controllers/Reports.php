<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

  function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');

        date_default_timezone_set("Asia/Manila");
        $this->load->model('super_model');
        $this->dropdown['department'] = $this->super_model->select_all_order_by('department', 'department_name', 'ASC');
        $this->dropdown['purpose'] = $this->super_model->select_all_order_by('purpose', 'purpose_desc', 'ASC');
        $this->dropdown['enduse'] = $this->super_model->select_all_order_by('enduse', 'enduse_name', 'ASC');
        $this->dropdown['employee'] = $this->super_model->select_all_order_by('employees', 'employee_name', 'ASC');
        $this->dropdown['assembly_loc'] = $this->super_model->select_all_order_by('assembly_location', 'al_id', 'ASC');
        $this->dropdown['engine'] = $this->super_model->select_all_order_by('assembly_engine', 'engine_name', 'ASC');
        // $this->dropdown['prno'] = $this->super_model->select_join_where("receive_details","receive_head", "saved='1' AND create_date BETWEEN CURDATE() - INTERVAL 60 DAY AND CURDATE()","receive_id");
        //$this->dropdown['prno'] = $this->super_model->select_join_where_order("receive_details","receive_head", "saved='1'","receive_id", "receive_date", "DESC");
         if(isset($_SESSION['user_id'])){
        $sessionid= $_SESSION['user_id'];
      
        foreach($this->super_model->get_table_columns("access_rights") AS $col){
            $this->access[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
            $this->dropdown[$col]=$this->super_model->select_column_where("access_rights",$col, "user_id", $sessionid);
            
        }
      }
        
       foreach($this->super_model->select_custom_where_group("receive_details", "closed=0", "pr_no") AS $dtls){
            foreach($this->super_model->select_custom_where("receive_head", "receive_id = '$dtls->receive_id'") AS $gt){
               if($gt->saved=='1'){
                    $this->dropdown['prno'][] = $dtls->pr_no;
               }
            }  
        }
        function arrayToObject($array){
            if(!is_array($array)) { return $array; }
            $object = new stdClass();
            if (is_array($array) && count($array) > 0) {
                foreach ($array as $name=>$value) {
                    $name = strtolower(trim($name));
                    if (!empty($name)) { $object->$name = arrayToObject($value); }
                }
                return $object;
            } else {
                return false;
            }
        }
    }

    public function itemlist(){
        $item=$this->input->post('item');
        $original_pn=$this->input->post('original_pn');
        $rows=$this->super_model->count_custom_where("items","item_name LIKE '%$item%' OR original_pn LIKE '%$original_pn%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("items", "item_name LIKE '%$item%' OR original_pn LIKE '%$item%'") AS $itm){ 
                    $name = str_replace('"', '', $itm->item_name);
                    ?>
                   <li onClick="selectItem('<?php echo $itm->item_id; ?>','<?php echo $name; ?>','<?php echo $itm->unit_id; ?>','<?php echo $itm->original_pn;?>')"><strong><?php echo $itm->original_pn;?> - </strong> <?php echo $name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }

    public function supplierlist(){
        $supplier=$this->input->post('supplier');
        $rows=$this->super_model->count_custom_where("supplier","supplier_name LIKE '%$supplier%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("supplier", "supplier_name LIKE '%$supplier%'") AS $sup){ 
                    $name = str_replace('"', '', $sup->supplier_name);
                    ?>
                   <li onClick="selectSupplier('<?php echo $sup->supplier_id; ?>','<?php echo $name; ?>')"><?php echo $name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }


    public function prlist(){
        $pr=$this->input->post('pr');
        $rows=$this->super_model->count_custom_where("receive_details","pr_no LIKE '%$pr%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("receive_details", "pr_no LIKE '%$pr%' GROUP BY pr_no") AS $pr){ 
                   /* $dr = $this->super_model->select_column_where('receive_head', 'dr_no', 'receive_id', $pr->receive_id);*/
                    ?>
                    <?php if($pr->closed == '0'){ ?>
                    <li onClick="selectPr('<?php echo $pr->receive_id; ?>','<?php echo $pr->pr_no; ?>')"><?php echo $pr->pr_no; ?> <span class="fa fa-unlock"></span></li>
                    <?php } else { ?>
                    <li onClick="selectPr('<?php echo $pr->receive_id; ?>','<?php echo $pr->pr_no; ?>')"><?php echo $pr->pr_no; ?> <span class="fa fa-lock"></span></li>
                    <?php } ?>
                <?php 
            }
             echo "<ul>";
        }
    }

    public function brandlist(){
        $brand=$this->input->post('brand');
        $rows=$this->super_model->count_custom_where("brand","brand_name LIKE '%$brand%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("brand", "brand_name LIKE '%$brand%'") AS $brnd){ 
                   
                    ?>
                   <li onClick="selectBrand('<?php echo $brnd->brand_id; ?>','<?php echo $brnd->brand_name; ?>')"><?php echo $brnd->brand_name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }

    public function qty_received($item,$supplier,$brand,$catalog){
        $qty=$this->super_model->select_sum_where("supplier_items","quantity","item_id='$item' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no = '$catalog'");
     //   echo "item_id='".$item."' AND supplier_id = '".$supplier."' AND brand_id = '".$brand."' AND catalog_no = '$catalog'";
        return $qty;
    }

     public function qty_restocked($item,$supplier,$brand,$catalog){
      /*  $qty=$this->super_model->select_sum_where("restock","quantity","item_id='$item' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no = '$catalog'");*/
        $qty2=$this->super_model->select_sum_where("restock_details","quantity","item_id='$item' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no = '$catalog'");
        $total=$qty2;
        return $total;
    }

    public function qty_issued($item,$supplier,$brand,$catalog){
        $qty=$this->super_model->select_sum_where("issuance_details","quantity","item_id='$item' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no = '$catalog'");
        return $qty;
    }

    public function dateDifference($date_1 , $date_2){
        $datetime2 = date_create($date_2);
        $datetime1 = date_create($date_1 );
        $interval = date_diff($datetime2, $datetime1);
        return $interval->format('%R%a');
    }

    public function dateDiff($date_1 , $date_2){
        $datetime2 = date_create($date_2);
        $datetime1 = date_create($date_1 );
        $interval = date_diff($datetime2, $datetime1);
        return $interval->format('%a');
    }


    public function aging_report(){
        $this->load->view('template/header');
        $this->load->view('template/topbar');
        $days=$this->uri->segment(3);
        $data['days']=$days;
        if(empty($days)){
            

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
            /*foreach($this->super_model->select_all('receive_head') as $head){
                    
                    foreach ($this->super_model->custom_query("SELECT DISTINCT item_id,supplier_id,brand_id,catalog_no,received_qty,receive_id FROM receive_items WHERE receive_id = '$head->receive_id'") as $age) {
                        $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $age->item_id);
                        $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $age->supplier_id);
                        $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $age->brand_id);
                        $data['date'] = $head->receive_date;
                        $receive_date = $head->receive_date;

                        $data['aging'][] = array(
                            "item"=>$item,
                            "date"=>$receive_date,
                            "qty"=>$age->received_qty,
                            "supplier"=>$supplier,
                            "brand"=>$brand,
                            "catalog_no"=>$age->catalog_no,
                            "sub"=>$new
                        );
                    }
                }*/

            }
        } else {
           // echo $days;
            $startdate = date('Y-m-d',strtotime("-".$days." days"));
            $now=date('Y-m-d');
            //echo $startdate . " " . $now."<br>";
           // foreach($this->super_model->custom_query("SELECT receive_id,receive_date FROM receive_head WHERE receive_date BETWEEN '$startdate' AND '$now'") as $head){

                    foreach($this->super_model->custom_query("SELECT DISTINCT item_id, supplier_id, brand_id, catalog_no FROM receive_items") as $items){
                        $item[] = array(
                            'item'=>$items->item_id,
                            'supplier'=>$items->supplier_id,
                            'brand'=>$items->brand_id,
                            'catalog_no'=>$items->catalog_no
                           
                        );
                    }
            //  }      
        
                    foreach($item AS $i){
                          $a=1;

                        foreach($this->super_model->custom_query("SELECT DISTINCT receive_id FROM receive_items WHERE item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'") AS $q){

                            $unit_cost = $this->super_model->select_column_custom_where("receive_items", "item_cost", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");
                           /* $qty = $this->super_model->select_sum_where("receive_items", "received_qty", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");*/

                           $rec_qty = $this->super_model->custom_query_single("received_qty","SELECT ri.received_qty FROM receive_items ri INNER JOIN receive_details rd ON ri.receive_id = rd.receive_id WHERE ri.item_id = '$i[item]' AND ri.supplier_id = '$i[supplier]' AND ri.brand_id = '$i[brand]' AND ri.catalog_no = '$i[catalog_no]' GROUP BY rd.receive_id");
                  
                    $restock_qty = $this->qty_restocked($i['item'],$i['supplier'],$i['brand'],$i['catalog_no']);
                    $iss_qty =  $this->super_model->custom_query_single("quantity","SELECT quantity FROM issuance_details WHERE item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'");

                    $count_issue = $this->super_model->count_custom_where("issuance_details","item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'");

                      if($a<=$count_issue){
                        if($rec_qty == $iss_qty){
                        
                            $issue_qty  = $iss_qty;

                        } else {
                            $new_iss = $rec_qty - $iss_qty;
                             $issue_qty  = $new_iss;
                          
                        }
                    } else {

                            $new_iss = $rec_qty - $iss_qty;
                            $issue_qty  = $new_iss;
                        

                    }

                            $qty = ($rec_qty+$restock_qty) -  $issue_qty;
                            $unit_x = $qty * $unit_cost;
                    $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $i['item']);

                            $receive_date = $this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $q->receive_id);
                            // echo $item . " - " .$receive_date . " - ". $qty . '<br>';
                            $diff=$this->dateDiff($receive_date , $now);
                            //echo $diff." - " .$days."<br>";
                      if($days!='361'){
                            if($days!='360'){
                                $start_diff=$days-59;
                            } else if($days=='360'){
                                 $start_diff=$days-179;
                            }
                            if($diff>=$start_diff && $diff<=$days){
                                if($qty!=0){
                                $data['total2'][]=$unit_x;
                                $data['info'][]=array(
                                    'receive_id'=>$q->receive_id,
                                    'receive_date'=>$receive_date,
                                    'unit_cost'=>$unit_cost,
                                    'qty'=>$qty,
                                    'unit_x'=>$unit_x,
                                    'item'=>$this->super_model->select_column_where('items', 'item_name', 'item_id', $i['item']),
                                    'supplier'=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $i['supplier']),
                                    'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $i['brand']),
                                    'catalog_no'=>$i['catalog_no']
                                );
                                }
                            }
                        } else{
                            /*if($diff>=$days){
                                if($qty!=0){
                                    $data['total2'][]=$unit_x;
                                    $data['info'][]=array(
                                    'receive_id'=>$q->receive_id,
                                    'receive_date'=>$receive_date,
                                    'unit_cost'=>$unit_cost,
                                    'qty'=>$qty,
                                    'unit_x'=>$unit_x,
                                    'item'=>$this->super_model->select_column_where('items', 'item_name', 'item_id', $i['item']),
                                    'supplier'=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $i['supplier']),
                                    'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $i['brand']),
                                    'catalog_no'=>$i['catalog_no']
                                    );
                                }
                            }*/

                        }
                         $a++;
                       // }
                    }
                 
                
            } 
                       
        }
        $this->load->view('reports/aging_report',$data);
        $this->load->view('template/footer');
    }

    public function aging_report2(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);

        foreach($this->super_model->custom_query("SELECT DISTINCT item_id, supplier_id, brand_id, catalog_no FROM receive_items") as $items){
            $item[] = array(
                'item'=>$items->item_id,
                'supplier'=>$items->supplier_id,
                'brand'=>$items->brand_id,
                'catalog_no'=>$items->catalog_no
            );
        }

       /* foreach($this->super_model->custom_query("SELECT DISTINCT item_id, supplier_id, brand_id, catalog_no FROM receive_items") as $items){
            $data['item_info'][] = array(
                'item'=>$items->item_id,
                'supplier'=>$items->supplier_id,
                'brand'=>$items->brand_id,
                'catalog_no'=>$items->catalog_no,
                'item_desc'=>$this->super_model->select_column_where('items', 'item_name', 'item_id', $items['item']),
                'supplier_name'=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $items['supplier']),
                'brand_name'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $items['brand']),
            );
        }*/

       foreach($item AS $i){
            foreach($this->super_model->custom_query("SELECT DISTINCT receive_id FROM receive_items WHERE item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'") AS $q){
            $unit_cost = $this->super_model->select_column_custom_where("receive_items", "item_cost", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");
            $qty = $this->super_model->select_sum_where("receive_items", "received_qty", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");
            $count = $this->super_model->count_custom_where("receive_items", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");
            $unit_x = $qty * $unit_cost;

            $receive_date = $this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $q->receive_id);
            $data['info'][]=array(
                'receive_id'=>$q->receive_id,
                'receive_date'=>$receive_date,
                'unit_cost'=>$unit_cost,
                'count'=>$count,
                'qty'=>$qty,
                'unit_x'=>$unit_x,
                'item'=>$this->super_model->select_column_where('items', 'item_name', 'item_id', $i['item']),
                'supplier'=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $i['supplier']),
                'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $i['brand']),
                'catalog_no'=>$i['catalog_no']
            );
            }
       }
        $this->load->view('reports/aging_report2',$data);
        $this->load->view('template/footer');
    }

    public function getReceived_items($item, $date){
        foreach($this->super_model->custom_query("SELECT SUM(ri.received_qty) AS qty FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id WHERE rh.receive_date = '$date' AND ri.item_id='$item'") AS $r){
            return $r->qty;
        }
    
    }


    public function getIssued_items($item, $date){
        foreach($this->super_model->custom_query("SELECT SUM(id.quantity) AS qty FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id WHERE ih.issue_date = '$date' AND id.item_id='$item'") AS $r){
            return $r->qty;
        }

    }

     public function getRestocked_items($item, $date){
        
        foreach($this->super_model->custom_query("SELECT SUM(resd.quantity) AS qty FROM restock_head resh INNER JOIN restock_details resd ON resh.rhead_id = resd.rhead_id WHERE resh.restock_date = '$date' AND resd.item_id='$item'") AS $r){
            return $r->qty;
        }

    }

    public function totalReceived_items($item, $from, $to){
        foreach($this->super_model->custom_query("SELECT SUM(ri.received_qty) AS qty FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id WHERE rh.receive_date BETWEEN '$from' AND '$to' AND ri.item_id='$item'") AS $r){
            return $r->qty;
        }
    
    }

      public function totalIssued_items($item,  $from, $to){
        foreach($this->super_model->custom_query("SELECT SUM(id.quantity) AS qty FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id WHERE ih.issue_date BETWEEN '$from' AND '$to' AND id.item_id='$item'") AS $r){
            return $r->qty;
        }

    }

    public function totalRestocked_items($item,  $from, $to){

        foreach($this->super_model->custom_query("SELECT SUM(resd.quantity) AS qty FROM restock_head resh INNER JOIN restock_details resd ON resh.rhead_id = resd.rhead_id WHERE resh.restock_date BETWEEN '$from' AND '$to' AND resd.item_id='$item'") AS $r){
            return $r->qty;
        }

    }

    public function begbal($item, $enddate){
        $beginning= ($this->qty_receive_date($item,$enddate) + $this->qty_restocked_date($item,$enddate)) - $this-> qty_issued_date($item,$enddate);
        return $beginning;
       // echo $this->qty_receive_date($item,$enddate) . "<br>";
    }

    public function first_transaction(){
        foreach($this->super_model->custom_query("SELECT receive_date FROM receive_head ORDER BY receive_date ASC LIMIT 1") AS $r){
            return $r->receive_date;
        }
    }


    public function qty_receive_date($item,$enddate){
       $start = $this->first_transaction();
       foreach($this->super_model->custom_query("SELECT SUM(ri.received_qty) AS qty FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id WHERE rh.receive_date BETWEEN '$start' AND '$enddate' AND ri.item_id='$item'") AS $r){
            return $r->qty;
        }

       
    }

     public function qty_restocked_date($item,$enddate){
         $start = $this->first_transaction();
          foreach($this->super_model->custom_query("SELECT SUM(resd.quantity) AS qty FROM restock_head resh INNER JOIN restock_details resd ON resh.rhead_id = resd.rhead_id WHERE resh.restock_date BETWEEN '$start' AND '$enddate' AND resd.item_id='$item'") AS $r){
            return $r->qty;
        }

    }

    public function qty_issued_date($item,$enddate){
          
        $start = $this->first_transaction();
          foreach($this->super_model->custom_query("SELECT SUM(id.quantity) AS qty FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id WHERE ih.issue_date BETWEEN '$start' AND '$enddate' AND id.item_id='$item'") AS $r){
            return $r->qty;
        }
    }

     public function stock_card_preview(){
        $this->load->view('template/header');
        $id=$this->uri->segment(3);
        $sup=$this->uri->segment(4);
        $supit=0;
        $cat=$this->uri->segment(5);
        $nkk=$this->uri->segment(6);
        $semt=$this->uri->segment(7);
        $brand=$this->uri->segment(8);
        $brandit=0;

        if($cat=='begbal'){
            $begbal = $this->super_model->select_column_custom_where("supplier_items","quantity","(supplier_id = '$supit' OR catalog_no = '$cat1' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brandit') AND item_id = '$id'");
        } else {
            $begbal=0;
        }
        $data['begbal'] = $begbal;
        foreach($this->super_model->select_row_where('items', 'item_id', $id) AS $det){
            $group = $this->super_model->select_column_where('group','group_name','group_id',$det->group_id);
            $location = $this->super_model->select_column_where('location','location_name','location_id',$det->location_id);
            $nkk = $this->super_model->select_column_where('supplier_items','nkk_no','item_id',$det->item_id);
            $semt = $this->super_model->select_column_where('supplier_items','semt_no','item_id',$det->item_id);
            $bin = $this->super_model->select_column_where('bin','bin_name','bin_id',$det->bin_id);
            $data['item'][]=array(
                'item'=>$det->item_name,
                'group'=>$group,
                'nkk'=>$nkk,
                'semt'=>$semt,
                'pn'=>$det->original_pn,
                'location'=>$location,
                'bin'=>$bin,
            );
        }
        /*$count = $this->super_model->count_custom_where("receive_items","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'");
        echo $count;*/
        
        /*foreach($this->super_model->select_custom_where("receive_items","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $rec){*/
        $sql="";
        if($id!='null'){
            $sql.= " item_id = '$id' AND";
        }else {
            $sql.= "";
        }

        if($sup!='null'){
            $sql.= " supplier_id = '$sup' OR";
        }else {
            $sql.= "";
        }

        if($cat!='null'){
            $sql.= " catalog_no = '$cat' OR";
        }else {
            $sql.= "";
        }

        if($nkk!='null'){
            $sql.= " nkk_no = '$nkk' OR";
        }else {
            $sql.= "";
        }

        if($semt!='null'){
            $sql.= " semt_no = '$semt' OR";
        }else {
            $sql.= "";
        }

        if($brand!='null'){
            $sql.= " brand_id = '$brand' OR";
        }else {
            $sql.= "";
        }

        $query=substr($sql,0,-3);
        foreach($this->super_model->select_custom_where("receive_items", $query) AS $rec){
            $receivedate=$this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $rec->receive_id);
            $daterec[]=$receivedate;
            $date = max($daterec);

            $count_iss= $this->super_model->count_custom_where('issuance_details', $query);
            if($count_iss!=0){
                foreach($this->super_model->select_custom_where("issuance_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $issue){
                    $issuedate=$this->super_model->select_column_where("issuance_head", "issue_date", "issuance_id", $issue->issuance_id);
                    $dateiss[]=$issuedate;
                    $dateissue = max($dateiss);
                }
            }else {
                $dateissue = '';
            }

            $issueqty= $this->super_model->select_sum_where('issuance_details', 'quantity', $query);

            

            $count_res = $this->super_model->count_custom_where('restock_details', $query);
            if($count_res!=0){
                foreach($this->super_model->select_custom_where("restock_details",$query) AS $restock2){
                    $restockdate=$this->super_model->select_column_where("restock_head", "restock_date", "rhead_id", $restock2->rhead_id);
                    $datest[]=$restockdate;
                    $datestock = max($datest);
                }
            }else {
                $datestock = '';
            }

            $restockqty= $this->super_model->select_sum_where('restock_details', 'quantity', $query);

            $data['rec_itm'][] = array(
                'receive_qty'=>$rec->received_qty,
                'issueqty'=>$issueqty,
                'restockqty'=>$restockqty,
                'date'=>$date,
                'date_iss'=>$dateissue,
                'date_res'=>$datestock,
            );
        } 

        /*$counter = $this->super_model->count_custom_where("receive_items","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'");
        if($counter!=0){
            foreach($this->super_model->select_custom_where("receive_items","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $rec){
                $receivedate=$this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $rec->receive_id);
                $daterec[]=$receivedate;
                $date = max($daterec);
                $arr_rec[]=$rec->received_qty;
                $data['rec_itm'][] = array(
                    'receive_qty'=>$rec->received_qty,
                    'issueqty'=>0,
                    'restockqty'=>0,
                    'date'=>$date
                );
            }
        }

        $counter_issue = $this->super_model->count_custom_where("issuance_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'");
        if($counter_issue!=0){
            foreach($this->super_model->select_custom_where("issuance_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $issue){
                $issuedate=$this->super_model->select_column_where("issuance_head", "issue_date", "issuance_id", $issue->issuance_id);
                $dateiss[]=$issuedate;
                $dateissue = max($dateiss);
                $arr_iss[]=$issue->quantity;
                $data['rec_itm'][] = array(
                    'receive_qty'=>0,
                    'issueqty'=>$issue->quantity,
                    'restockqty'=>0,
                    'date'=>$dateissue
                );
            }
        }

        $counter_restock2 = $this->super_model->count_custom_where("restock_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'");
        if($counter_restock2!=0){
            foreach($this->super_model->select_custom_where("restock_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $restock2){
                $restockdate=$this->super_model->select_column_where("restock_head", "restock_date", "rhead_id", $restock2->rhead_id);
                $datest[]=$restockdate;
                $datestock = max($datest);
                $arr_rs[]=$restock2->quantity;
                $data['rec_itm'][] = array(
                    'receive_qty'=>0,
                    'issueqty'=>0,
                    'restockqty'=>$restock2->quantity,
                    'date'=>$datestock
                );
            }
        }*/

       /* $sumrec=array_sum($arr_rec);
        $sumiss=array_sum($arr_iss);
        $sumst=array_sum($arr_rs);
        $total=($begbal+$sumrec)-$sumiss;
        $data['total']=$total;*/
       $data['printed']=$this->super_model->select_column_where('users', 'fullname', 'user_id', $_SESSION['user_id']);
       $this->load->view('reports/stock_card_preview',$data);
    }

    public function sc_prev_blank(){
        $this->load->view('template/header');
        $this->load->view('reports/sc_prev_blank');
    }

    public function for_accounting(){
        $this->load->view('template/header');
        $this->load->view('template/topbar');
        $from=$this->uri->segment(3);
        $cat=$this->uri->segment(4);
        $subcat=$this->uri->segment(5);
        $to= date("Y-m-d", strtotime("+6 day", strtotime($from)));
        $data['cat1']=$this->uri->segment(4);
        $data['subcat1']=$this->uri->segment(5);
        $data['from']=$this->uri->segment(3);
        $data['from2']=$this->uri->segment(3);
        $data['from3']=$this->uri->segment(3);
        $data['from4']=$this->uri->segment(3);
        $data['from5']=$this->uri->segment(3);
        $data['from6']=$this->uri->segment(3);
        $data['to']=$to;

        $sql="";
       
        if($cat!='null'){
            $sql.= " WHERE category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " subcat_id = '$subcat' AND";
        }

        $query=substr($sql,0,-3);

        $data['category'] = $this->super_model->select_all_order_by('item_categories','cat_name','ASC');
  //while(strtotime($from) <= strtotime($to)) { 
        foreach($this->super_model->custom_query("SELECT * FROM items ".$query." ORDER BY item_name ASC") AS $it){
           $begbal = $this->super_model->select_column_custom_where("supplier_items","quantity","item_id = '$it->item_id' AND catalog_no = 'begbal'");
           $beg = $this->begbal($it->item_id, $from) + $begbal;
            $ending=($beg + $this->totalReceived_items($it->item_id, $from, $to) + 
                $this->totalRestocked_items($it->item_id, $from, $to))-$this->totalIssued_items($it->item_id, $from, $to);
            $data['items'][]=array(
                'item_name'=>$it->item_name,
                'pn'=>$it->original_pn,
                'unit'=>$this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id),
                'rec_qty1'=>$this->getReceived_items($it->item_id, $from),
                'rec_qty2'=>$this->getReceived_items($it->item_id, date("Y-m-d", strtotime("+1 day", strtotime($from)))),
                'rec_qty3'=>$this->getReceived_items($it->item_id, date("Y-m-d", strtotime("+2 day", strtotime($from)))),
                'rec_qty4'=>$this->getReceived_items($it->item_id, date("Y-m-d", strtotime("+3 day", strtotime($from)))),
                'rec_qty5'=>$this->getReceived_items($it->item_id, date("Y-m-d", strtotime("+4 day", strtotime($from)))),
                'rec_qty6'=>$this->getReceived_items($it->item_id, date("Y-m-d", strtotime("+5 day", strtotime($from)))),
                'rec_qty7'=>$this->getReceived_items($it->item_id, date("Y-m-d", strtotime("+6 day", strtotime($from)))),
                'iss_qty1'=>$this->getIssued_items($it->item_id, $from),
                'iss_qty2'=>$this->getIssued_items($it->item_id, date("Y-m-d", strtotime("+1 day", strtotime($from)))),
                'iss_qty3'=>$this->getIssued_items($it->item_id, date("Y-m-d", strtotime("+2 day", strtotime($from)))),
                'iss_qty4'=>$this->getIssued_items($it->item_id, date("Y-m-d", strtotime("+3 day", strtotime($from)))),
                'iss_qty5'=>$this->getIssued_items($it->item_id, date("Y-m-d", strtotime("+4 day", strtotime($from)))),
                'iss_qty6'=>$this->getIssued_items($it->item_id, date("Y-m-d", strtotime("+5 day", strtotime($from)))),
                'iss_qty7'=>$this->getIssued_items($it->item_id, date("Y-m-d", strtotime("+6 day", strtotime($from)))),
                'res_qty1'=>$this->getRestocked_items($it->item_id, $from),
                'res_qty2'=>$this->getRestocked_items($it->item_id, date("Y-m-d", strtotime("+1 day", strtotime($from)))),
                'res_qty3'=>$this->getRestocked_items($it->item_id, date("Y-m-d", strtotime("+2 day", strtotime($from)))),
                'res_qty4'=>$this->getRestocked_items($it->item_id, date("Y-m-d", strtotime("+3 day", strtotime($from)))),
                'res_qty5'=>$this->getRestocked_items($it->item_id, date("Y-m-d", strtotime("+4 day", strtotime($from)))),
                'res_qty6'=>$this->getRestocked_items($it->item_id, date("Y-m-d", strtotime("+5 day", strtotime($from)))),
                'res_qty7'=>$this->getRestocked_items($it->item_id, date("Y-m-d", strtotime("+6 day", strtotime($from)))),
                'date_item1'=>$from,
                'date_item2'=>date("Y-m-d", strtotime("+1 day", strtotime($from))),
                'date_item3'=>date("Y-m-d", strtotime("+2 day", strtotime($from))),
                'date_item4'=>date("Y-m-d", strtotime("+3 day", strtotime($from))),
                'date_item5'=>date("Y-m-d", strtotime("+4 day", strtotime($from))),
                'date_item6'=>date("Y-m-d", strtotime("+5 day", strtotime($from))),
                'date_item7'=>date("Y-m-d", strtotime("+6 day", strtotime($from))),
                'total_received'=>$this->totalReceived_items($it->item_id, $from, $to),
                'total_issued'=>$this->totalIssued_items($it->item_id, $from, $to),
                'total_restocked'=>$this->totalRestocked_items($it->item_id, $from, $to),
                'beginning'=>$beg,
                'ending'=>$ending
            );
          
        }
        // $from =  date("Y-m-d", strtotime("+1 day", strtotime($from)));
        //$from=date ("Y-m-d", strtotime("-7 day", strtotime($from)));
   // }

       
         
    
    
        $this->load->view('reports/for_accounting',$data);
        $this->load->view('template/footer');
    }

    public function inventory_report(){
        $id=$this->uri->segment(3);
        $data['itemdesc'] = $this->super_model->select_column_where("items", "item_name", "item_id", $id);
        $total=array();
        foreach($this->super_model->select_row_where_group4("supplier_items", "item_id", $id, "item_id", "supplier_id", "brand_id", "catalog_no") AS $it){
             $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $it->supplier_id);
            $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $it->brand_id);
            $recqty=$this->qty_received($id,$it->supplier_id, $it->brand_id,$it->catalog_no);
            $issqty=$this->qty_issued($id,$it->supplier_id, $it->brand_id,$it->catalog_no);
            $resqty=$this->qty_restocked($id,$it->supplier_id, $it->brand_id,$it->catalog_no);
            $balance=$recqty-$issqty;
            $total[]=$balance;
            $data['items'][]=array(
                "supplier"=>$supplier,
                "brand"=>$brand,
                "catalog"=>$it->catalog_no,
                "nkk_no"=>$it->nkk_no,
                "semt_no"=>$it->semt_no,
                "received_qty"=>$recqty,
                "issued_qty"=>$issqty,
                "restocked_qty"=>$resqty,
                "balance"=>$balance
            );
        }


        $totalbal=array_sum($total);
        $data['totalbal']=$totalbal;
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/inventory_report',$data);
        $this->load->view('template/footer');
        
    }



    public function pr_report(){
        $id=$this->uri->segment(3);
        $prno=$this->uri->segment(4);
       /* $counter = $this->super_model->count_custom_where("receive_head","receive_id = '$id'");
        if($counter!=0){
            foreach($this->super_model->select_row_where("receive_head", "receive_id",$id) AS $head){
                $data['head'][]=array(
                    "recid"=>$head->receive_id,
                    "drno"=>$head->dr_no,
                    "jono"=>$head->jo_no,
                    "pono"=>$head->po_no,
                    "sino"=>$head->si_no,
                    "pcf"=>$head->pcf,
                    "recdate"=>$head->receive_date
                );
            } 
        }else {
            $data['head'] = array();
        }*/
        $counter = $this->super_model->count_custom_where("receive_details","pr_no = '$prno'");
         if($counter!=0){
            foreach($this->super_model->select_row_where("receive_details", "pr_no",$prno) AS $det1){
                foreach($this->super_model->select_row_where("receive_head", "receive_id",$det1->receive_id) AS $head)
                    $department = $this->super_model->select_column_where("department", "department_name", "department_id", $det1->department_id);
                $enduse = $this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $det1->enduse_id);
                $purpose = $this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $det1->purpose_id);
                $data['head'][]=array(
                    "recid"=>$head->receive_id,
                    "drno"=>$head->dr_no,
                    "jono"=>$head->jo_no,
                    "pono"=>$head->po_no,
                    "sino"=>$head->si_no,
                    "pcf"=>$head->pcf,
                    "recdate"=>$head->receive_date,
                    "prno"=>$det1->pr_no,
                    "department"=>$department,
                    "enduse"=>$enduse,
                    "purpose"=>$purpose,
                    "closed"=>$det1->closed
                );
            } 
        }else {
            $data['head'] = array();
        }
        foreach($this->super_model->select_custom_where("receive_details", "pr_no = '$prno'") AS $det){
                
                $data['details'][]=array(
                    "recid"=>$det->receive_id,
                    "rdid"=>$det->rd_id,
                    "prno"=>$det->pr_no,
                    "department"=>$department,
                    "enduse"=>$enduse,
                    "purpose"=>$purpose,
                    "closed"=>$det->closed
                );
            foreach($this->super_model->select_custom_where("receive_items", "rd_id = '$det->rd_id'") AS $itm){
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $item){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $item->unit_id);
                }
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $itm->supplier_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
                $unitid = $this->super_model->select_column_where('items', 'unit_id', 'item_id', $itm->item_id);
                $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $unitid);
                $brand = $this->super_model->select_column_where('brand', 'brand_name', 'brand_id', $itm->brand_id);
                $inspected = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $itm->inspected_by);
                $serial = $this->super_model->select_column_where('serial_number', 'serial_no', 'serial_id', $itm->serial_id);
                $data['items'][] = array(
                    'supplier'=>$supplier,
                    'recid'=>$itm->receive_id,
                    'rdid'=>$itm->rd_id,
                    'item'=>$item,
                    'brand'=>$brand,
                    'unit_cost'=>$itm->item_cost,
                    'catalog_no'=>$itm->catalog_no,
                    'nkk_no'=>$itm->nkk_no,
                    'semt_no'=>$itm->semt_no,
                    'serial'=>$serial,
                    'unit'=>$unit,
                    'expqty'=>$itm->expected_qty,
                    'recqty'=>$itm->received_qty,
                    'inspected'=>$inspected,
                    'remarks'=>$itm->remarks
                );
            }
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/pr_report',$data);
        $this->load->view('template/footer');
    }

    public function getCat(){
     /*   $cat = $this->input->post('category');
        $sub= $this->super_model->select_column_where('item_subcat', 'cat_id', 'cat_id', $cat);
        $subcat= $this->super_model->select_column_where('item_subcat', 'subcat_name', 'cat_id', $sub);
        $return = array('sub' => $sub, 'subcat' => $subcat);
        echo json_encode($return);*/
        $cat = $this->input->post('category');
        echo '<option value="">-Select Sub Category-</option>';
        foreach($this->super_model->select_row_where('item_subcat', 'cat_id', $cat) AS $row){
            echo '<option value="'. $row->subcat_id .'">'. $row->subcat_name .'</option>';
      
         }
    }


    public function inventory_balance($itemid){
         $recqty= $this->super_model->select_sum("supplier_items", "quantity", "item_id", $itemid);
      //   $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
         $resqty= $this->super_model->select_sum("restock_details", "quantity", "item_id", $itemid);
         $issueqty= $this->super_model->select_sum("issuance_details","quantity", "item_id",$itemid);
          
         $balance=($recqty+$resqty)-$issueqty;
         return $balance;
    }

    public function range_date(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $data['catt']=$this->uri->segment(5);
        $data['subcat1']=$this->uri->segment(6);
        $data['subcat'] = $this->super_model->select_all('item_subcat');
        $data['category'] = $this->super_model->select_all('item_categories');
        $data['c'] = $this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $data['s'] = $this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " rh.receive_date BETWEEN '$from' AND '$to' AND";
        }

        if($cat!='null'){
            $sql.= " i.category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " i.subcat_id = '$subcat' AND";
        }

        $query=substr($sql,0,-3);
        $count=$this->super_model->custom_query("SELECT rh.* FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id WHERE rh.saved='1' AND ".$query);
        if($count!=0){
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id  FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id WHERE rh.saved='1' AND ".$query) AS $head){
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $head->item_id);
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $head->item_id);
                $totalqty=$this->inventory_balance($head->item_id);
                $data['head'][] = array(
                    'item'=>$item,
                    'pn'=>$pn,
                    'total'=>$totalqty
                );          
            }
        } 
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/range_date',$data);
        $this->load->view('template/footer');
    }

    public function restock_report(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        $item=$this->uri->segment(7);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $data['catt1']=$this->uri->segment(5);
        $data['subcat2']=$this->uri->segment(6);
        $data['item1']=$this->uri->segment(7);
        $data['item'] = $this->super_model->select_all_order_by('items', 'item_name', 'ASC');
        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat', 'subcat_name', 'ASC');
        $data['category'] = $this->super_model->select_all_order_by('item_categories', 'cat_name', 'ASC');
        $data['c'] = $this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $data['s'] = $this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " rh.restock_date BETWEEN '$from' AND '$to' AND";
        }

        if($cat!='null'){
            $sql.= " i.category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " i.subcat_id = '$subcat' AND";
        }

        if($item!='null'){
            $sql.= " i.item_id = '$item' AND";
        }

        $query=substr($sql,0,-3);
        $count=$this->super_model->custom_query("SELECT rh.* FROM restock_head rh INNER JOIN restock_details rd ON rh.rhead_id = rd.rhead_id INNER JOIN items i ON rd.item_id = i.item_id WHERE rh.saved='1' AND ".$query);
        if($count!=0){
         
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id, sr.supplier_id, rd.rdetails_id FROM restock_head rh INNER JOIN restock_details rd ON rh.rhead_id = rd.rhead_id INNER JOIN items i ON rd.item_id = i.item_id INNER JOIN supplier sr ON sr.supplier_id = rd.supplier_id WHERE rh.saved='1' AND ".$query."ORDER BY rh.restock_date DESC") AS $itm){
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $itm->supplier_id);
                $qty = $this->super_model->select_column_where('restock_details', 'quantity', 'rhead_id', $itm->rhead_id); 
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $itm->item_id);
                $pr = $this->super_model->select_column_where('restock_head', 'pr_no', 'rhead_id', $itm->rhead_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $itm->department_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $itm->purpose_id);
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $itm->enduse_id);  
                $restock_date = $this->super_model->select_column_where('restock_head', 'restock_date', 'rhead_id', $itm->rhead_id);
                $received = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $itm->received_by);
                $returned = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $itm->returned_by);
                $acknowledge = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $itm->acknowledge_by);
                $noted_by = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $itm->noted_by);
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }             
                $data['restock'][] = array( 
                    'pr'=>$pr, 
                    'unit'=>$unit,
                    'res_date'=>$restock_date,       
                    'supplier'=>$supplier,
                    'item'=>$item,
                    'department'=>$department,
                    'purpose'=>$purpose,
                    'enduse'=>$enduse,
                    'pn'=>$pn,
                    'qty'=>$qty,
                    'acknowledge'=>$acknowledge,
                    'noted_by'=>$noted_by,
                    'returned_by'=>$returned,
                    'received_by'=>$received
                );
            }
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/restock_report',$data);
        $this->load->view('template/footer');
    }

    public function received_report(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        $item=$this->uri->segment(7);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $data['catt1']=$this->uri->segment(5);
        $data['subcat2']=$this->uri->segment(6);
        $data['item1']=$this->uri->segment(7);
        $data['item'] = $this->super_model->select_all_order_by('items', 'item_name', 'ASC');
        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat', 'subcat_name', 'ASC');
        $data['category'] = $this->super_model->select_all_order_by('item_categories', 'cat_name', 'ASC');
        $data['c'] = $this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $data['s'] = $this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " rh.receive_date BETWEEN '$from' AND '$to' AND";
        }

        if($cat!='null'){
            $sql.= " i.category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " i.subcat_id = '$subcat' AND";
        }

        if($item!='null'){
            $sql.= " i.item_id = '$item' AND";
        }

        $query=substr($sql,0,-3);
        $count=$this->super_model->custom_query("SELECT rh.* FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id INNER JOIN receive_details rd ON rd.receive_id = ri.receive_id WHERE rh.saved='1' AND ".$query);
        if($count!=0){
         
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id, sr.supplier_id,dt.department_id,pr.purpose_id,e.enduse_id, ri.ri_id, rd.rd_id FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN receive_details rd ON rd.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id INNER JOIN supplier sr ON sr.supplier_id = ri.supplier_id INNER JOIN department dt ON dt.department_id = rd.department_id INNER JOIN purpose pr ON pr.purpose_id = rd.purpose_id INNER JOIN enduse e ON e.enduse_id = rd.enduse_id WHERE rh.saved='1' AND ri.rd_id = rd.rd_id AND ".$query."ORDER BY rh.receive_date DESC") AS $itm){
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $itm->supplier_id);
                $recqty = $this->super_model->select_column_where('receive_items', 'received_qty', 'ri_id', $itm->ri_id); 
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $itm->item_id);
                $pr = $this->super_model->select_column_where('receive_details', 'pr_no', 'rd_id', $itm->rd_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $itm->department_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $itm->purpose_id);
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $itm->enduse_id);  
                $rec_date = $this->super_model->select_column_where('receive_head', 'receive_date', 'receive_id', $itm->receive_id);
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }             
                $data['rec'][] = array( 
                    'pr'=>$pr, 
                    'unit'=>$unit,
                    'rec_date'=>$rec_date,       
                    'supplier'=>$supplier,
                    'item'=>$item,
                    'department'=>$department,
                    'purpose'=>$purpose,
                    'enduse'=>$enduse,
                    'pn'=>$pn,
                    'recqty'=>$recqty,
                );
            }
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/received_report',$data);
        $this->load->view('template/footer');
    }

    public function issued_report(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        $item=$this->uri->segment(7);
        $data['from']=$this->uri->segment(3);
        $data['to']=$this->uri->segment(4);
        $data['catt']=$this->uri->segment(5);
        $data['subcat1']=$this->uri->segment(6);
        $data['item1']=$this->uri->segment(7);
        $data['item'] = $this->super_model->select_all_order_by('items','item_name','ASC');
        $data['subcat'] = $this->super_model->select_all_order_by('item_subcat','subcat_name','ASC');
        $data['category'] = $this->super_model->select_all_order_by('item_categories','cat_name','ASC');
        $data['c'] = $this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $data['s'] = $this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " ih.issue_date BETWEEN '$from' AND '$to' AND";
        }

        if($cat!='null'){
            $sql.= " i.category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " i.subcat_id = '$subcat' AND";
        }

        if($item!='null'){
            $sql.= " i.item_id = '$item' AND";
        }

        $query=substr($sql,0,-3);
        $count=$this->super_model->custom_query("SELECT ih.* FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id INNER JOIN items i ON id.item_id = i.item_id WHERE ih.saved='1' AND ".$query. " ORDER BY ih.issue_date DESC");
       /* echo "SELECT ih.* FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id INNER JOIN items i ON id.item_id = i.item_id WHERE ih.saved='1' AND ".$query;*/
        if($count!=0){
            //echo "SELECT ih.*,i.item_id, sr.supplier_id,dt.department_id,pr.purpose_id,e.enduse_id, id.is_id FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id INNER JOIN items i ON id.item_id = i.item_id INNER JOIN supplier sr ON sr.supplier_id = id.supplier_id INNER JOIN department dt ON dt.department_id = ih.department_id INNER JOIN purpose pr ON pr.purpose_id = ih.purpose_id INNER JOIN enduse e ON e.enduse_id = ih.enduse_id WHERE ih.saved='1' AND ih.issuance_id = id.issuance_id AND ".$query. "ORDER BY ih.issue_date";
            foreach($this->super_model->custom_query("SELECT ih.*,i.item_id, id.supplier_id, dt.department_id,pr.purpose_id,e.enduse_id, id.is_id FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id INNER JOIN items i ON id.item_id = i.item_id INNER JOIN department dt ON dt.department_id = ih.department_id INNER JOIN purpose pr ON pr.purpose_id = ih.purpose_id INNER JOIN enduse e ON e.enduse_id = ih.enduse_id WHERE ih.saved='1' AND ih.issuance_id = id.issuance_id AND ".$query. " ORDER BY ih.issue_date DESC") AS $itm){

                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $itm->supplier_id);
                $issqty = $this->super_model->select_column_where('issuance_details', 'quantity', 'is_id', $itm->is_id); 
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $itm->item_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $itm->department_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $itm->purpose_id);
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $itm->enduse_id);
                $issue_date = $this->super_model->select_column_where('issuance_head', 'issue_date', 'issuance_id', $itm->issuance_id);
                /*$pr = $this->super_model->select_column_where('request_head', 'pr_no', 'mreqf_no', $itm->mreqf_no);*/
                $pr = $this->super_model->select_column_where('issuance_head', 'pr_no', 'mreqf_no', $itm->mreqf_no);
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }
                $data['issue'][] = array(
                    'issue_date'=>$issue_date,
                    'pr'=>$pr,
                    'unit'=>$unit,
                    'supplier'=>$supplier,
                    'item'=>$item,
                    'department'=>$department,
                    'purpose'=>$purpose,
                    'enduse'=>$enduse,
                    'pn'=>$pn,
                    'issqty'=>$issqty,
                    'issuance_id'=>$itm->issuance_id
                );
            }
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/issued_report',$data);
        $this->load->view('template/footer');
    }

    public function stock_card(){
        $id=$this->uri->segment(3);
        $data['id']=$this->uri->segment(3);
        $sup=$this->uri->segment(4);
        $data['sup']=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $data['cat']=$this->uri->segment(5);
        $nkk=$this->uri->segment(6);
        $data['nkk']=$this->uri->segment(6);
        $semt=$this->uri->segment(7);
        $data['semt']=$this->uri->segment(7);
        $brand=$this->uri->segment(8);
        $data['brand']=$this->uri->segment(8);
        $arr_rec=array();
        $arr_iss=array();
        $arr_rs=array();
        $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $sup);
                $brandname = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $brand);
        $data['itemdesc'] = $this->super_model->select_column_where("items", "item_name", "item_id", $id);
        //foreach($this->super_model->select_row_where('receive_items', 'item_id', $id) AS $it){

        if($id=='null'){
            $id='';
        } else {
            $id=$id;
        }

         if($sup=='null'){
            $sup='';
            $supit=0;
        } else {
            $sup=$sup;
        }

         if($cat=='null'){
            $cat='';
         
        } else {
            $cat=$cat;
        }

        if($nkk=='null'){
            $nkk='';
         
        } else {
            $nkk=$nkk;
        }

        if($semt=='null'){
            $semt='';
         
        } else {
            $semt=$semt;
        }

         if($brand=='null'){
            $brand='';
            $brandit=0;
        } else {
            $brand=$brand;
        }

        if($cat=='begbal'){
        $begbal = $this->super_model->select_column_custom_where("supplier_items","quantity","(supplier_id = '$supit' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brandit') AND item_id = '$id'");
        } else {
            $begbal=0;
        }

            $counter = $this->super_model->count_custom_where("receive_items","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'");
          
            //echo $id ." - ". $sup . " - " . $cat . " - " . $brand;
            if($counter!=0){
                //unset($daterec);
                
                foreach($this->super_model->select_custom_where("receive_items","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $rec){
                    $receivedate=$this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $rec->receive_id);
                    //echo $rec->receive_id;
                    $daterec[]=$receivedate;
                    $date = max($daterec);
                    $prno = $this->super_model->select_column_where("receive_details", "pr_no", "receive_id", $rec->receive_id);
                  /*  $issueqty = $this->super_model->select_column_join_where("quantity","issuance_head","issuance_details", "saved='1' AND pr_no = '$prno' AND item_id='$id' AND supplier_id = '$sup' AND brand_id = '$brand' AND catalog_no = '$cat'", "issuance_id");*/
                  //  $received_qty = $this->super_model->select_column_custom_where("receive_items","received_qty","item_id='$id' AND supplier_id = '$sup' AND brand_id = '$brand' AND catalog_no = '$cat'");
                    $arr_rec[]=$rec->received_qty;
                    $data['rec_itm'][] = array(
                        'supplier'=>$supplier,
                        'catalog_no'=>$cat,
                        'nkk'=>$nkk,
                        'semt'=>$semt,
                        'brand'=>$brandname,
                        'item_cost'=>$rec->item_cost,
                        'receive_qty'=>$rec->received_qty,
                        'issueqty'=>0,
                        'restockqty'=>0,
                        'date'=>$date
                    );
                }
            }

            $counter_issue = $this->super_model->count_custom_where("issuance_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'");
            //echo $id . " - " . $sup . " - " . $cat . " - " . $brand;
             if($counter_issue!=0){
               
                foreach($this->super_model->select_custom_where("issuance_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $issue){
                    $issuedate=$this->super_model->select_column_where("issuance_head", "issue_date", "issuance_id", $issue->issuance_id);

                     $cost=$this->super_model->select_column_where("request_items", "unit_cost", "rq_id", $issue->rq_id);

                    //echo $rec->receive_id;
                    $dateiss[]=$issuedate;
                    $dateissue = max($dateiss);
                   /* $prno = $this->super_model->select_column_where("issuance_details", "pr_no", "issuance_id", $issue->issuance_id);*/
                  
                    //$issue_qty = $this->super_model->select_column_custom_where("issuance_details","quantity","item_id='$id' AND supplier_id = '$sup' AND brand_id = '$brand' AND catalog_no = '$cat'");
                    $arr_iss[]=$issue->quantity;
                    $data['rec_itm'][] = array(
                        'supplier'=>$supplier,
                        'catalog_no'=>$cat,
                        'nkk'=>$nkk,
                        'semt'=>$semt,
                        'brand'=>$brandname,
                        'item_cost'=>$cost,
                        'receive_qty'=>0,
                        'issueqty'=>$issue->quantity,
                        'restockqty'=>0,
                        'date'=>$dateissue
                    );
                }
            }

          /*   $counter_restock = $this->super_model->count_custom_where("restock","item_id = '$id' AND supplier_id = '$sup' AND catalog_no = '$cat' AND brand_id = '$brand'");
*/
             $counter_restock2 = $this->super_model->count_custom_where("restock_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'");
            //echo $id . " - " . $sup . " - " . $cat . " - " . $brand;
             if($counter_restock2!=0){
               
              /*  foreach($this->super_model->select_custom_where("restock","item_id = '$id' AND supplier_id = '$sup' AND catalog_no = '$cat' AND brand_id = '$brand'") AS $restock){
                    $restockdate=$this->super_model->select_column_where("restock", "restock_date", "restock_id", $restock->restock_id);
                    
                  
                    $rdid=$this->super_model->select_column_where("receive_details", "rd_id", "pr_no", $restock->pr_no);

                    $cost=$this->super_model->select_column_custom_where("receive_items", "item_cost", "rd_id = '$rdid' AND item_id = '$id' AND supplier_id = '$sup' AND catalog_no = '$cat' AND brand_id = '$brand'");

                    $datest[]=$restockdate;
                    $datestock = max($datest);
                 
                    $arr_rs[]=$restock->quantity;
                    $data['rec_itm'][] = array(
                        'supplier'=>$supplier,
                        'catalog_no'=>$cat,
                        'brand'=>$brandname,
                        'item_cost'=>$cost,
                        'receive_qty'=>0,
                        'issueqty'=>0,
                        'restockqty'=>$restock->quantity,
                        'date'=>$datestock
                    );
                }*/


                foreach($this->super_model->select_custom_where("restock_details","(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id'") AS $restock2){
                    $restockdate=$this->super_model->select_column_where("restock_head", "restock_date", "rhead_id", $restock2->rhead_id);
                    //echo $rec->receive_id;
                    $pr=$this->super_model->select_column_where("restock_head", "pr_no", "rhead_id", $restock2->rhead_id);
                    $rdid=$this->super_model->select_column_where("receive_details", "rd_id", "pr_no", $pr);

                    $cost=$this->super_model->select_column_custom_where("receive_items", "item_cost", "(supplier_id = '$sup' OR catalog_no = '$cat' OR nkk_no = '$nkk' OR semt_no = '$semt' OR brand_id = '$brand') AND item_id = '$id' AND rd_id = '$rdid'");
                    $datest[]=$restockdate;
                    $datestock = max($datest);
                   /* $prno = $this->super_model->select_column_where("issuance_details", "pr_no", "issuance_id", $issue->issuance_id);*/
                  
                    //$issue_qty = $this->super_model->select_column_custom_where("issuance_details","quantity","item_id='$id' AND supplier_id = '$sup' AND brand_id = '$brand' AND catalog_no = '$cat'");
                    $arr_rs[]=$restock2->quantity;
                    $data['rec_itm'][] = array(
                        'supplier'=>$supplier,
                        'catalog_no'=>$cat,
                        'nkk'=>$nkk,
                        'semt'=>$semt,
                        'brand'=>$brandname,
                        'item_cost'=>$cost,
                        'receive_qty'=>0,
                        'issueqty'=>0,
                        'restockqty'=>$restock2->quantity,
                        'date'=>$datestock
                    );
                }
            }

            $sumrec=array_sum($arr_rec);
            $sumiss=array_sum($arr_iss);
            $sumst=array_sum($arr_rs);
            $total=($begbal+$sumrec+$sumst)-$sumiss;
            $data['total']=$total;
       // } 
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/stock_card',$data);
        $this->load->view('template/footer');
    }

    public function generateReport(){
           $id= $this->input->post('item_id'); 
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/inventory_report/<?php echo $id; ?>'</script> <?php
    } 

    public function generateRange(){

           if(!empty($this->input->post('from'))){
                $from = $this->input->post('from');
           } else {
                $from = "null";
           }

           if(!empty($this->input->post('to'))){
                $to = $this->input->post('to');
           } else {
                $to = "null";
           }

           if(!empty($this->input->post('category'))){
                $cat = $this->input->post('category');
           } else {
                $cat = "null";
           }

           if(!empty($this->input->post('subcat'))){
                $subcat = $this->input->post('subcat');
           } else {
                $subcat = "null";
           }


      
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/range_date/<?php echo $from; ?>/<?php echo $to; ?>/<?php echo $cat; ?>/<?php echo $subcat; ?>'</script> <?php
    }

    public function generateRestock(){
           if(!empty($this->input->post('from'))){
                $from = $this->input->post('from');
           } else {
                $from = "null";
           }

           if(!empty($this->input->post('to'))){
                $to = $this->input->post('to');
           } else {
                $to = "null";
           }

           if(!empty($this->input->post('category'))){
                $cat = $this->input->post('category');
           } else {
                $cat = "null";
           }

           if(!empty($this->input->post('subcat'))){
                $subcat = $this->input->post('subcat');
           } else {
                $subcat = "null";
           } 

            if(!empty($this->input->post('item'))){
                $item = $this->input->post('item');
           } else {
                $item = "null";
           } 
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/restock_report/<?php echo $from; ?>/<?php echo $to; ?>/<?php echo $cat; ?>/<?php echo $subcat; ?>/<?php echo $item; ?>'</script> <?php
    }

    public function generateReceived(){
           if(!empty($this->input->post('from'))){
                $from = $this->input->post('from');
           } else {
                $from = "null";
           }

           if(!empty($this->input->post('to'))){
                $to = $this->input->post('to');
           } else {
                $to = "null";
           }

           if(!empty($this->input->post('category'))){
                $cat = $this->input->post('category');
           } else {
                $cat = "null";
           }

           if(!empty($this->input->post('subcat'))){
                $subcat = $this->input->post('subcat');
           } else {
                $subcat = "null";
           } 

            if(!empty($this->input->post('item'))){
                $item = $this->input->post('item');
           } else {
                $item = "null";
           } 
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/received_report/<?php echo $from; ?>/<?php echo $to; ?>/<?php echo $cat; ?>/<?php echo $subcat; ?>/<?php echo $item; ?>'</script> <?php
    }

    public function generateIssue(){
           if(!empty($this->input->post('from'))){
                $from = $this->input->post('from');
           } else {
                $from = "null";
           }

           if(!empty($this->input->post('to'))){
                $to = $this->input->post('to');
           } else {
                $to = "null";
           }

           if(!empty($this->input->post('category'))){
                $cat = $this->input->post('category');
           } else {
                $cat = "null";
           }

           if(!empty($this->input->post('subcat'))){
                $subcat = $this->input->post('subcat');
           } else {
                $subcat = "null";
           } 

           if(!empty($this->input->post('item'))){
                $item = $this->input->post('item');
           } else {
                $item = "null";
           } 
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/issued_report/<?php echo $from; ?>/<?php echo $to; ?>/<?php echo $cat; ?>/<?php echo $subcat; ?>/<?php echo $item; ?>'</script> <?php
    }

    public function generateItemReport(){
           $id= $this->input->post('item_id'); 
           ?>
           <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/item_report/<?php echo $id; ?>'</script> <?php
    } 


    public function generateStkcrd(){
        /*$catno=$this->input->post('catalog_no');
        $id= $this->input->post('item_id'); 
        $sid= $this->input->post('supplier_id'); 
        $bid= $this->input->post('brand_id');*/
        if(!empty($this->input->post('item_id'))){
            $id = $this->input->post('item_id');
        } else {
            $id = "null";
        }

        if(!empty($this->input->post('catalog_no'))){
            $catno = $this->input->post('catalog_no');
        } else {
            $catno = "null";
        } 

        if(!empty($this->input->post('supplier_id'))){
            $sid = $this->input->post('supplier_id');
        } else {
            $sid = "null";
        } 

        if(!empty($this->input->post('brand_id'))){
            $bid = $this->input->post('brand_id');
        } else {
            $bid = "null";
        }

        if(!empty($this->input->post('nkk'))){
            $nkk = $this->input->post('nkk');
        } else {
            $nkk = "null";
        }

        if(!empty($this->input->post('semt'))){
            $semt = $this->input->post('semt');
        } else {
            $semt = "null";
        }

        ?>

        <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/stock_card/<?php echo $id; ?>/<?php echo $sid;?>/<?php echo $catno; ?>/<?php echo $nkk; ?>/<?php echo $semt; ?>/<?php echo $bid; ?>'
        </script> 
    <?php
    } 
    public function generatePr(){
        $prno=$this->input->post('pr');
        $prid=$this->input->post('prid');
        ?>
        <script>
            window.location.href ='<?php echo base_url(); ?>index.php/reports/pr_report/<?php echo $prid;?>/<?php echo $prno;?>'
        </script> 
    <?php
    }  

    public function borrowing_report(){         
        $count=$this->super_model->select_count_join_inner("request_items","issuance_head", "request_items.borrowfrom_pr !='' AND replenished='0'","request_id");
        if($count!=0){
            foreach($this->super_model->select_join_where_inner("request_items","issuance_head", "request_items.borrowfrom_pr !='' AND replenished='0'","request_id") AS $itms){
               
                $data['list'][]=array(
                    'rqid'=>$itms->rq_id,
                    'mreqf_no'=>$this->super_model->select_column_where("request_head", "mreqf_no", "request_id", $itms->request_id),
                    'request_date'=>$this->super_model->select_column_where("request_head", "request_date", "request_id", $itms->request_id),
                    'request_time'=>$this->super_model->select_column_where("request_head", "request_time", "request_id", $itms->request_id),
                    'original_pr'=>$this->super_model->select_column_where("request_head", "pr_no", "request_id", $itms->request_id),
                    'borrowfrom'=>$itms->borrowfrom_pr,
                    'quantity'=>$itms->quantity,
                    'supplier'=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $itms->supplier_id),
                    'item'=>$this->super_model->select_column_where("items", "item_name", "item_id", $itms->item_id),
                    'brand'=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $itms->brand_id),
                    'catalog'=>$itms->catalog_no,
                    'nkk'=>$itms->nkk_no,
                    'semt'=>$itms->semt_no


                );
            } 
        } else {
            $data['list']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/borrowing_report',$data);
        $this->load->view('template/footer');
    }

    public function replenishborrow(){
        $id=$this->input->post('id');

        $data=array(
            'replenished'=>'1'
        );

        if($this->super_model->update_where("request_items", $data, "rq_id", $id)){
            echo "ok";
        }
    }

    public function item_report(){
        $id=$this->uri->segment(3);
        $data['itemdesc']=$this->super_model->select_column_where("items", "item_name", "item_id", $id);

        foreach($this->super_model->custom_query("SELECT pr_no, SUM(received_qty) AS qty FROM receive_items ri INNER JOIN receive_details rd ON ri.rd_id = rd.rd_id WHERE ri.item_id = '$id' GROUP BY rd.pr_no") AS $head){
            /*$issueqty=$this->super_model->custom_query_single("qty","SELECT SUM(quantity) AS qty FROM issuance_head ih INNER JOIN issuance_details id WHERE item_id= '$id' AND pr_no='$head->pr_no' GROUP BY pr_no");*/
          //  $qty=$this->super_model->select_sum_join_group("received_qty","receive_items","receive_details", "receive_details.receive_id = '$head->receive_id'", "rd_id","pr_no");
                $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$id' AND pr_no='$head->pr_no'","issuance_id");
                $total=$head->qty-$issueqty;
                $data['list'][] = array(
                    "prno"=>$head->pr_no,
                    "recqty"=>$head->qty,
                    "issueqty"=>$issueqty,
                    "total"=>$total
                );
            
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('reports/item_report',$data);
        $this->load->view('template/footer');
    }

    public function export_foraccounting(){
        $from=$this->uri->segment(3);
        $from2=$this->uri->segment(3);
        $from3=$this->uri->segment(3);
        $from4=$this->uri->segment(3);
        $from5=$this->uri->segment(3);
        $from6=$this->uri->segment(3);
        $to= date("Y-m-d", strtotime("+6 day", strtotime($from)));
        $cat=$this->uri->segment(4);
        $subcat=$this->uri->segment(5);

        echo $from;

        $sql="";
       
        if($cat!='null'){
            $sql.= " WHERE category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " subcat_id = '$subcat' AND";
        }

        $query=substr($sql,0,-3);

        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="For Accounting Report.xlsx";

        $gdImage = imagecreatefrompng('assets/default/logo_cenpri.png');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(35);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "Date:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "Warehouse");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Main Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', "Part No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J10', "UoM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', "Beginning Balance");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "MATERIAL RECIEVED");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S10', "Total Items Received (in)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S12', "Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T10', "MATERIAL ISSUED");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA10', "Total Items Issued (out)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA12', "Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB10', "MATERIAL RESTOCK");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI10', "Total Restock (in)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI12', "Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ10', "Ending Inventory as of (Date)");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ12', "Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', $from);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', $to);

        $objPHPExcel->getActiveSheet()->getStyle('S12')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('AA12')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('AI12')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('AJ12')->getFont()->setBold(true);
        
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PROGEN DIESEL TECH");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "FROM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "TO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M2', "MATERIAL INVENTORY REPORT (WEEKLY) FOR ACCOUNTING");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "Sub-Category");
        $num=13;
        $catname=$this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $subcatname=$this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
       
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $catname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', $subcatname);
        $x = 1;
        foreach($this->super_model->custom_query("SELECT * FROM items ".$query." ORDER BY item_name ASC") AS $itm){
            $ending=($this->begbal($itm->item_id, $from) + $this->totalReceived_items($itm->item_id, $from, $to) + 
            $this->totalRestocked_items($itm->item_id, $from, $to))-$this->totalIssued_items($itm->item_id, $from, $to);
            $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $itm->item_id);
            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
            $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $itm->unit_id);
            $begbal = $this->begbal($itm->item_id, $from); 
            $total_received=$this->totalReceived_items($itm->item_id, $from, $to);
            $total_issued=$this->totalIssued_items($itm->item_id, $from, $to);
            $total_restocked=$this->totalRestocked_items($itm->item_id, $from, $to);
            $rec_qty1 = $this->getReceived_items($itm->item_id, $from);
            $rec_qty2 = $this->getReceived_items($itm->item_id, date("Y-m-d", strtotime("+1 day", strtotime($from))));
            $rec_qty3 = $this->getReceived_items($itm->item_id, date("Y-m-d", strtotime("+2 day", strtotime($from))));
            $rec_qty4 = $this->getReceived_items($itm->item_id, date("Y-m-d", strtotime("+3 day", strtotime($from))));
            $rec_qty5 = $this->getReceived_items($itm->item_id, date("Y-m-d", strtotime("+4 day", strtotime($from))));
            $rec_qty6 = $this->getReceived_items($itm->item_id, date("Y-m-d", strtotime("+5 day", strtotime($from))));
            $rec_qty7 = $this->getReceived_items($itm->item_id, date("Y-m-d", strtotime("+6 day", strtotime($from))));
            $iss_qty1 = $this->getIssued_items($itm->item_id, $from);
            $iss_qty2 = $this->getIssued_items($itm->item_id, date("Y-m-d", strtotime("+1 day", strtotime($from))));
            $iss_qty3 = $this->getIssued_items($itm->item_id, date("Y-m-d", strtotime("+2 day", strtotime($from))));
            $iss_qty4 = $this->getIssued_items($itm->item_id, date("Y-m-d", strtotime("+3 day", strtotime($from))));
            $iss_qty5 = $this->getIssued_items($itm->item_id, date("Y-m-d", strtotime("+4 day", strtotime($from))));
            $iss_qty6 = $this->getIssued_items($itm->item_id, date("Y-m-d", strtotime("+5 day", strtotime($from))));
            $iss_qty7 = $this->getIssued_items($itm->item_id, date("Y-m-d", strtotime("+6 day", strtotime($from))));
            $res_qty1 = $this->getRestocked_items($itm->item_id, $from);
            $res_qty2 = $this->getRestocked_items($itm->item_id, date("Y-m-d", strtotime("+1 day", strtotime($from))));
            $res_qty3 = $this->getRestocked_items($itm->item_id, date("Y-m-d", strtotime("+2 day", strtotime($from))));
            $res_qty4 = $this->getRestocked_items($itm->item_id, date("Y-m-d", strtotime("+3 day", strtotime($from))));
            $res_qty5 = $this->getRestocked_items($itm->item_id, date("Y-m-d", strtotime("+4 day", strtotime($from))));
            $res_qty6 = $this->getRestocked_items($itm->item_id, date("Y-m-d", strtotime("+5 day", strtotime($from))));
            $res_qty7 = $this->getRestocked_items($itm->item_id, date("Y-m-d", strtotime("+6 day", strtotime($from))));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $pn);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $item);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $begbal);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $unit); 
            if(strtotime($from4) <= strtotime($to)) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $rec_qty1);
                $from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
            }if(strtotime($from4) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $rec_qty2);
                $from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
            }
            if(strtotime($from4) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $rec_qty3);
                $from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
            }if(strtotime($from4) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$num, $rec_qty4);
                $from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
            }if(strtotime($from4) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $rec_qty5);
                $from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
            }if(strtotime($from4) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$num, $rec_qty6);
                $from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
            }if(strtotime($from4) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $rec_qty7);
                $from4 = date ("Y-m-d", strtotime("+1 day", strtotime($from4)));
            }
            $from4=date ("Y-m-d", strtotime("-7 day", strtotime($from4)));


            if(strtotime($from5) <= strtotime($to)) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $iss_qty1);
                $from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
            }if(strtotime($from5) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $iss_qty2);
                $from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
            }
            if(strtotime($from5) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $iss_qty3);
                $from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
            }if(strtotime($from5) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('W'.$num, $iss_qty4);
                $from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
            }if(strtotime($from5) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $iss_qty5);
                $from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
            }if(strtotime($from5) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$num, $iss_qty6);
                $from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
            }if(strtotime($from5) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $iss_qty7);
                $from5 = date ("Y-m-d", strtotime("+1 day", strtotime($from5)));
            }
            $from5=date ("Y-m-d", strtotime("-7 day", strtotime($from5)));


            if(strtotime($from6) <= strtotime($to)) {
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AB'.$num, $res_qty1);
                $from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
            }if(strtotime($from6) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AC'.$num, $res_qty2);
                $from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
            }
            if(strtotime($from6) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$num, $res_qty3);
                $from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
            }if(strtotime($from6) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AE'.$num, $res_qty4);
                $from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
            }if(strtotime($from6) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AF'.$num, $res_qty5);
                $from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
            }if(strtotime($from6) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AG'.$num, $res_qty6);
                $from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
            }if(strtotime($from6) <= strtotime($to)){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AH'.$num, $res_qty7);
                $from6 = date ("Y-m-d", strtotime("+1 day", strtotime($from6)));
            }
            $from6=date ("Y-m-d", strtotime("-7 day", strtotime($from6)));

            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('S'.$num, $total_received);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$num, $total_issued);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AI'.$num, $total_restocked);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AJ'.$num, $ending);
            /*$objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $rec_qty2); 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $rec_qty3); 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$num, $rec_qty4); 
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $rec_qty5);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$num, $rec_qty6);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $rec_qty7);*/

            /*$objPHPExcel->getActiveSheet()->getStyle('D'.$num.":G".$num)->getAlignment()->setWrapText(true);*/
    
            $objPHPExcel->getActiveSheet()->getStyle('H'.$num.":AJ".$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
            $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":AJ".$num,'admin');

            $num++;
            $x++;
            $col_count4++;
            $objPHPExcel->getActiveSheet()->mergeCells('B13:C13');
            $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('D13:G13');
            $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":G".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('H13:I13');
            $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
            $objPHPExcel->getActiveSheet()->mergeCells('J13:K13');
            $objPHPExcel->getActiveSheet()->mergeCells('J'.$num.":K".$num);
            /*$objPHPExcel->getActiveSheet()->mergeCells('H12:K12');
            $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);*/
            $objPHPExcel->getActiveSheet()->getStyle('S13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
            $objPHPExcel->getActiveSheet()->getStyle('S'.$num)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
            $objPHPExcel->getActiveSheet()->getStyle('AA13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
            $objPHPExcel->getActiveSheet()->getStyle('AA'.$num)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
            $objPHPExcel->getActiveSheet()->getStyle('AI13')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
            $objPHPExcel->getActiveSheet()->getStyle('AI'.$num)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
            $objPHPExcel->getActiveSheet()->getStyle('H13:AJ13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H'.$num.":AJ".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('J13:K13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            /*$objPHPExcel->getActiveSheet()->getStyle('L13:R13')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":M".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
            /*$objPHPExcel->getActiveSheet()->getStyle('J'.$num.":K".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        }
        $a = $num+2;
        $b = $num+5;
        $c = $num+4;
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Prepared By: ");
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$b, "Warehouse Personnel ");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$a, "Checked By: ");
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$b, "Warehouse Supervisor ");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$a, "Approved By: ");
        $objPHPExcel->getActiveSheet()->setCellValue('G'.$b, "Plant Director/Plant Manager ");
        $objPHPExcel->getActiveSheet()->protectCells('A'.$a.":AJ".$a,'admin');
        $objPHPExcel->getActiveSheet()->protectCells('A'.$c.":AJ".$c,'admin');  
        
        $col_count = 'L';
        while(strtotime($from) <= strtotime($to)) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_count.'11', date('m/d', strtotime($from)));
            $from = date ("Y-m-d", strtotime("+1 day", strtotime($from)));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_count.'12', "Qty");
            $objPHPExcel->getActiveSheet()->getStyle($col_count.'12')->getFont()->setBold(true);
            $col_count++;
        }

        $col_count2 = 'T';
        while(strtotime($from2) <= strtotime($to)) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_count2.'11', date('m/d', strtotime($from2)));
            $from2 = date ("Y-m-d", strtotime("+1 day", strtotime($from2)));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_count2.'12', "Qty");
            $objPHPExcel->getActiveSheet()->getStyle($col_count2.'12')->getFont()->setBold(true);
            $col_count2++;
        }

        $col_count3 = 'AB';
        while(strtotime($from3) <= strtotime($to)) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_count3.'11', date('m/d', strtotime($from3)));
            $from3 = date ("Y-m-d", strtotime("+1 day", strtotime($from3)));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col_count3.'12', "Qty");
            $objPHPExcel->getActiveSheet()->getStyle($col_count3.'12')->getFont()->setBold(true);
            $col_count3++;
        }
      
        $styleArray = array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        );
        $num--;
        $objPHPExcel->getActiveSheet()->getRowDimension(10)->setRowHeight(-1); 
        $objPHPExcel->getActiveSheet()->getStyle('S10')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AA10')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AI10')->getAlignment()->setWrapText(true);
        $objPHPExcel->getActiveSheet()->getStyle('AJ10')->getAlignment()->setWrapText(true);
        /*$objPHPExcel->getActiveSheet()->mergeCells('H1:K1');*/
        $objPHPExcel->getActiveSheet()->mergeCells('M2:U2');
        /*$objPHPExcel->getActiveSheet()->mergeCells('S10:T10');*/
        $objPHPExcel->getActiveSheet()->mergeCells('T10:Z10');
        $objPHPExcel->getActiveSheet()->mergeCells('AB10:AH10');
        $objPHPExcel->getActiveSheet()->mergeCells('J10:K10');
        $objPHPExcel->getActiveSheet()->mergeCells('L10:R10');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->mergeCells('D10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('H10:I10');

        $objPHPExcel->getActiveSheet()->mergeCells('J11:K11');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:C11');
        $objPHPExcel->getActiveSheet()->mergeCells('D11:G11');
        $objPHPExcel->getActiveSheet()->mergeCells('H11:I11');

        $objPHPExcel->getActiveSheet()->mergeCells('J12:K12');
        $objPHPExcel->getActiveSheet()->mergeCells('B12:C12');
        $objPHPExcel->getActiveSheet()->mergeCells('D12:G12');
        $objPHPExcel->getActiveSheet()->mergeCells('H12:I12');
        /*$objPHPExcel->getActiveSheet()->mergeCells('H10:K10');*/
        $objPHPExcel->getActiveSheet()->getStyle('AA10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('AA11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('AA12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('AI10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('AI11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('AI12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('S10')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('S11')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('S12')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('f4e542');
        $objPHPExcel->getActiveSheet()->getStyle('A11:AJ11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A12:AJ12')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A10:AJ10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A10:AJ'.$num)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AJ3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AJ1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AJ1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AJ2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AJ3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AJ1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AJ2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AJ3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H8:J8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C8:E8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AJ1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AJ2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AJ3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
       /* $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);*/
        $objPHPExcel->getActiveSheet()->getStyle('A10:AJ10')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("M2")->getFont()->setBold(true)->setName('Arial Black');
        $objPHPExcel->getActiveSheet()->getStyle('M2:U2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
       /* $objPHPExcel->getActiveSheet()->getSecurity()->setLockWindows(true);
        $objPHPExcel->getActiveSheet()->getSecurity()->setLockStructure(true);*/
        /*$objPHPExcel->getActiveSheet()
            ->getStyle('A1:F1')
            ->getProtection()->setLocked(
                PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
            );*/
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="For Accounting Report.xlsx"');
        readfile($exportfilename);
        //echo "<script>window.location = 'import_items';</script>";
    }

    public function export(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Inventory Report.xlsx";

        $gdImage = imagecreatefrompng('assets/default/logo_cenpri.png');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(35);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));

        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "Warehouse");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Main Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', "Item Part No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E10', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K10', "Avail. Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PROGEN DIESEL TECH");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "MATERIAL INVENTORY REPORT");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('I2', "TO DATE");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "Sub-Category");
        $num=11;
        foreach($this->super_model->select_custom_where("receive_head","receive_date BETWEEN '$from' AND '$to'") AS $head){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', $from.' - '.$to);
        } 
         foreach($this->super_model->select_custom_where("item_categories","cat_id = '$cat'") AS $category){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $category->cat_name);
            /*$num++;*/
        }
        foreach($this->super_model->select_custom_where("item_subcat","subcat_id = '$subcat'") AS $sub){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', $sub->subcat_name);
            /*$num++;*/
        }
        $x = 1;
        if($from != 'null' && $to != 'null' && $cat != 'null' && $subcat != 'null'){ 
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id  FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id WHERE rh.saved='1' AND i.category_id = '$cat' AND i.subcat_id = '$subcat' AND rh.receive_date BETWEEN '$from' AND '$to'") AS $head){
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $head->item_id);
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $head->item_id);
                $totalqty=$this->inventory_balance($head->item_id);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $item);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $totalqty);
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":H".$num,'admin');
                $x++;
                $num++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$num.":K".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
        else if($from != 'null' && $to != 'null'){
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id  FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id WHERE rh.receive_date BETWEEN '$from' AND '$to' AND rh.saved='1'") AS $head){
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $head->item_id);
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $head->item_id);
                $totalqty=$this->inventory_balance($head->item_id);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $item);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $totalqty);
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":L".$num,'admin');
                $x++;
                $num++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":J".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$num.":L".$num);
                $objPHPExcel->getActiveSheet()->getStyle('K'.$num.":L".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            } 
        }else if($subcat != 'null' && $cat != 'null'){
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id  FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id WHERE rh.saved='1' AND i.category_id = '$cat' AND i.subcat_id = '$subcat'") AS $head){
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $head->item_id);
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $head->item_id);
                $totalqty=$this->inventory_balance($head->item_id);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $item);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $totalqty);
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":H".$num,'admin');
                $x++;
                $num++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$num.":K".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }else {
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id  FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id WHERE rh.saved='1'") AS $head){
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $head->item_id);
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $head->item_id);
                $totalqty=$this->inventory_balance($head->item_id);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $item);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $totalqty);
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":H".$num,'admin');
                $x++;
                $num++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->getStyle('H'.$num.":K".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }
         $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $num--;
        $objPHPExcel->getActiveSheet()->mergeCells('B10:D10');
        $objPHPExcel->getActiveSheet()->mergeCells('E10:J10');
        $objPHPExcel->getActiveSheet()->mergeCells('K10:L10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:D11');
        $objPHPExcel->getActiveSheet()->mergeCells('E11:J11');
        $objPHPExcel->getActiveSheet()->mergeCells('K11:L11');
        $objPHPExcel->getActiveSheet()->mergeCells('H1:L1');
        $objPHPExcel->getActiveSheet()->mergeCells('I2:K2');
        /*$objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":D".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('E'.$num.":G".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);*/
        $objPHPExcel->getActiveSheet()->getStyle('A10:L10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('K11:L11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        /*$objPHPExcel->getActiveSheet()->getStyle('H'.$num.":K".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        $objPHPExcel->getActiveSheet()->getStyle('A10:L'.$num)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:L3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H8:J8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C8:E8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('L1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('L2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('L3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        /*$objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);*/
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("H1")->getFont()->setBold(true)->setName('Arial Black')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle("I2")->getFont()->setBold(true)->setName('Arial Black')->setSize(10);
        $objPHPExcel->getActiveSheet()->getStyle('H1:L1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('I2:K2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        /*$objPHPExcel->getActiveSheet()->getStyle('I2')->getFont()->setBold(true);*/
        //$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Inventory Report.xlsx"');
        readfile($exportfilename);
        //echo "<script>window.location = 'import_items';</script>";
    }

    public function export_restock(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        $item=$this->uri->segment(7);

         $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " rh.restock_date BETWEEN '$from' AND '$to' AND";
        }

        if($cat!='null'){
            $sql.= " i.category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " i.subcat_id = '$subcat' AND";
        }

        if($item!='null'){
            $sql.= " i.item_id = '$item' AND";
        }

        $query=substr($sql,0,-3);

        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Restock Report.xlsx";

        $gdImage = imagecreatefrompng('assets/default/logo_cenpri.png');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(35);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "Period Covered:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "Warehouse");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Main Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', "Restock Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', "PR No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F10', "Item Part No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "UoM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M10', "Total Qty Restock");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O10', "Supplier");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R10', "Department");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U10', "Purpose");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X10', "End Use");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA10', "Reason");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PROGEN DIESEL TECH");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "TO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "FROM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "SUMMARY OF RESTOCK MATERIALS");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "Sub-Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8', "Item Name");
        $num=11;
       $itemname=$this->super_model->select_column_where("items", "item_name", "item_id", $item);
        $catname=$this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $subcatname=$this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        foreach($this->super_model->select_custom_where("receive_head","receive_date BETWEEN '$from' AND '$to'") AS $head){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', $from);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', $to);
        } 
       
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $catname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', $subcatname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8', $itemname);
        
        
        $x = 1;
       
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id, sr.supplier_id, rd.rdetails_id FROM restock_head rh INNER JOIN restock_details rd ON rh.rhead_id = rd.rhead_id INNER JOIN items i ON rd.item_id = i.item_id INNER JOIN supplier sr ON sr.supplier_id = rd.supplier_id WHERE rh.saved='1' AND ".$query."ORDER BY rh.restock_date DESC") AS $itm){
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $itm->supplier_id);
                $qty = $this->super_model->select_column_where('restock_details', 'quantity', 'rhead_id', $itm->rhead_id); 
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $itm->item_id);
                $pr = $this->super_model->select_column_where('restock_head', 'pr_no', 'rhead_id', $itm->rhead_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $itm->department_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $itm->purpose_id);
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $itm->enduse_id);  
                $restock_date = $this->super_model->select_column_where('restock_head', 'restock_date', 'rhead_id', $itm->rhead_id);
                $received = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $itm->received_by);
                $returned = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $itm->returned_by);
                $acknowledge = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $itm->acknowledge_by);
                $noted_by = $this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $itm->noted_by);
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }  
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $restock_date);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $pr);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $item); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $unit); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $qty); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$num, $supplier); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $department); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $purpose);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $enduse);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$num, $itm->reason);

                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":AC".$num,'admin');

                $num++;
                $x++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('D11:E11');
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F11:G11');
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H11:K11');
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('M11:N11');
                $objPHPExcel->getActiveSheet()->mergeCells('M'.$num.":N".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('O11:Q11');
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":T".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R11:T11');
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":T".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('U11:W11');
                $objPHPExcel->getActiveSheet()->mergeCells('U'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X11:Z11');
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Z".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('AA11:AC11');
                $objPHPExcel->getActiveSheet()->mergeCells('AA'.$num.":AC".$num);
                $objPHPExcel->getActiveSheet()->getStyle('L11:N11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":M".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            $a = $num+2;
            $b = $num+5;
            $c = $num+4;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Prepared By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$b, "Warehouse Personnel ");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$a, "Checked By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$b, "Warehouse Supervisor ");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$a, "Approved By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$b, "Plant Director/Plant Manager ");
            $objPHPExcel->getActiveSheet()->protectCells('A'.$a.":AC".$a,'admin');
            $objPHPExcel->getActiveSheet()->protectCells('A'.$c.":AC".$c,'admin');  
        
      
      
    
         $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $num--;
        /*$objPHPExcel->getActiveSheet()->mergeCells('H1:K1');*/
        $objPHPExcel->getActiveSheet()->mergeCells('N2:T2');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
        $objPHPExcel->getActiveSheet()->mergeCells('F10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('H10:K10');
        $objPHPExcel->getActiveSheet()->mergeCells('M10:N10');
        $objPHPExcel->getActiveSheet()->mergeCells('O10:Q10');
        $objPHPExcel->getActiveSheet()->mergeCells('R10:T10');
        $objPHPExcel->getActiveSheet()->mergeCells('U10:W10');
        $objPHPExcel->getActiveSheet()->mergeCells('X10:Z10');
        $objPHPExcel->getActiveSheet()->mergeCells('AA10:AC10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:C11');
    
        $objPHPExcel->getActiveSheet()->getStyle('A10:AC10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
        $objPHPExcel->getActiveSheet()->getStyle('A10:AC'.$num)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AC3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AC3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AC1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AC2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AC3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H8:J8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('M8:O8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C8:E8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AC1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AC2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AC3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
       /* $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);*/
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getFont()->setBold(true)->setName('Arial Black');
        $objPHPExcel->getActiveSheet()->getStyle('N2:T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
       /* $objPHPExcel->getActiveSheet()->getSecurity()->setLockWindows(true);
        $objPHPExcel->getActiveSheet()->getSecurity()->setLockStructure(true);*/
        /*$objPHPExcel->getActiveSheet()
            ->getStyle('A1:F1')
            ->getProtection()->setLocked(
                PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
            );*/
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Restock Report.xlsx"');
        readfile($exportfilename);
        //echo "<script>window.location = 'import_items';</script>";
    }

    public function export_rec(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        $item=$this->uri->segment(7);

        $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " rh.receive_date BETWEEN '$from' AND '$to' AND";
        }

        if($cat!='null'){
            $sql.= " i.category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " i.subcat_id = '$subcat' AND";
        }

        if($item!='null'){
            $sql.= " i.item_id = '$item' AND";
        }

        $query=substr($sql,0,-3);
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Received Report.xlsx";

        $gdImage = imagecreatefrompng('assets/default/logo_cenpri.png');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(35);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "Period Covered:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "Warehouse");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Main Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', "Received Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', "PR No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F10', "Item Part No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "Total Qty Received");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N10', "UoM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O10', "Supplier");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R10', "Department");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U10', "Purpose");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X10', "End Use");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PROGEN DIESEL TECH");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "TO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "FROM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "SUMMARY OF RECIEVED MATERIALS");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "Sub-Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8', "Item Name");
        $num=11;
        $itemname=$this->super_model->select_column_where("items", "item_name", "item_id", $item);
        $catname=$this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $subcatname=$this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        foreach($this->super_model->select_custom_where("receive_head","receive_date BETWEEN '$from' AND '$to'") AS $head){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', $from);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', $to);
        } 
       
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $catname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', $subcatname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8', $itemname);
        $x = 1;
        
     

            /*foreach($this->super_model->custom_query("SELECT rh.*,i.item_id, sr.supplier_id,dt.department_id,pr.purpose_id,e.enduse_id, ri.ri_id, rd.rd_id FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN receive_details rd ON rd.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id INNER JOIN supplier sr ON sr.supplier_id = ri.supplier_id INNER JOIN department dt ON dt.department_id = rd.department_id INNER JOIN purpose pr ON pr.purpose_id = rd.purpose_id INNER JOIN enduse e ON e.enduse_id = rd.enduse_id WHERE rh.saved='1' AND ri.rd_id = rd.rd_id AND ".$query."ORDER BY rh.receive_date DESC") AS $itm)*/
            foreach($this->super_model->custom_query("SELECT rh.*,i.item_id, sr.supplier_id,dt.department_id,pr.purpose_id,e.enduse_id, ri.ri_id, rd.rd_id FROM receive_head rh INNER JOIN receive_items ri ON rh.receive_id = ri.receive_id INNER JOIN receive_details rd ON rd.receive_id = ri.receive_id INNER JOIN items i ON ri.item_id = i.item_id INNER JOIN supplier sr ON sr.supplier_id = ri.supplier_id INNER JOIN department dt ON dt.department_id = rd.department_id INNER JOIN purpose pr ON pr.purpose_id = rd.purpose_id INNER JOIN enduse e ON e.enduse_id = rd.enduse_id WHERE rh.saved='1' AND ri.rd_id = rd.rd_id AND ".$query."ORDER BY rh.receive_date DESC") AS $itm) {
                $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $itm->supplier_id);
                $recqty = $this->super_model->select_column_where('receive_items', 'received_qty', 'ri_id', $itm->ri_id); 
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $itm->item_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $itm->department_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $itm->purpose_id);
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $itm->enduse_id);
                $recdate = $this->super_model->select_column_where('receive_head', 'receive_date', 'receive_id', $itm->receive_id); 
                $pr = $this->super_model->select_column_where('receive_details', 'pr_no', 'receive_id', $itm->receive_id);
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $recdate);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $pr);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $pn);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $item); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $recqty); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $unit); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$num, $supplier); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $department); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $purpose);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $enduse);

                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Z".$num,'admin');

                $num++;
                $x++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('D11:E11');
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F11:G11');
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H11:K11');
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('L11:M11');
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('O11:Q11');
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":T".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R11:T11');
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":T".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('U11:W11');
                $objPHPExcel->getActiveSheet()->mergeCells('U'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X11:Z11');
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Z".$num);
                $objPHPExcel->getActiveSheet()->getStyle('L11:N11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":N".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            $a = $num+2;
            $b = $num+5;
            $c = $num+4;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Prepared By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$b, "Warehouse Personnel ");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$a, "Checked By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$b, "Warehouse Supervisor ");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$a, "Approved By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$b, "Plant Director/Plant Manager ");
            $objPHPExcel->getActiveSheet()->protectCells('A'.$a.":AC".$a,'admin');
            $objPHPExcel->getActiveSheet()->protectCells('A'.$c.":AC".$c,'admin');
        
      
         $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $num--;
        /*$objPHPExcel->getActiveSheet()->mergeCells('H1:K1');*/
        $objPHPExcel->getActiveSheet()->mergeCells('N2:T2');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
        $objPHPExcel->getActiveSheet()->mergeCells('F10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('H10:K10');
        $objPHPExcel->getActiveSheet()->mergeCells('L10:M10');
        $objPHPExcel->getActiveSheet()->mergeCells('O10:Q10');
        $objPHPExcel->getActiveSheet()->mergeCells('R10:T10');
        $objPHPExcel->getActiveSheet()->mergeCells('U10:W10');
        $objPHPExcel->getActiveSheet()->mergeCells('X10:Z10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:C11');
        /*$objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('D11:E11');
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('F11:G11');
        $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('H11:I11');
        $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('J11:K11');
        $objPHPExcel->getActiveSheet()->mergeCells('J'.$num.":K".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('L11:M11');
        $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('N11:O11');
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);*/
        $objPHPExcel->getActiveSheet()->getStyle('A10:Z10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
       /* $objPHPExcel->getActiveSheet()->getStyle('F11:G11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        /*$objPHPExcel->getActiveSheet()->getStyle('F'.$num.":G11".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        $objPHPExcel->getActiveSheet()->getStyle('A10:Z'.$num)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Z1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:Z2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Z3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H8:J8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
         $objPHPExcel->getActiveSheet()->getStyle('M8:O8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C8:E8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Z1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Z2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Z3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
       /* $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);*/
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getFont()->setBold(true)->setName('Arial Black');
        $objPHPExcel->getActiveSheet()->getStyle('N2:T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        //$objPHPExcel->getActiveSheet()->getStyle('I1')->getFont()->setBold(true);
       /* $objPHPExcel->getActiveSheet()->getSecurity()->setLockWindows(true);
        $objPHPExcel->getActiveSheet()->getSecurity()->setLockStructure(true);*/
        /*$objPHPExcel->getActiveSheet()
            ->getStyle('A1:F1')
            ->getProtection()->setLocked(
                PHPExcel_Style_Protection::PROTECTION_UNPROTECTED
            );*/
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Received Report.xlsx"');
        readfile($exportfilename);
        //echo "<script>window.location = 'import_items';</script>";
    }

    public function export_issue(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $cat=$this->uri->segment(5);
        $subcat=$this->uri->segment(6);
        $item=$this->uri->segment(7);
        $sql='';
        if($from!='null' && $to!='null'){
           $sql.= " ih.issue_date BETWEEN '$from' AND '$to' AND";
        }

        if($cat!='null'){
            $sql.= " i.category_id = '$cat' AND";
        }

        if($subcat!='null'){
            $sql.= " i.subcat_id = '$subcat' AND";
        }

        if($item!='null'){
            $sql.= " i.item_id = '$item' AND";
        }
        $query=substr($sql,0,-3);
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Issued Report.xlsx";


        $gdImage = imagecreatefrompng('assets/default/logo_cenpri.png');
        // Add a drawing to the worksheetecho date('H:i:s') . " Add a drawing to the worksheet\n";
        $objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
        $objDrawing->setName('Sample image');
        $objDrawing->setDescription('Sample image');
        $objDrawing->setImageResource($gdImage);
        $objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG);
        $objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);
        $objDrawing->setHeight(35);
        $objDrawing->setCoordinates('A2');
        $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save(str_replace('.php', '.xlsx', __FILE__));
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', "Period Covered:");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "Warehouse");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A8', "Main Category");
       
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PROGEN DIESEL TECH");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "TO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "FROM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O2', "SUMMARY OF ISSUED MATERIALS");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F8', "Sub-Category");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L8', "Item Name");
        $num=11;

        $itemname=$this->super_model->select_column_where("items", "item_name", "item_id", $item);
        $catname=$this->super_model->select_column_where("item_categories", "cat_name", "cat_id", $cat);
        $subcatname=$this->super_model->select_column_where("item_subcat", "subcat_name", "subcat_id", $subcat);
        foreach($this->super_model->select_custom_where("receive_head","receive_date BETWEEN '$from' AND '$to'") AS $head){
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5', $from);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', $to);
        } 
       
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C8', $catname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H8', $subcatname);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M8', $itemname);
        $x = 1;

         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A10', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B10', "Issue Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D10', "PR No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F10', "Item Part No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H10', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L10', "UoM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M10', "Total Qty Received");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O10', "Supplier");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R10', "Department");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U10', "Purpose");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X10', "End Use");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA10', "Frequency");
        
            foreach($this->super_model->custom_query("SELECT ih.*,i.item_id, sr.supplier_id,dt.department_id,pr.purpose_id,e.enduse_id, id.is_id FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id INNER JOIN items i ON id.item_id = i.item_id INNER JOIN supplier sr ON sr.supplier_id = id.supplier_id INNER JOIN department dt ON dt.department_id = ih.department_id INNER JOIN purpose pr ON pr.purpose_id = ih.purpose_id INNER JOIN enduse e ON e.enduse_id = ih.enduse_id WHERE ih.saved='1' AND ih.issuance_id = id.issuance_id AND ".$query. "ORDER BY ih.issue_date DESC") AS $itm){
                      $supplier = $this->super_model->select_column_where('supplier', 'supplier_name', 'supplier_id', $itm->supplier_id);
                $issqty = $this->super_model->select_column_where('issuance_details', 'quantity', 'is_id', $itm->is_id); 
                $pn = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $itm->item_id);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $itm->item_id);
                $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $itm->department_id);
                $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $itm->purpose_id);
                $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $itm->enduse_id);
                 $pr = $this->super_model->select_column_where('request_head', 'pr_no', 'mreqf_no', $itm->mreqf_no);
                foreach($this->super_model->select_custom_where("items", "item_id = '$itm->item_id'") AS $itema){
                    $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
                }
                $issdate = $this->super_model->select_column_where('issuance_head', 'issue_date', 'issuance_id', $itm->issuance_id);
                         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $issdate);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $pr);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $pn);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $item); 
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $unit); 
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $issqty); 
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$num, $supplier); 
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $department); 
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $purpose);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $enduse);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AA'.$num, '');
                        $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                        $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":AA".$num,'admin');
                $num++;
                $x++;
               $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('D11:E11');
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F11:G11');
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H11:K11');
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('M11:N11');
                $objPHPExcel->getActiveSheet()->mergeCells('M'.$num.":N".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('O11:Q11');
                $objPHPExcel->getActiveSheet()->mergeCells('O'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R11:T11');
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":T".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('U11:W11');
                $objPHPExcel->getActiveSheet()->mergeCells('U'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X11:Z11');
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Z".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('AA11:AB11');
                $objPHPExcel->getActiveSheet()->mergeCells('AA'.$num.":AB".$num);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":N".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
            $a = $num+2;
            $b = $num+5;
            $c = $num+4;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$a, "Prepared By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$b, "Warehouse Personnel ");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$a, "Checked By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$b, "Warehouse Supervisor ");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$a, "Approved By: ");
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$b, "Plant Director/Plant Manager ");
            $objPHPExcel->getActiveSheet()->protectCells('A'.$a.":AC".$a,'admin');
            $objPHPExcel->getActiveSheet()->protectCells('A'.$c.":AC".$c,'admin');
        
         $styleArray = array(
          'borders' => array(
            'allborders' => array(
              'style' => PHPExcel_Style_Border::BORDER_THIN
            )
          )
        );
        $num--;
        $objPHPExcel->getActiveSheet()->mergeCells('O2:T2');
        $objPHPExcel->getActiveSheet()->mergeCells('B10:C10');
        $objPHPExcel->getActiveSheet()->mergeCells('D10:E10');
        $objPHPExcel->getActiveSheet()->mergeCells('F10:G10');
        $objPHPExcel->getActiveSheet()->mergeCells('H10:K10');
        $objPHPExcel->getActiveSheet()->mergeCells('M10:N10');
        $objPHPExcel->getActiveSheet()->mergeCells('O10:Q10');
        $objPHPExcel->getActiveSheet()->mergeCells('R10:T10');
        $objPHPExcel->getActiveSheet()->mergeCells('U10:W10');
        $objPHPExcel->getActiveSheet()->mergeCells('X10:Z10');
        $objPHPExcel->getActiveSheet()->mergeCells('AA10:AB10');
        $objPHPExcel->getActiveSheet()->mergeCells('B11:C11');
        /*$objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('D11:E11');
        $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('F11:G11');
        $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('H11:I11');
        $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('J11:K11');
        $objPHPExcel->getActiveSheet()->mergeCells('J'.$num.":K".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('L11:M11');
        $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('N11:O11');
        $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);
        $objPHPExcel->getActiveSheet()->mergeCells('P11:Q11');
        $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);*/
        $objPHPExcel->getActiveSheet()->getStyle('A10:AA10')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('L11:N11')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
         $objPHPExcel->getActiveSheet()->getStyle('A10:AB'.$num)->applyFromArray($styleArray);
        /*$objPHPExcel->getActiveSheet()->getStyle('F'.$num.":G11".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);*/
        $objPHPExcel->getActiveSheet()->getStyle('A10:AB'.$num)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AB3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AB1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AB2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AB3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H8:J8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('M8:O8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C8:E8')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AB1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AB2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AB3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('O2:T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
       /* $objPHPExcel->getActiveSheet()->getStyle('J2')->getFont()->setBold(true);*/
        $objPHPExcel->getActiveSheet()->getStyle("O2")->getFont()->setBold(true)->setName('Arial Black');
        //$objPHPExcel->getActiveSheet()->getStyle('O1')->getFont()->setBold(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Issued Report.xlsx"');
        readfile($exportfilename);
        //echo "<script>window.location = 'import_items';</script>";
    }

    public function export_aging(){
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Aging.xlsx";
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Brand");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', "Supplier");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L1', "Catalog No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N1', "Quantity");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P1', "Unit Cost");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R1', "1-60");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T1', "61-120");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V1', "121-180");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X1', "181-360");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z1', "360+");
        $num=2;
        /*foreach($this->super_model->select_all('receive_head') as $head){
            foreach ($this->super_model->custom_query("SELECT DISTINCT item_id,supplier_id,brand_id,catalog_no,received_qty,receive_id FROM receive_items WHERE receive_id = '$head->receive_id' ORDER BY receive_id DESC") as $age) {
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $age->item_id);
                $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $age->supplier_id);
                $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $age->brand_id);
                $receive_date = $head->receive_date;
                $cat_no = $age->catalog_no;
                $qty = $age->received_qty;*/
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
                /*$qty = $this->super_model->select_sum_where("receive_items", "received_qty", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");*/
                $unit_x = $qty * $unit_cost;
                $receive_date = $this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $q->receive_id);
                $now = date("Y-m-d");
                $diff = $this->dateDifference($now,$receive_date);
                $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $i['supplier']);
                $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $i['item']);
                $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $i['brand']);
                $cat_no = $i['catalog_no'];
               // echo $item . " - " . $qty . " - " . $unit_x .'<br>';
                /*$unx = number_format($unit_x,2);*/

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $item);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $brand);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $supplier);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('L'.$num, $cat_no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N'.$num, $qty);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $unit_cost);
                $objPHPExcel->getActiveSheet()->getStyle('P'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                if($diff >= 1 && $diff<=60){
                    if($qty!=0){
                   $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $unit_x);
                   $objPHPExcel->getActiveSheet()->getStyle('R'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }
                }else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, '');
                }

                if($diff >= 61 && $diff<=120){
                      if($qty!=0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, $unit_x);
                    $objPHPExcel->getActiveSheet()->getStyle('T'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }
                }else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('T'.$num, '');
                }

                if($diff >= 121 && $diff <=180){
                    if($qty!=0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, $unit_x);
                    $objPHPExcel->getActiveSheet()->getStyle('V'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }
                }else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('V'.$num, '');
                }

                if($diff >= 181 && $diff<=360){
                      if($qty!=0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, $unit_x);
                    $objPHPExcel->getActiveSheet()->getStyle('X'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }
                }else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('X'.$num, ''); 
                }

                if($diff>360){
                    if($qty!=0){
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, $unit_x);
                    $objPHPExcel->getActiveSheet()->getStyle('Z'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    }
                }else {
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Z'.$num, '');
                }

                $objPHPExcel->getActiveSheet()->mergeCells('A'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":K".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('L'.$num.":M".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('N'.$num.":O".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":S".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('T'.$num.":U".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('V'.$num.":W".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('X'.$num.":Y".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('Z'.$num.":AA".$num);
                $objPHPExcel->getActiveSheet()->getStyle('N'.$num.":AA".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":AA".$num,'admin');
                $num++;
                 $a++;
            }
           
        }
        $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->mergeCells('F1:G1');
        $objPHPExcel->getActiveSheet()->mergeCells('H1:K1');
        $objPHPExcel->getActiveSheet()->mergeCells('L1:M1');
        $objPHPExcel->getActiveSheet()->mergeCells('N1:O1');
        $objPHPExcel->getActiveSheet()->mergeCells('P1:Q1');
        $objPHPExcel->getActiveSheet()->mergeCells('R1:S1');
        $objPHPExcel->getActiveSheet()->mergeCells('T1:U1');
        $objPHPExcel->getActiveSheet()->mergeCells('V1:W1');
        $objPHPExcel->getActiveSheet()->mergeCells('X1:Y1');
        $objPHPExcel->getActiveSheet()->mergeCells('Z1:AA1');
        $objPHPExcel->getActiveSheet()->getStyle('N1:AA1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getFont()->setBold(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Aging.xlsx"');
        readfile($exportfilename);
    }

    public function export_aging_range(){
        $days=$this->uri->segment(3);
        $data['days']=$days;
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Aging Range.xlsx";
       
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B1', "Brand");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "Supplier");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D1', "Catalog No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E1', "Receive Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F1', "Quantity");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G1', "Unit Cost");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H1', $days . " Days");
        $num=2;
    
            // echo $days;
            $startdate = date('Y-m-d',strtotime("-".$days." days"));
            $now=date('Y-m-d');
            //echo $startdate . " " . $now."<br>";
           // foreach($this->super_model->custom_query("SELECT receive_id,receive_date FROM receive_head WHERE receive_date BETWEEN '$startdate' AND '$now'") as $head){

                    foreach($this->super_model->custom_query("SELECT DISTINCT item_id, supplier_id, brand_id, catalog_no FROM receive_items") as $items){
                        $item[] = array(
                            'item'=>$items->item_id,
                            'supplier'=>$items->supplier_id,
                            'brand'=>$items->brand_id,
                            'catalog_no'=>$items->catalog_no
                           
                        );
                    }
            //  }      
        
                    foreach($item AS $i){
                          $a=1;

                        foreach($this->super_model->custom_query("SELECT DISTINCT receive_id FROM receive_items WHERE item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'") AS $q){

                            $unit_cost = $this->super_model->select_column_custom_where("receive_items", "item_cost", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");
                           /* $qty = $this->super_model->select_sum_where("receive_items", "received_qty", "item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]' AND receive_id = '$q->receive_id'");*/

                           $rec_qty = $this->super_model->custom_query_single("received_qty","SELECT ri.received_qty FROM receive_items ri INNER JOIN receive_details rd ON ri.receive_id = rd.receive_id WHERE ri.item_id = '$i[item]' AND ri.supplier_id = '$i[supplier]' AND ri.brand_id = '$i[brand]' AND ri.catalog_no = '$i[catalog_no]' GROUP BY rd.receive_id");
                  
                    $restock_qty = $this->qty_restocked($i['item'],$i['supplier'],$i['brand'],$i['catalog_no']);
                    $iss_qty =  $this->super_model->custom_query_single("quantity","SELECT quantity FROM issuance_details WHERE item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'");

                    $count_issue = $this->super_model->count_custom_where("issuance_details","item_id = '$i[item]' AND supplier_id = '$i[supplier]' AND brand_id = '$i[brand]' AND catalog_no = '$i[catalog_no]'");

                      if($a<=$count_issue){
                        if($rec_qty == $iss_qty){
                        
                            $issue_qty  = $iss_qty;

                        } else {
                            $new_iss = $rec_qty - $iss_qty;
                             $issue_qty  = $new_iss;
                          
                        }
                    } else {

                            $new_iss = $rec_qty - $iss_qty;
                            $issue_qty  = $new_iss;
                        

                    }

                            $qty = ($rec_qty+$restock_qty) -  $issue_qty;
                            $unit_x = $qty * $unit_cost;
                    $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $i['item']);

                          
                           

                            $receive_date = $this->super_model->select_column_where("receive_head", "receive_date", "receive_id", $q->receive_id);
                            $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $i['supplier']);
                            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $i['item']);
                            $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $i['brand']);
                            $cat_no = $i['catalog_no'];
                            $diff=$this->dateDiff($receive_date , $now);
                            //echo $diff." - " .$days."<br>";
                            

                            if($days!='361'){
                                if($days!='360'){
                                    $start_diff=$days-59;
                                } else if($days=='360'){
                                     $start_diff=$days-179;
                                }
                            if($diff>=$start_diff && $diff<=$days){
                                if($qty!=0){
                        
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $item);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $brand);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $supplier);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $cat_no);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $receive_date);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $qty);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $unit_cost);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $unit_x);

                            $objPHPExcel->getActiveSheet()->getStyle('E'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                          
                            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                            $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":S".$num,'admin');
                            $num++;
                                }
                        
                             }
                            } else {
                                if($diff>=$days){
                                if($qty!=0){
                        
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $item);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $brand);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$num, $supplier);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $cat_no);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$num, $receive_date);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $qty);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G'.$num, $unit_cost);
                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $unit_x);

                            $objPHPExcel->getActiveSheet()->getStyle('E'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$num)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                          
                            $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                            $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":S".$num,'admin');
                            $num++;
                                }
                        
                             }

                            }
                        $a++;
            }
        }
      
        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Aging Range.xlsx"');
        readfile($exportfilename);
    }

    public function export_all_rec(){
        $days=$this->uri->segment(3);
        $data['days']=$days;
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="All Receive.xlsx";
        $objPHPExcel = new PHPExcel();
        $col1 = 1;
        $row1 = 1;
        $startdate = "2018-09-12";
        $now="2018-09-20";
        $styleArray1 = array(
            'borders' => array(
                'top' => array('style' => PHPExcel_Style_Border::BORDER_THICK),
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
            )
        );
        $styleArray2 = array(
            'borders' => array(
                'left' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
            )
        );
        $styleArray3 = array(
            'borders' => array(
                'right' => array('style' => PHPExcel_Style_Border::BORDER_THICK)
            )
        );
        foreach($this->super_model->custom_query("SELECT * FROM receive_head WHERE receive_date  BETWEEN '$startdate' AND '$now' AND saved = '1'") as $head){ 
            /*$objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK); */
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Date: ".$head->receive_date)->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "PO No.: ".$head->po_no)->getColumnDimension('B')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "DR No.: ".$head->dr_no)->getColumnDimension('A')->setWidth(40);
            if($head->pcf == "1"){
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "PCF: Yes")->getColumnDimension('B')->setWidth(30);
            }else {
                $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "PCF: ")->getColumnDimension('B')->setWidth(30);
            }
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "SI No.: ".$head->si_no)->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, " ")->getColumnDimension('A')->setWidth(40);
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, " ")->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;

            foreach($this->super_model->custom_query("SELECT * FROM receive_details WHERE receive_id = '$head->receive_id'") as $det){
            /*$num1++;*/
            $purpose = $this->super_model->select_column_where('purpose', 'purpose_desc', 'purpose_id', $det->purpose_id);
            $enduse = $this->super_model->select_column_where('enduse', 'enduse_name', 'enduse_id', $det->enduse_id);     
            $department = $this->super_model->select_column_where('department', 'department_name', 'department_id', $det->department_id);
          /*  $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row1, $col1, " ");
            $col1++;
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row, $col, " ");
            $col++;*/
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "PR/JO#: ".$det->pr_no);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray1);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Department: ".$department);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "End-Use: ".$enduse);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Purpose:".$purpose);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++; 
            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, " ");
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;

            $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, "Item No")->getColumnDimension('A')->setWidth(40); 
            $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, "UoM")->getColumnDimension('B')->setWidth(30); 
            $objPHPExcel->getActiveSheet()->setCellValue('C'.$col1, "Part No.")->getColumnDimension('C')->setWidth(20); 
            $objPHPExcel->getActiveSheet()->setCellValue('D'.$col1, "Item Description")->getColumnDimension('D')->setWidth(80); 
            $objPHPExcel->getActiveSheet()->setCellValue('E'.$col1, "Expected Qty.")->getColumnDimension('E')->setWidth(15); 
            $objPHPExcel->getActiveSheet()->setCellValue('F'.$col1, "Receive Qty.")->getColumnDimension('F')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('G'.$col1, "Supplier")->getColumnDimension('G')->setWidth(30); 
            $objPHPExcel->getActiveSheet()->setCellValue('H'.$col1, "Catalog No.")->getColumnDimension('H')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('I'.$col1, "Brand")->getColumnDimension('I')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('J'.$col1, "Serial No.")->getColumnDimension('J')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('K'.$col1, "Unit Cost")->getColumnDimension('K')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('L'.$col1, "Total Cost")->getColumnDimension('L')->setWidth(12); 
            $objPHPExcel->getActiveSheet()->setCellValue('M'.$col1, "Inspected By")->getColumnDimension('M')->setWidth(20); 
            $objPHPExcel->getActiveSheet()->setCellValue('N'.$col1, "Remarks")->getColumnDimension('N')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getFont()->setBold(true);
            $styleArray = array(
              'borders' => array(
                    'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                    )
                )
            );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
            $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
            $col1++;
            $x = 1;
            foreach($this->super_model->custom_query("SELECT * FROM receive_items WHERE rd_id = '$det->rd_id'") AS $q){
            
            $inspected_by = $this->super_model->select_column_where("employees", "employee_name", "employee_id", $q->inspected_by);
            $serial = $this->super_model->select_column_where("serial_number", "serial_no", "serial_id", $q->serial_id);
            $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $q->supplier_id);
            $item = $this->super_model->select_column_where('items', 'item_name', 'item_id', $q->item_id);
            $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $q->brand_id);
            $cat_no = $q->catalog_no;
            $cost = $q->item_cost;
            $rec_qty = $q->received_qty;
            $expected_qty = $q->expected_qty;
            $remarks = $q->remarks;
            foreach($this->super_model->select_custom_where("items", "item_id = '$q->item_id'") AS $itema){
                $unit = $this->super_model->select_column_where('uom', 'unit_name', 'unit_id', $itema->unit_id);
            }
            $total = $rec_qty * $cost;
            $part = $this->super_model->select_column_where('items', 'original_pn', 'item_id', $q->item_id);
                if($q->rd_id == $det->rd_id){ 
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN); 
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$col1, $x)->getColumnDimension('A')->setWidth(40); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$col1, $unit)->getColumnDimension('B')->setWidth(30); 
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$col1, $part)->getColumnDimension('C')->setWidth(20); 
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$col1, $item)->getColumnDimension('D')->setWidth(80); 
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$col1, $expected_qty)->getColumnDimension('E')->setWidth(15); 
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$col1, $rec_qty)->getColumnDimension('F')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$col1, $supplier)->getColumnDimension('G')->setWidth(30); 
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$col1, $cat_no)->getColumnDimension('H')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$col1, $brand)->getColumnDimension('I')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$col1, $serial)->getColumnDimension('J')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('K'.$col1, $cost)->getColumnDimension('K')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('L'.$col1, $total)->getColumnDimension('L')->setWidth(12); 
                    $objPHPExcel->getActiveSheet()->setCellValue('M'.$col1, $inspected_by)->getColumnDimension('M')->setWidth(20); 
                    $objPHPExcel->getActiveSheet()->setCellValue('N'.$col1, $remarks)->getColumnDimension('N')->setWidth(30);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":C".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$col1.":F".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$col1.":M".$col1)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                    $objPHPExcel->getActiveSheet()->protectCells('A'.$col1.":N".$col1,'admin');
                    $objPHPExcel->getActiveSheet()->getStyle('E'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('F'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('K'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('L'.$col1)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $styleArray = array(
                      'borders' => array(
                            'allborders' => array(
                              'style' => PHPExcel_Style_Border::BORDER_THIN
                            )
                        )
                    );
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray2);
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$col1.":N".$col1)->applyFromArray($styleArray3);
                    $x++;      
                }   
                $col1++;
            }
            $col1++;
        }  
    }

  /*  $col=1;
    $row++;
    $col1=1;
    $row1++;*/
        /*$objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
        $objPHPExcel->getActiveSheet()->mergeCells('F1:G1');
        $objPHPExcel->getActiveSheet()->mergeCells('H1:K1');
        $objPHPExcel->getActiveSheet()->mergeCells('L1:M1');
        $objPHPExcel->getActiveSheet()->mergeCells('N1:O1');
        $objPHPExcel->getActiveSheet()->mergeCells('P1:Q1');
        $objPHPExcel->getActiveSheet()->mergeCells('R1:S1');
        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);*/

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="All Receive.xlsx"');
        readfile ($exportfilename);
    }
}
?>
