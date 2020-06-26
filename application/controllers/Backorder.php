<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Backorder extends CI_Controller {

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

    public function back_order(){

        $id=$this->uri->segment(3);
        $data['id']=$id;
      /*  foreach($this->super_model->select_row_where("receive_head", "receive", $id) AS $hd){
            //$mif = $this->super_model->select_column_where("issuance_head", "mif_no", "request_id", $id);
           // $saved = $this->super_model->select_column_where("issuance_head", "saved", "request_id", $id);
            $data['head'][] = array(
                "receiveid"=>$id,
                "mrecf_no"=>$hd->mrecf_no,
                "receive_date"=>$hd->receive_date,
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $hd->department_id),
                "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $hd->purpose_id),
                "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $hd->enduse_id),
                "prno"=>$hd->pr_no,
                "borrowfrom"=>$hd->borrowfrom_pr,
                "remarks"=>$hd->remarks,
                "saved"=>$saved

            );
        }

        foreach($this->super_model->select_row_where("request_items", "request_id", $id) AS $it){
            $issue_qty = $this->super_model->select_column_where("issuance_details", "quantity", "rq_id", $it->rq_id);
            $remarks = $this->super_model->select_column_where("issuance_details", "remarks", "rq_id", $it->rq_id);
            $issueid = $this->super_model->select_column_where("issuance_details", "issuance_id", "rq_id", $it->rq_id);
            $boqty=$this->backorder_qty($it->rq_id);
            $data['items'][] = array(
                "rqid"=>$it->rq_id,
                "catalog_no"=>$it->catalog_no,
                "siid"=>$it->si_id,
                "uom"=>$it->uom,
                "quantity"=>$boqty,
                "pn_no"=>$it->pn_no,
                "item"=>$this->super_model->select_column_where("items", "item_name", "item_id", $it->item_id),
                "supplier"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $it->supplier_id),
                "brand"=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $it->brand_id),
                "item_id"=>$it->item_id,
                "supplier_id"=>$it->supplier_id,
                "brand_id"=>$it->brand_id,
                "issue_qty"=>$issue_qty,
                "remarks"=>$remarks,
                "issueid"=>$issueid

            );


        }
*/
        /*foreach($this->super_model->select_all_group("issuance_details","rq_id") AS $issue){
            foreach($this->super_model->select_row_where("request_items", "rq_id", $issue->rq_id) AS $request){
                $issueqty= $this->super_model->select_sum("issuance_details", "quantity", "rq_id", $issue->rq_id);
                $reqqty= $request->quantity;
                if($issueqty < $reqqty){
                    $data['prback'][]= array(
                        "mreqf"=>$this->super_model->select_column_where("issuance_head", "mreqf_no", "issuance_id", $issue->issuance_id),
                        "id"=>$request->request_id
                    );
                }
            }
        }*/

          foreach($this->super_model->select_row_where("receive_details", "rd_id", $id) AS $rd){
            
               
                 $data['details'][] = array(
                    "receiveid"=>$rd->receive_id,
                    "rdid"=>$rd->rd_id,
                    "prno"=>$rd->pr_no,
                    "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $rd->department_id),
                     "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $rd->purpose_id),
                    "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $rd->enduse_id),
                 );
             
        }

        foreach($this->super_model->select_row_where("receive_items", "rd_id", $id) AS $it){
             if($it->expected_qty > $it->received_qty){
                $boqty=$this->backorder_qty($it->ri_id);
                 $data['items'][] = array(
                    "receiveid"=>$it->receive_id,
                    "rdid"=>$it->rd_id,
                    "riid"=>$it->ri_id,
                    "item"=>$this->super_model->select_column_where("items", "item_name", "item_id", $it->item_id),
                    "supplier"=>$this->super_model->select_column_where("supplier", "supplier_name", "supplier_id", $it->supplier_id),
                    "brand"=>$this->super_model->select_column_where("brand", "brand_name", "brand_id", $it->brand_id),
                    "item_id"=>$it->item_id,
                    "supplier_id"=>$it->supplier_id,
                    "brand_id"=>$it->brand_id,
                    "expected_qty"=>$it->expected_qty,
                    "received_qty"=>$it->received_qty,
                    "quantity"=>$boqty,
                      "catalog_no"=>$it->catalog_no,
                 );
             }
        }


        /*  foreach($this->super_model->custom_query("SELECT * FROM receive_items lut WHERE NOT EXISTS (SELECT * FROM receive_items nx WHERE nx.po_no = lut.po_no AND nx.ri_id > lut.ri_id) ORDER BY ri_id DESC") AS $ri){
                 $item=$this->super_model->select_column_where("items", "item_name", "item_id", $ri->item_id);

                 if($ri->expected_qty>$ri->received_qty){
                     $data['prback'][]=array(
                        "pono"=>$ri->po_no,
                        "rdid"=>$ri->rd_id,
                       
                        
                    );
                 }
        }*/

        foreach($this->super_model->custom_query("SELECT * FROM receive_items lut INNER JOIN receive_details rd ON rd.rd_id = lut.rd_id WHERE NOT EXISTS (SELECT * FROM receive_items nx INNER JOIN receive_details rx ON rx.rd_id = nx.rd_id WHERE nx.item_id = lut.item_id AND nx.supplier_id = lut.supplier_id AND nx.brand_id = lut.brand_id AND nx.catalog_no = lut.catalog_no AND rd.pr_no = rx.pr_no AND nx.ri_id > lut.ri_id) ORDER BY ri_id DESC") AS $ri){
                 $item=$this->super_model->select_column_where("items", "item_name", "item_id", $ri->item_id);
                 $pr_no=$this->super_model->select_column_where("receive_details", "pr_no", "receive_id", $ri->receive_id);
                 $boqty=$this->backorder_qty($ri->ri_id);
                 if($ri->expected_qty>$ri->received_qty){
                     $data['prback'][]=array(
                        "pono"=>$ri->po_no,
                        "pr_no"=>$pr_no,
                        "rdid"=>$ri->rd_id,
                        "item"=>$item,
                        "expected"=>$boqty,
                        "received"=>$ri->received_qty,
                    );
                 }
        }
       
     
        
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('backorder/back_order',$data);
        $this->load->view('template/footer');
    }

    
    public function backorder_qty($riid){

        $expectedqty = $this->super_model->select_sum("receive_items", "expected_qty", "ri_id", $riid);
        $recqty = $this->super_model->select_column_where("receive_items", "received_qty", "ri_id", $riid);
        $bo_qty = $expectedqty-$recqty;
        return $bo_qty;
    }

    public function saveBackorder(){
      
        $receive_id= $this->input->post('receive_id');
        $rdid= $this->input->post('rdid');
        $po_no= $this->input->post('po_no');
        $dr_no= $this->input->post('dr_no');
        $userid = $_SESSION['user_id'];
         $year=date('Y-m');
         $now=date('Y-m-d H:i:s');
         $receivedate=date('Y-m-d');
            $rows=$this->super_model->count_custom_where("receive_head","receive_date LIKE '$year%'");
            if($rows==0){
                 $newrec_no = "MrecF-".$year."-0001";
            } else {
                $maxrecno=$this->super_model->get_max_where("receive_head", "mrecf_no","receive_date LIKE '$year%'");
                $recno = explode('-',$maxrecno);
                $series = $recno[3]+1;
                if(strlen($series)==1){
                    $newrec_no = "MrecF-".$year."-000".$series;
                } else if(strlen($series)==2){
                     $newrec_no = "MrecF-".$year."-00".$series;
                } else if(strlen($series)==3){
                     $newrec_no = "MrecF-".$year."-0".$series;
                } else if(strlen($series)==4){
                     $newrec_no = "MrecF-".$year."-".$series;
                }
            }


        $head_rows = $this->super_model->count_rows("receive_head");
        if($head_rows==0){
            $receiveid=1;
        } else {
            $maxid=$this->super_model->get_max("receive_head", "receive_id");
            $receiveid=$maxid+1;
        }

        foreach($this->super_model->select_row_where("receive_head", "receive_id", $receive_id) AS $hd){
              
            $data = array(
                  'receive_id'=>$receiveid,
                   'pcf'=>$hd->pcf,
                   'create_date'=> $now,
                   'receive_date'=> $receivedate,
                   'mrecf_no'=> $newrec_no,
                   'dr_no'=> $dr_no,
                   'jo_no'=> $hd->jo_no,
                   'po_no'=> $po_no,
                   'si_no'=> $hd->si_no,
                   'user_id'=> $userid,
                   'saved'=>'1'

            );

            $this->super_model->insert_into("receive_head", $data);
        }

           if($rows==0){
                $newrdid=1;
            } else {
                $maxid= $this->super_model->get_max("receive_details", "rd_id");
                $newrdid=$maxid+1;
            }


        foreach($this->super_model->select_row_where("receive_details", "rd_id", $rdid) AS $rd){
       
               $details = array(
                   'rd_id'=>$newrdid,
                   'receive_id'=> $receiveid,
                   'pr_no'=> $rd->pr_no,
                   'enduse_id'=> $rd->enduse_id,
                   'purpose_id'=> $rd->purpose_id,
                   'department_id'=> $rd->department_id
                );

        
                $this->super_model->insert_into("receive_details", $details);
        }

         $counter = $this->input->post('count');
        $pono=$this->super_model->select_column_where("receive_head", "po_no", "receive_id", $receive_id);
         //print_r($this->input->post('riid'));
        for($a=0;$a<$counter;$a++){
           // $riid= $this->input->post('riid['.$a.']');
            //echo $riid;
             foreach($this->super_model->select_row_where("receive_items", "ri_id", $this->input->post('riid['.$a.']')) AS $rd){
           
                $items = array(
                'rd_id'=>$newrdid,
                'receive_id'=> $receiveid,
                'po_no'=>$po_no,
                'supplier_id'=> $rd->supplier_id,
                'item_id'=> $rd->item_id,
                'brand_id'=> $rd->brand_id,
                'catalog_no'=> $rd->catalog_no,
                'serial_id'=>$rd->serial_id,
                'item_cost'=> $rd->item_cost,
                'expected_qty'=>$this->input->post('expqty['.$a.']'),
                'received_qty'=>$this->input->post('quantity['.$a.']'),
                'remarks'=> $this->input->post('remarks['.$a.']'),
                'inspected_by'=> $rd->inspected_by
            );
            
            $this->super_model->insert_into("receive_items", $items);

            $existingqty = $this->super_model->select_column_custom_where("supplier_items", "quantity", "item_id = '$rd->item_id' AND supplier_id = '$rd->supplier_id' AND catalog_no ='$rd->catalog_no' AND brand_id = '$rd->brand_id'");
            $newqty = $existingqty + $this->input->post('quantity['.$a.']');
            $si = array(
                "quantity"=>$newqty
            );

            $this->super_model->update_custom_where("supplier_items", $si, "item_id = '$rd->item_id' AND supplier_id = '$rd->supplier_id' AND catalog_no ='$rd->catalog_no' AND brand_id = '$rd->brand_id'");
            }
        }

        echo $receiveid;
    }
    /*   $requestid= $this->input->post('request_id');
       $rqid=$this->input->post('rqid');
      
       $quantity=$this->input->post('quantity');
       $userid=$this->input->post('userid');
   
        $remarks = $this->input->post('remarks');
       

       $count = count($quantity);
       
       $year=date('Y-m');
       

       $rows=$this->super_model->count_custom_where("issuance_head","issue_date LIKE '$year%'");

    
        if($rows==0){
             $mifno = "MIF-".$year."-0001";
        } else {
            $maxrecno=$this->super_model->get_max_where("issuance_head", "mif_no","issue_date LIKE '$year%'");
            $recno = explode('-',$maxrecno);
            $series = $recno[3]+1;
            if(strlen($series)==1){
                $mifno = "MIF-".$year."-000".$series;
            } else if(strlen($series)==2){
                 $mifno = "MIF-".$year."-00".$series;
            } else if(strlen($series)==3){
                 $mifno = "MIF-".$year."-0".$series;
            } else if(strlen($series)==4){
                 $mifno = "MIF-".$year."-".$series;
            }
        }

        $date=date('Y-m-d');
        $time=date('H:i:s');
        $create=date('Y-m-d H:i:s');

        $head_rows = $this->super_model->count_rows("issuance_head");
        if($head_rows==0){
            $issueid=1;
        } else {
            $maxid=$this->super_model->get_max("issuance_head", "issuance_id");
            $issueid=$maxid+1;
        }

        foreach($this->super_model->select_row_where("request_head", "request_id", $requestid) AS $req){
          

            $data = array(
                'issuance_id'=>$issueid,
                'mif_no'=>$mifno,
                'request_id'=>$requestid,
                'mreqf_no'=>$req->mreqf_no,
                'issue_date'=>$date,
                'issue_time'=>$time,
                'create_date'=>$create,
                'department_id'=>$req->department_id,
                'purpose_id'=>$req->purpose_id,
                'enduse_id'=>$req->enduse_id,
                'pr_no'=> $pr=$req->pr_no,
                'user_id'=>$userid,
                'saved'=>'1'
                
            );

            $this->super_model->insert_into("issuance_head", $data);
        }



       for($x=0; $x<$count; $x++){

         $itemid=$this->super_model->select_column_where("request_items", "item_id", "rq_id", $rqid[$x]);
         $supplierid=$this->super_model->select_column_where("request_items", "supplier_id", "rq_id", $rqid[$x]);
         $catalogno=$this->super_model->select_column_where("request_items", "catalog_no", "rq_id", $rqid[$x]);
         $brandid=$this->super_model->select_column_where("request_items", "brand_id", "rq_id", $rqid[$x]);
         $pn_no=$this->super_model->select_column_where("request_items", "pn_no", "rq_id", $rqid[$x]);
         $uom=$this->super_model->select_column_where("request_items", "uom", "rq_id", $rqid[$x]);
         
         if($quantity[$x]!='0' && $quantity[$x]!=""){
          
            $details= array(
                'issuance_id'=>$issueid,
                'rq_id'=>$rqid[$x],
                'item_id'=>$itemid,
                'supplier_id'=>$supplierid,
                'catalog_no'=>$catalogno,
                'brand_id'=>$brandid,
                'quantity'=>$quantity[$x],
                'pn_no'=>$pn_no,
                'uom'=>$uom,
                'remarks'=>$remarks[$x],
            );
        
             $this->super_model->insert_into("issuance_details", $details);
        }
       }

       echo $issueid;
    }*/
}
?>

