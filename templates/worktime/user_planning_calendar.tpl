<div class="st_margin_top">
<a id="show_planning_a" href="javascript:;" onclick="$(this).hide(); $('#planning_calendar').slideDown(300)" class="link">�������� ��������� ������������</a>
<div class="d_none" id="planning_calendar">

<script src="/js/calendar_planning.js"></script>

<script>

// ������ ��� �����
datesArr = {ARRAY_DATES};


//{ARRAY_DATES_DATA}

// ���������� �����
calendareStartDate = '{INIT_DATE}';


jQuery(document).ready(function(){
// ������������� ��������� �������
render_event_calendar(calendareStartDate);
})

</script>
<div>

<!--������ ���������-->
<div class="calendar_block">
	<div class="calendar_block_title">

    	<!--���� ������ ������ � ���� � ���������-->
    	<table cellpadding="0" cellspacing="0" style="margin:auto">
        	<tr>
            	<td class="calendar_title_form">��������� ������������</td>
            	<td class="c_pad"><a href="javascript:;" onClick="change_month('prev')" class="calendar_larr" ></a></td>
                <td class="c_pad"><div class="calendar_shape_1" id="change_calendar_month"></div></td>
                <td class="c_pad"><a href="javascript:;" onClick="change_month('next')" class="calendar_rarr"></a></td>
                <td class="calendar_sep"></td>
                <td class="c_pad"><a href="javascript:;" onClick="change_year('prev')" class="calendar_larr"></a></td>
                <td class="c_pad"><div class="calendar_shape_2" id="change_calendar_year"></div></td>
                <td class="c_pad"><a href="javascript:;" onClick="change_year('next')" class="calendar_rarr"></a></td>
            </tr>
        </table>
        <!--����� ���� ������ ������ � ���� � ���������-->
    </div>
	<div class="calendar_panel">
    	<div class="calendar_panel_left"></div>
        <div class="calendar_panel_right"></div>
    	<div class="calendar_margin_block"></div>
    	<table  cellpadding="0" cellspacing="0" style="margin:auto" border="0" class="calendar_table" id="calendar-container">

        </table>
	</div>
</div>
<!--����� ������ ���������-->
</div>

<div class="sub_calendar_legend">
<div class="legend_item"><div class="icon green"></div> - �������</div>
<div class="legend_item"><div class="icon orange"></div> - ������</div>
<div class="legend_item"><div class="icon pink"></div> - �����</div>
<div class="legend_item"><div class="icon red"></div> - �������</div>

<div class="clear"></div>
</div>

</div>
</div>