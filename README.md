# Trans Track System

Hệ thống theo dõi vận chuyển đơn giản sử dụng PHP cho backend và TailwindCSS cho giao diện.

## Cấu trúc dự án
- `public/`: Thư mục chứa file PHP/HTML công khai.
- `css/`: File CSS cho Project.
- `js/`: File JavaScript.

## Cài đặt và chạy
1. Clone repository:
git clone https://github.com/Odnoliu/Trans_Track_System
cd Trans_Track_System

2. Cài đặt dependencies:
npm install

3. Chạy server PHP:
php -S localhost:8000 -t public

4. Truy cập: http://localhost:8000

Lưu ý: Tạo file php mới thì anh em nhớ thêm dòng:
<script src="https://cdn.tailwindcss.com"></script>
-> thêm cdn của tailwindcss trên mỗi file php để có thể dùng tailwindcss nhé