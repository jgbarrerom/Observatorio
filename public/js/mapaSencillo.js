/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*variables*/
var goo = google.maps, shapes = [], selected_shape = null, points_tp = [], prueba;
/*obtener objeto por  Id*/
byId = function(s) {
    return document.getElementById(s);
};
/**
 * 
 * @param {type} shape
 * @returns {undefined}
 */
setSelection = function(shape) {
    clearSelection();
    selected_shape = shape;

    selected_shape.set((selected_shape.type
            ===
            google.maps.drawing.OverlayType.MARKER
            ) ? 'draggable' : 'editable', true);

};
clearShapes = function() {
    for (var i = 0; i < shapes.length; ++i) {
        shapes[i].setMap(null);
    }
    shapes = [];
};
/**
 * 
 * @returns {undefined}
 */
clearSelection = function() {
    if (selected_shape) {
        selected_shape.set((selected_shape.type
                ===
                google.maps.drawing.OverlayType.MARKER
                ) ? 'draggable' : 'editable', false);
        selected_shape = null;
    }
};
/**
 * Propiedades iniciales del mapa
 * @type type
 */
var mapProp = {
    center: new google.maps.LatLng(4.585833, -74.172049),
    zoom: 14,
    panControl: false,
    zoomControl: false,
    streetViewControl: false
};

/**
 * control de graficos sobre el mapa
 * @type google.maps.drawing.DrawingManager
 */
var drawingManager = new google.maps.drawing.DrawingManager({
    drawingControl: true,
    drawingControlOptions: {
        position: google.maps.ControlPosition.TOP_CENTER,
        drawingModes: [
            google.maps.drawing.OverlayType.POLYLINE
        ]
    },
    polylineOptions: {
        strokeColor: '#ff0000',
        strokeOpacity: 0.4,
        strokeWeight: 2,
        zIndex: 1,
        editable: true}
});

var drawingManager_m = new google.maps.drawing.DrawingManager({
    drawingControl: true,
    drawingControlOptions: {
        position: google.maps.ControlPosition.TOP_CENTER,
        drawingModes: [
            google.maps.drawing.OverlayType.MARKER
        ]
    },
    polylineOptions: {
        strokeColor: '#ff0000',
        strokeOpacity: 0.4,
        strokeWeight: 2,
        zIndex: 1,
        editable: true}
});

function initialize() {
    /**
     * Creacion del mapa
     * @type google.maps.Map
     */
    var mapa = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    agregar_controles(mapa, drawingManager);
//    /**
//     * evento de boton obtener coordenadas 
//     */
//    goo.event.addDomListener(byId('coordenadas'), 'click', function() {
//        var data = IO.IN(shapes, true);
//        byId('data').value = JSON.stringify(data);
//    });
    /**
     * Coloca el valor de las coordenadas en el mapa antes de enviar el formulario y valida que no sea vacio
     */
    jQuery('#enviar').click(function() {
        var data = IO.IN(shapes, true);
        byId('coordenadas').value = JSON.stringify(data);
        if (jQuery("#FormGuardarVia").valid()) {
            if (shapes.length > 0) {
                jQuery("#FormGuardarVia").submit();
            } else {
                alert('Debe Ingresar las coordenadas en el mapa');
            }
        }
    });
}

//////////////////////////////////////////////////////////////////////////////////////////////////////
var IO = {
    //returns array with storable google.maps.Overlay-definitions
    IN: function(arr, //array with google.maps.Overlays
            encoded//boolean indicating whether pathes should be stored encoded
            ) {
        var shapes = [],
                goo = google.maps,
                shape, tmp;

        for (var i = 0; i < arr.length; i++)
        {
            shape = arr[i];
            tmp = {type: this.t_(shape.type), id: shape.id || null};

            switch (tmp.type) {
                case 'CIRCLE':
                    tmp.radius = shape.getRadius();
                    tmp.geometry = this.p_(shape.getCenter());
                    break;
                case 'MARKER':
                    tmp.geometry = this.p_(shape.getPosition());
                    break;
                case 'RECTANGLE':
                    tmp.geometry = this.b_(shape.getBounds());
                    break;
                case 'POLYLINE':
                    tmp.geometry = this.l_(shape.getPath(), encoded);
                    break;
                case 'POLYGON':
                    tmp.geometry = this.m_(shape.getPaths(), encoded);

                    break;
            }
            shapes.push(tmp);
        }

        return shapes;
    },
    //returns array with google.maps.Overlays
    OUT: function(arr, //array containg the stored shape-definitions
            map//map where to draw the shapes
            ) {
        var shapes = [],
                goo = google.maps,
                map = map || null,
                shape, tmp;

        for (var i = 0; i < arr.length; i++)
        {
            shape = arr[i];

            switch (shape.type) {
                case 'CIRCLE':
                    tmp = new goo.Circle({radius: Number(shape.radius), center: this.pp_.apply(this, shape.geometry)});
                    break;
                case 'MARKER':
                    tmp = new goo.Marker({position: this.pp_.apply(this, shape.geometry)});
                    break;
                case 'RECTANGLE':
                    tmp = new goo.Rectangle({bounds: this.bb_.apply(this, shape.geometry)});
                    break;
                case 'POLYLINE':
                    tmp = new goo.Polyline({path: this.ll_(shape.geometry)});
                    break;
                case 'POLYGON':
                    tmp = new goo.Polygon({paths: this.mm_(shape.geometry)});

                    break;
            }
            tmp.setValues({map: map, id: shape.id});
            shapes.push(tmp);
        }
        return shapes;
    },
    l_: function(path, e) {
        path = (path.getArray) ? path.getArray() : path;
        if (e) {
            return google.maps.geometry.encoding.encodePath(path);
        } else {
            var r = [];
            for (var i = 0; i < path.length; ++i) {
                r.push(this.p_(path[i]));
            }
            return r;
        }
    },
    ll_: function(path) {
        if (typeof path === 'string') {
            return  google.maps.geometry.encoding.decodePath(path);
        } else {
            var r = [];
            for (var i = 0; i < path.length; ++i) {
                r.push(this.pp_.apply(this, path[i]));
            }
            return r;
        }
    },
    m_: function(paths, e) {
        var r = [];
        paths = (paths.getArray) ? paths.getArray() : paths;
        for (var i = 0; i < paths.length; ++i) {
            r.push(this.l_(paths[i], e));
        }
        return r;
    },
    mm_: function(paths) {
        var r = [];
        for (var i = 0; i < paths.length; ++i) {
            r.push(this.ll_.call(this, paths[i]));

        }
        return r;
    },
    p_: function(latLng) {
        return([latLng.lat(), latLng.lng()]);
    },
    pp_: function(lat, lng) {
        return new google.maps.LatLng(lat, lng);
    },
    b_: function(bounds) {
        return([this.p_(bounds.getSouthWest()),
            this.p_(bounds.getNorthEast())]);
    },
    bb_: function(sw, ne) {
        return new google.maps.LatLngBounds(this.pp_.apply(this, sw),
                this.pp_.apply(this, ne));
    },
    t_: function(s) {
        var t = ['CIRCLE', 'MARKER', 'RECTANGLE', 'POLYLINE', 'POLYGON'];
        for (var i = 0; i < t.length; ++i) {
            if (s === google.maps.drawing.OverlayType[t[i]]) {
                return t[i];
            }
        }
    }
};

function dibujarMapaSalida(salida) {

    var myOptions = {
        zoom: 12,
        panControl: false,
        zoomControl: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var mapa_salida = new google.maps.Map(document.getElementById("googleMapSalida"), myOptions);
    var points = [];
    var points = JSON.parse(byId('coordenadas').value);
    if (salida === true) {
        IO.OUT(points, mapa_salida);
    }
    setZoom(mapa_salida, points);
    return mapa_salida;
}
function setZoom(map, markers) {
    var boundbox = new google.maps.LatLngBounds();
    for (var i = 0; i < markers.length; i++)
    {
        var point = markers[i];
        var t = google.maps.geometry.encoding.decodePath(point.geometry);
        for (var j = 0; j < t.length; j++) {
            boundbox.extend(new google.maps.LatLng(t[j].k, t[j].D));
        }
    }
    map.setCenter(boundbox.getCenter());
    map.fitBounds(boundbox);
}

function agregar_controles(mapa_sel, controles) {
    var drawingManager = controles;
    google.maps.event.clearListeners(drawingManager, 'overlaycomplete');
    goo.event.addListener(drawingManager, 'overlaycomplete', function(e) {
        var shape = e.overlay;
        shape.type = e.type;
        setSelection(shape);
        goo.event.addListener(shape, 'click', function() {
            setSelection(this);
        });
        setSelection(shape);
        shapes.push(shape);
    });
    drawingManager.setMap(mapa_sel);


    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, mapa_sel);
    centerControlDiv.index = 1;
    centerControlDiv.id = 'clear';
    mapa_sel.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

    function CenterControl(controlDiv, map) {

        var controlUI = document.createElement('div');
        controlUI.style.background = 'url(\'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABcAAAAYCAYAAAARfGZ1AAAACXBIWXMAAAsTAAALEwEAmpwYAAAAIGNIUk0AAHolAACAgwAA+f8AAIDpAAB1MAAA6mAAADqYAAAXb5JfxUYAAAPBSURBVHjanJa9SyN5GMe/E/OimIl7Ftkk6iUai4sGUriCp1lFxHR2WggKIY1NFAS18j8QD4OF743eBsTOwttCRMQq7N2GwN5JCMRGOQ2rmWhe5u33XLFRVi9m1aebme98fl++PM8zwxHRGQAeAAHg8Ly601YAUJ/QZECvqNXVVfL7/SQIQlkdiCjzEnAsFiOe5wmA7PP58icn/0hEJJeQCi+CC4JAbW1tVF9fT93d3dTY2EgOh10MBoPnhULh9rFcg+dXNhAICIlEAg6HHZIkwWKxoKbmjX5paent8PCw/ujoKA8gV9Rzz4XLa2tr13t7ezqXywVVVUFEYIyhsrISnZ2/aj5//ks3MDDAjY+P5wuFAgBwHBFlit3yZCUSia/v3rUb7PafjUZjNVSV3T/jOO6+eRhjiEQiWF5eprGxsexznMuhUEjHcTDyPF8STPTtWpJEmM1mubW1lZ4Ti7q5ufl1fX3d4HL9AkVRngRrNBp8+fI3zczMiF6vVwOAysZyeXmZbmlxVZhMNbzNZruHlwKfnZ3B4/Hkdnd3KwAYANyUc34TDAazsizzPM+zZDIJVVWh1VY8AHMcB1EUcXNzoywsLFAR/O3QJ8DKhw+/Czs7O/ynT3+qKysr1NzcTIKQRjabA1dMk+MArVaLeDxOfr8/29TUZHi4JEoPkaTRcNLU1BQRESveY3NzcxLHcYrNZqOOjg56/95LFouFent7c6qq5h4xMiXh4XCYLJa3VGKs5XA4nPP5fLLdbie32021tbViLBa7LWHw//B0Ok12u12JRqPi9va2/PHjH6zEiywUCokAlI2NDYmIpFLwB5krioKxsTH09PTA4/FoTSZTxfz8b2xkZES8uLhgD5pfltW+vj4EAgEdAF3pxfyd83g8ngMgRqPR++Oz2ZwSCATy7e3t6tbWlkJELBKJSADYyclJuT33MJbr6+tMQ0PD9fj4uEpE6vfKw8NDNjg4KBGR0tnZqU5MTLAfLdHHmaupVEr2eDzq6OhovkSWbH5+nnQ6Xeb29jbzUvidywKA7NDQkJhMJu/akZ2enjIA4uLi4gURKa+CF1tQmp6elqurq/MOh0Pu7+9XAUhdXV2nRJQuA72LK80RkQDAlEqlcH5+DgBUVVXFmc1mGI1GaX9/P398fFwly7JOr9cLs7OzZDAYfirz4abi5KdBRHR1dUVOp5OsVit5vV5yu90EgCYnJ+m1xRhTOSK6kCTJcHBwkK6rq3tjtVo1qVRKSSQSYktLi87pdOp/8Ivx2DWIqALAv/8NAIwXsQUYVGgFAAAAAElFTkSuQmCC\')';
        controlUI.style.border = '1px solid #C1BEBE';
        controlUI.style.boxShadow = '0px 1px 2px #CBC7C7';
        controlUI.style.borderRadius = '3px';
        controlUI.style.cursor = 'pointer';
        controlUI.style.marginBottom = '22px';
        controlUI.style.textAlign = 'center';
        controlUI.title = 'click para borrar linea';
        controlUI.style.marginTop = '5px';
        controlUI.style.marginLeft = '-6px';
        controlUI.style.height = '24px';
        controlUI.style.width = '24px';
        controlDiv.appendChild(controlUI);
        google.maps.event.addDomListener(controlUI, 'click', function() {
            clearShapes();
            clearSelection();
            jQuery('#coordenadas').val('');
        });

    }
}
function mapa_marker() {
    var mapa = new google.maps.Map(document.getElementById("map-marker"), mapProp);
    agregar_controles(mapa, drawingManager_m);

    jQuery('#enviar').click(function() {
        var data = IO.IN(shapes, true);
        byId('coordenadas').value = JSON.stringify(data);
        if (jQuery("#formLugar").valid()) {
            if (shapes.length > 0) {
                jQuery("#formLugar").submit();
            } else {
                alert('Debe Ingresar la ubicacion en el mapa');
            }
        }
    });
}

function mapaEdicion() {
    var mapa = dibujarMapaSalida(false);
    agregar_controles(mapa, drawingManager);
    var flightPlanCoordinates = [];
    var points = JSON.parse(byId('coordenadas').value);
    for (var i = 0; i < points.length; i++)
    {
        var point = points[i];
        var t = google.maps.geometry.encoding.decodePath(point.geometry);
        for (var j = 0; j < t.length; j++) {
            flightPlanCoordinates.push(new google.maps.LatLng(t[j].k, t[j].D));
        }
    }


    var flightPath = new google.maps.Polyline({
        path: flightPlanCoordinates,
        strokeColor: '#ff0000',
        strokeOpacity: 0.4,
        strokeWeight: 2,
        zIndex: 1,
        type: 'polyline',
        editable: true
    });
    flightPath.setMap(mapa);
    var shape = flightPath;
    shape.type = flightPath.type;
    setSelection(shape);
    shapes.push(shape);
}

function establecerCoordenadas() {
    //Esto se hace por que  en el overlay de la edicion se ejecuta varias veces 
//    var temp_shapes = shapes[0];
//    shapes = [];
//    shapes.push(temp_shapes);
    var data = IO.IN(shapes, true);
    byId('coordenadas').value = JSON.stringify(data);
    // alert(jQuery('#coordenadas').val());
}
function mapa_lugares(data) {
    var myOptions = {
        zoom: 12,
        panControl: false,
        zoomControl: false,
        streetViewControl: false,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var map_lugares = new google.maps.Map(document.getElementById("mapa_lugares"), myOptions);

    datos = data.resultado.Records;
    var boundbox = new google.maps.LatLngBounds();
    $.each(datos, function() {
        var point = JSON.parse(this.coordenadas);
        boundbox.extend(new google.maps.LatLng(point[0].geometry[0], point[0].geometry[1]));
        var contentString = '<div id="content">' +
                '<div class="titulo-iw"><h5>' + this.nombre.toUpperCase() + '</h5></div>' +
                '<hr><div>' +
                '<p><b>Barrio: </b>' + this.barrio + '</p>' +
                '<p><b>Direccion: </b>' + this.direccion + '</p>' +
                '<p><b>Telefono: </b>' + this.telefono + '</p>' +
                '</div>' +
                '</div>';
        var infowindow = new google.maps.InfoWindow({
            content: contentString
        });

        var marker = new google.maps.Marker({
            position: new google.maps.LatLng(point[0].geometry[0], point[0].geometry[1]),
            map: map_lugares,
            title: this.nombre.toUpperCase(),
            animation: google.maps.Animation.DROP
        });
        google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map_lugares, marker);
        });


    });
    map_lugares.setCenter(boundbox.getCenter());
    map_lugares.fitBounds(boundbox);
}


//var distancia = google.maps.geometry.spherical.computeDistanceBetween(x1, x2); 
//function direccion(latlng) {
//    geocoder.geocode({'latLng': latlng}, function(results, status) {
//        if (status == google.maps.GeocoderStatus.OK) {
//            if (results[0]) {
//                $('#direccion').text(results[0].formatted_address);
//            } else {
//                alert('No se encontrarn resultados');
//            }
//        } else {
//            alert('Erro de conexión: ' + status);
//        }
//    });
//}
function mapaActividad(coordenadas) {
    var map_actividad = new google.maps.Map(document.getElementById("ubicacion"), mapProp);
    var point = JSON.parse(coordenadas);
    var boundbox = new google.maps.LatLngBounds();
    boundbox.extend(new google.maps.LatLng(point[0].geometry[0], point[0].geometry[1]));
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(point[0].geometry[0], point[0].geometry[1]),
        map: map_actividad,
        animation: google.maps.Animation.DROP
    });
    map_actividad.setCenter(boundbox.getCenter());
    map_actividad.fitBounds(boundbox);

}
function mapaEdicionLugar(coordenadas) {
    var mapa = new google.maps.Map(document.getElementById("map-marker"), mapProp);
    agregar_controles(mapa, drawingManager_m);
    var point = JSON.parse(coordenadas);
    var boundbox = new google.maps.LatLngBounds();
    boundbox.extend(new google.maps.LatLng(point[0].geometry[0], point[0].geometry[1]));
    var marker = new google.maps.Marker({
        position: new google.maps.LatLng(point[0].geometry[0], point[0].geometry[1]),
        map: mapa,
        animation: google.maps.Animation.DROP
    });
    mapa.setCenter(boundbox.getCenter());
    mapa.fitBounds(boundbox);
    var shape = marker;
    shape.type = marker.type;
    setSelection(shape);
    shapes.push(shape);

}