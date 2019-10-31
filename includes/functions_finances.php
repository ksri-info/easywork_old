<?php
// ������ ��������
function fill_finances($user_id)
{
	global $site_db, $current_user_id;
	
	$main_tpl = file_get_contents('templates/finances/finances.tpl');
	
	$finances_add_form_tpl = file_get_contents('templates/finances/finances_add_form.tpl');
	
	$more_finances_btn_tpl = file_get_contents('templates/finances/more_finances_btn.tpl');
	 
	$no_finances_tpl  = file_get_contents('templates/finances/no_finances.tpl');
	
	$finances_top_menu_tpl  = file_get_contents('templates/finances/finances_top_menu.tpl');
	
	$top_menu = $finances_top_menu_tpl;
	
	if($_GET['av'])
	{
		// ������� ����������� � ����� ��������� ��������
		$sql = "UPDATE ".FINANCES_ACCESS." SET noticed=1 WHERE user_id='$current_user_id' AND noticed=0";
		
		$site_db->query($sql);
		
		$finance_av = 1;
	}
	// ���-�� ����� ��������
	$new_finances_count = get_new_user_finances_count($user_id);
	
	### ������� ����
	// ������������ ����
	if(!$_GET['av'])
	{
		$active_menu_1 = 'menu_active';
	}
	else
	{
		$active_menu_2 = 'menu_active';
	}
	
	
	$new_finances_count = $new_finances_count ? ' (+ '.$new_finances_count.')' : '';
	 
	$PARS_1['{NEW_FINANCES_COUNT}'] = $new_finances_count;
	
 	$PARS_1['{CURRENT_USER_ID}'] = $current_user_id;
	
	$PARS_1['{ACTIVE_1}'] = $active_menu_1;
	
	$PARS_1['{ACTIVE_2}'] = $active_menu_2; 


	// ������� ����
	$top_menu = fetch_tpl($PARS_1, $finances_top_menu_tpl);
	
	
	// �������� ��������� ����������� ����
	$sql = "SELECT finance_id FROM ".FINANCES_TB." WHERE finance_deleted<>1 ORDER by finance_id DESC LIMIT 1";
	
	$row = $site_db->query_firstrow($sql);
	
	if($row['finance_id'])
	{
		$_SESSION['last_user_finance_id'] = $row['finance_id'];
	}
	
	if(!$_GET['av'])
	{
		// ������ �����
		$currency_list = fill_currency_list(0);
		
		$PARS_1['{CURRENCY_LIST}'] = $currency_list;
		
		// ����� �������� �����
		$finances_add_form = fetch_tpl($PARS_1, $finances_add_form_tpl);
	}
	
	if($_GET['av'])
	{
		// ���-�� ��������
		$finances_count = get_user_accessed_finances_count($user_id);
	}
	else
	{
		// ���-�� ��������
		$finances_count = get_user_finances_count($user_id);
	}
	
	// ���-�� �������
	$pages_count = ceil($finances_count/FINANCES_PER_PAGE);
	
	// ���� ������� ������ 1
	if($pages_count > 1)
	{
		$more_finances_btn = $more_finances_btn_tpl;
	}
		
	// ���� ������� ������ 1
	if($pages_count > 1)
	{
		$more_goods_btn = $more_goods_btn_tpl;
	}
		
	// ������ ��������
	$finances_list = fill_user_finances_list($user_id, 1, $finance_av);
	
	if($finances_list=='')
	{
		$finances_list = $no_finances_tpl;
	}
	
	$PARS['{USER_ID}'] = $user_id;
	
	$PARS['{FINANCES_ADD_FORM}'] = $finances_add_form; 
	
	$PARS['{FINANCES_LIST}'] = $finances_list; 
	
	$PARS['{MORE_FINANCES}'] = $more_finances_btn;
	
	$PARS['{TOP_MENU}'] = $top_menu;
	
	$PARS['{PAGES_COUNT}'] = $pages_count;
	
	$PARS['{FINANCE_AV}'] = $finance_av;
	
	return fetch_tpl($PARS, $main_tpl);
}

// ������ �������� ������������
function fill_user_finances_list($user_id, $page=1, $finance_av)
{
	global $site_db, $current_user_id;
	
	// �������� ������ �������������, ����������� � ������������ (���������� � �����������)
	//$users_for_access_arr = get_current_user_users_arrs(array(1,1,0,0,0), 1);
	
	// ������������
	$begin_pos = FINANCES_PER_PAGE * ($page-1);
	
	$limit = " LIMIT ".$begin_pos.",".FINANCES_PER_PAGE;
	
	// ��������� ����������� ������������� �������
	if($_SESSION['last_user_finance_id'])
	{
		$and_finances_id = " AND finance_id <= '".$_SESSION['last_user_finance_id']."' ";
	}
	
	// ��������� � ���� ������ �������
	$deleted_finances_ids = implode(', ', $_SESSION['finance_deleted']);
	
	if($deleted_finances_ids)
	{
		$and_deleted_finances = " OR finance_id IN($deleted_finances_ids) ";
	}
	
	// ��������� ������� ������������
	if($finance_av)
	{
		$sql = "SELECT j.* FROM ".FINANCES_ACCESS." i
				LEFT JOIN ".FINANCES_TB." j ON i.finance_id=j.finance_id
				WHERE i.user_id='$user_id' AND j.finance_deleted<>1 ORDER by i.id DESC $limit";
	}
	// ������� ������������
	else
	{
		$sql = "SELECT * FROM ".FINANCES_TB." WHERE user_id='$user_id' AND (finance_deleted<>1 $and_deleted_finances) $and_finances_id 
				ORDER by finance_summa DESC $limit";
	}
	 
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		// ��������� ����
		$finances_list .= fill_finance_item($row);
	}
	
	return $finances_list;
}

// ���������� �������� �����
function fill_finance_item($finance_data)
{
	global $site_db, $current_user_id, $user_obj;
	
	$finances_list_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finances_list_item.tpl');
	
	$edit_tools_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/edit_tools.tpl');
	
	$access_btn_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/access_btn.tpl');
	
	// ������������, ������� �������� ���������� �������
	$accessed_users_arr = get_accessed_users_arr_for_finance($finance_data['finance_id']);
	
	if(($finance_data['user_id']==$current_user_id || in_array($current_user_id, $accessed_users_arr)) && get_current_user_users_arrs(array(1,1,1,1,1,1)))
	{
		
		$PARS['{FINANCE_ID}'] = $finance_data['finance_id'];
		
		$access_btn = fetch_tpl($PARS, $access_btn_tpl);
		//���� �������� ���������
		//$finance_access_block = fill_finance_access_block($finance_data['finance_id'], $users_for_access_arr);
	}
	
	// ��������� ������ ������������
	$user_obj->fill_user_data($finance_data['user_id']);
	
	$create_user_id = $finance_data['user_id'];
	
	$creat_user_surname = $user_obj->get_user_surname();
	
	$creat_user_name = $user_obj->get_user_name();
	
	$creat_user_middlename = $user_obj->get_user_middlename();
	
	$creat_user_position = $user_obj->get_user_position();
	
	// �������� ������
	$finance_currency = get_currency_value_by_id($finance_data['currency_id']);
	
	// ��������� �����
	$finance_summa = sum_process($finance_data['finance_summa'], ' ', '\.', 1);
	
	if($finance_data['user_id'])
	{
		// ������ ��� ��������������
		$PARS_1['{FINANCE_ID}'] = $finance_data['finance_id'];	
		
		$edit_tools = fetch_tpl($PARS_1, $edit_tools_tpl);
	}
	
	$PARS['{ACCESS_BTN}'] = $access_btn;
	
	$PARS['{FINANCE_ID}'] = $finance_data['finance_id'];
	
	$PARS['{FINANCE_NAME}'] = $finance_data['finance_name'];
	
	$PARS['{FINANCE_SUMMA}'] = $finance_summa;
	
	$PARS['{FINANCE_CURRENCY}'] = $finance_currency;
	
	$PARS['{CREATER_USER_ID}'] = $create_user_id;
	
	$PARS['{EDIT_TOOLS}'] = $edit_tools;
	
	$PARS['{CREATER_USER_ID}'] = $create_user_id;
	
	$PARS['{CREATER_USER_NAME}'] = $creat_user_name;
		
	$PARS['{CREATER_USER_MIDDLENAME}'] = $creat_user_middlename;
			
	$PARS['{CREATER_USER_SURNAME}'] = $creat_user_surname;
			
	$PARS['{CREATER_USER_POSITION}'] = $creat_user_position;
	
	$PARS['{FINANCE_ACCESS_BLOCK}'] = $finance_access_block;
	
	$PARS['{ADDED_BY}'] = $added_by_block;
	
	return fetch_tpl($PARS, $finances_list_item_tpl);
}

// �������������� �����
function fill_edit_finance($finance_id)
{
	global $site_db, $current_user_id;
	
	$edit_finance_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/edit_finance.tpl');

	// ������ �����
	$sql = "SELECT * FROM ".FINANCES_TB." WHERE finance_id='$finance_id'";
	
	$finance_data = $site_db->query_firstrow($sql);
	
	// ���� � ������������ ���� ����� �� �������������� �����
	if(!check_user_for_access_to_operation($finance_data, $finance_id, $current_user_id))
	{
		header('Location: /finances');
	}

	// �������� ������
	$finance_currency = get_currency_value_by_id($finance_data['currency_id']);
	
	// ��������� �����
	$finance_summa = sum_process($finance_data['finance_summa'], ' ', '\.', 1);
	
	// ���� ��������
	$finance_operations_types_list = fill_finance_operations_types_list();
	
	// ������ �������� �����
	$finance_operation_list = fill_finance_operations_list($finance_id, $finance_data);

	$finance_chart_30_days = fill_finance_chart($finance_id, 'month');
	
	$finance_chart_one_year = fill_finance_chart($finance_id, 'year');


	$PARS['{FINANCE_ID}'] = $finance_data['finance_id'];
	
	$PARS['{FINANCE_NAME}'] = $finance_data['finance_name'];
	
	$PARS['{FINANCE_SUMMA}'] = $finance_summa;

	$PARS['{FINANCE_OPERATIONS_TYPES_LIST}'] = $finance_operations_types_list;

	$PARS['{FINANCE_CURRENCY}'] = $finance_currency;

	$PARS['{FINANCE_OPERATIONS_LIST}'] = $finance_operation_list;

	$PARS['{FINANCES_CHARTS_30_DAYS}'] = $finance_chart_30_days;

	$PARS['{FINANCES_CHARTS_ONE_YEAR}'] = $finance_chart_one_year;

	$PARS['{CURRENT_NORM_DATE}'] = date('d.m.Y');

	return fetch_tpl($PARS, $edit_finance_tpl);
}

// ������� ������� ������� � ������� �������� �������
function fill_finance_chart($finance_id, $mode)
{
	global $site_db, $current_user_id;
	
	// ������ �����
	$finance_data = get_finance_data($finance_id);
	// ������
	$currency_value = get_currency_value_by_id($finance_data['currency_id']);
	
	// ������ �� ��������� 30 ����
	if($mode=='month')
	{
		$finance_chart_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finance_chart_30_days.tpl');
		
		$date_from = date('Y-m-d 00:00:00', time() - 3600 * 24 * 30);
		$date_to = date('Y-m-d 23:59:59');
		
		// ��������� ������ 30 ��������� ����
		$days_arr = fill_array_num_days_ago_from_actual_date(30, date('Y-m-d'));	
		
		// ���������� � ������� ����� ������ 
		$date_start = get_date_utc_for_js_object($date_from);	
	}
	// ������ �� ��������� ���
	else if($mode=='year')
	{
		$finance_chart_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finance_chart_one_year.tpl');
		
		$date_from = date('Y-m-01 00:00:00', time() - 3600 * 24 * 365);
		$date_to = date('Y-m-31 23:59:59');
		
		// ��������� ������ 12 ��������� �������
		$days_arr = fill_array_num_month_ago_from_actual_date(12, date('Y-m'));
		
		// ���������� � ������� ����� ������ 
		$date_start = get_date_utc_for_js_object($date_from);
	}
	
	// �������� �������� �� ������ �����
	$sql = "SELECT * FROM ".FINANCES_OPERATIONS_TB." WHERE  finance_id='$finance_id' AND operation_returned<>1 
			AND operation_date >= '$date_from' AND operation_date<='$date_to'";
	 
	$res = $site_db->query($sql);
	
	while($row=$site_db->fetch_array($res))
	{
		// ������ 30 ����
		if($mode=='month')
		{
			$date = substr($row['operation_date'],0,10);
		}
		// ������ �� ���
		if($mode=='year')
		{
			$date = substr($row['operation_date'],0,7);
		}
		 
		// �����������
		if($row['operation_type']==1)
		{
			$series_finances_in_arr[$date] += $row['operation_summa'];
			$series_finances_out_arr[$date] += 0;
		}
		// ������
		else if($row['operation_type']==2)
		{
			$series_finances_out_arr[$date] += $row['operation_summa'];
			$series_finances_in_arr[$date] += 0;
		}
	}
	
	if(!$series_finances_in_arr && !$series_finances_out_arr)
	{
		return '';
	}
	
	// ���������� ������ ���� � �������� ������� ������, ����� ������� ��� ��� � �������
	$series_finances_in_arr =  array_merge($days_arr, $series_finances_in_arr);
	$series_finances_out_arr =  array_merge($days_arr, $series_finances_out_arr);
	
	//echo "<pre>", print_r($series_finances_out_arr), "<pre>";
	//echo "<pre>", print_r($series_finances_in_arr), "<pre>";

	$series_finances_in = $series_finances_in_arr ? '['.implode(',', $series_finances_in_arr).']' : '[]';
	$series_finances_out = $series_finances_out_arr ? '['.implode(',', $series_finances_out_arr).']' : '[]';
	
	
	$PARS['{SERIES_DATE_START}'] = $date_start;
	
	$PARS['{SERIES_FINANCES_IN}'] = $series_finances_in;
	
	$PARS['{SERIES_FINANCES_OUT}'] = $series_finances_out;
	
	$PARS['{FINANCE_CURRENCY}'] = $currency_value;
	
	return fetch_tpl($PARS, $finance_chart_tpl);
}

// �������� �� ������ � �������������� �����
function check_user_for_access_to_operation($finance_data, $finance_id, $user_id)
{
	global $site_db, $current_user_id;
	
	if($finance_data['finance_id'] && $finance_data['user_id']==$user_id)
	{
		return true;
	}
	else if($finance_id)
	{
		$sql = "SELECT id FROM ".FINANCES_ACCESS." WHERE finance_id='$finance_id' AND user_id='$user_id'";	
		
		$row = $site_db->query_firstrow($sql);
		
		if($row['id'])
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		return false;
	}
}

// ���������� id ��������, ������� ����� ����� ��������
function get_finance_operation_can_returned($finance_id)
{
	global $site_db, $current_user_id;
	
	// �������� ��������� ��������, ������� ����� ��������
	$sql = "SELECT * FROM ".FINANCES_OPERATIONS_TB." WHERE finance_id='$finance_id' AND operation_returned=0 AND operation_is_transfer=0 ORDER by operation_id DESC LIMIT 1";
	
	$row = $site_db->query_firstrow($sql);
	 
	if($row['operation_id'])
	{
		return $row['operation_id'];
	}
	
}


// ������ �������� �����
function fill_finance_operations_list($finance_id, $finance_data)
{
	global $site_db, $current_user_id;
	
	$finance_no_operations_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finance_no_operations.tpl');
	
	// ��������, ������� ����� ��������
	$operation_id_can_deleted = get_finance_operation_can_returned($finance_id);
	
	 
	
	
	// �������� ��� ��������
	$sql = "SELECT * FROM ".FINANCES_OPERATIONS_TB." WHERE finance_id='$finance_id' ORDER by operation_id DESC";
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		// ���� �������� ���� ��������
		if($row['operation_returned'])
		{
			//$operations_list .= fill_finance_operation_returned_item($row, $finance_data);
			
			$operations_list .= fill_finance_operation_item($row, $finance_data, $operation_id_can_deleted);
		}
		else
		{
			$operations_list .= fill_finance_operation_item($row, $finance_data, $operation_id_can_deleted);
		}
	}
	
	if(!$operations_list)
	{
		$operations_list = $finance_no_operations_tpl;
	}
	
	return $operations_list;
}

// ���������� �������� �������� �����
function fill_finance_operation_item($operation_data, $finance_data, $operation_id_can_deleted)
{
	global $site_db, $current_user_id, $user_obj;
	
	$finance_operation_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finance_operation_item.tpl');
	
	$finance_operation_returned_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finance_operation_returned_item.tpl');
	
	$operation_edit_tools_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/operation_edit_tools.tpl');
	
	// �������� ���� ��������
	$operation_type = get_finance_operation_name_by_id($operation_data['operation_type']);
	
	if($operation_data['client_id']>0)
	{
		$client_name = get_client_name_by_id($operation_data['client_id']);
	}
	else
	{
		$client_name = $operation_data['client_name'];
	}
	
	// �� ���� ����������� �������� �������� ��������
	if($operation_id_can_deleted== $operation_data['operation_id'])
	{
		// ������ �������� ��������
		$PARS_1['{OPERATION_ID}'] = $operation_data['operation_id'];
			
		$edit_tools = fetch_tpl($PARS_1, $operation_edit_tools_tpl);
		

	}
    // ���� ������� ��������
    $status_block = fill_finance_operation_status_block($operation_data);
	
	$operation_summa = sum_process($operation_data['operation_summa'], ' ', '\.', 1);
	
	$operation_date = formate_date_rus($operation_data['operation_date']);
	
	// ������
	$currency_value = get_currency_value_by_id($finance_data['currency_id']);

	
	// ��������� �������� ������
	$last_operation_status = get_finance_operation_last_status($operation_data['operation_id']);
	
	// ������������ ��� �������
	$status_back_color = switch_finance_status_back($last_operation_status);
	
	// ��������� ������ ������������
	$user_obj->fill_user_data($finance_data['user_id']);
	
	// �������� �����������
	if($operation_data['operation_type']==1)
	{
		$operation_out_summa = 0;
		
		$operation_in_summa = sum_process($operation_data['operation_summa'], ' ', '\.', 1);
	}
	// �������� ������
	else if($operation_data['operation_type']==2)
	{
		$operation_in_summa = 0;
		
		$operation_out_summa =  sum_process($operation_data['operation_summa'], ' ', '\.', 1);
	}
	
	if($operation_data['operation_returned_by_user_id'] && $operation_data['operation_returned'])
	{
		// ��������� ������ ������������
		$user_obj->fill_user_data($operation_data['operation_returned_by_user_id']);
		
		$returned_user_id = $operation_data['operation_returned_by_user_id'];
		
		$returned_user_surname = $user_obj->get_user_surname();
		
		$returned_user_name = $user_obj->get_user_name();
		
		$returned_user_middlename = $user_obj->get_user_middlename();
		
		$returned_user_position = $user_obj->get_user_position();
		
		$returned_date = datetime($operation_data['operation_returned_date'], '%d.%m.%y � %H:%i');
	}
	
	// ��������� ������ ��������� ��������
	$user_obj->fill_user_data($operation_data['user_id']);
	
	$creater_user_surname = $user_obj->get_user_surname();
	
	$creater_user_name = $user_obj->get_user_name();
	
	$creater_user_middlename = $user_obj->get_user_middlename();
	
	$creater_user_position = $user_obj->get_user_position();
	
	// ����� �� ������ ��������
	$finance_summa_after_operation = sum_process($operation_data['finance_summa_after_operation'], ' ', '\.', 1);
	
	// ������ ������
	$files_list = get_attached_files_to_content($operation_data['operation_id'], 2, $current_user_id);
	
	
	$PARS['{FILES_LIST}'] = $files_list;
	
	$PARS['{OPERATION_IN_SUMMA}'] = $operation_in_summa;
	
	$PARS['{OPERATION_OUT_SUMMA}'] = $operation_out_summa;
	
	$PARS['{FINANCE_SUMMA_AFTER_OPERATION}'] = $finance_summa_after_operation;
	
	
	$PARS['{OPERATION_ID}'] = $operation_data['operation_id'];
	
	$PARS['{OPERATION_TYPE}'] = $operation_type;
	
	$PARS['{CLIENT_NAME}'] = $client_name;
	
	$PARS['{CURRENCY_VALUE}'] = $currency_value;
	
	$PARS['{OPERATION_SUMMA}'] = $operation_summa;
	
	$PARS['{OPERATION_DATE}'] = $operation_date;
	
	$PARS['{OPERATION_COMMENT}'] = nl2br($operation_data['operation_comment']);
	
	
	$PARS['{STATUS_BACK_COLOR}'] = $status_back_color;
	
	$PARS['{EDIT_TOOLS}'] = $edit_tools;
	
	$PARS['{OPERATION_RETURNED_BACK}'] = $operation_returned_back;
	
	$PARS['{CREATER_USER_ID}'] = $operation_data['user_id'];
	
	$PARS['{CREATER_USER_SURNAME}'] = $creater_user_surname;
	
	$PARS['{CREATER_USER_NAME}'] = $creater_user_name;
	
	$PARS['{CREATER_USER_MIDDLENAME}'] = $creater_user_middlename;
	
	$PARS['{CREATER_USER_POSITION}'] = $creater_user_position;
	
	$PARS['{RETURNED_USER_ID}'] = $returned_user_id;
	
	$PARS['{RETURNED_USER_SURNAME}'] = $returned_user_surname;
	
	$PARS['{RETURNED_USER_NAME}'] = $returned_user_name;
	
	$PARS['{RETURNED_USER_MIDDLENAME}'] = $returned_user_middlename;
	
	$PARS['{RETURNED_USER_POSITION}'] = $returned_user_position;
	
	$PARS['{RETURNED_DATE}'] = $returned_date;
	
	$PARS['{STATUS_BLOCK}'] = $status_block;
	
	if($operation_data['operation_returned'])
	{
		return fetch_tpl($PARS, $finance_operation_returned_item_tpl);
	}
	else
	{
		return fetch_tpl($PARS, $finance_operation_item_tpl);
	}	
}

function fill_finance_operation_status_block($operation_data)
{
	global $site_db, $current_user_id;
	
	$finance_operation_status_block_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finance_operation_status_block.tpl');
	
	// ������ �������� �������� ��� �������
	$operations_statuses_types_list = fill_finance_operation_statuses_types_list();

	// ������ �������� ��������
	$operations_statuses_list = fill_finance_operation_statuses_list($operation_data['operation_id']);
	
	$PARS['{OPERATION_ID}'] = $operation_data['operation_id'];
	
	$PARS['{OPERATIONS_STATUSES_TYPES_LIST}'] = $operations_statuses_types_list;
	
	$PARS['{OPERATIONS_STATUSES_LIST}'] = $operations_statuses_list;
	
	return fetch_tpl($PARS, $finance_operation_status_block_tpl);
}
// ���������� ������ �������� ��� �������� �����
function fill_finance_operation_statuses_list($operation_id)
{
	global $site_db, $current_user_id;
	
	// ������ ��������
	$statuses_types_arr = get_finance_operations_statuses_arr();
	
	$sql = "SELECT * FROM ".FINANCES_OPERATIONS_STATUSES_TB." WHERE operation_id='$operation_id' ORDER by id DESC";
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$statuses_list .= fill_finance_operation_status_item($row, $statuses_types_arr);
	}
	
	return $statuses_list;
}

// ���������� ���� ������� ��������
function fill_finance_operation_status_item($status_data, $statuses_types_arr)
{
	global $site_db, $current_user_id, $user_obj;
	
	$operation_status_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/operation_status_item.tpl');
	
	$status_name = $statuses_types_arr[$status_data['status_id']];
	
	$status_back_color = switch_finance_status_back($status_data['status_id']);
	
	$status_date = datetime($status_data['status_date_add'], '%d.%m.%y � %H:%i');
	
	// ��������� ������ ������������
	$user_obj->fill_user_data($status_data['user_id']);
	
	$user_surname = $user_obj->get_user_surname();
	
	$user_name = $user_obj->get_user_name();
	
	$user_middlename = $user_obj->get_user_middlename();
	
	$user_position = $user_obj->get_user_position();
	
	$PARS['{USER_ID}'] = $status_data['user_id'];
	
	$PARS['{USER_SURNAME}'] = $user_surname;
	
	$PARS['{USER_NAME}'] = $user_name;
	
	$PARS['{USER_MIDDLENAME}'] = $user_middlename;
	
	$PARS['{USER_POSITION}'] = $user_position;
	
	$PARS['{STATUS_ID}'] = $status_data['status_id'];
	
	$PARS['{STATUS_COMMENT}'] = nl2br($status_data['status_comment']);
	
	$PARS['{STATUS_NAME}'] = $status_name;
	
	$PARS['{STATUS_BACK_COLOR}'] = $status_back_color;
	
	$PARS['{DATE}'] = $status_date;
	
	return fetch_tpl($PARS, $operation_status_item_tpl);
}

// ���������� ��������� ���������� ������ �������� �����
function get_finance_operation_last_status($operation_id)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT status_id FROM ".FINANCES_OPERATIONS_STATUSES_TB." WHERE operation_id='$operation_id' ORDER by id DESC";
	
	$row = $site_db->query_firstrow($sql);
	
	if($row['status_id'])
	{
		return $row['status_id'];
	}
	else
	{
		return '';
	}
}

// ����� ����������� ��������� �������� ��������
function switch_finance_status_back($status_id)
{
	switch($status_id)
	{
		case '1':
			return 'finance_status_back_1';
		break;
		case '2':
			return 'finance_status_back_2';
		break;
		case '3':
			return 'finance_status_back_3';
		break;
		default:
			return 'finance_status_back_1';
		break;
	}
}

// ���������� ������ ����� �������� ���������� ��������
function get_finance_operations_statuses_arr()
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT * FROM ".FINANCES_OPERATIONS_STATUSES_TYPES_TB." ORDER by status_id ASC";
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$statuses_arr[$row['status_id']] = $row['status_name'];
	}
	
	return $statuses_arr;
}
// ������ ����� �������� ���������� ��������
function fill_finance_operation_statuses_types_list()
{
	global $site_db, $current_user_id;
	
	$option_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/tags/option.tpl');
	
	$sql = "SELECT * FROM ".FINANCES_OPERATIONS_STATUSES_TYPES_TB." ORDER by status_id ASC";
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$PARS_1['{NAME}'] = $row['status_name'];
				
		$PARS_1['{VALUE}'] = $row['status_id'];
				
		$PARS_1['{SELECTED}'] = $selected;
				
		$statuses_list .= fetch_tpl($PARS_1, $option_tpl);
	}
	
	return $statuses_list;
}

// ���������� �������� ���� �������� �� ��� ID
function get_finance_operation_name_by_id($type_id)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT type_value FROM ".FINANCE_OPERATIONS_TYPES_TB." WHERE type_id='$type_id'";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['type_value'];
}


// ���-�� ������ � ������������
function get_user_finances_count($user_id)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT COUNT(*) as count FROM ".FINANCES_TB." WHERE user_id='$user_id' AND finance_deleted<>1";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

// ���-�� ������ � ������������
function get_user_accessed_finances_count($user_id)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT COUNT(*) as count FROM ".FINANCES_ACCESS." i
			LEFT JOIN ".FINANCES_TB." j ON i.finance_id=j.finance_id
			WHERE i.user_id='$user_id' AND j.finance_deleted<>1";
				
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

// ��������� ���� ������� � ������ � ������
function fill_finance_access_block($finance_id, $users_list, $accessed_users_arr)
{
	global $site_db, $current_user_id, $user_obj;
	
	$users_owner_block_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/users_owner_block.tpl');
	
	$users_owner_block_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/users_owner_block_item.tpl');
	
	$option_fcbk_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/tags/option_fcbk.tpl');
	
	$user_access_select_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/user_access_select.tpl');
	
	// �������� ���� �������������, �������� �������� �������
	$sql = "SELECT * FROM ".FINANCES_ACCESS." WHERE finance_id='$finance_id'";
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$user_obj->fill_user_data($row['user_id']); 
	
		$user_name = $user_obj->get_user_name();
		$user_middlename = $user_obj->get_user_middlename();
		
		$user_name = $user_obj->get_user_surname().' '.$user_name[0].'. '.$user_middlename[0].', '.$user_obj->get_user_position(); 
		
		$PARS['{ID}'] = $row['finance_id'];
		$PARS['{ACCESS_ID}'] = $row['id'];
		$PARS['{CLASS}'] = 'selected';
		$PARS['{VALUE}'] = $row['user_id'];
		$PARS['{NAME}'] = $user_name;
		$users_access_list .= fetch_tpl($PARS, $user_access_select_tpl);
		
		//$finances_users_accessed_arr[] = $row['user_id'];
	}
	
	/*foreach($users_list as $user_id => $user_data)
	{ 
		// �������� ���������� ��������� ���������
		$sql = "SELECT * FROM ".FINANCES_ACCESS." WHERE finance_id='$finance_id'";
		
		$good_data = $site_db->query_firstrow($sql);
		
		$access_active = '';
		
		if(in_array($user_data['user_id'], $finances_users_accessed_arr))
		{
			$access_active = 'access_active';
		}

		
		$PARS1['{ACCESS_ACTIVE}'] = $access_active;
		
		$PARS1['{GOOD_ID}'] = $good_id;
		
		$PARS1['{USER_ID}'] = $user_data['user_id'];
		
		$PARS1['{SURNAME}'] = $user_data['surname'];
		
		$PARS1['{NAME}'] = $user_data['name'];
				
		$PARS1['{MIDDLENAME}'] = $user_data['middlename'];
				
		$PARS1['{USER_POSITION}'] = $user_data['user_position'];
		  
		$users_owner_list .= fetch_tpl($PARS1, $users_owner_block_item_tpl);
	}*/
 
 	//$users_list = $users_list ? $users_list : '��� ������������� ��� ����������';
	
	$PARS['{USERS_LIST}'] = $users_access_list;
	
	$PARS['{FINANCE_ID}'] = $finance_id;
	
	return fetch_tpl($PARS, $users_owner_block_tpl);
}

// ������ �������� ��� �����
function fill_finance_operations_types_list($type_id)
{
	global $site_db, $current_user_id;
	
	$option_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/tags/option.tpl');
	
	$sql = "SELECT * FROM ".FINANCE_OPERATIONS_TYPES_TB;
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$selected = $row['type_id'] == $type_id ? 'selected="selected"' : '';
		
		$PARS_1['{NAME}'] = $row['type_value'];
				
		$PARS_1['{VALUE}'] = $row['type_id'];
				
		$PARS_1['{SELECTED}'] = $selected;
				
		$currency_list .= fetch_tpl($PARS_1, $option_tpl);
	}
	
	return $currency_list;
}

// ������ ������ ��������
function fill_currency_list($carrency_id)
{
	global $site_db, $current_user_id;
	
	$option_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/tags/option.tpl');
	
	$sql = "SELECT * FROM ".CURRENCY_DATA_TB;
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$selected = $row['currency_id'] == $currency_id ? 'selected="selected"' : '';
		
		$PARS_1['{NAME}'] = $row['currency_value'];
				
		$PARS_1['{VALUE}'] = $row['currency_id'];
				
		$PARS_1['{SELECTED}'] = $selected;
				
		$currency_list .= fetch_tpl($PARS_1, $option_tpl);
	}
	
	return $currency_list;
}

// ���������� �������� ������ �� �� ID
function get_currency_value_by_id($currency_id)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT currency_value FROM ".CURRENCY_DATA_TB." WHERE currency_id='$currency_id'";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['currency_value'];
}
// ���������� ������ �����
function get_finance_currency_arr()
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT * FROM ".CURRENCY_DATA_TB;
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$currency_arr['currency_id']= $row['currency_value'];
	}
	
	return $currency_arr;
}

// ���-�� ����� ��������
function get_new_user_finances_count($user_id)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT COUNT(*) as count FROM ".FINANCES_ACCESS." WHERE user_id='$user_id' AND noticed=0";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

// �������� ��� ������
function finance_operation_proc($summa_1, $summa_2, $operation)
{
	switch($operation)
	{
		case '+':
			$result = $summa_1 + $summa_2;
		break;
		
		case '-':
			$result = $summa_1 - $summa_2;
		break;
	}
	
	$result = round($result, 2);
	
	return $result;
}

// ������ �����
function get_finance_data($finance_id)
{
	global $site_db, $current_user_id;
	
	// ������ �����
	$sql = "SELECT * FROM ".FINANCES_TB." WHERE finance_id='$finance_id'";
		 
	$finance_data = $site_db->query_firstrow($sql);
	
	return $finance_data;
}

// ������ �����
function get_finance_operation_data($operation_id)
{
	global $site_db, $current_user_id;
	
	// ������ �����
	$sql = "SELECT * FROM ".FINANCES_OPERATIONS_TB." WHERE operation_id='$operation_id'";
		
	$operation_data = $site_db->query_firstrow($sql);
	
	return $operation_data;
}

function fill_finance_transfer_form($finance_data_from, $finance_data_to)
{
	global $site_db, $current_user_id, $user_obj;
	
	$finance_transfer_block_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/finances/finance_transfer_block.tpl');
	
	// �������� ������
	$finance_currency_to = get_currency_value_by_id($finance_data_to['currency_id']);
	$finance_currency_from = get_currency_value_by_id($finance_data_from['currency_id']);
	
	// ��������� �����
	$finance_summa_to = sum_process($finance_data_to['finance_summa'], ' ', '\.', 1);
	
	// ��������� ������ ��������� ��������
	$user_obj->fill_user_data($finance_data_to['user_id']);
	
	$user_surname_to = $user_obj->get_user_surname();
	
	$user_name_to = $user_obj->get_user_name();
	
	$user_middlename_to = $user_obj->get_user_middlename();
	
	$user_position_to = $user_obj->get_user_position();
	
	$PARS['{FINANCE_ID_TO}'] = $finance_data_to['finance_id'];
	
	$PARS['{FINANCE_NAME_TO}'] = $finance_data_to['finance_name'];
	
	$PARS['{CURRENCY_VALUE_TO}'] = $finance_currency_to;
	
	$PARS['{FINANCE_SUMMA_TO}'] = $finance_summa_to;
	
	$PARS['{TO_USER_ID}'] = $finance_data_to['user_id'];
	
	$PARS['{USER_SURNAME_TO}'] = $user_surname_to;
	
	$PARS['{USER_NAME_TO}'] = $user_name_to;
	
	$PARS['{USER_MIDDLENAME_TO}'] = $user_middlename_to;
	
	$PARS['{USER_POSITION_TO}'] = $user_position_to;
	
	
	$PARS['{FINANCE_ID_FROM}'] = $finance_data_from['finance_id'];
	
	$PARS['{CURRENCY_VALUE_FROM}'] = $finance_currency_from;
	
	return fetch_tpl($PARS, $finance_transfer_block_tpl);
}

// ������ �������������, � ������� ���� ������ � �����
function get_accessed_users_arr_for_finance($finance_id)
{
	global $site_db, $current_user_id, $user_obj;
	
	$users_arr = array();
	
	// ����� �������������
	$sql = "SELECT user_id FROM ".FINANCES_ACCESS." 
			WHERE finance_id='$finance_id'";
			
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res))
	{
		$users_arr[$row['user_id']] = $row['user_id'];
	}
	
	return $users_arr;
}
?>