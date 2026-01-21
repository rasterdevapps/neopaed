$(document).ready(function() {

    var admission_date = JSON.parse($('input[name="admission_date"]').val());

    var keys = Object.keys(admission_date);
    var values = Object.values(admission_date);

    admissionSelect();
    $('select[name="admission"]').on('change', function() {
        admissionSelect();
    });
    var jmin_date = '';
    var jmax_date = '';

    function admissionSelect() {
        var admission_id = $('select[name="admission"]').val();
        var index = keys.indexOf(admission_id);

        var date  = values[index].split(':');
        var min_date = dateFormater(date[0], 'min');
        if (date[1] == '') {
            var temp = new Date();
            if (typeof jmax_date == 'undefined') {
                jmax_date = temp;
            }
            var current_date = valueFormater(temp.getDate()) + '-' + valueFormater(temp.getMonth() + 1) + '-' + temp.getFullYear();
        }
        var max_date = date[1] == '' ? current_date : dateFormater(date[1], 'max');

        var millisBetween = jmax_date.getTime() - jmin_date.getTime();  
      
        var days = millisBetween / (1000 * 3600 * 24);  
      
        var diff_days = Math.round(Math.abs(days)); 

        var dates = []; 
            dates.push(jmin_date.getTime());
                console.log(diff_days);

        for (var i = 0; i < diff_days; i++) {
            var temp_date = jmin_date;
                temp_date.setDate(temp_date.getDate() + 1);
            if (temp_date.getTime() <= jmax_date.getTime()) {
                dates.push(temp_date.getTime());
            }
        }
                console.log(dates);

        $("#from-date, #to-date").datepicker("destroy");

        $('#from-date, #to-date').datepicker({
            dateFormat: 'dd-mm-yy',
            beforeShowDay: function(date) {
                if($.inArray(date.getTime(), dates) > -1) {
                    return [true, 'highlight', ''];
                } else {
                    return [true, '', ''];
                }
            },
        });

        $('#from-date').val(min_date);
        $('#to-date').val(max_date);
        getData();
    }

    function valueFormater(value) {
        return value < 10 ? '0' + value : value;
    }

    function dateFormater(date, slug) {
        var temp_date = date.split('-');
        var date = temp_date[2];
        var month = temp_date[1];
        var year = temp_date[0].split(' ')[0];
        if (slug == 'min') {
            jmin_date = new Date(year, month - 1, date);
        }
        if (slug == 'max') {
            jmax_date = new Date(year, month - 1, date);
        }

        return date + '-' + month + '-' + year;
    }

    $('#from-date, #to-date').on('change', function() {
        getData();
    });
    
    var data = [];
    var total = 0;

    function getData() {
        var mrn = $('input[name="mrn"]').val();
        var from_date = $('#from-date').val();
        var to_date = $('#to-date').val();
        $.ajax({
            type: "GET",
            url: base_url + "/care-event-chart-details",
            data: {
                mrn: mrn,
                from_date: from_date,
                to_date: to_date
            },
            beforeSend: function() {
                $('#range-loader').removeClass('display-none');
            },
            success: function(response) {
                data = response.event;
                total = response.total;
                if (total == 0) {
                    $('#empty-chart').removeClass('hide');
                    $('#event-chart').addClass('hide');                    
                } else {
                    $('#event-chart').removeClass('hide');                    
                    $('#empty-chart').addClass('hide');
                }
                charts();
            },
            complete: function() {
                $('#range-loader').addClass('display-none');
            }
        });

    }

    var root;
    var chart;

    function charts() {
        if (typeof root !== 'undefined') {
            root.dispose();
            chart.dispose();
        }
        /**
        * ---------------------------------------
        * This demo was created using amCharts 5.
        * 
        * For more information visit:
        * https://www.amcharts.com/
        * 
        * Documentation is available at:
        * https://www.amcharts.com/docs/v5/
        * ---------------------------------------
        */

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        root = am5.Root.new("event-chart");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
            ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: false,
            panY: false,
            layout: root.verticalLayout,
            paddingTop: 75
        }));
        chart.set("background", am5.Rectangle.new(root, {
            stroke: '#FFB3B3',
            strokeOpacity: 0.5,
            strokeWidth: 5,
            fill: '#000000',
            fillOpacity: 1
        }));
        chart.zoomOutButton.set("forceHidden", true);
        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, {
            minGridDistance: 30
        });
        xRenderer.labels.template.setAll({
            fill: root.interfaceColors.get("alternativeText"),
            fontSize: 12
        });
        xRenderer.labels.template.setAll({
            rotation: -90,
            centerY: am5.p50,
            centerX: am5.p100,
            paddingRight: 15
        });
        xRenderer.grid.template.set("visible", false);
        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            categoryField: "event",
            renderer: xRenderer,
        }));
        var range = xAxis.makeDataItem({
            value: 0,
        });
        xAxis.createAxisRange(range);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#FFFFFF',
            strokeOpacity: 1,
            strokeWidth: 1,
            visible: true
        });

        var yRenderer = am5xy.AxisRendererY.new(root, {
            strokeOpacity: 0.1
        })
        yRenderer.labels.template.setAll({
            fill: root.interfaceColors.get("alternativeText"),
            fontSize: 12
        });
        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
            min: 0,
            max: 100,
            numberFormat: "#.'%'",
            renderer: yRenderer
        }));
        yAxis.children.moveValue(am5.Label.new(root, {
            text: '('+ total + ')',
            paddingLeft: 0,
            paddingRight: 0,
            fontSize: 16,
            fontWeight: 'bold',
            fill: '#FF0000',
            centerX: am5.p0,
            centerY: am5.p50,
            dy: -2,
        }), 0);
        var range = yAxis.makeDataItem({
            value: 0,
        });
        yAxis.createAxisRange(range);
        var grid = range.get("grid");
        grid.setAll({
            stroke: '#FFFFFF',
            strokeOpacity: 1,
            strokeWidth: 1,
            visible: true
        });
        yRenderer.grid.template.set("visible", false);

        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: "Events",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            valueXField: "original",
            categoryXField: "event",
            maskBullets: false

        }));
            // Rounded corners for columns
        series.columns.template.setAll({
            cornerRadiusTL: 5,
            cornerRadiusTR: 5,
            strokeOpacity: 0
        });
            // Make each column to be of a different color
        series.columns.template.adapters.add("fill", function(fill, target) {
            return colors[series.columns.indexOf(target)];
        });
        series.bullets.push(function() {
            return am5.Bullet.new(root, {
                locationX: 0.5,
                locationY: 1,
                sprite: am5.Label.new(root, {
                    text: "[bold]{valueX} ({valueY} %)",
                    centerX: am5.percent(50),
                    centerY: am5.percent(50),
                    textAlign: "center",
                    rotation: -90,
                    populateText: true,
                    fill: '#FFFFFF',
                    paddingLeft: 80,
                    fontSize: 12
                })
            });
        });

        // Set data
        var temp = [];
        var colors = [];
        var total_events = Object.keys(data).length;
        $('#event-chart').css('width', (total_events * 70) + 100);
        $.each(data, function(key, value) {
            // if (value.count > 0) {
                var temp1 = {};
                temp1['event'] = value.event;
                temp1['value'] = ((value.count / total) * 100).toFixed(2);
                temp1['original'] = value.count;
                colors.push(value.bg_color);
                temp.push(temp1);
            // }
        });
        xAxis.data.setAll(temp);
        series.data.setAll(temp);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000);
        chart.appear(1000, 100);
    }

});
