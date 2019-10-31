<?php
/***
	����������� �������������
	
	Ver: 1.0
	Edited: 29.11.2012
*/
// �����������, ���������� �������������
class CAuth 
{
	private $auth_login; // �����
	
	private $auth_password; // ������
	
	private $auth_success = 0; // ���������� �����������
	
	private $auth_error = '';
	
	
	/*
		Tables
	*/
	
	private $clientsTb = CLIENTS_TB; // ������� ��������
	
	private $db;
	
	public function __construct($db)
	{
		$this->db = $db;
		
	}
	
	/*
		set, get $auth_login
	*/
	public function get_auth_login()
	{
		return $this->auth_login;
	}
	public function set_auth_login($s)
	{
		$this->auth_login= $s;
	}
	
	/*
		set, get $auth_password
	*/
	public function get_auth_password()
	{
		return $this->auth_password;
	}
	public function set_auth_password($s)
	{
		$this->auth_password = $s;
	}
	
	/*
		set, get $auth_success
	*/
	public function get_auth_success()
	{
		return $this->auth_success;
	}
	public function set_auth_success($s)
	{
		$this->auth_success = $s;
	}
	
	/*
		set, get $auth_error
	*/
	public function get_auth_error()
	{
		return $this->auth_error;
	}
	public function set_auth_error($s)
	{
		$this->auth_error = $s;
	}

	/*
		����� ������� ��� �����������
		out - ��������� �����������
	*/
	public function no_auth()
	{
		$html_tpl = file_get_contents('templates/html.tpl');
		
		$no_auth_tpl = file_get_contents('templates/no_auth.tpl');
		
		$where = array('{CONTENT}', '{LOGIN}');
	
		$what = array($no_auth_tpl, $login);
	
		$html = str_replace($where, $what, $html_tpl);
		
		return $no_auth_tpl;
	}

	/*
		�������� �����������
		out - true or false
	*/
	public function check_auth()
	{
		
		$client_id = $_SESSION['client_id'];
		
		if($client_id)
		{
			// �������� �����
			$sql = "SELECT client_id FROM ".$this->clientsTb." WHERE client_id='".$client_id."' AND client_deleted <> 1";
				 
			$r=$this->db->query_firstrow($sql);
			
			if($r['client_id'])
			{
				return true;
			}
			else
			{
				return false;
			}
		}// ���� �� �����
		else if($_COOKIE['client_id'] && $_COOKIE['client_password'])
		{
			$sql = "SELECT client_id, client_password FROM ".$this->clientsTb." WHERE client_id='".$_COOKIE['client_login']."' AND client_deleted <> 1";
			 
			$r=$this->db->query_firstrow($sql);
			
			if($_COOKIE['client_password']==$r['client_password'])
			{
				$_SESSION['client_id'] = $r['client_id'];
				
				return true;
			}
		}
		else
		{
			return false;
		}
		
	}

	/*
		����������� ������������
	*/
	public function auth_proc()
	{
		// �����
		$login = $this->auth_login;
		 
		// ������
		$password = $this->auth_password;
		 
		if(!$login)
		{ 
			$this->auth_error = '�� ������ �����!';
			return '';
		}
		if(!$password)
		{
			$this->auth_error = '�� ������ ������!';
			return '';
		}
		
		  
		// ������� �������
		$sql = "SELECT * FROM ".$this->clientsTb." WHERE client_id = '$login' AND client_deleted <> 1";
		 
		$r=$this->db->query_firstrow($sql);
		 
		$password_hash = md5(md5($password).md5(KEY_WORD));
		
		// ���� ������ ������ � ������ ���������
		if($r['client_id'] && $r['client_password']== $password_hash)
		{
			$_SESSION['client_id'] = $r['client_id'];
			 
			setcookie("client_login", $login, time() + 604800,"/");
				 
			setcookie("client_password", $password_hash, time() + 604800,"/");
			
			$this->auth_success = 1;
			
		}
		// ���� ���� ������ � ������ �� ���������
		else if($r['client_id'] && $r['client_password']!= $password_hash)
		{   
			$this->auth_error = '�������� ������!';
		}
		else
		{
			$this->auth_error = '��������� ����� ����������� � ����!';
		}
	}
	
	// ����� ��������������� ������������
	public function auth_exit()
	{
		$_SESSION['client_id']='';
		
		setcookie("client_id", '');
				 
		setcookie("client_password", '');
	 
		header('Location: /client/auth');
	}
	
	public function get_current_client_id()
	{
		return $_SESSION['client_id'];
	}
	
}


?>
