/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function initialize() {
    var mapProp = {
        center: new google.maps.LatLng(4.443154, -74.149647),
        zoom: 10,
        panControl: false,
        zoomControl: false,
        streetViewControl: false
    };
    var mapa = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYLINE, //el tipo con el que inicia 
        drawingControl: true,
        drawingControlOptions: {
            position: google.maps.ControlPosition.TOP_CENTER,
            drawingModes: [
                google.maps.drawing.OverlayType.POLYLINE
            ]
        }
    });
    drawingManager.setMap(mapa);
}

google.maps.event.addDomListener(window, 'load', initialize);
$(document).ready(function () {
    google.maps.event.addDomListener('accion', 'click', function () {
        alert('funciona');
    });
    google.maps.event.addListener(map,'rightclick',function(e){
        console.log('latitud=' + e.latLng.lat() + ',logitud=' + e.latLng.lng());
    });
});

