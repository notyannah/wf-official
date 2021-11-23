<h1 class="h3 mb-2 text-gray-800">Services</h1>
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
						<th>Service</th>
						<th>Type</th>
						<th>Provider</th>
						<th>Description</th>
						<th>Tags</th>
						<th>Longitude</th>
						<th>Latitude</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$items = mysql_query("select a.*, b.type, c.company from services a left join service_types b on a.typeid=b.id left join providers c on a.providerid=c.id where a.deleted=0 order by a.service");
					while($item = mysql_fetch_array($items)){
					?>
					<tr>
						<td><a href="#" data-toggle="modal" data-target="#delete" onclick="setID('<?php echo $item["id"];?>')" title="Click to delete"><span class="fas fa-trash-alt text-danger"></span></a></td>
						<td><?php echo $item["service"]; ?></td>
						<td><?php echo $item["type"]; ?></td>
						<td><?php echo $item["company"]; ?></td>
						<td><?php echo $item["description"]; ?></td>
						<td><?php echo $item["tags"]; ?></td>
						<td><?php echo $item["longitude"]; ?></td>
						<td><?php echo $item["latitude"]; ?></td>
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
							mysql_query("update services set deleted=1 where id=$_POST[delid]");
							echo "<script>window.location='index.php?pg=services';</script>";
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
				<h5 class="modal-title">New Service</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body">
					<div class="form-group">
						<label>Service</label>
						<input type="text" name="service" class="form-control" required></input>
					</div>
					<div class="form-group">
						<label>Service Type</label>
						<select name="type" class="form-control" required>
							<?php
							$items = mysql_query("select * from service_types where deleted=0 order by type");
							while($item = mysql_fetch_array($items)){
								echo "<option value='$item[id]'>$item[type]</option>";
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Service Provider</label>
						<select name="providerid" class="form-control" required>
							<?php
							$items = mysql_query("select * from providers where active=1 and deleted=0 order by company");
							while($item = mysql_fetch_array($items)){
								echo "<option value='$item[id]'>$item[company]</option>";
							}
							?>
						</select>
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea name="description" class="form-control" rows="2" required></textarea>
					</div>
					<div class="form-group">
						<label>Tags</label>
						<input type="text" name="tags" class="form-control" required></input>
					</div>
					<div class="form-group">
						<label>Longitude</label>
						<input type="text" name="longitude" class="form-control" required></input>
					</div>
					<div class="form-group">
						<label>Latitude</label>
						<input type="text" name="latitude" class="form-control" required></input>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" name="add" class="btn btn-primary">Save</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
					<?php
						if(isset($_POST["add"])){
							$service = addslashes($_POST["service"]);
							$type = $_POST["type"];
							$providerid = $_POST["providerid"];
							$description = addslashes($_POST["description"]);
							$tags = addslashes($_POST["tags"]);
							$longitude = addslashes($_POST["longitude"]);
							$latitude = addslashes($_POST["latitude"]);
							mysql_query("insert into services(providerid,service,description,dateadded,typeid,tags,longitude,latitude,deleted) values($providerid,'$service','$description',NOW(),$type,'$tags','$longitude','$latitude',0)");
							echo "<script>window.location='index.php?pg=services';</script>";
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