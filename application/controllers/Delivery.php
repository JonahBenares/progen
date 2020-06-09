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
        $year=date('Y');
        $rows=$this->super_model->count_custom_where("issuance_head","issue_date LIKE '$year%' AND dr_no!=''");
        if($rows==0){
            $dr_no = "PRO".$year."-0001";
        } else {
            $maxdrno=$this->super_model->get_max_where("issuance_head", "dr_no","create_date LIKE '$year%'");
            $drno = explode('-',$maxdrno);
            $series = $drno[1]+1;
            if(strlen($series)==1){
                $dr_no = "PRO".$year."-000".$series;
            } else if(strlen($series)==2){
                 $dr_no = "PRO".$year."-00".$series;
            } else if(strlen($series)==3){
                 $dr_no = "PRO".$year."-0".$series;
            } else if(strlen($series)==4){
                 $dr_no = "PRO".$year."-".$series;
            }
        }
        $data['heads'] = $this->super_model->select_row_where('issuance_head', 'issuance_id', $id);
        foreach($this->super_model->select_row_where('issuance_head','issuance_id', $id) AS $issue){
            $data['prepared_by']=$this->super_model->select_column_where("users","username","user_id",$issue->dr_prepared_by);
            $data['issuance_details'][] = array(
                'mif'=>$issue->mif_no,
                'dr_no'=>$dr_no,
                'prno'=>$issue->pr_no,
                'date'=>$issue->issue_date,
                'remarks'=>$issue->remarks
            );
            foreach($this->super_model->select_row_where('issuance_details','issuance_id', $issue->issuance_id) AS $rt){
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $rt->item_id);
                $uom = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $rt->unit_id);
                $data['issue_itm'][] = array(
                    'item'=>$item,
                    'qty'=>$rt->quantity,
                    'uom'=>$uom,
                    'pn'=>$rt->pn_no,
                    'remarks'=>$rt->remarks
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

    public function gatepass(){
        $this->load->view('template/header');
        $this->load->view('template/print_head'); 
        $this->load->view('delivery/gatepass');
    }

    public function add_delivery(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('delivery/add_delivery');
        $this->load->view('template/footer');
    }
}
