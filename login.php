<?php
require_once("db_const.php");
session_start();
$name=htmlspecialchars($_POST['name'], ENT_QUOTES);
$passwd=htmlspecialchars($_POST['passwd']);
$passwd2=htmlspecialchars($_POST['passwd2']);
$id=htmlspecialchars($_POST['id'], ENT_QUOTES);
/* login */
if( ($passwd2=="null" && $name=="null") 
	|| ($passwd2==null && $name==null) ){  
		$sql = "select * from `user` where `userid`='".$id."'";
		$result=$mysqli->query($sql);
		$row=$result->fetch_array();
		if(!$row) 
			echo "使用者不存在，請重新註冊";
		else if(md5($passwd."ClotheS")!=$row['passwd']) 
			echo "密碼錯誤";
		else{
			echo "yes";
			$_SESSION['id']=$row['id'];
		}
		return;
	}
/* check user */
$sql = "select * from `user` where `userid`='".$id."'";
$result=$mysqli->query($sql);
$row=$result->fetch_array();
if($row){ echo "使用者已存在"; return;}
/* register */
if($passwd!=$passwd2){ echo "密碼不同"; return;}
$sql = "INSERT INTO `user`(`userid`, `name`, `passwd`) VALUES ('".$id."','".$name."','".md5($passwd."ClotheS")."')";
$result=$mysqli->query($sql);
$_SESSION['id']=$result->id;
echo "yes";
?>

