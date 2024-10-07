$(function () {
    $('input[name="search"]').mask('99999');

    $('input[name="search"]').bind('input propertychange', function () {
        let $searhText = $(this).val();
        if ($searhText.length > 0) {
            $('#search-button').removeClass('btn_disabled').addClass('btn-green');
        } else {
            $('#search-button').removeClass('btn-green').addClass('btn_disabled');
        }
    });

    $('#search-button').click(function (e) {
        e.preventDefault();

        let $searchAddress = $('input[name="search"]').val();
        let $url           = $(this).data('url');
        let $searchForm    = $('.search-form');

        new google.maps.Geocoder().geocode({
            "address": $searchAddress
        }, function (results) {
            if (results !== null) {
                const lat = results[0].geometry.location.lat();
                const lng = results[0].geometry.location.lng();
                const isWithinPerimeterOfI285 = Polygon(lat, lng)

                calculateDelivery($url, $searchForm, $searchAddress, isWithinPerimeterOfI285);
            } else {
                calculateDelivery($url, $searchForm, $searchAddress, false);
            }

        });
    })

    function calculateDelivery($url, $searchForm, $searchAddress, isWithinPerimeterOfI285) {
        $.ajax({
            url    : $url,
            type   : 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data   : {
                search_address: $searchAddress,
                is_within_perimeter_of_i_285: isWithinPerimeterOfI285,
            },
            success: function (response) {
                if (response.status === 'success') {
                    $searchForm.find('.error-text').text('');
                    $searchForm.find('.input-wrapper').removeClass('error');
                    $searchForm.removeClass('error');

                    let resText = (response.data.delivery_fees !== null)
                        ? '$' + response.data.delivery_fees
                        : "ZIP not found";

                    $searchForm.find('.res-text').show().find('span').text(resText);
                    $searchForm.find('.input-wrapper').addClass('res');
                    $searchForm.addClass('res');
                }
            },
            error  : function (response) {
                let errorMessage = $.parseJSON(response.responseText).message;

                $searchForm.find('.res-text').hide().find('span').text('');
                $searchForm.find('.input-wrapper').removeClass('res');
                $searchForm.removeClass('res');

                $searchForm.find('.error-text').text(errorMessage);
                $searchForm.find('.input-wrapper').addClass('error');
                $searchForm.addClass('error');
            }
        });

    }


    $('.calear-form').click(function () {
        $('#search-button').removeClass('btn-green').addClass('btn_disabled');
        let $searchForm = $(this).closest('.search-form');

        $searchForm.find('.error-text').text('');
        $searchForm.find('.res-text').hide().find('span').text('');
        $searchForm.find('.input-wrapper').removeClass('error', 'res');
        $searchForm.removeClass('error', 'res');
    });

    $('.location-info-buttons').find('a').click(function (e) {
        e.preventDefault();

        $('.location-info-buttons').find('a').removeClass('active');
        $('.locations').removeClass('active');

        $(this).addClass('active');
        $('.' + $(this).attr('href')).addClass('active');
    });

    if (!google.maps.Polygon.prototype.getBounds) {
        google.maps.Polygon.prototype.getBounds = function (latLng) {
            var bounds = new google.maps.LatLngBounds(),
                paths = this.getPaths(),
                path,
                p, i;

            for (p = 0; p < paths.getLength(); p++) {
                path = paths.getAt(p);
                for (i = 0; i < path.getLength(); i++) {
                    bounds.extend(path.getAt(i));
                }
            }

            return bounds;
        };
    }

    google.maps.Polygon.prototype.containsLatLng = function (latLng) {
        var inPoly = false,
            bounds, lat, lng,
            numPaths, p, path, numPoints,
            i, j, vertex1, vertex2;

        if (arguments.length == 2) {
            if (
                typeof arguments[0] == "number" &&
                typeof arguments[1] == "number"
            ) {
                lat = arguments[0];
                lng = arguments[1];
            }
        } else if (arguments.length == 1) {
            bounds = this.getBounds();

            if (!bounds && !bounds.contains(latLng)) {
                return false;
            }
            lat = latLng.lat();
            lng = latLng.lng();
        } else {
            console.log("Wrong number of inputs in google.maps.Polygon.prototype.contains.LatLng");
        }

        // Raycast point in polygon method

        numPaths = this.getPaths().getLength();
        for (p = 0; p < numPaths; p++) {
            path = this.getPaths().getAt(p);
            numPoints = path.getLength();
            j = numPoints - 1;

            for (i = 0; i < numPoints; i++) {
                vertex1 = path.getAt(i);
                vertex2 = path.getAt(j);

                if (
                    vertex1.lng() < lng &&
                    vertex2.lng() >= lng ||
                    vertex2.lng() < lng &&
                    vertex1.lng() >= lng
                ) {
                    if (
                        vertex1.lat() +
                        (lng - vertex1.lng()) /
                        (vertex2.lng() - vertex1.lng()) *
                        (vertex2.lat() - vertex1.lat()) <
                        lat
                    ) {
                        inPoly = !inPoly;
                    }
                }

                j = i;
            }
        }

        return inPoly;
    };

    function Polygon(lat, lng) {
        // Define the LatLng coordinates for the polygon's path.
        const triangleCoords = [
            new google.maps.LatLng(33.670818, -84.335508),
            new google.maps.LatLng(33.664532, -84.351987),
            new google.maps.LatLng(33.659674, -84.360227),
            new google.maps.LatLng(33.656531, -84.364690),
            new google.maps.LatLng(33.645957, -84.369497),
            new google.maps.LatLng(33.639954, -84.378080),
            new google.maps.LatLng(33.634809, -84.382886),
            new google.maps.LatLng(33.631665, -84.390439),
            new google.maps.LatLng(33.632808, -84.400396),
            new google.maps.LatLng(33.632808, -84.408635),
            new google.maps.LatLng(33.629664, -84.415502),
            new google.maps.LatLng(33.623375, -84.425115),
            new google.maps.LatLng(33.618229, -84.443998),
            new google.maps.LatLng(33.620516, -84.456357),
            new google.maps.LatLng(33.619658, -84.474897),
            new google.maps.LatLng(33.619658, -84.483137),
            new google.maps.LatLng(33.619658, -84.486913),
            new google.maps.LatLng(33.634524, -84.492063),
            new google.maps.LatLng(33.645099, -84.497213),
            new google.maps.LatLng(33.689960, -84.500989),
            new google.maps.LatLng(33.707383, -84.497556),
            new google.maps.LatLng(33.726802, -84.502363),
            new google.maps.LatLng(33.753353, -84.495496),
            new google.maps.LatLng(33.765056, -84.492750),
            new google.maps.LatLng(33.784462, -84.495839),
            new google.maps.LatLng(33.797016, -84.486913),
            new google.maps.LatLng(33.809569, -84.497213),
            new google.maps.LatLng(33.818126, -84.495839),
            new google.maps.LatLng(33.828679, -84.486913),
            new google.maps.LatLng(33.844934, -84.487256),
            new google.maps.LatLng(33.885130, -84.471464),
            new google.maps.LatLng(33.892825, -84.453954),
            new google.maps.LatLng(33.900805, -84.445028),
            new google.maps.LatLng(33.905364, -84.433011),
            new google.maps.LatLng(33.915906, -84.420308),
            new google.maps.LatLng(33.916761, -84.408635),
            new google.maps.LatLng(33.915621, -84.397649),
            new google.maps.LatLng(33.913057, -84.381856),
            new google.maps.LatLng(33.911917, -84.362974),
            new google.maps.LatLng(33.913627, -84.350957),
            new google.maps.LatLng(33.921034, -84.326581),
            new google.maps.LatLng(33.921034, -84.306669),
            new google.maps.LatLng(33.919610, -84.292249),
            new google.maps.LatLng(33.909923, -84.281949),
            new google.maps.LatLng(33.901375, -84.273710),
            new google.maps.LatLng(33.893110, -84.258947),
            new google.maps.LatLng(33.882565, -84.249334),
            new google.maps.LatLng(33.871449, -84.249334),
            new google.maps.LatLng(33.852063, -84.246244),
            new google.maps.LatLng(33.829535, -84.252080),
            new google.maps.LatLng(33.780182, -84.245214),
            new google.maps.LatLng(33.771050, -84.233541),
            new google.maps.LatLng(33.754210, -84.232511),
            new google.maps.LatLng(33.728516, -84.231138),
            new google.maps.LatLng(33.714809, -84.241094),
            new google.maps.LatLng(33.699672, -84.255170),
            new google.maps.LatLng(33.697958, -84.275426),
            new google.maps.LatLng(33.694245, -84.290189),
            new google.maps.LatLng(33.689960, -84.301175),
            new google.maps.LatLng(33.683961, -84.310789),
            new google.maps.LatLng(33.677676, -84.319028),
            new google.maps.LatLng(33.671390, -84.334821)
        ];
        // Construct the polygon.
        const polygon = new google.maps.Polygon({
            paths: triangleCoords,
            strokeColor: "#FF0000",
            strokeOpacity: 0.8,
            strokeWeight: 2,
            fillColor: "#FF0000",
            fillOpacity: 0.35,
        });

        const coordinate = new google.maps.LatLng(lat, lng)

        return polygon.containsLatLng(coordinate);
    }
});
