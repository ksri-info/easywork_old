<?php
header ( "Cache-control: no-cache" );
include_once $_SERVER['DOCUMENT_ROOT'].'/startup.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_files.php';

// ����� �����������
$auth = new CAuth($site_db);
 
$current_user_id = $auth->get_current_user_id();

if(!$current_user_id)
{
	exit();
}

$mode = $_GET['mode'];

// ��� �������� ����������� ��� ���������
if(preg_match('/goods/i', $_SERVER['HTTP_REFERER'])  && $mode=='2')
{
	// ������������ ���������� ������������ �����
	$max_upload_image_resolution = $max_upload_goods_image_resolution;
	$min_upload_image_resolution = $min_upload_goods_image_resolution;
	
	// ����. ������� �����������, �� ������� ����������� ����� ��������� ��� ������
	$max_upload_preview_image_width = $max_upload_preview_goods_image_width;
	$max_upload_preview_image_height = $max_upload_preview_goods_image_height;
	
}
// ��� �������� ����������� ��� ���������
if(preg_match('/contacts/i', $_SERVER['HTTP_REFERER'])  && $mode=='3')
{
	// ������������ ���������� ������������ �����
	$max_upload_image_resolution = $max_upload_goods_image_resolution;
	$min_upload_image_resolution = $min_upload_goods_image_resolution;
	
	// ����. ������� �����������, �� ������� ����������� ����� ��������� ��� ������
	$max_upload_preview_image_width = $max_upload_preview_contact_image_width;
	$max_upload_preview_image_height = $max_upload_preview_contact_image_height;
	
}
// ��� �������� ����������� ��� ������������ ��������
else if(preg_match('/id/i', $_SERVER['HTTP_REFERER']) && $mode=='1')
{
	// ������������ ���������� ������������ �����
	$max_upload_image_resolution = $max_upload_user_image_resolution;
	$min_upload_image_resolution = $min_upload_user_image_resolution;
	
	// ����. ������� �����������, �� ������� ����������� ����� ��������� ��� ������
	$max_upload_preview_image_width = $max_upload_preview_user_image_width;
	$max_upload_preview_image_height = $max_upload_preview_user_image_height;
}


// ���������� �����
$file_type = strtolower(substr($_FILES['uploadfile']['name'],strrpos($_FILES['uploadfile']['name'], '.')+1,10));

// �������� �����
$file_name =  generate_rand_string(7).'.'.$file_type; 
 
// ������ �����
$filesize = round(filesize($_FILES['uploadfile']['tmp_name']) / 1000);

// ������� �����������
list($width,$height)=getimagesize($_FILES['uploadfile']['tmp_name']);

// ����������� �������
$true_file_type = array('jpeg','jpg','gif','png');

// ��������� ���������� ������
if(!in_array($file_type, $true_file_type))
{
	echo '0';
	exit();
}

// ����������� � �������� �����
$blacklist = array(".php", ".phtml", ".php3", ".php4");

foreach ($blacklist as $item)
{
	if(preg_match("/$item\$/i", $_FILES['uploadfile']['name'])) {
		echo '0';
		exit;
	}
}
 
// ���� ���������� ������� ������
if($width > $max_upload_image_resolution || $height > $max_upload_image_resolution)
{
	echo '1';
	exit();
}
else if($width < $min_upload_image_resolution || $height < $min_upload_image_resolution)
{
	echo '1';
	exit();
}


// ���� ������ ������� �����
if($filesize > (int) ini_get('upload_max_filesize') * 1000)
{
	echo '2';
	exit();
}




// �������� ���������� �����
$image_file = TEMP_PATH.'/'.$file_name;   

// ����������� �������� ���������� �����


// �������� �����������
if(move_uploaded_file($_FILES['uploadfile']['tmp_name'], $image_file))
{
	$file_name = addslashes($file_name);
	
	// �������������� ����������
	if($width > $height)
	{
		// ���� ������ �������, ���������
		if($width > $max_upload_preview_image_width)
		{
			img_resize($image_file, $image_file, $max_upload_preview_image_width, NULL);
		}
	}
	else
	{
		// ���� ������ �������, ���������
		if($height > $max_upload_preview_image_height)
		{
			img_resize($image_file, $image_file, NULL, $max_upload_preview_image_height);
		}
			 
	}
	
	echo "ok|".$file_name;
	
}
 
 
  
?>
