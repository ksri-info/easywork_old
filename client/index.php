<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/client/startup.php';

// �������� �����������
if(!$auth_obj->check_auth() && $_GET['o'] != 'auth')
{
	header('Location: /client/auth');
	exit();
}

ini_set('log_errors', 'On');
ini_set('error_log', 'log.txt');

// �������������� ������
$current_client_id = $auth_obj->get_current_client_id();

// ������� ���������� ��������� �������
set_last_client_visit_date($current_client_id);


// ���������� ������
$o = isset($_GET['o']) && $_GET['o']!='' ? $_GET['o'] : 'msgs';
 

// ������
switch($o)
{	

	case 'download':
		include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_files.php'; 
		
		$file_id = $_GET['file_id'];
		
		$body_content = fill_download_cl($file_id);

	break;
	// ������ ������ �������
	case 'files':
		
		include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_files.php'; 
		
		$body_content = fill_clients_files($current_client_id, 'client');
		
		$nav_obj = 'files';
		
	break;
	case 'msgs':
		
		include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_messages.php'; 
		include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_users.php';
		 
		$body_content = fill_client_messages($current_client_id, 1, 0);
		
		$nav_obj = 'msgs';
		 
	break;
	// ����� ����������� ��� ��������
	case 'auth':
	
		include_once $_SERVER['DOCUMENT_ROOT'].'/client/includes/functions_auth.php'; 
		
	 	if($auth_obj->check_auth())
		{  
			header('Location: /');
		}
		// ������� ����� ��� �����������
		 
		$body_content = no_auth_fill();
		
	break;
	// ����� ��������������� ������������
	case 'exit':
	
		$auth_obj->auth_exit();
		
	break;
	default:
		$nav_obj = 'error404';
		$body_content = fill_404($o);
		
	break;
}

	
// html ������
$html_tpl = file_get_contents('templates/html.tpl');

// ������ ��������
$body_content_tpl = file_get_contents('templates/body_content.tpl');
$body_content_without_blocks_tpl = file_get_contents('templates/body_content_without_blocks.tpl');

switch($o)
{
	case 'auth':
		$PARS['{BODY}'] = $body_content_without_blocks_tpl;
	break;
	default:
		$PARS['{BODY}'] = $body_content_tpl;
	break;
}

$html_tpl = fetch_tpl($PARS, $html_tpl);


$PARS = array();

// ���������� ����� <head>
$PARS['{HEAD}'] = fill_head($o);
$PARS['{CONTENT}'] = $body_content;
$PARS['{NAV}'] = fill_client_nav($nav_obj);

// ��� �������� ����������� - �� ������� ��������� �����
if($o=='auth')
{
	$PARS['{TOP_PANEL}'] = '';
	$PARS['{FOOTER}'] = '';
}
else
{
	$PARS['{LEFT_MENU}'] = fill_left_menu($o);
	$PARS['{TOP_PANEL}'] = fill_top_panel($o);
	$PARS['{FOOTER}'] = file_get_contents('templates/footer.tpl');
}

$html_result = fetch_tpl($PARS, $html_tpl);

echo $html_result;
?>
