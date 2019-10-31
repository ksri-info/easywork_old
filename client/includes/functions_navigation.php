<?php
// ������ ���������
function fill_client_nav($o)
{
	global $site_db,$current_user_id, $current_client_id;
	
	$nav_main_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/navigation/nav_main.tpl');
	
	$nav_current_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/navigation/nav_current.tpl');
	
	$nav_a_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/navigation/nav_a.tpl');
	
	$nav_sep_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/navigation/nav_sep.tpl');
	
	$nav_block_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/navigation/nav_block.tpl');
	
	switch($o)
	{
		case 'error404':
			$PARS['{TITLE}'] = '�������� �� �������';
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
		break;
		case 'files':
			 
			
			// ���� �������� ����� � �������
			if($_GET['folder_id'])
			{
				if($_GET['cl'])
				{
					if($current_client_id)
					{
						$href = '/client/files?cl=1';
					}
					else if($current_user_id)
					{
						$href = '/clients?files=1&id='.$_GET['id'].'&cl=1'; 
					}  
					// ���
					$PARS['{TITLE}'] = '����� �������';
					
					$PARS['{HREF}'] = $href;
					
					$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				}
				else
				{
					if($current_client_id)
					{
						$href = '/client/files';
					}
					else if($current_user_id)
					{
						$href = '/clients?files=1&id='.$_GET['id']; 
					}  
					// ���
					$PARS['{TITLE}'] = '����� �����������';
					
					$PARS['{HREF}'] = $href;
					
					$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				}
				// �������� �����
				$sql = "SELECT folder_name FROM ".CLIENTS_FOLDERS_TB." WHERE folder_id='".$_GET['folder_id']."'";
				
				$row = $site_db->query_firstrow($sql);
				
				// ���
				$PARS['{TITLE}'] = $row['folder_name'];
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				if($_GET['cl'])
				{
					// ���
					$PARS['{TITLE}'] = '����� �������';
				
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}
				else
				{
					// ���
					$PARS['{TITLE}'] = '����� �����������';
					
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}
			}
			
		break;
		
		case 'msgs':
			
			// ���
			$PARS['{TITLE}'] = '���������';
					
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
					
		break;
		
	}
	
	$PARS_1['{NAV}'] = $nav_string;
	
	return fetch_tpl($PARS_1, $nav_block_tpl);
}
?>