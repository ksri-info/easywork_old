<?php
header ( "Cache-control: no-cache" );
include_once $_SERVER['DOCUMENT_ROOT'].'/startup.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_files.php';

// ����� �����������
$auth = new CAuth($site_db);

$mode = $_POST['mode'];

$current_user_id = $auth->get_current_user_id();

if(!$current_user_id)
{
	exit();
}

// id �����
$folder_id = $_GET['folder_id'];

// �������� ����� ������?
$is_sharing = $_GET['is_sharing'];

// ���������� �����
$file_type = substr($_FILES['uploadfile']['name'],strrpos($_FILES['uploadfile']['name'], '.'),10);

$new_file_name = rand(1000000,9999999).'_'.$current_user_id.''.$file_type;

$uploaddir = TEMP_PATH; 
 
// �������� �����
$file_name =  strip_tags(htmlspecialchars($_FILES['uploadfile']['name'])); 

// ������ �����
$filesize = round(filesize($_FILES['uploadfile']['tmp_name']) / 1000);
$filesize_byte = filesize($_FILES['uploadfile']['tmp_name']);

if($filesize_byte > 104857600)
{
	echo '2';
	exit();
}


// �������� ���������� �����
$file = $uploaddir.'/'.$new_file_name;   


// ����������� �������� ���������� �����
$blacklist = array(".php", ".phtml", ".php3", ".php4");

foreach ($blacklist as $item)
{
	if(preg_match("/$item\$/i", $_FILES['uploadfile']['name'])) {
		echo '1';
		exit;
	}
}

// �������� �����������
if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $file))
{
	echo "ok|".$file_name."|".$new_file_name;
}
 

 
  
?>
