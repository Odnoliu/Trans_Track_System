/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./public/**/*.php",  // Quét file PHP trong public
    "./public/**/*.html"  // Nếu có file HTML
  ],
  theme: {
    extend: {
      // Bạn có thể thêm tùy chỉnh theme ở đây sau này, ví dụ: màu sắc riêng
    },
  },
  plugins: [],
}