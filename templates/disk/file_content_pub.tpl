<div class="" style="width:520px">
<div id="file_pub_bl_{FILE_ID}">
{FILE_PUB_LIST}
</div>

<div class="file_pub_form_wrap" id="file_pub_form_wrap_{FILE_ID}">
 
<table cellpadding="0" cellspacing="0"  class="pub_tb">
<tr>
	<td style="padding:0px;">���� ����� �������� � �������:</td>
    <td style="text-align:right"><input type="text" class="input_text" style="width:30px; display:none" id="file_pub_time_value_{FILE_ID}"/> <select id="file_pub_time_mode_{FILE_ID}" class="input_text" onchange="Disk._sh_time_inp({FILE_ID})"><option value="0">���������</option><option value="1">����</option><option value="2">�����</option><option value="3">�����</option></select></td>
</tr>
<tr>
	<td colspan="2" style="padding:0px"><textarea class="input_text" placeholder="�����������.." style="width:390px" id="file_pub_desc_{FILE_ID}"></textarea></td>
</tr>
</table>

 
 

<div class="clear"></div>
<br />
<a id="save_file_pub_btn_{FILE_ID}" href="javascript:;" onclick="Disk.save_file_pub('{FILE_ID}')" class="button"><div class="right"></div><div class="left"></div><div class="btn_cont">������������ ���� � ���������</div></a>
<div class="clear"></div>
</div>
</div>
