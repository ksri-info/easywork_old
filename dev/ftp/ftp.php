<?

// easy
// Ash2ieGh9zethiebee9A

$ftp_server = 'easy.easywork.pro';
$ftp_user_name = 'easy';
$ftp_user_pass = 'Ash2ieGh9zethiebee9A';



// ��������� ����������
$conn_id = ftp_connect($ftp_server); 

// ���� � ������ ������������ � �������
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass); 

// �������� ����������
if ((!$conn_id) || (!$login_result)) { 
        echo "�� ������� ���������� ���������� � FTP ��������!";
        echo "������� ����������� � ������� $ftp_server ��� ������ $ftp_user_name!";
        exit; 
    } else {
        echo "����������� ���������� � FTP �������� $ftp_server ��� ������ $ftp_user_name";
    }

 // /var/virtual/easy.easywork.pro/www
 //  var/virtual/easy.easywork.pro/www/index.php 

$destination_file = '/upload/t.txt';
$source_file = $_SERVER['DOCUMENT_ROOT'].'/log.txt';
// ����������� �����
$upload = ftp_put($conn_id, $destination_file, $source_file, FTP_BINARY); 

// �������� ����������
if (!$upload) { 
        echo "�� ������� �������� ����!";
    } else {
        echo "���� $source_file ������� �� $ftp_server ��� ������ $destination_file";
    }



?>