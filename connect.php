<?php
	mysql_connect("remotemysql.com","OKKhbJZJPV","ahb5auXghn");
	mysql_select_db("OKKhbJZJPV");
	session_start();
	
	function distance($lat1, $lon1, $lat2, $lon2) {
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		return ($miles * 1.609344);
	}
	
	require "PHPMailer/PHPMailerAutoload.php";	
	function email($msg, $name, $email, $subject){
		$mail = new PHPMailer;
		$mail->isSMTP();
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 587;
		$mail->SMTPSecure = "tls";
		$mail->SMTPAuth = true;
		$mail->Username = "wefixservices2021@gmail.com";
		$mail->Password = "Wefix2021!";
		$mail->setFrom("wefixservices2021@gmail.com", "WeFix Home Service");
		$mail->addAddress($email, $name);
		$mail->Subject = $subject;
		$mail->msgHTML($msg);
		$mail->send();
	}
	
	function convertToHoursMins($time) {
		$hours = floor($time / 60);
		$minutes = ($time % 60);
		if($time < 1){
			$hoursToMinutes = "less than a minute";
		}
		else{
			if($minutes == 0){
				if($hours == 1){
					$output_format = '%2d hour ';
				}else{
					$output_format = '%2d hours ';
				}
				$hoursToMinutes = sprintf($output_format, $hours);
			}else if($hours == 0){

				if ($minutes < 10) {
						$minutes = '' . $minutes;
				}
				if($minutes == 1){

					$output_format  = ' %2d minute ';
				}else{
					$output_format  = ' %2d minutes ';
				}
				$hoursToMinutes = sprintf($output_format,  $minutes);
			}else {
				if($hours == 1){

					$output_format = '%2d hour %2d minutes';
				}else{

					$output_format = '%2d hours %2d minutes';
				}
				$hoursToMinutes = sprintf($output_format, $hours, $minutes);
			}
		}
		return $hoursToMinutes;
	}
	
	//GOOGLE ACCOUNT
	//EMAIL: wefixservices2021@gmail.com
	//PASSWORD: Wefix2021!
?>