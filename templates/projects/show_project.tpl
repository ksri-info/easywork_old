<script type="text/javascript" src="/js/tinymce/tinymce.min.js"></script>

<div class="content_block_padn">
<div class="project_closed_title">{PROJECT_CLOSED_STR}</div>
{PROJECT_EDIT_TOOLS}
<div class="project_title">{PROJECT_NAME}</div>
{PROJECT_DESC}
<div style="margin-top:15px"></div>

<table cellpadding="0" cellspacing="0">
<tr>
<td>������������� ����:</td><td style="padding-left:10px">{PROJECT_HEAD} </td>
</tr>
</table>
<br>

<div id="add_form_block" class="stand_margin">
<div class="add_form add_form_margin"> 
<table cellpadding="0" cellspacing="0" style="margin-bottom:10px" id="project_tasks_tb">
<tr>
<td style="vertical-align:top; min-width:300px">
    <table class="project_tasks_tb"  cellpadding="0" cellspacing="0" id="project_tasks_tb">
    <tr>
    <th class="nopdl">�</th>
    <th class="">���������</th>
    <th title="�������������� ������">�����</th>
    <th class="">���� ������ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ���� ����������</th>
     
    <th></th>
    </tr>
   <tbody id="projects_tasks">
   {PROJECT_TASKS_LIST}
   </tbody>
   </table>
   <a href="javascript:;" onclick="add_project_task()" class="link" id="add_more_project_task_btn">[+] �������� ��� ������</a> 
</td>
<td style="vertical-align:top"></td>
</tr>
</table>

<div style="margin-top:30px">
{FILES_LIST}
<div id="file_form_{PROJECT_ID}"></div>
</div>

<div style="margin-bottom:10px" id="add_project_task_btn">
<a href="javascript:;" onclick="add_project_task()" class="link">[+] �������� ������</a>
</div>
<div class="d_none project_period_date" id="project_period_date">

<div><span class="prt_dates_rs">�� �����</span> ���� ������: <span id="project_date_start_plan"></span> ���� ����������: <span id="project_date_finish_plan"></span></div>
<div style="margin:4px 0px 4px 0px"><span class="prt_dates_rs">�� �����</span> ���� ������: <span id="project_date_start"></span> ���� ����������: <span id="project_date_finish"></span></div>
<div style="margin:4px 0px 4px 0px"><span class="prt_dates_rs">���������� �� �������</span> <span id="behind_schedule"></span></div>
 

</div>     
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
<div class="sub_project_scheme" id="gr_edited_notice">��������� �� ������� ����������� ����� ������� �� ������ "��������� ���������".</div>
<div class="clear"></div>
<div>
<div style="margin-top:15px"></div>
<div style="float:right"><div class="project_closed_title project_str_closed_status">{PROJECT_CLOSED_STR}</div>{PROJECT_CLOSE_BTN}</div>


<a class="button" onclick="save_project()" href="javascript:;" id="add_project_btn">
<div class="right"></div><div class="left"></div><div class="btn_cont">��������� ���������</div></a>

<div class="clear"></div>
</div>

<div class="error_box" id="error_box"></div>
<div id="success" class="success_marg"></div>
<div id="success_close" class="success_marg"></div>

</div>

</div>

{REPORT_BLOCK}
</div>

<script>
project_id = '{PROJECT_ID}';
Disk.get_content_file_upload_form('{PROJECT_ID}', 8, 'file_form_{PROJECT_ID}');
$('.task .date_inp').live('change', show_gr_edited_notice);
projects_tasks_init();
after_tasks_select_init();
$('.after_task_s').live('change', pr_task_after_task_change);

</script>