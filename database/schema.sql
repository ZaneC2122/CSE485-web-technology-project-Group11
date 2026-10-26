-- Bang 1: Tai khoan dang ky, dang nhap
CREATE TABLE users (
id_user INT AUTO_INCREMENT PRIMARY KEY,
ho_ten VARCHAR(100),
email VARCHAR(100),
mat_khau VARCHAR(100)
);

-- Bang 2: Thong tin sinh vien tong quan
CREATE TABLE student (
ma_sv VARCHAR(10) PRIMARY KEY,
ho_ten VARCHAR(100),
ngay_sinh DATE,
gioi_tinh VARCHAR(10),
ten_lop VARCHAR(50),
nganh VARCHAR(100),
khoa VARCHAR(100),
trang_thai VARCHAR(30)
);

-- Bang 3: Thong tin chi tiet sinh vien
CREATE TABLE students (
ma_sv VARCHAR(10) PRIMARY KEY,
cccd VARCHAR(12),
ngay_cap_cccd DATE,
noi_cap_cccd VARCHAR(100),
dan_toc VARCHAR(50),
quoc_tich VARCHAR(50),
dia_chi_thuong_tru VARCHAR(200),
noi_o_hien_tai VARCHAR(200),
ngay_nhap_hoc DATE,
nguoi_lien_he VARCHAR(100),
sdt_nguoi_lien_he VARCHAR(15),
ghi_chu VARCHAR(200),

    FOREIGN KEY (ma_sv) REFERENCES student(ma_sv)

);

-- Du lieu mau
INSERT INTO users(ho_ten, email, mat_khau)
VALUES
('Nguyễn Văn A', 'a@gmail.com', '12345678'),
('Trần Văn B', 'b@gmail.com', '12345678'),
('Lê Văn C', 'c@gmail.com', '12345678');

INSERT INTO student(ma_sv, ho_ten, ngay_sinh, gioi_tinh, ten_lop, nganh, khoa, trang_thai)
VALUES
('SV001', 'Nguyễn Thị Minh Anh', '2005-03-14', 'Nữ','HTTT2', 'Hệ thống thông tin','Công nghệ thông tin', 'Đang học'),

('SV002', 'Phạm Huỳnh Đăng Dương', '2004-11-08', 'Nam','HTTT2', 'Hệ thống thông tin','Công nghệ thông tin', 'Đang học'),

('SV003', 'Phạm Quốc Cường', '2005-07-22', 'Nam','KTPM1', 'Kỹ thuật phần mềm','Công nghệ thông tin', 'Bảo lưu'),

('SV004', 'Trần Công Hoan', '2003-12-02', 'Nam','ANM1', 'An ninh mạng','Công nghệ thông tin', 'Thôi học'),

('SV005', 'Bùi Quang Vinh', '2006-11-08', 'Nam','TTNT1', 'Trí tuệ nhân tạo','Công nghệ thông tin', 'Đang học');

INSERT INTO students(ma_sv, cccd, ngay_cap_cccd, noi_cap_cccd, dan_toc,quoc_tich, dia_chi_thuong_tru, noi_o_hien_tai,ngay_nhap_hoc, nguoi_lien_he,sdt_nguoi_lien_he, ghi_chu)
VALUES
('SV001', '001205123456', '2023-01-15',
'Cục Cảnh sát QLHC về TTXH', 'Kinh', 'Việt Nam',
'Hà Nội', 'Hà Nội', '2023-09-05',
'Nguyễn Văn Minh', '0912345678', 'Sinh viên đang học'),

('SV002', '001204234567', '2022-11-20',
'Cục Cảnh sát QLHC về TTXH', 'Kinh', 'Việt Nam',
'Hà Nội', 'Hà Nội', '2022-09-05',
'Phạm Văn Hùng', '0987654321', 'Sinh viên đang học'),

('SV003', '001205345678', '2023-03-10',
'Cục Cảnh sát QLHC về TTXH', 'Kinh', 'Việt Nam',
'Bắc Giang', 'Bắc Giang', '2023-09-05',
'Phạm Văn Thành', '0903456789', 'Sinh viên bảo lưu'),

('SV004', '001203456789', '2021-12-05',
'Cục Cảnh sát QLHC về TTXH', 'Kinh', 'Việt Nam',
'Nam Định', 'Nam Định', '2021-09-05',
'Trần Văn Nam', '0934567890', 'Sinh viên thôi học'),

('SV005', '001206567890', '2024-02-18',
'Cục Cảnh sát QLHC về TTXH', 'Kinh', 'Việt Nam',
'Hà Nội', 'Hà Nội', '2024-09-05',
'Bùi Văn Long', '0945678901', 'Sinh viên đang học');
