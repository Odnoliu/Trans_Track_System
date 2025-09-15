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
('admin', 'admin123', 'VT001'),     --1
('nvgh1', 'nvgh123', 'VT002'),      --2
('nvgh2', 'nvgh123', 'VT002'),      --3
('nvgh3', 'nvgh123', 'VT002'),      --4
('khachhang1', 'kh123', 'VT003'),   --5
('khachhang2', 'kh123', 'VT003'),   --6
('khachhang3', 'kh123', 'VT003'),   --7
('khachhang4', 'kh123', 'VT003'),   --8
('khachhang5', 'kh123', 'VT003'),   --9
('khachhang6', 'kh123', 'VT003'),   --10
('khachhang7', 'kh123', 'VT003'),   --11
('khachhang8', 'kh123', 'VT003'),   --12
('nhacungcap1', 'ncc123', 'VT004'), --13
('nhacungcap2', 'ncc123', 'VT004'), --14
('nhacungcap3', 'ncc123', 'VT004'); --15

CREATE TABLE khachhang (
    KH_ID INT AUTO_INCREMENT PRIMARY KEY,
    KH_Ten VARCHAR(50) NOT NULL,
    KH_SDT VARCHAR(12) NOT NULL UNIQUE,
    KH_Email VARCHAR(100) NOT NULL UNIQUE,
    TK_ID INT DEFAULT NULL,
    FOREIGN KEY (TK_ID) REFERENCES taikhoan(TK_ID)
)ENGINE=InnoDB;

INSERT INTO khachhang (KH_Ten, KH_SDT, KH_Email, TK_ID) VALUES
('Nguyễn Văn A', '0911123111', 'vana@gmail.com', 5),
('Trần Thị B', '0911123112', 'thib@gmail.com', 6),
('Võ Văn C', '0911123113', 'vanc@gmail.com', 7),
('Lê Thị D', '0911123114', 'thid@gmail.com', 8),
('Phạm Văn E', '0911123115', 'vane@gmail.com', 9),
('Hoàng Thị F', '0911123116', 'thif@gmail.com', 10),
('Đỗ Văn G', '0911123117', 'vang@gmail.com', 11),
('Ngô Thị H', '0911123118', 'thih@gmail.com', 12);

CREATE TABLE phuong (
    PH_ID INT AUTO_INCREMENT PRIMARY KEY,
    PH_Ten VARCHAR(50) NOT NULL UNIQUE
)ENGINE=InnoDB;

INSERT INTO phuong (PH_Ten) VALUES
('An Bình'),        --1
('An Khánh'),       --2
('Bình Thuỷ'),      --3
('Cái Khế'),        --4
('Cái Răng'),       --5
('Hưng Phú'),       --6
('Long Tuyền'),     --7
('Ninh Kiều'),      --8
('Phú Thứ'),        --9
('Thốt Nốt'),       --10
('Thới An Đông'),   --11
('Thới Lai'),       --12
('Tân An'),         --13
('Trà Nóc'),        --14
('Ô Môn');          --15

CREATE TABLE diachi (
    DC_ID INT AUTO_INCREMENT PRIMARY KEY,
    DC_SoNha VARCHAR(200) NOT NULL,
    DC_ToaDo VARCHAR(100) NOT NULL,
    PH_ID INT AUTO_INCREMENT NOT NULL,
    KH_ID INT NOT NULL,
    FOREIGN KEY (PH_Ma) REFERENCES phuong(PH_Ma),
    FOREIGN KEY (KH_ID) REFERENCES khachhang(KH_ID)
)ENGINE=InnoDB;

INSERT INTO diachi (DC_SoNha, PH_ID, KH_ID) VALUES
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
    NVGH_Ma INT AUTO_INCREMENT PRIMARY KEY,
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
    NVGH_Ma INT DEFAULT NULL,
    NCC_ID INT NOT NULL,
    TT_Ma CHAR(5) NOT NULL,
    K_Ma CHAR(5) NOT NULL,
    FOREIGN KEY (KH_ID) REFERENCES khachhang(KH_ID),
    FOREIGN KEY (NVGH_Ma) REFERENCES nhanviengiaohang(NVGH_Ma),
    FOREIGN KEY (NCC_ID) REFERENCES nhacungcap(NCC_ID),
    FOREIGN KEY (TT_Ma) REFERENCES trangthai(TT_Ma),
    FOREIGN KEY (K_Ma) REFERENCES kho(K_Ma)
)ENGINE=InnoDB;

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
