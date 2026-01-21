<style type="text/css">
	.canvasjs-chart-credit {
		display: none;
	}
	.watermark {
		position: relative;
		top: 18px;
		background-color: #000000;
		color: #000000;
		z-index: 1;
	}
</style>
        @php
        $site_url = url('/').'/public';
        @endphp
<script src="{{$site_url}}/js/canvasjs.min.js"></script>
<span class="watermark">00000000000000</span>
<div id="chartContainer" style="height: 100px; width: 950px;"></div>
<input type="hidden" name="ecg-value-list">
<script type="text/javascript">
    var xAxisStripLinesArray = [];
    var yAxisStripLinesArray = [];
    var dps = [];
    var data_index = 0;
    var color = "#EB0102";
    var chart = new CanvasJS.Chart("chartContainer", {
            // theme: "light2",
            axisY: {
                gridThickness: 0,
                tickLength: 0,
                lineThickness: 0,
                maximum: 1000,
                labelFormatter: function() {
                    return " ";
                }
            },
            axisX: {
                gridThickness: 0,
                tickLength: 0,
                lineThickness: 0,
                labelFormatter: function() {
                    return " ";
                }
            },
            data: [
            {
                type: "spline",
                color: "#00FF00",
                dataPoints: dps
            }],
            animationEnabled: true,
            backgroundColor: "#000000"
        });
    var request_in_process = false;
    var loop = 1;

    function updateChart() {
        if (!request_in_process) {
            request_in_process = true;
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                data: {
                    mrn: '584138',
                    count: 10
                },
                url: "{{ action('InterfaceData\InterfaceDataController@ecgdata') }}",
                success: function(response) {
                    var results = response.results;
                    dps_value = results;
                    request_in_process = false;
                }
            });
        }
    };
    var empty_data_set = [];
    var dps_value = [];
    var data_set = '';

    function updateData() {
        if (loop == 1) {
            data_set = dps_value;
        }
        if (typeof data_set !== 'undefined' && data_set.length > 0) {
            for (var z = 0; z < 10; z++) {
                    // Draw line
                    var value = parseInt(data_set[data_index]);
                    if (typeof chart.options.data[0].dataPoints[data_index] != 'undefined') {
                        chart.options.data[0].dataPoints[data_index].y = value;
                    } else {
                        console.log('EEEEEEEEEEEEEE++++++++' + new Date() + '.' + new Date().getMilliseconds());
                        data_index = 0;
                        chart.options.data[0].dataPoints[data_index].y = value;
                    }
                    // Remove line
                    var start_remove_data_index = data_index + 1;
                    var end_remove_data_index = start_remove_data_index + 30;
                    var removed_count = 0;
                    for (var i = start_remove_data_index; i < end_remove_data_index; i++) {
                        if (typeof chart.options.data[0].dataPoints[i] != 'undefined') {
                            var value = empty_data_set[data_index];
                            chart.options.data[0].dataPoints[i].y = value;
                            removed_count++;
                        } else {
                            for (var j = removed_count; j < 30; j++) {
                                if (typeof chart.options.data[0].dataPoints[j] != 'undefined') {
                                    chart.options.data[0].dataPoints[j].y = value;
                                }
                            }
                        }
                    }
                    if (data_index > 5000) {
                        data_index = 0;
                    }
                    if (data_index == 4000) {
                        updateChart();
                        loop++;
                    }
                    if (data_index == 4999) {
                        console.log('hhhhhhhhhh');
                        data_set = dps_value;
                    }
                    data_index += 1;
                }
                chart.render();
                // window.requestAnimationFrame(updateData);
            }
        }
        setInterval(updateData, 30);
        updateChart();
        console.log('SSSSSSSSSSss++++++++' + new Date() + '.' + new Date().getMilliseconds());
        // window.requestAnimationFrame(updateData);
        addDataPoints();

        function addDataPoints() {
            for (i = 0; i < 2500; i++) {
                dps.push({
                    y: empty_data_set[i]
                });
            }
            chart.render();
        }   
    </script>
