<?php
$db_servertype = "mysql";
$db_host = $_SERVER_MYSQL_DB_HOST;
$db_name = $_SERVER_MYSQL_DB_NAME;
$db_user = $_SERVER_MYSQL_DB_USER;
$db_password = $_SERVER_MYSQL_DB_PASSWORD;

$google_client_id = '1058514656051-tder88ho0hk6cjlafq8pcptltvlosdkn.apps.googleusercontent.com';
$google_secret = 'vGji-U27G8-viLNbSnBAeRjz';
$google_redirect_uri = 'http://www.holding.bz/services/gdocs.php';
 
if(preg_match('/local/',$_SERVER['HTTP_HOST']))
{
	define ('SMS', 0);
	define ('HOST', 'local.tasks');
}
else
{
	define ('SMS', 1);
	define ('HOST', $_SERVER['HTTP_HOST']);
}

$postApiLogin = 'oaoKI';
$postApiPass = 'XMqYOEXwbV';

define ('PER_PAGE',20);

define ('USE_G_SERVICES', 1);

define ('KEY_WORD', 'tasks');

define ('CNEWS_PER_PAGE', 5);

define ('HISTORY_PER_PAGE', 3);

define ('DIALOGS_PER_PAGE', 10);

define ('MSG_PER_PAGE', 20);

// ���-�� ������ �� ��������
define ('PS_PER_PAGE', 5);

// ���-�� ������ �� ��������
define ('FILES_PER_PAGE', 50);

// ���-�� ������ �� ��������
define ('FILES_GROUP_PER_PAGE', 10);

// ���-�� ��������� ����� ������ �� ��������
define ('POSTTR_PER_PAGE', 20);

// ���-�� �������� �� ��������
define ('PROJECTS_PER_PAGE', 15);

// ���-�� ��������� �� ��������
define ('CONTACTS_PER_PAGE', 5);

// ���-�� ��������� �� ��������
define ('CLIENTS_PER_PAGE', 15);

// ���-�� ������ �� ��������
define ('DEALS_PER_PAGE', 15);

// ���-�� ������ �� �������� ������ �����������
define ('WORKERS_DEALS_PER_PAGE', 5);

// ���-�� ��������� �� ��������
define ('GOODS_PER_PAGE', 5);

// ���-�� ����� �� ��������
define('MONEY_PER_PAGE', 5);

// ���-�� �������� �� ��������
define('FINANCES_PER_PAGE', 5);

// ���-�� ������� �� ��������
define('COMMENTS_ON_MAIN_PER_PAGE', 2);

// ���-�� ����������� ����� �� 30 ���� �� ��������
define('TASKS_COMPLETED_ON_MAIN_PER_PAGE', 2);

// ���-�� ������������ �� ��������
define('PLANNING_PER_PAGE', 10);

// ���-�� ������������ �� ��������
define('OFDOCS_PER_PAGE', 10);

// ���-�� ��������� �� ��������
define('REPRIMANDS_PER_PAGE', 10);

// ���-�� ������� �� ��������
define('NOTES_PER_PAGE', 10);

// ���-�� ������� ����� ������������ �� ��������
define('WORK_REPORTS_PER_PAGE', 5);

// ���-�� ��������� � ������ �� ������� ��������
define('LIST_PER_PAGE_ON_MAIN', 2);

define('UPLOAD_FOLDER', 'upload/'.$_SERVER_ID);

// ���� �� ��������� ������
define('TEMP_PATH', $_SERVER['DOCUMENT_ROOT'].'/temp');

// ���� �� ������
define('UPLOAD_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.UPLOAD_FOLDER);

// ���� �� ������
define('FILES_PATH', $_SERVER['DOCUMENT_ROOT'].'/'.UPLOAD_FOLDER.'/uploads');

// ����� � ������ �������
define('SHARING_PATH', UPLOAD_PATH.'/files/sh');

// ����� � ������� ������������
define('PRIVATE_PATH', UPLOAD_PATH.'/files/pr');

// ����� � ������� �������
define('CLIENTS_PATH', UPLOAD_PATH.'/files/clients');

// ����� � ������� ������������
define('USERS_PATH', UPLOAD_PATH.'/users');

// ����� � ������� ���������
define('GOODS_PATH', UPLOAD_PATH.'/goods');

// ����� � ������� ���������
define('CONTACTS_PATH', UPLOAD_PATH.'/contacts');

// ����� � ������� ������� �������
define('REC_CALL_PATH', TEMP_PATH.'/rec_call/'.$_SERVER_ID);

// ����� � ������� ������� ����� �������
define('LOG_REC_PATH', TEMP_PATH.'/log_rec/'.$_SERVER_ID);

// ����� � ������� ������� �� ����� ������������
define('WORK_REPORTS_PATH', UPLOAD_PATH.'/work_reports');

define('SMS_FROM', 'EasyWork');

// ������������ ������ ������������ ����� � ��
define('UPLOAD_SIZE_LIMIT', 100);
define('UPLOAD_SIZE_LIMIT_IN_BYTES', 104857600);


#####
// ����. ������� �����������, �� ������� ����������� ����� ��������� ��� ������ ��� ������������ ��������
$max_upload_preview_user_image_width = 450;
$max_upload_preview_user_image_height = 450;

// ������������ ���������� ������������ ����� ��� ������������ ��������
$max_upload_user_image_resolution = 5000;
// ����������� ���������� ������������ ����� ��� ������������ ��������
$min_upload_user_image_resolution = 200;


// ����. ������� �����������, �� ������� ����������� ����� ��������� ��� ������ ��� ������������ ��������
$max_upload_preview_goods_image_width = 250;
$max_upload_preview_goods_image_height = 250;

// ����. ������� �����������, �� ������� ����������� ����� ��������� ��� ������ ��� ���������
$max_upload_preview_contact_image_width = 400;
$max_upload_preview_contact_image_height = 400;

// ������������ ���������� ������������ ����� ��� �������� 
$max_upload_goods_image_resolution = 5000;
// ����������� ���������� ������������ ����� ��� ������������ ��������
$min_upload_goods_image_resolution = 200;
?>
