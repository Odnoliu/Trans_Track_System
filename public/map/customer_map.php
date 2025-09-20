<?php
// 7 điểm cố định (5 Smart Locker, 2 Kho)
$points = [
  ['id' => 'locker-1', 'type' => 'locker', 'name' => 'Smart Locker GO! Cần Thơ', 'coords' => [105.782405, 10.013725], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-2', 'type' => 'locker', 'name' => 'Smart Locker Đại học Cần Thơ', 'coords' => [105.770782, 10.029144], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-3', 'type' => 'locker', 'name' => 'Smart Locker Sense City Cần Thơ', 'coords' => [105.785598, 10.034457], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-4', 'type' => 'locker', 'name' => 'Smart Locker Mega Market', 'coords' => [105.761449, 10.023039], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'locker-5', 'type' => 'locker', 'name' => 'Smart Locker Coop Mart', 'coords' => [105.770930, 10.054364], 'icon' => '../../images/smart_locker_point/locker.png'],
  ['id' => 'warehouse-1', 'type' => 'warehouse', 'name' => 'Hub Vệ tinh', 'coords' => [105.750637, 10.052864], 'icon' => '../../images/default_point/warehouse.png'],
  ['id' => 'warehouse-2', 'type' => 'warehouse', 'name' => 'Hub Chính', 'coords' => [105.783084, 10.013510], 'icon' => '../../images/default_point/warehouse.png'],
];

// Demo cảnh báo
$alerts = [
  ['id' => 'alert-2', 'type' => 'Traffic', 'name' => 'Khu vực ùn tắc giao thông', 'coords' => [105.779464, 10.046051], 'icon' => '../../images/traffic.png'],
  ['id' => 'alert-1', 'type' => 'Flood', 'name' => 'Khu vực ngập lụt', 'coords' => [105.773663, 10.051739], 'icon' => '../../images/flood.png'],
  ['id' => 'alert-1', 'type' => 'Flood', 'name' => 'Khu vực ngập lụt', 'coords' => [105.757084, 10.026777], 'icon' => '../../images/flood.png'],
  ['id' => 'alert-2', 'type' => 'Traffic', 'name' => 'Khu vực ùn tắc giao thông', 'coords' => [105.764714, 10.021395], 'icon' => '../../images/traffic.png'],
];

// Shipper xuất phát
$default_shipper = [105.750790, 10.053068];

// 2 điểm đến demo (image) + 2 smartlocker
$destinations = [
  ['id' => 'dest-img1', 'name' => 'Điểm giao hàng của mã đơn DH00001', 'coords' => [105.771733, 10.036914], 'icon' => '../../images/destination.png'],
  ['id' => 'dest-img2', 'name' => 'Điểm giao hàng của mã đơn DH00002', 'coords' => [105.767525, 10.045412], 'icon' => '../../images/destination.png'],
  ['id' => 'dest-locker1', 'name' => 'Giao tại SmartLocker 1 của mã đơn DH00003', 'coords' => $points[4]['coords'], 'icon' => $points[4]['icon'], 'image' => '../../images/full_smart_locker.jpg'],
  ['id' => 'dest-locker2', 'name' => 'Giao tại SmartLocker 2 của mã đơn DH00004', 'coords' => $points[1]['coords'], 'icon' => $points[1]['icon'], 'image' => '../../images/full_smart_locker.jpg'],
];
?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <title>Bản đồ giao hàng & cảnh báo</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://api.mapbox.com/mapbox-gl-js/v3.15.0/mapbox-gl.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@turf/turf@6/turf.min.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
  <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <style>
    #map {
      width: 100%;
      height: 100vh;
    }

    .marker {
      width: 36px;
      height: 36px;
      background-size: contain;
    }

    .marker-shipper {
      width: 48px;
      height: 48px;
      background-size: contain;
    }

    .distance-label {
      background: rgba(0, 0, 0, 0.7);
      color: white;
      padding: 4px 10px;
      border-radius: 4px;
      font-size: 14px;
    }
  </style>
</head>

<body>
  <div id="map"></div>
  <script>
    mapboxgl.accessToken = "pk.eyJ1IjoicHBodWNqcyIsImEiOiJjbTV5emdvNWUwbjhhMmpweXAybThmbmVhIn0.4PA9RDEf2HFu7jMuicJ1OQ";
    const map = new mapboxgl.Map({
      container: "map",
      style: "mapbox://styles/mapbox/streets-v11",
      center: [105.780142, 10.029895],
      zoom: 13
    });

    // Điểm cố định
    const points = <?php echo json_encode($points); ?>;
    points.forEach(pt => {
      const el = document.createElement("div");
      el.className = "marker";
      el.style.backgroundImage = `url('${pt.icon}')`;
      new mapboxgl.Marker(el).setLngLat(pt.coords)
        .addTo(map);

      new mapboxgl.Popup({
          offset: 25
        })
        .setLngLat(pt.coords)
        .setHTML(`<b>${pt.name}</b>`)
        .addTo(map);
    });

    // Cảnh báo
    const alerts = <?php echo json_encode($alerts); ?>;
    alerts.forEach(al => {
      const el = document.createElement("div");
      el.className = "marker";
      el.style.backgroundImage = `url('${al.icon}')`;
      new mapboxgl.Marker(el).setLngLat(al.coords).addTo(map);

      new mapboxgl.Popup({
          offset: 25
        })
        .setLngLat(al.coords)
        .setHTML(`<b>${al.name}</b><br>Loại: ${al.type}`)
        .addTo(map);
    });

    // Shipper
    const shipperEl = document.createElement("div");
    shipperEl.className = "marker-shipper";
    shipperEl.style.backgroundImage = "url('../../images/shipper.png')";
    new mapboxgl.Marker(shipperEl).setLngLat(<?php echo json_encode($default_shipper); ?>).addTo(map);

    new mapboxgl.Popup({
        offset: 25
      })
      .setLngLat(<?php echo json_encode($default_shipper); ?>)
      .setHTML("<b>Shipper xuất phát từ Hub Vệ tinh</b>")
      .addTo(map);

    // Destinations
    const destinations = <?php echo json_encode($destinations); ?>;
    destinations.forEach(dest => {
      const el = document.createElement("div");
      el.className = "marker";
      el.style.backgroundImage = `url('${dest.icon}')`;
      new mapboxgl.Marker(el).setLngLat(dest.coords).addTo(map);

      new mapboxgl.Popup({
          offset: 25
        })
        .setLngLat(dest.coords)
        .setHTML(`
      <div class="text-center">
        <h3 class="font-bold text-blue-600">${dest.name}</h3>
      </div>
    `)
        .addTo(map);
    });

    // Hàm vẽ tuyến đường
    async function drawRoute(start, end, routeId) {
      const query = await fetch(`https://api.mapbox.com/directions/v5/mapbox/driving/${start};${end}?geometries=geojson&alternatives=true&steps=true&access_token=${mapboxgl.accessToken}`);
      const json = await query.json();
      const routes = json.routes;

      if (!routes || routes.length === 0) return;

      // Vẽ tuyến chính
      const mainRoute = routes[0];
      addRouteLayer(`main-route-${routeId}`, mainRoute.geometry, "#3b82f6", 5);

      // Check cảnh báo
      let danger = false;
      alerts.forEach(al => {
        const pt = turf.point(al.coords);
        const line = turf.lineString(mainRoute.geometry.coordinates);
        if (turf.booleanPointOnLine(pt, line, {
            tolerance: 0.001
          })) danger = true;
      });

      // Nếu có cảnh báo => vẽ tuyến thay thế
      if (danger && routes[1]) {
        const altRoute = routes[1];
        addRouteLayer(`alt-route-${routeId}`, altRoute.geometry, "#f87171", 4, "[2,2]");

        Toastify({
          text: `⚠️ Tuyến chính đến "${end}" đi qua vùng cảnh báo. Click tuyến đỏ để chọn thay thế!`,
          duration: 6000,
          gravity: "top",
          position: "right",
          style: {
            background: "#ef4444"
          }
        }).showToast();

        // Cho phép click vào tuyến thay thế để highlight
        map.on("click", `alt-route-${routeId}`, () => {
          map.setPaintProperty(`alt-route-${routeId}`, "line-color", "#22c55e"); // xanh lá khi chọn
          map.setPaintProperty(`main-route-${routeId}`, "line-opacity", 0.3);
          Toastify({
            text: "✅ Bạn đã chọn tuyến thay thế!",
            duration: 4000,
            gravity: "top",
            position: "right",
            style: {
              background: "#16a34a"
            }
          }).showToast();
        });
      }
    }

    // Hàm add tuyến
    function addRouteLayer(id, geometry, color, width, dash = null) {
      if (map.getSource(id)) return;
      map.addSource(id, {
        type: "geojson",
        data: {
          type: "Feature",
          geometry
        }
      });
      map.addLayer({
        id,
        type: "line",
        source: id,
        paint: {
          "line-color": color,
          "line-width": width,
          "line-opacity": 0.8,
          ...(dash ? {
            "line-dasharray": [2, 2]
          } : {})
        }
      });
    }

    map.on("load", () => {
      // Vẽ tuyến từ shipper đến các điểm giao hàng
      destinations.forEach((dest, i) => {
        drawRoute(<?php echo json_encode($default_shipper); ?>, dest.coords, i);
      });
    });


    // Hàm add tuyến
    function addRouteLayer(id, geometry, color, width, dash = null) {
      if (map.getSource(id)) return;
      map.addSource(id, {
        type: "geojson",
        data: {
          type: "Feature",
          geometry
        }
      });
      map.addLayer({
        id,
        type: "line",
        source: id,
        paint: {
          "line-color": color,
          "line-width": width,
          "line-opacity": 0.8,
          ...(dash ? {
            "line-dasharray": [2, 2]
          } : {})
        }
      });
    }

    map.on("load", () => {
      // Vẽ tuyến từ shipper đến các điểm giao hàng
      destinations.forEach((dest, i) => {
        console.log(dest.coords)
        drawRoute(<?php echo json_encode($default_shipper); ?>, dest.coords);
      });
    });
  </script>
</body>

</html>