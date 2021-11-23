<!DOCTYPE html>
<html lang="en">
<?php
date_default_timezone_set('Asia/Manila');
include("connect.php");
if(!isset($_REQUEST['pg'])){ $pg = "main"; } else { $pg = $_REQUEST['pg']; }
if(isset($_SESSION["id"])){
	$user = mysql_fetch_array(mysql_query("select * from clients where id=$_SESSION[id]"));
}
?>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>WeFix Home Service</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/v4-shims.css">
    <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>
    <section id="topbar" class="d-flex align-items-center"></section>
	
    <header id="header" class="d-flex align-items-center">
        <div class="container d-flex align-items-center justify-content-between">
            <a href="index.php" class="logo"><img src="assets/img/logo.png" alt=""></a>
            <nav id="navbar" class="navbar">
                <ul>
                    <li><a class="nav-link scrollto active" href="index.php?pg=main#hero">Home</a></li>
                    <li><a class="nav-link scrollto" href="index.php?pg=main#about">About</a></li>
                    <li><a class="nav-link scrollto" href="index.php?pg=main#services">Services</a></li>
                    <li><a class="nav-link scrollto" href="index.php?pg=main#contact">Contact</a></li>
					<?php if(isset($_SESSION["id"])){
					?>
                    <li class="dropdown"><a href="#"><span>Account</span> <i class="bi bi-chevron-down"></i></a>
                        <ul>
                            <li class="fw-bold text-white"><a><b><?php echo $user["fullname"]; ?></b></a><hr/></li>
                            <li><a href="index.php?pg=appointments">Appointments</a></li>
                            <li><a href="index.php?pg=account">My Account</a></li>
                            <li><a href="logout.php">Logout</a></li>
                        </ul>
                    </li>
					<?php
					}
					else{
					?>
					<li><a class="nav-link scrollto" href="index.php?pg=login">Login</a></li>
					<?php
					}
					?>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>

        </div>
    </header>
	
	<?php
		if($pg=="main")include("main.php");
		else if($pg=="services")include("services.php");
		else if($pg=="login")include("login.php");
		else if($pg=="schedule")include("schedule.php");
		else if($pg=="appointments")include("appointments.php");
		else if($pg=="account")include("account.php");
		else if($pg=="details")include("details.php");
		else if($pg=="serviceprovider")include("serviceprovider.php");
		else if($pg=="servicelist")include("servicelist.php");
	?>
	
	<section id="topbar" class="d-flex align-items-center" style="height:3px !important"></section>
    <footer id="footer">

        <div class="footer-top">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-md-6 footer-contact">
                        <h3>WeFix</h3>
                        <p>
                            Kapitan Ponso st. <br>
                            Bauan <br>
                            Batangas 4201 <br><br>
                            <strong>Phone:</strong> +63 956 794 1292<br>
                            <strong>Email:</strong> admwefix.homeservices.official@gmail.com<br>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Useful Links</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php?pg=main#hero">Home</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php?pg=main#about">About Us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php?pg=main#services">Services</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php?pg=main#contact">Contact Us</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="#">Privacy Policy</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Others</h4>
                        <ul>
                            <li><i class="bx bx-chevron-right"></i> <a href="admin/index.php">Admin Panel</a></li>
                            <li><i class="bx bx-chevron-right"></i> <a href="index.php?pg=serviceprovider">Service Provider Registration</a></li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-6 footer-links">
                        <h4>Our Social Networks</h4>
                        <p>Be updated! Check our other platforms.</p>
                        <div class="social-links mt-3">
                            <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
                            <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="container py-4">
            <div class="copyright">
                &copy; Copyright <strong><span>WeFix</span></strong>. All Rights Reserved
            </div>
        </div>
    </footer>

    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/vendor/purecounter/purecounter.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/waypoints/noframework.waypoints.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/jquery.min.js"></script>
	<script>
		window.onload = function(){
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(function(position) {
						$("#lat").val(position.coords.latitude);
						$("#long").val(position.coords.longitude);
					},
					function(error) {
						console.log("Error: ", error);
					},
					{
						enableHighAccuracy: true
					}
				);
			}
		}
	</script>
</body>

</html>