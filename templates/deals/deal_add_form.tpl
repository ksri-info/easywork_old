<div style="display:none" id="add_deal_form_block" class="add_form_margin">
<div class="title_add_form">�������� ����� ������</div>
<div  class="add_form add_form_margin">
<table cellpadding="0" cellspacing="0" class="add_client_tb">
	 
	<tr>
    	<td class="td_title">�������� ������</td>
        <td class="td_value"><input type="text" id="deal_name" value="" class="input_text" /></td>
        
    </tr>
    <tr>
    	<td class="td_title">������</td>
        <td class="td_value"><select id="deal_group"></select></td>
        
    </tr>
    <tr>
    	<td class="td_title"></td>
        <td class="td_value">{DEALS_TYPES_BLOCK}</td>
        
    </tr>
    
    <tr>
    	<td class="td_title">������<sup>*</sup></td>
        <td class="td_value"><select  id="deal_client"></select>
        <div id="client_name_error" class="td_error sub_input_error"></div>
        <div class="add_deal_sub_client" id="client_notice">�������� �������� ��� ���������� � ���������� �������</div></td>
        
    </tr>
    <tr>
    	<td class="td_title">���������� ����</td>
        <td class="td_value"><input type="text" id="deal_contact_person" value="" class="input_text" /></td>
        
    </tr>
    <tr>
    	<td class="td_title">E-mail</td>
        <td class="td_value"><input type="text" id="deal_email" value="" class="input_text" /></td>
        
    </tr>
    <tr>
    	<td class="td_title">�����</td>
        <td class="td_value"><input type="text" id="deal_address" value="" class="input_text" /></td>
        
    </tr>
    <tr>
    	<td class="td_title">�������</td>
        <td class="td_value"><input type="text" id="deal_phone" value="" class="input_text" /></td>
        
    </tr>
    <tr>
    	<td class="td_title">�������������� ����������</td>
        <td class="td_value"><textarea type="text" id="deal_other_info" class="input_text" /></textarea></td>
        
    </tr>
    <tr>
    	<td class="td_title">����� ������</td>
        <td class="td_value"><input type="text" id="deal_price" value="" class="input_text" /></td>
        
    </tr>
    <tr>
    	<td class="td_title">������ ������</td>
        <td class="td_value"><select style="width:200px" class="input_text" id="deal_status"><option value="0">- �������� ������ ������ -</option>{DEALS_STATUSES_LIST}</select></td>
        
    </tr>
	<tr>
    	<td class="td_title">�����</td>
        <td class="td_value"><textarea type="text" id="deal_report" class="input_text" /></textarea></td>
        
    </tr> 
    <tr>
    	<td class="td_title"></td>
        <td class="td_value"><input type="checkbox" id="deal_private_edit" /> <label for="deal_private_edit">��������� �������������� ���������� �� ������ ����, ����� ����������� �����������.</label></td>
        
    </tr>
    
    <tr>
    	<td>
        </td>
        <td class="td_value">
        	<div id="file_form_0"></div>
        </td>
    </tr>

	<tr>
    	<td class="td_title"></td>
        <td class="td_value"><a class="button" onclick="add_new_deal()" href="javascript:;" id="add_deal_btn">
    <div class="right"></div><div class="left"></div><div class="btn_cont">�������� ������</div></a> </td>
        
    </tr> 
     
</table>


 
</div>
<div class="stand_margin">
<a href="javascript:;" class="link" onclick="$('#add_deal_form_block').hide(); $('#show_deal_add_form_a').show()">������ ����� ����������</a>
</div>
</div>


 
<div style="display:none" id="import_deal_form_block" class="add_form_margin">
<div class="title_add_form">������������� ������</div>
<div  class="add_form add_form_margin">
<table cellpadding="0" cellspacing="0" class="add_client_tb">
	 
	<tr>
    	<td class="td_title">�������� ������</td>
        <td class="td_value"><input type="text" id="import_deal_name" value="" class="input_text" /></td>
        
    </tr>
    <tr>
    	<td class="td_title">������</td>
        <td class="td_value"><select id="import_deal_group"></select></td>
        
    </tr>
	<tr>
    	<td class="td_title"></td>
        <td class="td_value" id='import_deal_type'>{DEALS_TYPES_BLOCK}</td>
        
    </tr>
	<tr>
    	<td class="td_title">������<sup>*</sup></td>
        <td class="td_value"><select  id="import_deal_client"></select>
        <div id="import_client_name_error" class="td_error sub_input_error"></div>
        <div class="add_deal_sub_client" id="import_client_notice">�������� �������� ��� ���������� � ���������� �������</div></td>
        
    </tr>
    <tr>
    	<td class="td_title">������ ������</td>
        <td class="td_value"><select style="width:200px" class="input_text" id="import_deal_status"><option value="0">- �������� ������ ������ -</option>{DEALS_STATUSES_LIST}</select></td>
        
    </tr>
	<tr>
    	<td class="td_title">�����</td>
        <td class="td_value"><textarea type="text" id="import_deal_report" class="input_text" /></textarea></td>
        
    </tr> 
    <tr>
    	<td class="td_title"></td>
        <td class="td_value"><input type="checkbox" id="import_deal_private_edit" /> <label for="deal_private_edit">��������� �������������� ���������� �� ������ ����, ����� ����������� �����������.</label></td>
        
    </tr>
    
    <tr>
    	<td>
        </td>
        <td class="td_value">
			<input id="file_form_import" type="file" class="form-control" name="import_data"  autofocus>
<!--        	<div id="file_form_import"></div>-->
        </td>
    </tr>

	<tr>
    	<td class="td_title"></td>
        <td class="td_value"><a class="button" onclick="import_new_deal()" href="javascript:;" id="import_deal_btn">
    <div class="right"></div><div class="left"></div><div class="btn_cont">�������������</div></a> </td>
        
    </tr> 
     
</table>


 
</div>
<div class="stand_margin">
<a href="javascript:;" class="link" onclick="$('#import_deal_form_block').hide(); $('#show_deal_import_form_a').show()">������ ����� �������</a>
</div>
</div>


 
<div class="add_new_list_item" > 
<a href="javascript:;" id="show_deal_add_form_a" class="link" onclick="$('#add_deal_form_block').fadeIn(200); $(this).hide()">+ �������� ������</a>
&nbsp;&nbsp;&nbsp;
<a href="javascript:;" id="show_deal_import_form_a" class="link" onclick="$('#import_deal_form_block').fadeIn(200); $(this).hide()">�������������</a>
</div>


<script>
$(document).ready(function(){
	$('#deal_client').easycomplete(
	{
		str_word_select : '������� �������',
		width:520,
		url:'/ajax/ajaxGetClients.php',
		show_tag : 1
	});	
        
        $('#import_deal_client').easycomplete(
	{
		str_word_select : '������� �������',
		width:520,
		url:'/ajax/ajaxGetClients.php',
		show_tag : 1
	});		
	
	$('#deal_group').easycomplete(
			{
				str_word_select : '������� ������ ������',
				width:520,
				show_tag : 1,
				trigger : 1,
				url:'/ajax/ajaxDeals.php?mode=get_deals_groups'
			});
                        
        $('#import_deal_group').easycomplete(
	{
		str_word_select : '������� ������ ������',
		width:520,
		show_tag : 1,
		tag_ct : ' (����� ��������� ����� ������)',
		trigger : 1,
		url:'/ajax/ajaxDeals.php?mode=get_deals_groups'
	});
});

Disk.get_content_file_upload_form('0', 5, 'file_form_0');

</script>
