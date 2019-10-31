<div class="task_top_panel" id="user_tabs">
<a href="javascript:;" onclick="select_tab_on_main(this)" class="item active" tab="1">���������� � �������</a>
<a href="javascript:;" onclick="select_tab_on_main(this)" class="item" tab="2">������ Sipuni</a>
</div>


<div class="content_block">
<div id="tab_conts" class="tab_conts">

<!-- Tab-->
<div tab="1" class="tab_cont_item" style="display:block">
	<br /> 
    <div class="title">����� ���������� � �������</div>
    <br /> 
    <div class="add_form">
    <table cellpadding="0" cellspacing="0" class=" ">
    <tr>
        <td class="td_title">����</td>
        <td class="td_value"><input type="text" id="for_date" class="input_text" style="width:80px" placeholder="��.��.����" value=""/></td>
    </tr>
    <tr>
        <td class="td_title td_vert_top">���������� �� �������</td>
        <td class="td_value">
        
        <div><input type="checkbox" id="to_chart_inbox" checked="checked" /> <label for="to_chart_inbox">��. ���������</label></div>
        <div><input type="checkbox" id="to_chart_outbox" checked="checked"/> <label for="to_chart_outbox">���. ���������</label></div>
        <div><input type="checkbox" id="to_chart_task_reports" checked="checked"/> <label for="to_chart_task_reports">������ � ����������� � �������</label></div>
        <div><input type="checkbox" id="to_chart_edit_deals" checked="checked"/> <label for="to_chart_edit_deals">���������� ������</label></div>
        <div><input type="checkbox" id="to_chart_add_deals" checked="checked"/> <label for="to_chart_add_deals">�������������� ������</label></div>
        <div><input type="checkbox" id="to_chart_work_reports" checked="checked"/> <label for="to_chart_work_reports">����� � ����� ������������</label></div>

        <div style=" margin:20px 0px 10px 4px; border-bottom:1px solid #CCC">������� �������</div>
        <div><input type="checkbox" id="to_chart_sipuni" /> <label for="to_chart_sipuni">������ sipuni</label></div>
        
        </td>
    </tr>
    <tr>
        <td class="td_title"></td>
        <td class="td_value"><a class="button" onclick="Ucontrol.show_stat()" href="javascript:;" id="show_stat_btn">
        <div class="right"></div><div class="left"></div><div class="btn_cont">�������� ����������</div></a>
        <div class="clear"></div>
        <div class="" id="stat_result"></div>
        </td>
    </tr>
    </table>
    </div>
    <div id="stat_msgs_block"></div>
</div>
<!-- end Tab-->

<!-- Tab-->
<div tab="2" class="tab_cont_item">
	<br />
    <div class="title">���������� ������� Sipuni</div>
    <br />
    <div class="add_form">
    
    
    <table cellpadding="0" cellspacing="0" class=" ">
    <tr>
        <td class="td_title">����� ��������</td>
        <td class="td_value">{SIPUNI_PHONE} <a class="link_proc" href="javascript:;" onclick="Ucontrol.show_user_options();">��������</a></td>
    </tr>
    <tr>
        <td class="td_title">����</td>
        <td class="td_value">� <input type="text" class="input_text"  id="sipuni_from_date" placeholder="��.��.����" value="" onchange="if(!$('#sipuni_to_date').val()) {$('#sipuni_to_date').val(this.value)}"/>&nbsp;&nbsp; &nbsp;�� <input type="text" class="input_text"  id="sipuni_to_date" placeholder="��.��.����" value=""/></td>
    </tr>
    <tr>
        <td class="td_title"></td>
        <td class="td_value"><a class="button" onclick="Ucontrol.get_sipuni_stat()" href="javascript:;" id="sipuni_btn">
        <div class="right"></div><div class="left"></div><div class="btn_cont">�������� ����������</div></a>
        <div class="clear"></div>
        <div class="" id="sipuni_stat_result"></div>
        </td>
    </tr>
    </table>
    
    <div class="clear"></div>
        
    </div>
    <div id="sipuni_stat_wrap"></div> 
</div>
<!-- end Tab-->

</div>
</div>

<script>

	$("#sipuni_from_date").datepicker({
		  showOn: "button",
		  buttonImage: "/img/calendar.gif",
		  buttonImageOnly: true,
		  changeMonth: true,
		  changeYear: true
	});
	
	$("#sipuni_to_date").datepicker({
		  showOn: "button",
		  buttonImage: "/img/calendar.gif",
		  buttonImageOnly: true,
		  changeMonth: true,
		  changeYear: true
	});

</script>