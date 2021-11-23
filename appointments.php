<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>Appointments</h2>
				<ol>
					<li><a href="index.php">Home</a></li>
					<li>Appointments</li>
				</ol>
			</div>
		</div>
	</section>
	<section class="inner-page">
		<div class="container">
			<div class="row table-responsive">
				<table class="table table-bordered table-hover">
					<tr>
						<th>Appointment #</th>
						<th>Service</th>
						<th>Service Type</th>
						<th>Provider</th>
						<th>Schedule</th>
						<th>Date Added</th>
						<th>Status</th>
					</tr>
					<?php
						$q = mysql_query("select a.*, b.type, c.company, d.schedule, d.dateadded, d.status, d.id as aid from appointments d left join services a on d.serviceid = a.id left join service_types b on a.typeid = b.id left join providers c on a.providerid = c.id where d.clientid = $_SESSION[id]");
						while($r = mysql_fetch_array($q)){
							?>
							<tr>
								<td><a href="index.php?pg=details&id=<?php echo $r["aid"]; ?>">WF-SRVC-<?php echo sprintf('%08d', $r["aid"]); ?></a></td>
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
				</table>
			</div>
		</div>
	</section>
</main>