<?php

   
	 

$email = $_GET['email'];

	//send_mail('alex_skv@mail15.com', 'subject', '', 'noraply@ksri.info', 'noraply@ksri.info');
	 
send_mail($email, '�� ����������� �������', '', 'noraply@ksri.info', '����������� �������');	 
	
function send_mail($to,$subject,$mail_template,$from_mail='',$from_name='')
{
	$mail_template=str_replace($where,$what,$mail_template);
				
	$charset = 'CP-1251';
	$encoded_subject = "=?$charset?B?" . base64_encode ($subject) . "?=\n";
	$headers = "From: \"" . $from_name . "\" <" . 
	$from_mail . ">\n" . "Content-Type: text/html; charset=$charset; format=flowed\n" . "MIME-Version: 1.0\n" . "Content-Transfer-Encoding: 8bit\n" . "X-Mailer: PHP/" . phpversion () . "\n";
	
	// �������� ����� ��� ����� ������ � ���� ������
	$mail_template = '������ ����!<br><br>

� ����������� ����������� ���������, ���������� ��� ���������.<br><br>

����������� ��� �����������:<br>
http://kstocks.ru/files/Rus_pdf.pdf<br><br>

������:<br>
http://kstocks.ru/files/ocenka-easywork24.pdf<br><br>

�������� �������: www.easywork24.ru<br><br>

�������� ������������� IT-��������, ������� ���������� �������� ������������ � ������-�����. ���� ������ ��� � ���������� ��������.';
					
	mail ($to, $encoded_subject, $mail_template, $headers );
}


	
?>
