<script>
user_id = "{USER_ID}";
pages_count = '{PAGES_COUNT}';
deal_list_type = '{DEAL_LIST_TYPE}';	 
</script>
{TOP_MENU}

{DEAL_ADD_FORM}

 
{DEALS_REMINDERS_LIST}

<div style="margin-top:20px">
{DEALS_SEARCH_FORM}
<div class="back_cont_bl" >�: <input type="text" id="date_from" style="width:70px" value="{DATE_FROM}" /> ��: <input type="text" style="width:70px"id="date_to" value="{DATE_TO}" /> &nbsp;&nbsp;<select id="search_deals_by_group_id" style="width:150px"><option value="0">- ������ ������ -</option>{DEALS_GROUPS_LIST}</select> &nbsp;&nbsp;<select id="search_deals_by_status" style="width:150px"><option value="0">- ������ ������ -</option>{DEALS_STATUS_LIST}</select> &nbsp; <select id="search_deals_by_call" style="width:150px"><option value="0">- ������ ������ -</option>{DEALS_STATUS_CALL}</select> &nbsp; <a href="javascript:;" onclick="show_deal_by_date(0)" class="link">�����</a> {CLEAR_DATE_BLOCK}</div>
{DEAL_SALES_FUNNEL_BLOCK}
</div> 

<div class="tables_data_1_wrap_visible">
<div class="tables_data_1_wrap_back" style="width:1800px">
<table cellpadding="0" cellspacing="0" id="deals_list" class="deals_list_tb tables_data_1">
<thead>
<tr class="tr_th">
	<th class="">��������</th>
	<th class="">�������<br></th>
	<th class="">�������� ������</th>
    <th class="">��������</th>
    <th class="" style="width:50px">����� ������</th>
    <th class="">�����</th>
    <th class="">����</th>
    <th class="">��� ������</th>
    <th class="">������</th>
    <th class="">���������� ����</th>
    <th class="">����� ������</th>
    <th class="">������ ������</th>
    <th class="" style="width:200px;">�������� ������� ������</th>
	 
</tr>
</thead>

<tbody>
{DEALS_LIST}
</tbody>
</table>
 
 {MORE_DEALS}
 </div>
</div>

  {SMS_PAGE}

<script>
$("#date_from").datepicker({
      showOn: "button",
      buttonImage: "/img/calendar.gif",
      buttonImageOnly: true,
	   changeMonth: true,
      changeYear: true
    });
	
$("#date_to").datepicker({
      showOn: "button",
      buttonImage: "/img/calendar.gif",
      buttonImageOnly: true,
	   changeMonth: true,
      changeYear: true
    });
$("#date_from2").datepicker({
      showOn: "button",
      buttonImage: "/img/calendar.gif",
      buttonImageOnly: true,
	   changeMonth: true,
      changeYear: true
    });
	
$("#date_to2").datepicker({
      showOn: "button",
      buttonImage: "/img/calendar.gif",
      buttonImageOnly: true,
	   changeMonth: true,
      changeYear: true
    });
</script>
