<?php
ini_set("display_errors","0");
header("Content-Type: text/html; charset=windows-1251");
// ��������� �������
include_once $_SERVER['DOCUMENT_ROOT'].'/servers_config.php'; //
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_servers.php';
server_detect();

include_once $_SERVER['DOCUMENT_ROOT'].'/config.php'; //���������
include_once $_SERVER['DOCUMENT_ROOT'].'/config_tables.php'; //���������
include_once $_SERVER['DOCUMENT_ROOT'].'/global.php'; //�������� ������� ��

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions.php'; // ��������
include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_head.php'; // �������� ���� <HEAD>
include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_left_menu.php'; // �������� ������ ����
include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_top_panel.php'; // �������� ������ ������
include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_navigation.php'; // ������ ���������
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_clients.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_error.php';

// ����� �����������
include_once $_SERVER['DOCUMENT_ROOT'].'/client/classes/class.CAuth.php';
$auth_obj = new CAuth($site_db);

// ����� ������������
include_once $_SERVER['DOCUMENT_ROOT'].'/classes/class.CUser.php';
$user_obj = new CUser($site_db);




?>