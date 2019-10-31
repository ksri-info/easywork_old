<?php
// ��������� ������ �����������
function fetch_tpl($par, $template)
{
	foreach($par as $key => $val) 
	{
		$where[] = $key;
			 
		$what[] = $val;
	}
	return str_replace($where, $what , $template);

}


 
function seconds_to_date_min_rus($seconds, $mode=0)
{
	$mon_c[1]="���";
	$mon_c[2]="���";
	$mon_c[3]="����";
	$mon_c[4]="���";
	$mon_c[5]="���";
	$mon_c[6]="����";
	$mon_c[7]="����";
	$mon_c[8]="���";
	$mon_c[9]="����";
	$mon_c[10]="���";
	$mon_c[11]="����";
	$mon_c[12]="���";
	
	if($mode==1)
	{
		$date_time_tmp = split(' ', $date);
		
		$tmp_date = split('-', $date_time_tmp[0]);
			
		$formate_date = (int)date('d', $seconds).' '.$mon_c[(int)date('m', $seconds)];
	}
	
	return $formate_date;
}

// ����������� ���� � ����� � ������� "25 ��� 2012"
function formate_date_rus($date='', $mode=0, $mon_arr=1)
{
	if(preg_match('/0000/', $date))
	{
		return '';
	}
	
	switch($mon_arr)
	{
		case '1':
			$mon_c[1]="������";
			$mon_c[2]="�������";
			$mon_c[3]="�����";
			$mon_c[4]="������";
			$mon_c[5]="���";
			$mon_c[6]="����";
			$mon_c[7]="����";
			$mon_c[8]="�������";
			$mon_c[9]="��������";
			$mon_c[10]="�������";
			$mon_c[11]="������";
			$mon_c[12]="�������";
		break;
		case '2':
			$mon_c[1]="���";
			$mon_c[2]="���";
			$mon_c[3]="����";
			$mon_c[4]="���";
			$mon_c[5]="���";
			$mon_c[6]="����";
			$mon_c[7]="����";
			$mon_c[8]="���";
			$mon_c[9]="����";
			$mon_c[10]="���";
			$mon_c[11]="����";
			$mon_c[12]="���";
		break;
	}
	
	switch($mode)
	{
		// 0 = 8 ������� 2012 � 18:34
		case '0':
			$date_time_tmp = split(' ', $date);
			$tmp_date = split('-', $date_time_tmp[0]);
			
			$formate_date = (int)$tmp_date[2].' '.$mon_c[(int)$tmp_date[1]].' '.$tmp_date[0].' � '.substr($date_time_tmp[1],0,5);
		break;
		// 1 = 8 ������� 2012
		case '1':
			$date_time_tmp = split(' ', $date);
			$tmp_date = split('-', $date_time_tmp[0]);
			
			$formate_date = (int)$tmp_date[2].' '.$mon_c[(int)$tmp_date[1]].' '.$tmp_date[0];
		break;
		// 2 = 8 �������
		case '2':
			$date_time_tmp = split(' ', $date);
			$tmp_date = split('-', $date_time_tmp[0]);
			
			$formate_date = (int)$tmp_date[2].' '.$mon_c[(int)$tmp_date[1]];
		break;
	}
	
	
	return $formate_date;
}
// �������������� �������

function datetime($date, $formate='%Y-%m-%d %H-%i-%s', $in_mktime=0)
{
	if($in_mktime || is_numeric($date))
	{
		$date = date('Y-m-d H:i:s', $date);
	}
	
	if(preg_match('/0000/', $date))
	{
		return '';
	} 
	
	$mon_rf[1]="������";
	$mon_rf[2]="�������";
	$mon_rf[3]="�����";
	$mon_rf[4]="������";
	$mon_rf[5]="���";
	$mon_rf[6]="����";
	$mon_rf[7]="����";
	$mon_rf[8]="�������";
	$mon_rf[9]="��������";
	$mon_rf[10]="�������";
	$mon_rf[11]="������";
	$mon_rf[12]="�������";

	$mon_rm[1]="���";
	$mon_rm[2]="���";
	$mon_rm[3]="����";
	$mon_rm[4]="���";
	$mon_rm[5]="���";
	$mon_rm[6]="����";
	$mon_rm[7]="����";
	$mon_rm[8]="���";
	$mon_rm[9]="����";
	$mon_rm[10]="���";
	$mon_rm[11]="����";
	$mon_rm[12]="���";
		 
	$weekday_c[0]="�����������";
	$weekday_c[1]="�����������";
	$weekday_c[2]="�������";
	$weekday_c[3]="�����";
	$weekday_c[4]="�������";
	$weekday_c[5]="�������";
	$weekday_c[6]="�������";
		
	$tmp_date = split(' ', $date);
	$date_arr = split('-', $tmp_date[0]);
	$time_arr = split(':', $tmp_date[1]);
	
	// 'Y-m-d-H-i-s'
	 
	// ���
	$PARS['%Y'] = $date_arr[0];
	$PARS['%y'] = substr($date_arr[0],2);
	
	// ����� 
	$PARS['%F'] = $mon_rf[(int)$date_arr[1]];
	$PARS['%M'] = $mon_rm[(int)$date_arr[1]];
	$PARS['%m'] = strlen($date_arr[1]) < 2 ? '0'.$date_arr[1] : $date_arr[1];
	$PARS['%n'] = (int)$date_arr[1]; 
	
 	// ����
	$PARS['%d'] = strlen($date_arr[2]) < 2 ? '0'.$date_arr[2] : $date_arr[2];
	$PARS['%j'] = (int)$date_arr[2];
	$PARS['%l'] = $weekday_c[date('w', $date_mktime)];
	
	// �����
	$PARS['%H'] = $time_arr[0];
	$PARS['%G'] = (int)$time_arr[0];
	$PARS['%i'] = $time_arr[1];
	$PARS['%s'] = $time_arr[2];
	
	return fetch_tpl($PARS, $formate);
}

// ������� � ������������ ���� "2012-12-28"
function formate_to_norm_date($date)
{
	if(!$date)
	{
		return '';
	}
	$date_time_tmp = split('\.', $date);
			
	return $date_time_tmp[2].'-'.$date_time_tmp[1].'-'.$date_time_tmp[0];
}
// �������������� ���� � �������
function formate_date($date, $mode=0)
{
	if(!$date || preg_match('/0000/', $date))
	{
		return '';
	}
	
	switch($mode)
	{
		// � ���� 24.1.2012 � 12:11
		case '0':
			
			$date_time_tmp = split(' ', $date);
			$tmp_date = split('-', $date_time_tmp[0]);
			
			$formate_date = $tmp_date[2].'.'.$tmp_date[1].'.'.$tmp_date[0].' � '.substr($date_time_tmp[1],0,5);
		
		break;
		// � ���� 24.1.2012
		case '1':
			
			$date_time_tmp = split(' ', $date);
			$tmp_date = split('-', $date_time_tmp[0]);
			
			$formate_date = $tmp_date[2].'.'.$tmp_date[1].'.'.$tmp_date[0];
		
		break;
	}
	
	return $formate_date;
}

function value_arr_proc($array)
{
	foreach($array as $k => $v)
	{
		$new[value_proc($k)] = value_proc($v);
	}
	
	return $new;
}
// ��������� ���������� �������� � ��������
function value_proc($value, $iconv=1, $allowable_tags)
{
	if($allowable_tags)
	{
		$value = trim(htmlspecialchars(strip_tags($value, "<h1><h2><h3><h4><h5><h6><strong><em><sup><sub><blockquote><div></pre><p><table><thead><th><tbody><tr><td>")));
	}
    else 
	{
		$value = trim(htmlspecialchars(strip_tags($value)));
	}
	
	if (!get_magic_quotes_gpc()) 
	{
		$value = addslashes($value);
	}
	
	if($iconv)
	{
		$value = iconv('utf-8//IGNORE', 'cp1251//IGNORE', $value);
	}
	 
	return $value;
}


// ����������� ����� �������� � ������������ ����
function convert_to_valid_phone_number($phone)
{
	//$phone = preg_replace('/[^0-9]+/', '', $phone);
	
	//if(strlen($phone)==11 && ($phone[0]==8 || $phone[0]==7))
	//{
		//$phone = substr($phone,1,10);
	//}
	$phone = preg_replace('/[^\+0-9]+/', '', $phone);
	
	return $phone;
}

// �������
function to_mktime($date, $only_date = 0)
{
	if(preg_match('/0000/', $date))
	{
		return '';
	}
	$date_time_tmp = split(' ', $date);
	 
	$tmp_date = split('-', $date_time_tmp[0]);
	
	if($date_time_tmp[1])
	{
		$time_arr = split(':', $date_time_tmp[1]);
	}
	
	if(!$time_arr || $only_date)
	{
		return mktime(0, 0, 0, $tmp_date[1], $tmp_date[2], $tmp_date[0]);
	}
	else
	{
		return mktime($time_arr[0], $time_arr[1], $time_arr[2], $tmp_date[1], $tmp_date[2], $tmp_date[0]);
	}
}


// ��������� �������� �����������
function img_resize($src, $out, $width, $height) {
	
    if (!file_exists($src)) {
		return false;
    }

	// ������ ������ � �����������
    $size = getimagesize($src);

    // ������ �� ������� (mime) ��������, ������ � ����� �������� ����� ����

    $format = strtolower(substr($size['mime'], strpos($size['mime'], '/') + 1));
    $picfunc = 'imagecreatefrom'.$format;

    // ��������� ����������� �������
    $gor = $width  / $size[0];
    $ver = $height / $size[1];

    // ���� �� ������ ������
    if ($height == 0) {
        $ver = $gor;
        $height  = $ver * $size[1];
    }
	// ���� �� ������ ������
	elseif ($width == 0) {
        $gor = $ver;
        $width   = $gor * $size[0];
    }

    // ��������� ������ �����������
    $ratio = min($gor, $ver);
	   if ($gor == $ratio)
        $use_gor = true;
    else
        $use_gor = false;

    $new_width   = $use_gor  ? $width  : floor($size[0] * $ratio);
    $new_height  = !$use_gor ? $height : floor($size[1] * $ratio);
	
    $picsrc  = $picfunc($src);
    // �������� ����������� � ������
    $picout = imagecreatetruecolor($new_width, $new_height);
	// ���������� ������
   // imagefill($picout, 0, 0, 0xFFFFFF);
    // ��������� ������� �� �����
    imagecopyresampled($picout, $picsrc, 0, 0, 0, 0, $new_width, $new_height, $size[0], $size[1]);
	// �������� ����� �����������
    imagejpeg($picout, $out, 100);

    // ������� ������
    imagedestroy($picsrc);
    imagedestroy($picout);
 	return true;
}


// ��������� ������
function generate_rand_string($number)
{

    $arr = array('a','b','c','d','e','f',

                 'g','h','i','j','k','l',

                 'm','n','o','p','r','s',

                 't','u','v','x','y','z',

                 'A','B','C','D','E','F',

                 'G','H','I','J','K','L',

                 'M','N','O','P','R','S',

                 'T','U','V','X','Y','Z',

                 '1','2','3','4','5','6',

                 '7','8','9','0');
	$pass = "";

    for($i = 0; $i < $number; $i++)
	{

      // ��������� ��������� ������ �������
	  $index = rand(0, count($arr) - 1);

      $pass .= $arr[$index];
	}

    return $pass;

}


// ������� ����������� ��� ������
function crop_preview_photo($file_input, $file_output, $crop = 'square',$percent = false) 
{
	list($w_i, $h_i, $type) = getimagesize($file_input);

    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
    	$func = 'imagecreatefrom'.$ext;
    	$img = $func($file_input);
    }
	if ($crop == 'square') {
		$min = $w_i;
		if ($w_i > $h_i) $min = $h_i;
		$w_o = $h_o = $min;
	} else {
		list($x_o, $y_o, $w_o, $h_o) = $crop;

	}
	$img_o = imagecreatetruecolor($w_o, $h_o);
	imagefill($img_o, 0, 0, 0x281430);
	imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
	if ($type == 2) {
		return imagejpeg($img_o,$file_output,100);
	} else {
		$func = 'image'.$ext;
		return $func($img_o,$file_output);
	}
}

// �������� ������
function translit($str)
{
	    $tr = array(
        "�"=>"a","�"=>"b",
        "�"=>"v","�"=>"g","�"=>"d","�"=>"e","�"=>"e","�"=>"zh",
        "�"=>"z","�"=>"i","�"=>"i","�"=>"k","�"=>"l",
        "�"=>"m","�"=>"n","�"=>"o","�"=>"p","�"=>"r",
        "�"=>"s","�"=>"t","�"=>"u","�"=>"f","�"=>"h",
        "�"=>"c","�"=>"ch","�"=>"sh","�"=>"shh","�"=>"",
        "�"=>"y","�"=>"","�"=>"je","�"=>"ju","�"=>"ja", 
		
		"�"=>"a","�"=>"b",
        "�"=>"v","�"=>"g","�"=>"d","�"=>"e","�"=>"e","�"=>"zh",
        "�"=>"z","�"=>"i","�"=>"i","�"=>"k","�"=>"l",
        "�"=>"m","�"=>"n","�"=>"o","�"=>"p","�"=>"r",
        "�"=>"s","�"=>"t","�"=>"u","�"=>"f","�"=>"h",
        "�"=>"c","�"=>"ch","�"=>"sh","�"=>"shh","�"=>"",
        "�"=>"y","�"=>"","�"=>"je","�"=>"ju","�"=>"ja"
    );
    return strtr($str,$tr);
}


// ������������ �����
function light_words($string, $words='', $first_char=0)
{
	
	if($words)
	{
		// ����������� �����
		if($first_char)
		{
			$string = preg_replace("/^($words)/i", '<span class="word_selected">$1</span>', $string);
		}
		else
		{
			$string = preg_replace("/($words)/i", '<span class="word_selected">$1</span>', $string);
		}
	}


	return $string;
}

// �������� ���� � �����
function date_passing($date, $only_in_days=0)
{
	$date_time_tmp = split(' ', $date);
	
	$tmp_date = split('-', $date_time_tmp[0]);
	
	$time_arr = split(':', $date_time_tmp[1]);
		
	// ���������� ����� � �������	
	$date_mktime =  mktime($time_arr[0], $time_arr[1], $time_arr[2], $tmp_date[1], $tmp_date[2], $tmp_date[0]);
	 
	// ���������� ����� � �������
	$actual_mktime = time();
	
	$string = $actual_mktime -  $date_mktime;
	 
	//echo date('Y-m-d-H-i-s', $string);
	
	$date_string_arr = sec_to_date_words($string, $only_in_days);
	
	$date_string = $date_string_arr['string'];

	return $date_string;

}

// ��������� ������� � ���-�� ����, �����, �����
function sec_to_date_words($seconds, $only_in_days = 0, $with_seconds=0, $return_str_result=0)
{
	if($only_in_days)
	{
		$day=round($seconds/86400);
		
		$hours=round(($seconds/3600)-$day*24); 
		
		$min=round(($seconds-$hours*3600-$day*86400)/60); 
		
		$sec=$seconds-($min*60+$hours*3600+$day*86400); 
	}
	else
	{
		$day=floor($seconds/86400);
		
		$hours=floor(($seconds/3600)-$day*24); 
		
		$min=floor(($seconds-$hours*3600-$day*86400)/60); 
		
		$sec=$seconds-($min*60+$hours*3600+$day*86400); 
	}
	
	if(!$with_seconds)
	{
		$min = $min ? $min : 1;
	}
 	 
	// ������ >= 1 ���
	$is_days = 0; 
	 
	$days_string =  $day.' '.numToword($day, array('����', '���', '����'));
	$hours_string =  $hours.' '.numToword($hours, array('���', '����', '�����'));
	$min_string =  $min.' '.numToword($min, array('������', '������', '�����'));
	$sec_string =  $sec.' '.numToword($sec, array('�������', '�������', '������'));
	
	
	// ���������� ���, ����, ������
	if(!$only_in_days)
	{
		if($day)
		{
			$date_string .= $days_string;
			$is_days = 1; 
		}
		if($hours)
		{
			$date_string .= ' '.$hours_string;
		}
		if($min)
		{
			$date_string .= ' '.$min_string;
		}
		if($with_seconds)
		{
			$date_string .= ' '.$sec_string;
		}
	}
	// ���������� ������ ���
	else
	{
		if($day)
		{
			$date_string .= $day.' '.numToword($day, array('����', '���', '����'));
			$is_days = 1; 
		}
		else
		{
			$date_string .= '������ ���';
		}
	} 
	
	if($return_str_result)
	{
		// ��������� ������ ������ ���������� ������ �� ����
		if($day)
		{
			return  $days_string;
		}
		else if($hours)
		{
			return $hours_string;
		}
		else if($min)
		{
			return $min_string;
		}
	}
	
	return array('string' => $date_string, 'is_days' => $is_days, 'days_string' => $days_string, 'hours_string' => $hours_string, 'min_string' => $min_string, 'sec_string' => $sec_string, 'day' => $day, 'hours' => $hours, 'min' => $min, 'sec' => $sec);
}
// � ���������� ���� ���������� ��� � ���������� ����
function days_to_date_after_date($days, $date)
{
	
	$days_in_seconds = $days * 3600 * 24;
 
	$date_in_seconds = $days_in_seconds + to_mktime($date);
	
	return date('Y-m-d', $date_in_seconds);
	
}

// ������� �����
function numToword($num, $words)
{
	$num = $num % 100;
	if ($num > 19) 
	{
		$num = $num % 10;
	}
	switch ($num) {
		case 1: {
			return($words[0]);
		}
		case 2: case 3: case 4: {
			return($words[1]);
		}
		default: {
			return($words[2]);
		}
	}
}

// ������� ip ������ � �����
function ip_to_number($IPaddr)
{
	if ($IPaddr == "")
	{
	        return 0;
	} 
	else 
	{
		$ips = split ("\.", "$IPaddr");
		return ($ips[3] + $ips[2] * 256 + $ips[1] * 256 * 256 + $ips[0] * 256 * 256 * 256);
	}
}

// ������������ ������ �� �������
function password_hash_proc($string)
{
	return md5(md5($string).md5(KEY_WORD));
}

// ������������ ������ �����
function series_data($date, $value, $other_value, $with_time=0)
{
	$tmp_date = split(' ', $date);
	$year = substr($tmp_date[0],0,4);
	$month = (int)substr($tmp_date[0],5,2)-1;
	$day = (int)substr($tmp_date[0],8,2);
	
	if($with_time)
	{
		$tmp_time = split(':', $tmp_date[1]);
		$hour = (int)$tmp_time[0];
		$minutes = (int)$tmp_time[1];
		$seconds = (int)$tmp_time[2];
	}
	else
	{
		$hour = 0;
		$minutes = 0;
		$seconds = 0;
	}
	 
			
	$data = '[Date.UTC('.$year.','.$month.','.$day.', '.$hour.','.$minutes.','.$seconds.'), '.$value.', "'.$other_value.'"]'; ;
	
	return $data;		
}
function get_date_utc_for_js_object($date)
{
	$year = substr($date,0,4);
	$month = (int)substr($date,5,2)-1;
	$day = (int)substr($date,8,2);
			
	return 'Date.UTC('.$year.','.$month.','.$day.')';
}

// ����������� ����� � ��������� ���� ���� 1 000 00
function sum_process($string, $sep=' ', $split='\.', $with_kopek)
{
	return number_format($string, 2, '.', ' ');
}

// ������� ���� � ����� � ���� 2012-11-11 14:11
function join_date_and_time($date, $time)
{	
	$time = $time=='' ? '00:00' : $time;
	
	if($date=='')
	{
		return '';
	}
	
	$time_tmp = split(':', $time);

	if(count($time_tmp)!=2)
	{
		return '';
	}
	
	if(!is_numeric($time_tmp[0]) || !is_numeric($time_tmp[1]))
	{
		return '';
	}
	
	if($time_tmp[0] < 0 || $time_tmp[0] > 23 || $time_tmp[1] < 0 || $time_tmp[1] > 59)
	{
		return '';
	}
	
	return $date.' '.$time;
}

// ���������� ����� ����
function get_part_from_date($date, $need)
{
	$tmp_date = split(' ', $date);
	$date_arr = split('-', $tmp_date[0]);
	$time_arr = split(':', $tmp_date[1]);
	
	switch($need)
	{
		case 'y':
			return $date_arr[0];
		break;
		case 'm':
			return $date_arr[1];
		break;
		case 'd':
			return $date_arr[2];
		break;
		case 'h':
			return $time_arr[0];
		break;
		case 'min':
			return $time_arr[1];
		break;
		case 's':
			return $time_arr[2];
		break;
	}
}

// ��������� ������ �-���������� ������� ���� �� �������� ���
function fill_array_num_days_ago_from_actual_date($num, $date_to)
{
	// ��������� ������ 31 ��� �� ��������
	$start_day = time() - 3600 * 24 * $num;
	while(!$stop)
	{
		$date_s = date('Y-m-d', $start_day);
		$days_arr[$date_s] = '0';
		if($date_s==$date_to)
		{
			$stop=1;
		}
		$start_day += 24 * 3600;
		
		if($i>400)
		{
			$stop=1;
		}
		$i++;
	}
	
	return $days_arr;
}


// ��������� ������ �-���������� �������  ������� �� �������� ������ 
function fill_array_num_month_ago_from_actual_date($num, $date_to)
{
	
	$year = substr($date_to,0,4);
	$month = (int)substr($date_to,5,2);
	
	for($i=0; $i<=$num; $i++)
	{
		$month_str = strlen($month)==1 ? '0'.$month : $month;
		$days_arr[$year.'-'.$month_str] = '0';
		
		$month -= 1;
		
		if($month==0)
		{
			$month = 12;
			$year -= 1;
		}
		
	}
	$days_arr = array_reverse($days_arr);
	return $days_arr;
}

// ���������� �������� ������ �� ����
function get_dayweek_name_by_date($date)
{
	$date_mktime = to_mktime($date);
	
	$weekday_c[0]="�����������";
	$weekday_c[1]="�����������";
	$weekday_c[2]="�������";
	$weekday_c[3]="�����";
	$weekday_c[4]="�������";
	$weekday_c[5]="�������";
	$weekday_c[6]="�������";
	
	return $weekday_c[date('w', $date_mktime)];
}

function formate_filesize($bytes)
{
	if ($bytes > 0)
    {
        $unit = intval(log($bytes, 1024));
		 
        $units = array('�', '��', '��', '��');
		
		  if (array_key_exists($unit, $units) === true)
        {
			if($unit>=2)
			{
				$res =  sprintf('%01.1f %s', $bytes / pow(1024, $unit), $units[$unit]);
			}
			else
			{
           		$res =   sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
			}
        }
    }
	
	$res = str_replace(',', '.', $res);

    return $res;
}

// �������� �� ������������ ����
function date_rus_validate($date)
{
	if(!preg_match('/^[0-9]{1,2}\.[0-9]{1,2}\.[0-9]{4}/', $date))
	{
		return false;
	}
	else
	{
		return true;
	}
}
function stdToArray($obj){
  $rc = (array)$obj;
  foreach($rc as $key => &$field){
    if(is_object($field))$field = stdToArray($field);
  }
  return $rc;
}

function to_iconv_array($arr)
{
	foreach($arr as $key => $val)
	{
		$new_arr[$key] = iconv('windows-1251','UTF-8', $val);
	}
	
	return $new_arr;
}

function to_iconv($val, $to_win)
{
	if($to_win)
	{
		return iconv('UTF-8', 'windows-1251', $val);
	}
	else
	{
		return iconv('windows-1251','UTF-8', $val);
	}
	 
}

function get_selected_easycomplete($value, $name)
{
	$option_fcbk_tpl = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/templates/tags/option_fcbk.tpl');
	
	// �������� ������� ��� ���� ����
	$PARS['{CLASS}'] = 'selected';
	$PARS['{VALUE}'] = '-s-'.$value;
	$PARS['{NAME}'] = $name;
	return  fetch_tpl($PARS, $option_fcbk_tpl);
}
function proc_splited_date($year, $month, $day)
{
	if(!$year>0 || !$month> 0 || !$day>0)
	{
		return '';
	}
	else
	{
		return $year.'-'.$month.'-'.$day;
	}	
}

function create_token($timestamp)
{
	return md5('_-`13WERwgfg43#$%4532423412423tfc:#$%232' . $timestamp);
}

// �������� ���������� ����� �� ��������
function is_file_ext_in_blacklist($file_name)
{
	$blacklist = array(".php", ".phtml", ".php3", ".php4", ".exe", ".bat");
	
	// ���������� �����
	$extension = substr($file_name,strrpos($file_name, '.'),20);
	
	 
	if(in_array( $extension, $blacklist))
	{
		return 1;
	}
	else return 0;
}

function create_upload_folder($date, $static=0)
{
	if($date)
	{
		$mktime = to_mktime($date);
	}
	else
	{
		$mktime = time();
	}
	
	if($static)
	{
		$upload_path = UPLOAD_PATH.'/static';
	}
	else
	{
		$upload_path = UPLOAD_PATH.'/d';
	}
	 
	
	$year = date('Y', $mktime);
	
	$month = date('m', $mktime);
	
	$day = date('d', $mktime);
	
	$y_dir = $upload_path.'/'.$year;
	$m_dir = $upload_path.'/'.$year.'/'.$month;
	$d_dir = $upload_path.'/'.$year.'/'.$month.'/'.$day;
	
  
	if(!is_dir($y_dir))
	{
		mkdir($y_dir);
		chmod($y_dir, 0775);
	}
	
	if(!is_dir($m_dir))
	{
		mkdir($m_dir);
		chmod($m_dir, 0775);
	}
	
	/*if(!is_dir($d_dir))
	{
		mkdir($d_dir);
		chmod($d_dir, 0775);
	}*/
	
	return $m_dir;
}

// ���������� ���������� ���� ���� �� �����
function get_download_dir($upload_path, $file_date, $static=0)
{
	if($static)
	{
		$upload_path = UPLOAD_PATH.'/static';
	}
	else
	{
		$upload_path = UPLOAD_PATH.'/d';
	}
	
	$date_mktime = to_mktime($file_date);
	
	$year = date('Y', $date_mktime);
	
	$month = date('m', $date_mktime);
	
	$day = date('d', $date_mktime);
	
	return $upload_path.'/'.$year.'/'.$month;
}

function get_file_dir_url($file_date, $image_name)
{
	
	//return '/dl/'.$image_name.'?t='.$type.'&i='.$id;
	
	$date_mktime = to_mktime($file_date);
	
	$year = date('Y', $date_mktime);
	
	$month = date('m', $date_mktime);
	
	$day = date('d', $date_mktime);
	
	return '/'.UPLOAD_FOLDER.'/static/'.$year.'/'.$month.'/'.$image_name;
}

function get_rand_file_system_name($file_name)
{
	$file_parts = pathinfo($file_name);
		
	$extension = $file_parts['extension'];
	 
	return date('ymdHis').'_'.rand(1000000000,9999999999).'.'.$extension;
}


// ���������� �����
function file_download_start($filename, $file_name_for_out='') {
	
	 
   if (file_exists($filename)) 
   {
	
 		header('Accept-Ranges:	bytes');
		header('Connection:	Keep-Alive');
		header('Content-Length: ' . filesize($filename));
		//header('Content-Type:	image/jpeg');
		header('Content-Type: application/octet-stream');
		header('Connection:	Keep-Alive');
		
		header('Content-Disposition:	attachment; filename="'.$file_name_for_out.'"');
		
		readfile($filename);
	
    	exit;
	
   }
}

function is_date_exists($date)
{
	// ���� ������� ���� �������� �����
	if(!preg_match('/0000/', $date))
	{
		return true;
	}
	else return false;
}
function str_to_a($text)
{
	// http://ruseller.com/lessons.php?rub=37&id=662
	$text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" target=\"_blank\" class=\"link\">$3</a>", $text);
 
    $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" target=\"_blank\" class=\"link\">$3</a>", $text);
	
	return($text);
}
// �������� �����
function email_valid($email)
{
	if(!preg_match('/^[^@\s]+@([-a-z0-9]+\.)+[a-z]{2,}$/i', $email))
	{
		return false;
	}
	else
	{
		return true;
	}
}
?>