
// ����� ����
function change_year(mode)
{ 
	actual_date = calendareStartDate.split('-');

	actual_year = Number(actual_date[0])

	actual_month = actual_date[1]

	actual_day = actual_date[2]

	if(mode=='prev')
	{
		new_year = actual_year - 1;

	}
	if(mode=='next')
	{
		new_year = actual_year + 1;
	}

	actual_day = '01';

	calendareStartDate = new_year+'-'+actual_month+'-'+actual_day

	render_event_calendar(calendareStartDate);

}

// ����� ������
function change_month(mode)
{
	actual_date = calendareStartDate.split('-');

	actual_year = Number(actual_date[0])

	actual_month = Number(actual_date[1])

	actual_day = actual_date[2]

	if(mode=='prev')
	{
		new_month = actual_month - 1;

		if(new_month==0)
		{
			new_month=12;

			actual_year--;
		}
	}
	if(mode=='next')
	{
		new_month = actual_month + 1;

		if(new_month==13)
		{
			new_month=1;

			actual_year++;
		}
	}
	actual_day = '01';

	new_month = ''+new_month;

	new_month = new_month.length > 1 ? new_month : '0'+new_month

	calendareStartDate = actual_year+'-'+new_month+'-'+actual_day

	render_event_calendar(calendareStartDate);

}

// in - ��������������� ����
// ��� ������ ������� ���� �������� �����������
global_checked_date = 0;
global_checked_month = 0
global_checked_year = 0
function render_event_calendar(dateStr)
{
	// ��������� �������� ����
	todayDate=new Date(parseDate(dateStr));
	thisday=todayDate.getDay()+1;
	thismonth=todayDate.getMonth();
	thisdate=todayDate.getDate();
	thisyear=todayDate.getFullYear();


	/// ���������� ����
	nowDate=new Date();
	now_day=nowDate.getDay();
	now_month=nowDate.getMonth();
	now_date=nowDate.getDate();
	now_year=nowDate.getFullYear();
	
	
	monthdays = get_month_days_count('array', thisyear);
	
	var cal;
	

	/*startspaces=thisdate;

	while (startspaces > 7)
	{
		startspaces-=7;
	}*/


	// ���� ������ ������� ����� ������
	//startDayWeek = thisday - startspaces;

	// ����������� ���� ������ ������� ����� ������
	tmpdateStr = dateStr.split('-');
	tmpdateStr = tmpdateStr[0]+'-'+tmpdateStr[1]+'-01';
	tmpDate = new Date(parseDate(tmpdateStr));
	tmpWeekDay = tmpDate.getDay();
	startDayWeek = tmpWeekDay;


	// ���������� �������� ������ � ���
	jQuery('#change_calendar_month').html(get_month_rus_name_by_month(thismonth));
	jQuery('#change_calendar_year').html(thisyear);


	count=1; // ������ ����� ������
	date_col = '';
	date_col_weekdays = '';
	 

 	// ���������� ��������� ���� ���
 	if(global_checked_date==0)
	{
		global_checked_date = thisdate
		global_checked_month = thismonth
		global_checked_year = thisyear
	}
	 
	while (count <= monthdays[thismonth])
	{
		if (count <= monthdays[thismonth])
		{
			// ��������� ����������� ����
			if (count==now_date && now_year==thisyear && now_month == thismonth)
			{
				day_now_light = "<div class='calendar_day_now_light'><div class='panel'></div>�������</div>";
				
			}
			else
			{
				day_now_light = "";
				
			}
			if(count==1)
			{
			// alert(thismonth)
			// alert(now_month)
			}
			// ��������� ��������� ����  
			if(global_checked_date==count && global_checked_month == thismonth && global_checked_year==thisyear)
			{
				day_actual_back = 'calendar_actual_day_back';
			}
			else
			{
				day_actual_back = '';
			}
			// ��������� �������� ����
			if(startDayWeek==6 || startDayWeek==0)
			{
				class_weekend = '';
				date_dayweek_class = 'calendar_dayweek_weekend';
			}
			else
			{
				class_weekend = '';
				date_dayweek_class = 'calendar_dayweek_budn'
			}

			// ���� ������
			date_day_week = get_dayweek_by_day(startDayWeek);

			// ����������� ���� � �������� ������
			tmp_day = ''+count;
			tmp_day = tmp_day.length > 1 ? tmp_day : '0'+tmp_day;

			// ����������� ����� � �������� ������
			tmp_month = thismonth+1;
			tmp_month = ''+tmp_month;
			tmp_month = tmp_month.length > 1 ? tmp_month : '0'+tmp_month;

			// ���������� ���� ��� ���������� �� � ������� �����������
			check_event_date = thisyear+'-'+tmp_month+'-'+tmp_day

			//alert(datesArr);
			//return;

			// ���������, ���� �� ������� �� ��� ����
			// datesArr - ���������� ������ ��� �������. ������� - bottom_js
			
			  
			if(datesArr && datesArr[check_event_date])
			{
				is_event_day_class = 'calendar_day_is_event';
				event_date = check_event_date;
				day_over_class = 'calendar_day_over';
				 
			}
			else
			{
				is_event_day_class = '';
				event_date = '';
				day_over_class = '';
			}

			// ����������� ����� �������� ����
			if(count < monthdays[thismonth])
			{
				td_sep = '<td width="1"></td>';
			}
			else
			{
				td_sep = '';
			}

			// �����
			date_col +="<td rel='"+event_date+"' class='calendar_col_day "+class_weekend+" "+is_event_day_class+" "+day_over_class+" "+day_actual_back+" ' >"+count+"<div style='position:relative'>"+day_now_light+"</div></td>"+td_sep;
			// ��� ������
			date_col_weekdays += "<td class='"+date_dayweek_class+"'>"+date_day_week +"</td>"+td_sep;


			// ������� �� ��������� ���� ������
			if(startDayWeek<6)
			{
				startDayWeek++;
			}
			else
			{
				startDayWeek = 0;
			}
		}

		// ������� �� ����. ����
		count++;

	}
	date_col_weekdays = "<tr>"+date_col_weekdays+"</tr>";
	date_col = "<tr>"+date_col+"</tr>";
 
	 
	  jQuery('#calendar-container').animate({
			 "opacity": 0
			}, 50);
		
		
			// ������� ��������� �����
			setTimeout(function(){
				 jQuery('#calendar-container').html(date_col_weekdays+date_col);
				 jQuery('#calendar-container').animate({
				 "opacity": 1
				}, 100);
			
			
			
	// ������ ���������
	//jQuery('#calendar-container').html(date_col_weekdays+date_col);
 
	// ������ ���������� ������� ��� ���� ������� �������
	jQuery('.calendar_day_is_event').each(function() {
 
		jQuery(this).bind('click',function()
		{
			 
			if(page_=='worker_task')
			{   
				document.location = '/tasks?id='+to_user_id+'&date='+jQuery(this).attr('rel');
			}
			if(page_=='my_tasks')
			{
				document.location = '/tasks?date='+jQuery(this).attr('rel');
			}
			
			
		})

	})
	
	},50)

}

function get_month_days_count(return_what, thisyear, month)
{
	// ���-�� ���� � �������
	monthdays = new Array(12);
	monthdays[0]=31;
	monthdays[1]=28;
	monthdays[2]=31;
	monthdays[3]=30;
	monthdays[4]=31;
	monthdays[5]=30;
	monthdays[6]=31;
	monthdays[7]=31;
	monthdays[8]=30;
	monthdays[9]=31;
	monthdays[10]=30;
	monthdays[11]=31;
	
	// �������� �� ���������� ���
	if (((thisyear % 4 == 0) && !(thisyear % 100 == 0)) ||(thisyear % 400 == 0))
	{
		monthdays[1]++;
	}
	
	if(return_what=='array')
	{
		return monthdays;
	}
	else if(return_what=='count_month_days')
	{
		return monthdays[month];
	}
}

function get_dayweek_by_day(day)
{
	dayWeek = {};
	dayWeek[0] = '��';
	dayWeek[1] = '��';
	dayWeek[2] = '��';
	dayWeek[3] = '��';
	dayWeek[4] = '��';
	dayWeek[5] = '��';
	dayWeek[6] = '��';
	
	return dayWeek[day]
}

function get_month_rus_name_by_month(month, upper)
{
	monthnames = new Array(
	"������",
	"�������",
	"����",
	"������",
	"���",
	"����",
	"����",
	"������",
	"��������",
	"�������",
	"������",
	"�������");
	
	monthnames_upper = new Array(
	"������",
	"�������",
	"����",
	"������",
	"���",
	"����",
	"����",
	"������",
	"��������",
	"�������",
	"������",
	"�������");
	
	if(upper)
	{
		return monthnames_upper[month];
	}
	else
	return monthnames[month];
}