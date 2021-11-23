<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>Accounts</h2>
				<ol>
					<li><a href="index.php">Home</a></li>
					<li>Accounts</li>
				</ol>
			</div>
		</div>
	</section>
	<section class="inner-page">
		<div class="container">
			<div class="row">
				<div class="col-7">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">My Account</h5>
							<hr/>
							<form method="POST">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Full Name</label>
											<input type="text" class="form-control form-control-sm" name="name" placeholder="Full Name" value="<?php echo $user["fullname"]; ?>" readonly required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="email">Email Address</label>
											<input type="email" class="form-control form-control-sm" name="email" placeholder="Email Address" value="<?php echo $user["email"]; ?>" required>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="mobile">Mobile Number</label>
											<input type="text" class="form-control form-control-sm" name="mobile" maxlength="11" placeholder="Mobile Number" value="<?php echo $user["mobile"]; ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Complete Address</label>
											<input type="text" class="form-control form-control-sm" name="address" placeholder="Complete Address" value="<?php echo $user["address"]; ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="password">Password</label>
											<div class="input-group mb-3">
												<input type="password" class="form-control form-control-sm" name="password" id="password" placeholder="Password" aria-describedby="basic-addon2" value="<?php echo $user['password']; ?>" required>
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
										</script>
									</div>
									<div class="col-md-12">
										<input type="submit" name="updateaccount" value="Save Changes" class="btn btn-primary">
										<?php
										if(isset($_POST["updateaccount"])){
											$email = addslashes($_POST["email"]);
											$mobile = $_POST["mobile"];
											$address = addslashes($_POST["address"]);
											$password = addslashes($_POST["password"]);
											mysql_query("update clients set email = '$email', mobile = '$mobile', address = '$address', password = '$password' where id = $_SESSION[id]");
											echo "<script>window.location = window.location.href;</script>";
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