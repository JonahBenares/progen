<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assembly extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->helper(array('form', 'url'));
        $this->load->library('session');
        $this->load->model('super_model');
        date_default_timezone_set("Asia/Manila");
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
            } 
            else {
                return false;
            }
        }
    }


    public function bank_list(){
        $data['bank'] = $this->super_model->select_all_order_by('assembly_bank','bank_location','ASC');
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/bank_list', $data);
        $this->load->view('template/footer');
    }

    public function assloc_list(){
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/assloc_list');
        $this->load->view('template/footer');
    }

    public function condi_list(){
        $data['condition'] = $this->super_model->select_all_order_by('assembly_condition','condition_desc','ASC');
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/condi_list',$data);
        $this->load->view('template/footer');
    }

    public function insert_bank(){
       
        $data = array(
            'bank_location'=>$this->input->post('bank_location'),
            'bank_name'=>$this->input->post('bank_name'),
        );
        if($this->super_model->insert_into("assembly_bank", $data)){
           echo "<script>alert('Bank successfully Added!'); 
                window.location ='".base_url()."index.php/assembly/bank_list'; </script>";
         }
    }

    public function insert_condition(){
       
        $data = array(
            'condition_desc'=>$this->input->post('condition'),
        );
        if($this->super_model->insert_into("assembly_condition", $data)){
           echo "<script>alert('Condition successfully added!'); 
                window.location ='".base_url()."index.php/assembly/condi_list'; </script>";
         }
    }

     public function update_bank(){
        $id=$this->uri->segment(3);
        $data['bank'] = $this->super_model->select_row_where('assembly_bank', 'bank_id', $id);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/update_bank', $data);
        $this->load->view('template/footer');
    }

    public function edit_bank(){
        $data = array(
            'bank_location'=>$this->input->post('bank_location'),
            'bank_name'=>$this->input->post('bank_name'),
        );
        $bankid = $this->input->post('bank_id');
            if($this->super_model->update_where('assembly_bank ', $data, 'bank_id', $bankid)){
            echo "<script>alert('Successfully updated'); 
                window.location ='".base_url()."index.php/assembly/bank_list'; </script>";
        }
    }

    public function delete_bank(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('assembly_bank', 'bank_id', $id)){
            echo "<script>alert('Succesfully deleted!'); 
                window.location ='".base_url()."index.php/assembly/bank_list'; </script>";
        }
    }


    public function update_condition(){
        $id=$this->uri->segment(3);
        $data['condition'] = $this->super_model->select_row_where('assembly_condition', 'condition_id', $id);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/update_condition', $data);
        $this->load->view('template/footer');
    }

     public function edit_condition(){
        $data = array(
            'condition_desc'=>$this->input->post('condition')
        );
        $conid = $this->input->post('condition_id');
            if($this->super_model->update_where('assembly_condition ', $data, 'condition_id', $conid)){
            echo "<script>alert('Successfully updated!'); 
                window.location ='".base_url()."index.php/assembly/condi_list'; </script>";
        }
    }

     public function delete_condition(){
        $id=$this->uri->segment(3);
        if($this->super_model->delete_where('assembly_condition', 'condition_id', $id)){
            echo "<script>alert('Succesfully deleted!'); 
                window.location ='".base_url()."index.php/assembly/condi_list'; </script>";
        }
    }


    public function parts_list(){
        $data['engine'] = $this->super_model->select_all('assembly_engine');
        $data['assembly'] = $this->super_model->select_all('assembly_head');
        foreach($this->super_model->select_all('assembly_details') AS $det){
            $item = $this->super_model->select_column_where("items","item_name", "item_id", $det->item_id);
            $unit = $this->super_model->select_column_where("uom","unit_name", "unit_id", $det->uom);
            $data['items'][]= array(
                "id"=>$det->ad_id,
                "engine_id"=>$det->engine_id,
                "assembly_id"=>$det->assembly_id,
                "item"=>$item,
                "pn"=>$det->pn_no,
                "uom"=>$unit,
                "qty"=>$det->qty
            );
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/parts_list', $data);
        $this->load->view('template/footer');
    }

    public function update_item(){
        $id=$this->uri->segment(3);
        $data['id'] = $id;
         foreach($this->super_model->select_row_where('assembly_details', 'ad_id', $id) AS $det){
            $item = $this->super_model->select_column_where("items","item_name", "item_id", $det->item_id);
            $unit = $this->super_model->select_column_where("uom","unit_name", "unit_id", $det->uom);
            $data['items'][]= array(
                "id"=>$det->ad_id,
                "item"=>$item,
                "pn"=>$det->pn_no,
                "uom"=>$unit,
                "qty"=>$det->qty,
                "item_id"=>$det->item_id,
                "uom_id"=>$det->uom
            );
        }
        $this->load->view('template/header');
        $this->load->view('assembly/update_item', $data);
        $this->load->view('template/footer');
    }

    public function insert_engine(){
       
        $data = array(
            'engine_name'=>$this->input->post('engine_name'),
        );
        if($this->super_model->insert_into("assembly_engine", $data)){
           echo "<script>alert('Engine successfully added!'); 
                window.location ='".base_url()."index.php/assembly/parts_list'; </script>";
         }
    }

     public function edit_engine(){
        $data = array(
            'engine_name'=>$this->input->post('enginename')
        );
        $engineid = $this->input->post('engineid');
            if($this->super_model->update_where('assembly_engine ', $data, 'engine_id', $engineid)){
            echo "<script>alert('Successfully updated!'); 
                window.location ='".base_url()."index.php/assembly/parts_list'; </script>";
        }
    }

     public function insert_assembly(){
       
        $data = array(
            'engine_id'=>$this->input->post('engine_id'),
            'assembly_name'=>$this->input->post('assembly_name'),
        );
        if($this->super_model->insert_into("assembly_head", $data)){
           echo "<script>alert('Assembly successfully added!'); 
                window.location ='".base_url()."index.php/assembly/parts_list'; </script>";
         }
    }

     public function edit_assembly(){
        $data = array(
            'assembly_name'=>$this->input->post('assemblyname')
        );
        $assemblyid = $this->input->post('assemblyid');
            if($this->super_model->update_where('assembly_head ', $data, 'assembly_id', $assemblyid)){
            echo "<script>alert('Successfully updated!'); 
                window.location ='".base_url()."index.php/assembly/parts_list'; </script>";
        }
    }

     public function itemlist(){
        $item=$this->input->post('item');
        $rows=$this->super_model->count_custom_where("items","item_name LIKE '%$item%'");
        if($rows!=0){
             echo "<ul id='name-item'>";
            foreach($this->super_model->select_custom_where("items", "item_name LIKE '%$item%'") AS $itm){ 
                    $name = str_replace('"', '', $itm->item_name);
                    $uom = $this->super_model->select_column_where("uom","unit_name", "unit_id", $itm->unit_id);
                    ?>
                   <li onClick="selectItem('<?php echo $itm->item_id; ?>','<?php echo $name; ?>','<?php echo $uom; ?>', '<?php echo $itm->unit_id; ?>','<?php echo $itm->original_pn;?>')"><strong><?php echo $itm->original_pn;?> - </strong> <?php echo $name; ?></li>
                <?php 
            }
             echo "<ul>";
        }
    }

     public function insert_item(){
        $engineid = $this->super_model->select_column_where("assembly_head","engine_id", "assembly_id", $this->input->post('assembly_id'));
        $data = array(
            'engine_id'=>$engineid,
            'assembly_id'=>$this->input->post('assembly_id'),
            'item_id'=>$this->input->post('item_id'),
            'pn_no'=>$this->input->post('pn_no'),
            'qty'=>$this->input->post('qty'),
            'uom'=>$this->input->post('uom_id'),
        );
        if($this->super_model->insert_into("assembly_details", $data)){
           echo "<script>alert('Assembly item successfully added!'); 
                window.location ='".base_url()."index.php/assembly/parts_list'; </script>";
         }
    }

      public function update_assem_item(){
        $id = $this->input->post('id');
        $data = array(
            'item_id'=>$this->input->post('item_id'),
            'pn_no'=>$this->input->post('pn_no'),
            'qty'=>$this->input->post('qty'),
            'uom'=>$this->input->post('uom_id'),
        );
        if($this->super_model->update_where("assembly_details", $data, 'ad_id', $id)){
           echo "<script>alert('Assembly item successfully updated!'); 
                window.close(); window.opener.location.reload(); </script>";
         }
    }

    public function searchPlate($engine, $assembly, $bankid, $column){
        $col = $this->super_model->select_column_custom_where("assembly_inventory", $column,"engine_id = '$engine' AND assembly_id = '$assembly' AND bank_id = '$bankid'");
        return $col; 
    }

    public function searchQty($engine, $assembly, $bankid, $item, $column){
        $col = $this->super_model->select_column_custom_where("assembly_inventory", $column,"engine_id = '$engine' AND assembly_id = '$assembly' AND item_id = '$item' AND bank_id = '$bankid'");
        //return "engine_id = '$engine' AND assembly_id = '$assembly' AND item_id = '$item' AND bank_id = '$bankid'";
        return $col; 
    }

     public function getReqQty($engine, $assembly, $item){
        $col = $this->super_model->select_column_custom_where("assembly_details", "qty","engine_id = '$engine' AND assembly_id = '$assembly' AND item_id = '$item'");
        return $col; 
    }

     public function searchValue($engine, $assembly, $item, $column){
        $col = $this->super_model->select_column_custom_where("assembly_inventory", $column,"engine_id = '$engine' AND assembly_id = '$assembly' AND item_id = '$item'");
        return $col; 
    }

    public function engview_list(){
        $engine=$this->uri->segment(3);
        $data['engine_id'] = $engine;
        $data['engine_name'] = $this->super_model->select_column_where("assembly_engine","engine_name", "engine_id", $engine);
        $data['assembly'] = $this->super_model->select_row_where("assembly_head", "engine_id", $engine);
        $count= $this->super_model->count_rows_where("assembly_details", "engine_id", $engine);
        if($count!=0){
            foreach($this->super_model->select_row_where("assembly_details", "engine_id", $engine) AS $det){
                $itemname=$this->super_model->select_column_where("items","item_name", "item_id", $det->item_id);
                $uom=$this->super_model->select_column_where("uom","unit_name", "unit_id", $det->uom);
                $data['items'][] = array(
                    "id"=>$det->ad_id,
                    "assembly_id"=>$det->assembly_id,
                    "item_id"=>$det->item_id,
                    "item_name"=>$itemname,
                    "pn_no"=>$det->pn_no,
                    "qty"=>$det->qty,
                    "uom"=>$uom
                );
            }
        } else {
            $data['items']=array();
        }
        $data['left'] = $this->super_model->count_rows_where("assembly_bank","bank_location","A");
        $data['right'] = $this->super_model->count_rows_where("assembly_bank","bank_location","B");
        $data['leftbank'] = $this->super_model->select_row_where_order_by("assembly_bank", "bank_location","A","bank_name", "ASC");
        $data['rightbank'] = $this->super_model->select_row_where_order_by("assembly_bank", "bank_location","B","bank_name", "ASC");
        $this->load->view('template/header');
        $this->load->view('assembly/engview_list',$data);
        $this->load->view('template/footer');
    }


     public function complete_list(){
        $engine=$this->uri->segment(3);
        $assembly=$this->uri->segment(4);
        $data['engine_id'] = $engine;
        $data['assembly_id'] = $assembly;
        $data['engine'] = $this->super_model->select_column_where("assembly_engine","engine_name", "engine_id", $engine);
        $data['assembly'] = $this->super_model->select_column_where("assembly_head","assembly_name", "assembly_id", $assembly);
        $data['left'] = $this->super_model->count_rows_where("assembly_bank","bank_location","A");
        $data['right'] = $this->super_model->count_rows_where("assembly_bank","bank_location","B");
        $data['leftbank'] = $this->super_model->select_row_where_order_by("assembly_bank", "bank_location","A","bank_name", "ASC");
        $data['rightbank'] = $this->super_model->select_row_where_order_by("assembly_bank", "bank_location","B","bank_name", "ASC");
        $data['inventory']= $this->super_model->select_custom_where("assembly_inventory", "engine_id = '$engine' AND assembly_id = '$assembly'");
        $count= $this->super_model->count_rows_where("assembly_details", "assembly_id", $assembly);
        if($count!=0){
            foreach($this->super_model->select_row_where("assembly_details", "assembly_id", $assembly) AS $det){
                $itemname=$this->super_model->select_column_where("items","item_name", "item_id", $det->item_id);
                $uom=$this->super_model->select_column_where("uom","unit_name", "unit_id", $det->uom);
                $data['items'][] = array(
                    "id"=>$det->ad_id,
                    "item_id"=>$det->item_id,
                    "item_name"=>$itemname,
                    "pn_no"=>$det->pn_no,
                    "qty"=>$det->qty,
                    "uom"=>$uom
                );
            }
        } else {
            $data['items']=array();
        }
        $this->load->view('template/header');
        $this->load->view('assembly/complete_list', $data);
        $this->load->view('template/footer');
    }

    public function insert_inventory(){
        $now=date('Y-m-d H:i:s');
        $item_counter = $this->input->post('counter_item');
        $bank_counter = $this->input->post('counter');
        $engine = $this->input->post('engine');
        for($y=0;$y<=$item_counter;$y++){
            $qty = $this->input->post('qty'.$y);
            $bank = $this->input->post('bank'.$y);

            for($x=0;$x<$bank_counter;$x++){
            $plate = $this->input->post('plate'.$x);
               
                   // echo $this->input->post('item'.$y) . " - ". $qty[$x]. " - " . $bank[$x]  . $plate . "<br>";
                  //  if(!empty($qty[$x])){
                    $data=array(
                        "engine_id"=>$this->input->post('engine'),
                        "assembly_id"=>$this->input->post('assembly'),
                        "item_id"=>$this->input->post('item'.$y),
                        "bank_id"=>$bank[$x],
                        "plate_no"=>$plate,
                        "qty"=>$qty[$x],
                        "remarks"=>$this->input->post('remarks'.$y),
                        "inspected"=>$this->input->post('inspected'.$y),
                        "cleaned"=>$this->input->post('cleaned'.$y),
                        "status"=>$this->input->post('status'.$y),
                        "location"=>$this->input->post('location'.$y),
                        "create_date"=>$now,
                        "user_id"=>$this->input->post('userid')
                    );
                    $this->super_model->insert_into("assembly_inventory", $data);
                   // }
                
            }
        }

        echo "<script>alert('Beginning balance has been set.'); window.location = '".base_url()."index.php/assembly/engview_list/".$engine."'</script>";
    }

     public function update_inventory(){
        $now=date('Y-m-d H:i:s');
        $item_counter = $this->input->post('counter_item');
        $bank_counter = $this->input->post('counter');
        $engine=$this->input->post('engine');
        $assembly=$this->input->post('assembly');
        for($y=0;$y<=$item_counter;$y++){
            $qty = $this->input->post('qty'.$y);
            $bank = $this->input->post('bank'.$y);
            $item=$this->input->post('item'.$y);
            for($x=0;$x<$bank_counter;$x++){
            $plate = $this->input->post('plate'.$x);
               
                   // echo $this->input->post('item'.$y) . " - ". $qty[$x]. " - " . $bank[$x]  . $plate . "<br>";

               $count= $this->super_model->count_custom_where("assembly_inventory","engine_id = '$engine' AND assembly_id = '$assembly' AND item_id = '$item' AND bank_id = '$bank[$x]'");

              // echo "engine_id = ".$engine. " AND assembly_id = ". $assembly ." AND item_id = ". $item . " AND bank_id = ". $bank[$x] . "<br>";
                   if($count==0){
                        if(!empty($qty[$x])){
                            $data=array(
                                "engine_id"=>$engine,
                                "assembly_id"=>$assembly,
                                "item_id"=>$item,
                                "bank_id"=>$bank[$x],
                                "plate_no"=>$plate,
                                "qty"=>$qty[$x],
                                "remarks"=>$this->input->post('remarks'.$y),
                                "inspected"=>$this->input->post('inspected'.$y),
                                "cleaned"=>$this->input->post('cleaned'.$y),
                                "status"=>$this->input->post('status'.$y),
                                "location"=>$this->input->post('location'.$y),
                                "create_date"=>$now,
                                "user_id"=>$this->input->post('userid')
                            );
                            $this->super_model->insert_into("assembly_inventory", $data);
                        }
                    } else {
                        if(!empty($qty[$x])){
                            $data=array(
                                "plate_no"=>$plate,
                                "qty"=>$qty[$x],
                                "remarks"=>$this->input->post('remarks'.$y),
                                "inspected"=>$this->input->post('inspected'.$y),
                                "cleaned"=>$this->input->post('cleaned'.$y),
                                "status"=>$this->input->post('status'.$y),
                                "location"=>$this->input->post('location'.$y),
                                "create_date"=>$now,
                                "user_id"=>$this->input->post('userid')
                            );
                            $this->super_model->update_custom_where("assembly_inventory", $data,"engine_id = '$engine' AND assembly_id = '$assembly' AND item_id = '$item' AND bank_id = '$bank[$x]'");
                        }
                    }
                
            }
        }

          echo "<script>alert('Beginning balance has been updated.'); window.location = '".base_url()."index.php/assembly/engview_list/".$engine."'</script>";
    }

    public function insert_issue(){
       $now=date('Y-m-d H:i:s');

       if($this->input->post('location')=='4'){
            $data = array(
                'transfer_date'=>$this->input->post('transfer_date'),
                'transfer_to'=>$this->input->post('location'),
                'engine_to'=>$this->input->post('engine_to'),
                'assembly_to'=>$this->input->post('assembly_to'),
                'department_id'=>$this->input->post('department'),
                'purpose_id'=>$this->input->post('purpose'),
                'enduse_id'=>$this->input->post('enduse'),
                'create_date'=>$now,
                'user_id'=>$this->input->post('userid'),

            );
        } else {
            $data = array(
                'transfer_date'=>$this->input->post('transfer_date'),
                'transfer_to'=>$this->input->post('location'),
                'department_id'=>$this->input->post('department'),
                'purpose_id'=>$this->input->post('purpose'),
                'enduse_id'=>$this->input->post('enduse'),
                'create_date'=>$now,
                'user_id'=>$this->input->post('userid'),

            );
        }

        if($this->super_model->insert_into("assembly_issuance_head", $data)){
            $id=$this->super_model->get_max("assembly_issuance_head", "issuance_id");
        
           echo "<script>window.location ='".base_url()."index.php/assembly/transfer_form/".$id."'</script>";
         }
    }


    public function transfer_form(){
        $id = $this->uri->segment(3);
        $engine = $this->uri->segment(4);
        $assembly = $this->uri->segment(5);
        $data['engine'] = $engine;
        $data['engine_name'] = $this->super_model->select_column_where("assembly_engine","engine_name", "engine_id", $engine);
        $data['assembly'] = $assembly;
        $data['assembly_name'] = $this->super_model->select_column_where("assembly_head","assembly_name", "assembly_id", $assembly);
        $data['id'] = $id;
        foreach($this->super_model->select_row_where("assembly_issuance_head", "issuance_id", $id) AS $i){
            $data['info'][] = array(
                "location"=>$this->super_model->select_column_where("assembly_location","location_name", "al_id", $i->transfer_to),
                "location_id"=>$i->transfer_to,
                "department"=>$this->super_model->select_column_where("department","department_name", "department_id", $i->department_id),
                "purpose"=>$this->super_model->select_column_where("purpose","purpose_desc", "purpose_id", $i->purpose_id),
                "enduse"=>$this->super_model->select_column_where("enduse","enduse_name", "enduse_id", $i->enduse_id),
                "engine_to"=>$this->super_model->select_column_where("assembly_engine","engine_name", "engine_id", $i->engine_to),
                "assembly_to"=>$this->super_model->select_column_where("assembly_head","assembly_name", "assembly_id", $i->assembly_to),
                "engine_id"=>$i->engine_to,
                "assembly_id"=>$i->assembly_to
            );
             $data['engine_all'] = $this->super_model->select_custom_where("assembly_engine","engine_id!= '$i->engine_to'");
        }
       
        $count = $this->super_model->count_custom_where("assembly_inventory", "engine_id = '$engine' AND assembly_id = '$assembly'");
        if($count!=0){
            foreach($this->super_model->select_custom_where("assembly_inventory", "engine_id = '$engine' AND assembly_id = '$assembly' ORDER BY item_id, bank_id ASC") AS $inv){
                $data['inventory'][] = array(
                    "inventory_id"=>$inv->ass_inv_id,
                    "item_id"=>$inv->item_id,
                    "item_name"=>$this->super_model->select_column_where("items","item_name", "item_id", $inv->item_id),
                    "bank_id"=>$inv->bank_id,
                    "bank_name"=>$this->super_model->select_column_where("assembly_bank","bank_name", "bank_id", $inv->bank_id),
                    "plate_no"=>$inv->plate_no,
                    "qty"=>$inv->qty
                );
            }
        } else {
            $data['inventory']=array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/transfer_form', $data);
        $this->load->view('template/footer');
    }

      public function getAssembly(){
      
        $engine = $this->input->post('engine');

        echo '<option value="">Select Assembly</option>';
        foreach($this->super_model->select_row_where('assembly_head', 'engine_id', $engine) AS $row){
            echo '<option value="'. $row->assembly_id .'">'. $row->assembly_name .'</option>';
      
         }
    }


    public function banklist(){
        $bank=$this->input->post('bank');
        $engine=$this->input->post('engine');
        $assembly=$this->input->post('assembly');
        $count=$this->input->post('count');
      //  echo $engine . " - " . $assembly;
    
      /*  $rows = $this->super_model->count_join_where("assembly_inventory","assembly_bank", "engine_id='$engine' AND assembly_id = '$assembly'","bank_id");
        echo "SELECT ai.bank_id, ab.bank_name, ai.plate_no FROM assembly_inventory ai INNER JOIN assembly_bank ab ON ai.bank_id = ab.bank_id WHERE ab.bank_name LIKE '%$bank%' AND ai.engine_id='$engine' AND ai.assembly_id = '$assembly' GROUP BY ai.bank_id";*/
        $rows = $this->super_model->count_custom_where("assembly_bank", "bank_name LIKE '%$bank%'");
        if($rows!=0){
          echo "<ul id='name-item'>";
          /*  foreach($this->super_model->custom_query("SELECT ai.bank_id, ab.bank_name, ai.plate_no FROM assembly_inventory ai INNER JOIN assembly_bank ab ON ai.bank_id = ab.bank_id WHERE ab.bank_name LIKE '%$bank%' AND ai.engine_id='$engine' AND ai.assembly_id = '$assembly' GROUP BY ai.bank_id") AS $bk){*/
            foreach($this->super_model->select_custom_where("assembly_bank", "bank_name LIKE '%$bank%'") AS $bk){
      
                    ?>
                   <li onClick="selectBank('<?php echo $bk->bank_id; ?>','<?php echo $bk->bank_name; ?>','<?php echo $count; ?>')"><?php echo $bk->bank_name; ?></li> 
                <?php 

            }
            echo "<ul>";
  
          
        }
    }

    public function insert_issue_details(){
        $issuance_id = $this->input->post('id');
        $counter = $this->input->post('counter');
        $enginefrom= $this->input->post('engine_from');
        $assemfrom = $this->input->post('assembly_from');
        
        $location_id= $this->input->post('location_id');
        $now = date('Y-m-d H:i:s');
        $userid = $this->input->post('userid');
       
        $data = array(
            'engine_from'=>$this->input->post('engine_from'),
            'assembly_from'=>$this->input->post('assembly_from')

        );
        if($this->super_model->update_where("assembly_issuance_head", $data, "issuance_id", $issuance_id)){
            
            for($a=1;$a<=$counter;$a++){
                $qty = $this->input->post('trans_qty'.$a);
                $itemfrom = $this->input->post('item_from'.$a);
                $bankfrom = $this->input->post('bank_from'.$a);
                if($this->input->post('trans_bank_id'.$a)!=NULL){
                    $bankto = $this->input->post('trans_bank_id'.$a);
                } else {
                    $bankto = 0;
                }

                 if($this->input->post('location_to'.$a)!=NULL){
                    $locationto = $this->input->post('location_to'.$a);
                } else {
                    $locationto = '';
                }

                if(!empty($qty) || $qty !=0){
                    $details = array(
                        'issuance_id'=>$issuance_id,
                        'item_id'=>$itemfrom,
                        'bank_from'=>$bankfrom, 
                        'transfer_qty'=>$qty,
                        'bank_to'=>$bankto,
                        'location_to'=>$locationto,
                    );

                    $this->super_model->insert_into("assembly_issuance_detail", $details);

                 

                    $old_qty = $this->super_model->select_column_custom_where("assembly_inventory", "qty", "engine_id = '$enginefrom' AND assembly_id = '$assemfrom' AND item_id = '$itemfrom' AND bank_id ='$bankfrom'");
                    $newqty = $old_qty - $qty;

                    $quantity = array(
                        'qty'=>$newqty
                    );
                    $this->super_model->update_custom_where("assembly_inventory", $quantity, "engine_id = '$enginefrom' AND assembly_id = '$assemfrom' AND item_id = '$itemfrom' AND bank_id ='$bankfrom'");

                    if($location_id == '4'){
                        $engineto= $this->input->post('engine_to');
                        $assemto = $this->input->post('assembly_to');

                        $count_item = $this->super_model->count_custom_where("assembly_details","engine_id = '$engineto' AND assembly_id = '$assemto' AND item_id = '$itemfrom'");
                        if($count_item==0){
                            $item_det = array(
                                'engine_id'=>$engineto,
                                'assembly_id'=>$assemto,
                                'item_id'=>$itemfrom
                            );
                            $this->super_model->insert_into("assembly_details", $item_det);
                        }

                        $count_exist = $this->super_model->count_custom_where("assembly_inventory","engine_id = '$engineto' AND assembly_id = '$assemto' AND item_id = '$itemfrom' AND bank_id ='$bankto'");
                        if($count_exist == 0){

                            $inv_details = array(
                                'engine_id'=>$engineto,
                                'assembly_id'=>$assemto,
                                'item_id'=>$itemfrom,
                                'bank_id'=>$bankto,
                                'qty'=>$qty,
                                'create_date'=>$now,
                                'user_id'=>$userid
                            );
                            $this->super_model->insert_into("assembly_inventory", $inv_details);

                        } else {
                            $old_qty_to = $this->super_model->select_column_custom_where("assembly_inventory", "qty", "engine_id = '$engineto' AND assembly_id = '$assemto' AND item_id = '$itemfrom' AND bank_id ='$bankto'");
                            $new_qty_to = $old_qty_to + $qty;

                            $new_qty = array(
                                'qty'=>$new_qty_to
                            );

                            $this->super_model->update_custom_where("assembly_inventory", $new_qty, "engine_id = '$engineto' AND assembly_id = '$assemto' AND item_id = '$itemfrom' AND bank_id ='$bankto'");
                        }
                    }
                }
            }
            
         }
         echo "<script>window.location ='".base_url()."index.php/assembly/assem_transfer_list'</script>";
    }

    public function assem_receive_list(){
        $rows = $this->super_model->count_rows("assembly_receive_head");
        if($rows!=0){
            foreach($this->super_model->custom_query("SELECT * FROM assembly_receive_head ORDER BY receive_date DESC") AS $in){
                 $data['info'][] = array(
                    "id"=>$in->ass_rec_id,
                    "engine_name"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $in->engine_id),
                    "assembly_name"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $in->assembly_id),
                    "receive_date"=>$in->receive_date,
                    "receipt_no"=>$in->receipt_no
                 );
            }
        } else {
            $data['info'] =array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/assem_receive_list',$data);
        $this->load->view('template/footer');
    }

    public function assem_transfer_list(){
        $rows = $this->super_model->count_rows("assembly_issuance_head");
        if($rows!=0){
            foreach($this->super_model->custom_query("SELECT * FROM assembly_issuance_head ORDER BY transfer_date DESC") AS $in){
                $item_id = $this->super_model->select_column_where("assembly_issuance_detail", "item_id", "issuance_id", $in->issuance_id);
                $qty = $this->super_model->select_column_where("assembly_issuance_detail", "transfer_qty", "issuance_id", $in->issuance_id);
                $item = $this->super_model->select_column_where("items", "item_name", "item_id", $item_id);
                $data['info'][] = array(
                    "id"=>$in->issuance_id,
                    "transfer_date"=>$in->transfer_date,
                    "engine_from"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $in->engine_from),
                    "assembly_from"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $in->assembly_from),
                    "engine_to"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $in->engine_to),
                    "transfer_to"=>$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $in->transfer_to),
                    "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $in->department_id),
                    "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $in->purpose_id),
                    "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $in->enduse_id),
                    "item"=>$item,
                    "qty"=>$qty
                );
            }
        } else {
            $data['info'] =array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/assem_transfer_list', $data);
        $this->load->view('template/footer');
    }

    public function assem_transfer_view(){
        $id = $this->uri->segment(3);
        foreach($this->super_model->custom_query("SELECT * FROM assembly_issuance_head WHERE issuance_id = '$id' ORDER BY transfer_date DESC") AS $in){
                $data['head'][] = array(
                    "id"=>$in->issuance_id,
                    "transfer_date"=>$in->transfer_date,
                    "transfer_id"=>$in->transfer_to,
                    "transfer_to"=>$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $in->transfer_to),
                    "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $in->department_id),
                    "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $in->purpose_id),
                    "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $in->enduse_id),
                    "engine_to"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $in->engine_to),
                    "assembly_to"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $in->assembly_to),
                    "engine_from"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $in->engine_from),
                    "assembly_from"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $in->assembly_from),
                 );
        }
        $rows = $this->super_model->select_count("assembly_issuance_detail", "issuance_id", $id);
        if($rows!=0){
            foreach($this->super_model->custom_query("SELECT * FROM assembly_issuance_detail WHERE issuance_id = '$id'") AS $det){
                    $data['details'][] = array(
                        "aii_id"=>$det->aii_id,
                        "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $det->item_id),
                        "bank_from"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_from),
                        "transfer_qty"=>$det->transfer_qty,
                        "bank_to"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_to),
                        "location_to"=>$det->location_to,
                     );
            }
        } else {
            $data['details']=array();
        }


        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/assem_transfer_view',$data);
        $this->load->view('template/footer');
    }

    public function insert_receive_head(){

        $count= $this->super_model->count_rows("assembly_receive_head");
        if($count==0){
            $ass_rec_id = 1;
        } else {
            $max=$this->super_model->get_max("assembly_receive_head", "ass_rec_id");
            $ass_rec_id = $max+1;
        }
        $now = date('Y-m-d H:i:s');
        $month = date('Y-m');

        $count_receipt = $this->super_model->count_custom_where("assembly_receive_head","receipt_no LIKE '$month%'");
        if($count_receipt==0){
            $receipt_no = $month."-0001";
        } else {
            $max = $this->super_model->get_max_where("assembly_receive_head", "receipt_no","receipt_no LIKE '$month%'");
            $rec = explode('-',$max);
            $series = $rec[2]+1;
            $receipt_no = $month."-000".$series;
        }
        $data = array(
            'ass_rec_id'=>$ass_rec_id,
            'receive_date'=>$this->input->post('receive_date'),
            'receipt_no'=>$receipt_no,
            'engine_id'=>$this->input->post('engine'),
            'assembly_id'=>$this->input->post('assembly'),
            'user_id'=>$this->input->post('userid'),
            'create_date'=>$now
        );

        if($this->super_model->insert_into("assembly_receive_head", $data)){
               echo "<script>window.location ='".base_url()."index.php/assembly/asrec_form/".$ass_rec_id."'</script>";
        }
    }


   /* public function asrec_form(){
        $id = $this->uri->segment(3);
        $data['id'] = $id;
        $data['info'] = $this->super_model->select_row_where("assembly_receive_head", "ass_rec_id", $id);
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/asrec_form',$data);
        $this->load->view('template/footer');
    }*/
    public function asrec_form(){
        $id = $this->uri->segment(3);

        $engine = $this->super_model->select_column_where("assembly_receive_head", "engine_id", "ass_rec_id", $id);
        $assembly = $this->super_model->select_column_where("assembly_receive_head", "assembly_id", "ass_rec_id", $id);
       
        foreach($this->super_model->select_row_where("assembly_receive_head", "ass_rec_id", $id) AS $in){
             $data['info'][] = array(
                "engine_name"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $in->engine_id),
                "assembly_name"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $in->assembly_id),
                "receive_date"=>$in->receive_date,
                "receipt_no"=>$in->receipt_no
             );
        }
        $data['id'] = $id;
        $data['engine'] = $engine;

        $data['assembly'] = $assembly;
        foreach($this->super_model->select_custom_where("assembly_inventory", "engine_id = '$engine' AND assembly_id = '$assembly'") AS $inv){

            $exp_qty = $this->super_model->select_column_custom_where("assembly_details", "qty", "engine_id = '$engine' AND assembly_id = '$assembly' AND item_id = '$inv->item_id'");

            if($inv->qty < $exp_qty){
                $unit_id = $this->super_model->select_column_where("items", "unit_id", "item_id", $inv->item_id);
                $uom = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $unit_id);
                $data['items'][] = array(
                    "inv_id"=>$inv->ass_inv_id,
                    "item_id"=>$inv->item_id,
                    "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $inv->item_id),
                    "pn_no"=>$this->super_model->select_column_where("items", "original_pn", "item_id", $inv->item_id),
                    "unit_id"=>$unit_id,
                    "uom"=>$uom,
                    "bank_id"=>$inv->bank_id,
                    "bank_name"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $inv->bank_id),
                    "exp_qty"=>$exp_qty,
                    "curr_qty"=>$inv->qty,
                );
            }
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/asrec_form', $data);
        $this->load->view('template/footer');
    }

     public function asrec_form_view(){
        $id = $this->uri->segment(3);

        $engine = $this->super_model->select_column_where("assembly_receive_head", "engine_id", "ass_rec_id", $id);
        $assembly = $this->super_model->select_column_where("assembly_receive_head", "assembly_id", "ass_rec_id", $id);
       
        foreach($this->super_model->select_row_where("assembly_receive_head", "ass_rec_id", $id) AS $in){
             $data['info'][] = array(
                "engine_name"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $in->engine_id),
                "assembly_name"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $in->assembly_id),
                "receive_date"=>$in->receive_date,
                "receipt_no"=>$in->receipt_no
             );
        }
        $data['id'] = $id;
        $data['engine'] = $engine;

        $data['assembly'] = $assembly;
        $rows = $this->super_model->count_rows_where("assembly_receive_details","ass_rec_id",$id);
        if($rows!=0){
            foreach($this->super_model->select_custom_where("assembly_receive_details", "ass_rec_id = '$id'") AS $inv){

                    $item_id=$this->super_model->select_column_where("assembly_inventory", "item_id", "ass_inv_id", $inv->ass_inv_id);
                    $bank_id=$this->super_model->select_column_where("assembly_inventory", "bank_id", "ass_inv_id", $inv->ass_inv_id);
                    $unit_id = $this->super_model->select_column_where("items", "unit_id", "item_id", $item_id);
                    $uom = $this->super_model->select_column_where("uom", "unit_name", "unit_id", $unit_id);
                    $data['items'][] = array(
                        "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $item_id),
                        "pn_no"=>$this->super_model->select_column_where("items", "original_pn", "item_id", $item_id),
                        "unit_id"=>$unit_id,
                        "uom"=>$uom,
                        "bank_name"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $bank_id),
                        "rec_qty"=>$inv->received_qty,
                    );
                
            }
        } else {
            $data['items'] = array();
        }
        $this->load->view('template/header');
        $this->load->view('template/sidebar',$this->dropdown);
        $this->load->view('assembly/asrec_form_view', $data);
        $this->load->view('template/footer');
    }

    public function receive_details(){
        $count = $this->input->post('count');
        for($y=1; $y<=$count;$y++){
            $qty = $this->input->post('rec_qty'.$y);
            if(!empty($qty)){
                $invid=$this->input->post('inventory_id'.$y);
                $data = array(
                    "ass_rec_id"=>$this->input->post('id'),
                    "ass_inv_id"=>$this->input->post('inventory_id'.$y),
                    "received_qty"=>$qty
                );

                $old_qty = $this->super_model->select_column_where("assembly_inventory", "qty", "ass_inv_id", $invid);

                if($this->super_model->insert_into("assembly_receive_details", $data)){
                    $new_qty = $old_qty+$qty;
                    $update = array(
                        "qty"=>$new_qty
                    );

                    //echo "UPDATE assembly_inventory SET qty = '$new_qty' WHERE ass_inv_id = '$invid'<br>";
                    $this->super_model->update_where("assembly_inventory", $update, "ass_inv_id", $this->input->post('inventory_id'.$y));
                }
            }
        }


           echo "<script>alert('Received successfully!'); window.location ='".base_url()."index.php/assembly/assem_receive_list/'</script>";
    }


    public function issue_report(){

        foreach($this->super_model->custom_query("SELECT ih.*, id.* FROM assembly_issuance_head ih INNER JOIN assembly_issuance_detail id ON ih.issuance_id = id.issuance_id ORDER BY ih.transfer_date DESC") AS $det){
            $data['info'][] = array(
                "issuance_id"=>$det->issuance_id,
                "transfer_date"=>$det->transfer_date,
                "transfer_to"=>$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $det->transfer_to),
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $det->department_id),
                 "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $det->purpose_id),
                "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $det->enduse_id),
                "engine_to"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_to),
                "assembly_to"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_to),
                "engine_from"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_from),
                "assembly_from"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_from),
                 "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $det->item_id),
                "bank_from"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_from),
                "transfer_qty"=>$det->transfer_qty,
                "bank_to"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_to),
            );
        }
        $data['location']=$this->super_model->select_all_order_by("assembly_location", "location_name", "ASC");
        $data['engine']=$this->super_model->select_all_order_by("assembly_engine", "engine_name", "ASC");
        $data['assembly']=$this->super_model->select_all_group("assembly_head","assembly_name");
        $this->load->view('template/header');
        $this->load->view('template/topbar');
        $this->load->view('assembly/issue_report',$data);
        $this->load->view('template/footer');
    }

    public function receive_report(){

        foreach($this->super_model->custom_query("SELECT ih.*, id.* FROM assembly_issuance_head ih INNER JOIN assembly_issuance_detail id ON ih.issuance_id = id.issuance_id ORDER BY ih.transfer_date DESC") AS $det){
            $data['info'][] = array(
                "issuance_id"=>$det->issuance_id,
                "transfer_date"=>$det->transfer_date,
                "transfer_to"=>$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $det->transfer_to),
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $det->department_id),
                 "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $det->purpose_id),
                "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $det->enduse_id),
                "engine_to"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_to),
                "assembly_to"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_to),
                "engine_from"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_from),
                "assembly_from"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_from),
                 "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $det->item_id),
                "bank_from"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_from),
                "transfer_qty"=>$det->transfer_qty,
                "bank_to"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_to),
            );
        }
        $data['location']=$this->super_model->select_all_order_by("assembly_location", "location_name", "ASC");
        $data['engine']=$this->super_model->select_all_order_by("assembly_engine", "engine_name", "ASC");
        $data['assembly']=$this->super_model->select_all_group("assembly_head","assembly_name");
        $this->load->view('template/header');
        $this->load->view('template/topbar');
        $this->load->view('assembly/issue_report',$data);
        $this->load->view('template/footer');
    }

    public function filter_receive(){
         $where='';
         $filter='';
         $itemname=$this->super_model->select_column_where("items", "item_name", "item_id", $this->input->post('item_id'));
         $engine=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $this->input->post('engine'));
         $assembly=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $this->input->post('assembly'));

        if(!empty($this->input->post('from'))){
            $data['from'] = $this->input->post('from');
        } else {
            $data['from']= "null";
        }

        if(!empty($this->input->post('to'))){
            $data['to'] = $this->input->post('to');
        } else {
            $data['to'] = "null";
        }

        if(!empty($this->input->post('item_id'))){
            $data['item_id'] = $this->input->post('item_id');
        }else {
            $data['item_id'] ='null';
        }

        if(!empty($this->input->post('engine'))){
            $data['engine'] = $this->input->post('engine');
        }else {
            $data['engine'] ='null';
        }

        if(!empty($this->input->post('assembly'))){
            $data['assembly'] = $this->input->post('assembly');
        }else {
            $data['assembly'] ='null';
        }


         if(!empty($this->input->post('from')) && !empty($this->input->post('to'))){
            /*$date = $this->input->post('receive_date');
            $where.=" rh.receive_date = '$date' AND";
            $filter.=" Receive date: ". $date . ", ";*/
            $from = $this->input->post('from');
            $to = $this->input->post('to');
            $where.= " rh.receive_date BETWEEN '$from' AND '$to' AND";
            $filter .= "Issue Date - ".$from.' <strong>To</strong> '.$to.", ";
         }
         if(!empty($this->input->post('item_id'))){
            $item=$this->input->post('item_id');
             $where.=" ai.item_id = '$item' AND";
             $filter.=" Item: ". $itemname . ", ";
         }
         if(!empty($this->input->post('engine'))){
            $engine=$this->input->post('engine');
            $where.=" rh.engine_id = '$engine' AND";
            $filter.=" Engine: ". $engine . ", ";
         }
         if(!empty($this->input->post('assembly'))){
            $assembly=$this->input->post('assembly');
             $where.=" rh.assembly_id = '$assembly' AND";
             $filter.=" Assembly: ". $assembly . ", ";
         }

         $filter = substr($filter, 0, -2);
         
         $data['filter']=$filter;
         $whr = substr($where, 0, -4);
         $count = $this->super_model->count_custom_query("SELECT rh.*, rd.* FROM assembly_receive_head rh INNER JOIN  assembly_receive_details rd ON rh.ass_rec_id = rd.ass_rec_id INNER JOIN assembly_inventory ai ON rd.ass_inv_id = ai.ass_inv_id WHERE ".$whr);

         if($count!=0){
         foreach($this->super_model->custom_query("SELECT rh.*, rd.* FROM assembly_receive_head rh INNER JOIN  assembly_receive_details rd ON rh.ass_rec_id = rd.ass_rec_id INNER JOIN assembly_inventory ai ON rd.ass_inv_id = ai.ass_inv_id WHERE ".$whr) AS $det){
            $item_id = $this->super_model->select_column_where("assembly_inventory", "item_id", "ass_inv_id", $det->ass_inv_id);
            $bank_id = $this->super_model->select_column_where("assembly_inventory", "bank_id", "ass_inv_id", $det->ass_inv_id);
               $data['info'][] = array(
                "receive_id"=>$det->ass_rec_id,
                "receive_date"=>$det->receive_date,
                "receipt_no"=>$det->receipt_no,
                "engine"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_id),
                "assembly"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_id),
                "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $item_id),
                "bank"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $bank_id),
                "received_qty"=>$det->received_qty,
            );
         }
        } else {
            $data['info'] = array();
        }
        $this->load->view('template/header');
        $this->load->view('template/topbar');
        $this->load->view('assembly/receive_report',$data);
        $this->load->view('template/footer');
         //echo $sql;
    }

    public function filter_issue(){
         $where='';
         $filter='';
         $itemname=$this->super_model->select_column_where("items", "item_name", "item_id", $this->input->post('item_id'));
         $transfer_to=$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $this->input->post('transfer_to'));
         $engine_from=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $this->input->post('engine_from'));
         $assembly_from=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $this->input->post('assembly_from'));
         $engine_to=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $this->input->post('engine_to'));
         $assembly_to=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $this->input->post('assembly_to'));

        /*if(!empty($this->input->post('issue_date'))){
            $data['date_issued'] = $this->input->post('issue_date');
        }else { 
            $data['date_issued']='null';
        }*/

        if(!empty($this->input->post('from'))){
            $data['from'] = $this->input->post('from');
        } else {
            $data['from']= "null";
        }

        if(!empty($this->input->post('to'))){
            $data['to'] = $this->input->post('to');
        } else {
            $data['to'] = "null";
        }

        if(!empty($this->input->post('item_id'))){
            $data['item_id'] = $this->input->post('item_id');
        }else {
            $data['item_id'] ='null';
        }

        if(!empty($this->input->post('transfer_to'))){
            $data['transfer_to'] = $this->input->post('transfer_to');
        }else {
            $data['transfer_to'] ='null';
        }

        if(!empty($this->input->post('engine_to'))){
            $data['engine_to'] = $this->input->post('engine_to');
        }else{
            $data['engine_to'] = 'null';
        }

        if(!empty($this->input->post('engine_from'))){
            $data['engine_from'] = $this->input->post('engine_from');
        }else {
            $data['engine_from'] = 'null';
        }

        if(!empty($this->input->post('assembly_from'))){
            $data['assembly_from'] = $this->input->post('assembly_from');
        }else {
            $data['assembly_from'] = 'null';
        }

        if(!empty($this->input->post('assembly_to'))){
            $data['assembly_to'] = $this->input->post('assembly_to');
        }else {
            $data['assembly_to'] = 'null';
        }


         /*if(!empty($this->input->post('issue_date'))){
            $date = $this->input->post('issue_date');
            $where.=" ih.transfer_date = '$date' AND";
            $filter.=" Issue date: ". $date . ", ";
         }*/

        if(!empty($this->input->post('from')) && !empty($this->input->post('to'))){
            $from = $this->input->post('from');
            $to = $this->input->post('to');
            $where.= " ih.transfer_date BETWEEN '$from' AND '$to' AND";
            $filter .= "Issue Date - ".$from.' <strong>To</strong> '.$to.", ";
        }

         if(!empty($this->input->post('item_id'))){
            $item=$this->input->post('item_id');
             $where.=" id.item_id = '$item' AND";
             $filter.=" Item Name: ". $itemname . ", ";
         }
         if(!empty($this->input->post('transfer_to'))){
            $transfer_to=$this->input->post('transfer_to');
             $where.=" ih.transfer_to = '$transfer_to' AND";
             $filter.=" Transfer to: ". $transfer_to . ", ";
         }
         if(!empty($this->input->post('engine_from'))){
            $engine_from=$this->input->post('engine_from');
             $where.=" ih.engine_from = '$engine_from' AND";
             $filter.=" Engine (from): ". $engine_from . ", ";
         }
         if(!empty($this->input->post('assembly_from'))){
            $assembly_from=$this->input->post('assembly_from');
             $where.=" ih.assembly_from = '$assembly_from' AND";
             $filter.=" Assembly (from): ". $assembly_from . ", ";
         }
         if(!empty($this->input->post('engine_to'))){
            $engine_to=$this->input->post('engine_to');
             $where.=" ih.engine_to = '$engine_to' AND";
             $filter.=" Engine (to): ". $engine_to . ", ";
         }
         if(!empty($this->input->post('assembly_to'))){
            $assembly_to=$this->input->post('assembly_to');
             $where.=" ih.assembly_to = '$assembly_to' AND";
             $filter.=" Assembly (to): ". $assembly_to . ", ";
         }
         $filter = substr($filter, 0, -2);
         $data['filter']=$filter;
         $whr = substr($where, 0, -4);
         $count = $this->super_model->count_custom_query("SELECT ih.*, id.* FROM assembly_issuance_head ih INNER JOIN  assembly_issuance_detail id ON ih.issuance_id = id.issuance_id WHERE ".$whr);
         if($count!=0){
         foreach($this->super_model->custom_query("SELECT ih.*, id.* FROM assembly_issuance_head ih INNER JOIN  assembly_issuance_detail id ON ih.issuance_id = id.issuance_id WHERE ".$whr) AS $det){
               $data['info'][] = array(
                "issuance_id"=>$det->issuance_id,
                "transfer_date"=>$det->transfer_date,
                "transfer_to"=>$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $det->transfer_to),
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $det->department_id),
                 "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $det->purpose_id),
                "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $det->enduse_id),
                "engine_to"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_to),
                "assembly_to"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_to),
                "engine_from"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_from),
                "assembly_from"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_from),
                 "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $det->item_id),
                "bank_from"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_from),
                "transfer_qty"=>$det->transfer_qty,
                "bank_to"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_to),
            );
         }
     } else {
        $data['info'] = array();
     }
        $this->load->view('template/header');
        $this->load->view('template/topbar');
        $this->load->view('assembly/issue_report',$data);
        $this->load->view('template/footer');
         //echo $sql;
    }

    public function export_receive(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $item=$this->uri->segment(5);
        $engine=$this->uri->segment(6);
        $assembly=$this->uri->segment(7);
        

        $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " rh.receive_date BETWEEN '$from' AND '$to' AND";
        }

        if($item!='null'){
            $sql.= " ai.item_id = '$item' AND";
        }

        if($engine!='null'){
            $sql.= " rh.engine_id = '$engine' AND";
        }

        if($assembly!='null'){
            $sql.= " rh.assembly_id = '$assembly' AND";
        }

        $query=substr($sql,0,-3);
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Assembly Receive.xlsx";

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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', "Receive Date");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7', "Receipt No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', "Engine");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H7', "Assembly");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J7', "Bank");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K7', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q7', "Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PROGEN DIESEL TECH");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "TO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "FROM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K2', "ASSEMBLY RECEIVE");
        $num=8;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5',$from);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', $to);
        $x = 1;
        if($from!='' && $to!='' && $item!='' && $engine!='' && $assembly!=''){
            foreach($this->super_model->custom_query("SELECT rh.*, rd.* FROM assembly_receive_head rh INNER JOIN assembly_receive_details rd ON rh.ass_rec_id = rd.ass_rec_id AND ".$query."ORDER BY rh.receive_date DESC") AS $det){
                $item_id = $this->super_model->select_column_where("assembly_inventory", "item_id", "ass_inv_id", $det->ass_inv_id);
                $bank_id = $this->super_model->select_column_where("assembly_inventory", "bank_id", "ass_inv_id", $det->ass_inv_id);
                $receive_id=$det->ass_rec_id;
                $receive_date=$det->receive_date;
                $receipt_no=$det->receipt_no;
                $engine=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_id);
                $assembly=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_id);
                $item_name=$this->super_model->select_column_where("items", "item_name", "item_id", $item_id);
                $bank=$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $bank_id);
                $received_qty=$det->received_qty;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $receive_date);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $receipt_no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $engine);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $assembly); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $bank); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $item_name); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$num, $received_qty);

                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Q".$num,'admin');

                $num++;
                $x++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('D8:E8');
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F8:G8');
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H8:I8');
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('K8:P8');
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$num.":P".$num);
                $objPHPExcel->getActiveSheet()->getStyle('L8:N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":N".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('Q'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }else {
            foreach($this->super_model->custom_query("SELECT rh.*, rd.* FROM assembly_receive_head rh INNER JOIN assembly_receive_details rd ON rh.ass_rec_id = rd.ass_rec_id ORDER BY rh.receive_date DESC") AS $det){
                $item_id = $this->super_model->select_column_where("assembly_inventory", "item_id", "ass_inv_id", $det->ass_inv_id);
                $bank_id = $this->super_model->select_column_where("assembly_inventory", "bank_id", "ass_inv_id", $det->ass_inv_id);
                $receive_id=$det->ass_rec_id;
                $receive_date=$det->receive_date;
                $receipt_no=$det->receipt_no;
                $engine=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_id);
                $assembly=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_id);
                $item_name=$this->super_model->select_column_where("items", "item_name", "item_id", $item_id);
                $bank=$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $bank_id);
                $received_qty=$det->received_qty;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $receive_date);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $receipt_no);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $engine);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $assembly); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $bank); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $item_name); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Q'.$num, $received_qty);

                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":Q".$num,'admin');

                $num++;
                $x++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('D8:E8');
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F8:G8');
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H8:I8');
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('K8:P8');
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$num.":P".$num);
                $objPHPExcel->getActiveSheet()->getStyle('L8:N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":N".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('J'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('Q'.$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
        $objPHPExcel->getActiveSheet()->mergeCells('K2:N2');
        $objPHPExcel->getActiveSheet()->mergeCells('B7:C7');
        $objPHPExcel->getActiveSheet()->mergeCells('D7:E7');
        $objPHPExcel->getActiveSheet()->mergeCells('F7:G7');
        $objPHPExcel->getActiveSheet()->mergeCells('H7:I7');
        $objPHPExcel->getActiveSheet()->mergeCells('K7:P7');
        $objPHPExcel->getActiveSheet()->mergeCells('B8:C8');
        $objPHPExcel->getActiveSheet()->getStyle('A7:Q7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:Q'.$num)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Q3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Q3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:Q1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:Q2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:Q3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Q1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Q2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('Q3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("K2")->getFont()->setBold(true)->setName('Arial Black');
        $objPHPExcel->getActiveSheet()->getStyle('K2:N2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('J8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('Q8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Assembly Receive.xlsx"');
        readfile($exportfilename);
    }

    public function export_issuance(){
        $from=$this->uri->segment(3);
        $to=$this->uri->segment(4);
        $item=$this->uri->segment(5);
        $transfer_to=$this->uri->segment(6);
        $engine_from=$this->uri->segment(7);
        $assembly_from=$this->uri->segment(8);
        $engine_to=$this->uri->segment(9);
        $assembly_to=$this->uri->segment(10);

        $sql="";
        if($from!='null' && $to!='null'){
           $sql.= " ih.transfer_date BETWEEN '$from' AND '$to' AND";
        }

        if($item!='null'){
            $sql.= " id.item_id = '$item' AND";
        }

        if($transfer_to!='null'){
            $sql.= " ih.transfer_to = '$transfer_to' AND";
        }

        if($engine_from!='null'){
            $sql.= " ih.engine_from = '$engine_from' AND";
        }

        if($assembly_from!='null'){
            $sql.= " ih.assembly_from = '$assembly_from' AND";
        }

        if($engine_to!='null'){
            $sql.= " ih.engine_to = '$engine_to' AND";
        }

        if($assembly_to!='null'){
            $sql.= " ih.assembly_to = '$assembly_to' AND";
        }

        $query=substr($sql,0,-3);
        require_once(APPPATH.'../assets/js/phpexcel/Classes/PHPExcel/IOFactory.php');
        $objPHPExcel = new PHPExcel();
        $exportfilename="Assembly Issuance.xlsx";

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
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', "No.");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B7', "Date Issued");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D7', "Transfer To");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F7', "Engine From");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H7', "Assembly From");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J7', "Bank From");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K7', "Engine To");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M7', "Assembly To");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O7', "Bank To");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P7', "Department");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R7', "Purpose");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U7', "End Use");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y7', "Item Description");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD7', "Qty");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C1', "PROGEN DIESEL TECH");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C2', "Purok San Jose, Brgy. Calumangan, Bago City");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C3', "Tel. No. 476 - 7382");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C5', "TO");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('G5', "FROM");
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('N2', "ASSEMBLY ISSUANCE");
        $num=8;
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D5',$from);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H5', $to);
        $x = 1;
        if($from!='' && $to!='' && $item!='' && $transfer_to!='' && $engine_from!='' && $assembly_from!='' && $engine_to!='' && $assembly_to!=''){
            foreach($this->super_model->custom_query("SELECT ih.*, id.* FROM assembly_issuance_head ih INNER JOIN assembly_issuance_detail id ON ih.issuance_id = id.issuance_id AND ".$query."ORDER BY ih.transfer_date DESC") AS $det){
                $issuance_id = $det->issuance_id;
                $transfer_date=$det->transfer_date;
                $transfer_to=$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $det->transfer_to);
                $department=$this->super_model->select_column_where("department", "department_name", "department_id", $det->department_id);
                $purpose=$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $det->purpose_id);
                $enduse=$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $det->enduse_id);
                $engine_to=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_to);
                $assembly_to=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_to);
                $engine_from=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_from);
                $assembly_from=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_from);
                $item_name=$this->super_model->select_column_where("items", "item_name", "item_id", $det->item_id);
                $bank_from=$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_from);
                $transfer_qty=$det->transfer_qty;
                $bank_to=$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_to);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $transfer_date);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $transfer_to);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $engine_from);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $assembly_from); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $bank_from); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $engine_to); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $assembly_to); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$num, $bank_to); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $department);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $purpose);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $enduse);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$num, $item_name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$num, $transfer_qty);

                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":AD".$num,'admin');

                $num++;
                $x++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('D8:E8');
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F8:G8');
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H8:I8');
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('K8:L8');
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$num.":L".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('M8:N8');
                $objPHPExcel->getActiveSheet()->mergeCells('M'.$num.":N".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P8:Q8');
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R8:T8');
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":T".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('U8:x8');
                $objPHPExcel->getActiveSheet()->mergeCells('U'.$num.":x".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('Y8:AC8');
                $objPHPExcel->getActiveSheet()->mergeCells('Y'.$num.":AC".$num);
                $objPHPExcel->getActiveSheet()->getStyle('L8:N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":N".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            }
        }else {
            foreach($this->super_model->custom_query("SELECT ih.*, id.* FROM assembly_issuance_head ih INNER JOIN assembly_issuance_detail id ON ih.issuance_id = id.issuance_id ORDER BY ih.transfer_date DESC") AS $det){
                $issuance_id = $det->issuance_id;
                $transfer_date=$det->transfer_date;
                $transfer_to=$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $det->transfer_to);
                $department=$this->super_model->select_column_where("department", "department_name", "department_id", $det->department_id);
                $purpose=$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $det->purpose_id);
                $enduse=$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $det->enduse_id);
                $engine_to=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_to);
                $assembly_to=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_to);
                $engine_from=$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_from);
                $assembly_from=$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_from);
                $item_name=$this->super_model->select_column_where("items", "item_name", "item_id", $det->item_id);
                $bank_from=$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_from);
                $transfer_qty=$det->transfer_qty;
                $bank_to=$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_to);

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$num, $x);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B'.$num, $transfer_date);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$num, $transfer_to);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('F'.$num, $engine_from);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$num, $assembly_from); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('J'.$num, $bank_from); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('K'.$num, $engine_to); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('M'.$num, $assembly_to); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('O'.$num, $bank_to); 
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('P'.$num, $department);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$num, $purpose);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('U'.$num, $enduse);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('Y'.$num, $item_name);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('AD'.$num, $transfer_qty);

                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);    
                $objPHPExcel->getActiveSheet()->protectCells('A'.$num.":AD".$num,'admin');

                $num++;
                $x++;
                $objPHPExcel->getActiveSheet()->mergeCells('B'.$num.":C".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('D8:E8');
                $objPHPExcel->getActiveSheet()->mergeCells('D'.$num.":E".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('F8:G8');
                $objPHPExcel->getActiveSheet()->mergeCells('F'.$num.":G".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('H8:I8');
                $objPHPExcel->getActiveSheet()->mergeCells('H'.$num.":I".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('K8:L8');
                $objPHPExcel->getActiveSheet()->mergeCells('K'.$num.":L".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('M8:N8');
                $objPHPExcel->getActiveSheet()->mergeCells('M'.$num.":N".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('P8:Q8');
                $objPHPExcel->getActiveSheet()->mergeCells('P'.$num.":Q".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('R8:T8');
                $objPHPExcel->getActiveSheet()->mergeCells('R'.$num.":T".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('U8:x8');
                $objPHPExcel->getActiveSheet()->mergeCells('U'.$num.":x".$num);
                $objPHPExcel->getActiveSheet()->mergeCells('Y8:AC8');
                $objPHPExcel->getActiveSheet()->mergeCells('Y'.$num.":AC".$num);
                $objPHPExcel->getActiveSheet()->getStyle('L8:N8')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('L'.$num.":N".$num)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
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
        $objPHPExcel->getActiveSheet()->mergeCells('N2:T2');
        $objPHPExcel->getActiveSheet()->mergeCells('B7:C7');
        $objPHPExcel->getActiveSheet()->mergeCells('D7:E7');
        $objPHPExcel->getActiveSheet()->mergeCells('F7:G7');
        $objPHPExcel->getActiveSheet()->mergeCells('H7:I7');
        $objPHPExcel->getActiveSheet()->mergeCells('K7:L7');
        $objPHPExcel->getActiveSheet()->mergeCells('M7:N7');
        $objPHPExcel->getActiveSheet()->mergeCells('P7:Q7');
        $objPHPExcel->getActiveSheet()->mergeCells('R7:T7');
        $objPHPExcel->getActiveSheet()->mergeCells('U7:X7');
        $objPHPExcel->getActiveSheet()->mergeCells('Y7:AC7');
        $objPHPExcel->getActiveSheet()->mergeCells('B8:C8');
        $objPHPExcel->getActiveSheet()->getStyle('A7:AD7')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->getActiveSheet()->getStyle('A7:AD'.$num)->applyFromArray($styleArray);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AD3')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AD2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AD3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:AD1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A2:AD2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A3:AD3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('D5:E5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H5:I5')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('C3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('H3')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AD1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AD2')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('AD3')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
        $objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H1')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('C5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('G5')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle('H2')->getFont()->setBold(true);
        $objPHPExcel->getActiveSheet()->getStyle("N2")->getFont()->setBold(true)->setName('Arial Black');
        $objPHPExcel->getActiveSheet()->getStyle('N2:T2')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        if (file_exists($exportfilename))
        unlink($exportfilename);
        $objWriter->save($exportfilename);
        unset($objPHPExcel);
        unset($objWriter);   
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Assembly Issuance.xlsx"');
        readfile($exportfilename);
    }


    /*public function filter_issue(){
         $where='';

         if(!empty($this->input->post('issue_date'))){
            $date = $this->input->post('issue_date');
            $where.=" ih.transfer_date = '$date' AND";
         }
         if(!empty($this->input->post('item_id'))){
            $item=$this->input->post('item_id');
             $where.=" id.item_id = '$item' AND";
         }
         if(!empty($this->input->post('transfer_to'))){
            $transfer_to=$this->input->post('transfer_to');
             $where.=" ih.transfer_to = '$transfer_to' AND";
         }
         if(!empty($this->input->post('engine_from'))){
            $engine_from=$this->input->post('engine_from');
             $where.=" ih.engine_from = '$engine_from' AND";
         }
         if(!empty($this->input->post('assembly_from'))){
            $assembly_from=$this->input->post('assembly_from');
             $where.=" ih.assembly_from = '$assembly_from' AND";
         }
         if(!empty($this->input->post('engine_to'))){
            $engine_to=$this->input->post('engine_to');
             $where.=" ih.engine_to = '$engine_to' AND";
         }
         if(!empty($this->input->post('assembly_to'))){
            $assembly_to=$this->input->post('assembly_to');
             $where.=" ih.assembly_to = '$assembly_to' AND";
         }
         $whr = substr($where, 0, -4);
         foreach($this->super_model->custom_query("SELECT ih.*, id.* FROM assembly_issuance_head ih INNER JOIN  assembly_issuance_detail id ON ih.issuance_id = id.issuance_id WHERE ".$whr) AS $det){
               $data['info'][] = array(
                "issuance_id"=>$det->issuance_id,
                "transfer_date"=>$det->transfer_date,
                "transfer_to"=>$this->super_model->select_column_where("assembly_location", "location_name", "al_id", $det->transfer_to),
                "department"=>$this->super_model->select_column_where("department", "department_name", "department_id", $det->department_id),
                 "purpose"=>$this->super_model->select_column_where("purpose", "purpose_desc", "purpose_id", $det->purpose_id),
                "enduse"=>$this->super_model->select_column_where("enduse", "enduse_name", "enduse_id", $det->enduse_id),
                "engine_to"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_to),
                "assembly_to"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_to),
                "engine_from"=>$this->super_model->select_column_where("assembly_engine", "engine_name", "engine_id", $det->engine_from),
                "assembly_from"=>$this->super_model->select_column_where("assembly_head", "assembly_name", "assembly_id", $det->assembly_from),
                 "item_name"=>$this->super_model->select_column_where("items", "item_name", "item_id", $det->item_id),
                "bank_from"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_from),
                "transfer_qty"=>$det->transfer_qty,
                "bank_to"=>$this->super_model->select_column_where("assembly_bank", "bank_name", "bank_id", $det->bank_to),
            );
         }
          $this->load->view('template/header');
        $this->load->view('template/topbar');
        $this->load->view('assembly/issue_report',$data);
        $this->load->view('template/footer');
         //echo $sql;
    }*/

}

?>
