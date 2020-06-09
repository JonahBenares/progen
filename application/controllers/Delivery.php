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
        $this->load->view('delivery/delivery_list');
        $this->load->view('template/footer');
    }

    public function delivery_receipt(){        
        $this->load->view('template/header');
        $this->load->view('template/print_head');
        $data['id']=$this->uri->segment(3);
        $id=$this->uri->segment(3);
        foreach($this->super_model->select_row_where("delivery_head","delivery_id",$id) AS $h){
            $buyer_name=$this->super_model->select_column_where("buyer","buyer_name","buyer_id",$h->buyer_id);
            $address=$this->super_model->select_column_where("buyer","address","buyer_id",$h->buyer_id);
            $contact_person=$this->super_model->select_column_where("buyer","contact_person","buyer_id",$h->buyer_id);
            $contact_no=$this->super_model->select_column_where("buyer","contact_no","buyer_id",$h->buyer_id);
            $verified_by=$this->super_model->select_column_where("employees","employee_name","employee_id",$h->verified_by);
            $prepared_by=$this->super_model->select_column_where("employees","employee_name","employee_id",$h->user_id);
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
                "noted_by"=>$noted_by,
                "received_by"=>$h->received_by,
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
                    "qty"=>$h->qty,
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
        $this->load->view('delivery/delivery_receipt',$data);
    }

    public function insert_delivery(){
        $location=LOCATION;
        $date=$this->input->post('date');
        $pr_no=$this->input->post('pr_no');
        $buyer=$this->input->post('buyer');
        $po_date=$this->input->post('po_date');
        $rows=$this->super_model->count_rows("delivery_head");
        if($rows==0){
            $dr_no = $location."-0001";
        } else {
            $dr=$this->super_model->get_max("delivery_head", "dr_no");
            $dr_nos = explode('-',$dr);
            $series = $dr_nos[1]+1;
            if(strlen($series)==1){
                $dr_no = $location."-000".$series;
            } else if(strlen($series)==2){
                 $dr_no = $location."-00".$series;
            } else if(strlen($series)==3){
                 $dr_no = $location."-0".$series;
            } else if(strlen($series)==4){
                 $dr_no = $location."-".$series;
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
        $this->load->view('delivery/gatepass');
    }
    public function getBuyer(){
        $buyer = $this->input->post('buyer');
        $address= $this->super_model->select_column_where('buyer', 'address', 'buyer_id', $buyer);
        $contact_person= $this->super_model->select_column_where('buyer', 'contact_person', 'buyer_id', $buyer);
        $contact_no= $this->super_model->select_column_where('buyer', 'contact_no', 'buyer_id', $buyer);
        $return = array('address' => $address, 'contact_person' => $contact_person, 'contact_no' => $contact_no);
        echo json_encode($return);
    }
    
    public function add_delivery(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('delivery/add_delivery');
        $this->load->view('template/footer');
    }
}
