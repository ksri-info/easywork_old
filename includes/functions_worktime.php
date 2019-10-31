<?php
// �������� �������� ����������
function fill_worktime($user_id)
{
	global $site_db, $current_user_id, $all_workers_arr;
	
	$main_tpl = file_get_contents('templates/worktime/worktime.tpl');
	
	// �������� �� ����������� ���������� ����������. 
	if($user_id != $current_user_id && !check_user_access_to_user_content($user_id, array(0,1,0,0,1)))
	{
		header('Location: /wktime/'.$current_user_id);
	}
	
	// ���� �������� ����
	if($_GET['date'])
	{
		$date = formate_to_norm_date($_GET['date']);
		$checked_date = $_GET['date'];
	}
	else
	{
		$date = date('Y-m-d');
		$checked_date = date('d.m.Y');
	}

	// ������ ��������� �������� ������ �� ����
	$schedule_change_deal_statuses_actual_day = fill_worktime_change_deal_statuses_schedule_one_day($user_id, $date);
	
	// ������ ��������� �������� ������ �� 30 ����
	$schedule_change_deal_statuses_actual_30days = fill_worktime_change_deal_statuses_schedule_30day($user_id, $date);
	
	// ������� ������� ������ ������������
	$fill_user_worktime_arr = fill_user_worktime_arr($user_id, $date);
	
	// ������ ������
	$worktime_list = $fill_user_worktime_arr['worktime_list'];
	
 	// ������ ������
	$worktime_schedule = $fill_user_worktime_arr['worktime_schedule'];
	
	// ������ ����������
	$activity_list = fill_worktime_activity_list($user_id, $date);
	  
	// ������ ����� �������� � �������� ��������
	$activity_start_and_finish_btns = fill_activity_start_and_finish_btns($user_id, $date);
	
	// ������� ����������� �� ������
	$statuses = fill_worktime_statuses($user_id);
	
	// ��������� ������������ ������������
	$user_planning_calendar = fill_user_planning_calendar($user_id);
	
	
	$PARS['{USER_ID}'] = $user_id;

	$PARS['{USER_ACTIVITY}'] = $activity_list;
	
	$PARS['{ACTIVITY_BTNS}'] = $activity_start_and_finish_btns;
	
	$PARS['{STATUSES}'] = $statuses;
	
	$PARS['{CHECKED_DATE}'] = $checked_date;
	
	$PARS['{WORKTIME_LIST}'] = $worktime_list;
	
	$PARS['{SCHEDULE_CHANGE_DEAL_STATUSES_ACTUAL_DAY}'] = $schedule_change_deal_statuses_actual_day;
	
	$PARS['{SCHEDULE_CHANGE_DEAL_STATUSES_ACTUAL_30DAYS}'] = $schedule_change_deal_statuses_actual_30days;
	
	$PARS['{SCHEDULE_WORKTIME}'] = $worktime_schedule;
	
	$PARS['{USER_PLANNING_CALENDAR}'] = $user_planning_calendar;
	
	return fetch_tpl($PARS, $main_tpl);
		
}

// ���� ����� ������� ������������
function fill_worktime_statuses($user_id)
{
	$worktime_status_block_tpl = file_get_contents('templates/worktime/worktime_status_block.tpl');
	
	$worktime_status_block_item_tpl = file_get_contents('templates/worktime/worktime_status_block_item.tpl');
	
	global $site_db, $current_user_id;
	
	// ���� ����� ������� ������� ������ ������ ��������
	if($current_user_id!=$user_id)
	{
		return '';
	}
	
	// ����� ���� ��������
	$sql = "SELECT * FROM ".USERS_STATUSES_DATA_TB."";
	
	$res = $site_db->query($sql);
		 
	while($row=$site_db->fetch_array($res, 1))
	{
		$PARS_1['{STATUS_ID}'] = $row['status_id'];
		
		$PARS_1['{STATUS_NAME}'] = $row['status_name'];
		
		$statuses_list .= fetch_tpl($PARS_1, $worktime_status_block_item_tpl);
	}
	
	// �������� ���������� ������� ������������
	$active_user_status_arr = get_user_last_status($user_id);
	$active_user_status = $active_user_status_arr['status_name'];
	
	$PARS['{ACTIVE_USER_STATUS}'] = $active_user_status;
	
	$PARS['{STATUSES_LIST}'] = $statuses_list;
	
	return fetch_tpl($PARS, $worktime_status_block_tpl);
}

// ���������� ��������� ������ ������������
function get_user_last_status($user_id)
{
	global $site_db;
	
	$now_date = date('Y-m-d');
	
	// ����� ������� ������������
	$sql = "SELECT i.*, j.status_name, j.any_days FROM ".USERS_STATUSES_TB." i
			LEFT JOIN ".USERS_STATUSES_DATA_TB." j ON i.status_id=j.status_id
			WHERE i.user_id='$user_id'";
			 
	$user_status_arr = $site_db->query_firstrow($sql);
	
	//echo datetime($user_status_arr['date'], '%Y-%m-%d');
	
	// ���� ���� ��������� ������ � �� �������� ��� ��� �������� ���, �� ������ ��������� ���������� �� ���������� ���
	if($user_status_arr['status_id'] > 0 && ($user_status_arr['any_days']==1 || datetime($user_status_arr['date'], '%Y-%m-%d') == $now_date))
	{
		$active_user_status = array('status_id' => $user_status_arr['status_id'], 'status_name' => $user_status_arr['status_name']);	
	}
	else
	{
		$active_user_status = array('status_id' => 0, 'status_name' => '������� ���');
	}
	
	return $active_user_status;
	
}

// ��������� ���� ������� ������� ������ ������������ � �������
function fill_user_worktime_arr($user_id, $date)
{
	global $site_db, $current_user_id;
	
	// ������� ������� ������ ������������ 
	$worktime_by_comps_arr = get_user_worktime_computers($user_id, $date, 1);
	 
	 //  echo "<pre>", print_r($worktime_by_comps_arr), "<pre>";
	// �������
	$worktime_list = fill_worktime_list($worktime_by_comps_arr);
	// ������
	$worktime_schedule = fill_worktime_schedule($worktime_by_comps_arr);
	 
	return array('worktime_list' => $worktime_list, 'worktime_schedule' => $worktime_schedule); 
}

// ���������� ������� ������� ������ ������������ �� 30 ����
function fill_worktime_list($worktime_by_comps_arr)
{
	$worktime_table_tpl = file_get_contents('templates/worktime/worktime_table.tpl');
	
	$worktime_table_item_tpl = file_get_contents('templates/worktime/worktime_table_item.tpl');
	
	$worktime_by_comps_arr = array_reverse($worktime_by_comps_arr);
	
	$i = 1;
	 // echo "<pre>", print_r($worktime_by_comps_arr), "<pre>";
	// ������ �� ������� ������� ������ �� 30 ���� �������������
	foreach($worktime_by_comps_arr as $date => $worktime_data)
	{
		if($i%2==0)
		{
			$back_class = 'zebra';
		}
		else
		{
			$back_class = '';
		}
		
		$worktime_by_all_comps = $worktime_data['worktime_by_all_comps'];
	
		$worktime_by_authed_comps = $worktime_data['worktime_by_authed_comps'];
		
		$weekday = datetime($date, '%l');
		
		$PARS['{BACK_CLASS}'] = $back_class;
		
		$PARS['{DATE}'] = datetime($date, '%j %M, %l');
		
		$PARS['{WEEKDAY}'] = $weekday;
		
		$PARS['{WORKTIME_BY_AUTHED_COMPS}'] = $worktime_by_authed_comps;
	
		$PARS['{WORKTIME_BY_ALL_COMPS}'] = $worktime_by_all_comps;
	
		$worktime_list .= fetch_tpl($PARS, $worktime_table_item_tpl);
		
		$i++;
	}
	
	$PARS_1['{WORK_TIME_LIST}'] = $worktime_list;
	
	return fetch_tpl($PARS_1, $worktime_table_tpl);
}

// ���������� ������ ������� ������ ������������ �� 30 ����
function fill_worktime_schedule($worktime_by_comps_arr)
{
	global $site_db, $current_user_id;
	
	$worktime_schedule_worktime_tpl = file_get_contents('templates/worktime/worktime_schedule_worktime.tpl');
	
	foreach($worktime_by_comps_arr as $date => $date_data)
	{
		$series_by_auth_computers_arr[] = series_data($date, $date_data['worktime_by_authed_comps_seconds'] * 1000, 1); 
		$series_by_all_computers_arr[] = series_data($date, $date_data['worktime_by_all_comps_seconds'] * 1000, 1); 

	}
	//   echo "<pre>", print_r($worktime_by_comps_arr), "<pre>";

	if($series_by_auth_computers_arr)
	{
		$series_by_auth_computers = '['.implode(',', $series_by_auth_computers_arr).']';
		$series_by_all_computers = '['.implode(',', $series_by_all_computers_arr).']';
	}

	$PARS['{SERIES_BY_AUTH_COMPUTERS}'] = $series_by_auth_computers;
	
	$PARS['{SERIES_BY_ALL_COMPUTERS}'] = $series_by_all_computers;
	
	return fetch_tpl($PARS, $worktime_schedule_worktime_tpl);
}

// ���������� ������ � ������� ������ �� �������������� ����������� � ����� ������������
function get_user_worktime_computers($user_id, $date, $by_authed_comps)
{
	global $site_db, $current_user_id;
	
	$worktime_table_not_worked_tpl = file_get_contents('templates/worktime/worktime_table_not_worked.tpl');
	
	// ������� ����� ������ � �������������� �����������
	if($by_authed_comps)
	{
		//$by_authed_comps_s = 'AND j.computer_authed=1';
	}
	
	$date_from = date('Y-m-d', time() - 3600 * 24 * 30);
	$date_to = date('Y-m-d');	
	 
	$sql = "SELECT i.*, j.computer_authed FROM ".WORK_ACTIVITY_TB." i
			LEFT JOIN ".COMPS_TB." j ON i.computer_id=j.computer_id
			WHERE i.user_id='$user_id' AND i.activity_date >= '$date_from' AND i.activity_date <= '$date_to' ";
		 
	$res = $site_db->query($sql);
		 
	$activity_group_date_arr = array();
		 
	while($row=$site_db->fetch_array($res, 1))
	{
		// ���-�� ����� ����� ��������, ����� �������� ������������ ������� ������ �������� �����
		$worktime_limit_new_day = get_work_seconds_midnight();
		
		$work_day_date = $row['activity_date'];
		
		if($row['activity_datetime'] - to_mktime($row['activity_date']) < $worktime_limit_new_day)
		{
			$work_day_date = date('Y-m-d', to_mktime($row['activity_date']) - 3600 * 24);
		}
		// �� ������� ���� ����� 30 ����, ���� �����������������
		if($date_from > $work_day_date && $work_day_date)
		{
			continue;
		}
		
		if(!$activity_group_date_arr[$work_day_date][$row['activity_datetime']]['computer_authed'])
		{
			$activity_group_date_arr[$work_day_date][$row['activity_datetime']] = array('date' => $row['activity_datetime'], 'activity_status' => $row['activity_status'], 'computer_authed' => $row['computer_authed']);
		}
		 

	}
	
	// ��������� ������ ������ 30 ����
	$days_arr = fill_array_num_days_ago_from_actual_date(30, $date_to);
	
	//$days_arr = array('2014-02-13' => '2014-02-13');
	
	// ���������� ������ ���� � �������� ������� ������, ����� ������� ��� ��� � �������
	$activity_group_date_arr =  array_merge($days_arr, $activity_group_date_arr);
	
	// echo "<pre>", print_r($days_arr), "<pre>";
	
	//print_r($activity_group_date_arr);
	foreach($activity_group_date_arr as $wktime => $activity_arr)
	{
		ksort($activity_arr);
		 // echo "<pre>", print_r($activity_arr), "<pre>";
		//ksort($activity_arr);
		// ��������� ���������� ������������ � ������� �� ����
		$last_activity_date_arr = end($activity_arr);
		$last_activity_date = $last_activity_date_arr['date'];
		
		$i = 1;
		$authed_i = 1;
		
		// ������ ������������ �� �������������� ����������
		$worked_by_authed = 0;
		
		$worktime_arr_by_all_comps = array();
		$worktime_arr_by_authed_comps = array();
		$worked_by_authed = 0;
		$work_started = 0;
		$worktime_finish_flag = 0;
		
		// �������� �� ������� ������� ���������� � ��������� ��� �������
		// 1 - ������ ������� ������ �� ����� �����������
		// 2 - ������ ������� ������ �� �������������� �����������
		// ��� ��� ������������ � ������� ��� ����� ��������� ��� ������ �� ������ "�������� �����" � "�������� ��������",
		// �� ��������� ������� �������� ������
		// ������
		/*
		Array
		(
			[1] => Array
				(
					[start] => 2013-05-27 08:31:18
					[finish] => 2013-05-27 11:31:23
				)
		
			[2] => Array
				(
					[start] => 2013-05-27 12:36:24
					[finish] => 2013-05-27 13:20:28
				)
			.....
		)	
		*/
		
		 
		foreach($activity_arr as $worktime_data)
		{ 
			// ���� - �������� �����
			if($worktime_data['activity_status']==1)
			{
				$worktime_arr_by_all_comps[$i]['start'] = $worktime_data['date'];
				$work_started = 1;
			}
			
			// ���� - �������� ��������
			if($worktime_data['activity_status']==2)
			{
				$worktime_arr_by_all_comps[$i]['finish'] = $worktime_data['date'];
				$worktime_finish_flag = 1;
			}
			
			
			// ������� ������������ ����� ����� ��������� ����� �������, ����� ������������ ����� ������ "�������� �����" � ���� �� ������� �������, 
			// �� ������ �� �������������� �����������.
			
			// ���� ������ ������������� �� �������������� ���������� � ��������� ������� ������� �� � ��������������� ����������
			if($worked_by_authed && !$worktime_data['computer_authed'])
			{
				$worked_by_authed = 0; // �����, ���� ������ ������� ������ �� � ��������������� ����������
				$authed_i++; // ��� ���������� ������� ������� ������ �� �������������� ����������, ���� ����� �����
			}
			
			// ������� ������� � ��������������� ���������� � ������, ����� ������������ ����� ������ "�������� �����"
			if($worktime_data['computer_authed'] && $work_started)
			{
				// ��������� � ���������� ��������� �����, ����� ������������ ����� � ��������������� ����������
				if(!$worktime_arr_by_authed_comps[$authed_i]['start'])
				{ 
					$worktime_arr_by_authed_comps[$authed_i]['start'] = $worktime_data['date'];
					$worked_by_authed = 1;
				}
				
				// ��������� � ���������� �������� �����, ����� ������������ ����� � ��������������� ���������� 
				if($worktime_arr_by_authed_comps[$authed_i]['start'])
				{
					$worktime_arr_by_authed_comps[$authed_i]['finish'] = $worktime_data['date'];
				}
			}
			
			
			// ���� ��� ������ ����� �������� �������
			if($worktime_finish_flag)
			{
				$worktime_finish_flag = 0; // ���� � ���, ��� �������� ��������
				$work_started = 0; // ����, ����� ����� ���� �� ������� �����
				$i++;
				$authed_i++;
			}
		}
		
		
		//if($wktime=='2013-07-24')
		//echo "<pre>", print_r($activity_arr), "<pre>";
		
		// echo "<pre>", print_r($worktime_arr_by_all_comps), "<pre>";
		// echo "<pre>", print_r($worktime_arr_by_all_comps), "<pre>";
		
		// print_r($worktime_arr_by_all_comps);
		
		// ����������� ����� �������� ������� � �������� �� ����� ����������� 
		$result_time_in_seconds_all_time = work_time_proc($worktime_arr_by_all_comps, $last_activity_date);
		$n = sec_to_date_words($result_time_in_seconds_all_time);
		
	//	echo $n['string'];
		
		// ����������� ����� �������� ������� � ��������  �� �������������� �����������
		$result_time_in_seconds_by_authed_comps_time = work_time_proc($worktime_arr_by_authed_comps, $last_activity_date);
		 
		//���� ������� ������� ����� �� ����� ����������� 
		if($result_time_in_seconds_all_time)
		{
			// �� ������ �������� ������� �� ������ ������������ ��������� ������  ����������
			$result_worktime_string_arr =  sec_to_date_words($result_time_in_seconds_all_time);
			$worktime_by_all_comps = $result_worktime_string_arr['string'];
			$worktime_by_all_comps_seconds = $result_time_in_seconds_all_time;
		}
		else
		{
			$worktime_by_all_comps =   $worktime_table_not_worked_tpl;
			$worktime_by_all_comps_seconds = 0;
		}
		
		
		//���� ������� ������� ����� �� �������������� ���������� 
		if($result_time_in_seconds_by_authed_comps_time)
		{
			// �� ������ �������� ������� �� ��������������� ������������ ��������� ������  ����������
			$result_worktime_string_arr =  sec_to_date_words($result_time_in_seconds_by_authed_comps_time);
			$worktime_by_authed_comps = $result_worktime_string_arr['string'];
			$worktime_by_authed_comps_seconds = $result_time_in_seconds_by_authed_comps_time;
		}
		else
		{
			$worktime_by_authed_comps =  $worktime_table_not_worked_tpl;
			$worktime_by_authed_comps_seconds = 0;
		}
		
		
		$result_wortime_arr[$wktime] = array('worktime_by_all_comps' => $worktime_by_all_comps, 'worktime_by_authed_comps' => $worktime_by_authed_comps, 'worktime_by_all_comps_seconds' => $worktime_by_all_comps_seconds, 'worktime_by_authed_comps_seconds' => $worktime_by_authed_comps_seconds,);
	}
	
	krsort($worktime_by_comps_arr);
	
	//  echo "<pre>", print_r($result_wortime_arr), "<pre>";
	return $result_wortime_arr;
	
}

// ����������� ����� �������� ������� � �������� 
function work_time_proc($worktime_arr, $last_activity_date)
{
	// echo "<pre>", print_r($worktime), "<pre>";
	foreach($worktime_arr as $time)
	{
		// ����� ������ ������
		$start_time = $time['start'];
		
		// ����� ����� ������
		if($time['finish'])
		{
			$finish_date = $time['finish'];
		}
		else
		{ 
			$finish_date = $last_activity_date;
		}
	 
		$mktime_start_date = ($start_time);
		
		$mktime_finish_date = ($finish_date);
		 
		// ���-�� �������, ������� ������������ �������
		$result_time_in_seconds += $mktime_finish_date - $mktime_start_date;
	}
	
	return $result_time_in_seconds;
}



// ���������� ������ ��������� �������� ������ �������������
function fill_worktime_change_deal_statuses_schedule_30day($user_id, $date)
{
	global $site_db, $current_user_id;
	
	$worktime_schedule_deal_statuses_tpl = file_get_contents('templates/worktime/worktime_schedule_deal_statuses_30day.tpl');
	
	$tmp_date = time() - 3600 * 24 * 30;
	
	$date_from = date('Y-m-d 00:00:00', $tmp_date);
	
	$date_to = date('Y-m-d 23:59:59');
	 
	// �������� ����������� ������� �� ��������� ����
	$sql = "SELECT i.* FROM ".DEALS_STATUSES_TB." i
			LEFT JOIN ".DEALS_TB." j ON i.deal_id=j.deal_id
			WHERE i.user_id='$user_id' AND i.status_date BETWEEN '$date_from' AND '$date_to' AND j.deal_deleted<>1"; 
	
	$res = $site_db->query($sql);
		
	while($row=$site_db->fetch_array($res, 1))
	{
		// �������� ��� �� ������ ����
		$date_hour = substr($row['status_date'],0,10);
		 
		$statuses_arr[$date_hour] += 1;
	}
	
	// �� ������� ������ ������
	if(!$statuses_arr)
	{
		return '';
	}
	
	// ������ ���� �� ������� 
	$start_day = to_mktime($date_from); 
	
	// ��������� ��� �
	for($i=0; $i<31; $i++)
	{
		$date_s = date('Y-m-d', $start_day);
		 
		// ���� �� ������� ��� ���� ����������� �������, �� ��������� ��, ����� ������ 0
		if($statuses_arr[$date_s])
		{
			$SERIES_DATA_ARR[] = series_data($date_s, $statuses_arr[$date_s]);
		}
		else
		{
			$SERIES_DATA_ARR[] = series_data($date_s, 0);
		}
		
		// ����������� �� 1 ����
		$start_day += 24 * 3600;
	}
	 
	  
	if($SERIES_DATA_ARR)
	{
		$series = '['.implode(',', $SERIES_DATA_ARR).']';
	}
	else
	{
		return '';
	}
	
 	// ���������� � ������� ����� ������ 
	$date_start = get_date_utc_for_js_object($date_from);
	 
	$PARS['{SERIES}'] = $series;
	 
	$PARS['{SERIES_DATE_START}'] = $date_start;
	
	return fetch_tpl($PARS, $worktime_schedule_deal_statuses_tpl);
}

// ���������� ������ ��������� �������� ������ �������������
function fill_worktime_change_deal_statuses_schedule_one_day($user_id, $date)
{
	global $site_db, $current_user_id;
	
	$worktime_schedule_deal_statuses_tpl = file_get_contents('templates/worktime/worktime_schedule_deal_statuses_one_day.tpl');
	
	// ������ ������� 
	$date_from = $date.' 00:00:00';
	$date_to = $date.' 23:59:59';
	
	// �������� ����������� ������� �� ��������� ����
	$sql = "SELECT i.* FROM ".DEALS_STATUSES_TB." i
			LEFT JOIN ".DEALS_TB." j ON i.deal_id=j.deal_id
			WHERE i.user_id='$user_id' AND i.status_date BETWEEN '$date_from' AND '$date_to' AND j.deal_deleted<>1"; 
	 
	$res = $site_db->query($sql);
		   
	while($row=$site_db->fetch_array($res, 1))
	{
		// �������� ��� �� ������ ����
		$date_hour = (int)get_part_from_date($row['status_date'], 'h');
		 
		$statuses_arr[$date_hour] += 1;
	}
	
	// �� ������� ������ ������
	if(!$statuses_arr)
	{
		return '';
	}

	// ��������� ��� �
	for($i=0; $i<24; $i++)
	{
		// ���� �� ������� ��� ���� ����������� �������, �� ��������� ��, ����� ������ 0
		if($statuses_arr[$i])
		{
			$SERIES_DATA_ARR[$i] = $statuses_arr[$i];
		}
		else
		{
			$SERIES_DATA_ARR[$i] = 0;
		}
	}
	 
	if($SERIES_DATA_ARR)
	{
		$series = '['.implode(',', $SERIES_DATA_ARR).']';
	}
	 
 	// ���������� � ������� ����� ������ 
	$date_start = get_date_utc_for_js_object($date);
	 
	$PARS['{SERIES}'] = $series;
	 
	$PARS['{SERIES_DATE_START}'] = $date_start;
	
	return fetch_tpl($PARS, $worktime_schedule_deal_statuses_tpl);
}

function fill_user_planning_calendar($user_id, $date, $for_personal=0)
{ 
	global $site_db, $current_user_id;
	
	if($for_personal)
	{ 
		$user_planning_calendar_tpl = file_get_contents('templates/worktime/user_planning_calendar_on_personal.tpl');
	}
	else
	{
		$user_planning_calendar_tpl = file_get_contents('templates/worktime/user_planning_calendar.tpl');
	}
			
	$dates_array = get_user_wktime_dates_for_planning_calendar($user_id);
	
	$PARS['{INIT_DATE}'] = $_GET['date'] ? $_GET['date'] : date('Y-m-d');
	
	$PARS['{ARRAY_DATES}'] = $dates_array;
	
	$PARS['{ARRAY_DATES_DATA}'] = json_encode($dates_array);
	
	return fetch_tpl($PARS, $user_planning_calendar_tpl);
	
}

// ���������� ������ ��� ������������ ������������ � ���� ������
function get_user_wktime_dates_for_planning_calendar($user_id, $date)
{
	global $site_db, $current_user_id, $all_workers_arr;
	
	$dates_array = array();
	
	if(!$date)
	{
		$date_from = date('Y-m');
		$date_to = date('Y-m-31');
	}
	
	// ����� ������� �������
	$sql = "SELECT date FROM ".WORK_ACTIVITY_WORK_STARTED_TB." WHERE user_id='$user_id'";
	
	$res = $site_db->query($sql);
	 
	while($row=$site_db->fetch_array($res, 1))
	{
		$dates_array[$row['date']] = '0';
	}
	
	/*$sql = "SELECT * FROM ".PLANNING_DATES_TB." i
			
			WHERE
				((date_is_period=0 AND date_one BETWEEN '$date_from' AND '$date_to') OR (date_is_period=1 AND (date_from LIKE '$date_from%' OR date_to LIKE '$date_from%'))) AND i.user_id='$user_id' AND i.deleted<>1";*/
				
	
	$sql = "SELECT * FROM ".PLANNING_DATES_TB." i
			LEFT JOIN ".PLANNING_TB." j ON j.planning_id = i.planning_id
			WHERE i.user_id='$user_id' AND i.deleted<>1 AND j.planning_result<>0";
				
	$res = $site_db->query($sql);
	 
	while($row=$site_db->fetch_array($res, 1))
	{	
		// ���� ����
		if($row['date_is_period']==0)
		{
			$dates_array[datetime($row['date_one'], '%Y-%m-%d')] = $row['type_id'];
		}
		
		// ������ ���
		if($row['date_is_period']==1)
		{
			 
			$mktime_date_from = to_mktime($row['date_from']);
			$mktime_date_to = to_mktime($row['date_to']);
			
			
			if($mktime_date_to<$mktime_date_from)
			{ 
				continue;
			}
			
			$step = 1;
			$stop = 0;
			while(!$stop)
			{ 
				// ��������� ����������� ������� ���� �� � ��
				if($mktime_date_from<=$mktime_date_to)
				{
					$dates_array[date('Y-m-d', $mktime_date_from)] = $row['type_id'];
					$mktime_date_from += 3600 * 24;
				}
				else
				{
					$stop = 1;
				}
				
				// ������ ����, ���� ���..
				if($step>3000)
				{
					break;
				}
				$step++;
			}
		}	 
	}
	
	
	 
	return json_encode($dates_array);
}

// ������ ���������� �������� �� ������� �����
function fill_worktime_activity_list($user_id, $date)
{
	global $site_db, $current_user_id, $all_workers_arr;
	
	$user_activity_tb_tpl = file_get_contents('templates/worktime/user_activity_tb.tpl');
	
	$activity_list_item_tpl = file_get_contents('templates/worktime/activity_list_item.tpl');
	
	$activity_status_start_tpl = file_get_contents('templates/worktime/activity_status_start.tpl');
	
	$activity_status_finish_tpl = file_get_contents('templates/worktime/activity_status_finish.tpl');
	
	$computer_item_tpl = file_get_contents('templates/worktime/computer_item.tpl');
	
	$computer_item_proc_tpl = file_get_contents('templates/worktime/computer_item_proc.tpl');
	
	$activity_no_tpl = file_get_contents('templates/worktime/activity_no.tpl');
	
	$in_work_tpl = file_get_contents('templates/worktime/in_work.tpl');
	
	$in_outwork_tpl = file_get_contents('templates/worktime/in_outwork.tpl');
	
	
	// ����� ���������� ������������ �� ����
	$sql = "SELECT i.*, j.computer_name, j.user_id as computer_user_id FROM ".WORK_ACTIVITY_TB." i 
			LEFT JOIN ".COMPS_TB." j ON i.computer_id=j.computer_id
			WHERE i.user_id='$user_id' AND i.activity_date='$date'";
	
	$res = $site_db->query($sql);
		  
	while($row=$site_db->fetch_array($res, 1))
	{ 	
	 	// ���������� ���������� �� ���� � �� �� ������
		// ����� ����� ������ � ��������� ������ ��������� � ������ - ��������� � ��� ��������� ��������
		if($row['activity_status']==1 || $row['activity_status']==2)
		{
			$activity_arr[$row['activity_datetime'].rand(0,100)] = $row;
		}
		else
		{
			$activity_arr[substr($row['activity_datetime'],0 ,16)] = $row;
		}
	}
	
	// ���������� �� �������� ����
	asort($activity_arr);
	
	//echo "<pre>", print_r($activity_arr), "</pre>";
	// ��������� ������
	foreach($activity_arr as $activity_data)
	{
		$PARS_1['{COMPUTER_ID}'] = $activity_data['computer_id'];
		
		$PARS_1['{COMPUTER_NAME}'] = $activity_data['computer_name'];
		
		$PARS_1['{ACTIVITY_ID}'] = $activity_data['activity_id'];
		 
		// ���� ������������ ����� ����� �� �������������� �������� ����������
		if(check_access_for_edit_computer_name($activity_data, $all_workers_arr))
		{
			$computer_block = fetch_tpl($PARS_1, $computer_item_proc_tpl);	
		}
		else
		{
			$computer_block = fetch_tpl($PARS_1, $computer_item_tpl);	
		}
		
		$activity_date = datetime($activity_data['activity_datetime'], '%H:%i', 1);
		
		$provider = $activity_data['provider'];
		 
		// �������� ������ ����������
		switch ($activity_data['activity_status'])
		{
			case '1':
				$activity_status_block = $activity_status_start_tpl;
				$user_in_work = 1;
			break;
			case '2':
				$activity_status_block = $activity_status_finish_tpl;
				$user_in_work = 0;
			break;
			default:
				$activity_status_block = $user_in_work ? $in_work_tpl : $in_outwork_tpl;
				$provider = '';
			break;
		}
		$user_in_work_class = $user_in_work ? 'wktime_activite_onair' : '';
		
		$PARS['{ACTIVITY_ID}'] = $activity_data['activity_id'];
		
		$PARS['{ACTIVITY_DATE}'] = $activity_date;
		
		$PARS['{ACTIVITY_STATUS}'] = $activity_status_block;
		
		$PARS['{PROVIDER}'] = $provider;
		
		$PARS['{USER_IN_WORK_CLASS}'] = $user_in_work_class;
		
		$PARS['{COMPUTER_BLOCK}'] = $computer_block;
		
		$activity_list = fetch_tpl($PARS, $activity_list_item_tpl).$activity_list;
	}
	
	$PARS['{DATE}'] = datetime($date, '%d.%m.%y');
	
	if(!$activity_list)
	{
		return fetch_tpl($PARS, $activity_no_tpl);
	}
	
	$PARS['{ACTIVITY_LIST}'] = $activity_list;
	
	return fetch_tpl($PARS, $user_activity_tb_tpl);

}


// ���������� ������ ����� �������� � �������� ��������
function fill_activity_start_and_finish_btns($user_id, $date)
{
	global $site_db, $current_user_id;
	
	$now_date = date('Y-m-d');
	
	$activity_work_buttons_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/worktime/activity_work_buttons.tpl');
	 
	if($user_id != $current_user_id || $now_date!=$date)
	{
		return '';
	}
	
	// ��������� ��������� ������ ("����� ������" ��� "������� ��������") �� ����
	$user_last_status = get_last_user_activity_status($user_id);
 
	// ���������� ������ "�������� �����"
	if($user_last_status==1)
	{   
		$button = fill_activity_start_and_finish_btn(2);
	}
	// ���������� ������ "�������� ��������"
	else if($user_last_status==2 || !$user_last_status)
	{  
		$button =  fill_activity_start_and_finish_btn(1);
	}
	
	$PARS['{BUTTONS}'] = $button;
	
	return fetch_tpl($PARS, $activity_work_buttons_tpl);
}

// ���������� ��������� ������ ("����� ������" ��� "������� ��������") �� ����
function get_last_user_activity_status($user_id, $ff)
{
	global $site_db, $current_user_id;
	
	// ���-�� ������ ��������� � 12 ���� �������� ��� �� ���������� �����
	$pm_time = time() - to_mktime(date('Y-m-d'));
	
	// ���-�� ����� ����� ��������, ����� �������� ������������ ������� ������ �������� �����
	$worktime_limit_new_day = get_work_seconds_midnight();
	
	if($pm_time < $worktime_limit_new_day)
	{
		$work_date_finish = to_mktime(date('Y-m-d')) + $worktime_limit_new_day;
	 
		$work_date_start = $work_date_finish - 3600 * 24;
	}
	else
	{
		$work_date_finish = to_mktime(date('Y-m-d')) + 60*60 * 29;
	 
		$work_date_start = $work_date_finish - 60*60 * 24;
	}
	
	//echo 3600 * 5,' ';
	//echo $n;
	
	 
	
//if(!$ff) //echo $sql; echo $row['activity_status'];
 //	echo date('y-m-d H:i:s', $work_date_finish),' ';
	
	// ������� ��������� ������ (����� �������� ��� �������� ��������)
	$sql = "SELECT activity_id, activity_status FROM ".WORK_ACTIVITY_TB." WHERE user_id='$user_id' AND activity_datetime > '$work_date_start' AND activity_datetime <= '$work_date_finish' AND activity_status<>0 ORDER BY activity_id DESC LIMIT 1";
	 	 
	$row = $site_db->query_firstrow($sql);

	return $row['activity_status'];
}
// ���������� ������
function fill_activity_start_and_finish_btn($button)
{
	$activity_work_start_btn_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/worktime/activity_work_start_btn.tpl');
	
	$activity_work_finish_btn_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/worktime/activity_work_finish_btn.tpl');
	
	// ���������� ������ "�������� �����"
	if($button==1)
	{
		return $activity_work_start_btn_tpl;
	}
	// ���������� ������ "�������� ��������"
	if($button==2)
	{
		return $activity_work_finish_btn_tpl;
	}
}

// ���������, ���� �� � ������������ ������ � �������������� �������� ����������
function check_access_for_edit_computer_name($computer_data, $all_workers_arr)
{
	global $site_db, $current_user_id;
	 
	/*if($current_user_id==$computer_data['computer_user_id'])
	{
		return true;
	}
	else */
	if(check_user_access_to_user_content($computer_data['computer_user_id'], array(0,1,0,0,1)))
	{ 
		return true;
	}
}
// ������ ������� � ���������� �������� �� ������� �����
function set_user_work_activity($activity_status = 0, $computer_time_in_seconds, $screen_width, $screen_height)
{
	global $site_db, $current_user_id;
	
	if(!$current_user_id)
	{
		return '';
	}
	
	// ��������� � ���� ���������� ������ ������ 5 �����
	if($_SESSION['last_user_activity_datetime'] && time() - $_SESSION['last_user_activity_datetime'] < 60 * 5 && !$activity_status)
	{
		return '';
	}
	
	// �� ��������� ������, ����� �������� �� ������ ����������� �� 2 �������
	if($activity_status)
	{
		sleep(1);
		
		$datetime = date('Y-m-d H:i:s');
	}
	else
	{
		$datetime = date('Y-m-d H:i:s');
	}
	// �������� id ���������� ������������
	$computer_id = get_user_computer_id($current_user_id, $computer_time_in_seconds, $screen_width, $screen_height);
	
	$provider = addslashes(htmlspecialchars(($_SESSION['remote_addr']['provider'])));
	
	$datetime = time();
	 
	$sql = "INSERT INTO ".WORK_ACTIVITY_TB." (user_id, activity_date, activity_datetime, computer_id, activity_status, provider) VALUES ('$current_user_id', NOW(), '$datetime', '$computer_id', '$activity_status', '$provider')";
	 
	$site_db->query($sql);
	
	if($activity_status==1)
	{
		// ������ �������, ��� � ���� ���� ��������� �������
		set_work_activity_at_day();
	}
	
	$_SESSION['last_user_activity_datetime'] = time();
}

function set_work_activity_at_day()
{
	global $site_db, $current_user_id;
	
	$date = date('Y-m-d');
	
	// ���������, ���� �� ������� � �������, ��� � ���� ���� ��������� ����� ��������
	$sql = "SELECT id FROM ".WORK_ACTIVITY_WORK_STARTED_TB." WHERE user_id='$current_user_id' AND date='$date'";
	$work_started_arr = $site_db->query_firstrow($sql);
	
	// ���� ������� ��� - ���������
	if(!$work_started_arr['id'])
	{
		$sql = "INSERT INTO ".WORK_ACTIVITY_WORK_STARTED_TB." (user_id, date) VALUES ('$current_user_id', NOW())";
		$site_db->query($sql);
	}
}

// ������ ��������� �����
function get_user_computer_id($user_id, $computer_time_in_seconds, $screen_width, $screen_height)
{
	global $site_db, $current_user_id;
 	
	$mk_time = time();
	 
	// ���� ���� ��� ���������� � ���������� ������������
	if($_SESSION['user_computer']['computer_id'] && $_SESSION['user_computer']['user_id']==$current_user_id)
	{
		return $_SESSION['user_computer']['computer_id'];
	}
	
	// ���������� ��
	preg_match('/\((.*)\)/', $_SERVER['HTTP_USER_AGENT'], $matches);
	
	if($matches[0])
	{
		$computer_os = substr($matches[0], 1, strpos($matches[0], ')')-2);
		
		$computer_os_s = value_proc(get_os($_SERVER['HTTP_USER_AGENT']));
		
		$hash_value = md5($computer_os.$screen_width.$screen_height);
	}
	 
	$computer_os = value_proc(get_os($_SERVER['HTTP_USER_AGENT']));
	$computer_os_s = $computer_os;
	$hash_value = md5($computer_os);

	
	// ����������� �������
	$computer_time_btw_from = $computer_time_in_seconds - 60;
	$computer_time_btw_to = $computer_time_in_seconds + 60;
	 
	$raznost = abs(time() - $computer_time_in_seconds);
	
	$computer_time_fault_btw_from = $raznost - 60;
	$computer_time_fault_btw_to = $raznost + 60; 
	
	// ������� ����� ���������
	$sql = "SELECT computer_id FROM ".COMPS_TB." 
			WHERE hash_value='$hash_value' 
			AND computer_time_fault >= '$computer_time_fault_btw_from' AND computer_time_fault <= '$computer_time_fault_btw_to' 
			AND user_id='$user_id'";
	 
	$row = $site_db->query_firstrow($sql);
	
	if($row['computer_id'])
	{
		$computer_id = $row['computer_id'];
		
		$_SESSION['user_computer']['computer_id'] = $computer_id;
		$_SESSION['user_computer']['user_id'] = $user_id;
	
	}
	else
	{
		// �������� ����������
		$computer_name = make_computer_name($current_user_id);
		
		$user_agent = value_proc($_SERVER['HTTP_USER_AGENT']);
		
		// ��������� ������ � ���������� ������������
		$sql = "INSERT INTO ".COMPS_TB." (hash_value, computer_name, hash_date, user_id, computer_os, computer_time_fault, ip, computer_screen_width, computer_screen_height, user_agent) VALUES ('$hash_value', '$computer_name', NOW(), '$user_id', '$computer_os_s', '$raznost', '".$_SERVER['REMOTE_ADDR']."', '$screen_width', '$screen_height', '$user_agent')";
		
		$site_db->query($sql);
		
		$computer_id = $site_db->get_insert_id();
		
		$_SESSION['user_computer']['computer_id'] = $computer_id;
		$_SESSION['user_computer']['user_id'] = $user_id;
	}
	
	return $computer_id;
	
}

function get_os($userAgent) {
  // �������� ������ ������������ ������ � ���� ��������� �������
    $oses = array (
        'iPhone' => '(iPhone)',
        'Windows 3.11' => 'Win16',
        'Windows 95' => '(Windows 95)|(Win95)|(Windows_95)', // ���������� ���������� ���������
        'Windows 98' => '(Windows 98)|(Win98)',
        'Windows 2000' => '(Windows NT 5.0)|(Windows 2000)',
        'Windows XP' => '(Windows NT 5.1)|(Windows XP)',
        'Windows 2003' => '(Windows NT 5.2)',
        'Windows Vista' => '(Windows NT 6.0)|(Windows Vista)',
        'Windows 7' => '(Windows NT 6.1)|(Windows 7)',
        'Windows NT 4.0' => '(Windows NT 4.0)|(WinNT4.0)|(WinNT)|(Windows NT)',
        'Windows ME' => 'Windows ME',
        'Open BSD'=>'OpenBSD',
        'Sun OS'=>'SunOS',
        'Linux'=>'(Linux)|(X11)',
        'Macintosh'=>'(Mac_PowerPC)|(Macintosh)',
        'QNX'=>'QNX',
        'BeOS'=>'BeOS',
        'OS/2'=>'OS/2',
        'Search Bot'=>'(nuhk)|(Googlebot)|(Yammybot)|(Openbot)|(Slurp/cat)|(msnbot)|(ia_archiver)'
    );
  
    foreach($oses as $os=>$pattern)
	{
        if(eregi($pattern, $userAgent)) 
		{ 
            return $os;
        }
    }
    return 'Unknown';
}

// ������������ �������� ����������
function make_computer_name($user_id)
{
	// ���-�� �����������
	$user_computers_count = get_all_computers_count($user_id);
	
	$next_user_num_computer = $user_computers_count ? $user_computers_count + 1 : 1;
	
	return '��������� �'.$next_user_num_computer;
}

// �������� ���-�� ����������� ������������
function get_user_count_computers($user_id)
{
	global $site_db, $current_user_id;
	
	// ���-�� ����������� ������������
	$sql = "SELECT COUNT(*) as count FROM ".COMPS_TB." WHERE user_id='$user_id'";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

// �������� ����� ���-�� �����������
function get_all_computers_count()
{
	global $site_db, $current_user_id;
	
	// ���-�� ����������� ������������
	$sql = "SELECT COUNT(*) as count FROM ".COMPS_TB."";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['count'];
}

// ���������
function fill_worktime_user_computer($computer_id)
{
	global $site_db, $current_user_id;
	
	$user_computer_tpl = file_get_contents('templates/worktime/user_computer.tpl');
	
	// ����� ���������� ������������ �� ����
	$sql = "SELECT *, user_id as computer_user_id FROM ".COMPS_TB."
			WHERE computer_id='$computer_id'";
		
	$computer_data = $site_db->query_firstrow($sql);
			
	// ������ ���� ����������� ��� �������� ������������ ���� �������
	$all_workers_arr = get_all_workers_arr_for_user($current_user_id);
		 
	// ���������, ����� ����� �� �������������� �������� ����������
	if(!check_access_for_edit_computer_name($computer_data, $all_workers_arr))
	{
		header('Location: /wktime/'.$current_user_id);
	}
	
	$computer_authed = $computer_data['computer_authed'] ? 'checked="checked"' : '';
	
	// ����������� ������� � �����
	$time_fault = sec_to_date_words($computer_data['computer_time_fault'],0 , 1);
	
	$time_fault = $time_fault['string'];


	
	$PARS['{COMPUTER_ID}'] = $computer_data['computer_id'];
	
	$PARS['{COMPUTER_NAME}'] = $computer_data['computer_name'];
	
	$PARS['{OS}'] = $computer_data['computer_os'];
	
	$PARS['{TIME_FAULT}'] = $time_fault;
	
	$PARS['{COMPUTER_AUTHED_CHECK}'] = $computer_authed;
	
	$PARS['{RESOLUTION}'] = $computer_data['computer_screen_width'].' x '.$computer_data['computer_screen_height'];

	return fetch_tpl($PARS, $user_computer_tpl);
}

// �������� ������������ �� ��� ����������
function get_user_id_by_computer_id($computer_id)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT user_id FROM ".COMPS_TB." WHERE computer_id='$computer_id'";
	
	$row = $site_db->query_firstrow($sql);
	
	return $row['user_id'];
	
}

// ���-�� ������ ����� ���������, ������� ��������� ������� ���� ����������� ���
function get_work_seconds_midnight()
{
	return 3600 * 5;
}
?>