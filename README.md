# CSE485-web-technology-project-Group11
Bài tập lớn tạo lập trang web quản lý sinh viên bằng ngôn ngữ PHP sử dụng mô hình MVC

## Đăng ký, đăng nhập và xóa hồ sơ

- Mở ứng dụng tại `http://localhost/BTL-QLSVL/public/`.
- Tài khoản mẫu sau khi chạy `database/schema.sql`: `a@gmail.com`, mật khẩu `12345678` (có thể dùng `b@gmail.com` hoặc `c@gmail.com`).
- Trang đăng ký có tại `http://localhost/BTL-QLSVL/public/?controller=user&action=register`; tài khoản mới được lưu vào bảng `users` và đăng nhập sau khi đăng ký thành công.
- Mật khẩu tài khoản đăng ký mới được lưu bằng `password`; mật khẩu cần dài từ 8 đến 72 byte.
- Tại bảng sinh viên, nhấn nút dấu cộng để mở biểu mẫu thêm hồ sơ. Mã sinh viên phải là duy nhất.
- Danh sách sinh viên yêu cầu đăng nhập. Biểu mẫu đăng xuất và xóa hồ sơ sử dụng POST.
- Khi xóa, thông tin chi tiết trong `students` được xóa cùng hồ sơ trong `student`.

