<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/startup.php';

if($_GET['info']==5) phpinfo(); 

if($_GET['o']=='pub_file')
{
	 
}
else
{
	// �������� �����������
	if(!$_SESSION['user_id'] && $_GET['o'] != 'auth' && $_GET['o']!='disk_gdrive_auth')
	{
		header('Location: /auth');
		exit();
	}
	
	ini_set('log_errors', 'On');
	ini_set('error_log', $_SERVER['DOCUMENT_ROOT'].'/log.txt');
	
	// �������������� ������������ �� ������ �������� ��� �������������
	redirect_user_to_page($current_user_id);
	
	// ������������� ������ ��������� �� ����
	//tasks_date_to_actual($current_user_id);
		
	// ������ � ���� ���� ���������� ��������� ������������ �� �����
	set_last_user_visit_date($current_user_id);
	
	
	 
}

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_worktime.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_content.php';
 

fill_content($o);

?>
