// �������� � ��� ����������
function add_in_my_workers_list()
{ 
	var worker_id, comment;
	
	$('#work_error').html('');
	
	$('#work_error').hide();
	
	worker_id = $('#worker_select').val();
	
	comment = $('#worker_comment').val();
	
	 
	 
	if(worker_id<=0)
	{
		$('#work_error').show()
		$('#work_error').html('��������� �� ������');
		return false;
	} 
	$.post('/ajax/ajaxWorkers.php', 
	{   
		mode : 'add_in_my_workers',
		worker_id : worker_id,
		comment : comment
	},
	function(data){ 
		 
		if(data['error'])
		{
			$('#work_error').show()
		}
		else
		{
			$('#work_error').hide()
		}
		
		if(data['error']==1)
		{
			 $('#work_error').html('��������� ��� ��������� � ������ "��� ����������"');
		}
		else if(data['error']==2)
		{
			$('#work_error').html('�������� � ������ "��� ����������" ����������, ��� ��� ��������� ��������� �������� ����� �������������');
		}
		else if(data['error']==3)
		{
			$('#work_error').html('�� �� ������ �������� ���� ���� � ������ ���� �����������');
		}
		else if(data['error']==4)
		{
			$('#work_error').html('�� �� ������ �������� ����������, ��� ��� �� �������� �������������');
		}
		else if(data['success']==1)
		{
			//$('#add_in_my_workers_list_form').fadeOut(100);
			clear_add_form();
			
			// ������� ������ 
			$('#ea_selected__worker_select').trigger('click')
			
			setTimeout(function(){
				$('#add_my_workers_result').html('<div class="success" style="margin-top:10px">��������� ����� ��������� � ����� ������� | <a href="javascript:;" onclick="open_add_my_workers_form()">�������</a></div>')}, 100);
				
			// ��������� ������ �����������	
			//get_my_workers_list(global_current_user_id)
		}
		
	}, 'json');
	
	
}

// ������� �����
function clear_add_form()
{
	$('#worker_comment').val('');
	$('.maininput').val('');
	$('.closebutton').trigger('click');
	$('#work_error').html('');
	$('#work_error').hide('')
}
is_open_form = 0
// �������� ����� �� ���������� ����������
function open_add_my_workers_form()
{
	// ������� ��������� �� ���������� ����������� ����� ��������
	$('#add_my_workers_result').html('');
	
	 
	if(is_open_form==1)
	{
		$('#add_in_my_workers_list_form').hide();
		clear_add_form();
		is_open_form = 0;
	}
	else
	{
		$('#add_in_my_workers_list_form').show(1)
		is_open_form = 1;
		
	}
	 
}

// ������ �����������
function get_my_workers_list(user_id)
{
	
	$.post('/ajax/ajaxWorkers.php', 
	{   
		mode : 'get_workers_list',
		user_id : user_id
	},
	function(data){ 
		
		$('#user_list_container').html(data)
		
	});
}


// ������ ����������� ������
function hide_rejected_notice(invite_user_id, invited_user_id)
{
	$.post('/ajax/ajaxWorkers.php', 
	{   
		mode : 'hide_rejected_notice',
		invite_user_id : invite_user_id,
		invited_user_id : invited_user_id
	},
	function(data){ 
		
		if(data==1)
		{
			$('#task_'+invited_user_id).remove()
		}
		
	});
}

// ������� ����������
function remove_user_from_worker(user_id, mode)
{
	$.post('/ajax/ajaxWorkers.php', 
	{   
		mode : 'remove_user_from_worker',
		user_id : user_id
	},
	function(data){ 
		
		if(data==1)
		{
			if(mode==1)
			{
				$('#remove_from_workers_block').remove();
				$('#delete_user_from_workers_result').html('<div class="success">������������ ������ �� �������� �����������</div>')
			}
			else if(mode==2)
			{
				$('#worker_'+user_id).remove();
			}
		}
		
	});
}