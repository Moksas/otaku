<?php
include("compare.php");
$max_size = 3*1024*1024; //限制可檔案大小為3MB
$limitedext = array("bmp","gif","jpg","jpeg","png");//設定可上傳的檔案類型(副檔名)

$File_Extension = explode(".", $_FILES['file']['name']); 
$File_Extension = $File_Extension[count($File_Extension)-1];
if($_FILES["file"]["error"]>0){

	//echo 'test'.$_FILES['file']['error'];
	echo "the file is wrong";
}
else if(($max_size > 0) && ($_FILES['file']['size'] > $max_size)){

	echo "您上傳的檔案大小大於".$max_size."位元組";

	exit;

}
else if(!in_array($File_Extension,$limitedext)){

	echo "not support()";

	exit;

}

else {

	echo "filename:".$_FILES['file']['name'].'<br/>';
	echo "filetype".$_FILES['file']['type'].'<br/>';
	echo "filesize".$_FILES['file']['size'].'<br/>';
	echo "tempname".$_FILES['file']['tmp_name'].'<br/>';
	$uniq_filename = sha1(uniqid(rand()));
	if(file_exists("../newupload/".$_FILES['file']['name'])){
		echo "the file is exist don't upload same file";
	}
	else {
		//if(is_dir('../newupload/'))
		//echo 'ok';
		//else echo'fail';
		echo $uniq_filename.'</br>';
		move_uploaded_file($_FILES['file']['tmp_name'], "../newupload/"
			.$uniq_filename.'.'.$File_Extension);

	}
	echo	docompare("../newupload/".$uniq_filename.'.'.$File_Extension);
}


?>



