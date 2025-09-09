# Trans Track System

Hệ thống theo dõi vận chuyển đơn giản sử dụng PHP cho backend và TailwindCSS cho giao diện.

## Cấu trúc dự án
- `public/`: Thư mục chứa file PHP/HTML công khai.
- `css/`: File CSS từ Tailwind.
- `js/`: File JavaScript.
- `tailwind.config.js`: Cấu hình TailwindCSS.

## Cài đặt và chạy
1. Clone repository:
-> git clone https://github.com/Odnoliu/Trans_Track_System
-> cd Trans_Track_System

2. Cài đặt dependencies:
-> npm install

3. Build CSS:
Lưu ý: Copy folder css trong thư mục public đem ra ngoài cùng cấp với public thì mới chạy câu lệnh bên dưới được =))))

-> npm run build-css

4. Chạy server PHP:
-> php -S localhost:8000 -t public

5. Truy cập: http://localhost:8000

