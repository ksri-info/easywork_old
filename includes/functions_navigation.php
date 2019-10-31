<?php
// ������ ���������
function fill_nav($o)
{
	global $site_db, $user_obj,$current_user_id;
	
	$nav_main_tpl = file_get_contents('templates/navigation/nav_main.tpl');
	
	$nav_current_tpl = file_get_contents('templates/navigation/nav_current.tpl');
	
	$nav_a_tpl = file_get_contents('templates/navigation/nav_a.tpl');
	
	$nav_sep_tpl = file_get_contents('templates/navigation/nav_sep.tpl');
	
	$nav_block_tpl = file_get_contents('templates/navigation/nav_block.tpl');
	
	$not_with_main  = 1;
	 
	if(!$o)
	{
		return '';
	}
	switch($o)
	{
		case 'ucontrol':
			
			$PARS['{TITLE}'] = '����������';
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
				
		break;
		case 'tasks':
		
			if($_GET['tid'])
			{
				$rf = urldecode($_GET['rf']);
				
				$rf = $rf ? '?'.$rf : '';
				
				$PARS['{TITLE}'] = '��������� � ������ �����';
				$PARS['{HREF}'] = '/tasks'.$rf;
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl); 
				
				$PARS['{TITLE}'] = '�������� ������';
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl); 
			}
			else
			{
				$PARS['{TITLE}'] = '������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			}
			
			 
			
		break;
		case 'c_structure':
			
			$PARS['{TITLE}'] = '��������� ��������';
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			
		break;
		case 'org':
			
			$PARS['{TITLE}'] = '����������';
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
		break;
		case 'disk':
			
			if($_GET['act']=='av')
			{
				$PARS['{TITLE}'] = '��������� �����';
			
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			
			}
			else if($_GET['act']=='co')
			{
				$PARS['{TITLE}'] = '����� ��������';
			
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			
			}
			else
			{
				$PARS['{TITLE}'] = '��� �����';
			
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			}
			
		break;
		case 'posttr':
			
			$PARS['{TITLE}'] = '�������. ����� ������.';
			
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			
		break;
		case 'evcal':
			
			$PARS['{TITLE}'] = '��������� �������';
			
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			
		break;
		case 'cnews':
			
			$PARS['{TITLE}'] = '������� ��������';
			
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			
		break;
		case 'tasks_projects':
			if($_GET['id'])
			{
				if($_GET['referer']=='part')
				{ 
					$PARS['{HREF}'] = '/projects?part=1';
					$PARS['{TITLE}'] = '�������, � ������� ��������';
				}
				else
				{
					$PARS['{HREF}'] = '/projects'.$part;
					$PARS['{TITLE}'] = '��� �������';
				}
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				$PARS['{TITLE}'] = '�������� �������';
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['part']==1)
			{
				$PARS['{TITLE}'] = '�������, � ������� ��������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				$PARS['{TITLE}'] = '��� �������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
		break;
		case 'error404':
			$PARS['{TITLE}'] = '�������� �� �������';
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
		break;
		case 'rfw':
		
			$PARS['{TITLE}'] = '����������� �� ������';
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
			
		break;
		case 'notes':
			
			if($_GET['av'])
			{
				// ���
				$PARS['{TITLE}'] = '����� �������';
			}
			else
			{
				// ���
				$PARS['{TITLE}'] = '��� �������';
			}
			
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl); 
		
		break;
		
		case 'external':
			
				$service_id = $_GET['s_id'] > 0 ? $_GET['s_id'] : 1;
				
			 	$service_name = get_external_service_name_by_service_id($service_id);
				// ���
				$PARS['{TITLE}'] = $service_name;
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
		
		break;
		case 'deputy':
			
			if($_GET['my'])
			{
				// ���
				$PARS['{TITLE}'] = '� �������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				// ���
				$PARS['{TITLE}'] = '��� �����������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			
		break;
		case 'reprimand':
			
			if($_GET['wks'])
			{
				// ���
				$PARS['{TITLE}'] = '�������� ���� �����������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				// ���
				$PARS['{TITLE}'] = '��� ��������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			
		break;
		case 'ofdocs':
			
			if($_GET['wks'])
			{
				// ���
				$PARS['{TITLE}'] = '����������� ��������� ���� �����������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				// ���
				$PARS['{TITLE}'] = '����������� ���������';
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			
		break;
		case 'planning':
			
			// ���
			$PARS['{TITLE}'] = '������������ ����������';
				
				 
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'registration':
			
			// ���
			$PARS['{TITLE}'] = '�����������';
				
				 
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'colleagues':
			
			// ���
			$PARS['{TITLE}'] = '��� �������';
				
				 
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'msgs':
			
			$PARS['{HREF}'] = '/msgs';
					
			$PARS['{TITLE}'] = '��� �������';
				
			$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
			
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['id']);
			
			// ���
			$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
			
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
		break;
		case 'msgs_group':
		
			$PARS['{TITLE}'] = '��������';
				
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'msgs_group_add':
			
			$PARS['{TITLE}'] = '����������� ��������';
				
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				
		break;
		case 'dialogs':
			
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['user_id']);
			
			// ���
			$PARS['{TITLE}'] = '��� �������';
				
				 
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'finance':
			
			if($_GET['finance_id'])
			{
				$PARS['{HREF}'] = '/finances';
					
				$PARS['{TITLE}'] = '������� �������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				// ������ �����
				$sql = "SELECT * FROM ".FINANCES_TB." WHERE finance_id='".$_GET['finance_id']."'";
				
				$finance_data = $site_db->query_firstrow($sql);
				
				// ���
				$PARS['{TITLE}'] = '�������������� ����� "'.$finance_data['finance_name']."\"";
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				if($_GET['av'])
				{
					// ���
					$PARS['{TITLE}'] = '����� ������� �������';
					
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}
				else
				{
					// ���
					$PARS['{TITLE}'] = '������� �������';
					
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}
			}
		break;
		case 'auto':
		
			$PARS['{TITLE}'] = '��� �������������';
				
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
			
		break;
		case 'camera':
		
			$PARS['{TITLE}'] = '��� ���������������';
				
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
			
		break;
		
		case 'wktime':
		
			if($_GET['cmp'])
			{
				// ���
				$PARS['{TITLE}'] = '���������';
					
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				if($_GET['user_id']!=$current_user_id && $_GET['user_id'])
				{
					$PARS['{HREF}'] = '/workers';
				
					$PARS['{TITLE}'] = '��� ����������';
				
					$nav_string1 = fetch_tpl($PARS, $nav_a_tpl);
				
					// ��������� ������ ������������
					$user_obj->fill_user_data($_GET['user_id']);
					
					$PARS['{HREF}'] = '/id'.$_GET['user_id'];
					
					// ���
					$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
					
					$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
					
					// ���
					$PARS['{TITLE}'] = '����������� �� ������';
					
					$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				}
				else
				{
					// ���
					$PARS['{TITLE}'] = '����������� �� ������';
						
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}

			}
		break;
		
		case 'computer':
			
			$user_id = get_user_id_by_computer_id($_GET['id']);
			
			// ��������� ������ ������������
			$user_obj->fill_user_data($user_id);
			
			$PARS['{HREF}'] = '/id'.$user_id;
			
			// ���
			$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
			
			$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
			
			
			// ���
			$PARS['{TITLE}'] = '����������� �� ������';
			
			$PARS['{HREF}'] = '/wktime/'.$user_id;
			
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_a_tpl);
			
			// ���
			$PARS['{TITLE}'] = '�������������� ����������';
			
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'money':
		
			if($_GET['id'])
			{
				$PARS['{HREF}'] = '/money';
					
				$PARS['{TITLE}'] = '�������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				if(!check_user_access_to_user_content($_GET['id'], array(0,1,0,0,1)) && $_GET['accruals'])
				{
					$PARS['{TITLE}'] = '��� ����������';
					
					$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				}
				else
				{
					if($_GET['accruals'] && check_user_access_to_user_content($_GET['id'], array(0,1,0,0,1)))
					{
						$PARS['{TITLE}'] = '����������';
					}
					else
					{	
						$PARS['{TITLE}'] = '�������';
					}
					
					$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
					
					// ��������� ������ ������������
					$user_obj->fill_user_data($_GET['id']);
				
					// ���
					$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
				
					$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				}
				
				 
				 
				 
				 
			}
			else
			{
				$PARS['{TITLE}'] = '��� �������';
					
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			
		break;
		case 'goods':
			
			if($_GET['good_id'])
			{ 
				$PARS['{TITLE}'] = '��� ���������';
				
				$PARS['{HREF}'] = '/goods/'.$current_user_id;
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				$PARS['{TITLE}'] = '��������������';
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['wks'])
			{
				$PARS['{TITLE}'] = '��������� ���� �����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($current_user_id==$_GET['user_id'])
			{
				$PARS['{TITLE}'] = '��� ���������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				/*// ��������� ������ ������������
				$user_obj->fill_user_data($_GET['user_id']);
				
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
				$PARS['{TITLE}'] = '���������';
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);*/
			}

		break;
		case 'efficiency':
			
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['id']);
				
			// ���
			$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();;
			
			// ���
			$PARS['{HREF}'] = '/tasks?id='.$_GET['id'];
					
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_a_tpl);
			
			$PARS['{TITLE}'] = '������ �������������';
				
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
		break;
		case 'deals':
			
			if($_GET['wks'])
			{
				$PARS['{TITLE}'] = '������ ���� �����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			elseif($_GET['user_id'])
			{
				$PARS['{TITLE}'] = '��� ������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				$PARS['{TITLE}'] = '����� ������ �� ���� �����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			
		break;
		
		case 'deal_edit':
			
			// ���
			$PARS['{TITLE}'] = '��� ������';
			
			// ���
			$PARS['{HREF}'] = '/deals/'.$current_user_id;
					
			$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
			
			$PARS['{TITLE}'] = '�������������� ������';
				
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'clients':
		
			if($_GET['import'])
			{
				$PARS['{TITLE}'] = '������ ���� ������������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['show']==1 && $_GET['id'])
			{
				$PARS['{HREF}'] = '/clients/'.$current_user_id;
				$PARS['{TITLE}'] = '�������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				$PARS['{TITLE}'] = '��������';
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['wks'])
			{
				$PARS['{TITLE}'] = '������� ���� �����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['user_id'])
			{
				$PARS['{TITLE}'] = '��� �������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['msg']==1)
			{
				
				$PARS['{HREF}'] = '/clients';
				$PARS['{TITLE}'] = '��� �������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				$client_data = get_client_data($_GET['id']);
				
				
				$PARS['{TITLE}'] = '������ � ��������';
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
				
				// ���
				$PARS['{TITLE}'] = $client_data['client_name'];
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['files']==1)
			{
				$PARS['{HREF}'] = '/clients';
				$PARS['{TITLE}'] = '��� �������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				$client_data = get_client_data($_GET['id']);
				
				
				$PARS['{TITLE}'] = '����� �������';
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
				// ���
				$PARS['{TITLE}'] = $client_data['client_name'];
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				$PARS['{TITLE}'] = '����� �������� �� ���� �����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			
		break;
		
		case 'task_to_users':
		
			$PARS['{TITLE}'] = '��� ������������ ������';
			
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'tree':
		
			$PARS['{TITLE}'] = '�������� �����������';
						
			$nav_string = fetch_tpl($PARS, $nav_current_tpl);
				
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['user_id']);
				
			// ���
			$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();;
				
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
		break;
		case 'contacts':
			
			if(!$_GET['user_id'])
			{
				$PARS['{TITLE}'] = '����� ���������';
						
				$nav_string = fetch_tpl($PARS, $nav_current_tpl);
			}
			else if($_GET['user_id']==$current_user_id || !$_GET['user_id'])
			{  
				$PARS['{TITLE}'] = '��� ��������';
						
				$nav_string = fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				// ��������� ������ ������������
				$user_obj->fill_user_data($_GET['user_id']);
				
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();;
				
				 
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
				$PARS['{TITLE}'] = '��������';
						
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			
		break;
		case 'active_log':
			
			// ���
				$PARS['{TITLE}'] = '��� ����������';
						
				$nav_string = $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
				// ��������� ������ ������������
				$user_obj->fill_user_data($_GET['user_id']);
				
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();;
				
				 
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
		break;
		case 'personal':
			
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['user_id']);
			
			// ���
			$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();;
				
				 
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
			
			
					
		break;
		
		case 'files':
			
			
			// ���� �������� ����� � �������
			if($_GET['folder_id'])
			{
				if($_GET['av'])
				{
					// ���
					$PARS['{TITLE}'] = '����� �����';
					
					$PARS['{HREF}'] = '/files?av=1';
					
					$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				}
				else if($_GET['s'])
				{
					// ���
					$PARS['{TITLE}'] = '����� �����';
					
					$PARS['{HREF}'] = '/files?s=1';
					
					$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				}
				else
				{
					// ���
					$PARS['{TITLE}'] = '��� �����';
					
					$PARS['{HREF}'] = '/files';
					
					$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				}
				// �������� �����
				$sql = "SELECT folder_name FROM ".FOLDERS_TB." WHERE folder_id='".$_GET['folder_id']."'";
				
				$row = $site_db->query_firstrow($sql);
				
				// ���
				$PARS['{TITLE}'] = $row['folder_name'];
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				if($_GET['av'])
				{
					// ���
					$PARS['{TITLE}'] = '����� �����';
					
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}
				else if($_GET['s'])
				{
					// ���
					$PARS['{TITLE}'] = '����� �����';
					
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}
				else
				{
					// ���
					$PARS['{TITLE}'] = '��� �����';
					
					$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
				}
			}
			
		break;
		case 'user_comments':
			
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['id']);
			
			// ���
			$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();;
			
			 
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			
			// ���
			$PARS['{TITLE}'] = '������';
			
			 
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			
		break;
		case 'work':
		
			if($_GET['id']==$current_user_id || !$_GET['id'])
			{
					// ���
				$PARS['{TITLE}'] = '��� ���� ������������';
			
			 
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			}
			else
			{
				
				$PARS['{HREF}'] = '/workers';
				
				$PARS['{TITLE}'] = '��� ����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				 
				// ���
				$PARS['{TITLE}'] = '���� ������������';
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				 
				// ��������� ������ ������������
				$user_obj->fill_user_data($_GET['id']);
			 
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
			 
			}
			 
		break;
		case 'user_work':
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['id']);
			
			// ���
			$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();;
			
			 
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			
			 
			
			// ���
			$PARS['{TITLE}'] = '���� ������������';
			
			 
			$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
		break;
		case 'boss':
			// ���
			$PARS['{TITLE}'] = '��� �����������';
				
			$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
		break;
		case 'worker':
			
			// ��������� ������ ������������
			$user_obj->fill_user_data($_GET['id']);
			
			// ���
			$PARS['{TITLE}'] = '��� ����������';
			
			$PARS['{HREF}'] = '/workers';
			
			$nav_string = $nav_sep_tpl.fetch_tpl($PARS, $nav_a_tpl);
				
			if($_GET['date'])
			{
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
			
				$PARS['{HREF}'] = '/workers?id='.$_GET['id'];
			
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_a_tpl);
			
				// ����
				$PARS['{TITLE}'] = formate_date_rus($_GET['date'], 1);
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
			}
			else
			{
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			
			}
			 
			
		break;
		
		case 'settings':
			
			if($_GET['id'])
			{
				$PARS['{TITLE}'] =  '��������� ������������';
			}
			else
			{
				// ���
				$PARS['{TITLE}'] =  '��� ���������';
			}
				
			$nav_string = fetch_tpl($PARS, $nav_current_tpl);
				
		break;
		
		/*case 'my_tasks':
			
			if($_GET['date'])
			{
				$PARS['{TITLE}'] = '��� ������';
			
				$PARS['{HREF}'] = '/tasks';
			
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
			
				// ����
				$PARS['{TITLE}'] = '������ �� '.formate_date_rus($_GET['date'], 1);
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
			}
			else
			{
				$PARS['{TITLE}'] = '��� ������';
				
				$nav_string .= fetch_tpl($PARS, $nav_current_tpl);
			
			}
				
		break;
		
		case 'tasks':
			
			if($_GET['date'])
			{
				$PARS['{HREF}'] = '/workers';
				
				$PARS['{TITLE}'] = '��� ����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				 
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
				
				$PARS['{HREF}'] = '/tasks?id='.$_GET['id'];
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_a_tpl);
				
				// ����
				$PARS['{TITLE}'] = '������ �� '.formate_date_rus($_GET['date'], 1);
				
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
				
			}
			else
			{
				$PARS['{HREF}'] = '/workers';
				
				$PARS['{TITLE}'] = '��� ����������';
				
				$nav_string .= fetch_tpl($PARS, $nav_a_tpl);
				
				 
				
				// ��������� ������ ������������
				$user_obj->fill_user_data($_GET['id']);
			
				// ���
				$PARS['{TITLE}'] = $user_obj->get_user_surname().' '.$user_obj->get_user_name().' '.$user_obj->get_user_middlename();
			
				$nav_string .= $nav_sep_tpl.fetch_tpl($PARS, $nav_current_tpl);
			
			}
				
		break;*/
		
		case 'workers':
			
			// ���
			$PARS['{TITLE}'] =  '��� ����������';
				
			$nav_string = fetch_tpl($PARS, $nav_current_tpl);
				
		break;
	}
	
	if($not_with_main)
	{
		$nav_str =  $nav_string;
	}
	else
	{
		$nav_str =  $nav_main_tpl.' '.$nav_string;
	}
	
	$PARS_1['{NAV}'] = $nav_str;
	
	return fetch_tpl($PARS_1, $nav_block_tpl);
	 
}
?>