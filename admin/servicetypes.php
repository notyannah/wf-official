<h1 class="h3 mb-2 text-gray-800">Service Types</h1>
<input type="button" class="btn btn-sm btn-primary mb-2" data-toggle="modal" data-target="#add" value="Add New"></input>
		
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Records</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th></th>
						<th>Type</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$items = mysql_query("select * from service_types where deleted=0 order by type");
					while($item = mysql_fetch_array($items)){
					?>
					<tr>
						<td><a href="#" data-toggle="modal" data-target="#delete" onclick="setID('<?php echo $item["id"];?>')" title="Click to delete"><span class="fas fa-trash-alt text-danger"></span></a></td>
						<td><?php echo $item["type"];?></td>
					</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="delete">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body">
					<p>Are you sure to delete this record?</p>
					<input type="hidden" id="delid" name="delid"></input>
				</div>
				<div class="modal-footer">
					<button type="submit" name="delete" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<?php
						if(isset($_POST["delete"])){
							mysql_query("update service_types set deleted=1 where id=$_POST[delid]");
							echo "<script>window.location='index.php?pg=servicetypes';</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="add">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">New Type</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body">
					<label>Type</label>
					<input type="text" name="type" class="form-control"></input>
				</div>
				<div class="modal-footer">
					<button type="submit" name="add" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<?php
						if(isset($_POST["add"])){
							$type = addslashes($_POST["type"]);
							mysql_query("insert into service_types(type) values('$type')");
							echo "<script>window.location='index.php?pg=servicetypes';</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	function setID(id){
		$("#delid").val(id);
	}
</script>