<div style="display:none" id="add_finance" class="add_form_margin">
<div class="title_add_form">������� ��������� ����</div>
<div class="add_form add_form_margin">

<table cellpadding="0" cellspacing="0" class="add_client_tb">
	<tr>
    	<td class="td_title">�������� �����<sup>*</sup></td>
        <td class="td_value"><input type="text" id="finance_name" value="" class="input_text" />
         <div id="money_summa_error" class="td_error sub_input_error"></div>
     </td>
        
    </tr>
	<tr>
    	<td class="td_title">�����</td>
        <td class="td_value"><input type="text" id="finance_summa" value="0.00" class="finance_summa input_text" style="width:100px" />
        <select id="finance_currency" class="input_text" style="width:70px">{CURRENCY_LIST}</select></td>
        
    </tr>
    <tr>
    	<td class="td_title"></td>
        <td class="td_value"><a class="button" onclick="add_finance()" href="javascript:;" id="add_finance_btn">
    <div class="right"></div><div class="left"></div><div class="btn_cont">������� ��������� ����</div></a>
    </td>
        
    </tr>
  
</table>

</div>
<div class="stand_margin">
<a href="javascript:;" class="link" onclick="$('#add_finance').hide(); $('#show_add_finance_form_a').show()">������</a>
</div>
</div>

<div class="add_new_list_item " id="show_add_finance_form_a"> 
<a href="javascript:;" id="show_add_finance_form_a" class="link" onclick="$('#add_finance').fadeIn(200); $('#show_add_finance_form_a').hide()">+ ������� ��������� ����</a>
</div>


<script>
$('.finance_summa').keydown(sum_mask_proc);
$('.finance_summa').blur(check_for_format)
</script>
