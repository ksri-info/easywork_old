<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/startup.php';

include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_top_panel.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_worktime.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_calendar_of_events.php';

// ����� �����������
$auth = new CAuth($site_db);

$mode = $_POST['mode'];

$current_user_id = $auth->get_current_user_id();

switch($mode)
{
	case 'planning_session_notice':
		
		// ����������� � ����� ���������
		$planning_session_notice = fill_planning_session_notice();
	
		echo $planning_session_notice;
		
	break;
	
	// ������ � ������� ������ 
	case 'wk_top':
		
		echo fill_top_panel_worktime_btn($current_user_id);
		
	break;
	
	case 'tp_notice_bar_init':
		
		$what = value_proc($_POST['what']);
		
		if($what=='evcal')
		{
			// ��������� �������
	   		$cal_of_events = get_evcal_count_label($current_user_id); 
		}
		else if($what=='ps')
		{
			// ����������� � ����� ���������
			$planning_sessions_count_label = get_actual_planning_sessions_count_label($current_user_id);
		}
		else
		{
			// ��������� �������
	   		$cal_of_events = get_evcal_count_label($current_user_id); 
			// ����������� � ����� ���������
			$planning_sessions_count_label = get_actual_planning_sessions_count_label($current_user_id);
		}

		 
		 
		
		echo json_encode(array('planning_session' =>  iconv('cp1251', 'utf-8', $planning_sessions_count_label), 'cal_of_events' => iconv('cp1251', 'utf-8',$cal_of_events)));
		
	break;
}

?>