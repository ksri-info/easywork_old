<div class="charts_container">
	<div id="container_work_time"></div>
</div>

<script>
$(function () {
    var chart;
	 
	series_by_auth_computers = {SERIES_BY_AUTH_COMPUTERS};
	series_by_all_computers = {SERIES_BY_ALL_COMPUTERS};
	
	$(document).ready(function() {
		
		$('#container_work_time').highcharts({
            chart: {
                type: 'column',
				width : 910,
				borderColor: '#e7e5e5',
				borderWidth:5,
				marginRight:50 
            },
            title: {
                text: '����� ������ �� ��������� 30 ����'
            },
            subtitle: {
                text: ''
            },
            xAxis: {
                type: 'datetime',
				name: '����',
				dateTimeLabelFormats: {
                    day: '%e. %b',
                },
				 
            },
			yAxis: {
                min: 0,
                title: {
                    text: '�����'
                },
				type: 'datetime',
				showFirstLabel:false,
				 minTickInterval : 1,
                maxZoom: 0,
            },
           
			tooltip: {
				
				 
				formatter: function() {
					
					tmp_d = new Date(this.x);
					
					s = Highcharts.dateFormat('%B, %e, %A', this.x, 1);
					
					$.each(this.points, function(i, point) {
					
						s += '<tr>'+
						'<td style="color:'+point.series.color+';padding:0">'+point.series.name+': </td>' +
                    	'<td style="padding:0"><b> '+timeFormat(point.point.y, 1)+' �.</b></td>' +
						'</tr>';
					})
					return '<table>' + s + '</table>';
                }
				,
				useHTML: true,
				shared: true, 
				 
            },
			
            series: [{
                name: '�������������� ����������',
				color: '#00CC66',
                data: series_by_auth_computers
    
            }, {
                name: '��� ����������',
				data: series_by_all_computers
    
            }]
        });
		
    });
    
});	 
</script>
