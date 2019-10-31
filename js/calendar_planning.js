
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

// ��������� � ������ �������
function parseDate(input, format) {
  format = format || 'yyyy-mm-dd'; // default format
  var parts = input.match(/(\d+)/g),
      i = 0, fmt = {};
  // extract date-part indexes from the format
  format.replace(/(yyyy|dd|mm)/g, function(part) { fmt[part] = i++; });

  return new Date(parts[fmt['yyyy']], parts[fmt['mm']]-1, parts[fmt['dd']]);
}
// in - ��������������� ����
// ��� ������ ������� ���� �������� �����������
global_checked_date = 0;
global_checked_month = 0
global_checked_year = 0
function render_event_calendar(dateStr)
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

	dayWeek = {};
	dayWeek[0] = '��';
	dayWeek[1] = '��';
	dayWeek[2] = '��';
	dayWeek[3] = '��';
	dayWeek[4] = '��';
	dayWeek[5] = '��';
	dayWeek[6] = '��';


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



	// ��������� �������� ����
	todayDate=new Date(parseDate(dateStr));
	thisday=todayDate.getDay()+1;
	thismonth=todayDate.getMonth();
	thisdate=todayDate.getDate();
	thisyear=todayDate.getYear();


	/// ���������� ����
	nowDate=new Date();
	now_day=nowDate.getDay();
	now_month=nowDate.getMonth();
	now_date=nowDate.getDate();
	now_year=nowDate.getFullYear();

	thisyear = thisyear % 100;

	var cal;
	// �������������� ����
	thisyear = ((thisyear < 50) ? (2000 + thisyear) : (1900 + thisyear));

	// �������� �� ���������� ���
	if (((thisyear % 4 == 0) && !(thisyear % 100 == 0)) ||(thisyear % 400 == 0))
	{
		monthdays[1]++;
	}
	
	// ���� ������ ������� ����� ������
	//startDayWeek = thisday - startspaces;

	// ����������� ���� ������ ������� ����� ������
	tmpdateStr = dateStr.split('-');
	tmpdateStr = tmpdateStr[0]+'-'+tmpdateStr[1]+'-01';
	tmpDate = new Date(parseDate(tmpdateStr));
	tmpWeekDay = tmpDate.getDay();
	startDayWeek = tmpWeekDay;


	// ���������� �������� ������ � ���
	jQuery('#change_calendar_month').html(monthnames[thismonth]);
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
				day_actual_back = '';
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
			date_day_week = dayWeek[startDayWeek];

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
			
			// alert(check_event_date)
			//if(jQuery.inArray(check_event_date, datesArr)>=0)
			if(datesArr && datesArr[check_event_date])
			{
				is_event_day_class = '';
				switch(datesArr[check_event_date])
				{
					
					case '1':
						is_event_day_class = 'calendar_cal_planning_orange';
					break;
						
					case '2':
						is_event_day_class = 'calendar_cal_planning_pink';
					break;
					
					case '3':
						is_event_day_class = 'calendar_cal_planning_red';
					break;
					
					case '0':
						is_event_day_class = 'calendar_cal_planning_green';
					break;
				}
				 
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
		
		
		 
			setTimeout(function(){
				 jQuery('#calendar-container').html(date_col_weekdays+date_col);
				 jQuery('#calendar-container').animate({
				 "opacity": 1
				}, 100);
			
	
	
	},50)

}
