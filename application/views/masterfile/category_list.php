<script type="text/javascript">
	function viewCat(cat_id){
        window.open('<?php echo base_url(); ?>index.php/masterfile/view_cat/'+cat_id, '_blank', 'top=100px,left=400px,width=600,height=400');
    }
</script>
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">Category</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<br>
			</div>
		</div><!--/.row-->		
		
		<div class="row">
			<div class="col-md-12">
				<div class="panel panel-default shadow">
					<div class="panel-heading">
						CATEGORY LIST					
						<div class="pull-right">
							<a class="  clickable panel-toggle panel-button-tab-right shadow" title="VIEW ALL"  data-toggle="modal" data-target="#viewcat">
								<span class="fa fa-file-text-o"></span>
							</a>
							<?php if($access['masterfile_add'] == 1){ ?>
							<a class=" clickable panel-toggle panel-button-tab-right shadow"  data-toggle="modal" data-target="#addCategory">
								<span class="fa fa-plus"></span>
							</a>							
							<?php } ?>
						</div>
					</div>
					<div class="panel-body">
						<div class="canvas-wrapper">
							<table class="table table-bordered table-hover" id="item_table">
								<thead>
									<tr>
										<th>Code</th>
										<th>Category Name</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
										foreach($category AS $cat){ 
									?>
									<tr>
										<td><?php echo $cat->cat_code; ?></td>
										<td><?php echo $cat->cat_name;?></td>
										<td>
											<?php if($access['masterfile_add'] == 1){ ?>
											<a class="btn btn-sm btn-success" onClick="viewCat(<?php echo $cat->cat_id;?>)" title = "ADD"><span class="fa fa-plus"></span></a>
											<?php } 
											 if($access['masterfile_edit'] == 1){ ?>
											<a href = "<?php echo base_url(); ?>index.php/masterfile/update_category/<?php echo $cat->cat_id;?>" class = "btn btn-primary btn-sm" title="UPDATE"><span class="fa fa-pencil-square-o"></span></a>
											<?php } 
											 if($access['masterfile_delete'] == 1){ ?>
											<a  href="<?php echo base_url(); ?>index.php/masterfile/delete_category/<?php echo $cat->cat_id;?>" onclick="confirmationDelete(this);return false;" class="btn btn-danger btn-sm" title="DELETE" title="DELETE" alt='DELETE'><span class="fa fa-trash-o"></span></a>
											<?php } ?>
										</td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- MODAL -->
		<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Add New Category</h4>
					</div>
					<div class="modal-body">
						<form method="POST" action = "<?php echo base_url();?>index.php/masterfile/add_category">
							<label>Prefix</label>
							<input type = "text" name = "prefix" class = "form-control">
							<label>Category Name</label>
							<input type = "text" name = "category_name" class = "form-control">
							<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-warning">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="modal fade" id="viewcat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
			<div class="modal-dialog " role="document">
				<div class="modal-content">
					<div class="modal-header modal-headback">
						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4 class="modal-title" id="myModalLabel">Category List with Sub Category </h4>
					</div>
					<div class="modal-body">
						<table class="table table-hover table-bordered shadow" id="item_table">
							<thead>
								<tr>
									<th>Code</th>
									<th>Category Name</th>
									<th>Prefix</th>
								</tr>								
							</thead>
							<tbody>
								<?php foreach($category AS $cat){ ?>
								<tr style="background:#f9e065">
									<td><?php echo $cat->cat_code; ?></td>														
									<td><?php echo $cat->cat_name; ?></td>								
									<td><?php echo $cat->cat_prefix; ?></td>																
								</tr>
								<?php 
									foreach($subcat AS $sub){ 
								 		switch($sub){
								 			case($cat->cat_id == $sub->cat_id): 
								 ?>
					 			<tr>
									<td><?php echo $sub->subcat_code;?></td>
									<td style = "text-indent:30px;"><?php echo $sub->subcat_name;?></td>	
									<td><?php echo $sub->subcat_prefix;?></td>
								</tr>
								<?php	
							 		break;
							 		default: 
							 		} } }
						 		?>
							</tbody>
							<tfoot>
								<tr>
									<th>Code</th>
									<th>Category Name</th>
									<th>Prefix</th>
								</tr>
							</tfoot>
						</table>
					</div>
				</div>
			</div>
		</div>
