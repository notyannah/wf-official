<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set('Asia/Manila');
include("../connect.php");
if(!isset($_REQUEST['pg'])){ $pg = "main"; } else { $pg = $_REQUEST['pg']; }
?>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>WeFix Admin Panel</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/v4-shims.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-home"></i>
                </div>
                <div class="sidebar-brand-text mx-3">WeFix Admin</div>
            </a>
			<?php 
			if(isset($_SESSION["id"])){
			?>
				<!--<hr class="sidebar-divider my-0">
				<li class="nav-item active">
					<a class="nav-link" href="index.php"><i class="fas fa-fw fa-tachometer-alt"></i> <span>Dashboard</span></a>
				</li>-->
				<hr class="sidebar-divider my-0">
				<li class="nav-item <?php if($pg == "appointments" || $pg == "details"){ echo "active"; } ?>">
					<a class="nav-link" href="index.php?pg=appointments"><i class="fas fa-fw fa-calendar-day"></i> <span>Appointments</span></a>
				</li>
				<?php 
				if($_SESSION["type"] == "admin"){
				?>
					<hr class="sidebar-divider my-0">
					<li class="nav-item <?php if($pg == "providers"){ echo "active"; } ?>">
						<a class="nav-link" href="index.php?pg=providers"><i class="fas fa-fw fa-user-cog"></i> <span>Service Providers</span></a>
					</li>
					<hr class="sidebar-divider my-0">
					<li class="nav-item <?php if($pg == "services"){ echo "active"; } ?>">
						<a class="nav-link" href="index.php?pg=services"><i class="fas fa-fw fa-tools"></i> <span>Services</span></a>
					</li>
					<hr class="sidebar-divider my-0">
					<li class="nav-item <?php if($pg == "servicetypes"){ echo "active"; } ?>">
						<a class="nav-link" href="index.php?pg=servicetypes"><i class="fas fa-fw fa-list"></i> <span>Service Types</span></a>
					</li>
				<?php
				}
				?>
				<hr class="sidebar-divider my-0">
				<li class="nav-item <?php if($pg == "account"){ echo "active"; } ?>">
					<a class="nav-link" href="index.php?pg=account"><i class="fas fa-fw fa-key"></i> <span>Change Password</span></a>
				</li>
				<hr class="sidebar-divider my-0">
				<li class="nav-item">
					<a class="nav-link" href="logout.php"><i class="fas fa-fw fa-sign-out-alt"></i> <span>Logout</span></a>
				</li>
				<hr class="sidebar-divider my-0">
			<?php
			}
			else{
			?>
				<hr class="sidebar-divider my-0">
				<li class="nav-item active">
					<a class="nav-link" href="#"></a>
				</li>
			<?php
			}
			?>
        </ul>
		
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img style="width:110px;height:40px" src="../assets/img/logo.png">
                            </a>
                        </li>
                    </ul>
                </nav>

                <div class="container-fluid">
					<?php
						if($pg=="main")include("main.php");
						else if($pg=="appointments")include("appointments.php");
						else if($pg=="details")include("details.php");
						else if($pg=="account")include("account.php");
						else if($pg=="services")include("services.php");
						else if($pg=="providers")include("providers.php");
						else if($pg=="servicetypes")include("servicetypes.php");
					?>
                </div>
            </div>

            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; WeFix 2021</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="js/sb-admin-2.min.js"></script>
	<script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
    <script src="js/demo/datatables-demo.js"></script>
</body>
</html>