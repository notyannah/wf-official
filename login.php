<script src="assets/js/jquery.min.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBv_Cv9NdV2k-jyrcwJWHce9QZ-3waoZNg"></script>
<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>Login</h2>
				<ol>
					<li><a href="index.php">Home</a></li>
					<li>Login</li>
				</ol>
			</div>
		</div>
	</section>
	<section class="inner-page">
		<div class="container">
			<div class="row">
				<div class="col-5">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Login</h5>
							<h6 class="card-subtitle mb-2 text-muted"><small>Please login your existing account</small></h6>
							<hr/>
							<form method="POST">
								<div class="form-group mb-2">
									<label class="frm-lbl">Email Address</label>
									<input type="email" class="form-control form-control-sm" name="email" placeholder="Email" required>
								</div>
								<div class="form-group mb-2">
									<label class="frm-lbl">Password</label>
									<input type="password" name="password" class="form-control form-control-sm" placeholder="Password" required>
								</div>
								<div class="form-group">
									<input type="submit" name="login" class="btn btn-primary w-100" value="Login"/>
								</div>
								<?php
									if(isset($_POST["login"])){
										$email = addslashes($_POST["email"]);
										$password = addslashes($_POST["password"]);
										$qlog = mysql_query("select * from clients where email='$email' and password='$password'");
										$rlog = mysql_num_rows($qlog);
										if($rlog > 0){
											$ulog = mysql_fetch_array($qlog);
											$_SESSION["id"] = $ulog["id"];
											echo "<script>window.location = 'index.php?pg=main';</script>";
										}
										else{
											echo "<small class='text-danger'>Invalid email or password. Please try again.</small>";
										}
									}
								?>
							</form>
						</div>
					</div>
					<div class="card mt-4">
						<div class="card-body">
							<h5 class="card-title">Service Provider &amp; Administrator</h5>
							<h6 class="card-subtitle mb-2 text-muted"><small>Access admin panel or create service provider account</small></h6>
							<hr/>
							<div class="col-md-12 mt-1">
								<a href="admin/index.php" class="btn btn-secondary w-100"><span class="fa fa-user-shield"></span> Admin Panel</a>
							</div>
							<div class="col-md-12 mt-1">
								<a href="index.php?pg=serviceprovider" class="btn btn-secondary w-100"><span class="fa fa-tools"></span> Service Provider Registration</a>
							</div>
						</div>
					</div>
				</div>
				<div class="col-7">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Register</h5>
							<h6 class="card-subtitle mb-2 text-muted"><small>Register a new account</small></h6>
							<hr/>
							<form method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Full Name</label>
											<input type="text" class="form-control form-control-sm" name="fullname" placeholder="Full Name" value="<?php echo isset($_POST['fullname']) ? $_POST['fullname'] : ''; ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="email">Email Address</label>
											<input type="email" class="form-control form-control-sm" name="email" placeholder="Email Address" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="mobile">Mobile Number</label>
											<input type="text" class="form-control form-control-sm" name="mobile" maxlength="11" placeholder="Mobile Number" value="<?php echo isset($_POST['mobile']) ? $_POST['mobile'] : ''; ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Complete Address</label>
											<input type="text" class="form-control form-control-sm" name="address" placeholder="Complete Address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="card-footer text-muted" id="mapview">
											<div id="map"></div>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="password">Password</label>
											<div class="input-group mb-3">
												<input type="password" class="form-control form-control-sm" name="password" id="password" placeholder="Password" aria-describedby="basic-addon2" value="<?php echo isset($_POST['password']) ? $_POST['password'] : ''; ?>" required>
												<div class="input-group-append">
													<span class="input-group-text" id="basic-addon2"><span class="text-dark cursor-pointer ml-2"><i id="showpassword" style="cursor:pointer;" onclick="toggleShow()" class="fa fa-eye" aria-hidden="true"></i></span></span>
												</div>
											</div>
										</div>
										<script>
											function toggleShow(){
												if($("#showpassword").attr("class")=="fa fa-eye"){
													$("#showpassword").attr("class","fa fa-eye-slash");
													$("#password").prop("type","text");
												}
												else{
													$("#showpassword").attr("class","fa fa-eye");
													$("#password").prop("type","password");
												}
											}	
											
											var mapObject;
											var activeInfoWindow; 
											var clat, clng;
											$(document).ready(function(){
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
															var mapObject = new google.maps.Map(document.getElementById("map"), myOptions);
															if (activeInfoWindow) { activeInfoWindow.close();}
															var infoWindow = new google.maps.InfoWindow();
															infoWindow.setPosition(pos);
															infoWindow.setContent("<span class='text-success fas fa-map-marker-alt'></span>");
															infoWindow.open(mapObject);
															mapObject.setCenter(pos);
															activeInfoWindow = infoWindow;
															$("#latitude").val(clat);
															$("#longitude").val(clng);
															google.maps.event.addListener(mapObject, 'click', function(event) {
																var ppos = { lat: event.latLng.lat(), lng: event.latLng.lng() };
																infoWindow.setPosition(ppos);
																infoWindow.setContent("<span class='text-success fas fa-map-marker-alt'></span>");
																infoWindow.open(mapObject);
																mapObject.setCenter(ppos);
																$("#latitude").val(event.latLng.lat());
																$("#longitude").val(event.latLng.lng());
															});
														},
														function(error) {
															console.log("Error: ", error);
														},
														{
															enableHighAccuracy: true
														}
													);
												}
											});
										</script>
										<input type="hidden" name="latitude" id="latitude"></input>
										<input type="hidden" name="longitude" id="longitude"></input>
									</div>
									<div class="col-md-12">
										<input type="submit" name="register" value="Register" class="btn btn-primary w-100">
										<?php
										if(isset($_POST["register"])){
											$fullname = addslashes($_POST["fullname"]);
											$email = addslashes($_POST["email"]);
											$mobile = $_POST["mobile"];
											$address = $_POST["address"];
											$latitude = $_POST["latitude"];
											$longitude = $_POST["longitude"];
											$password = addslashes($_POST["password"]);
											$ac = mysql_num_rows(mysql_query("select * from clients where email = '$email' or mobile = '$mobile'"));
											if($ac > 0){
												echo "<small class='text-danger'>Email address or mobile number already exist. Please try again.</small>";
											}
											else{
												mysql_query("insert into clients(fullname,email,mobile,address,password,latitude,longitude) values('$fullname','$email','$mobile','$address','$password','$latitude','$longitude')");
												$newid = mysql_insert_id();
												$_SESSION["id"] = $newid;
												echo "<script>window.location = 'index.php?pg=main';</script>";
											}
										}
										?>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</main>