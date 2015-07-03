<?php
$tahun = date('Y');

for($a=1 ; $a<=12; $a++){
	$total = $this->app_model->GrafikJual($a,$tahun);
	$data[$a]= $total;
}


$tampil_data = '';

for ($i=1; $i<=12; $i++) {

	$tampil_data .= $data[$i];
	if($i < 12) $tampil_data .= ',';
}

?>

<script type="text/javascript">
$(function () {
    var chart;
    $(document).ready(function() {
        chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'line',
				spacingTop: 0,				
				spacingBottom: 0
            },
            title: {
                text: '<?php echo $judul;?> Bulanan',
				style: {
                        color: '#154C67',
                        fontSize: '14px',
                        fontFamily: 'Verdana, sans-serif'							
                    }
            },
            subtitle: {
                text: '<?php echo $nama_program;?>'
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
				labels: {
                    align: 'center',
                    style: {
                        fontSize: '8px',
                        fontFamily: 'Verdana, sans-serif'
                    }
                }
            },
            yAxis: {
                title: {
                    text: 'Total Pembelian',
                    style: {
                        color: '#154C67',
                        fontSize: '12px',
                        fontFamily: 'Verdana, sans-serif'						
                    }
                },
				lineColor:'#999',
				lineWidth:1,
				tickColor:'#666',
				tickWidth:1,
				tickLength:3,
				gridLineColor:'#ddd',				
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.x +': '+ this.y;
                }
				/*
				headerFormat: '<b>{series.name}</b><br />',
                pointFormat: 'x = {point.x}, y = {point.y}'
				*/
            },
			legend: {
				enabled: true,
                layout: 'horizontal',
                align: 'center',
                verticalAlign: 'bottom',
                borderWidth: 0				
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true
                    },
                    enableMouseTracking: true
                }
            },
            series: [{
                name: 'Tahun <?php echo $tahun;?>',
                data: [<?php echo $tampil_data;?>],
				color: '#AA4643'
            }]
        });
    });
    
});
</script>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
	