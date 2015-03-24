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
     * Creacion del mapa
     * @type google.maps.Map
     */
    var mapa = new google.maps.Map(document.getElementById("googleMap"), mapProp);
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
    drawingManager.setMap(mapa);
    /**
     * evento de boton obtener coordenadas 
     */
    goo.event.addDomListener(byId('coordenadas'), 'click', function() {
        var data = IO.IN(shapes, true);
        byId('data').value = JSON.stringify(data);
    });
    /**
     * evento completar el grafico sobre el mapa
     */
    goo.event.addListener(drawingManager, 'overlaycomplete', function(e) {
        var shape = e.overlay;
        shape.type = e.type;
        goo.event.addListener(shape, 'click', function() {
            setSelection(this);
        });
        setSelection(shape);
        shapes.push(shape);
        var data = IO.IN(shapes, true);
        byId('coordenadas').value = JSON.stringify(data);
    });
    var centerControlDiv = document.createElement('div');
    var centerControl = new CenterControl(centerControlDiv, mapa);
    centerControlDiv.index = 1;
    centerControlDiv.id = 'clear';
    mapa.controls[google.maps.ControlPosition.TOP_CENTER].push(centerControlDiv);

    function CenterControl(controlDiv, map) {

        var controlUI = document.createElement('div');
        controlUI.style.background = 'url(\'data:image/jpg;base64,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AFBnUEMAAAAATGVmdFVudEYjUmx0AAAAAAAAAAAAAAAAVG9wIFVudEYjUmx0AAAAAAAAAAAAAAAAU2NsIFVudEYjUHJjQFkAAAAAAAAAAAAQY3JvcFdoZW5QcmludGluZ2Jvb2wAAAAADmNyb3BSZWN0Qm90dG9tbG9uZwAAAAAAAAAMY3JvcFJlY3RMZWZ0bG9uZwAAAAAAAAANY3JvcFJlY3RSaWdodGxvbmcAAAAAAAAAC2Nyb3BSZWN0VG9wbG9uZwAAAAAAOEJJTQPtAAAAAAAQAEgAAAABAAIASAAAAAEAAjhCSU0EJgAAAAAADgAAAAAAAAAAAAA/gAAAOEJJTQQNAAAAAAAEAAAAHjhCSU0EGQAAAAAABAAAAB44QklNA/MAAAAAAAkAAAAAAAAAAAEAOEJJTScQAAAAAAAKAAEAAAAAAAAAAjhCSU0D9QAAAAAASAAvZmYAAQBsZmYABgAAAAAAAQAvZmYAAQChmZoABgAAAAAAAQAyAAAAAQBaAAAABgAAAAAAAQA1AAAAAQAtAAAABgAAAAAAAThCSU0D+AAAAAAAcAAA/////////////////////////////wPoAAAAAP////////////////////////////8D6AAAAAD/////////////////////////////A+gAAAAA/////////////////////////////wPoAAA4QklNBAgAAAAAABAAAAABAAACQAAAAkAAAAAAOEJJTQQeAAAAAAAEAAAAADhCSU0EGgAAAAADSQAAAAYAAAAAAAAAAAAAABUAAAAWAAAACgBfADMAMQA4AC0AMQAwADIAMAA5AAAAAQAAAAAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAWAAAAFQAAAAAAAAAAAAAAAAAAAAABAAAAAAAAAAAAAAAAAAAAAAAAABAAAAABAAAAAAAAbnVsbAAAAAIAAAAGYm91bmRzT2JqYwAAAAEAAAAAAABSY3QxAAAABAAAAABUb3AgbG9uZwAAAAAAAAAATGVmdGxvbmcAAAAAAAAAAEJ0b21sb25nAAAAFQAAAABSZ2h0bG9uZwAAABYAAAAGc2xpY2VzVmxMcwAAAAFPYmpjAAAAAQAAAAAABXNsaWNlAAAAEgAAAAdzbGljZUlEbG9uZwAAAAAAAAAHZ3JvdXBJ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b3JnLzE5OTkvMDIvMjItcmRmLXN5bnRheC1ucyMiPiA8cmRmOkRlc2NyaXB0aW9uIHJkZjphYm91dD0iIiB4bWxuczp4bXA9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC8iIHhtbG5zOmRjPSJodHRwOi8vcHVybC5vcmcvZGMvZWxlbWVudHMvMS4xLyIgeG1sbnM6cGhvdG9zaG9wPSJodHRwOi8vbnMuYWRvYmUuY29tL3Bob3Rvc2hvcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RFdnQ9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZUV2ZW50IyIgeG1wOkNyZWF0b3JUb29sPSJBZG9iZSBQaG90b3Nob3AgQ1M2IChXaW5kb3dzKSIgeG1wOkNyZWF0ZURhdGU9IjIwMTUtMDMtMjNUMTY6MTQ6NTYtMDU6MDAiIHhtcDpNb2RpZnlEYXRlPSIyMDE1LTAzLTIzVDE2OjI5OjE0LTA1OjAwIiB4bXA6TWV0YWRhdGFEYXRlPSIyMDE1LTAzLTIzVDE2OjI5OjE0LTA1OjAwIiBkYzpmb3JtYXQ9ImltYWdlL2pwZWciIHBob3Rvc2hvcDpDb2xvck1vZGU9IjMiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6NzhBMTNFQTdBM0QxRTQxMUFCRjBGNEQyNUM2RjdFRUQiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6NzhBMTNFQTdBM0QxRTQxMUFCRjBGNEQyNUM2RjdFRUQiIHhtcE1NOk9yaWdpbmFsRG9jdW1lbnRJRD0ieG1wLmRpZDo3OEExM0VBN0EzRDFFNDExQUJGMEY0RDI1QzZGN0VFRCI+IDx4bXBNTTpIaXN0b3J5PiA8cmRmOlNlcT4gPHJkZjpsaSBzdEV2dDphY3Rpb249ImNyZWF0ZWQiIHN0RXZ0Omluc3RhbmNlSUQ9InhtcC5paWQ6NzhBMTNFQTdBM0QxRTQxMUFCRjBGNEQyNUM2RjdFRUQiIHN0RXZ0OndoZW49IjIwMTUtMDMtMjNUMTY6MTQ6NTYtMDU6MDAiIHN0RXZ0OnNvZnR3YXJlQWdlbnQ9IkFkb2JlIFBob3Rvc2hvcCBDUzYgKFdpbmRvd3MpIi8+IDwvcmRmOlNlcT4gPC94bXBNTTpIaXN0b3J5PiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICAgICA8P3hwYWNrZXQgZW5kPSJ3Ij8+/+4ADkFkb2JlAGRAAAAAAf/bAIQAAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQEBAQICAgICAgICAgICAwMDAwMDAwMDAwEBAQEBAQEBAQEBAgIBAgIDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMD/8AAEQgAFQAWAwERAAIRAQMRAf/dAAQAA//EAaIAAAAGAgMBAAAAAAAAAAAAAAcIBgUECQMKAgEACwEAAAYDAQEBAAAAAAAAAAAABgUEAwcCCAEJAAoLEAACAQMEAQMDAgMDAwIGCXUBAgMEEQUSBiEHEyIACDEUQTIjFQlRQhZhJDMXUnGBGGKRJUOhsfAmNHIKGcHRNSfhUzaC8ZKiRFRzRUY3R2MoVVZXGrLC0uLyZIN0k4Rlo7PD0+MpOGbzdSo5OkhJSlhZWmdoaWp2d3h5eoWGh4iJipSVlpeYmZqkpaanqKmqtLW2t7i5usTFxsfIycrU1dbX2Nna5OXm5+jp6vT19vf4+foRAAIBAwIEBAMFBAQEBgYFbQECAxEEIRIFMQYAIhNBUQcyYRRxCEKBI5EVUqFiFjMJsSTB0UNy8BfhgjQlklMYY0TxorImNRlUNkVkJwpzg5NGdMLS4vJVZXVWN4SFo7PD0+PzKRqUpLTE1OT0laW1xdXl9ShHV2Y4doaWprbG1ub2Z3eHl6e3x9fn90hYaHiImKi4yNjo+DlJWWl5iZmpucnZ6fkqOkpaanqKmqq6ytrq+v/aAAwDAQACEQMRAD8AvG+W/wAufk3/ADHfkn2d/LB/lc9lZHozF9H5SlxP8wL+YbR4+qqJPj5XPU5FKLoXoLGplNvV+6O7twZDBVNNk8jT1dLBhKenqIoqmOqWSel917odf5fX8w7t6h7lq/5Zn8zPH4Prf+YLsDBTZLrjsPFRjGdO/PjqTEpUR0fd3R1dNFR0ce+Rj8fJNujayJDU0dRDU1NNTwxw5DH4f3Xurvffuvdf/9DYn/mB/wAvHuna3da/zPf5XVRg9ifPHaWIp6HufpvJ1CYbp3+YJ1Rh0gep6r7bpElpMdQdq0eOoli2vut3gmimjhpauoijjoq7Ge691ro/zfv5u/Sf8wDpHqHLZfqXsn4rdcfGDsjE7u7e7q3fhpNkfNXYHzM2NLS1ua+EHwYyFfS0GTwXcO3srQUsm+9+VFMcFtLEGirK2iav/hmMyPuvdDP0T/wqh7X7p/lR/OLuP/Qrtzb/AMyPhniul8lJIKDfmU6Q371R3J8kOtuj6LN/3kg3LFuLavcWE2xvSqV4avIGGuzFImZo4J6MV+Hx/uvdf//R3+D/ALH/AGFv+J49+69189//AIVl4P8Alg5z5c9LRd39ofMnrD5B0/Vs8m5a3oTofZPe/UeW2a+fyyYikqMZ2p8jvjniNvdjwZn7iSvqNv1eTSWl8UeSgjqfBJ7917qw3rqL+RB/0DPfICHq+t7P/wBke/uftOL5KZHa2Lwn+zqf7Md/pA65TZNb2dhaPL/wH/TT/pi/uzJjqWsr/wC438O+2jiqP7s/ue/de6//2Q==\')';
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
        });

    }
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
    IO.OUT(JSON.parse(byId('coordenadas').value), mapa_salida);
    setZoom(mapa_salida, points);
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

