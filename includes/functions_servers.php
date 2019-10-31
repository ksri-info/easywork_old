<?php
// ����������� �������� ��� ������������� �������� ��� ������ ������
function server_detect()
{
	global $_SERVERS_ARRAY, $_SERVER_ID, $_SERVER_MYSQL_DB_HOST, $_SERVER_MYSQL_DB_NAME, $_SERVER_MYSQL_DB_USER, $_SERVER_MYSQL_DB_PASSWORD;
	
	$http_host = str_replace(array('http://', 'www.'), '', $_SERVER['HTTP_HOST']);
	
	include_once $_SERVER['DOCUMENT_ROOT'].'/bills_config.php'; //���������
	include_once $_SERVER['DOCUMENT_ROOT'].'/client_config.php'; //���������
	 
	$site_db = new Db($db_bills_host, $db_bills_user, $db_bills_password, $db_bills_name);
	$site_db->query('SET NAMES cp1251');
	
	// ����� ������� �� ��� �����
	$sql = "SELECT * FROM easy_bills.bills_clients_hosts WHERE host='$http_host'";
	
	$client_host_data = $site_db->query_firstrow($sql);
		
	if($client_host_data['host_id'])
	{ 
		$client_id = $client_host_data['client_id'];
		
		// ������������ �������
		$sql = "SELECT * FROM easy_bills.bills_clients_config WHERE client_id='$client_id'";
		
		$client_config_data = $site_db->query_firstrow($sql); 
		
		// �������� ��
		$db_name = $client_config_data['client_db_name'];
		
		// ���� ���� �������� �� ������, ������� ���������� ����������� ��� �� ��� �������
		if(!$db_name)
		{
			$db_name = get_client_db_name($client_id);
		}
		
		
		$_SERVER_ID = $client_id;
	
		$_SERVER_MYSQL_DB_HOST = 'localhost';
		 
		$_SERVER_MYSQL_DB_NAME = $db_name;
                    
		$_SERVER_MYSQL_DB_USER = $client_db_user;
		
		$_SERVER_MYSQL_DB_PASSWORD = $client_db_password;
	}
	else
	{
		client_not_found();
	}
}

function client_not_found()
{
	exit();
}

// ������������ ��� �� �������
function get_client_db_user($client_id)
{
	// �������� �� �������
	$db_name = get_client_db_name($client_id);
	
	// ������������ ��� ��
	$db_user_login = 'user_'.$db_name;
	
	return $db_user_login;
}

function get_client_db_name($client_id)
{
	// �������� �� ��� �������
	$db_name = 'client_'.$client_id;
	
	return $db_name;
}


// ���������� ���������� � ip ������������ � ������� �� � �������
function detect_provider()
{
	global $site_db, $current_user_id, $user_obj;
	
	if (getenv('HTTP_X_FORWARDED_FOR'))
	{
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	}
	else 
	{
		$ip = getenv('REMOTE_ADDR');
	}
	
	if(!$current_user_id)
	{
		return '';
	}
		
	if(!$_SESSION['remote_addr']['ip'])
	{  
		$ip_number  = ip_to_number($ip);
		
		// ������� ����� � ���������
		$sql = "SELECT city_name, isp, region_name FROM tasks_ip2location_db4 WHERE (ip_from <= '$ip_number') AND (ip_to >='$ip_number')";
		
		$row = $site_db->query_firstrow($sql);
		
		if($row['city_name'])
		{
			$city = addslashes(value_proc($row['city_name']));
			$provider = addslashes(value_proc($row['isp']));
			$region = addslashes(value_proc($row['region_name']));
			$_SESSION['remote_addr']['ip'] = $ip;
			$_SESSION['remote_addr']['provider'] = $row['isp'];
			
		}
		else
		{
			$city='�� ���������';
			$provider='�� ���������';
			$_SESSION['remote_addr']['ip'] = $ip;
			$_SESSION['remote_addr']['provider'] = $provider;
		}
	}
}
?>