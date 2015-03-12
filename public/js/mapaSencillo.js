/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

byId = function(s) {
    return document.getElementById(s);
};
function initialize() {
    /*variables*/
    var goo = google.maps, shapes = [], selected_shape = null, points_tp = [];
    /*obtener objeto por  Id*/

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
        center: new google.maps.LatLng(4.443154, -74.149647),
        zoom: 10,
        panControl: false,
        zoomControl: false,
        streetViewControl: false
    };
    /**
     * Creacion del mapa
     * @type google.maps.Map
     */
    var mapa = new google.maps.Map(document.getElementById("googleMap"), mapProp);
    /**
     * control de graficos sobre el mapa
     * @type google.maps.drawing.DrawingManager
     */
    var drawingManager = new google.maps.drawing.DrawingManager({
        drawingMode: google.maps.drawing.OverlayType.POLYLINE, //el tipo con el que inicia 
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
    drawingManager.setMap(mapa);
    /**
     * evento de boton obtener coordenadas 
     */
    goo.event.addDomListener(byId('coordenadas'), 'click', function() {
        alert('Jeisson ');
        var data = IO.IN(shapes, false);
        byId('data').value = JSON.stringify(data);
    });
    /**
     * evento completar el grafico sobre el mapa
     */
    goo.event.addListener(drawingManager, 'overlaycomplete', function(e) {
        alert('Jeisson ');
        var shape = e.overlay;
        shape.type = e.type;
        goo.event.addListener(shape, 'click', function() {
            setSelection(this);
        });
        setSelection(shape);
        shapes.push(shape);
        var data = IO.IN(shapes, false);
        byId('coordenadas').value = JSON.stringify(data);
    });
}

google.maps.event.addDomListener(window, 'load', initialize);

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
        }
        else {
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

function dibujarMapaSalida() {

    var centerMap = new google.maps.LatLng(4.572956, -74.168959);
    var myOptions = {
        zoom: 10,
        center: centerMap,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    var mapa_salida = new google.maps.Map(document.getElementById("googleMapSalida"), myOptions);
    var
            points = [];
    points = byId('coordenadas').value;
    alert('sdfghjk');
//    alert(points.toString());
//    setZoom(mapa_salida, points);}
    //var points = google.maps.geometry.encoding.decodePath(byId('coordenadas').value);
    //  var points = google.maps.geometry.encoding.decodePath()
    var p = new google.maps.geometry
    IO.OUT(JSON.parse(byId('coordenadas').value), mapa_salida);
}

function setZoom(map, markers) {
    var boundbox = new google.maps.LatLngBounds();
    for (var i = 0; i < markers.length; i++)
    {
        //      alert(markers[i].k + '-- ' + markers[i].D);
        boundbox.extend(new google.maps.LatLng(markers[i].k, markers[i].D));
    }
    alert(boundbox.getCenter());
    map.setCenter(boundbox.getCenter());
    map.fitBounds(boundbox);
}