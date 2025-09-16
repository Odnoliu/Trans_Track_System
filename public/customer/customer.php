<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Khách hàng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
</head>
<body class="bg-gradient-to-br from-blue-50 to-green-50 min-h-screen flex flex-col items-center">
    <?php include("../navbar.php"); ?>
    <h1 class="text-4xl font-bold text-blue-700 mb-8 animate-pulse">Theo dõi vận đơn</h1>
    <div id="orders-container" class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 w-11/12 max-w-6xl mb-10">
        <p class="text-gray-600 text-center">Đang tải đơn hàng...</p>
    </div>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 w-11/12 max-w-6xl">
    </div>

    <script>
        let images = [
            "https://intriphat.com/wp-content/uploads/2023/03/hop-carton-dong-hang-3.jpg",
            "https://cafefcdn.com/203337114487263232/2024/10/26/464385008102238323746298706642100005426166399n-1729884014454670501745-1729884387387-17298843877621930862296-1729924046888-1729924047068427834891.jpg",
            "https://tuigoihang.com/resources/product/2023/1/10/tui-goi-hang-gia-re-mau-hong-1673362825.jpg",
            "https://get.pxhere.com/photo/box-carton-odyssey-product-design-packaging-and-labeling-package-delivery-221916.jpg",
            "https://hopcartondonghang.com/wp-content/uploads/2023/08/thung-carton-dung-sau-rieng-14.jpg"
        ];
        async function fetchOrders() {
            try {
                // Gọi API
                const response = await fetch("../api/orders.php");
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const data = await response.json();
                console.log("Orders từ API (fetch):", data);

                // Lấy container để render đơn hàng
                const container = document.getElementById("orders-container");
                console.log("Container đơn hàng:", container);
                // Kiểm tra dữ liệu từ API
                if (data.status !== "success" || !data.data) {
                    container.innerHTML = "<p class='text-red-500 text-center'>Lỗi: API không trả về dữ liệu hợp lệ!</p>";
                    return;
                }

                // Kiểm tra xem có đơn hàng nào không
                if (data.data.length === 0) {
                    container.innerHTML = "<p class='text-gray-600 text-center'>Không có đơn hàng nào để hiển thị.</p>";
                    return;
                }

                // Render từng đơn hàng
                container.innerHTML = ""; // Xóa nội dung cũ
                let i = 0;
                data.data.forEach(order => {

                    const div = document.createElement("div");
                    div.className = "bg-white rounded-2xl shadow-lg overflow-hidden transform transition duration-300 hover:scale-105 hover:shadow-2xl animate-fadeIn";
                    div.innerHTML = `
                        <img src="${images[i % images.length]}" alt="${name}" class="h-48 w-full object-cover">
                        <div class="p-5">
                            <p class="text-gray-600 mb-4">Mã đơn: #${order.id}</p>
                            <a href="map.php?order_id=${order.id}" class="inline-flex items-center bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg transition">
                                <i class="ti ti-eye mr-2"></i> Xem tiến độ
                            </a>
                        </div>
                    `;
                    container.appendChild(div);
                    i++;
                });
            } catch (error) {
                console.error("Lỗi khi lấy dữ liệu đơn hàng:", error);
                const container = document.getElementById("orders-container");
                container.innerHTML = `<p class='text-red-500 text-center'>Lỗi: ${error.message}</p>`;
            }
        }

        // Gọi hàm fetchOrders khi trang tải
        document.addEventListener("DOMContentLoaded", async () => {
            await fetchOrders();
        });
    </script>
</body>
</html>