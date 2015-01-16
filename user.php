<!DOCTYPE html>
<html style="height:100%;width:100%">
<head>
	<title>otaku fashion</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="user.css" />
	<script src="js/jquery-1.2.6.min.js" type="text/javascript"></script>
	<script src="js/masonry.pkgd.min.js"></script>
<script>
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
</head>
<body style="background-color:black;height:100%;width:100%;overflow:hidden">
	<div id="logo" style="width:100%;text-align:center">
		<img src="images/logo.png" style="height:200px;width:90%;" />
	</div>

	<div id="pricing-table" class="clear" style="overflow-x:auto">
<?php
	session_start();
	 require_once("db_const.php");
	$sql="SELECT *FROM `userpic`WHERE `user` = '".$_SESSION['username']."'";
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
