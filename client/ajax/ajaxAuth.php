<?php 
include_once $_SERVER['DOCUMENT_ROOT'].'/client/startup.php';

// ����� �����������
$auth = new CAuth($site_db);

$login = value_proc($_POST['login']);

$password = value_proc($_POST['password']);

// ������������� ����������
$auth->set_auth_login($login);

$auth->set_auth_password($password);

// �����������
$auth->auth_proc();

// ����������
$success = $auth->get_auth_success();

$error = $auth->get_auth_error();

// ���������� ���������
echo json_encode(array('success' => $success, 'error' => iconv("windows-1251", "UTF-8", $error)));
?>