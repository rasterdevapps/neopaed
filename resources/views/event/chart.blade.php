<html>
    <head>
        <title>D3 Electrocardiogram (ECG)</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script
            type="text/javascript"
            src="https://d3js.org/d3.v3.js"
            ></script>
        <style id="compiled-css" type="text/css">
            body {<!--  w w w  . d  em  o  2 s .  c  o m-->
            font: 12px Arial;
            }
            path {
            stroke: steelblue;
            stroke-width: 2;
            fill: none;
            }
            .axis path, .axis line {
            fill: none;
            stroke: grey;
            stroke-width: 1;
            shape-rendering: crispEdges;
            }
        </style>
    </head>
    <body>
        <body>
    </body>
    <script type='text/javascript'>
        var margin = {
            top: 30,
            right: 20,
            bottom: 30,
            left: 50
        };
        var xIndex = 0;
        var width = 600 - margin.left - margin.right;
        var height = 270 - margin.top - margin.bottom;
        var data = [];
        var x = d3.scale.linear().domain([0, 200]).range([0, width]);
        var y = d3.scale.linear().domain([0, 100]).range([height, 0]);
        var count = 0;
        var lineToDraw;
        var xAxis = d3.svg.axis().scale(x)
            .orient("bottom").ticks(5);
        var yAxis = d3.svg.axis().scale(y)
            .orient("left").ticks(5);
        var valueline = d3.svg.line()
            .x(function (d) {
              return x(d.x);
            })
            .y(function (d) {
              return y(d.y);
            });
        var svg = d3.select("body")
            .append("svg")
            .attr("width", width + margin.left + margin.right)
            .attr("height", height + margin.top + margin.bottom)
            .append("g")
            .attr("transform", "translate(" + margin.left + "," + margin.top + ")");
        // Render two slip paths. One will be drawn as the other is wiped. To create the wipe effect, I simply reduce the size of the clip path and translate it.
        var clipPath1 = svg.append("defs")
              .append("clipPath")
              .attr("id", "clip1");
        var clipPath2 = svg.append("defs")
              .append("clipPath")
              .attr("id", "clip2");
        var clipRect1 = clipPath1.append("rect")
                .attr("x", 0)
                .attr("width", 0)
                .attr("height", height);
        var clipRect2 = clipPath2.append("rect")
                .attr("x", 0)
                .attr("width", 0)
                .attr("height", height);
        // Append two paths. One path will be used to draw on while the other will be the previously drawn path.
        var path1 = svg.append("g")
            .attr("id", "g1")
            .append("path") // Add the valueline path.
            .attr("class", "line1")
            .attr("clip-path", "url(#clip1)")
            .data([data])
            .attr("d", valueline);
        var path2 = svg.append("g")
            .attr("id", "g2")
            .append("path")
            .attr("clip-path", "url(#clip2)")// Add the valueline path.
            .data([data])
            .attr("class", "line2")
            .attr("d", valueline);
        // Add the x and y axis.
        svg.append("g")
            .attr("class", "x axis")
            .attr("transform", "translate(0," + height + ")")
            .call(xAxis);
        svg.append("g")
            .attr("class", "y axis")
            .call(yAxis);
        // An interval that adds a data point every 5 milliseconds
        setInterval(function()
        {
          var point = {
            x: xIndex,
            y: Math.abs(Math.floor(Math.random() * Math.floor(100)))
          };
          data.push(point);
          xIndex++;
          addData();
        }, 5);
        function addData()
        {
          if (data.length === 200)
          {
            count++;
            xIndex = 0;
            data =[]
            if (lineToDraw !== undefined)
            {
              if (lineToDraw === ".line1")
              {
                clipRect2.attr("width", "0");
                clipRect2.attr("transform", "translate(0, 0)");
              }
              else
              {
                clipRect1.attr("width", "0");
                clipRect1.attr("transform", "translate(0, 0)");
              }
            }
          }
          lineToDraw = count % 2 === 0 ? ".line1" : ".line2";
          var increment = x(data.length);
          var newWidth = width - increment;
          if (lineToDraw === ".line1")
          {
              clipRect1.attr("width", increment);
              clipRect2.attr("width", newWidth);
              clipRect2.attr("transform", "translate(" + increment + ", 0)");
          }
          else
          {
              clipRect2.attr("width", increment);
              clipRect1.attr("width", newWidth);
              clipRect1.attr("transform", "translate(" +increment + ", 0)");
          }
          svg.select(lineToDraw)
            .data([data])
            .attr("d", valueline);
        }
    </script>
    </body>
</html>
