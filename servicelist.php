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
				$key = $_GET["key"];
				echo ($key == "") ? "": "<h3>Result for '$key'</h3>";
				$q = mysql_query("select a.*, b.type, c.company, c.contact, c.address, c.email, c.img from services a left join service_types b on a.typeid = b.id left join providers c on a.providerid = c.id where b.type like '%$key%' and a.deleted = 0 order by a.id desc");
				while($r = mysql_fetch_array($q)){
					$rquery = mysql_query("select a.* from rates a left join appointments b on a.appointmentid=b.id where b.serviceid = $r[id]");
					$qratesum = mysql_fetch_array(mysql_query("select SUM(a.rate) from rates a left join appointments b on a.appointmentid=b.id where b.serviceid = $r[id]"));
					$qratectr = mysql_num_rows($rquery);
					if($qratectr > 0){
						$qratedetails = mysql_fetch_array($rquery);
						$avg = $qratesum[0]/$qratectr;
						$round_num = round($avg / 0.5) * 0.5;
					}
					?>
					<div class="col-6">
						<div class="card">
							<div class="card-body">
								<h5 class="card-title"><?php echo $r["service"]; ?></h5>
								<h6 class="card-subtitle mb-2 text-muted"><?php echo $r["type"]; ?></h6>
								<p class="card-text"><small><?php echo $r["description"]; ?></small></p>
								<div class="row">
									<div class="col-8">
										<p class="card-footer text-muted">
											<small><small>
												<b>Service Provider: </b><span class="text-primary"><?php echo $r["company"]; ?></span><br/>
												<b>Address: </b><span class="text-primary"><?php echo $r["address"]; ?></span><br/>
												<b>Contact Number: </b><a href="tel:<?php echo $r["contact"]; ?>"><?php echo $r["contact"]; ?></a><br/>
												<b>Email Address: </b><a href="mail:<?php echo $r["email"]; ?>"><?php echo $r["email"]; ?></a><br/>
												<?php
												if($qratectr > 0){
												?>
													<b>Rate: </b><?php echo number_format($round_num, 1); ?> <span class="fas fa-star text-warning"></span><br/>
												<?php
												}
												else{
												?>
													<b>Rate: </b>No Ratings<br/>
												<?php
												}
												?>
											</small></small>
										</p>
									</div>
									<div class="col-4">
										<img src="admin/<?php  echo $r["img"]; ?>" class="w-100"/>
									</div>
								</div>
								<?php if(isset($_SESSION["id"])){
								?>
									<a href="index.php?pg=schedule&id=<?php echo $r["id"]; ?>" class="btn btn-sm btn-primary">Set Appointment</a>
								<?php
								}
								else{
								?>
									<a href="index.php?pg=login" class="btn btn-sm btn-primary">Set Appointment</a>
								<?php
								}
								?>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</section>
</main>