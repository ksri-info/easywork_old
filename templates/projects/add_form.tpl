<div style="display:none" id="add_form_block" class="add_form_margin">
<div class="title_add_form">�������� ������</div>
<div class="add_form add_form_margin">

<table cellpadding="0" cellspacing="0" class="tables_data_1">
<tbody>
	<tr>
    	<td class="td_title">��������</td>
        <td class="td_value"><input type="text" class="input_text" id="project_name" style="width:528px" />
        <div class="td_error sub_input_error"></div>
        </td>
        
    </tr>
    <tr>
    	<td class="td_title td_vert_top">��������</td>
        <td class="td_value"><textarea id="project_desc" class="input_text" style="width:528px; height:100px"></textarea>
        </td>
    </tr>
    <tr>
    	<td class="td_title td_vert_top">������������� ����</td>
        <td class="td_value"><select id="project_head"></select>
        </td>
    </tr>
    
    
    <tr>
    	<td class="td_title td_vert_top">������</td>
        <td class="td_value"><a href="javascript:;" onclick="add_project_task()" class="link" id="add_project_task_btn"> [+] �������� ������</a>
        </td>
    </tr>
    
   </tbody>
    </table>
 
                
     
<table cellpadding="0" cellspacing="0" style="margin-bottom:10px" class="d_none" id="project_tasks_tb">
<tr>
<td style="vertical-align:top; min-width:300px">
    <table class="project_tasks_tb d_none1"  cellpadding="0" cellspacing="0" id="project_tasks_tb">
    <tr >
    <th class="nopdl">�</th>
    <th class="">���������</th>
    <th title="�������������� ������">�����</th>
    <th class="">���� ������ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ���� ����������</th>
    <th></th>
    </tr>
   <tbody id="projects_tasks">
    </tbody>
    </table>
	<a href="javascript:;" onclick="add_project_task()" class="link d_none" id="add_more_project_task_btn"> [+] �������� ��� ������</a> 
</td>
<td style="vertical-align:top"></td>
</tr>
</table>

<div class="d_none project_period_date" id="project_period_date">���� ������: <span id="project_date_start"></span> ���� ����������: <span id="project_date_finish"></span></div>     
<div class="project_scheme d_none" id="project_scheme">
<table cellpadding="0" cellspacing="0" class="project_scheme_tb">
<thead class="project_scheme_month_th">
<tr id="project_scheme_month_th_tr"></tr>
</thead>
<thead class="project_scheme_days_th">
<tr id="project_scheme_days_th_tr"></tr>
</thead>
<tbody class="project_scheme_days_rows" id="project_scheme_days_rows"></tbody>
</table>
</div>

<div id="file_form_0" style="margin-top:20px"></div>

<div style="margin-top:20px">
<a class="button" onclick="add_project()" href="javascript:;" id="add_project_btn">
<div class="right"></div><div class="left"></div><div class="btn_cont">�������� ������</div></a>
<div class="clear"></div>
</div>

<div class="error_box" id="error_box"></div>
<div id="success" class="success_marg"></div>

</div>

<div class="stand_margin">
<a href="javascript:;" class="link" onclick="$('#add_form_block').hide(); $('#show_add_form_a').show()">������</a>
</div>

</div>

<div class="add_new_list_item" id="show_add_form_a" > 
<a href="javascript:;" class="link" onclick="$('#add_form_block').fadeIn(200); $('#show_add_form_a').hide()">+ �������� ������</a>
</div>

<script type="text/javascript">
tinymce.init({
    selector: "#project_desc",
	language : 'ru',
	plugins: ['table'
         
   ],
   menubar:false,
   toolbar1: "table"
 });
</script>
<script>
Disk.get_content_file_upload_form('0', 8, 'file_form_0');
$('#add_more_project_task_btn').trigger('click');
after_tasks_select_init();
$('.after_task_s').live('change', pr_task_after_task_change);
$('#project_head').easycomplete(
{
	str_word_select : '������� ����������',
	url:'/ajax/ajaxGetUsers.php?who=all&by=name&current_user=1&result_name=2',
	width:350,
	trigger : 1
});
</script>