<div class="task_top_panel">
<a href="javascript:;" onclick="Tasks.get_add_form();" class="item add_btn">+ �������� ������</a>

<a href="/tasks?l=2" class="item {LIST_MENU_ACTIVE_2}">�������� {NEW_MENU_ACTIVE_2}</a>
<a href="/tasks?l=1" class="item {LIST_MENU_ACTIVE_1}">������� {NEW_MENU_ACTIVE_1}</a>
<a href="/tasks?l=3" class="item {LIST_MENU_ACTIVE_3}">������� {NEW_MENU_ACTIVE_3}</a>
<a href="/tasks?l=4" class="item {LIST_MENU_ACTIVE_4}">� ����� {NEW_MENU_ACTIVE_4}</a> 
{TASK_MENU_WORKERS}

</div>
<div class="task_sub_top_panel">

<div class="it"> 
<select onchange="Tasks.tasks_filter();" id="filter_status"><option value="all" {FILTER_CHECKED_STATUS_0}>���</option><option value="1" {FILTER_CHECKED_STATUS_1}>� ������</option><option value="2" {FILTER_CHECKED_STATUS_2}>�����������</option></select>
</div>

{FILTER_USERS_LIST}
<div class="it"><input type="text" id="filter_key" class="filter_key" placeholder="�������� �����.." value="{KEY}"/></div>

<a href="javascript:;" class="search_btn" title="�����" onclick="Tasks.tasks_filter();"></a>

<a href="javascript:;" onclick="$('#filter_key').val('');Tasks.tasks_filter();"class="clear_txt" style="{CLEAR_KEY_TEXT_DISPLAY}"></a>
 
 
<div class="clear"></div>
</div> 
<div class="">
<table cellpadding="0" cellspacing="0" class="tasks_tb">
<thead>
	<tr>
    	<th>��������</th>
        <th><span title="���������">�����.</span></th>
        <th>������� ����</th>
        <th>������ ��������</th>
        <th>�����������</th>
    </tr>
</thead>
<tbody id="tasks_list_body">
	{TASKS_LIST}
</tbody>
</table>
</div>
<div class="files_list_footer_no_br">
{PAGES}
<div class="clear"></div>
</div>
<div class="pop" id="pop"></div>

<script>
list = '{LIST_TYPE}';
list_status = '{LIST_STATUS}';
key = '{KEY}';
filter_user_id = '{FILTER_USER_ID}';

if(list_status==2 || list_status=='all' || list==5)
{
	$(window).scroll(function(){
		Load.list_scroll('tasks_list_body .task_it_row:last', Tasks.get_more);
		 
	});
}
</script>