$(document).ready(function() {
    var mrn = $('input[name="mrn"]').val();
    var admission_date = $('input[name="admission_date"]').val();
    admission_date = admission_date.split('-');
    date = admission_date[2];
    month = admission_date[1] - 1;
    year = admission_date[0];
    admission_date = new Date(year, month, date);
    $('#otfrom-date, #otto-date').datepicker({
        dateFormat: 'dd-mm-yy',
        minDate: admission_date,
        maxDate: new Date()
    });

    fio2DateFilter();
    $('#filter-icon').on('click', function() {
        fio2DateFilter();
    });

    var open = 0;
    var high = 0;
    var low = 0;
    var close = 0;
    var mean = 0;

    function fio2DateFilter() {
        var selected_start_date = $('#otfrom-date').val() + ' ' + valueFormater($('#otfrom-hour').val()) + ':' + valueFormater($('#otfrom-mins').val()) + ' ' + $('#otfrom-session').val();
        var selected_end_date = $('#otto-date').val() + ' ' + valueFormater($('#otto-hour').val()) + ':' + valueFormater($('#otto-mins').val()) + ' ' + $('#otto-session').val();
        $.ajax({
            type: "GET",
            url: base_url + "/fio2-calculation-charts",
            data: {
                mrn: mrn,
                start_from: selected_start_date,
                end_to: selected_end_date
            },
            beforeSend: function() {
                $('#range-loader').removeClass('display-none');
            },
            success: function(response) {
                low = parseFloat(response[0].low);
                open = parseFloat(response[0].first_quartile);
                mean = parseFloat(response[0].mean);
                close = parseFloat(response[0].last_quartile);
                high = parseFloat(response[0].close);
                if ($.isNumeric(low) && $.isNumeric(open) && $.isNumeric(mean) && $.isNumeric(close) && $.isNumeric(high)) {
                    $('#fio2-chart').removeClass('empty-div');
                    fio2Chart();
                } else {
                    $('#fio2-chart').addClass('empty-div');
                }
            },
            complete: function() {
                $('#range-loader').addClass('display-none');
            }
        });
    }

    function valueFormater(value) {
        return value < 10 ? '0' + value : value;
    }

    var root;
    var chart;

    function fio2Chart() {
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
        root = am5.Root.new("fio2-chart");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        chart = root.container.children.push(
            am5xy.XYChart.new(root, {
                panX: false,
                panY: false
            })
        );

        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xAxis = chart.xAxes.push(
            am5xy.DateAxis.new(root, {
                baseInterval: {
                    timeUnit: "day",
                    count: 1
                },
                renderer: am5xy.AxisRendererX.new(root, {}),
                tooltip: am5.Tooltip.new(root, {})
            })
        );
        xAxis.get("renderer").labels.template.set("forceHidden", true);

        var yAxis = chart.yAxes.push(
            am5xy.ValueAxis.new(root, {
                renderer: am5xy.AxisRendererY.new(root, {})
            })
        );

        var color = "#5FB817";

        // Add series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(
            am5xy.CandlestickSeries.new(root, {
                fill: color,
                stroke: color,
                name: "MDXI",
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "close",
                openValueYField: "open",
                lowValueYField: "low",
                highValueYField: "high",
                valueXField: "date",
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "horizontal",
                    labelText: "Max: {highValueY}\nFirst Quartile: {openValueY}\nMedian: {mean}\nThird Quartile: {valueY}\nMin: {lowValueY}"
                })
            })
        );

        // low series
        var lowSeries = chart.series.push(
            am5xy.StepLineSeries.new(root, {
                stroke: color,
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "low",
                valueXField: "date",
                stepWidth: am5.percent(25)
            })
        );
        // mean series
        var meanSeries = chart.series.push(
            am5xy.StepLineSeries.new(root, {
                stroke: root.interfaceColors.get("background"),
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "mean",
                valueXField: "date",
                noRisers: true,
                stepWidth: am5.percent(50)
            })
        );
        // high series
        var highSeries = chart.series.push(
            am5xy.StepLineSeries.new(root, {
                stroke: color,
                xAxis: xAxis,
                yAxis: yAxis,
                valueYField: "high",
                valueXField: "date",
                noRisers: true,
                stepWidth: am5.percent(25)
            })
        );

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {
            xAxis: xAxis
        }));
        cursor.lineY.set("visible", false);

        var data = [{
            date: "2023-07-27",
            open: open,
            high: high,
            low: low,
            close: close,
            mean: mean
        }];

        series.data.processor = am5.DataProcessor.new(root, {
            dateFields: ["date"],
            dateFormat: "yyyy-MM-dd"
        });

        series.data.setAll(data);
        lowSeries.data.setAll(data);
        meanSeries.data.setAll(data);
        highSeries.data.setAll(data);

        // Make stuff animate on load
        // https://www.amcharts.com/docs/v5/concepts/animations/
        series.appear(1000, 100);
        meanSeries.appear(1000, 100);
        chart.appear(1000, 100);
    }

});