<?php
	if($_SESSION["type"] == "admin"){
		$r = mysql_fetch_array(mysql_query("select * from admin"));
		$current = $r["password"];
	}
	else{
		$r = mysql_fetch_array(mysql_query("select * from providers where id = $_SESSION[id]"));
		$current = $r["password"];
	}
?>
<h1 class="h3 mb-2 text-gray-800">Change Password</h1>
		
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Details</h6>
	</div>
	<form method="POST">
		<div class="card-body">
			<div class="form-group mb-2">
				<div class="form-group">
					<label>Current Password</label>
					<input type="text" name="password" class="form-control" required></input>
				</div>
				<div class="form-group">
					<label>Password</label>
					<div class="input-group">
						<input type="password" class="form-control" name="newpassword" id="password" placeholder="Password" aria-describedby="basic-addon2" required>
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
			<input type="submit" name="change" value="Update" class="btn btn-primary">
			<?php
				if(isset($_POST["change"])){
					$password = addslashes($_POST["password"]);
					$newpassword = addslashes($_POST["newpassword"]);
					if($password != $current){
						echo "<label class='text-danger'>Invalid password. Please try again!</label>";
					}
					else{
						if($_SESSION["type"] == "admin"){
							mysql_query("update admin set password='$newpassword'");
						}
						else{
							mysql_query("update providers set password='$newpassword' where id = $_SESSION[id]");
						}
						echo "<script>window.location = 'index.php?pg=account';</script>";
					}
				}
			?>
		</div>
	</form>
</div>