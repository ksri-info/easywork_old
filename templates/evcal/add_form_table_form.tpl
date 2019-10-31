<div style="display:none" id="add_form_block_0" class="add_form_margin">
<div class="title_add_form">�������� �������</div>
<div class="add_form add_form_margin">

<table cellpadding="0" cellspacing="0" class="evcal_add_tb">
	<tr>
    	<td class="td_title td_vert_top" style="width:80px">��������<sup>*</sup></td>
        <td class="td_value"><input type="text" id="event_name_0"  class="input_text" style="width:600px"/>
        <div class="error_inp"></div>
        </td>
    </tr>

    <tr>
    	<td class="td_title td_vert_top" style="width:80px">������</td>
        <td class="td_value"><input type="text" id="event_start_0"  class="input_text" style="width:65px"/>&nbsp;&nbsp;&nbsp;<select class="input_text" style="padding:2px !important" id="event_start_hour_0">{TIME_HOURS_LIST}</select> : <select class="input_text" style="padding:2px !important" id="event_start_minute_0">{TIME_MINUTES_LIST}</select>
        <div class="error_inp"></div>
        </td>
    </tr>
    <tr>
    	<td class="td_title td_vert_top" style="width:80px">�����</td>
        <td class="td_value"><input type="text" id="event_finish_0"  class="input_text" style="width:65px"/>&nbsp;&nbsp;&nbsp;<select class="input_text" style="padding:2px !important" id="event_finish_hour_0">{TIME_HOURS_LIST}</select> : <select class="input_text" style="padding:2px !important" id="event_finish_minute_0">{TIME_MINUTES_LIST}</select>
        <div class="error_inp"></div>
        </td>
    </tr>
     <tr>
    	<td class="td_title td_vert_top" style="width:80px">���������</td>
        <td class="td_value">�� <select class="input_text" id="event_reminder_0">{REMINDER_LIST}</select> ����(���)
        <div class="error_inp"></div>
        </td>
    </tr>
	<tr>
    	<td class="td_title td_vert_top" style="width:80px">��������</td>
        <td class="td_value"><textarea class="input_text" style="width:600px" id="event_desc_0"></textarea>
        <div class="error_inp"></div>
        </td>
    </tr>
    <tr>
    	<td class="td_title td_vert_top" style="width:80px">���������</td>
        <td class="td_value"><select id="event_category_0" class="input_text"><option value="0">�� ���������</option>{CATEGORIES_LIST}</select>
        <div class="error_inp"></div>
        </td>
    </tr>
    
    <tr>
    	<td class="td_title"></td>
        <td class="td_value">
        <a class="button" onclick="Evcal.add_event(0,0)" href="javascript:;" id="add_event_btn">
  	    <div class="right"></div><div class="left"></div><div class="btn_cont">�������� �������</div></a>
        <div class="clear"></div>
        <div class="error_box" id="error_box_0"></div>
	    <div id="success_0" class="success_marg"></div>

	</td>
        
    </tr> 
    
     
</table>

</div>

<div class="stand_margin">
<a href="javascript:;" class="link" onclick="$('#add_form_block_0').hide(); $('#show_add_form_a').show()">������</a>
</div>

</div>


<div class="add_new_list_item" id="show_add_form_a" > 
<a href="javascript:;" class="link" onclick="$('#add_form_block_0').fadeIn(200); $('#show_add_form_a').hide()">+ �������� �������</a>
</div>
<script>

$("#event_start_0").datepicker({
			  showOn: "button",
			  buttonImage: "/img/calendar.gif",
			  buttonImageOnly: true,
			  changeMonth: true,
			  changeYear: true
			});
$("#event_finish_0").datepicker({
			  showOn: "button",
			  buttonImage: "/img/calendar.gif",
			  buttonImageOnly: true,
			  changeMonth: true,
			  changeYear: true
			});	
			
 

$("#event_start_0").bind('change', function() {
	$('#event_finish_0').val(this.value);
});

$("#event_start_hour_0").bind('change', function() {
	var date_start = $('#event_start_0').val();
	var event_finish = $('#event_finish_0').val();
	
	if(date_start==event_finish)
	{
		$("#event_finish_hour_0").val($(this).val());
	}
});

$("#event_start_minute_0").bind('change', function() {
	var date_start = $('#event_start_0').val();
	var event_finish = $('#event_finish_0').val();
	var event_start_hour = $('#event_start_hour_0').val();
	var event_finish_hour = $('#event_finish_hour_0').val();
	
	if(date_start==event_finish && event_start_hour==event_finish_hour)
	{
		$("#event_finish_minute_0").val($(this).val());
	}
});

</script>