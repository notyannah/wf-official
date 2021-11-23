<h1 class="h3 mb-2 text-gray-800">Service Providers</h1>
		
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Records</h6>
	</div>
	<div class="card-body">
		<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
				<thead>
					<tr>
						<th></th>
						<th>Name</th>
						<th>Contact No.</th>
						<th>Email Address</th>
						<th>Address</th>
						<th>Offered Services</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$items = mysql_query("select * from providers where deleted=0 order by company");
					while($item = mysql_fetch_array($items)){
					?>
					<tr>
						<td><span class="fas fa-trash-alt text-danger" style="cursor:pointer;" data-toggle="modal" data-target="#delete_<?php echo $item["id"];?>"></span></td>
						<td>
							<a href="#" data-toggle="modal" data-target="#view_<?php echo $item["id"];?>">
							<img src="<?php echo $item["img"]; ?>" class="mr-2" width="40" height="40" style="border-radius: 50px;border: 1px solid #ddd; margin-right: 5px;"/> <?php echo $item["company"]; ?></a> <?php echo ($item["active"]==0) ? "<span class='text-danger'>&#9679;</span>":""; ?>
						</td>
						<td><?php echo $item["contact"]; ?></td>
						<td><?php echo $item["email"]; ?></td>
						<td><?php echo $item["address"]; ?></td>
						<td><?php echo $item["services"]; ?></td>
					</tr>
					<div class="modal" tabindex="-1" role="dialog" id="view_<?php echo $item["id"];?>">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Details</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<?php
								if($item["active"] == 0){
								?>
								<form method="POST" enctype="multipart/form-data">
									<div class="modal-body">
										<div class="card">
											<div class="card-header">Documents</div>
											<div class="card-body">
											<?php
											$dq = mysql_query("select * from documents where providerid = $item[id]");
											while($dr = mysql_fetch_array($dq)){
											?>
												<a class="btn btn-sm btn-secondary mb-1" target="_blank" href="../<?php echo $dr["file"]; ?>">
													<span class="fas fa-download text-success"></span><br/>
													<?php echo basename("../$dr[file]"); ?>
												</a>
											<?php
											}
											?>
											</div>
										</div>
										<p>Click approve button to approve the application</p>
									</div>
									<div class="modal-footer">
										<button type="submit" name="approve" class="btn btn-primary">Approve</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
										<?php
											if(isset($_POST["approve"])){
												mysql_query("update providers set active=1 where id=$item[id]");
												$msg = "Dear $item[company],<br/>
													<p>Your application for Service Provider has been approved! You can now access your account in the website. Thank you!</p>";
												email($msg,$user["company"],$item["email"],'Application Approved');
												echo "<script>window.location='index.php?pg=providers';</script>";
											}
										?>
									</div>
								</form>
								<?php
								}
								else{
								?>
								<div class="modal-body">
									<p>Application already approved</p>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
								<?php
								}
								?>
							</div>
						</div>
					</div>
					<div class="modal" tabindex="-1" role="dialog" id="delete_<?php echo $item["id"];?>">
						<div class="modal-dialog modal-sm" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Confirmation</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<form method="POST">
									<div class="modal-body">
										<p>Are you sure to delete this service provider and its services?</p>
									</div>
									<div class="modal-footer">
										<button type="submit" name="btndel_<?php echo $item["id"];?>" class="btn btn-primary">Yes</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
										<?php
											if(isset($_POST["btndel_$item[id]"])){
												mysql_query("update providers set deleted=1 where id=$item[id]");
												mysql_query("update services set deleted=1 where providerid=$item[id]");
												echo "<script>window.location='index.php?pg=providers';</script>";
											}
										?>
									</div>
								</form>
							</div>
						</div>
					</div>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>