<div class="tables_data_1_wrap_visible">
<div class="tables_data_1_wrap_back" style="width:710px; overflow-x:scroll">
<table cellpadding="0" cellspacing="0" id="deals_list" class="deals_list_tb tables_data_1">
<thead>
<tr class="tr_th">
	<th class="">���</th>
	<th class="">��������</th>
	<th class="">���</th>
    <th class="">���������� ����</th>
    <th class="">����������� �����</th>
    <th class="">����������� �����</th>
    <th class="">�������</th>
    <th class="">����</th>
    <th class="">E-mail</th>
    <th class="">����</th>
    <th class="">���</th>
    <th class="">� �����</th>
    <th class="">��������</th>
</tr>
</thead>
<tbody id="clients_list">
{CLIENTS_LIST}
</tbody>
</table>
</div>
</div>

<div style="margin:10px 0px 10px 0px">
�������� �����, ������� ����� ��������� ��� ���� ����������� ������������:
</div>
<table cellpadding="0" cellspacing="0" class="add_client_tb">
   <tr>
    	<td class=""><input type="checkbox" id="client_private_edit" /> <label for="client_private_edit">��������� ������������� � ������������� ���������� �� ������� ����, ����� ����������� �����������.</label></td>
        
    </tr>
  
    <tr>
    	<td>
        <br /><a class="button" onclick="client_import_save('{IMPORT_FILE}')" href="javascript:;" id="client_import_save_btn">
    <div class="right"></div><div class="left"></div><div class="btn_cont">��������� ������ �����������</div></a>
    	
        <div style="float:left; padding:4px 0px 0px 10px">��� <a href="javascript:;" onclick="$('#import_preview').html('');$('#import_add_form').show();" class="link">�������� � ��������� ����� ����</a></div>
    	</td>
         
    </tr>
</table>

