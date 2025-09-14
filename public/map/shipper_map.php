<?php
// Demo dữ liệu toạ độ từ order_id
$orders = [
    1 => [106.700981, 10.776889], // HCM
    2 => [105.854444, 21.028511], // Hà Nội
    3 => [105.780000, 10.030000], // Cần Thơ
];

$order_id = $_GET['order_id'] ?? 1;
$destination = $orders[$order_id];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>LogiX - Bản đồ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.js"></script>
    <style>
        #map {
            width: 100%;
            height: 100vh;
        }
    </style>
</head>

<body class="bg-gray-100">

    <div id="map"></div>

    <script>
        mapboxgl.accessToken = "pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ"; // <-- thay bằng token thật

        // Khởi tạo bản đồ
        const map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [<?= $destination[0] ?>, <?= $destination[1] ?>],
            zoom: 6
        });

        // Lấy vị trí hiện tại của người dùng
        navigator.geolocation.getCurrentPosition(successLocation, errorLocation, {
            enableHighAccuracy: true
        });

        function successLocation(position) {
            const userCoords = [position.coords.longitude, position.coords.latitude];
            const orderCoords = [<?= $destination[0] ?>, <?= $destination[1] ?>];

            // Marker cho user
            new mapboxgl.Marker({
                    color: "green"
                })
                .setLngLat(orderCoords)
                .setPopup(new mapboxgl.Popup().setHTML("<b>Điểm đến của đơn hàng</b>"))
                .addTo(map);

            // Marker cho shipper (ảnh)
            const el = document.createElement('div');
            el.className = 'shipper-marker';
            el.style.backgroundImage = "url('images/shipper.jpg')";
            el.style.width = "40px";
            el.style.height = "40px";
            el.style.backgroundSize = "cover";

            new mapboxgl.Marker(el)
                .setLngLat(userCoords)
                .setPopup(new mapboxgl.Popup().setHTML("<b>Vị trí của shipper</b>"))
                .addTo(map);

            // Vẽ tuyến đường
            getRoute(userCoords, orderCoords);
        }

        function errorLocation() {
            alert("Không thể lấy vị trí hiện tại!");
        }

        // Hàm lấy route từ Mapbox Directions API
        async function getRoute(start, end) {
            const query = await fetch(
                `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`
            );
            const json = await query.json();
            const data = json.routes[0];
            const route = data.geometry.coordinates;

            map.addSource('route', {
                'type': 'geojson',
                'data': {
                    'type': 'Feature',
                    'properties': {},
                    'geometry': {
                        'type': 'LineString',
                        'coordinates': route
                    }
                }
            });

            map.addLayer({
                'id': 'route',
                'type': 'line',
                'source': 'route',
                'layout': {
                    'line-join': 'round',
                    'line-cap': 'round'
                },
                'paint': {
                    'line-color': '#3b82f6',
                    'line-width': 5
                }
            });
        }
    </script>
</body>

</html>