<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/startup.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_personal.php';
// ����� �����������
$auth = new CAuth($site_db);

$mode = $_POST['mode'];

$current_user_id = $auth->get_current_user_id();

if(!$current_user_id)
{
	exit();
}

switch($mode)
{
	// �������� � ������ �����������
	case 'add_in_my_workers':
		// �������� �����������
		if(!$auth->check_auth())
		{
			exit();
		}
		
		$worker_id = $_POST['worker_id'];
		
		$comment = value_proc($_POST['comment']);
		
		if($worker_id == $current_user_id)
		{
			exit();
		}
		
		if(!$worker_id)
		{
			exit();
		}
		
		// ������� ���� ����������� ��� ������������, �������� ����� �������� 
		$workers_arr = get_all_workers_arr_for_user($worker_id);
		
		// ���� ������� ������������ �������� ����������� ������ ������, �� �� ���� �������� � ���������� ��������
		if(in_array($current_user_id, $workers_arr))
		{
			$error = 4;
		}
		
		##### ���������, ���� �� ����� ��������� � ����������
		$sql = "SELECT * FROM ".WORKERS_TB." WHERE invite_user='$current_user_id' AND invited_user='$worker_id' AND invited_user_status = 1 AND deputy_id = 0";
		
		$row = $site_db->query_firstrow($sql);
		
		// ����� ��������� ���� ��� � ����������
		if($row['id'])
		{
			$error = 1;
		}
		
		##### ���������, �� �������� �� ��������� ���� �����������
		$sql = "SELECT * FROM ".WORKERS_TB." WHERE invite_user='$worker_id' AND invited_user='$current_user_id' AND invited_user_status = 1 AND deputy_id = 0";
		
		$row = $site_db->query_firstrow($sql);
		
		// ��� ���������
		if($row['id'])
		{
			$error = 2;
		}
		 
		
		// ���� ��� ������
		if(!$error)
		{
			// ������� ������ ������ �� ������, ����� �� ��������� ����������
			$sql = "DELETE FROM ".WORKERS_TB." WHERE invite_user='$current_user_id' AND invited_user='$worker_id' AND deputy_id = 0";
			
			$site_db->query($sql);
			
			// ������� ������ ������ �� ������, ����� �� ��������� ����������
			$sql = "DELETE FROM ".WORKERS_TB." WHERE invite_user='$worker_id' AND invited_user='$current_user_id' AND invited_user_status IN(0,2) AND deputy_id = 0";
			
			$site_db->query($sql);
			
			
			// ��������� ������ � ����
			$sql = "INSERT INTO  ".WORKERS_TB." (invite_user, invited_user, invite_date, invite_user_comment)
					VALUES ('$current_user_id', '$worker_id', NOW(), '$comment')";
			
			$site_db->query($sql);
			
			$success = 1;
		}
		
		echo json_encode(array('success' => $success, 'error' => $error));
	
	break;
	
	// ������ "��� ����������"
	case 'get_workers_list':
	
		$user_id = $_POST['user_id'];
		
		$workers_list = fill_workers_list($user_id);
		
		echo $workers_list;
		
	break;
	
	// ��������� ���������� � ������
	case 'hide_rejected_notice':
		
		$invite_user_id = $_POST['invite_user_id'];
		
		$invited_user_id = $_POST['invited_user_id'];
		
		if($invite_user_id != $current_user_id)
		{  
			exit();
		}
		 
		// ���������
		$sql = "DELETE FROM ".WORKERS_TB." WHERE invite_user='$invite_user_id' AND invited_user='$invited_user_id' AND invited_user_status= 2 AND deputy_id = 0";
		
		$site_db->query($sql);
		
		echo 1;
		
	break;
	
	// ������ ������������ �� �����������
	case 'remove_user_from_worker':
		
		$user_id = $_POST['user_id'];
		
		$sql = "DELETE FROM ".WORKERS_TB." WHERE invite_user='$current_user_id' AND invited_user='$user_id' AND deputy_id = 0";
		
		$site_db->query($sql);
		
		echo 1;
	break;
	
	case 'get_more':
		
		$page = value_proc($_POST['page']);
		
		$key = value_proc($_POST['key']);
		
		$users_list = fill_workers_list($page, $key);
		
		echo $users_list;
		
	break;
	
	case 'workers_list':
		
		$key = value_proc($_POST['key']);
		
		$workers_list = fill_workers_list_content($key);
		
		echo $workers_list;
		
	break;


}

?>