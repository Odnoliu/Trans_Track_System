CREATE DATABASE IF NOT EXISTS logistics_db;
ALTER DATABASE logistics_db 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

USE logistics_db;

DROP TABLE IF EXISTS kienhang;
DROP TABLE IF EXISTS donhang;
DROP TABLE IF EXISTS kho;
DROP TABLE IF EXISTS trangthai;
DROP TABLE IF EXISTS nhanviengiaohang;
DROP TABLE IF EXISTS phuongtien;
DROP TABLE IF EXISTS nhacungcap;
DROP TABLE IF EXISTS diachi;
DROP TABLE IF EXISTS phuong;
DROP TABLE IF EXISTS khachhang;
DROP TABLE IF EXISTS taikhoan;
DROP TABLE IF EXISTS vaitro;

CREATE TABLE vaitro (
    VT_Ma CHAR(5) PRIMARY KEY,
    VT_Ten VARCHAR(50) NOT NULL UNIQUE
)ENGINE=InnoDB;

INSERT INTO vaitro (VT_Ma, VT_Ten) VALUES
('VT001', 'Admin'),
('VT002', 'Nhân Viên Giao Hàng'),
('VT003', 'Khách Hàng'),
('VT004', 'Nhà Cung Cấp');


CREATE TABLE taikhoan (
    TK_ID INT AUTO_INCREMENT PRIMARY KEY,
    TK_TenDangNhap VARCHAR(50) NOT NULL UNIQUE,
    TK_MatKhau VARCHAR(16) NOT NULL,
    VT_Ma CHAR(5) NOT NULL,
    FOREIGN KEY (VT_Ma) REFERENCES vaitro(VT_Ma)
)ENGINE=InnoDB;

INSERT INTO taikhoan (TK_TenDangNhap, TK_MatKhau, VT_Ma) VALUES
('admin', 'admin123', 'VT001'),     
('nvgh1', 'nvgh123', 'VT002'),      
('nvgh2', 'nvgh123', 'VT002'),      
('nvgh3', 'nvgh123', 'VT002'),      
('khachhang1', 'kh123', 'VT003'),   
('khachhang2', 'kh123', 'VT003'),   
('khachhang3', 'kh123', 'VT003'),   
('khachhang4', 'kh123', 'VT003'),   
('khachhang5', 'kh123', 'VT003'),   
('khachhang6', 'kh123', 'VT003'),   
('khachhang7', 'kh123', 'VT003'),   
('khachhang8', 'kh123', 'VT003'),   
('nhacungcap1', 'ncc123', 'VT004'), 
('nhacungcap2', 'ncc123', 'VT004'), 
('nhacungcap3', 'ncc123', 'VT004'); 

CREATE TABLE khachhang (
    KH_ID INT AUTO_INCREMENT PRIMARY KEY,
    KH_Ten VARCHAR(50) NOT NULL,
    KH_SDT VARCHAR(12) NOT NULL UNIQUE,
    KH_Email VARCHAR(100) NOT NULL UNIQUE,
    TK_ID INT DEFAULT NULL,
    FOREIGN KEY (TK_ID) REFERENCES taikhoan(TK_ID)
)ENGINE=InnoDB;

INSERT INTO khachhang (KH_Ten, KH_SDT, KH_Email, TK_ID) VALUES
('Nguyễn Hoàng Phúc', '0949445708', 'yasuohasagi369@gmail.com', 5),
('Trần Thị B', '0911123112', 'thib@gmail.com', 6),
('Võ Văn C', '0911123113', 'vanc@gmail.com', 7),
('Lê Thị D', '0911123114', 'thid@gmail.com', 8),
('Phạm Văn E', '0911123115', 'vane@gmail.com', 9),
('Hoàng Thị F', '0911123116', 'thif@gmail.com', 10),
('Đỗ Văn G', '0911123117', 'vang@gmail.com', 11),
('Cao Hồng Phúc', '0372807439', 'phucc0386@gmail.com', 12);

CREATE TABLE phuong (
    PH_ID INT AUTO_INCREMENT PRIMARY KEY,
    PH_Ten VARCHAR(50) NOT NULL UNIQUE
)ENGINE=InnoDB;

INSERT INTO phuong (PH_Ten) VALUES
('An Bình'),        
('An Khánh'),       
('Bình Thuỷ'),     
('Cái Khế'),        
('Cái Răng'),       
('Hưng Phú'),      
('Long Tuyền'),  
('Ninh Kiều'),      
('Phú Thứ'),        
('Thốt Nốt'),       
('Thới An Đông'),   
('Thới Lai'),       
('Tân An'),         
('Trà Nóc'),        
('Ô Môn');          

CREATE TABLE diachi (
    DC_ID INT AUTO_INCREMENT PRIMARY KEY,
    DC_SoNha VARCHAR(200) NOT NULL,
    DC_ToaDo VARCHAR(100) NOT NULL,
    PH_ID INT NOT NULL,
    KH_ID INT NOT NULL,
    FOREIGN KEY (PH_ID) REFERENCES phuong(PH_ID),
    FOREIGN KEY (KH_ID) REFERENCES khachhang(KH_ID)
)ENGINE=InnoDB;

INSERT INTO diachi (DC_SoNha, DC_ToaDo, PH_ID, KH_ID) VALUES
('98 đường 3 Tháng 2', '10.0169, 105.7607', 13, 1),
('55 đường Nguyễn Văn Linh', '10.0250, 105.7602', 13, 2),
('509 đường 30 Tháng 4', '10.0129, 105.7609', 13, 3),
('30 đường Cách Mạng Tháng 8', '10.0462, 105.7797', 8, 4),
('3 đường Trần Văn Khéo', '10.0436, 105.7825', 8, 5),
('100 đường 30 Tháng 4', '10.0297, 105.7793', 8, 6),
('200 đường Nguyễn Văn Cừ', '10.0378, 105.7594', 13, 7),
('388 đường Lê Bình', '9.9992, 105.7524', 5, 8);

CREATE TABLE nhacungcap (
    NCC_ID INT AUTO_INCREMENT PRIMARY KEY,
    NCC_Ten VARCHAR(100) NOT NULL,
    NCC_SDT VARCHAR(12) NOT NULL UNIQUE,
    NCC_Email VARCHAR(100) NOT NULL UNIQUE,
    NCC_TinhThanh VARCHAR(50) NOT NULL,
    TK_ID INT DEFAULT NULL,
    FOREIGN KEY (TK_ID) REFERENCES taikhoan(TK_ID)
)ENGINE=InnoDB;

INSERT INTO nhacungcap (NCC_Ten, NCC_SDT, NCC_Email, NCC_TinhThanh, TK_ID) VALUES
('Shop Hoà An', '0922123111', 'hoaanshop@gmail.com', 'TP.HCM', 13),
('Shop Hưng Phát', '0922123112', 'hungphatshop@gmail.com', 'Hà Nội', 14),
('Shop Thành Lợi', '0922123113', 'thanhloishop@gmail.com', 'Đà Nẵng', 15);

CREATE TABLE phuongtien (
    PT_Ma CHAR(5) PRIMARY KEY,
    PT_Ten VARCHAR(50) NOT NULL UNIQUE
)ENGINE=InnoDB;

INSERT INTO phuongtien (PT_Ma, PT_Ten) VALUES
('PT001', 'Xe Máy'),
('PT002', 'Xe Tải');

CREATE TABLE nhanviengiaohang (
    NVGH_Ma CHAR(5) PRIMARY KEY,
    NVGH_Ten VARCHAR(50) NOT NULL,
    NVGH_SDT VARCHAR(12) NOT NULL UNIQUE,
    NVGH_GioiTinh INT NOT NULL CHECK (NVGH_GioiTinh IN (0,1)),
    NVGH_NgaySinh DATE NOT NULL,
    NVGH_CCCD VARCHAR(12) NOT NULL UNIQUE,
    NVGH_AnhChanDung VARCHAR(100) NOT NULL,
    PT_Ma CHAR(5) NOT NULL,
    TK_ID INT DEFAULT NULL,
    FOREIGN KEY (PT_Ma) REFERENCES phuongtien(PT_Ma),
    FOREIGN KEY (TK_ID) REFERENCES taikhoan(TK_ID)
)ENGINE=InnoDB;

INSERT INTO nhanviengiaohang (NVGH_Ma, NVGH_Ten, NVGH_SDT, NVGH_GioiTinh, NVGH_NgaySinh, NVGH_CCCD, NVGH_AnhChanDung, PT_Ma, TK_ID) VALUES
('NV001', 'Lê Văn I', '0933123111', 1, '1990-05-15', '123456789012', 'nvgh1.jpg', 'PT001', 2),
('NV002', 'Phạm Thị J', '0933123112', 0, '1992-08-20', '123456789013', 'nvgh2.jpg', 'PT002', 3),
('NV003', 'Trần Văn K', '0933123113', 1, '1988-12-10', '123456789014', 'nvgh3.jpg', 'PT001', 4);

CREATE TABLE kho (
    K_Ma CHAR(5) PRIMARY KEY,
    K_Ten VARCHAR(50) NOT NULL UNIQUE,
    K_DiaChi VARCHAR(200) NOT NULL,
    K_ToaDo VARCHAR(100) NOT NULL
)ENGINE=InnoDB;

INSERT INTO kho (K_Ma, K_Ten, K_DiaChi, K_ToaDo) VALUES
('K0001', 'Kho Cái Răng', '62 Quốc Lộ 1 A, Cái Răng, Cần Thơ', '9.9813, 105.7444'),
('K0002', 'Kho Ninh Kiều', '80 Hùng Vương, Ninh Kiều, Cần Thơ', '10.0433, 105.7782'),
('K0003', 'Kho Bình Thuỷ', '666 Nguyễn Văn Linh, Bình Thuỷ, Cần Thơ', '10.0415, 105.7395');

CREATE TABLE trangthai (
    TT_Ma CHAR(5) PRIMARY KEY,
    TT_Ten VARCHAR(50) NOT NULL UNIQUE
)ENGINE=InnoDB;

INSERT INTO trangthai (TT_Ma, TT_Ten) VALUES
('TT001', 'Đang Chờ Xử Lý'),
('TT002', 'Đang Giao Hàng'),
('TT003', 'Đã Giao Hàng'),
('TT004', 'Đã Nhận Hàng'),
('TT005', 'Đã Hủy'),
('TT006', 'Trả Hàng'),
('TT007', 'Đang Giao Hàng Chậm');

CREATE TABLE donhang (
    DH_Ma CHAR(10) PRIMARY KEY,
    DH_MaQR VARCHAR(100) NOT NULL,
    DH_SoLuongKIH INT NOT NULL CHECK (DH_SoLuongKIH > 0),
    DH_TongTien FLOAT NOT NULL CHECK (DH_TongTien >= 0),
    DH_ToaDoDi VARCHAR(100) NOT NULL,
    DH_ToaDoDen VARCHAR(100) NOT NULL,
    DH_GhiChu VARCHAR(200) DEFAULT NULL,
    KH_ID INT NOT NULL,
    NVGH_Ma CHAR(5) DEFAULT NULL,
    NCC_ID INT NOT NULL,
    TT_Ma CHAR(5) NOT NULL,
    K_Ma CHAR(5) NOT NULL,
    FOREIGN KEY (KH_ID) REFERENCES khachhang(KH_ID),
    FOREIGN KEY (NVGH_Ma) REFERENCES nhanviengiaohang(NVGH_Ma),
    FOREIGN KEY (NCC_ID) REFERENCES nhacungcap(NCC_ID),
    FOREIGN KEY (TT_Ma) REFERENCES trangthai(TT_Ma),
    FOREIGN KEY (K_Ma) REFERENCES kho(K_Ma)
)ENGINE=InnoDB;

INSERT INTO donhang (DH_Ma, DH_MaQR, DH_SoLuongKIH, DH_TongTien, DH_ToaDoDi, DH_ToaDoDen, DH_GhiChu, KH_ID, NVGH_Ma, NCC_ID, TT_Ma, K_Ma) VALUES
('DH0000001', 'QR001.jpg', 1, 150000.0, '10.0433, 105.7782', '10.0169, 105.7607', 'Giao hàng trong giờ hành chính', 1, 'NV001', 1, 'TT002', 'K0001'),
('DH0000002', 'QR002.jpg', 1, 80000.0, '10.0415, 105.7395', '10.0250, 105.7602', NULL, 2, 'NV002', 2, 'TT002', 'K0002'),
('DH0000003', 'QR003.jpg', 1, 200000.0, '9.9813, 105.7444', '10.0129, 105.7609', 'Giao hàng nhanh', 3, NULL, 3, 'TT001', 'K0003'),
('DH0000004', 'QR004.jpg', 1, 120000.0, '10.0297, 105.7793', '10.0436, 105.7825', NULL, 4, 'NV003', 1, 'TT002', 'K0001'),
('DH0000005', 'QR005.jpg', 1, 90000.0, '10.0433, 105.7782', '10.0378, 105.7594', 'Giao hàng trước 5 PM', 5, NULL, 2, 'TT001', 'K0002'),
('DH0000006', 'QR006.jpg', 1, 110000.0, '10.0415, 105.7395', '9.9992, 105.7524', NULL, 6, 'NV001', 3, 'TT002', 'K0003'),
('DH0000007', 'QR007.jpg', 1, 130000.0, '9.9813, 105.7444', '10.0169, 105.7607', 'Giao hàng gấp', 7, 'NV002', 1, 'TT002', 'K0001'),
('DH0000008', 'QR008.jpg', 1, 70000.0, '10.0433, 105.7782', '10.0250, 105.7602', NULL, 8, NULL, 2, 'TT001', 'K0002'),
('DH0000009', 'QR009.jpg', 1, 160000.0, '10.0415, 105.7395', '10.0129, 105.7609', 'Giao hàng trong ngày', 1, 'NV003', 3, 'TT002', 'K0003'),
('DH0000010', 'QR010.jpg', 1, 140000.0, '10.0297, 105.7793', '10.0436, 105.7825', NULL, 2, NULL, 1, 'TT001', 'K0001'),
('DH0000011', 'QR011.jpg', 1, 95000.0, '10.0433, 105.7782', '10.0378, 105.7594', 'Giao hàng trước 6 PM', 3, 'NV001', 2, 'TT002', 'K0002'),
('DH0000012', 'QR012.jpg', 1, 115000.0, '10.0415, 105.7395', '9.9992, 105.7524', NULL, 4, 'NV002', 3, 'TT003', 'K0003'),
('DH0000013', 'QR013.jpg', 1, 125000.0, '9.9813, 105.7444', '10.0169, 105.7607', 'Giao hàng nhanh', 5, NULL, 1, 'TT001', 'K0001'),
('DH0000014', 'QR014.jpg', 1, 85000.0, '10.0433, 105.7782', '10.0250, 105.7602', NULL, 6, 'NV003', 2, 'TT002', 'K0002'),
('DH0000015', 'QR015.jpg', 1, 175000.0, '10.0415, 105.7395', '10.0129, 105.7609', 'Giao hàng trong ngày', 7, NULL, 3, 'TT001', 'K0003'),
('DH0000016', 'QR016.jpg', 1, 145000.0, '10.0297, 105.7793', '10.0436, 105.7825', NULL, 8, 'NV001', 1, 'TT002', 'K0001'),
('DH0000017', 'QR017.jpg', 1, 105000.0, '10.0433, 105.7782', '10.0378, 105.7594', 'Giao hàng trước 5 PM', 1, NULL, 2, 'TT001', 'K0002'),
('DH0000018', 'QR018.jpg', 1, 115000.0, '10.0415, 105.7395', '9.9992, 105.7524', NULL, 2, 'NV002', 3, 'TT002', 'K0003'),
('DH0000019', 'QR019.jpg', 1, 135000.0, '9.9813, 105.7444', '10.0169, 105.7607', 'Giao hàng gấp', 3, 'NV003', 1, 'TT003', 'K0001'),
('DH0000020', 'QR020.jpg', 1, 75000.0, '10.0433, 105.7782', '10.0250, 105.7602', NULL, 4, NULL, 2, 'TT001', 'K0002');

CREATE TABLE kienhang (
    KIH_ID INT AUTO_INCREMENT PRIMARY KEY,
    KIH_TrongLuong FLOAT NOT NULL CHECK (KIH_TrongLuong > 0),
    KIH_ChieuDai FLOAT NOT NULL CHECK (KIH_ChieuDai > 0),
    KIH_ChieuRong FLOAT NOT NULL CHECK (KIH_ChieuRong > 0),
    KIH_ChieuCao FLOAT NOT NULL CHECK (KIH_ChieuCao > 0),
    KIH_DeVo INT NOT NULL CHECK (KIH_DeVo IN (0,1)),
    KIH_CoGiaTri INT NOT NULL CHECK (KIH_CoGiaTri IN (0,1)),
    KIH_GiaTien FLOAT NOT NULL CHECK (KIH_GiaTien >= 0),
    KIH_Anh VARCHAR(100) NOT NULL,
    KIH_MoTa VARCHAR(200) DEFAULT NULL,
    DH_Ma CHAR(10) NOT NULL,
    FOREIGN KEY (DH_Ma) REFERENCES donhang(DH_Ma)
)ENGINE=InnoDB;

INSERT INTO kienhang (KIH_TrongLuong, KIH_ChieuDai, KIH_ChieuRong, KIH_ChieuCao, KIH_DeVo, KIH_CoGiaTri, KIH_GiaTien, KIH_Anh, KIH_MoTa, DH_Ma) VALUES
(2.5, 30.0, 20.0, 15.0, 1, 1, 150000.0, 'kih1.jpg', 'Đồ điện tử', 'DH0000001'),
(1.0, 25.0, 15.0, 10.0, 0, 0, 80000.0, 'kih2.jpg', 'Quần áo', 'DH0000002'),
(5.0, 50.0, 40.0, 30.0, 1, 1, 200000.0, 'kih3.jpg', 'Đồ gia dụng', 'DH0000003'),
(3.0, 35.0, 25.0, 20.0, 0, 1, 120000.0, 'kih4.jpg', 'Sách vở', 'DH0000004'),
(1.5, 28.0, 18.0, 12.0, 1, 0, 90000.0, 'kih5.jpg', 'Giày dép', 'DH0000005'),
(2.0, 32.0, 22.0, 16.0, 0, 1, 110000.0, 'kih6.jpg', 'Đồ chơi trẻ em', 'DH0000006'),
(4.0, 45.0, 35.0, 25.0, 1, 1, 130000.0, 'kih7.jpg', 'Đồ thể thao', 'DH0000007'),
(1.2, 26.0, 16.0, 11.0, 0, 0, 70000.0, 'kih8.jpg', 'Phụ kiện thời trang', 'DH0000008'),
(3.5, 38.0, 28.0, 22.0, 1, 1, 160000.0, 'kih9.jpg', 'Đồ nội thất nhỏ', 'DH0000009'),
(2.8, 34.0, 24.0, 18.0, 0, 1, 140000.0, 'kih10.jpg', 'Đồ dùng học tập', 'DH0000010'),
(1.7, 29.0, 19.0, 13.0, 1, 0, 95000.0, 'kih11.jpg', 'Mỹ phẩm', 'DH0000011'),
(2.3, 31.0, 21.0, 15.0, 0, 1, 115000.0, 'kih12.jpg', 'Đồ điện tử nhỏ', 'DH0000012'),
(4.5, 48.0, 38.0, 28.0, 1, 1, 125000.0, 'kih13.jpg', 'Đồ gia dụng lớn', 'DH0000013'),
(1.3, 27.0, 17.0, 12.0, 0, 0, 85000.0, 'kih14.jpg', 'Quần áo trẻ em', 'DH0000014'),
(5.5, 52.0, 42.0, 32.0, 1, 1, 175000.0, 'kih15.jpg', 'Đồ thể thao lớn', 'DH0000015'),
(3.2, 36.0, 26.0, 20.0, 0, 1, 145000.0, 'kih16.jpg', 'Đồ nội thất vừa', 'DH0000016'),
(2.1, 33.0, 23.0, 17.0, 1, 1, 105000.0, 'kih17.jpg', 'Đồ dùng cá nhân', 'DH0000017'),
(2.4, 30.5, 20.5, 15.5, 0, 1, 115000.0, 'kih18.jpg', 'Đồ điện tử phụ kiện', 'DH0000018'),
(4.2, 46.0, 36.0, 26.0, 1, 1, 135000.0, 'kih19.jpg', 'Đồ gia dụng cao cấp', 'DH0000019'),
(1.1, 25.5, 15.5, 10.5, 0, 0, 75000.0, 'kih20.jpg', 'Phụ kiện điện thoại', 'DH0000020');