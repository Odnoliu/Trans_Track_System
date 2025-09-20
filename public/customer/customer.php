<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Theo dõi vận đơn</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* custom animations */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(10px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .animate-fadeInUp {
      animation: fadeInUp .45s ease forwards;
    }

    /* simple toast */
    .toast {
      position: fixed;
      right: 1rem;
      bottom: 1rem;
      z-index: 60;
      min-width: 220px;
    }
  </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-blue-100 min-h-screen flex flex-col items-center pb-12">

  <?php include("../navbar.php"); ?>

  <main class="w-full max-w-6xl px-4">
    <header class="mt-8 mb-6 flex items-center justify-between">
      <h1 class="text-4xl font-extrabold text-blue-700 animate-pulse">Theo dõi vận đơn</h1>
      <div>
        <button id="refreshBtn" class="inline-flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded-lg shadow">
          ⟳ Làm mới
        </button>
      </div>
    </header>

    <section id="orders-container" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 mb-10">
      <!-- Cards sẽ được JS render vào đây -->
      <div class="col-span-full text-center text-gray-500" id="loader">
        Đang tải đơn hàng...
      </div>
    </section>

    <template id="order-card-template">
      <article class="bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl animate-fadeInUp">
        <div class="h-44 bg-gray-100 overflow-hidden">
          <img class="w-full h-full object-cover" alt="Ảnh đơn hàng">
        </div>
        <div class="p-5 flex flex-col gap-2">
          <div class="flex items-start justify-between">
            <div>
              <h2 class="text-lg font-semibold text-gray-800 order-id">Mã đơn: -</h2>
              <p class="text-sm text-gray-600 customer-name">Khách hàng: -</p>
              <p class="text-sm text-gray-600 order-status">Trạng thái: -</p>
            </div>
            <div class="text-right">
              <p class="text-sm text-gray-500">Số lượng</p>
              <p class="text-xl font-semibold qty">0</p>
            </div>
          </div>

          <div class="flex items-center gap-2 text-sm text-gray-700">
            <div class="px-3 py-1 rounded-md bg-blue-50 text-blue-700 font-medium total">0 đ</div>
            <a class="ml-auto text-blue-600 hover:underline map-link" href="#">Theo dõi đơn →</a>
          </div>

          <!-- Form chọn thời gian + địa điểm (inline) -->
          <div class="mt-3 grid gap-2">
            <!-- NEW: thay input bằng text -->
            <label class="text-sm font-medium text-gray-700">Thời gian giao dự kiến</label>
            <p class="time-fixed px-3 py-2 border rounded-xl bg-gray-50 text-gray-700 font-medium"></p>

            <label class="text-sm font-medium text-gray-700">Chọn địa điểm giao</label>
            <select class="place-select w-full px-3 py-2 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-300"></select>

            <div class="flex items-center gap-2 mt-3">
              <button class="confirm-btn flex-1 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white py-2 rounded-xl font-semibold shadow">Xác nhận giao hàng</button>
              <button class="btn-view-map text-gray-600 px-3 py-2 border rounded-xl hover:bg-gray-50">Bản đồ</button>
            </div>
          </div>
        </div>
      </article>
    </template>

  </main>

  <!-- toast -->
  <div id="toast" class="toast hidden"></div>

  <script>
    (() => {
      const apiUrl = "../api/orders.php";
      const confirmUrl = "../api/confirm_delivery.php";

      const lockers = [{
          id: "locker-1",
          label: "Smart Locker 1 - Đại học Cần Thơ"
        },
        {
          id: "locker-2",
          label: "Smart Locker 2 - Lotte Mart Cần Thơ"
        },
        {
          id: "locker-3",
          label: "Smart Locker 3 - Coopmart"
        },
        {
          id: "locker-4",
          label: "Smart Locker 4 - BigC"
        },
        {
          id: "locker-5",
          label: "Smart Locker 5 - Sense City"
        }
      ];

      const placeholderImages = [
        "https://intriphat.com/wp-content/uploads/2023/03/hop-carton-dong-hang-3.jpg",
        "https://cafefcdn.com/203337114487263232/2024/10/26/464385008102238323746298706642100005426166399n-1729884014454670501745-1729884387387-17298843877621930862296-1729924046888-1729924047068427834891.jpg",
        "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSPk6yitzvHNEhbC1WIJWiW6XowOBgHxBNHGA&s",
        "https://get.pxhere.com/photo/box-carton-odyssey-product-design-packaging-and-labeling-package-delivery-221916.jpg",
        "https://hopcartondonghang.com/wp-content/uploads/2023/08/thung-carton-dung-sau-rieng-14.jpg"
      ];

      const ordersContainer = document.getElementById("orders-container");
      const loader = document.getElementById("loader");
      const template = document.getElementById("order-card-template");
      const refreshBtn = document.getElementById("refreshBtn");
      const toastEl = document.getElementById("toast");

      function showToast(msg, type = "info") {
        toastEl.className = "toast fixed right-4 bottom-4 z-50";
        toastEl.innerHTML = `<div class="px-4 py-2 rounded-lg shadow-lg text-white ${type === 'success' ? 'bg-green-600' : type === 'error' ? 'bg-red-600' : 'bg-blue-600'}">${msg}</div>`;
        toastEl.classList.remove('hidden');
        clearTimeout(toastEl._t);
        toastEl._t = setTimeout(() => {
          toastEl.classList.add('hidden');
        }, 3000);
      }

      function safeText(node, text) {
        node.textContent = text ?? "";
      }

      function makeImageSrc() {
        return placeholderImages[Math.floor(Math.random() * placeholderImages.length)];
      }

      async function fetchOrders() {
        loader && (loader.style.display = "block");
        try {
          const res = await fetch(apiUrl, {
            cache: "no-cache"
          });
          if (!res.ok) throw new Error(`HTTP ${res.status}`);
          const json = await res.json();
          if (json.status !== "success" || !Array.isArray(json.data)) {
            ordersContainer.innerHTML = `<div class="col-span-full text-red-600 text-center">Lỗi: API không trả về dữ liệu hợp lệ.</div>`;
            return;
          }
          renderOrders(json.data);
        } catch (err) {
          console.error(err);
          ordersContainer.innerHTML = `<div class="col-span-full text-red-600 text-center">Lỗi khi tải đơn hàng: ${err.message}</div>`;
        } finally {
          loader && (loader.style.display = "none");
        }
      }

      function getStatusConfig(statusCode) {
        const statusConfigs = {
          'TT001': {
            label: 'Đang Chờ Xử Lý',
            btnText: 'Xác nhận giao hàng',
            btnClass: 'bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700',
            enabled: true
          },
          'TT002': {
            label: 'Đang Giao Hàng',
            btnText: 'Đang giao',
            btnClass: 'bg-gradient-to-r from-yellow-500 to-yellow-600',
            enabled: false
          },
          'TT003': {
            label: 'Đã Giao Hàng',
            btnText: 'Đã giao',
            btnClass: 'bg-gradient-to-r from-green-500 to-green-600',
            enabled: false
          },
          'TT004': {
            label: 'Đã Nhận Hàng',
            btnText: 'Đã nhận',
            btnClass: 'bg-gradient-to-r from-green-600 to-green-700',
            enabled: false
          },
          'TT005': {
            label: 'Đã Hủy',
            btnText: 'Đã hủy',
            btnClass: 'bg-gradient-to-r from-red-500 to-red-600',
            enabled: false
          },
          'TT006': {
            label: 'Trả Hàng',
            btnText: 'Đã trả',
            btnClass: 'bg-gradient-to-r from-red-600 to-red-700',
            enabled: false
          },
          'TT007': {
            label: 'Đang Giao Hàng Chậm',
            btnText: 'Giao chậm',
            btnClass: 'bg-gradient-to-r from-orange-500 to-orange-600',
            enabled: false
          }
        };
        return statusConfigs[statusCode] || {
          label: 'Không xác định',
          btnText: 'Không xác định',
          btnClass: 'bg-gradient-to-r from-gray-500 to-gray-600',
          enabled: false
        };
      }

      function randomTimeToday() {
        const now = new Date();
        const start = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 8, 0); // 8h sáng
        const end = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 20, 0); // 20h tối
        const rand = new Date(start.getTime() + Math.random() * (end.getTime() - start.getTime()));
        return rand.toTimeString().slice(0, 5); // dạng "HH:MM"
      }

      function renderOrders(orders) {
        ordersContainer.innerHTML = "";
        if (!orders.length) {
          ordersContainer.innerHTML = `<div class="col-span-full text-gray-600 text-center">Không có đơn hàng để hiển thị.</div>`;
          return;
        }

        orders.forEach((order, idx) => {
          if (order.TT_Ma === 'TT004') return; // Skip delivered orders
          const clone = template.content.cloneNode(true);
          const article = clone.querySelector("article");
          const imgEl = clone.querySelector("img");
          const orderIdEl = clone.querySelector(".order-id");
          const customerNameEl = clone.querySelector(".customer-name");
          const statusEl = clone.querySelector(".order-status");
          const qtyEl = clone.querySelector(".qty");
          const totalEl = clone.querySelector(".total");
          const mapLinkEl = clone.querySelector(".map-link");
          const timeInput = clone.querySelector(".time-input");
          const placeSelect = clone.querySelector(".place-select");
          const confirmBtn = clone.querySelector(".confirm-btn");
          const viewMapBtn = clone.querySelector(".btn-view-map");

          // fill content safely
          const DH_Ma = order.DH_Ma ?? order.id ?? ("unknown-" + idx);
          imgEl.src = makeImageSrc();
          imgEl.alt = `Đơn ${DH_Ma}`;
          safeText(orderIdEl, `Mã đơn: ${DH_Ma}`);
          safeText(customerNameEl, `Khách hàng: ${order.KH_Ten ?? 'Ẩn danh'}`);
          safeText(qtyEl, `${order.DH_SoLuongKIH ?? 0}`);
          const totalFormatted = order.DH_TongTien ? new Intl.NumberFormat('vi-VN').format(order.DH_TongTien) + ' đ' : '0 đ';
          safeText(totalEl, totalFormatted);

          // status handling
          const statusConfig = getStatusConfig(order.TT_Ma);
          safeText(statusEl, `Trạng thái: ${statusConfig.label}`);
          confirmBtn.textContent = statusConfig.btnText;
          confirmBtn.className = `confirm-btn flex-1 ${statusConfig.btnClass} text-white py-2 rounded-xl font-semibold shadow`;
          confirmBtn.disabled = !statusConfig.enabled;

          // map link
          mapLinkEl.href = `/map/customer_map.php?order_id=${encodeURIComponent(DH_Ma)}`;
          viewMapBtn.addEventListener('click', () => {
            window.location.href = `/map/customer_map.php?order_id=${encodeURIComponent(DH_Ma)}`;
          });

          // populate placeSelect: lockers + default address (from order)
          placeSelect.innerHTML = "";
          lockers.forEach(l => {
            const opt = document.createElement("option");
            opt.value = l.id;
            opt.textContent = l.label;
            placeSelect.appendChild(opt);
          });
          const addrText = (order.DC_SoNha ? order.DC_SoNha : '');
          if (addrText.trim()) {
            const opt = document.createElement("option");
            opt.value = order.DC_ToaDo ?? "user-default";
            opt.textContent = `Địa chỉ mặc định: ${addrText}`;
            placeSelect.appendChild(opt);
          }
          const timeEl = clone.querySelector(".time-fixed"); // NEW
          const fixedTime = randomTimeToday(); // NEW
          safeText(timeEl, fixedTime); // NEW
          // confirm button handler
          confirmBtn.addEventListener('click', async () => {
            if (!statusConfig.enabled) return; // Prevent action if button is disable
            const time = fixedTime;
            const place = placeSelect.value;
            if (!time) {
              showToast("Vui lòng chọn thời gian giao.", "error");
              return;
            }
            confirmBtn.disabled = true;
            confirmBtn.textContent = "Đơn hàng của bạn đang được vận chuyển...";
            try {
              const payload = {
                DH_Ma: DH_Ma,
                delivery_time: time,
                delivery_place: place,
                TT_Ma: "TT002"
              };
              const r = await fetch(confirmUrl, {
                method: "POST",
                headers: {
                  "Content-Type": "application/json"
                },
                body: JSON.stringify(payload),
                credentials: "same-origin"
              });
              if (!r.ok) throw new Error(`Status ${r.status}`);
              showToast("Yêu cầu xác nhận đã gửi.", "success");
              confirmBtn.textContent = "Xác nhận giao hàng";
            } catch (err) {
              console.error(err);
              showToast("Gửi thất bại: " + err.message, "error");
              confirmBtn.textContent = "Thử lại";
            } finally {
              confirmBtn.disabled = false;
            }
          });

          ordersContainer.appendChild(clone);
        });
      }

      refreshBtn.addEventListener('click', () => {
        fetchOrders();
      });

      document.addEventListener('DOMContentLoaded', fetchOrders);
    })();
  </script>
</body>

</html>