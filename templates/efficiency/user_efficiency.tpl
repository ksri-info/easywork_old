<script>
$(function () {
    var chart;
    $(document).ready(function() {
		categories = {CATEGORIES};
		data = {SERIES};
		user_name = '{SURNAME} {NAME} {MIDDLENAME}';
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'area',
				borderColor: '#e7e5e5',
				borderWidth:5,
				marginRight:35,
				width : 725 
			},
            title: {
                text: '������ �������������'
                
            },
            subtitle: {
                text: user_name
                
            },
            xAxis: {
				showFirstLabel:true,
				startOnTick:true,
				endOnTick:true,
				dateTimeLabelFormats: {
                    day: '%e. %b'
                },
				type : 'datetime',
				 
					title: {
						text: '���'
					}
            },
			tooltip: {
				xDateFormat: '%B, %e, %A'
            }, 
			series: [{
			name : '�������������',
				 data: data
            }],
           
            yAxis: {
                title: {
                    text: '���'
                },
				max : 100 
            }
        });
    });
    
});	 
</script>
<div class="charts_container">
<div id="container"></div>
</div>
