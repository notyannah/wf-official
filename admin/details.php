<script src="vendor/jquery/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBv_Cv9NdV2k-jyrcwJWHce9QZ-3waoZNg"></script>
<?php
$id = $_GET["id"];
$srvc = mysql_fetch_array(mysql_query("
select 
	a.*, 
	b.type, 
	c.company, 
	d.schedule, 
	d.dateadded, 
	d.status, 
	d.id as aid, 
	d.dateapproved, 
	d.dateintransit, 
	d.dateongoing, 
	d.datecancelled, 
	d.datecompleted,
	d.clientid,
	d.durationintransit,
	d.fee
from 
	appointments d 
	left join services a on d.serviceid = a.id 
	left join service_types b on a.typeid = b.id 
	left join providers c on a.providerid = c.id 
where 
	d.id = $id"));
$q = mysql_query("select a.*, b.type, c.company, c.contact, c.address, c.email from services a left join service_types b on a.typeid = b.id left join providers c on a.providerid = c.id where a.id=$srvc[id]");
$r = mysql_fetch_array($q);
$user = mysql_fetch_array(mysql_query("select * from clients where id=$srvc[clientid]"));

$qrate = mysql_query("select * from rates where appointmentid = $id");
$qratectr = mysql_num_rows($qrate);
if($qratectr > 0){
	$qratedetails = mysql_fetch_array($qrate);
}
?>
<h1 class="h3 mb-2 text-gray-800">Appointment Details</h1>
<p class="mb-4">#WF-SRVC-<?php echo sprintf('%08d', $id); ?></p>
<div class="row">
	<div class="col-7">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Appointment Details</h6>
			</div>
			<div class="card-body">
				<h4 class="text-primary"><?php echo $r["service"]; ?></h4>
				<hr/>
				<h6 class="card-title"><?php echo $r["type"]; ?></h6>
				<p class="card-text"><small><?php echo $r["description"]; ?></small></p>
				<p class="card-footer text-muted">
					<small>
						<b>Service Provider: </b><span class="text-primary"><?php echo $r["company"]; ?></span><br/>
						<b>Address: </b><span class="text-primary"><?php echo $r["address"]; ?></span><br/>
						<b>Location: </b><a href="https://maps.google.com/?q=<?php echo $r["latitude"]; ?>,<?php echo $r["longitude"]; ?>&z=15" target="_blank"><span class="fa fa-map-marker-alt text-danger"></span></a><br/>
						<b>Contact Number: </b><a href="tel:<?php echo $r["contact"]; ?>"><?php echo $r["contact"]; ?></a><br/>
						<b>Email Address: </b><a href="mail:<?php echo $r["email"]; ?>"><?php echo $r["email"]; ?></a><br/>
					</small>
				</p>
				<hr/>
				<h6 class="card-title">Schedule</h6>
				<p class="card-footer text-muted">
					<small>
						<b>Schedule: </b><span class="text-primary"><?php echo date_format(date_create($srvc["schedule"]),"F d, Y h:i A"); ?></span><br/>
						<b>Date Added: </b><span class="text-primary"><?php echo date_format(date_create($srvc["dateadded"]),"F d, Y h:i A"); ?></span><br/>
						<b>Client Name: </b><span class="text-primary"><?php echo $user["fullname"]; ?></span><br/>
						<b>Address: </b><span class="text-primary"><?php echo $user["address"]; ?></span><br/>
						<b>Location: </b><a href="https://maps.google.com/?q=<?php echo $user["latitude"]; ?>,<?php echo $user["longitude"]; ?>&z=15" target="_blank"><span class="fa fa-map-marker-alt text-danger"></span></a><br/>
					</small>
				</p>
				<?php
				if($srvc["status"] != "Completed" && $srvc["status"] != "Cancelled"){
				?>
					<input type="button" class="btn btn-sm btn-danger mr-1" value="Cancel Appointment" data-toggle="modal" data-target="#cancel"></input>
				<?php
				}
				if($srvc["status"] == "Pending"){
				?>
					<input type="button" class="btn btn-sm btn-primary mr-1" value="Approve Appointment" data-toggle="modal" data-target="#approve"></input>
				<?php
				}
				if($srvc["status"] == "Approved"){
				?>
					<input type="button" class="btn btn-sm btn-warning mr-1" value="In-Transit" data-toggle="modal" data-target="#intransit"></input>
				<?php
				}
				if($srvc["status"] == "In-Transit"){
				?>
					<input type="button" class="btn btn-sm btn-info mr-1" value="On-Going" data-toggle="modal" data-target="#ongoing"></input>
				<?php
				}
				if($srvc["status"] == "On-Going"){
				?>
					<input type="button" class="btn btn-sm btn-success mr-1" value="Complete" data-toggle="modal" data-target="#complete"></input>
				<?php
				}
				?>
			</div>
		</div>
	</div>
	<div class="col-5">
		<?php
		if($srvc["status"] == "In-Transit"){
		?>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary"><span class="text-warning fas fa-exclamation-triangle"></span> You are on your way</h6>
			</div>
			<div class="card-body">
				<h6 class="card-title"><small>Please do not leave this page to keep track of your real-time location</small></h6>
				<div class="card-footer text-muted" id="mapview">
					<div id="map"></div>
				</div>
			</div>
		</div>
		<?php
		}
		?>
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h6 class="m-0 font-weight-bold text-primary">Appointment Status</h6>
			</div>
			<div class="card-body">
				<h5 class="card-title"><?php echo $srvc["status"]; ?></h5>
				<div class="card-footer text-muted">
					<?php
					if($qratectr > 0){
					?>
						<div class="card mt-2">
							<div class="card-body">
								<small>
								<b class="text-primary">Service Rated</b><br/>
								<p><?php echo "<b>Your Rate: </b>$qratedetails[rate]<br/><b>Comments: </b>$qratedetails[remarks]"; ?></p>
								<?php echo date_format(date_create($qratedetails["dateadded"]),"F d, Y h:i A"); ?>
								</small>
							</div>
						</div>
					<?php
					}
					if($srvc["datecompleted"] != "0000-00-00 00:00:00"){
					?>
						<div class="card mt-2">
							<div class="card-body">
								<small>
								<b class="text-primary">Appointment Completed</b><br/>
								<p><b>Repair Fee: </b>Php <?php echo number_format($srvc["fee"], 2); ?></p>
								<?php echo date_format(date_create($srvc["datecompleted"]),"F d, Y h:i A"); ?>
								</small>
							</div>
						</div>
					<?php
					}
					if($srvc["datecancelled"] != "0000-00-00 00:00:00"){
					?>
						<div class="card mt-2">
							<div class="card-body">
								<small>
								<b class="text-primary">Appointment Cancelled</b><br/>
								<?php echo date_format(date_create($srvc["datecancelled"]),"F d, Y h:i A"); ?>
								</small>
							</div>
						</div>
					<?php
					}
					if($srvc["dateongoing"] != "0000-00-00 00:00:00"){
					?>
						<div class="card mt-2">
							<div class="card-body">
								<small>
								<b class="text-primary">Service On-Going</b><br/>
								<?php echo date_format(date_create($srvc["dateongoing"]),"F d, Y h:i A"); ?>
								</small>
							</div>
						</div>
					<?php
					}
					if($srvc["dateintransit"] != "0000-00-00 00:00:00"){
					?>
						<div class="card mt-2">
							<div class="card-body">
								<small>
								<b class="text-primary">In-Transit</b><br/>
								<p>Please wait for the repairman for approximately <?php echo $srvc["durationintransit"]; ?> to reach your area. For concerns, please call <a href="tel:<?php echo $r["contact"]; ?>"><?php echo $r["contact"]; ?></a>. Thank you.</p>
								<?php echo date_format(date_create($srvc["dateintransit"]),"F d, Y h:i A"); ?>
								</small>
							</div>
						</div>
					<?php
					}
					if($srvc["dateapproved"] != "0000-00-00 00:00:00"){
					?>
						<div class="card mt-2">
							<div class="card-body">
								<small>
								<b class="text-primary">Appointment Approved</b><br/>
								<?php echo date_format(date_create($srvc["dateapproved"]),"F d, Y h:i A"); ?>
								</small>
							</div>
						</div>
					<?php
					}
					?>
					<div class="card mt-2">
						<div class="card-body">
							<small>
							<b class="text-primary">Appointment Submitted</b><br/>
							<?php echo date_format(date_create($srvc["dateadded"]),"F d, Y h:i A"); ?>
							</small>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal" tabindex="-1" id="cancel">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body text-center">
					<p>Are you sure to cancel this appointment?</p>
					<input type="text" name="reason" class="form-control" placeholder="Enter reason" required></input>
				</div>
				<div class="modal-footer">
					<button type="submit" name="cancel" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<?php
						if(isset($_POST["cancel"])){
							$reason = addslashes($_POST["reason"]);
							mysql_query("update appointments set status='Cancelled', datecancelled=NOW() where id=$id");
							$msg = "Dear $user[fullname],<br/><p>Your appointment, with appointment number <b>WF-SRVC-".sprintf('%08d', $id)."</b> has been cancelled. Reason: <b>$reason</b>. If you did not request for cancellation, please contact us. To request for a new service, login to <a href='#'>WeFix</a>, search for desired service, then set the schedule. Thank you!</p>";
							email($msg,$user["fullname"],$user["email"],'Appointment Cancelled');
							echo "<script>window.location = window.location.href;</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" id="approve">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body text-center">
					<p>Are you sure to approve this appointment?</p>
				</div>
				<div class="modal-footer">
					<button type="submit" name="approve" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<?php
						if(isset($_POST["approve"])){
							mysql_query("update appointments set status='Approved', dateapproved=NOW() where id=$id");
							$msg = "Dear $user[fullname],<br/><p>Your appointment, with appointment number <b>WF-SRVC-".sprintf('%08d', $id)."</b> has been approved. Please wait for our updates. Thank you!</p>";
							email($msg,$user["fullname"],$user["email"],'Appointment Approved');
							echo "<script>window.location = window.location.href;</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" id="intransit">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body text-center">
					<p>Are you sure to set this appointment as 'In-Transit'?</p>
				</div>
				<div class="modal-footer">
					<button type="submit" name="intransit" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<?php
						if(isset($_POST["intransit"])){
							$km = distance($r["latitude"], $r["longitude"], $user["latitude"], $user["longitude"]);
							$mins = round($km/60);
							$duration = convertToHoursMins($mins);
							mysql_query("update appointments set status='In-Transit', dateintransit=NOW(), durationintransit='$duration' where id=$id");
							$msg = "Dear $user[fullname],<br/><p>The repairman for the appointment number <b>WF-SRVC-".sprintf('%08d', $id)."</b> is now on his way and will approximately reach you in $duration upon receiving this email. Please wait for our updates. Please keep your line open. Thank you!</p>";
							email($msg,$user["fullname"],$user["email"],'Appointment In-Transit');
							echo "<script>window.location = window.location.href;</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" id="ongoing">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body text-center">
					<p>Are you sure to set this appointment as 'On-Going'?</p>
				</div>
				<div class="modal-footer">
					<button type="submit" name="ongoing" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<?php
						if(isset($_POST["ongoing"])){
							mysql_query("update appointments set status='On-Going', dateongoing=NOW() where id=$id");
							$msg = "Dear $user[fullname],<br/><p>Your appointment, with appointment number <b>WF-SRVC-".sprintf('%08d', $id)."</b> has now started. The total fee will be computed after the repair. Thank you!</p>";
							email($msg,$user["fullname"],$user["email"],'Appointment On-Going');
							echo "<script>window.location = window.location.href;</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<div class="modal" tabindex="-1" id="complete">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="POST">
				<div class="modal-body text-center">
					<p>Are you sure to complete this appointment?</p>
					<input type="text" name="fee" class="form-control" placeholder="Enter total fee" required></input>
				</div>
				<div class="modal-footer">
					<button type="submit" name="complete" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
					<?php
						if(isset($_POST["complete"])){
							$fee = number_format($_POST["fee"], 2);
							mysql_query("update appointments set status='Completed', datecompleted=NOW(), fee=$_POST[fee] where id=$id");
							$msg = "Dear $user[fullname],<br/><p>Your appointment, with appointment number <b>WF-SRVC-".sprintf('%08d', $id)."</b> is now completed with a total of Php $fee. Thank you for availing our service. If you have any concerns, feel free to message us anytime.</p>";
							email($msg,$user["fullname"],$user["email"],'Appointment Completed');
							echo "<script>window.location = window.location.href;</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<div id="updateloc"></div>
<script>
	var mapObject;
	var activeInfoWindow; 
	var clat, clng;
	function getCurrentLocation(){
		if (navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(function(position) {
					clat = position.coords.latitude;
					clng = position.coords.longitude;
					var mapwidth = $("#mapview").width();
					$("#map").css({ "width": mapwidth, "height":"300px" });
					var myOptions = {
						zoom: 15,
						center: new google.maps.LatLng(clat,clng),
						mapTypeId: google.maps.MapTypeId.ROADMAP
					};
					const pos = {
						lat: clat,
						lng: clng,
					};
					mapObject = new google.maps.Map(document.getElementById("map"), myOptions);
					if (activeInfoWindow) { activeInfoWindow.close();}
					var infoWindow = new google.maps.InfoWindow();
					infoWindow.setPosition(pos);
					infoWindow.setContent("<span class='text-success fas fa-car'></span>");
					infoWindow.open(mapObject);
					mapObject.setCenter(pos);
					activeInfoWindow = infoWindow;
					$("#updateloc").load("updateloc.php?lat=" + clat + "&lng=" + clng + "&id=<?php echo $id; ?>");
				},
				function(error) {
					console.log("Error: ", error);
				},
				{
					enableHighAccuracy: true
				}
			);
		}
	}
	setInterval(function(){
		getCurrentLocation();
	},5000);
	
	$(document).ready(function(){
		getCurrentLocation();
	});
</script>