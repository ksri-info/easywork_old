<table cellpadding="0" cellspacing="0" class="user_settings_tb table">
<tr>
	<td class="td_title"></td>
    <td class="td_value"><div class="us_bl_title_st ">����������</div></td>
</tr>

<tr>
	<td class="td_title">�������</td>
    <td class="td_value"><input {USER_NAME_DISABLED} type="text" id="surname" class="input_text" value="{SURNAME}"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">���</td>
    <td class="td_value"><input {USER_NAME_DISABLED} type="text" id="name" class="input_text" value="{NAME}"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">��������</td>
    <td class="td_value"><input {USER_NAME_DISABLED} type="text" id="middlename" class="input_text" value="{MIDDLENAME}"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">���� ��������</td>
    <td class="td_value"><select id="bdate_day" class="input_select"  onchange="chenge_to_day=this.value"></select>
    <select id="bdate_month" class="input_select" onchange="init_select_date_block_init_days($('#bdate').val())"></select>
    <select id="bdate_year" class="input_select" onchange="init_select_date_block_init_days($('#bdate').val())"></select>
    <input type="hidden"  value="{BDATE}" id="bdate"/></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">���������</td>
    <td class="td_value"><input {POSITION_DISABLED} type="text" id="position" class="input_text" value="{POSITION}"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">�������</td>
    <td class="td_value"><select class="input_text" id="phone_country_code" onchange="change_phone_mask()" style="width:100px"><option value="RU">������</option><option value="BY">����������</option><option value="UK">�������</option></select>&nbsp;&nbsp;&nbsp;<input type="text" id="phone" class="input_text" value="{PHONE}" style="width:200px"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">E-mail</td>
    <td class="td_value"><input type="text" id="email" class="input_text" value="{EMAIL}"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">�����</td>
    <td class="td_value"><input type="text" id="login" class="input_text" value="{LOGIN}"></td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">����� ������</td>
    <td class="td_value"><input type="password" id="pass" class="input_text">{CHANGE_PASSWORD_NOTICE}</td>
    <td class="td_error"></td>
</tr>
<tr>
	<td class="td_title">����� ������ ��� ���</td>
    <td class="td_value"><input type="password" id="pass1" class="input_text"></td>
    <td class="td_error"></td>
</tr>

<tr>
	<td class="td_title"></td>
    <td class="td_value"><div class="us_bl_title">������������</div></td>
</tr>

<tr>
	<td class="td_title"></td>
    <td class="td_value">
    <div class="auth_method_bl"><input type="radio" name="auth_method" id="auth_method_1" {AUTH_METHOD_0} value="0" /> <label for="auth_method_1">����������� ����� <b>������</b>.</label></div>
    <div class="auth_method_bl"><input type="radio" name="auth_method" id="auth_method_2" {AUTH_METHOD_1} value="1"/> <label for="auth_method_2">����������� ����� <b>���-���</b>.</label></div>
    <div class="auth_method_bl"><input type="radio" name="auth_method" id="auth_method_3" {AUTH_METHOD_2} value="2"/> <label for="auth_method_3">����������� ����� <b>������</b> � <b>���-���</b>.</label></div>
    </td>
    <td class="td_error"></td>
</tr>

<tr>
	<td></td>
    <td class="td_value">
    <div class="us_bl_title"></div>
    <a class="button" onclick="save_profile_settings('{USER_ID}')" href="javascript:;" id="save_profile_settings_btn"><div class="right"></div><div class="left"></div><div class="btn_cont">���������</div></a>
    <br class="clear" />
    <div id="settings_result"></div>
    </td>
    <td  style="text-align:left"></td>
</tr>
</table>

 
<script>
init_phone_mask();
init_select_date_block($('#bdate').val());
</script>