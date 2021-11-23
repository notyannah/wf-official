<h1 class="h3 mb-2 text-gray-800">Appointments</h1>
		
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Records</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="appDataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th>Appointment #</th>
						<th>Client</th>
						<th>Service</th>
						<th>Service Type</th>
						<th>Provider</th>
						<th>Schedule</th>
						<th>Date Added</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if($_SESSION["type"] == "admin"){
							$q = mysql_query("select a.*, b.type, c.company, d.schedule, d.dateadded, d.status, d.id as aid, e.fullname from appointments d left join services a on d.serviceid = a.id left join service_types b on a.typeid = b.id left join providers c on a.providerid = c.id left join clients e on e.id = d.clientid order by d.id desc");
						}
						else{
							$q = mysql_query("select a.*, b.type, c.company, d.schedule, d.dateadded, d.status, d.id as aid, e.fullname from appointments d left join services a on d.serviceid = a.id left join service_types b on a.typeid = b.id left join providers c on a.providerid = c.id left join clients e on e.id = d.clientid where a.providerid=$_SESSION[id] order by d.id desc");
						}
						while($r = mysql_fetch_array($q)){
							?>
							<tr>
								<td><a href="index.php?pg=details&id=<?php echo $r["aid"]; ?>">WF-SRVC-<?php echo sprintf('%08d', $r["aid"]); ?></a></td>
								<td><?php echo $r["fullname"]; ?></td>
								<td><?php echo $r["service"]; ?></td>
								<td><?php echo $r["type"]; ?></td>
								<td><?php echo $r["company"]; ?></td>
								<td><?php echo date_format(date_create($r["schedule"]),"m/d/Y h:i A"); ?></td>
								<td><?php echo date_format(date_create($r["dateadded"]),"m/d/Y h:i A"); ?></td>
								<td><?php echo $r["status"]; ?></td>
							</tr>
							<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>