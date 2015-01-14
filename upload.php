<?php
include("compare.php");
if($_FILES["file"]["error"]>0){

	echo 'test'.$_FILES['file']['error'];

}
else {
	echo "filename:".$_FILES['file']['name'].'<br/>';
	echo "filetype".$_FILES['file']['type'].'<br/>';
	echo "filesize".$_FILES['file']['size'].'<br/>';
	echo "tempname".$_FILES['file']['tmp_name'].'<br/>';

	if(file_exists("newupload/".$_FILES['file']['name'])){
		echo "the file is exist don't upload same file";
	}
	else {
		move_uploaded_file($_FILES['file']['tmp_name'], "newupload/".$_FILES['file']['name']);

	}
}


?>
