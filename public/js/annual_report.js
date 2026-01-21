
//This for mixed bar chart property 
function mixedBarchart(sexDistributiondata, sexDistributionprop, id) {
    return AmCharts.makeChart(id, {
        "type": "serial",
        "theme": "light",
        "legend": {
            "verticalGap": 2,
            "maxColumns": 10,
            "position": "bottom",
            "useGraphSettings": true,
            "markerSize": 10
        },
        "precision": 2,
        "dataProvider": sexDistributiondata,
        "valueAxes": [{
            "stackType": "regular",
            "axisAlpha": 0.3,
            "gridAlpha": 0,
            "maximum": 100,
        }],
        "graphs": sexDistributionprop,
        "categoryField": "Year",
        "categoryAxis": {
            "gridPosition": "start",
            "axisAlpha": 0,
            "gridAlpha": 0,
            "position": "left"
        },
        "export": {
            "enabled": false
        }
    });
}

function multipleBarchart(dataList, property, id) {
    return AmCharts.makeChart(id, {
        "type": "serial",
        "theme": "light",
        "legend": {
            "verticalGap": 2,
            "maxColumns": 10,
            "position": "bottom",
            "useGraphSettings": true,
            "markerSize": 10
        },
        "precision": 2,
        "categoryField": "Year",
        "rotate": false,
        "startDuration": 1,
        "categoryAxis": {
            "gridPosition": "start",
            "position": "bottom"
        },
        "trendLines": [],
        "graphs": property,
        "guides": [],
        "valueAxes": [
        {
            "id": "ValueAxis-1",
            "position": "left",
            "axisAlpha": 0,
            //"maximum" : 100,
        }],
        "allLabels": [],
        "balloon": {},
        "titles": [],
        "dataProvider": dataList,
        "export": {
            "enabled": false
        }
    });
}
