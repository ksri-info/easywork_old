<?php
// ��������� ������ �����������
function fill_head($o)
{
	global $db, $current_user_id;
	
	$head_tpl = file_get_contents('templates/head.tpl');
	
	$title_main= '������� ���������� ���������';
	
	if($o=='main' || $o=='workers')
	{
		$title = '��� ����������';
	}
	
	if($o=='tasks')
	{
		$title = '��� ������';
	}
	
	if($o=='registration')
	{
		$title = '����������� ������ ����������';
	}
	// ���� � ����������� �������� �� ����� ���������
	$not_check_new_msgs = 0;
	
	if($o=='msgs' && $_GET['id'])
	{
		$not_check_new_msgs = 1;
	}
	
	

	$PARS['{SCRIPTS}'] = get_scripts_list($o); 
	
	$PARS['{CSS}'] = get_css_list($o); 
	
	$PARS['{TITLE}'] = $title_main.' - '.$title ; 
	
	$PARS['{NEW_MSGS_COUNT}'] = $new_msgs_count; 
	
	$PARS['{CURRENT_USER_ID}'] = $current_user_id; 
	
	$PARS['{NOT_CHECK_NEW_MSGS}'] = $not_check_new_msgs; 
	
	$PARS['{O}'] = $o; 
	
	return fetch_tpl($PARS, $head_tpl);
}


// ��������� ������ ������������ ������
function get_css_list($o)
{ 
	switch($o)
	{
		case 'personal':
			$css_list = return_css_list_by_num(array(100,101));
		break;
		 
	}
	return $css_list;
}
// ���������� ������ ���������� ������� ������
function return_css_list_by_num($num_array)
{  
	$css_arr = array(
		100 => '<link rel="stylesheet" type="text/css" href="/js/fancybox/jquery.fancybox-1.3.4.css" media="screen" />'
	);
	
	foreach($num_array as $i)
	{
		 
		$css_list .= chr(10).$css_arr[$i];
	}
	
	return $css_list;
}

// ��������� ������ ������������ ��������
function get_scripts_list($o)
{
	switch($o)
	{
		case 'auth':
			$scripts_list = return_scripts_list_by_num(array(1));
		break;
		case 'msgs':
			$scripts_list = return_scripts_list_by_num(array(2));
		break;
		case 'files':
			$scripts_list = return_scripts_list_by_num(array(3,100));
		break;
		
		 
	}
	return $scripts_list;
}
// ���������� ������ ���������� ������� ��������
function return_scripts_list_by_num($num_array)
{
	$scripts_arr = array(
	1 => '<script src="/client/js/auth.js"></script>',
	2 => '<script src="/client/js/messages.js"></script>',
	3 => '<script src="/client/js/files.js"></script>',
	
	
	100 => '<script src="/js/ajaxupload.3.5.js"></script>' 
	);
	
	foreach($num_array as $i)
	{
		$scripts_list .= chr(10).$scripts_arr[$i];
	}
	
	return $scripts_list;
}
?>