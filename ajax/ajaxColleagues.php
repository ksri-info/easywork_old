<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/startup.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_colleagues.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/includes/functions_worktime.php';
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
	// �������� �������
	case 'add_in_colleague_list':
		// �������� �����������

		
		$user_id = $_POST['user_id'];
		
		$comment = value_proc($_POST['comment']);
		
		if(!$user_id)
		{
			exit();
		}
		 
		// ������������ ��� �������� ��������
		if(check_user_access_to_user_content($user_id, array(0,0,1,0,0)))
		{
			$error = 1;
		}
		
		// ������������ �������� ����������
		if(check_user_access_to_user_content($user_id, array(1,0,0,1,0)))
		{
			$error = 2;
		}
		// ������������ �������� �����������
		if(check_user_access_to_user_content($user_id, array(0,1,0,0,1)))
		{
			$error = 3;
		}

		
		// ���� ��� ������
		if(!$error)
		{
			// ������� ������ ������ �� ������, ����� �� ��������� ����������
			$sql = "DELETE FROM ".COLLEAGUES_TB." WHERE invite_user_id='$current_user_id' AND invited_user_id='$user_id'";
			
			$site_db->query($sql);
			
			// ������� ������ ������ �� ������, ����� �� ��������� ����������
			$sql = "DELETE FROM ".COLLEAGUES_TB." WHERE invite_user_id='$user_id' AND invited_user_id='$current_user_id' AND invited_user_status IN(0,2)";
			$site_db->query($sql);
			
			// ��������� ������ � ����
			$sql = "INSERT INTO  ".COLLEAGUES_TB." (invite_user_id, invited_user_id, invite_date, invite_user_comment)
					VALUES ('$current_user_id', '$user_id', NOW(), '$comment')";
			
			$site_db->query($sql);
			
			$success = 1;
		}
		
		echo json_encode(array('success' => $success, 'error' => $error));
	
	break;
	
	// ������ ������ ������������
	case 'get_colleagues_list':
		 
		$user_id = $_POST['user_id'];
		
		$colleagues_list = fill_colleagues_list($user_id);
		
		echo $colleagues_list;
		
	break;

	// �����������, ��� ������������ �������� ��������
	case 'colleague_confirm':
		
		$invite_user_id = $_POST['invite_user_id'];

		$invited_user_id = $_POST['invited_user_id'];
		
		if(!$invite_user_id || !$invited_user_id)
		{
			exit();
		}
		
		if(check_user_access_to_user_content($invite_user_id, array(1,1,1,1,1)))
		{
			$sql = "DELETE FROM ".COLLEAGUES_TB." WHERE invited_user_id='$current_user_id' AND invite_user_id='$invite_user_id'";
			
		//	$site_db->query($sql);
			
			$remove = 1;
		}
		else
		{
			// ������������
			$sql = "UPDATE ".COLLEAGUES_TB." SET invited_user_status=1 WHERE invited_user_id='$current_user_id' AND invite_user_id='$invite_user_id'";
			
			$site_db->query($sql);
			
			$success = 1;
		}
		
		// ���-�� ����� ������ �� ���������� � �������
		$new_colleagues_count = get_new_user_colleagues_count($current_user_id);
		
		echo json_encode(array('success' => $success, 'new_colleagues_count' => $new_colleagues_count, 'remove' => $remove));
	break;
	
	case 'colleague_cancel_confirm':
		
		if(!$auth->check_auth())
		{
			exit();
		}
		
		$invite_user_id = $_POST['invite_user_id'];

		$invited_user_id = $_POST['invited_user_id'];
		
		// ������������
		$sql = "UPDATE ".COLLEAGUES_TB." SET invited_user_status=2 WHERE invited_user_id='$current_user_id' AND invite_user_id='$invite_user_id'";
		
		$site_db->query($sql);
		
		// ���-�� ����� ������ �� ���������� � �������
		$new_colleagues_count = get_new_user_colleagues_count($current_user_id);
		
		echo json_encode(array('new_colleagues_count' => $new_colleagues_count));
	
	break;
	
	// ���������� 
	case 'get_colleague_item':
		
		$invite_user_id = $_POST['invite_user_id'];

		$invited_user_id = $_POST['invited_user_id'];
		
		// �������� ������
		$sql = "SELECT * FROM ".COLLEAGUES_TB." WHERE  invited_user_id='$invited_user_id' AND invite_user_id='$invite_user_id'";
		
		$row = $site_db->query_firstrow($sql);
		
		$colleague_item = fill_colleagues_list_item($row);

		echo $colleague_item;
	break;
	
	// �������� � �� ������� ���������� ���� ����������� � ������ ������
	case 'hide_colleague_rejected_notice':
		
		$invite_user_id = $_POST['invite_user_id'];

		$invited_user_id = $_POST['invited_user_id'];
		
		// ������� ������ �����������
		$sql = "DELETE FROM ".COLLEAGUES_TB." WHERE  invited_user_id='$invited_user_id' AND invite_user_id='$invite_user_id'";
		
		$site_db->query($sql);
		
		echo 1;
	break;
	
	// ������ ������������ �� ������ ������
	case 'delete_from_colleagues':
		
		$invite_user_id = $_POST['invite_user_id'];

		$invited_user_id = $_POST['invited_user_id'];
		
		// ������ ���� �� �������� ������
		$sql = "UPDATE ".COLLEAGUES_TB." SET colleague_deleted=1 WHERE invited_user_id='$invited_user_id' AND invite_user_id='$invite_user_id'";
		
		$site_db->query($sql);
		
		echo 1;
	break;
	
	// ������������ ���������� ������� �� ������
	case 'restore_deleted_colleague':
		
		$invite_user_id = $_POST['invite_user_id'];

		$invited_user_id = $_POST['invited_user_id'];
		
		// ������ ���� �� �������� ������
		$sql = "UPDATE ".COLLEAGUES_TB." SET colleague_deleted=0 WHERE invited_user_id='$invited_user_id' AND invite_user_id='$invite_user_id'";
		
		$site_db->query($sql);
		
		echo 1;
	break;
}

?>