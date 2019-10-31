<?php
// ������ ���� ������
function fill_cnews($user_id)
{
	global $site_db, $current_user_id, $current_user_obj;
	
	set_user_read_cnews_cookie();
	
	// ������� ������� ��������� ���������
	if($_SESSION['cnews_delete'])
	{
		$_SESSION['cnews_delete'] = '';
	}
	
	// �������� ��������� ����������� �������
	$sql = "SELECT cnews_id FROM ".CNEWS_TB." WHERE deleted<>1 ORDER by cnews_id DESC LIMIT 1";
	
	$row = $site_db->query_firstrow($sql);
	
	if($row['cnews_id'])
	{
		$_SESSION['last_cnews_id'] = $row['cnews_id'];
	}
		
	$main_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/cnews/cnews.tpl');

	$more_btn_tpl = file_get_contents('templates/cnews/more_btn.tpl');
	
	// ��� ������
	if($current_user_obj->get_is_admin())
	{
		// ����� ���������� �������
		$add_form = fill_cnews_add_form();
	}
	
	// ������ ��������
	$cnews_list = fill_cnews_list();
	
	// ���-�� ��������
	$cnews_count = get_cnews_count();
	
	// ���-�� �������
	$pages_count = ceil($cnews_count/CNEWS_PER_PAGE);
		
	// ���� ������� ������ 1
	if($pages_count > 1)
	{
		$more_btn = $more_btn_tpl;
	}
	
	// ���� ������� ������ 1
	if($pages_count > 1)
	{
		$more_btn = $more_btn_tpl;
	}
	
	$PARS['{ADD_FORM}'] = $add_form;
	
	$PARS['{CNEWS_LIST}'] = $cnews_list;
	
	$PARS['{PAGES_COUNT}'] = $pages_count;
	
	$PARS['{MORE_BTN}'] = $more_btn;
	 
	return fetch_tpl($PARS, $main_tpl);
}

function fill_cnews_add_form()
{
	$add_form_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/cnews/add_form.tpl');
	
	return $add_form_tpl;
}

// ������ ��������
function fill_cnews_list($page = 1)
{
	global $site_db;
	
	$no_cnews_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/cnews/no_cnews.tpl');
	
	$page = $page ? $page : 1;
	// ������������
	$begin_pos = CNEWS_PER_PAGE * ($page-1);
	
	$limit = " LIMIT ".$begin_pos.",".CNEWS_PER_PAGE;
	
	// ��������� � ���� ������ �������
	$deleted_cnews_ids = implode(', ', $_SESSION['cnews_delete']);
	
	if($deleted_cnews_ids)
	{
		$and_deleted_cnews = " OR cnews_id IN($deleted_cnews_ids) ";
	}
	
	// ��������� ����������� ������������� �������
	if($_SESSION['last_cnews_id'])
	{
		$and_cnews_id = " AND cnews_id <= '".$_SESSION['last_cnews_id']."' ";
	}
	
	$sql = "SELECT * FROM ".CNEWS_TB." WHERE (deleted <> 1 $and_deleted_cnews) $and_cnews_id ORDER by cnews_id DESC $limit";
	
	$res = $site_db->query($sql);
			
	while($row=$site_db->fetch_array($res))
	{
		$news_list.= fill_cnews_item($row);
	}
	
	if(!$news_list)
	{
		$news_list = $no_cnews_tpl;
	}
	
	return $news_list;
}

// ���������� �������� �������
function fill_cnews_item($cnews_data, $form)
{
	global $site_db, $current_user_id, $user_obj, $current_user_obj;
	
	if($form=='edit')
	{
		$cnews_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/cnews/cnews_item_edit.tpl');
	}
	else
	{
		$cnews_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/cnews/cnews_item.tpl');
	}
	
	$edit_tools_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/cnews/edit_tools.tpl');
	
	 
	// ���� ��������� �� �������� ���������� ����������� ��� ���������
	if($current_user_obj->get_is_admin())
	{
		$PARS['{CNEWS_ID}'] = $cnews_data['cnews_id'];
		
		$edit_tools = fetch_tpl($PARS,  $edit_tools_tpl);
	}
	
	// ��������� ������ ������������
	$user_obj->fill_user_data($cnews_data['user_id']);
	
	$PARS['{USER_ID}'] = $cnews_data['user_id'];
	
	$PARS['{USER_NAME}'] = $user_obj->get_user_name();
		
	$PARS['{USER_MIDDLENAME}'] = $user_obj->get_user_middlename();
			
	$PARS['{USER_SURNAME}'] = $user_obj->get_user_surname();
			
	$PARS['{USER_POSITION}'] = $user_obj->get_user_position();
	
	$PARS['{USER_WRD_END}'] = get_words_end_by_user_sex($user_obj->get_user_sex());
	
	 
	$PARS['{CNEWS_ID}'] = $cnews_data['cnews_id'];
	
	$PARS['{CNEWS_ID}'] = $cnews_data['cnews_id'];
	
	$PARS['{CNEWSDATE_ADD}'] = datetime($cnews_data['date_add'], '%d %F %Y, %H:%i:%s');
	
	$PARS['{DATE_MONTH_RUS}'] = datetime($cnews_data['date_add'], '%M');
	
	$PARS['{DATE_DAY_RUS}'] = datetime($cnews_data['date_add'], '%d');
	
	$PARS['{CNEWS_THEME}'] = $cnews_data['cnews_theme'];
	
	$PARS['{CNEWS_TEXT}'] = $form=='edit' ? $cnews_data['cnews_text'] : nl2br($cnews_data['cnews_text']);
	
	$PARS['{EDIT_TOOLS}'] = $edit_tools;
	
	return fetch_tpl($PARS, $cnews_item_tpl);
}

// ���-�� �������� ��������
function get_cnews_count()
{
	global $site_db;
	
	$sql = "SELECT COUNT(*) as count FROM ".CNEWS_TB." WHERE deleted <> 1";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

// ������ �������
function get_cnews_data($cnews_id)
{
	global $site_db, $current_user_id, $user_obj;
	
	$sql = "SELECT * FROM ".CNEWS_TB." WHERE cnews_id='$cnews_id'";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row;
}

function get_cnews_cookie_name()
{
	global $site_db, $current_user_id;
	
	return 'ews_cnews'.$current_user_id;
}
function set_user_read_cnews_cookie()
{
	global $site_db, $current_user_id;
	
	$actual_cnews_ids = get_actual_news_ids();
	
	$cnews_ids = implode('_', $actual_cnews_ids);
	
	// �������� ���� ��� ��������
	$cnews_cookie_name = get_cnews_cookie_name();
	
	if($actual_cnews_ids && $_COOKIE[$cnews_cookie_name]!=$cnews_ids)
	{
		setcookie($cnews_cookie_name,  $cnews_ids, time() + 3600 * 24 * 4, "/");
	}
}

// �������� ���������� id �������� �������� � ��������� ���� ����
function get_actual_news_ids()
{
	global $site_db, $current_user_id;
	
	$cnews_arr = array();
	
	$actual_cnews_date = date('y-m-d', time() - 3600 * 24 * 2);
	
	$sql = "SELECT cnews_id FROM ".CNEWS_TB." WHERE date_add > '$actual_cnews_date' AND deleted <> 1 AND user_id <> '$current_user_id'";
	
	$res = $site_db->query($sql);
	
	while($row=$site_db->fetch_array($res))
	{
		$cnews_arr[] = $row['cnews_id'];
	}
	
	sort($cnews_arr);
	
	return $cnews_arr;
}
// ������� ������ ��� ��������
function get_new_cnews_counts()
{ 
	global $site_db, $current_user_id;
	
	// �������� ���� ��� ��������
	$cnews_cookie_name = get_cnews_cookie_name();
	
	$actual_cnews_ids = get_actual_news_ids();
	
	$cnews_ids = implode('_', $actual_cnews_ids);
	
	$cookie_cnews_ids = array();
	// ���� ���� ������ � ����� ��������
	if($_COOKIE[$cnews_cookie_name])
	{
		$cookie_cnews_ids = split('_', $_COOKIE[$cnews_cookie_name]);
	}
	
	
	// ���� ���� ������� �� ��������� ��� � ���� ��������� ��� �� �����������, ���������� 1
	if($actual_cnews_ids && $_COOKIE[$cnews_cookie_name]!=$cnews_ids && array_diff($actual_cnews_ids, $cookie_cnews_ids))
	{ 
		return '1';
	}
	else return 0;
	
}
?>