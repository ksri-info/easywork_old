<?php
// ������ ���� ������
function fill_reprimand($user_id)
{
	global $site_db, $current_user_id;
	
	$main_tpl = file_get_contents('templates/reprimand/reprimand.tpl');
	
	$more_btn_tpl = file_get_contents('templates/reprimand/more_btn.tpl');
	 
	// ������� ������� ��������� ���������
	if($_SESSION['reprimand_delete'])
	{
		$_SESSION['reprimand_delete'] = '';
	}
	
	$type = value_proc($_GET['t']);
	$type = $type ? $type : 1;
	
	// ����� ���������� ���������
	if($_GET['wks'])
	{
		// �������� ��������� ����������� �������
		$sql = "SELECT reprimand_id FROM ".REPRIMANDS_TB." WHERE deleted<>1 ORDER by reprimand_id DESC LIMIT 1";
		
		$row = $site_db->query_firstrow($sql);
		
		if($row['reprimand_id'])
		{
			$_SESSION['last_reprimand_id'] = $row['reprimand_id'];
		}
		
		// ������ ��������� �����������
		$reprimand_list = fill_workers_reprimand_list($current_user_id, 1, $type);
		// ���-�� ��������� �����������
		$reprimands_count = get_workers_reprimands_count($current_user_id, $type);
		// ����� �������� ��������
		$add_form = fill_reprimand_add_form();
		
		$is_wks = 1;
	}
	else
	{
		// "��� ��������"
		$reprimand_list = fill_reprimand_list($user_id, 1, $type);
		// ���-�� ��� ���������
		$reprimands_count = get_reprimands_count($user_id, $type);
		
		$is_wks = 0;
	}
	
	
	// ���-�� �������
	$pages_count = ceil($reprimands_count/REPRIMANDS_PER_PAGE);
		
	// ���� ������� ������ 1
	if($pages_count > 1)
	{
		$more_btn = $more_btn_tpl;
	}
	 
	// ������� ����
	$top_menu = fill_reprimand_top_menu();
	
	$PARS['{ADD_FORM}'] = $add_form;
	
	$PARS['{REPRIMAND_LIST}'] = $reprimand_list;
	
	$PARS['{MORE_REPRIMAND}'] = $more_btn;

	$PARS['{TOP_MENU}'] = $top_menu;
	
	$PARS['{USER_ID}'] = $user_id;
	
	$PARS['{PAGES_COUNT}'] = $pages_count;
	
	$PARS['{IS_WKS}'] = $is_wks;
	
	$PARS['{TYPE}'] = $type;
	
	return fetch_tpl($PARS, $main_tpl);
}


// ������ ��������� �����������
function fill_reprimand_list($user_id, $page = 1, $type)
{
	global $site_db, $current_user_id, $user_obj;
	
	$no_reprimand_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/no_reprimand.tpl');
	
	$no_reprimand_1_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/no_reprimand_1.tpl');
	
	$page = $page ? $page : 1;
	// ������������
	$begin_pos = REPRIMANDS_PER_PAGE * ($page-1);
	
	$limit = " LIMIT ".$begin_pos.",".REPRIMANDS_PER_PAGE;
	
	// �������� ��������
	$sql = "SELECT * FROM ".REPRIMANDS_TB." WHERE worker_id='$user_id' AND deleted<>1 AND type='$type' ORDER by reprimand_id DESC $limit";
	  
	$res = $site_db->query($sql);
			
	while($row=$site_db->fetch_array($res))
	{
		$reprimand_list .= fill_reprimand_list_item($row);
	}
	
	if(!$reprimand_list)
	{
		$reprimand_list = $type==1 ? $no_reprimand_tpl : $no_reprimand_1_tpl;
	}
	
	return $reprimand_list;
}

// ������ ��������� �����������
function fill_workers_reprimand_list($user_id, $page = 1, $type)
{
	global $site_db, $current_user_id, $user_obj;
	
	$no_reprimand_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/no_reprimand.tpl');
	
	$no_reprimand_1_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/no_reprimand_1.tpl');
	
	// ��������� � ���� ������ �������
	$deleted_reprimand_ids = implode(', ', $_SESSION['reprimand_delete']);
	
	if($deleted_reprimand_ids)
	{
		$and_deleted_reprimands = " OR reprimand_id IN($deleted_reprimand_ids) ";
	}
	
	// ��������� ����������� ������������� �������
	if($_SESSION['last_reprimand_id'])
	{
		$and_reprimand_id = " AND reprimand_id <= '".$_SESSION['last_reprimand_id']."' ";
	}
	
	$page = $page ? $page : 1;
	// ������������
	$begin_pos = REPRIMANDS_PER_PAGE * ($page-1);
	
	$limit = " LIMIT ".$begin_pos.",".REPRIMANDS_PER_PAGE;
	
	// �������� ��������
	$sql = "SELECT * FROM ".REPRIMANDS_TB." WHERE boss_id='$user_id' AND (deleted<>1 $and_deleted_reprimands) AND type='$type' $and_reprimand_id  ORDER by reprimand_id DESC $limit";
	 
	$res = $site_db->query($sql);
			
	while($row=$site_db->fetch_array($res))
	{
		$reprimand_list .= fill_reprimand_list_item($row);
	}
	
	if(!$reprimand_list)
	{
		$reprimand_list = $type==1 ? $no_reprimand_tpl : $no_reprimand_1_tpl;
	}
	
	return $reprimand_list;
}

// ������� ��������
function fill_reprimand_list_item($reprimand_data, $for_personal=0)
{
	global $site_db, $current_user_id, $user_obj;
	
	if($for_personal==1)
	{ 
		$reprimand_list_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/reprimand_list_item_on_personal.tpl');
	}
	else
	{
		$reprimand_list_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/reprimand_list_item.tpl');
	}
	
	$edit_tools_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/edit_tools.tpl');

	$reprimand_confirm_btn_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/reprimand_confirm_btn.tpl');
	
	$type_str_1_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/type_str_1.tpl');
	$type_str_2_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/reprimand/type_str_2.tpl');
	
	// ������ �������� ������� �������� ��������������
	if($current_user_id==$reprimand_data['boss_id'])
	{
		$PARS['{REPRIMAND_ID}'] = $reprimand_data['reprimand_id'];
		
		$edit_tools = fetch_tpl($PARS, $edit_tools_tpl);
	}
	
	// ��� ���������� ������� ������ �������������, ���� ���� ����� �������������� ������� ������������
	if($reprimand_data['worker_id']==$current_user_id && $reprimand_data['noticed']==0)
	{
		$PARS_1['{REPRIMAND_ID}'] = $reprimand_data['reprimand_id'];
		
		// ������ ������������� ��� ������ ��� ����������
		$reprimand_confirm_btn = fetch_tpl($PARS_1, $reprimand_confirm_btn_tpl);
		
		$not_confirm = 'not_confirm';	
	}
	
	if($reprimand_data['noticed']==0)
	{
		if($reprimand_data['worker_id']==$current_user_id)
		{
			//not_confirm_status_str = '�� ����������';
		}
		else if($reprimand_data['boss_id']==$current_user_id)
		{
			$not_confirm_status_str = '(�� ����������)';
		}
		$not_confirm = 'not_confirm';
	}
	
	$date_add = datetime($reprimand_data['date'], '%j %M � %H:%i');
	
	// ��������� ������ ������������, ���� ������ �������
	$user_obj->fill_user_data($reprimand_data['worker_id']);
	$to_name = $user_obj->get_user_name();
	$to_surname = $user_obj->get_user_middlename();
	$to_moddlename = $user_obj->get_user_surname();
	
	
	// ��������� ������ ������������
	$user_obj->fill_user_data($reprimand_data['boss_id']);
	
	// ������ �������� ������������
	$user_avatar_src = get_user_preview_avatar_src($reprimand_data['boss_id'], $user_obj->get_user_image());
	
	if($reprimand_data['type']==1)
	{
		$type_str = $type_str_1_tpl;
	}
	else if($reprimand_data['type']==2)
	{
		$type_str = $type_str_2_tpl;
	}
	
	$PARS['{USER_ID}'] = $reprimand_data['boss_id'];
	
	$PARS['{AVATAR_SRC}'] = $user_avatar_src;
			
	$PARS['{USER_NAME}'] = $user_obj->get_user_name();
		
	$PARS['{USER_MIDDLENAME}'] = $user_obj->get_user_middlename();
			
	$PARS['{USER_SURNAME}'] = $user_obj->get_user_surname();
			
	$PARS['{USER_POSITION}'] = $user_obj->get_user_position();
	
	
	$PARS['{TO_NAME}'] = $to_name;
		
	$PARS['{TO_MIDDLENAME}'] = $to_surname;
			
	$PARS['{TO_SURNAME}'] = $to_moddlename;
	
	
	$PARS['{EDIT_TOOLS}'] = $edit_tools;
	
	$PARS['{DATE_ADD}'] = $date_add;
		
	$PARS['{REPRIMAND_ID}'] = $reprimand_data['reprimand_id'];
	
	$PARS['{REPRIMAND_TEXT}'] = nl2br($reprimand_data['reprimand_text']);
	
	$PARS['{REPRIMAND_CONFIRM_BTN}'] = $reprimand_confirm_btn;
	
	$PARS['{NOT_CONFIRM}'] = $not_confirm;
	
	$PARS['{NOT_CONFIRM_STATUS}'] = $not_confirm_status_str;
	
	$PARS['{TYPE}'] = $type_str;
	
	return fetch_tpl($PARS, $reprimand_list_item_tpl);
}

// ����� ���������� ��������
function fill_reprimand_add_form()
{
	global $site_db, $current_user_id, $user_obj;
	
	$option_tag_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/tags/option.tpl');
	
	$add_form_tpl = file_get_contents('templates/reprimand/add_form.tpl');
	
	$user_workers_arr = get_current_user_users_arrs(array(0,1,0,0,1), 1);
	
	if(!$user_workers_arr)
	{
		return '';
	}
	
	 
	
	foreach($user_workers_arr as $user_data)
	{
		$user_obj->fill_user_data($user_data['user_id']);
		
		$user_name = $user_obj->get_user_name();
		
		$user_middlename = $user_obj->get_user_middlename();
		
		$user_surname = $user_obj->get_user_surname();
		
		$user_position = $user_obj->get_user_position();
		
		$PARS['{VALUE}'] = $user_data['user_id'];
		
		$PARS['{NAME}'] = $user_surname.' '.$user_name.' '.$user_middlename;
		
		$PARS['{SELECTED}'] = '';
		
		$boss_list .= fetch_tpl($PARS, $option_tag_tpl);
	}
	
	
	$PARS['{WORKERS_LIST}'] = $boss_list;
	
	return fetch_tpl($PARS, $add_form_tpl);
}

// ������� ����
function fill_reprimand_top_menu()
{
	global $site_db, $current_user_id, $_CURRENT_USER_WORKERS_ARR;
	
	$top_menu_tpl = file_get_contents('templates/reprimand/top_menu.tpl');
	
	$top_menu_workers_tpl = file_get_contents('templates/reprimand/top_menu_workers.tpl');
	
	// ���� � ������������ ��� �����������, �� ������� ������ "������� ���� �����������"
	if($_CURRENT_USER_WORKERS_ARR)
	{
		$workers_top_menu = $top_menu_workers_tpl;
	}
	
	if($_GET['wks'] && $_GET['t']==1)
	{
		$active_menu_2 = 'menu_active';
	}
	else if($_GET['wks'] && $_GET['t']==2)
	{
		$active_menu_3 = 'menu_active';
	}
	else if($_GET['t']==2)
	{
		$active_menu_4 = 'menu_active';
		// ������� �����������
		//noticed_reprimand_by_user_id($current_user_id);
	}
	else
	{
		$active_menu_1 = 'menu_active';
		// ������� �����������
		//noticed_reprimand_by_user_id($current_user_id);
	}
	
	$new_workers_reprimand_count = get_new_workers_reprimands_count($current_user_id, 1);
	$new_workers_reprimand_count_for_worker_type_1 = $new_workers_reprimand_count ? ' (+ '.$new_workers_reprimand_count.')' : '';
	
	$new_workers_reprimand_count = get_new_workers_reprimands_count($current_user_id, 2);
	$new_workers_reprimand_count_for_worker_type_2 = $new_workers_reprimand_count ? ' (+ '.$new_workers_reprimand_count.')' : '';
	
	$PARS_1['{WORKERS_TOP_MENU}'] = $workers_top_menu;
	
	$PARS_1['{ACTIVE_1}'] = $active_menu_1;
	
	$PARS_1['{ACTIVE_2}'] = $active_menu_2;
	
	$PARS_1['{ACTIVE_3}'] = $active_menu_3;
	
	$PARS_1['{ACTIVE_4}'] = $active_menu_4;
		
	$PARS_1['{NEW_COUNT_FOR_WORKER_TYPE_1}'] = $new_workers_reprimand_count_for_worker_type_1;
	
	$PARS_1['{NEW_COUNT_FOR_WORKER_TYPE_2}'] = $new_workers_reprimand_count_for_worker_type_2; 
	
	return fetch_tpl($PARS_1, $top_menu_tpl);

}

// ������ ����� ����������� � ���������
function noticed_reprimand_by_user_id($user_id)
{
	global $site_db, $current_user_id;
	
	$sql = "UPDATE ".REPRIMANDS_TB." SET noticed=1 WHERE worker_id='$user_id'";
	
	$site_db->query($sql);
}

function get_reprimands_count($user_id, $type)
{
	global $site_db, $current_user_id;
	
	// ���-�� ����������
	$sql = "SELECT COUNT(*) as count FROM ".REPRIMANDS_TB." WHERE worker_id='$user_id' AND deleted<>1 AND type='$type'";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

function get_workers_reprimands_count($user_id, $type)
{
	global $site_db, $current_user_id;
	
	// ���-�� ����������
	$sql = "SELECT COUNT(*) as count FROM ".REPRIMANDS_TB." WHERE boss_id='$user_id' AND deleted<>1 AND type='$type'";
 
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

// ���-�� ����� �� ���������� ��� ����������
function get_new_workers_reprimands_count($user_id, $type)
{
	global $site_db, $current_user_id;
	
	// ���-�� ����������
	$sql = "SELECT COUNT(*) as count FROM ".REPRIMANDS_TB." WHERE worker_id='$user_id'  AND deleted<>1 AND noticed=0 AND type='$type'";
  
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

?>