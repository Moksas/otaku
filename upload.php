<?php
session_start();
//include("compare.php");
$max_size = 3*1024*1024; //限制可檔案大小為3MB
$limitedext = array("bmp","gif","jpg","jpeg","png");//設定可上傳的檔案類型(副檔名)


$File_Extension = explode(".", $_FILES['file']['name'][0]); 
$File_Extension = $File_Extension[count($File_Extension)-1];
$_SESSION['username']='testname';
  //  echo'Hello world';
if(!(isset($_SESSION['username'])))
{
	echo "Please login before upload";

}
else
   	if($_FILES["file"]["error"][0]>0){

	//echo 'test'.$_FILES['file']['error'];
	echo "the file is wrong";
}
else if(($max_size > 0) && ($_FILES['file']['size'][0]> $max_size)){

	echo "您上傳的檔案大小大於".$max_size."位元組";


	exit;

}
else if(!in_array($File_Extension,$limitedext)){

	echo "not support()";

	exit;

}

else {

//	echo "filename:".$_FILES['file']['name'].'<br/>';
//	echo "filetype".$_FILES['file']['type'].'<br/>';
//	echo "filesize".$_FILES['file']['size'].'<br/>';
//	echo "tempname".$_FILES['file']['tmp_name'].'<br/>';
	$uniq_filename = sha1(uniqid(rand()));

	if(file_exists("../newupload/".$uniq_filename)){
		echo "the file is exist don't upload same file";
	}
	else {
		//if(is_dir('../newupload/'))
		//echo 'ok';
		//else echo'fail';
//		echo $uniq_filename.'</br>';
		move_uploaded_file($_FILES['file']['tmp_name'][0], "../newupload/"
			.$uniq_filename.'.'.$File_Extension);

		$_SESSION['CompareFile']=$uniq_filename.'.'.$File_Extension;
//		echo $_SESSION['CompareFile'];
		insertfiletodatabase($_SESSION['CompareFile'],$_SESSION['username']);
		echo"upload sucess";
	}

//	echo	docompare("../newupload/".$uniq_filename.'.'.$File_Extension);
}

	function insertfiletodatabase($filename,$username){
		require_once("db_const.php");
		$t=getdate();
		$timestr=$t["year"]."-".$t["mon"]."-".$t["mday"]." ".$t["hours"].":".$t["minutes"].":".$t["seconds"];
		$sql="INSERT INTO `clothes`.`userpic` (`fid` ,`user` ,`filename` ,`score`,`uploadtime`)
			VALUES (NULL , '".$username."', '".$filename."',NULL, '".$timestr."')";
//		echo "</br>".$timestr;
//		echo "</br>".$sql;
	$result=$mysqli->query($sql);
	}


?>



