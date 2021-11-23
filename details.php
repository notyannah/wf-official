<script src="assets/js/jquery.min.js"></script>
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
	d.durationintransit,
	d.durationupdate,
	d.durationupdate_lat,
	d.durationupdate_lng,
	d.fee
from 
	appointments d 
	left join services a on d.serviceid = a.id 
	left join service_types b on a.typeid = b.id 
	left join providers c on a.providerid = c.id 
where 
	d.id = $id"));
$qrate = mysql_query("select * from rates where appointmentid = $id");
$qratectr = mysql_num_rows($qrate);
if($qratectr > 0){
	$qratedetails = mysql_fetch_array($qrate);
}
?>
<input type="hidden" id="clat" value="<?php echo $srvc["durationupdate_lat"]; ?>"></input>
<input type="hidden" id="clng" value="<?php echo $srvc["durationupdate_lng"]; ?>"></input>
<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>Appointment Details</h2>
				<ol>
					<li><a href="index.php">Home</a></li>
					<li>Appointment Details</li>
				</ol>
			</div>
		</div>
	</section>
	<section class="inner-page">
		<div class="container">
			<div class="row">
				<?php
				$q = mysql_query("select a.*, b.type, c.company, c.contact, c.address, c.email, c.img from services a left join service_types b on a.typeid = b.id left join providers c on a.providerid = c.id where a.id=$srvc[id]");
				$r = mysql_fetch_array($q);
				?>
				<div class="col-7">
					<div class="card mb-4">
						<div class="card-body">
							<h4 class="text-primary">WF-SRVC-<?php echo sprintf('%08d', $id); ?></h4>
							<hr/>
							<h6 class="card-title"><?php echo $r["service"]; ?></h6>
							<h6 class="card-subtitle mb-2 text-muted"><?php echo $r["type"]; ?></h6>
							<p class="card-text"><small><?php echo $r["description"]; ?></small></p>
							<div class="row">
								<div class="col-8">
									<p class="card-footer text-muted">
										<small><small>
											<b>Service Provider: </b><span class="text-primary"><?php echo $r["company"]; ?></span><br/>
											<b>Address: </b><span class="text-primary"><?php echo $r["address"]; ?></span><br/>
											<b>Location: </b><a href="https://maps.google.com/?q=<?php echo $r["latitude"]; ?>,<?php echo $r["longitude"]; ?>&z=15" target="_blank"><span class="fa fa-map-marker-alt text-danger"></span></a><br/>
											<b>Contact Number: </b><a href="tel:<?php echo $r["contact"]; ?>"><?php echo $r["contact"]; ?></a><br/>
											<b>Email Address: </b><a href="mail:<?php echo $r["email"]; ?>"><?php echo $r["email"]; ?></a><br/>
										</small></small>
									</p>
								</div>
								<div class="col-4">
									<img src="admin/<?php  echo $r["img"]; ?>" class="w-100"/>
								</div>
							</div>
							<hr/>
							<h6 class="card-title">Schedule</h6>
							<p class="card-footer text-muted">
								<small><small>
									<b>Schedule: </b><span class="text-primary"><?php echo date_format(date_create($srvc["schedule"]),"F d, Y h:i A"); ?></span><br/>
									<b>Date Added: </b><span class="text-primary"><?php echo date_format(date_create($srvc["dateadded"]),"F d, Y h:i A"); ?></span><br/>
									<b>Client Name: </b><span class="text-primary"><?php echo $user["fullname"]; ?></span><br/>
									<b>Address: </b><span class="text-primary"><?php echo $user["address"]; ?></span><br/>
									<b>Location: </b><a href="https://maps.google.com/?q=<?php echo $user["latitude"]; ?>,<?php echo $user["longitude"]; ?>&z=15" target="_blank"><span class="fa fa-map-marker-alt text-danger"></span></a><br/>
								</small></small>
							</p>
							<?php
							if($srvc["status"] == "Pending"){
							?>
								<input type="button" class="btn btn-sm btn-danger" value="Cancel Appointment" data-bs-toggle="modal" data-bs-target="#cancel"></input>
							<?php
							}
							?>
						</div>
					</div>
					<?php
					if($qratectr == 0){
					?>
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Rate Service</h5>
							<h6 class="card-subtitle mb-2 text-muted">Your opinion is important to us</h6>
							<p class="card-text"><small>Please rate us from 1-5 (5 is the highest) and leave any comments/suggestions for the service.</small></p>
							<div class="card-footer text-muted">
								<form method="POST">
									<label>Rate</label>
									<select class="form-control form-control-sm" name="rate" required>
										<option>5</option>
										<option>4</option>
										<option>3</option>
										<option>2</option>
										<option>1</option>
									</select>
									<label>Comments</label>
									<textarea class="form-control form-control-sm mb-2" cols="2" name="remarks" required></textarea>
									<input type="submit" name="btnrate" class="btn btn-sm btn-primary" value="Submit"></input>
									<?php
									if(isset($_POST["btnrate"])){
										$rate = $_POST["rate"];
										$remarks = addslashes($_POST["remarks"]);
										mysql_query("insert into rates(appointmentid,rate,remarks,dateadded) values($id,$rate,'$remarks',NOW())");
										echo "<script>window.location = window.location.href;</script>";
									}
									?>
								</form>
							</div>
						</div>
					</div>
					<?php
					}
					else{
					?>
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Rate Service</h5>
							<p class="card-footer text-muted">
								<?php
									echo "<small><b>Your Rate: </b>$qratedetails[rate]<br/><b>Comments: </b>$qratedetails[remarks]</small>";
								?>
							</p>
						</div>
					</div>
					<?php
					}
					?>
				</div>
				<div class="col-5">
					<?php
					if($srvc["status"] == "In-Transit"){
					?>
					<div class="card mb-4">
						<div class="card-body">
							<h6 class="card-title"><small><span class="text-warning fas fa-exclamation-triangle"></span> The repairman is on his way. Arrive in <span id="arrive"></span></small></h6>
							<div class="card-footer text-muted" id="mapview">
								<div id="map"></div>
							</div>
						</div>
					</div>
					<?php
					}
					?>
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Appointment Status</h5>
							<h6 class="card-subtitle mb-2 text-muted"><?php echo $srvc["status"]; ?></h6>
							<div class="card-footer text-muted">
								<?php
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
											<p><small>Please wait for the repairman for approximately <?php echo $srvc["durationintransit"]; ?> to reach your area. For concerns, please call <a href="tel:<?php echo $r["contact"]; ?>"><?php echo $r["contact"]; ?></a>. Thank you.</small></p>
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
		</div>
	</section>
</main>

<div class="modal" tabindex="-1" id="cancel">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Confirmation</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<form method="POST">
				<div class="modal-body text-center">
					<p><span class="fa fa-question-circle fs-2"></span><br/>Are you sure to cancel this appointment?</p>
				</div>
				<div class="modal-footer">
					<button type="submit" name="cancel" class="btn btn-primary">Yes</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
					<?php
						if(isset($_POST["cancel"])){
							mysql_query("update appointments set status='Cancelled' where id=$id");
							$msg = "Dear $user[fullname],<br/><p>Your appointment, with appointment number <b>WF-SRVC-".sprintf('%08d', $id)."</b> has been cancelled. If you did not request for cancellation, please contact us. To request for a new service, login to <a href='#'>WeFix</a>, search for desired service, then set the schedule. Thank you!</p>";
							email($msg,$user["fullname"],$user["email"],'Appointment Cancelled');
							echo "<script>window.location = window.location.href;</script>";
						}
					?>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	var mapObject;
	var activeInfoWindow; 
	function getCurrentLocation(){
		$.ajax({
			url : "getupdate.php",
			type : 'get',
			data : { id: '<?php echo $id; ?>' },
			dataType: 'text',
			success : function(data){
				console.log(data);
				var x = data.split(',');
				$("#arrive").html(x[0]);
				var clat = Number(x[1]);
				var clng = Number(x[2]);
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
			},
			error:function (xhr, ajaxOptions, thrownError) {
				console.log(xhr.status);
				console.log(thrownError);
			}
		});
	}
	setInterval(function(){
		getCurrentLocation();
	},5000);
	
	$(document).ready(function(){
		getCurrentLocation();
	});
</script>