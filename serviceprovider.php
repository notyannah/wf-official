<script src="assets/js/jquery.min.js"></script>
<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>Registration</h2>
				<ol>
					<li><a href="index.php">Home</a></li>
					<li>Registration</li>
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
							<h5 class="card-title">Register</h5>
							<h6 class="card-subtitle mb-2 text-muted"><small>Register a new service provider account</small></h6>
							<hr/>
							<form method="POST" enctype="multipart/form-data">
								<div class="row">
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Full Name</label>
											<input type="text" class="form-control form-control-sm" name="company" placeholder="Full Name" value="<?php echo isset($_POST['company']) ? $_POST['company'] : ''; ?>" required>
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
											<label class="frm-lbl" for="mobile">Contact Number</label>
											<input type="text" class="form-control form-control-sm" name="contact" maxlength="11" placeholder="Contact Number" value="<?php echo isset($_POST['contact']) ? $_POST['contact'] : ''; ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Complete Address</label>
											<input type="text" class="form-control form-control-sm" name="address" placeholder="Complete Address" value="<?php echo isset($_POST['address']) ? $_POST['address'] : ''; ?>" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Service Type/s</label>
											<ul style="list-style-type:none;">
												<?php
													$s = mysql_query("select * from service_types where deleted = 0 order by type");
													while($r = mysql_fetch_array($s)){
													?>
														<li><input type="checkbox" value="<?php echo $r["type"]; ?>"></input> <?php echo $r["type"]; ?></li>
													<?php
													}
												?>
												
											</ul>
											<input type="hidden" id="service_types" name="service_types"></input>
										</div>
									</div>
									<div class="col-md-6">
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
											
											
											$(document).ready(function(){
												$('input:checkbox').change(function() {
													var arrst = [];
													$("input:checkbox:checked").each(function(){
														arrst.push($(this).val());
													});
													$("#service_types").val(arrst.join(', '));
												});
												
											});
											
											
											
										</script>
									</div>
									<div class="col-md-6">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Image</label>
											<input type="file" class="form-control form-control-sm" name="img" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group mb-2">
											<label class="frm-lbl" for="name">Attachments</label>
											<input type="file" class="form-control form-control-sm" name="documents[]" required multiple>
											<small><small>Please attach supporting documents about you. (<i>e.g. Resume, Certificates, Valid ID, etc.</i>)</small></small>
										</div>
									</div>
									<div class="col-md-12">
										<input type="submit" name="register" value="Register" class="btn btn-primary w-100">
										<?php
										if(isset($_POST["register"])){
											$company = addslashes($_POST["company"]);
											$email = addslashes($_POST["email"]);
											$contact = $_POST["contact"];
											$address = $_POST["address"];
											$password = addslashes($_POST["password"]);
											$service_types = addslashes($_POST["service_types"]);
											$ac = mysql_num_rows(mysql_query("select * from providers where email = '$email' or contact = '$contact'"));
											if($ac > 0){
												echo "<small class='text-danger'>Email address or contact number already exist. Please try again.</small>";
											}
											else{
												mysql_query("insert into providers(company,email,contact,address,password,active,services) values('$company','$email','$contact','$address','$password',0,'$service_types')");
												$newid = mysql_insert_id();
												$files = array_filter($_FILES['documents']['name']);
												$total_count = count($_FILES['documents']['name']);
												for( $i=0 ; $i < $total_count ; $i++ ) {
													$tmpFilePath = $_FILES['documents']['tmp_name'][$i];
													if ($tmpFilePath != ""){
														$newFilePath = "assets/documents/".$_FILES['documents']['name'][$i];
														if(move_uploaded_file($tmpFilePath, $newFilePath)) {
															mysql_query("insert into documents(providerid,file) values($newid,'$newFilePath')");
														}
													}
												}
												$img= "img/".basename($_FILES["img"]["name"]);
												if(move_uploaded_file($_FILES["img"]["tmp_name"],$img)){
													mysql_query("update providers set img='$img' where id=$newid");
												}
												echo "<script>window.location = 'index.php?pg=login';</script>";
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