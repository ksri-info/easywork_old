<?php
// ���� ����� ����������
function fill_video_instructions_block($site_page, $method)
{
	$video_block_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/video_instructions/video_block.tpl');
	
	// ������ �� �����
	$video_href_id = get_video_ins_href_id($site_page, $method);
	
	// ����, ���������� �� ������������ ����� ����������
	$is_video_showed = is_user_view_this_video_ins($site_page);
	
	// ���� ������������ �� ��������� �������� �� �������� ����� �������
	if($method == 'show_auto' && $is_video_showed)
	{
		return NULL;
	}
	else if(!$is_video_showed)
	{
		// ������������� ����� � ��������� ����� ����������
		set_video_ins_view_by_user($site_page);
	}
	
	
	
	// ��������� ������ �����
	$video_list = get_vidio_instructions_list();
	
	$PARS['{VIDEO_LIST_1}'] = $video_list[0];
	$PARS['{VIDEO_LIST_2}'] = $video_list[1];
	$PARS['{VIDEO_HREF_ID}'] = $video_href_id;
	$PARS['{METHOD}'] = $method;
	
	$video_block = fetch_tpl($PARS, $video_block_tpl);
	
	return array('video_block' => iconv('cp1251', 'utf-8', $video_block), 'video_href_id' => $video_href_id);
}

// ������� � ��������� ����� ����������
function set_video_ins_view_by_user($site_page)
{
	global $site_db, $current_user_id;
	
	if(!$site_page || !$current_user_id)
	{
		return '';
	}
	
	if($site_page)
	{
		// ���������, ���� �� ����� ��� ������� �������
		$sql = "SELECT * FROM ".VIDEO_INS_TB." WHERE site_page='$site_page'";
		
		$row = $site_db->query_firstrow($sql);
		
		if($row['video_id'])
		{
			$sql = "INSERT INTO ".VIDEO_INS_VIEWS_TB." SET user_id='$current_user_id', site_page='$site_page'";
	 
			$site_db->query($sql);
		}
	}
	
}

// ���������, ���������� �� ������������ ����� ��� ����� ��� ������ ������ � ������
function is_user_view_this_video_ins($site_page)
{
	global $site_db, $current_user_id;
	
	$sql = "SELECT * FROM ".VIDEO_INS_VIEWS_TB." WHERE user_id='$current_user_id' AND site_page='$site_page'";
	
	$row = $site_db->query_firstrow($sql);
	
	if($row['id'])
	{
		return true;
	}
	else return false;
}

function get_video_ins_href_id($site_page, $method)
{	
	global $site_db;
	
	$sql = "SELECT * FROM ".VIDEO_INS_TB." WHERE site_page='$site_page'";
	
	$video_arr = $site_db->query_firstrow($sql);
	
	if($site_page && $video_arr['video_id'])
	{
		return $video_arr['video_href_id'];
	}
	else if($method=='show_auto')
	{
		return '';
	}
	else 
	{
		$sql = "SELECT * FROM ".VIDEO_INS_TB." WHERE site_page='vvedenie'";
		
		$video_arr = $site_db->query_firstrow($sql);
		
		return $video_arr['video_href_id'];
	}  
}

// ������ ����� ����������
function get_vidio_instructions_list()
{
	global $site_db;
	
	$video_list_item_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/video_instructions/video_list_item.tpl');

	
	// �������� ������ �����
	$sql = "SELECT * FROM ".VIDEO_INS_TB." ORDER by sort";
	
	$res = $site_db->query($sql);
		
	$num = 1;
	
	while($row=$site_db->fetch_array($res))
	{
		$PARS['{NUM}'] = $num;
		
		$PARS['{SITE_PAGE}'] = $row['site_page'];
		
		$PARS['{VIDEO_HREF_ID}'] = $row['video_href_id'];
		
		$PARS['{VIDEO_NAME}'] = $row['video_name'];
		
		// �� ��� �����
		if($num < 12)
		{
			$video_list_1 .= fetch_tpl($PARS, $video_list_item_tpl);
		}
		else
		{
			$video_list_2 .= fetch_tpl($PARS, $video_list_item_tpl);
		}
		
		$num++;
	}
	
	return array($video_list_1, $video_list_2);
}
?>