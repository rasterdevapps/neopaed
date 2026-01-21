<style type="text/css">
  #monthly_reg_chart_custom {
    width     : 100%;
    height    : 495px;
    font-size : 11px;
  }
  @media  screen and (max-width: 576px){
    #monthly_reg_chart_custom {
      height    : 245px;
    }
  }
</style>

<div class="row">
    <div id="monthly_reg_chart_custom" class="chart-shadow"></div>
</div>
<script type="text/javascript">
var color = ['#2E91E6', '#E05F98', '#1DA71C', '#FB0D0D', '#DA16FE', '#222B2A', '#B68101', '#750D86', '#EB663B', '#501CFC', '#01A08A', '#FC00D1', '#B2838D', '#6C7C33', '#7789AD', '#812915', '#A777F1', '#1617A7', '#DA61CA', '#6B4516', '#0D2A62', '#AB0337'];
// var color = ['#1DB2F6', '#F4564A', '#98C95C', '#FFC720', '#E93574', '#A63CB8'];
  
// var color = ['#5588BB', '#66BBBB', '#AA6644', '#99BB55', '#EE9944', '#444466', '#BB5555'];


var order_date = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
var results = <?php echo json_encode($year_wise_baby_reg); ?>;
$('#custom_chart').on('click', function() {
  customMonthlyChart();
});

function customMonthlyChart() {

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
  var root = am5.Root.new("monthly_reg_chart_custom");


  // Set themes
  // https://www.amcharts.com/docs/v5/concepts/themes/
  root.setThemes([
    am5themes_Animated.new(root)
  ]);


  // Create chart
  // https://www.amcharts.com/docs/v5/charts/xy-chart/
  var chart = root.container.children.push(am5xy.XYChart.new(root, {
    layout: root.verticalLayout
  }));

  chart.children.unshift(am5.Label.new(root, {
    text: "[bold]NICU Admissions [normal](Aug 2017 - Mar 2022)",
    fontSize: 16,
    textAlign: "center",
    x: am5.percent(50),
    centerX: am5.percent(50),
    paddingTop: 0,
  }));
  // Add legend
  // https://www.amcharts.com/docs/v5/charts/xy-chart/legend-xy-series/
  var legend = chart.children.push(
    am5.Legend.new(root, {
      centerX: am5.p50,
      x: am5.p50
    })
  );

  var data = [];
  $.each(order_date, function(item, index) {
    var value = results['data'][index];
    value.month = new Date(null, value.month - 1);
    data.push(value);
  });
  // Create axes
  // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
  var xRenderer = am5xy.AxisRendererX.new(root, {
    minGridDistance: 5,
    cellStartLocation: 0.1,
    cellEndLocation: 0.9
  })
  var xAxis = chart.xAxes.push(am5xy.CategoryDateAxis.new(root, {
    baseInterval: {
      timeUnit: "month",
      count: 1
    },
    dateFormats: {
      month: "MMM"
    },
    periodChangeDateFormats: {
      month: "MMM"
    },
    categoryField: "month",
    renderer: xRenderer,
    tooltip: am5.Tooltip.new(root, {})
  }));
  xRenderer.grid.template.setAll({
    location: 1
  })

  xAxis.data.setAll(data);

  var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
    min: 0,
    renderer: am5xy.AxisRendererY.new(root, {
      minGridDistance: 15,
      strokeOpacity: 0.1
    })
  }));


  // Add series
  // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
  function makeSeries(name, fieldName, color) {
    var series = chart.series.push(am5xy.ColumnSeries.new(root, {
      name: name,
      xAxis: xAxis,
      yAxis: yAxis,
      valueYField: fieldName,
      categoryXField: "month",
      fill: color
    }));

    series.columns.template.setAll({
      tooltipText: "{name}: {valueY}",
      width: am5.percent(90),
      tooltipY: 0,
      strokeOpacity: 0
    });

    series.data.setAll(data);

    // Make stuff animate on load
    // https://www.amcharts.com/docs/v5/concepts/animations/
    series.appear();

    legend.data.push(series);
  }

  $.each(results['year'], function(key, value) {
    makeSeries(value, value, color[key]);
  });


  // Make stuff animate on load
  // https://www.amcharts.com/docs/v5/concepts/animations/
  chart.appear(1000, 100);
}

</script>
