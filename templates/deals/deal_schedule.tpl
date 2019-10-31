<div style="height:400px; width:800px; margin-top:20px; overflow-x:visible;padding-bottom:30px">
	<div id="container" style="width: 1200px; height: 400px"></div>
</div>

<script>
$(function () {
    var chart;
	 
	data = {SERIES};
	// ����������������� ������ ���� � ������
	// ����� ����� ���� �������� � Tooltip
	structured_arr = {}
	$.each(data, function(i, j){
		structured_arr[j[0]] = j[2]
	})
	
	$(document).ready(function() {
		
		chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line',
				width: 820,
				borderColor: '#e7e5e5',
				borderWidth:5,
				marginRight:50
            },
			title: {
				text: '������ �������� ������'
			},
            xAxis: {
                type: 'datetime',
                dateTimeLabelFormats: {
                    day: '%e. %b'
                },
				maxZoom: 48 * 3600 * 3000,
				name: '����'
            },
            yAxis: {
                title: {
                    text: '������ ������'
                },
                min: 0,
				max : 100
            },
			tooltip: {
				
				useHTML : true,
				formatter: function() {
					
					var y, d, m, comment;
					
					comment = structured_arr[this.point.x];
				 
					return comment;
                }
            },

           
			series: [{
                name: '������',
                data: data
            }]
	
          
           
        });
    });
    
});	 
</script>