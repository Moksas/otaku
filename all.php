<!DOCTYPE html>
<html style="height:100%;width:100%">
<head>
	<title>otaku fashion</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="css/user.css" />
	<link rel="stylesheet" type="text/css" href="css/main.css"/>
	<script src="js/jquery-1.2.6.min.js" type="text/javascript"></script>
	<script src="js/masonry.pkgd.min.js"></script>
<style>
		.RightButton{
			height:18%;
			margin:4%;
			z-index: 100;
			display: none;
		}
		.RightButton *,#Menu:hover{
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
<script>
$(document).ready(function(){
	$("#Menu").click(function(){
		if($('#navbar').css('right') == '-150px'){
			$('.RightButton').show();
			$('.HideButton').hide();
			$('#navbar').animate({right:"50"},1000);
		}
		else{
			$('#navbar').animate({right:"-150"},1000);
			$('.RightButton').hide();
		}
	});
});
jQuery(window).load(function(){
	$(".plan").each(function(){
		var H = $(this).height();
//		var H = $(this).find("img").height();
		$(this).height(H+15);
	});
  var container = document.querySelector('#pricing-table');
  var msnry = new Masonry( container, {
    columnWidth: 230
  });
});
</script>
<?php session_start(); ?>
</head>
<body style="background-color:black;height:100%;width:100%;overflow-x:hidden">
	<div id="logo" style="width:100%;text-align:center">
		<img src="images/logo.png" style="height:200px;width:90%;" />
		<img src="images/dragon.jpg" style="width: 8%" id="Menu"/>
	</div>
	<div id="navbar" style="height:100%;right:-150px;top:10px;position:fixed;">
		<div class="RightButton" id="go_home" onClick="location.href='./'">
		    	<p>Home</p>
				<img src="images/gokun.png" style="height:100%"/>
		</div>
<?php 
	if(!isset($_SESSION['id'])){
		echo '
		<div class="RightButton" id="Login" >
		    	<p>Login</p>
			<a id="Loginbutton"  href="#loginform" rel="modal:open" onClick="loginOpen();">
				<img src="images/gohan.png" style="height:100%"/>
			</a>
		</div>';
	}
	else{
		echo '
		<div class="RightButton" id="Logout" onClick="location.replace(\'logout.php\');" >
		    	<p>Logout</p>
				<img src="images/vegeta.png" style="height:100%"/>
		</div>';
		echo '
		<div class="RightButton" id="Record" onClick="location.href=\'user.php\';">
		    	<p>Record</p>
				<img src="images/beko.png" style="height:100%"/>
		</div>';
	}
?>
	</div>

	<div id="pricing-table" class="clear" style="overflow-x:auto">
<?php
	 require_once("db_const.php");
	$sql="SELECT * FROM `userpic`";
	 $result=$mysqli->query($sql);
	$i=1;
	 while($rows=$result->fetch_array())
	 {
	 		echo '<div class="item h'.$i.'">';
				echo '<div class="plan">';
			
				echo '<h3>'.$rows['uploadtime'].'<span>'.$rows['score'].'</span></h3>';
				echo '<img src="../newupload/'.$rows['filename'].'" style="width:180px">';
				echo '</div>';
			echo '</div>';
			++$i;
	 		if($i>3) $i=1;
	 
	 }
?>	
</body>
</html>
