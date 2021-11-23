<main id="main" data-aos="fade-up">
	<section class="breadcrumbs">
		<div class="container">
			<div class="d-flex justify-content-between align-items-center">
				<h2>Services</h2>
				<ol>
					<li><a href="index.php">Home</a></li>
					<li>Services</li>
				</ol>
			</div>
		</div>
	</section>
	<section class="inner-page">
		<div class="container">
			<div class="row">
				<?php
				$q = mysql_query("select a.*, b.type, c.company, c.contact, c.address, c.email from services a left join service_types b on a.typeid = b.id left join providers c on a.providerid = c.id where a.id=$_GET[id]");
				$r = mysql_fetch_array($q);
				$min = date('c', strtotime(date('Y-m-d h:i A'). ' + 1 hours'));
				$min = str_replace("+08:00","",$min);
				?>
				<div class="col-5">
					<div class="card mb-4">
						<div class="card-body">
							<h5 class="card-title">Set Schedule</h5>
							<p class="card-text"><small>Set the available day and time</small></p>
							<form method="POST">
								<input type="datetime-local" name="schedule" class="form-control form-control-sm mb-2" min="<?php echo $min ?>" required></input>
								<input type="submit" name="submit" class="btn btn-primary w-100" value="Submit"></input>
								<?php
								if(isset($_POST["submit"])){
									mysql_query("insert into appointments(serviceid,clientid,schedule,dateadded,status) values($_GET[id],$_SESSION[id],'$_POST[schedule]',NOW(),'Pending')");
									$apptid = mysql_insert_id();
									$msg = "Dear $user[fullname],<br/>
										<p>Thank you for choosing WeFix. We have received your request (Appointment Number: <b>WF-SRVC-".sprintf('%08d', $apptid)."</b>) and still subject for approval. Please wait within an hour to approve your request. Thank you!</p>
										<p><b>Service: </b>$r[service]<br/><b>Schedule: </b>".date_format(date_create($_POST["schedule"]),"m/d/Y h:i A")."</p>";
									email($msg,$user["fullname"],$user["email"],'Appointment Submitted');
									echo "<script>window.location = 'index.php?pg=appointments';</script>";
								}
								?>
							</form>
						</div>
					</div>
					
					<div class="card">
						<div class="card-body">
							<h5 class="card-title">Repair Fee</h5>
							<p class="card-text"><small>Please note that the amount may vary depending on the request. For quotation, you can call us using this number <a href="tel:<?php echo $r["contact"]; ?>"><?php echo $r["contact"]; ?></a> before proceeding to the appointment request. Thank you!</small></p>
						</div>
					</div>
				</div>
				<div class="col-7">
					<div class="card">
						<div class="card-body">
							<h5 class="card-title"><?php echo $r["service"]; ?></h5>
							<h6 class="card-subtitle mb-2 text-muted"><?php echo $r["type"]; ?></h6>
							<p class="card-text"><small><?php echo $r["description"]; ?></small></p>
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
					</div>
				</div>
			</div>
		</div>
	</section>
</main>