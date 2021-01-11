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
            );
            foreach($this->super_model->select_row_where("delivery_details","delivery_id",$h->delivery_id) AS $d){
                $item_name=$this->super_model->select_column_where("items","item_name","item_id",$d->item_id);
                $original_pn=$this->super_model->select_column_where("items","original_pn","item_id",$d->item_id);
                $unit=$this->super_model->select_column_where("uom","unit_name","unit_id",$d->unit_id);
                $data['details'][]=array(
                    "item_name"=>$item_name,
                    "pn_no"=>$original_pn,
                    "unit"=>$unit,
                    "qty"=>$d->qty,
                    "selling_price"=>$d->selling_price,
                    "discount"=>$d->discount,
                    "shipping_fee"=>$d->shipping_fee,
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
        $rows=$this->super_model->count_rows("delivery_head");
        if($rows==0){
            $dr_no = $location."-0001";
        } else {
            $dr=$this->super_model->get_max("delivery_head", "dr_no");
            $dr_nos = explode('-',$dr);
            $series = $dr_nos[1]+1;
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
                $data['details'][]=array(
                    "item_name"=>$item_name,
                    "pn_no"=>$original_pn,
                    "unit"=>$unit,
                    "qty"=>$d->qty,
                    "selling_price"=>$d->selling_price,
                    "discount"=>$d->discount,
                    "shipping_fee"=>$d->shipping_fee,
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

    public function getIteminformation(){
        $item = $this->input->post('item');
        foreach($this->super_model->select_custom_where("items", "item_id='$item'") AS $itm){ 
            $return = array('item_id' => $itm->item_id,'item_name' => $itm->item_name, 'unit' => $itm->unit_id, 'pn' => $itm->original_pn); 
            echo json_encode($return);   
        }
    }

    public function getitem(){
        $item_id=$this->input->post('itemid');
        foreach($this->super_model->select_custom_where("items","item_id = '$item_id'") AS $it){
             $unit = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $it->unit_id);
        }
        $data['list'] = array(
            'original_pn'=>$this->input->post('original_pn'),
            'unit'=>$this->input->post('unit'),
            'unit_name'=>$unit,
            'itemid'=>$this->input->post('itemid'),
            'quantity'=>$this->input->post('quantity'),
            'selling'=>$this->input->post('selling'),
            'discount'=>$this->input->post('discount'),
            'shipping'=>$this->input->post('shipping'),
            'item'=>$this->input->post('itemname'),
            'count'=>$this->input->post('count'),
        );
            
        $this->load->view('delivery/row_item',$data);
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
            );
            foreach($this->super_model->select_row_where("delivery_details","delivery_id",$h->delivery_id) AS $d){
                $item_name=$this->super_model->select_column_where("items","item_name","item_id",$d->item_id);
                $original_pn=$this->super_model->select_column_where("items","original_pn","item_id",$d->item_id);
                $unit=$this->super_model->select_column_where("uom","unit_name","unit_id",$d->unit_id);
                $data['details'][]=array(
                    "item_name"=>$item_name,
                    "pn_no"=>$original_pn,
                    "unit"=>$unit,
                    "qty"=>$d->qty,
                    "selling_price"=>$d->selling_price,
                    "discount"=>$d->discount,
                    "shipping_fee"=>$d->shipping_fee,
                );
            }
        }
        $this->load->view('delivery/add_delivery',$data);
        $this->load->view('template/footer');
    }

    public function insertBuyer(){
        $counter = $this->input->post('counter');
        $id=$this->input->post('delivery_id');
        for($a=0;$a<$counter;$a++){
            if(!empty($this->input->post('item_id['.$a.']'))){
                $data = array(
                    'delivery_id'=>$this->input->post('delivery_id'),
                    'item_id'=>$this->input->post('item_id['.$a.']'),
                    'qty'=>$this->input->post('quantity['.$a.']'),
                    'selling_price'=>$this->input->post('selling['.$a.']'),
                    'discount'=>$this->input->post('discount['.$a.']'),
                    'shipping_fee'=>$this->input->post('shipping['.$a.']'),
                    'unit_id'=>$this->input->post('unit_id['.$a.']'),
                    'pn_no'=>$this->input->post('original_pn['.$a.']'),
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
            "prepared_by"=>$this->input->post('user_id'),
            "released_by"=>$this->input->post('released_by'),
            "verified_by"=>$this->input->post('verified_by'),
            "received_by"=>$this->input->post('received_by'),
            "noted_by"=>$this->input->post('noted_by'),
        );

        $this->super_model->update_where("delivery_head", $data, "delivery_id", $id);
        echo "success";
    }
}