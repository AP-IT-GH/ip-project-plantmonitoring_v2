<?php

if (!isset($_POST['submit'])){
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="css/stylelogin.css">

</head>
<body style="background-image: url('images/bg-01.jpg');  background-color: rgba(0,0,0,0.5);">
<div class="caixa-form" style="background-color: #fff;">
  

	<form action="<?=$_SERVER['PHP_SELF']?>" method="post">
		<div class="divproc1">
		 <h3 style="color:#a06845; ">LOGIN</h3>
		
		<div class="form-inp" style="border-bottom: 1px solid #e6e6e6;">
        <a style="font-size:14px; font-family: Ubuntu-Regular;font-size: 20px;  color: #555555; ">USERNAME:</a>
        <input type="text" name="username" style="font-family: Ubuntu-Regular;  font-size: 20px;  color: #555555;" />
		</div>
		<div class="form-inp" style="border-bottom: 1px solid #e6e6e6;">
        <a style="font-size:14px;  font-family: Ubuntu-Regular;font-size: 20px;  color: #555555;" >PASSWORD:</a>
        <input type="password" name="password" style="font-family: Ubuntu-Regular;  font-size: 20px;  color: #555555;"/>
		</div>
 
		<div class="botao">
		<input type="submit" class="submit" name="submit" value="Login" />
		</div>
			</div>
	</form>
	<div class="qualf">
		<div class="image"></div>
    
    </div>
	
<?php
} else {
	require 'php/connect.php';
	//error_reporting(0); 
	$mysqli = new mysqli("$servername", "$username", "$password", "$dbname");
	
	if ($mysqli->connect_errno) {
		echo "<p>MySQL error no {$mysqli->connect_errno} : {$mysqli->connect_error}</p>";
		exit();
	}
 
	session_start();
	$username = $_POST['username'];
	$pass = $_POST['password'];
	echo $username;
	echo $pass;
	$password = sha1($pass);
	echo $password;
 
	$sql = "SELECT * from users WHERE username LIKE '{$username}' AND password LIKE '{$password}' LIMIT 1;";
	$result = $mysqli->query($sql);
	$row=mysqli_fetch_array($result);
	$_SESSION['username']=$row['username'];
	if (!$result->num_rows == 1) {
		echo header('location: login.php');
	} else {
		$_SESSION['username']=$row['username'];
		echo header('location: home.php');
		
	}
}
?>		

	
	