/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


//$(function() {
//    $('#container').highcharts({
//        title: {
//            text: 'Monthly Average Temperature',
//            x: -20 //center
//        },
//        subtitle: {
//            text: 'Source: WorldClimate.com',
//            x: -20
//        },
//        xAxis: {
//            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
//                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
//        },
//        yAxis: {
//            title: {
//                text: 'Temperature (°C)'
//            },
//            plotLines: [{
//                    value: 0,
//                    width: 1,
//                    color: '#808080'
//                }]
//        },
//        tooltip: {
//            valueSuffix: '°C'
//        },
//        legend: {
//            layout: 'vertical',
//            align: 'right',
//            verticalAlign: 'middle',
//            borderWidth: 0
//        },
//        series: [{
//                name: 'Tokyo',
//                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
//            }, {
//                name: 'New York',
//                data: [-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5]
//            }, {
//                name: 'Berlin',
//                data: [-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0]
//            }, {
//                name: 'London',
//                data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
//            }]
//    });
//});

$(document).ready(function() {
    var c = [];
    var s = [];
    $.getJSON("/home/estjson", function(json) {
        var prueba = json.resultado;
        c = prueba.categories;
        s = prueba.series;
    });
    var options = {
        chart: {
            renderTo: 'container',
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false
        },
        title: {
            text: 'Numero de Obras Viales',
            x: -20 //center
        },
        subtitle: {
            text: 'Alcaldia local de Ciudad Bolivar',
            x: -20
        },
        xAxis: {
            categories: c
        },
        yAxis: {
            title: {
                text: 'Numero de Obras '
            },
            plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
        },
        tooltip: {
            valueSuffix: '  Obras'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: s
    };
    chart = new Highcharts.Chart(options);
}); 