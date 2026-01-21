<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/amcharts.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/serial.js"></script>
<script class="special-print-css" type="text/javascript" src="{{ url('/') }}/public/plugins/amcharts/pie.js"></script>

<script type="text/javascript" src="{{ url('/') }}/js/amcharts5/index.js"></script>
<script type="text/javascript" src="{{ url('/') }}/js/amcharts5/xy.js"></script>
<script type="text/javascript" src="{{ url('/') }}/js/amcharts5/themes_animated.js"></script>

<style type="text/css">
  #monthly_reg_chart, #ward_wise_chart {
    width     : 100%;
    height    : 495px;
    font-size : 11px;
  }
  .carousel-indicators {
      bottom: -5px;
  }
  @media screen and (min-width: 576px) and (max-width: 992px) {
    .col-xs-12.col-sm-12.col-md-8, .col-xs-12.col-sm-12.col-md-4 {
      width    : 50%;
    }
    .carousel-inner .item {
      overflow-y: auto;
    }
  }
  @media screen and (max-width: 576px){
    #monthly_reg_chart, #ward_wise_chart {
      height    : 245px;
    }
    .carousel-inner .item {
      overflow-y: auto;
    }
  }
</style>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-8">
    <div id="monthly_reg_chart" class="chart-shadow"></div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-4">
    <div id="ward_wise_chart" class="chart-shadow"></div>
  </div>
</div>
<script type="text/javascript">

var color = ['#2E91E6', '#E05F98', '#1DA71C', '#FB0D0D', '#DA16FE', '#222B2A', '#B68101', '#750D86', '#EB663B', '#501CFC', '#01A08A', '#FC00D1', '#B2838D', '#6C7C33', '#7789AD', '#812915', '#A777F1', '#1617A7', '#DA61CA', '#6B4516', '#0D2A62', '#AB0337'];
// var color = ['#1DB2F6', '#F4564A', '#98C95C', '#FFC720', '#E93574', '#A63CB8'];
  
// var color = ['#5588BB', '#66BBBB', '#AA6644', '#99BB55', '#EE9944', '#444466', '#BB5555'];

var order_date = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
var results = <?php echo json_encode($comparse_year_wise_baby_reg); ?>;

monthlyChart();

function monthlyChart() {

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
  var root = am5.Root.new("monthly_reg_chart");


var colorSet = am5.ColorSet.new(root, {});

console.log(colorSet);
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
    text: "[bold]NICU Admissions [normal](Apr 2022 to Till Now)",
    fontSize: 16,
    fontWeight: "bold",
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

if ($('#monthly_reg_chart').width() <= 622) {
  chart.categoryAxis.tickLength = 5;
}

var chart = AmCharts.makeChart("ward_wise_chart", {
  "type": "pie",
  "theme": "dark",
  "colors": ['#495057', '#34a7c8', '#58cc90'],
  "titles": [{
    "text": "Total Admissions = " + <?php echo $ward_wise_reg['total_admission']; ?> +" ( 30 Days )",
    "size" : 16
  }],
  "dataProvider": [{
    "country": "NICU",
    "visits": <?php echo $ward_wise_reg['nicu']; ?>
  }, {
    "country": "Postnatal",
    "visits": <?php echo $ward_wise_reg['postnatal']; ?>
  }, {
    "country": "OP",
    "visits": <?php echo $ward_wise_reg['op']; ?>
  }],
  "valueField": "visits",
  "titleField": "country",
  "startEffect": "elastic",
  "startDuration": 2,
  "labelRadius": 15,
  "innerRadius": "50%",
  "depth3D": 10,
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
  "angle": 15,
  "export": {
    "enabled": false
  }
});

setInterval(function() {
  $('a[href="http://www.amcharts.com/javascript-charts/"]').addClass('hide');
}, 10)
</script>
