<div id="client_deals_block_{CLIENT_ID}" style="display:none; margin-top:15px">
<div class="cat_block cat_block_margin">������:</div>
<table cellpadding="2" cellspacing="2" class="data_table client_data_table">
<thead>
<tr class="tr_th">
	<th class="nopdl">�</th>
    <th class="">����</th>
    <th class="">������</th>
    <th class="">���������</th>
</tr>
</thead>
<tbody>
{DEALS_LIST}
</tbody>
</table>
<a href="javascript:;" onclick="$('#client_deals_block_{CLIENT_ID}').hide(); $('#deals_btn_{CLIENT_ID}').show();" class="link">������</a>
</div>
<div style="margin-top:15px" id="deals_btn_{CLIENT_ID}">
<a href="javascript:;"   onclick="$('#deals_btn_{CLIENT_ID}').hide(); $('#client_deals_block_{CLIENT_ID}').show()" class="link">�������� ������ � ��������</a>
</div>