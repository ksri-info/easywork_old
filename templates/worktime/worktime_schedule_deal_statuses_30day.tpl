
<div class="charts_container">
	<div id="container_chart_30days"></div>
</div>

<script>
$(function () {
    var chart;
	 
	data_1 = {SERIES};
	date_start_1 = {SERIES_DATE_START};
	 
	 
	
	$(document).ready(function() {
		
		chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container_chart_30days',
                type: 'column',
				width: 910,
				borderColor: '#e7e5e5',
				borderWidth:5,
				marginRight:50
            },
			title: {
				text: '������ �������� ������ �� ��������� 30 ����'
			},
             
			xAxis: {
                type: 'datetime',
                name: '�����',
				dateTimeLabelFormats: {
                    day: '%e. %b'
                }
				 
				 
            },
            yAxis: {
                title: {
                    text: '���-�� ���������� ������'
                },
                min: 0 
            },
			tooltip: {
				
				useHTML : true,
				formatter: function() {
					
					var f_date;
					dateObj = new Date(this.point.x);
				 	f_date = Highcharts.dateFormat('%B, %e, %A', this.x, 1);
					return f_date+'<br>���-�� ����������� �������� ������: <b>'+this.point.y+'</b>';
                }
            }, 
 
			 
			series: [{
                name: '���������� ��������',
               /* data: data,*/
				data : data_1 
				
            }]
	
          
           
        });
    });
    
});	 
</script>
