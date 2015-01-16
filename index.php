<!DOCTYPE html>
<html style="height:100%;width:100%">
<head>
	<title>otaku fashion</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/form.css"/>
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css"/>
	<link rel="stylesheet" type="text/css" href="css/jquery.modal.css" media="screen"/>
	<link rel="stylesheet" type="text/css" href="css/main.css"/>
	<link rel="stylesheet" type="text/css" href="css/index.css"/>
	<script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
	<script src="js/jquery.jodometer.js" type="text/javascript"></script>
	<script src="js/jquery.modal.min.js" type="text/javascript"></script>
	<script src="js/login.js" type="text/javascript"></script>
	<script src="js/index.js" type="text/javascript"></script>
	<style>
		.counter2{
			width:108px;
			height:31px;
			overflow:hidden;
			position:absolute;
			top: 23.5%;
			left: 51.5%;
		}
		.counter3{
			width:180px;
			height:106px;
			overflow:hidden;
			position:absolute;
			top: 35%;
			left: 50%;
		}
		.RightButton{
			height:18%;
			margin:4%;
			z-index: 100;
			display: none;
		}
		.RightButton:hover{
			cursor: pointer;
		}
		.RightButton > p{
			-ms-transform: rotate(90deg); /* IE 9 */
			-webkit-transform: rotate(90deg); /* Chrome, Safari, Opera */
			transform: rotate(90deg);
			right: 10px;
			color: white;
			position: fixed;
		}
	</style>
<script type="text/javascript">
$(document).ready(function() {
	$(".username").focus(function() {
		$(".user-icon").css("left","-48px");
	});
	$(".username").blur(function() {
		$(".user-icon").css("left","0px");
	});
	
	$(".password").focus(function() {
		$(".pass-icon").css("left","-48px");
	});
	$(".password").blur(function() {
		$(".pass-icon").css("left","0px");
	});

	$("#Menu").click(function(){
		if($('#navbar').css('right') == '-150px'){
			$('.RightButton').show();
			$('#navbar').animate({right:"50"},1000);
		}
		else{
			$('#navbar').animate({right:"-150"},1000);
			$('.RightButton').hide();
		}
	});
});
</script>
</head>
<?php session_start(); ?>
<body style="background-color:black;height:100%;width:100%;overflow:hidden">

	<button id="Menu">Menu</button>
	<div id="logo" style="width:100%;text-align:center">
		<img src="images/logo.png" style="height:200px;width:90%;" />
	</div>
	<div id="navbar" style="height:100%;right:-150px;top:10px;position:fixed;">
		<div class="RightButton" id="go_home" >
		    	<p>Home</p>
				<img src="images/gokun.png" style="height:100%"/>
		</div>
		<div class="RightButton" id="Login" <?php if(!$_SESSION['id']) echo 'style="display:none"'; ?>>
		    	<p>Login</p>
			<a id="Loginbutton"  href="#loginform" rel="modal:open" onClick="loginOpen();">
				<img src="images/gohan.png" style="height:100%"/>
			</a>
		</div>
		<div class="RightButton" id="Logout" onClick="location.replace('logout.php');" <?php if($_SESSION['id']) echo 'style="display:none"'; ?>>
		    	<p>Logout</p>
				<img src="images/vegeta.png" style="height:100%"/>
		</div>
		<div class="RightButton" id="Upload" >
		    <p>Upload</p>
			<label for="file-input">
				<img src="images/trunks.png" style="height:100%"/>
			</label>
		</div>
		<div class="RightButton" id="Record" >
		    	<p>Record</p>
				<img src="images/beko.png" style="height:100%"/>
		</div>
	</div>
	<div id="back" style="height:100%;z-index:-1;top:150px;left:-200px;position:fixed" >
		<img src="images/background.png" style="height:100%"/>
		<img id="glass" src="images/glass-right.png" style="position:absolute;left:48%;top:17.5%;width:17%" />
		<div class="counter2"></div>
		<div class="counter3"></div>
	</div>
	<div>
		
	</div>

	<div id="upload_button" style="top:330px;right:120px;position:fixed">

		<form action="upload.php" id="FormUpload" method="post" enctype="multipart/form-data">
			<label for="file-input">
				<img id="file-img" src="" style="width:200px;z-index:0"/>
			</label>
			

			<input type="file" name="file" id="file-input" />
		</form>
	</div>
			<!--
  	<a href="#"><button class="boton"><input type="file" id="imgfile" name="imgfile" /></button></a>
  	<div class="footer"><h5>Developed by <a href="#">Otaku Fashion</a></h5>
  	<div class="flow">
      <boton class="copyright" title="Copyright © 2014 WP">©</boton>
  </div>
  -->

<!--WRAPPER-->
<div id="loginform" class="modal">

	<!--SLIDE-IN ICONS-->
    <div class="user-icon"></div>
    <div class="pass-icon"></div>
    <!--END SLIDE-IN ICONS-->

<!--LOGIN FORM-->
<form name="login-form" class="login-form" action="" method="post">

	<!--HEADER-->
    <div class="header" style="height:76px">
    <!--TITLE--><h1>Login Form</h1><!--END TITLE-->
    <!--DESCRIPTION--><span>Fill out the form below to login to my super awesome imaginary control panel.</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content">
	<!--USERNAME--><input name="username" type="text" class="input username" value="Username" onfocus="this.value=''" /><!--END USERNAME-->
    <!--PASSWORD--><input name="password" type="password" class="input password" value="Password" onfocus="this.value=''" /><!--END PASSWORD-->
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer">
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="Login" class="button" /><!--END LOGIN BUTTON-->
    <!--REGISTER BUTTON--><input type="submit" name="submit" value="Register" class="register" /><!--END REGISTER BUTTON-->
    </div>
    <!--END FOOTER-->

</form>
<!--END LOGIN FORM-->

</div>
<!--END WRAPPER-->

<!--
	<div id="loginform" class="modal">
		<div id="facebook">
			<i class="fa fa-facebook"></i>
			<div id="connect">Connect with Facebook</div>
		</div>
		<div id="mainlogin">
			<div id="or">or</div>
			<h1>Login to Upload your clothes</h1>
			<form id="LoginLogin" action="#">
				<input type="text" id="text" placeholder="your id" value="" required>
				<input type="password" id="password" placeholder="password" value="" required>
				<span id="formHide" style="display:none">
					<input type="password" id="password2" placeholder="password again" value="">
					<input type="text" id="name" placeholder="name" value="">
				
				</span>
				<button type="submit"><i class="fa fa-arrow-right"></i></button>
			</form>
			<div id="note">
				<a href="#">new user?</a>
			</div>

		</div>
	</div>
-->
</body>
</html>
