<?php
// Demo dữ liệu toạ độ (tất cả nằm trong khu vực TP Cần Thơ)
$orders = [
  1 => [105.770900, 10.015800],
  2 => [105.789000, 10.040500],
  3 => [105.800200, 10.025600],
  4 => [105.751898, 10.031262],
  5 => [105.770900, 10.015800],
];

// 7 điểm mặc định trong Cần Thơ (5 Smart Locker, 2 Kho)
$points = [
  // Smart Lockers
  ['id' => 'locker-1', 'type' => 'locker', 'name' => 'Smart Locker GO! Cần Thơ', 'coords' => [105.783924, 10.013610], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-2', 'type' => 'locker', 'name' => 'Smart Locker Đại học Cần Thơ', 'coords' => [105.770782, 10.029144], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-3', 'type' => 'locker', 'name' => 'Smart Locker Sense City Cần Thơ', 'coords' => [ 105.785598, 10.034457], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-4', 'type' => 'locker', 'name' => 'Smart Locker Mega Market', 'coords' => [105.761449, 10.023039], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-5', 'type' => 'locker', 'name' => 'Smart Locker Coop Mart', 'coords' => [105.770930, 10.054364], 'icon' => '../../images/smart_locker_point/locker.png'],
  // Warehouses
  // ['id' => 'warehouse-1', 'type' => 'warehouse', 'name' => 'Hub Vệ tinh', 'coords' => [105.750637, 10.052864], 'icon' => '../../images/default_point/warehouse.png'],
  // ['id' => 'warehouse-2', 'type' => 'warehouse', 'name' => 'Hub Chính', 'coords' => [105.783084, 10.013510], 'icon' => '../../images/default_point/warehouse.png'],
];

// Mặc định shipper ở kho 1
$default_shipper = [105.780142, 10.029895]; // warehouse-1

$order_id = (int)($_GET['order_id'] ?? 1);
$destination = $orders[$order_id] ?? $orders[1];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>LogiX - Bản đồ (Cần Thơ Demo)</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Mapbox -->
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <!-- Turf.js -->
  <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

  <style>
    #map {
      width: 100%;
      height: 100vh;
    }

    .marker-svg {
      width: 36px;
      height: 36px;
      background-size: contain;
      background-repeat: no-repeat;
    }

    .marker-shipper {
      width: 48px;
      height: 48px;
      background-size: contain;
    }

    .pulse {
      box-shadow: 0 0 0 rgba(220, 38, 38, 0.7);
      animation: pulse-ring 1.8s infinite ease-out;
      border-radius: 50%;
    }

    @keyframes pulse-ring {
      0% {
        box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.7);
      }

      70% {
        box-shadow: 0 0 0 12px rgba(220, 38, 38, 0);
      }

      100% {
        box-shadow: 0 0 0 0 rgba(220, 38, 38, 0);
      }
    }
  </style>
</head>

<body>
  <div id="map"></div>

  <script>
    mapboxgl.accessToken = "pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ"; // <-- thay bằng token thật

    // Khởi tạo bản đồ focus Cần Thơ
    const map = new mapboxgl.Map({
      container: "map",
      style: "mapbox://styles/mapbox/streets-v11",
      center: [105.780000, 10.030000],
      zoom: 13,
      maxBounds: [
        [105.65, 9.95], // Southwest
        [105.95, 10.15] // Northeast (giới hạn khu vực Cần Thơ)
      ]
    });

    // Hiển thị 7 điểm mặc định
    const points = <?php echo json_encode($points); ?>;
    points.forEach(pt => {
      const el = document.createElement("div");
      el.className = "marker-svg";
      el.style.backgroundImage = `url('${pt.icon}')`;

      // Nội dung popup
      let popupContent = `
    <div class="relative p-2 max-w-xs text-center">
      <h3 class="text-lg font-bold text-blue-600 mb-2 transition duration-300 ease-in-out hover:text-red-500 hover:scale-105 inline-block cursor-pointer">
        ${pt.name}
      </h3>
  `;


      // Nếu là Smart Locker thì thêm ảnh
      if (pt.type == "locker") {
        popupContent += `
      <img src="../../images/full_smart_locker.jpg" alt="${pt.name}" 
           class="rounded-xl shadow-md object-cover transition duration-300 hover:scale-105" />
    `;
      }

      popupContent += `</div>`;
      new mapboxgl.Marker(el)
        .setLngLat(pt.coords)
        .setPopup(new mapboxgl.Popup({
          offset: 25,
          closeButton: false
        }).setHTML(popupContent))
        .addTo(map);
    });
    const destinationel = document.createElement("div");
    // destinationel.className = "marker-svg";
    // destinationel.style.backgroundImage = "url('../../images/destination.png')";
    // new mapboxgl.Marker(destinationel)
    //   .setLngLat(<?php echo json_encode($destination); ?>)
    //   .setPopup(new mapboxgl.Popup().setHTML("<b>Điểm đến của đơn hàng #<?php echo $order_id; ?></b>"))
    // .addTo(map);
    // Marker shipper (ở Kho 1)
    // const shipperEl = document.createElement("div");
    // shipperEl.className = "marker-shipper";
    // shipperEl.style.backgroundImage = "url('../../images/shipper.png')";
    // new mapboxgl.Marker(shipperEl)
    //   .setLngLat(<?php echo json_encode($default_shipper); ?>)
    //   .setPopup(new mapboxgl.Popup().setHTML("<b>Shipper xuất phát từ Kho 1</b>"))
    //   .addTo(map);
    // console.log(<?php echo json_encode($default_shipper); ?>);
    // Vẽ tuyến đường shipper -> order
    // const start = <?php echo json_encode($default_shipper); ?>;
    // const end = <?php echo json_encode($destination); ?>;

    // async function getRoute(start, end) {
    //   const query = await fetch(
    //     `https://api.mapbox.com/directions/v5/mapbox/driving/${start[0]},${start[1]};${end[0]},${end[1]}?geometries=geojson&access_token=${mapboxgl.accessToken}`
    //   );
    //   const json = await query.json();
    //   const data = json.routes[0];
    //   const route = data.geometry;

    //   // Thêm route chính
    //   map.addSource("route", {
    //     "type": "geojson",
    //     "data": {
    //       "type": "Feature",
    //       "geometry": route
    //     }
    //   });

    //   map.addLayer({
    //     "id": "route",
    //     "type": "line",
    //     "source": "route",
    //     "layout": {
    //       "line-join": "round",
    //       "line-cap": "round"
    //     },
    //     "paint": {
    //       "line-color": "#3b82f6",
    //       "line-width": 5
    //     }
    //   });

      // Check route với alerts
      //   await fetch("../../data/alerts.json")
      //     .then(res => res.json())
      //     .then(alerts => {
      //       alerts.forEach(alert => {
      //         // Marker cảnh báo
      //         const alertEl = document.createElement("div");
      //         alertEl.className = "marker-svg pulse animate__animated animate__bounce";
      //         alertEl.style.backgroundImage = `url('../../images/${alert.type}.png')`;

      //         new mapboxgl.Marker(alertEl)
      //           .setLngLat([alert.lng, alert.lat])
      //           .setPopup(new mapboxgl.Popup().setHTML(`<b>${alert.title}</b><br>${alert.description}`))
      //           .addTo(map);

      //         // Nếu route đi qua cảnh báo -> highlight đoạn đường
      //         const point = turf.point([alert.lng, alert.lat]);
      //         const line = turf.lineString(route.coordinates);
      //         const dist = turf.pointToLineDistance(point, line, { units: "kilometers" });

      //         if (dist < 0.3) { // khoảng cách nhỏ hơn 300m coi như ảnh hưởng
      //           map.addLayer({
      //             "id": "route-alert-" + alert.id,
      //             "type": "line",
      //             "source": {
      //               "type": "geojson",
      //               "data": {
      //                 "type": "Feature",
      //                 "geometry": route
      //               }
      //             },
      //             "layout": { "line-join": "round", "line-cap": "round" },
      //             "paint": { "line-color": "#dc2626", "line-width": 6, "line-dasharray": [2,2] }
      //           });
      //         }
      //       });
      //     });
    // }

    // getRoute(start, end);
  </script>
</body>

</html>
<style>
  img {
    width: 200px;
    height: auto;
  }
</style>