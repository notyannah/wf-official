<?php
	if(isset($_SESSION["id"])){
		header("Location: index.php?pg=appointments");
	}
	else{
	?>
		<div class="col-5">
			<h1 class="h3 mb-2 text-gray-800">Authentication</h1>
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Credentials</h6>
				</div>
				<form method="POST">
					<div class="card-body">
						<div class="form-group mb-2">
							<div class="form-group">
								<label>Username</label>
								<input type="text" name="email" class="form-control" required></input>
							</div>
							<div class="form-group">
								<label>Password</label>
								<div class="input-group">
									<input type="password" class="form-control" name="password" id="password" placeholder="Password" aria-describedby="basic-addon2" required>
									<div class="input-group-append">
										<span class="input-group-text" id="basic-addon2"><span class="text-dark cursor-pointer ml-2"><i id="showpassword" style="cursor:pointer;" onclick="toggleShow()" class="fa fa-eye" aria-hidden="true"></i></span></span>
									</div>
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
						<input type="submit" name="login" value="Login" class="btn btn-primary w-100">
						<?php
							if(isset($_POST["login"])){
								$email = addslashes($_POST["email"]);
								$password = addslashes($_POST["password"]);
								$q1 = mysql_query("select * from admin where username='$email' and password='$password'");
								$q2 = mysql_query("select * from providers where email='$email' and password='$password'");
								if(mysql_num_rows($q1) > 0){
									$_SESSION["id"] = 0;
									$_SESSION["type"] = "admin";
									echo "<script>window.location = 'index.php?pg=main';</script>";
								}
								else if(mysql_num_rows($q2) > 0){
									$r2 = mysql_fetch_array($q2);
									$_SESSION["id"] = $r2["id"];
									$_SESSION["type"] = "provider";
									echo "<script>window.location = 'index.php?pg=main';</script>";
								}
								else{
									echo "<label class='text-danger'>Invalid username or password. Please try again!</label>";
								}
							}
						?>
					</div>
				</form>
			</div>
		</div>
	<?php
	}
?>
