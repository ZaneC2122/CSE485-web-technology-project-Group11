# CSE485-web-technology-project-Group11
Bài tập lớn tạo lập trang web quản lý sinh viên bằng ngôn ngữ PHP sử dụng mô hình MVC

## Đăng nhập và xóa hồ sơ

- Mở ứng dụng tại `http://localhost/BTL-QLSVL/public/`.
- Tài khoản mẫu sau khi chạy `database/schema.sql`: `a@gmail.com`, mật khẩu `12345678` (có thể dùng `b@gmail.com` hoặc `c@gmail.com`).
- Danh sách sinh viên yêu cầu đăng nhập. Biểu mẫu đăng xuất và xóa hồ sơ sử dụng POST kèm CSRF token.
- Khi xóa, thông tin chi tiết trong `students` được xóa cùng hồ sơ trong `student`.
- Mật khẩu mẫu đang ở dạng cũ sẽ được chuyển sang password hash khi đăng nhập thành công lần đầu.
