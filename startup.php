<?php
ini_set("display_errors","0");
header("Content-Type: text/html; charset=windows-1251");
setlocale(LC_ALL, 'ru_RU.CP1251', 'rus_RUS.CP1251', 'Russian_Russia.1251');

// ��������� �������
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/db_mysql.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_servers.php';
server_detect();


include_once $_SERVER['DOCUMENT_ROOT'].'/config.php'; //���������
include_once $_SERVER['DOCUMENT_ROOT'].'/config_tables.php'; //���������
include_once $_SERVER['DOCUMENT_ROOT'].'/global.php'; //�������� ������� �� 

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_messages.php';


include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_head.php'; // �������� ���� <HEAD>
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_tasks.php'; // ������� �������
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_workers.php'; // ������� �����������
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_boss.php'; // ������� �����������
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'; // ������ �������
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_left_menu.php'; //
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_top_panel.php'; //
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_navigation.php'; //
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_work.php'; //
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_messages.php'; //
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_files.php'; //
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_comments.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_users.php';
include_once ($_SERVER['DOCUMENT_ROOT'].'/includes/functions_upl.php');

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_boss.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_workers.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_colleagues.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_deputy.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_reprimand.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_video_instructions.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_user_data.php';
 

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_error.php';

// ����� ��������
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/class.Dialogs.php';

// ����� �����������
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/class.CAuth.php';
$auth = new CAuth($site_db);
$auth->check_auth();
// �������������� ������������
$current_user_id = $auth->get_current_user_id();

// ����� ������������
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/class.CUser.php';
$current_user_obj = new CUser($site_db);
$current_user_obj->fill_user_data($current_user_id);

if($current_user_obj->get_is_fired()  && $_GET['o'] != 'exit')
{  
	header('Location: /exit');
	exit();
}

$user_obj = new CUser($site_db);

// ��������� ���������� �������� 
set_current_user_global_array_data();
?>