<div id="reg_result"></div>

<div id="reg_form">

<table cellpadding="0" cellspacing="0" class="user_settings_tb table">
<tr>
	<td class="td_title"></td>
    <td class="td_value"><div class="us_bl_title_st">����������</div></td>
</tr>
<tr>
	<td class="td_title">�������<sup>*</sup></td>
    <td class="td_value"><input type="text" id="surname" class="input_text"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">���<sup>*</sup></td>
    <td class="td_value"><input type="text" id="name" class="input_text"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">��������<sup>*</sup></td>
    <td class="td_value"><input type="text" id="middlename" class="input_text"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">���������<sup>*</sup></td>
    <td class="td_value"><input type="text" id="position" class="input_text"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">�������<sup>*</sup></td>
    <td class="td_value"><select class="input_text" id="phone_country_code" onchange="change_phone_mask()" style="width:100px"><option value="RU">������</option><option value="BY">����������</option><option value="UK">�������</option></select>&nbsp;&nbsp;&nbsp;<input type="text" id="phone" class="input_text" value="" style="width:200px">
    <div class="sub_input">��������� ��� ��������� ��������</div></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">E-mail</td>
    <td class="td_value"><input type="text" id="email" class="input_text"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">�����<sup>*</sup></td>
    <td class="td_value"><input type="text" id="login" class="input_text"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">������<sup>*</sup></td>
    <td class="td_value"><input type="password" id="pass" class="input_text"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">������ ��� ���<sup>*</sup></td>
    <td class="td_value"><input type="password" id="pass1" class="input_text"></td>
    <td class="td_error"></td>
</tr>

<tr>
	<td class="td_title"></td>
    <td class="td_value"><div class="us_bl_title">���������</div></td>
</tr>

<tr>
	<td class="td_title">�������������</td>
    <td class="td_value"><select style="width:400px; height:150px; overflow-y:scroll" id="user_dept" class="input_text" multiple="multiple" >{DEPST_LIST}</select></td>
    <td class="td_error"></td>
</tr>




<tr>
	<td class="td_title"></td>
    <td class="td_value"><div class="us_bl_title">����������</div></td>
</tr>
<tr>
	<td class="td_title"></td>
    <td class="td_value">
     <div class="auth_method_bl"><input type="checkbox" id="user_is_admin"> <label for="user_is_admin">������������� �������</label></div>
     </td>
    
</tr>
<tr>
	<td class="td_title"></td>
    <td class="td_value">
     <div class="auth_method_bl"><input type="checkbox" id="user_is_full_access" > <label for="user_is_full_access">������ ������ � �������� �����������</label></div>
     </td>
    
</tr>
<tr>
	<td class="td_title"></td>
    <td class="td_value"><div class="us_bl_title">����������� �������</div></td>
</tr>
<tr>
	<td class="td_title"></td>
    <td class="td_value">
     <input type="radio" style="margin-left:0px" name="user_limitation" value="1" checked="checked"/> ������ ����� ������ ������������ <br><input type="radio" style="margin-left:0px" name="user_limitation" value="2" /> ������ ����� ������ ������������� ������ ������<br><input type="radio" style="margin-left:0px" name="user_limitation" value="0" /> ������ ����� ����
     </td>
    
</tr>
<tr>
	<td></td>
    <td class="td_value">
    <br />
    <a class="button" onclick="registration()" href="javascript:;" id="reg_btn"><div class="right"></div><div class="left"></div><div class="btn_cont">���������������� ����������</div></a>
   
</tr>
</table>
</div>

<script>
$("#phone").mask("+7 (999) 999-99-99");
</script>