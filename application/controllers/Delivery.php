<?php
defined('BASEPATH') OR exit('No direct script access allowed');

ini_set('max_execution_time', 0);
ini_set('memory_limit', '2048M');

class Delivery extends CI_Controller {

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
        $this->dropdown['pr_list']=$this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE saved='1' GROUP BY pr_no");
        $this->dropdown['buyer']=$this->super_model->select_all_order_by("buyer","buyer_name","ASC");
      //  $this->dropdown['prno'] = $this->super_model->select_join_where_order("receive_details","receive_head", "saved='1'","receive_id", "receive_date", "DESC");
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
        $rows=$this->super_model->count_custom_where("items","item_name LIKE '%$item%'");
        //count_join_where("items",", $where,$group_id);
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("items", "item_name LIKE '%$item%'") AS $itm){ 
                    $name = str_replace('"', '', $itm->item_name);
                    //echo $name;
                    $rec_qty = $this->inventory_balance($itm->item_id);
                    ?>
                    <li onClick="selectItem('<?php echo $itm->item_id; ?>','<?php echo $name; ?>','<?php echo $itm->unit_id; ?>','<?php echo $itm->original_pn;?>','<?php echo $rec_qty;?>')"><strong><?php echo $itm->original_pn;?> - </strong> <?php echo $name; ?></li> 
                <?php 
            }
             echo "<ul>";
        }
        
    }

    public function delivery_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $rows=$this->super_model->count_rows("delivery_head");
        if($rows!=0){
            foreach($this->super_model->select_all_order_by("delivery_head","date","ASC") AS $h){
                $buyer_name=$this->super_model->select_column_where("buyer","buyer_name","buyer_id",$h->buyer_id);
                $address=$this->super_model->select_column_where("buyer","address","buyer_id",$h->buyer_id);
                $data['heads'][]=array(
                    "delivery_id"=>$h->delivery_id,
                    "buyer_name"=>$buyer_name,
                    "address"=>$address,
                    "date"=>$h->date,
                    "pr_no"=>$h->pr_no,
                    "sales_pr"=>$h->sales_pr,
                    "dr_no"=>$h->dr_no,
                    "shipped_via"=>$h->shipped_via,
                    "waybill_no"=>$h->waybill_no,
                );
            }
        }else{
            $data['heads']=array();
        }
        $this->load->view('delivery/delivery_list',$data);
        $this->load->view('template/footer');
    }

    public function edit_endpurp(){  
        $this->load->view('template/header');
        $data['id']=$this->input->post('id');
        $id=$this->input->post('id');
        foreach($this->super_model->select_row_where('delivery_head', 'delivery_id', $id) AS $i){
            $data['delivery_list'][]=array(
                'sales_pr'=>$i->sales_pr,
                'date'=>$i->date,
            );
        }
        $this->load->view('delivery/edit_endpurp',$data);
    }

    public function update_purend(){
        $data = array(
            'sales_pr'=>$this->input->post('sales_pr'),
            'date'=>$this->input->post('date'),
        );
        $delivery_id = $this->input->post('delivery_id');
        if($this->super_model->update_where('delivery_head', $data, 'delivery_id', $delivery_id)){
            echo "<script>alert('Successfully Updated!'); 
                window.location ='".base_url()."index.php/delivery/delivery_list'; </script>";
        }
    }

    public function delivery_receipt(){        
        $this->load->view('template/header');
        $this->load->view('template/print_head');
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        foreach($this->super_model->select_row_where('delivery_head', 'delivery_id', $id) AS $us){
            $data['username'][] = array( 
                'positionrel'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->released_by),
                'positionver'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->verified_by),
                'positionnote'=>$this->super_model->select_column_where('employees', 'position', 'employee_id', $us->noted_by),
            );
        }

        $data['position']=$this->super_model->custom_query("SELECT * FROM employees GROUP BY position ORDER BY position ASC ");
        foreach($this->super_model->select_row_where("delivery_head","delivery_id",$id) AS $h){
            $buyer_name=$this->super_model->select_column_where("buyer","buyer_name","buyer_id",$h->buyer_id);
            $address=$this->super_model->select_column_where("buyer","address","buyer_id",$h->buyer_id);
            $contact_person=$this->super_model->select_column_where("buyer","contact_person","buyer_id",$h->buyer_id);
            $contact_no=$this->super_model->select_column_where("buyer","contact_no","buyer_id",$h->buyer_id);
            $verified_by=$this->super_model->select_column_where("employees","employee_name","employee_id",$h->verified_by);
            $prepared_by=$this->super_model->select_column_where("users","fullname","user_id",$h->prepared_by);
            $released_by=$this->super_model->select_column_where("employees","employee_name","employee_id",$h->released_by);
            $noted_by=$this->super_model->select_column_where("employees","employee_name","employee_id",$h->noted_by);
            $data['heads'][]=array(
                "delivery_id"=>$h->delivery_id,
                "buyer_name"=>$buyer_name,
                "address"=>$address,
                "contact_person"=>$contact_person,
                "contact_no"=>$contact_no,
                "date"=>$h->date,
                "po_date"=>$h->po_date,
                "sales_pr"=>$h->sales_pr,
                "pr_no"=>$h->pr_no,
                "dr_no"=>$h->dr_no,
                "shipped_via"=>$h->shipped_via,
                "waybill_no"=>$h->waybill_no,
                "verified_by"=>$verified_by,
                "prepared_by"=>$prepared_by,
                "released_by"=>$released_by,
                "noted_by"=>$noted_by,
                "received_by"=>$h->received_by,
                "user_id"=>$h->prepared_by,
                "verified_id"=>$h->verified_by,
                "noted_id"=>$h->noted_by,
                "released_id"=>$h->released_by,
                "remarks"=>$h->remarks,
                "vat"=>$h->vat,
            );
            foreach($this->super_model->select_row_where("delivery_details","delivery_id",$h->delivery_id) AS $d){
                $item_name=$this->super_model->select_column_where("items","item_name","item_id",$d->item_id);
                $original_pn=$this->super_model->select_column_where("items","original_pn","item_id",$d->item_id);
                $unit=$this->super_model->select_column_where("uom","unit_name","unit_id",$d->unit_id);
                $total_price = ($d->selling_price * $d->qty)-$d->discount;
                $data['details'][]=array(
                    "item_name"=>$item_name,
                    "pn_no"=>$original_pn,
                    "unit"=>$unit,
                    "qty"=>$d->qty,
                    "serial_no"=>$d->serial_no,
                    "selling_price"=>$d->selling_price,
                    "discount"=>$d->discount,
                    "shipping_fee"=>$d->shipping_fee,
                    "total_price"=>$total_price,
                );
            }
        }
        foreach($this->super_model->select_row_where("signatories", "reviewed", "1") AS $sign){
            $data['reviewed_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                'empid'=>$sign->employee_id
            );
        }

        foreach($this->super_model->select_row_where("signatories", "noted", "1") AS $sign){
            $data['noted_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                'empid'=>$sign->employee_id
            );
        }

        foreach($this->super_model->select_row_where("signatories", "released", "1") AS $sign){
            $data['released_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $sign->employee_id),
                'empid'=>$sign->employee_id
            );
        }
        $this->load->view('delivery/delivery_receipt',$data);
    }

    public function insert_delivery(){
        $location=LOCATION;
        $year=date("Y");
        $date=$this->input->post('date');
        $pr_no=$this->input->post('pr_no');
        $buyer=$this->input->post('buyer');
        $po_date=$this->input->post('po_date');
        $vat=$this->input->post('vat');
        $sales_pr=$this->input->post('sales_pr');
        $rows=$this->super_model->count_rows("delivery_head");
        if($rows==0){
            $dr_no = $location."-0001";
        } else {
            $dr=$this->super_model->get_max("delivery_head", "dr_no");
            $dr_nos = explode('-',$dr);
            $series = $dr_nos[2]+1;
            if(strlen($series)==1){
                $dr_no = $location."-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $dr_no = $location."-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $dr_no = $location."-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $dr_no = $location."-".$year."-".$series;
            }
        }
        $head_rows = $this->super_model->count_rows("delivery_head");
        if($head_rows==0){
            $delivery_id=1;
        } else {
            $maxid=$this->super_model->get_max("delivery_head", "delivery_id");
            $delivery_id=$maxid+1;
        }
        $data = array(
            'delivery_id'=>$delivery_id,
            'date'=>$date,
            'po_date'=>$po_date,
            'dr_no'=>$dr_no,
            'pr_no'=>$pr_no,
            'buyer_id'=>$buyer,
            'vat'=>$vat,
            'sales_pr'=>$sales_pr,
            'created_date'=>date('Y-m-d h:i:s'),
        );
        if($this->super_model->insert_into("delivery_head", $data)){
            echo "<script>alert('Successfully Added!'); 
                window.location ='".base_url()."index.php/delivery/add_delivery/$delivery_id'; </script>";
        }
    }

    public function gatepass(){
        $this->load->view('template/header');
        $this->load->view('template/print_head'); 
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $year=date('Y-m');
        $gp= "MGPDR-".$year;
        $gpdetails=explode("-", $gp);
        $gp_prefix1=$gpdetails[0];
        $gp_prefix2=$gpdetails[1];
        $gp_prefix3=$gpdetails[2];
        $gp_prefix=$gp_prefix1."-".$gp_prefix2."-".$gp_prefix3;
        $rows=$this->super_model->count_custom_where("gp_series","gp_prefix='$gp_prefix'");
        if($rows==0){
            $gpno = "MGPDR-".$year."-0001";
        } else {
            $maxgpno=$this->super_model->get_max_where("gp_series", "series","gp_prefix='$gp_prefix'");
            $series=$maxgpno+1;
            //$gateno = explode('-',$maxgpno);
            //$series = $gateno[3]+1;
            if(strlen($series)==1){
                $gpno = "MGPDR-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $gpno = "MGPDR-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $gpno = "MGPDR-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $gpno = "MGPDR-".$year."-".$series;
            }
        }
        foreach($this->super_model->select_row_where("delivery_head","delivery_id",$id) AS $h){
            $buyer_name=$this->super_model->select_column_where("buyer","buyer_name","buyer_id",$h->buyer_id);
            $address=$this->super_model->select_column_where("buyer","address","buyer_id",$h->buyer_id);
            $contact_person=$this->super_model->select_column_where("buyer","contact_person","buyer_id",$h->buyer_id);
            $contact_no=$this->super_model->select_column_where("buyer","contact_no","buyer_id",$h->buyer_id);
            $prepared_by=$this->super_model->select_column_where("users","fullname","user_id",$h->prepared_by);
            if($h->gp_no!=''){
                $gp_no=$h->gp_no;
            }else {
                $gp_no=$gpno;
            }
            $data['heads'][]=array(
                "delivery_id"=>$h->delivery_id,
                "buyer_name"=>$buyer_name,
                "address"=>$address,
                "contact_person"=>$contact_person,
                "contact_no"=>$contact_no,
                "date"=>$h->date,
                "po_date"=>$h->po_date,
                "pr_no"=>$h->pr_no,
                "dr_no"=>$h->dr_no,
                "gp_no"=>$gp_no,
                "saved"=>$h->saved,
                "remarks"=>$h->remarks,
                "shipped_via"=>$h->shipped_via,
                "waybill_no"=>$h->waybill_no,
                "gp_recommending"=>$h->gp_recommending,
                "gp_inspected"=>$h->gp_inspected,
                "gp_approved"=>$h->gp_approved,
                "gp_prepared"=>$prepared_by,
                "prepared"=>$h->prepared_by,
                "gp_noted"=>$h->gp_noted,
                "gp_requested"=>$h->gp_requested,
            );
            foreach($this->super_model->select_row_where("delivery_details","delivery_id",$h->delivery_id) AS $d){
                $item_name=$this->super_model->select_column_where("items","item_name","item_id",$d->item_id);
                $original_pn=$this->super_model->select_column_where("items","original_pn","item_id",$d->item_id);
                $unit=$this->super_model->select_column_where("uom","unit_name","unit_id",$d->unit_id);
                $total_price = ($d->selling_price * $d->qty)-$d->discount;
                $data['details'][]=array(
                    "item_name"=>$item_name,
                    "pn_no"=>$original_pn,
                    "unit"=>$unit,
                    "qty"=>$d->qty,
                    "selling_price"=>$d->selling_price,
                    "discount"=>$d->discount,
                    "shipping_fee"=>$d->shipping_fee,
                    "total_price"=>$total_price,
                );
            }
        }

        foreach($this->super_model->select_all_order_by("employees", "employee_name", "ASC") AS $emp){
            $data['employees'][] = array( 
                'empname'=>$emp->employee_name,
                'empid'=>$emp->employee_id
            );
        }

         foreach($this->super_model->select_row_where("signatories", "requested", "1") AS $notes){
            $data['requested_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }

        foreach($this->super_model->select_row_where("signatories", "noted", "1") AS $notes){
            $data['noted_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }


        foreach($this->super_model->select_row_where("signatories", "approved", "1") AS $notes){
            $data['approved_emp'][] = array( 
                'empname'=>$this->super_model->select_column_where('employees', 'employee_name', 'employee_id', $notes->employee_id),
                'empid'=>$notes->employee_id
            );
        }
        $this->load->view('delivery/gatepass',$data);
    }

    public function getBuyer(){
        $buyer = $this->input->post('buyer');
        $address= $this->super_model->select_column_where('buyer', 'address', 'buyer_id', $buyer);
        $contact_person= $this->super_model->select_column_where('buyer', 'contact_person', 'buyer_id', $buyer);
        $contact_no= $this->super_model->select_column_where('buyer', 'contact_no', 'buyer_id', $buyer);
        $return = array('address' => $address, 'contact_person' => $contact_person, 'contact_no' => $contact_no);
        echo json_encode($return);
    }

    public function inventory_balance($itemid){
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id='$itemid' AND catalog_no = 'begbal'");
        $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id='$itemid' AND saved='1'","receive_id");
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND saved='1'","issuance_id");
        $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id='$itemid' AND saved='1'","rhead_id");
        $balance=($recqty+$begbal+$restockqty)-$issueqty;
        return $balance;
    }

    public function getIteminformation(){
        $item = $this->input->post('item');
        foreach($this->super_model->select_custom_where("items", "item_id='$item'") AS $itm){ 
            $rec_qty = $this->inventory_balance($itm->item_id);
            $return = array('item_id' => $itm->item_id,'item_name' => $itm->item_name, 'unit' => $itm->unit_id, 'pn' => $itm->original_pn, 'recqty' => $rec_qty); 
            echo json_encode($return);   
        }
    }

    public function getPRinformation(){
        $prno = $this->input->post('pr_no');
        foreach($this->super_model->custom_query("SELECT pr_no, enduse_id, purpose_id,department_id FROM receive_head INNER JOIN receive_details WHERE pr_no LIKE '%$prno%' AND saved='1' GROUP BY pr_no") AS $pr){ 
            $return = array('pr_no' => $pr->pr_no,'enduse' => $pr->enduse_id, 'purpose' => $pr->purpose_id, 'department' => $pr->department_id); 
            echo json_encode($return);   
        }
    }

    public function crossref_balance($itemid,$supplierid,$brandid,$catalogno){
        //$recqty= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno'");

        //$issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = '$catalogno' AND saved='1'","issuance_id");
        
        $begbal= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = 'begbal'");

        //echo "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no = 'begbal'";

         $recqty= $this->super_model->select_sum_join("received_qty","receive_items","receive_head", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno' AND saved='1'","receive_id");
        
        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno' AND saved='1'","issuance_id");
        
         $restockqty= $this->super_model->select_sum_join("quantity","restock_details","restock_head", "item_id = '$itemid' AND supplier_id = '$supplierid' AND brand_id = '$brandid' AND catalog_no ='$catalogno' AND saved='1' AND excess = '0'","rhead_id");
        
         $balance=($recqty+$begbal+$restockqty)-$issueqty;

         //$balance=$recqty-$issueqty;
         return $balance;
    }

    public function crossreflist(){
        $item=$this->input->post('item');
        $prno=$this->input->post('prno');
        $rows=$this->super_model->count_custom_where("supplier_items","item_id = '$item'");
        if($rows!=0){ ?>
            <select name='siid' id='siid' class='form-control' onchange="getUnitCost('<?php echo $prno; ?>','<?php echo $item; ?>')" >
            <option value=''>-Cross Reference-</option>
            <?php
            /*echo "<select name='siid' id='siid' class='form-control' onchange='getUnitCost()'>";
            echo "<option value=''>-Cross Reference-</option>";*/
            foreach($this->super_model->select_custom_where("supplier_items","item_id = '$item' AND quantity != '0'") AS $itm){ 
                    $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $itm->brand_id);
                    $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $itm->supplier_id);
                    $balance=$this->crossref_balance($itm->item_id,$itm->supplier_id, $itm->brand_id, $itm->catalog_no);
                    /*$unit = $this->super_model->select_column_where("items", "unit_id", "item_id", $itm->item_id);*/
                    foreach($this->super_model->select_custom_where("items","item_id = '$item'") AS $it){
                    $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
                    if($balance>0){
                    ?>
                    <option value="<?php echo $itm->si_id; ?>"><?php echo $supplier . " - " . $itm->catalog_no . " - ". $brand . " (".$balance.")" ." - ". $unit; ?></option>

                <?php } ?>

           <?php } } 
            echo "</select>";
        }
        
    }

    public function getitem(){
        foreach($this->super_model->select_row_where("supplier_items", "si_id", $this->input->post('siid')) AS $si){
             $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $si->brand_id);
             $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $si->supplier_id);
             $supplier_id = $si->supplier_id;
             $brand_id=$si->brand_id;
             $catalog_no = $si->catalog_no;
             $nkk_no = $si->nkk_no;
             $semt_no = $si->semt_no;

        $item_id=$this->input->post('itemid');
        foreach($this->super_model->select_custom_where("items","item_id = '$item_id'") AS $it){
             $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
            }
        }
        $data['list'] = array(
            'original_pn'=>$this->input->post('original_pn'),
            'unit'=>$this->input->post('unit'),
            'serial'=>$this->input->post('serial'),
            'unit_name'=>$unit,
            'itemid'=>$this->input->post('itemid'),
            'deliveryid'=>$this->input->post('deliveryid'),
            'siid'=>$this->input->post('siid'),
            'brand'=>$brand,
            'brand_id'=>$brand_id,
            'supplier_id'=>$supplier_id,
            'supplier'=>$supplier,
            'catalog_no'=>$catalog_no,
            'nkk_no'=>$nkk_no,
            'semt_no'=>$semt_no,
            'total'=>$this->input->post('total'),
            'quantity'=>$this->input->post('quantity'),
            'selling'=>$this->input->post('selling'),
            'discount'=>$this->input->post('discount'),
            'shipping'=>$this->input->post('shipping'),
            'item'=>$this->input->post('itemname'),
            'count'=>$this->input->post('count'),
        );
            
        $this->load->view('delivery/row_item',$data);
    }

    public function checkpritem(){
        $item = $this->input->post('item');
        $pr = $this->input->post('pr');
      
        $recqty = $this->super_model->custom_query_single("sumqty","SELECT SUM(ri.received_qty) AS sumqty FROM receive_items ri INNER JOIN receive_details rd ON ri.rd_id = rd.rd_id INNER JOIN receive_head rh ON rd.receive_id = rh.receive_id WHERE rh.saved = '1' AND rd.pr_no = '$pr' AND ri.item_id = '$item'");
       

        $issue_qty = $this->super_model->custom_query_single("issueqty","SELECT SUM(quantity) AS issueqty FROM issuance_head ih INNER JOIN issuance_details id ON ih.issuance_id = id.issuance_id WHERE pr_no= '$pr' AND item_id='$item'");

         /* $sales_qty = $this->super_model->custom_query_single("salesqty","SELECT SUM(qty) AS salesqty FROM delivery_head dh INNER JOIN delivery_details dd ON dh.delivery_id = dd.delivery_id WHERE pr_no= '$pr' AND item_id='$item'");*/

        $deliveredqty = $this->super_model->custom_query_single("deliveredqty","SELECT SUM(qty) AS deliveredqty FROM delivery_head ih INNER JOIN delivery_details id ON ih.delivery_id = id.delivery_id WHERE pr_no= '$pr' AND item_id='$item'");

        $bal=($recqty-$issue_qty-$deliveredqty);
        echo $bal;
    }

    public function getSIDetails(){
        $siid=$this->input->post('siid');

        $cost = $this->super_model->select_column_where("supplier_items", "item_cost", "si_id", $siid);
        echo $cost;
    }

    public function getMaxqty(){
        $siid=$this->input->post('siid');

        $brand=$this->super_model->select_column_where("supplier_items", "brand_id", "si_id", $siid);
        $supplier=$this->super_model->select_column_where("supplier_items", "supplier_id", "si_id", $siid);
        $catalog=$this->super_model->select_column_where("supplier_items", "catalog_no", "si_id", $siid);
        $itemid=$this->super_model->select_column_where("supplier_items", "item_id", "si_id", $siid);

        $recqty= $this->super_model->select_sum_where("supplier_items", "quantity", "item_id = '$itemid' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no ='$catalog'");

        $issueqty= $this->super_model->select_sum_join("quantity","issuance_details","issuance_head", "item_id='$itemid' AND supplier_id = '$supplier' AND brand_id = '$brand' AND catalog_no = '$catalog' AND saved='1'","issuance_id");

        $maxqty = $recqty-$issueqty;
        echo $maxqty;
    }

    public function add_delivery(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        $data['item_list']=$this->super_model->select_all_order_by("items","item_name","ASC");
        foreach($this->super_model->select_row_where("delivery_head","delivery_id",$id) AS $h){
            $buyer_name=$this->super_model->select_column_where("buyer","buyer_name","buyer_id",$h->buyer_id);
            $address=$this->super_model->select_column_where("buyer","address","buyer_id",$h->buyer_id);
            $contact_person=$this->super_model->select_column_where("buyer","contact_person","buyer_id",$h->buyer_id);
            $contact_no=$this->super_model->select_column_where("buyer","contact_no","buyer_id",$h->buyer_id);
            $data['heads'][]=array(
                "delivery_id"=>$h->delivery_id,
                "buyer_name"=>$buyer_name,
                "address"=>$address,
                "contact_person"=>$contact_person,
                "contact_no"=>$contact_no,
                "date"=>$h->date,
                "po_date"=>$h->po_date,
                "pr_no"=>$h->pr_no,
                "dr_no"=>$h->dr_no,
                "saved"=>$h->saved,
                "vat"=>$h->vat,
                "sales_pr"=>$h->sales_pr,
            );
            foreach($this->super_model->select_row_where("delivery_details","delivery_id",$h->delivery_id) AS $d){
                $item_name=$this->super_model->select_column_where("items","item_name","item_id",$d->item_id);
                $original_pn=$this->super_model->select_column_where("items","original_pn","item_id",$d->item_id);
                $unit=$this->super_model->select_column_where("uom","unit_name","unit_id",$d->unit_id);
                $rec_qty = $this->super_model->select_sum("supplier_items", "quantity", "item_id", $d->item_id);
                $total = ($d->selling_price * $d->qty)-$d->discount;

                foreach($this->super_model->select_custom_where("supplier_items","item_id = '$d->item_id' AND quantity != '0'") AS $itm){
                    $brand = $this->super_model->select_column_where("brand", "brand_name", "brand_id", $d->brand_id);
                    $supplier = $this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $d->supplier_id);
                    $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $d->unit_id);
                    $cross = $supplier ." - ". $itm->catalog_no ." - ". $brand . " (".$itm->quantity.")";
                }
                $data['details'][]=array(
                    "item_name"=>$item_name,
                    "pn_no"=>$original_pn,
                    "unit"=>$unit,
                    "qty"=>$d->qty,
                    "selling_price"=>$d->selling_price,
                    "serial_no"=>$d->serial_no,
                    "discount"=>$d->discount,
                    "shipping_fee"=>$d->shipping_fee,
                    'invqty'=>$rec_qty,
                    'cross'=>$cross,
                    'total'=>$total,
                );
            }
        $this->load->view('delivery/add_delivery',$data);
        $this->load->view('template/footer');
    }
}

    public function insertBuyer(){
        $counter = $this->input->post('counter');
        $total = $this->input->post('total');
        $id=$this->input->post('delivery_id');
        for($a=0;$a<$counter;$a++){
            if(!empty($this->input->post('item_id['.$a.']'))){
                $data = array(
                    'delivery_id'=>$this->input->post('delivery_id'),
                    'item_id'=>$this->input->post('item_id['.$a.']'),
                    'serial_no'=>$this->input->post('serial['.$a.']'),
                    'qty'=>$this->input->post('quantity['.$a.']'),
                    'selling_price'=>$this->input->post('selling['.$a.']'),
                    'discount'=>$this->input->post('discount['.$a.']'),
                    'shipping_fee'=>$this->input->post('shipping['.$a.']'),
                    'unit_id'=>$this->input->post('unit_id['.$a.']'),
                    'pn_no'=>$this->input->post('original_pn['.$a.']'),
                    'supplier_id'=>$this->input->post('supplier_id['.$a.']'),
                    'catalog_no'=>$this->input->post('catalog_no['.$a.']'),
                    'nkk_no'=>$this->input->post('nkk_no['.$a.']'),
                    'semt_no'=>$this->input->post('semt_no['.$a.']'),
                    'brand_id'=>$this->input->post('brand_id['.$a.']'),
                );
                $this->super_model->insert_into("delivery_details", $data); 
            }
        }

        $saved=array(
            'saved'=>1
        );
        $this->super_model->update_where("delivery_head", $saved, "delivery_id", $id);
        echo $id;
    }

    public function printGP(){
        $id=$this->input->post('delivery_id');
        $gpdetails=explode("-", $this->input->post('gpno'));
        $gp_prefix1=$gpdetails[0];
        $gp_prefix2=$gpdetails[1];
        $gp_prefix3=$gpdetails[2];
        $gp_prefix=$gp_prefix1."-".$gp_prefix2."-".$gp_prefix3;
        $checkgp=$this->super_model->count_custom_where("delivery_head","delivery_id='$id' AND gp_no!=''");
        $rows=$this->super_model->count_custom_where("gp_series","gp_prefix='$gp_prefix'");
        if($rows==0){
            $nxt= "0001";
            $gpno= $gp_prefix."-0001";
        } else {
            $series = $this->super_model->get_max_where("gp_series", "series","gp_prefix='$gp_prefix'");
            $next=$series+1;
            //$gpno = $gp_prefix."-".$next;
            if(strlen($next)==1){
                $nxt="000".$next;
                $gpno = $gp_prefix."-000".$next;
            } else if(strlen($next)==2){
                $nxt="00".$next;
                $gpno = $gp_prefix."-00".$next;
            } else if(strlen($next)==3){
                $nxt="0".$next;
                $gpno = $gp_prefix."-0".$next;
            } else if(strlen($next)==4){
                $nxt=$next;
                $gpno = $gp_prefix."-".$next;
            }
        }

        if($checkgp==0){
            $data = array(
                "gp_no"=>$gpno,
                "gp_prepared"=>$this->input->post('gp_employee'),
                "gp_recommending"=>$this->input->post('gp_recommend'),
                "gp_noted"=>$this->input->post('gp_noted'),
                "gp_approved"=>$this->input->post('gp_approved'),
                "gp_requested"=>$this->input->post('gp_requested'),
                "gp_inspected"=>$this->input->post('gp_inspected')
            );
        }else{
            $data = array(
                "gp_prepared"=>$this->input->post('gp_employee'),
                "gp_recommending"=>$this->input->post('gp_recommend'),
                "gp_noted"=>$this->input->post('gp_noted'),
                "gp_approved"=>$this->input->post('gp_approved'),
                "gp_requested"=>$this->input->post('gp_requested'),
                "gp_inspected"=>$this->input->post('gp_inspected')
            );
        }

        if($this->super_model->update_where("delivery_head", $data, "delivery_id", $id)){
            if($checkgp==0){
                $data_series = array(
                    "gp_prefix"=>$gp_prefix,
                    "series"=>$nxt,
                );
                $this->super_model->insert_into("gp_series", $data_series);
            }
        }
        echo "success";

    }
        public function getEmprel(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

        public function getEmpver(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

        public function getEmpnote(){
        $employee_id = $this->input->post('employee_id');
        foreach($this->super_model->custom_query("SELECT employee_id, position, employee_name FROM employees WHERE employee_id='$employee_id'") AS $emp){   
            $return = array('position' => $emp->position); 
            echo json_encode($return);   
        }
    }

    public function printDR(){
        $id=$this->input->post('delivery_id');
        $data = array(
            "remarks"=>$this->input->post('remarks'),
            "shipped_via"=>$this->input->post('shipped'),
            "waybill_no"=>$this->input->post('waybill_no'),
            "prepared_by"=>$_SESSION['user_id'],
            "released_by"=>$this->input->post('released_by'),
            "verified_by"=>$this->input->post('verified_by'),
            "received_by"=>$this->input->post('received_by'),
            "noted_by"=>$this->input->post('noted_by'),
        );

        $this->super_model->update_where("delivery_head", $data, "delivery_id", $id);
        echo "success";
    }
}