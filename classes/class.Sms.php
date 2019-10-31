<?php
/***
	�������� ���-���������
	
	Ver: 1.0
	Edited: 26.12.2011
*/
class CSms {
	
	private $sms_login = 'tol271'; // �����
	
	private $sms_password = 'Qw1905s'; // ������
	
	private $sms_to = ''; //����� ���������� � ������������� �������
	
	private $sms_from = '+74996475461'; //����� �����������, ����������� ��� 11 ���� ��� ���.  ����
	
	private $sms_coding = '2'; // 0 - ��������� �������, 1 - �������� ���������, 2 - ���������������� �������
	
	private $sms_text = ''; // ���� ��������� (�� 765 ��������� ����. ��� 335 ������. ����)
	
	private $sms_priority = 0; //��������� ���������, �� 0 �� 3
	
	private $sms_mclass = 1; // ����� ���������, 0 - ����, 1 - ������� ��� 
	
	private $sms_dlrmask = 31; // ����������� � ��������, 0  - ��������, 31 - �������, �� ��������� 31
	
	private $sms_deferred = 0; // ��������, ����� �������� ������� ��������� ��������� � �������
	
	private $sms_send_result_arr = ''; // ������ ���������� �� �������� ������� �� �������� ���-���������
	
	public function __construct()
	{
		  
	}
	
	/*
		set, get $sms_send_result_arr
	*/
	public function getSmsSendResultArr()
	{
		return $this->sms_send_result_arr;
	}
	public function setSmsSendResultArr($s)
	{
		$this->sms_send_result_arr = $s;
	}
	
	/*
		set, get $sms_deferred
	*/
	public function getSmsDeferred()
	{
		return $this->sms_deferred;
	}
	public function setSmsDeferred($s)
	{
		$this->sms_deferred = $s;
	}
	
	/*
		set, get $sms_dlrmask
	*/
	public function getSmsDlrmask()
	{
		return $this->sms_dlrmask;
	}
	public function setSmsDlrmask($s)
	{
		$this->sms_dlrmask = $s;
	}
	
	/*
		set, get $sms_mclass
	*/
	public function getSmsMclass()
	{
		return $this->sms_mclass;
	}
	public function setSmsMclass($s)
	{
		$this->sms_mclass = $s;
	}
	
	/*
		set, get $sms_priority
	*/
	public function getSmsPriority()
	{
		return $this->sms_priority;
	}
	public function setSmsPriority($s)
	{
		$this->sms_priority = $s;
	}
	
	/*
		set, get $sms_text
	*/
	public function getSmsText()
	{
		return $this->sms_text;
	}
	public function setSmsText($s)
	{
		$this->sms_text = $s;
	}
	
	/*
		set, get $sms_coding
	*/
	public function getSmsCoding()
	{
		return $this->sms_coding;
	}
	public function setSmsCoding($s)
	{
		$this->sms_coding = $s;
	}
	
	/*
		set, get $sms_from
	*/
	public function getSmsFrom()
	{
		return $this->sms_from;
	}
	public function setSmsFrom($s)
	{
		$this->sms_from = $s;
	}
	
	/*
		set, get $sms_to
	*/
	public function getSmsTo()
	{
		return $this->sms_to;
	}
	public function setSmsTo($s)
	{
		$this->sms_to = $s;
	}
	
	/*
		set, get $sms_login
	*/
	public function getSmsLogin()
	{
		return $this->sms_login;
	}
	public function setSmsLogin($s)
	{
		$this->sms_login = $s;
	}
	
	/*
		set, get $sms_password
	*/
	public function getSmsPassword()
	{
		return $this->sms_password;
	}
	public function setSmsPassword($s)
	{
		$this->sms_password = $s;
	}
	
	// ���������� ������ �� ������� ��� ���������
	//
	public function send_sms()
	{
		// xml ��� �������
		
		$xml_sms_body ='<?xml version="1.0" encoding="windows-1251"?>
						<message>
						<username>'.$this->sms_login.'</username>
						<password>'.$this->sms_password.'</password>
						<from>'.$this->sms_from.'</from>
						<to>'.$this->sms_to.'</to>
						<coding>'.$this->sms_coding.'</coding>
						<dlrmask>'.$this->sms_dlrmask.'</dlrmask>
						<text>'.$this->sms_text.'</text>
						</message>';
		
		
		//�������������� �����
		$curl = curl_init();
		 
		//�c����������� ���, � �������� ���������
		curl_setopt($curl, CURLOPT_URL, 'https://www.stramedia.ru/modules/xml_send_sms.php');
		 
		//�������� ����� ����������
		curl_setopt($curl, CURLOPT_HEADER, 0);
		 
		//�������� ������ �� ������ post
		curl_setopt($curl, CURLOPT_POST, 1);
		 
		//������ curl ������ ��� �����, � �� �������
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		 
		curl_setopt($curl, CURLOPT_HTTPHEADER, 
        array('Content-Type: text/xml; charset=utf-8', 
              'Content-Length: '.strlen($xml_sms_body)));
			  
		curl_setopt($curl, CURLOPT_POSTFIELDS, $xml_sms_body);
			  
		curl_setopt($curl, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		 
		$result = curl_exec($curl);
		 
		curl_close($curl);
		
		// ������� � �������� ��������� ���������� �������
		$this->sms_send_result_arr = $result;
	}
	
	// ��������� ���������� ������� �� �������� ���-��������� 
	public function get_responce_send_text()
	{
		// ������ �� �������
		$array_errors = array("Error: Invalid xml" => "��������� ������� ���� ����������� ���������� � �������",
		"Error: Invalid username or password or user is blocked" => "��������� ����� � ������ � ��, ��� ��� ����� �� ������������",
		"Error: Invalid or missing 'from' address" => "��������� ������� � ������ ������ ����������", 
		"Error: Invalid or missing 'to' address" => "��������� ������� � ����� ������ �����������",
		"Error: Invalid or missing coding" => "��������� ������� � �������� ��������� coding",
		"Error: Missing text" => "��������� ������� ��������� text",
		"Error: Text too long" => "��������� ����� ��������� text", 
		"Error: IP not allowed" => "��� IP ����������, ���������� � �������������� �������",
		"Error: Max limit exceeded" => "�� �������� ������������� ����� sms, ���������� � �������������� �������", 
		"Error: Insufficient balance" => "� ��� �� ����������� ������");
		
		if(preg_match('/Success: Message accepted for sending/', $this->sms_send_result_arr))
		{
			return 'succuss';
		}
		 
		// ������ ������ �� �������� �������
		$result_arr = new SimpleXMLElement($this->sms_send_result_arr);
		
		// ��������� ����������
		$result_text = trim($result_arr->text);
		 
		//������
		return $array_errors[$result_text];
		 
	}
	
	// �������� ������� ������������� ���-���������
	// in - id sms ���������, code(� ����� ���� ����������,0-���, 1-�����)
	public function get_sms_status($sms_id, $code=0)
	{
		// xml ��� �������
		$xml_sms_status_body ='<?xml version="1.0" encoding="windows-1251"?>
						<message>
						<username>'.$this->sms_login.'</username>
						<password>'.$this->sms_password.'</password>
						<id>'.$sms_id.'</id>
						</message>';
		
		$host = 'www.stramedia.ru';
		
 		$fp = fsockopen($host, 80);
		
		fputs($fp, "POST https://www.stramedia.ru/modules/xml_sms_sta HTTP/1.1\r\n");
		fputs($fp, "Host: $host\r\n");
		fputs($fp, "Content-type: text/xml; charset=utf-8\r\n");
		fputs($fp, "Content-length: ". strlen($xml_sms_status_body) ."\r\n");
		fputs($fp, "Connection: close\r\n\r\n");
		fputs($fp, $xml_sms_status_body);
		
		$result = ''; 
		
		// �����
		while(!feof($fp))
		{
			$result .= fgets($fp, 128);
		}
		
		// ������ ������ �� �������� �������
		$result_status_arr = new SimpleXMLElement($result);
		
		// �������
		$array_status = array('0' => '��������� �������� �����',
							  '1' => '������� ���������� �� ����������',
							  '2' => '������� ���������� �������� SMS',
							  '4' => '��������� � ������� � ��������� �����',
							  '8' => '�������� ����� ������ SMS',
							  '16' => '�������� ����� �������� SMS',
							  '32' => '���� �������� SMS');
							  
		$result_status_arr->status;
		
		// ���������� ������ �������� � ���� ����
		if($code==0)
		{
			return 	$result_status_arr->status;	
		}
		// ���������� ������ �������� � �������� ����
		if($code==1)
		{
			return 	$array_status[$result_status_arr->status];	
		}
				  
	}
	
	// ������� ��������� � ��������
	// in - �����
	public function  translit_sms_text($text)
	{
		$tr = array(
        "�"=>"a","�"=>"b",
        "�"=>"v","�"=>"g","�"=>"d","�"=>"e","�"=>"zh",
        "�"=>"z","�"=>"i","�"=>"i","�"=>"k","�"=>"l",
        "�"=>"m","�"=>"n","�"=>"o","�"=>"p","�"=>"r",
        "�"=>"s","�"=>"t","�"=>"u","�"=>"f","�"=>"h",
        "�"=>"c","�"=>"ch","�"=>"sh","�"=>"shh","�"=>"",
        "�"=>"y","�"=>"","�"=>"je","�"=>"ju","�"=>"ja");
		
    	return strtr($text,$tr);
	}

	// ��������� ������� �� ������������
	// in - ����� ��������
	public function check_phone_number($phone)
	{
		// ����� ������ ��������
		$phone_length = strlen($phone);
		
		// ���� �������� �������� � ����������� �����
		if(is_numeric($phone) && $phone_length==11)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>