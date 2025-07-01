# Omacha Shop - E-commerce Toy Store

<p align="center">
  <img src="screenshot/logo.png" alt="Omacha Shop Logo" height="50px"/> <!-- Đảm bảo đường dẫn logo chính xác -->
</p>

Welcome to Omacha Shop, a delightful e-commerce platform dedicated to bringing joy and quality toys to children and families. This project showcases a full-stack web application built with PHP, designed for use with XAMPP, and features a comprehensive set of functionalities for both customers and administrators.
This README is available in English and Vietnamese. Please expand the section for your preferred language.

**Project Link:** [https://github.com/TranHuuDat2004/Omacha_Shop](https://github.com/TranHuuDat2004/Omacha_Shop) <!-- Cập nhật link repo nếu cần -->

---

<details>
<summary><strong>English Version (Click to Expand)</strong></summary>

## 🌟 Project Overview

Omacha Shop is designed to provide a seamless and enjoyable online shopping experience for toy enthusiasts. From browsing a diverse collection of toys to secure (simulated) payment and order tracking, Omacha aims to be a trusted destination for parents and children alike. The platform also includes a robust administration system for efficient business management.

**Live Demo (GitHub Pages - Frontend UI Only):**
*   Customer View: [https://tranhuudat2004.github.io/Omacha-Shop-Demo/](https://tranhuudat2004.github.io/Omacha-Shop-Demo/)
*   Admin View (UI Only): [https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html](https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html)
*(Note: The live demos are frontend-only and do not include backend functionality like database interactions, user authentication, or order processing. For full functionality, please set up the project locally as described below.)*

## ✨ Key Features

### For Customers:
*   **Intuitive Product Browsing:** Homepage, categories, age-based filtering, advanced search.
*   **Detailed Product Pages:** Multiple screenshots, descriptions, reviews.
*   **Shopping Cart & Wishlist:** Add to cart, cart preview, quantity updates, coupon application, save favorites.
*   **Secure Checkout Process:** Clear steps, shipping info, order summary, "Thank You" page, invoice generation (PDF option).
*   **User Accounts:** Registration, login, (potentially) order history.
*   **Engagement & Information:** Blog, About Us, Contact page, product reviews, comment system.

### 🛍️ Customer Interface (Screenshots)
|           Home Page (Layout 1)            |             Product Listing (with Filter)              |                    Product Detail Page                    |
| :---------------------------------------: | :----------------------------------------------------: | :-------------------------------------------------------: |
|  ![Omacha Home 1](screenshot/Home1.jpg)   | ![Omacha Product List & Filter](screenshot/filter.jpg) |  ![Omacha Product Detail](screenshot/product_detail.jpg)  |
|             **Shopping Cart**             |                  **Checkout Process**                  |                    **Thank You Page**                     |
|    ![Omacha Cart](screenshot/cart.jpg)    |      ![Omacha Checkout](screenshot/checkout.jpg)       |       ![Omacha Thank You](screenshot/thankyou.jpg)        |
|              **Login Page**               |                 **Registration Page**                  |                     **Wishlist Page**                     |
|   ![Omacha Login](screenshot/login.jpg)   |      ![Omacha Register](screenshot/signup.jpg)       |        ![Omacha Wishlist](screenshot/wishlist.jpg)        |
|               **Blog Page**               |                   **About Us Page**                    |                     **Contact Page**                      |
|    ![Omacha Blog](screenshot/blog.jpg)    |       ![Omacha About Us](screenshot/about5.jpg)        |         ![Omacha Contact](screenshot/contact.jpg)         |
|        **Order Detail**         |                   **Search Results**                   |          **Comment Section** (e.g., on Product)           |
| ![Omacha Invoice](screenshot/checkout1.jpg) |    ![Omacha Search Results](screenshot/search.jpg)     | ![Omacha Comment Section](screenshot/comment_product.jpg) |
|     **Home Page (Layout 2)**     |           **Home Page (Layout 3)**            |             **Home Page (Layout 4)**             |
|  ![Omacha Home 2](screenshot/Home2.jpg)   |         ![Omacha Home 3](screenshot/Home3.jpg)         |          ![Omacha Home 4](screenshot/Home4.jpg)           |
|     **Home Page (Layout 5)**     |      **Invoice**                                                   |                                                           |
|  ![Omacha Home 5](screenshot/Home5.jpg)   |           ![Invoice](screenshot/invoice.jpg)                                             |                                                           |

### For Administrators (Admin Dashboard):
*   **Dashboard Overview:** Statistics on orders, users, sales, comments.
*   **User Management:** View and manage users.
*   **Product Management:** Add, view, edit, delete products.
*   **Order Management:** View and manage customer orders.
*   **Comment Management:** Approve, reply to comments.
*   **Content Management:** Manage blog posts, categories.
*   **Statistical Reports:** Charts for best sellers, revenue.

### ⚙️ Admin Interface (Screenshots)
|                     Admin Login Page                     |               Admin Signup Page (if applicable)                |                      Admin Dashboard                       |
| :------------------------------------------------------: | :------------------------------------------------------------: | :--------------------------------------------------------: |
|    ![Omacha Admin Login](screenshot/login_admin.jpg)     |      ![Omacha Admin Signup](screenshot/create_admin.jpg)       |      ![Omacha Admin Dashboard](screenshot/admin1.jpg)      |
|                   **Add Product Form**                   |                   **Manage Products (List)**                   |                  **Manage Orders (List)**                  |
| ![Omacha Admin Add Product](screenshot/add_product.jpg)  | ![Omacha Admin Manage Products](screenshot/manage_product.jpg) | ![Omacha Admin Manage Orders](screenshot/manage_order.jpg) |
|                 **Manage Users (List)**                  |                                                                |                                                            |
| ![Omacha Admin Manage Users](screenshot/manage_user.jpg) |                                                                |                                                            |

## 🛠️ Technology Stack

*   **Frontend:** HTML5, CSS3, JavaScript, Bootstrap, Tailwind CSS (for Admin)
*   **Backend:** PHP (Procedural or with a custom structure)
*   **Database:** MySQL (Managed via phpMyAdmin in XAMPP)
*   **Web Server:** Apache (via XAMPP)

## 🚀 Getting Started

### Prerequisites

*   **XAMPP:** Installed and running (Apache, PHP, MySQL).
*   **Git:** For cloning.

### Installation & Setup

1.  **Start XAMPP:** Ensure Apache and MySQL services are running.
2.  **Clone Repository into `htdocs`:**
    *   Navigate to your XAMPP `htdocs` directory.
    *   Run: `git clone https://github.com/TranHuuDat2004/Omacha_Shop.git`
    *   `cd OmachaShop`

3.  **Database Setup:**
    *   Go to `http://localhost/phpmyadmin`.
    *   Create a new database named `toy-shop` (collation `utf8mb4_general_ci`).
    *   Select `toy-shop`, go to "Import", choose `OmachaShop/Frontend/toy-shop.sql` (or the correct path to your SQL file), and click "Go".

4.  **Configure Database Connection (if necessary):**
    *   Check your PHP database connection files.
    *   Default XAMPP credentials: Host: `localhost`, User: `root`, Password: `(empty)`, DB: `toy-shop`.

5.  **Accessing the Application:**
    *   **Customer Site:** `http://localhost/OmachaShop/` (or `http://localhost/OmachaShop/Frontend/`)
    *   **Admin Panel:** `http://localhost/OmachaShop/admin/` (or your specific admin path).
        *   *Default Admin Credentials (if any):* Username: `[admin_user]`, Password: `[admin_pass]` (Please update)

## 📝 License

This work is licensed under a [Creative Commons Attribution-NonCommercial 4.0 International License](https://creativecommons.org/licenses/by-nc/4.0/).
You are free to Share and Adapt the material, under the terms of Attribution and NonCommercial use.
[![License: CC BY-NC 4.0](https://licensebuttons.net/l/by-nc/4.0/88x31.png)](https://creativecommons.org/licenses/by-nc/4.0/)

## 👤 Contributors

*   **Team Engineering**
    *   **Nguyễn Thùy Khanh** - Team Leader | Project Visionary & Lead Ideator
    *   **Trần Hữu Đạt** - Full-Stack Web Developer - [@TranHuuDat2004](https://github.com/TranHuuDat2004)
    *   **Trần Bình Quyển** - Member
    *   **Dương Thị Thùy Linh** - Member

</details>

---

<details>
<summary><strong>Phiên bản Tiếng Việt (Nhấn để Mở rộng)</strong></summary>

## 🌟 Tổng quan Dự án

Omacha Shop được thiết kế để cung cấp trải nghiệm mua sắm trực tuyến liền mạch và thú vị cho những người đam mê đồ chơi. Từ việc duyệt qua bộ sưu tập đồ chơi đa dạng đến thanh toán (mô phỏng) an toàn và theo dõi đơn hàng, Omacha đặt mục tiêu trở thành một điểm đến đáng tin cậy cho các bậc cha mẹ và trẻ em. Nền tảng này cũng bao gồm một hệ thống quản trị mạnh mẽ để quản lý kinh doanh hiệu quả.

**Demo Trực tuyến (GitHub Pages - Chỉ Giao diện Frontend):**
*   Giao diện Khách hàng: [https://tranhuudat2004.github.io/Omacha-Shop-Demo/](https://tranhuudat2004.github.io/Omacha-Shop-Demo/)
*   Giao diện Quản trị (Chỉ UI): [https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html](https://tranhuudat2004.github.io/Omacha-Shop-Demo/Admin/public/index.html)

*(Lưu ý: Các bản demo trực tuyến chỉ là giao diện người dùng và không bao gồm các chức năng backend như tương tác cơ sở dữ liệu, xác thực người dùng hoặc xử lý đơn hàng. Để có đầy đủ chức năng, vui lòng cài đặt dự án cục bộ theo hướng dẫn bên dưới.)*

## ✨ Các Tính năng Chính

### Dành cho Khách hàng:
*   **Duyệt Sản phẩm Trực quan:** Trang chủ, danh mục, lọc theo độ tuổi, tìm kiếm nâng cao.
*   **Trang Chi tiết Sản phẩm:** Nhiều ảnh chụp màn hình, mô tả, đánh giá.
*   **Giỏ hàng & Danh sách Yêu thích:** Thêm vào giỏ hàng, xem trước giỏ hàng, cập nhật số lượng, áp dụng mã giảm giá, lưu sản phẩm yêu thích.
*   **Quy trình Thanh toán An toàn:** Các bước rõ ràng, thông tin vận chuyển, tổng kết đơn hàng, trang "Cảm ơn", tạo hóa đơn (tùy chọn xuất PDF).
*   **Tài khoản Người dùng:** Đăng ký, đăng nhập, (có thể có) lịch sử đơn hàng.
*   **Tương tác & Thông tin:** Mục Blog, trang Giới thiệu, trang Liên hệ, đánh giá sản phẩm, hệ thống bình luận.

### 🛍️ Giao diện Khách hàng (Ảnh chụp màn hình)
|           Trang Chủ (Layout 1)            |             Danh sách SP (có Bộ lọc)              |                    Trang Chi tiết Sản phẩm                    |
| :---------------------------------------: | :----------------------------------------------------: | :-------------------------------------------------------: |
|  ![Omacha Home 1](screenshot/Home1.jpg)   | ![Omacha Product List & Filter](screenshot/filter.jpg) |  ![Omacha Product Detail](screenshot/product_detail.jpg)  |
|             **Giỏ hàng**             |                  **Quy trình Thanh toán**                  |                    **Trang Cảm ơn**                     |
|    ![Omacha Cart](screenshot/cart.jpg)    |      ![Omacha Checkout](screenshot/checkout.jpg)       |       ![Omacha Thank You](screenshot/thankyou.jpg)        |
|              **Trang Đăng nhập**               |                 **Trang Đăng ký**                  |                     **Trang Yêu thích**                     |
|   ![Omacha Login](screenshot/login.jpg)   |      ![Omacha Register](screenshot/signup.jpg)       |        ![Omacha Wishlist](screenshot/wishlist.jpg)        |
|               **Trang Blog**               |                   **Trang Giới thiệu**                    |                     **Trang Liên hệ**                      |
|    ![Omacha Blog](screenshot/blog.jpg)    |       ![Omacha About Us](screenshot/about5.jpg)        |         ![Omacha Contact](screenshot/contact.jpg)         |
|        **Chi tiết Đơn hàng**         |                   **Kết quả Tìm kiếm**                   |          **Mục Bình luận** (ví dụ: trên Sản phẩm)           |
| ![Omacha Invoice](screenshot/checkout1.jpg) |    ![Omacha Search Results](screenshot/search.jpg)     | ![Omacha Comment Section](screenshot/comment_product.jpg) |
|     **Trang Chủ (Layout 2)**     |           **Trang Chủ (Layout 3)**            |             **Trang Chủ (Layout 4)**             |
|  ![Omacha Home 2](screenshot/Home2.jpg)   |         ![Omacha Home 3](screenshot/Home3.jpg)         |          ![Omacha Home 4](screenshot/Home4.jpg)           |
|     **Trang Chủ (Layout 5)**     |      **Hóa đơn**                                                   |                                                           |
|  ![Omacha Home 5](screenshot/Home5.jpg)   |           ![Invoice](screenshot/invoice.jpg)                                             |                                                           |

### Dành cho Quản trị viên (Bảng điều khiển Admin):
*   **Tổng quan Dashboard:** Thống kê nhanh về đơn hàng, người dùng, doanh số, bình luận.
*   **Quản lý Người dùng:** Xem và quản lý người dùng.
*   **Quản lý Sản phẩm:** Thêm, xem, sửa, xóa sản phẩm.
*   **Quản lý Đơn hàng:** Xem và quản lý đơn hàng của khách.
*   **Quản lý Bình luận:** Phê duyệt, trả lời bình luận.
*   **Quản lý Nội dung:** Quản lý bài viết blog, danh mục.
*   **Báo cáo Thống kê:** Biểu đồ về sản phẩm bán chạy, doanh thu.

### ⚙️ Giao diện Quản trị (Ảnh chụp màn hình)
|                     Trang Đăng nhập Admin                     |               Trang Đăng ký Admin (nếu có)                |                      Dashboard Admin                       |
| :------------------------------------------------------: | :------------------------------------------------------------: | :--------------------------------------------------------: |
|    ![Omacha Admin Login](screenshot/login_admin.jpg)     |      ![Omacha Admin Signup](screenshot/create_admin.jpg)       |      ![Omacha Admin Dashboard](screenshot/admin1.jpg)      |
|                   **Form Thêm Sản phẩm**                   |                   **Quản lý Sản phẩm (Danh sách)**                   |                  **Quản lý Đơn hàng (Danh sách)**                  |
| ![Omacha Admin Add Product](screenshot/add_product.jpg)  | ![Omacha Admin Manage Products](screenshot/manage_product.jpg) | ![Omacha Admin Manage Orders](screenshot/manage_order.jpg) |
|                 **Quản lý Người dùng (Danh sách)**                  |                                                                |                                                            |
| ![Omacha Admin Manage Users](screenshot/manage_user.jpg) |                                                                |                                                            |

## 🛠️ Công nghệ sử dụng

*   **Frontend:** HTML5, CSS3, JavaScript, Bootstrap, Tailwind CSS (cho trang Quản trị)
*   **Backend:** PHP (Lập trình thủ tục hoặc theo cấu trúc tùy chỉnh)
*   **Cơ sở dữ liệu:** MySQL (Quản lý qua phpMyAdmin trong XAMPP)
*   **Web Server:** Apache (thông qua XAMPP)

## 🚀 Bắt đầu

### Điều kiện Tiên quyết

*   **XAMPP:** Tải và cài đặt XAMPP (bao gồm Apache, PHP, MySQL/MariaDB, phpMyAdmin) từ [Apache Friends](https://www.apachefriends.org/index.html).
*   **Git:** Để sao chép kho lưu trữ.

### Cài đặt & Thiết lập

1.  **Khởi động XAMPP:**
    *   Mở XAMPP Control Panel.
    *   Khởi động dịch vụ **Apache** và **MySQL**.

2.  **Sao chép kho lưu trữ:**
    *   Mở dòng lệnh/terminal của bạn.
    *   Điều hướng đến thư mục `htdocs` trong thư mục cài đặt XAMPP (ví dụ: `C:\xampp\htdocs` trên Windows, hoặc `/Applications/XAMPP/htdocs` trên macOS).
    *   Sao chép dự án:
        ```bash
        git clone https://github.com/TranHuuDat2004/Omacha_Shop.git
        cd OmachaShop
        ```
        Dự án bây giờ sẽ nằm trong thư mục như `C:\xampp\htdocs\OmachaShop`.

3.  **Thiết lập Cơ sở dữ liệu:**
    *   Mở trình duyệt web và truy cập `http://localhost/phpmyadmin`.
    *   Tạo một cơ sở dữ liệu mới:
        *   Nhấp vào "New" ở thanh bên trái.
        *   Nhập tên cơ sở dữ liệu là `toy-shop`.
        *   Chọn một đối chiếu (collation) (ví dụ: `utf8mb4_general_ci`) và nhấp "Create".
    *   Nhập tệp SQL:
        *   Chọn cơ sở dữ liệu `toy-shop` vừa tạo từ thanh bên trái.
        *   Nhấp vào tab "Import" ở trên cùng.
        *   Nhấp "Choose File" và điều hướng đến thư mục `OmachaShop/Frontend/` (hoặc vị trí chứa tệp `toy-shop.sql` của bạn) và chọn tệp `toy-shop.sql`.
        *   Cuộn xuống và nhấp "Go".

4.  **Cấu hình Kết nối Cơ sở dữ liệu (nếu cần):**
    *   Ứng dụng PHP của bạn sẽ cần kết nối đến cơ sở dữ liệu. Tìm (các) tệp PHP trong dự án của bạn xử lý việc kết nối cơ sở dữ liệu (ví dụ: `config.php`, `db_connect.php`, hoặc tương tự).
    *   Đảm bảo các chi tiết kết nối chính xác cho thiết lập XAMPP mặc định:
        *   Hostname: `localhost`
        *   Tên cơ sở dữ liệu: `toy-shop`
        *   Tên người dùng: `root`
        *   Mật khẩu: `(để trống theo mặc định)`
    *   *(Nếu tệp kết nối của bạn có cấu trúc khác, hãy điều chỉnh cho phù hợp.)*

5.  **Truy cập Ứng dụng:**
    *   **Trang Khách hàng:** Mở trình duyệt và truy cập `http://localhost/OmachaShop/` (hoặc `http://localhost/TenThuMucDuAnCuaBan/` nếu bạn đặt tên thư mục khác trong `htdocs`).
    *   **Trang Quản trị:** Truy cập qua `http://localhost/OmachaShop/admin/` (hoặc đường dẫn cụ thể đến khu vực quản trị của bạn, ví dụ: `admin.php`, `admin_login.php`).
        *   *Thông tin đăng nhập quản trị mặc định (nếu có, vui lòng chỉ định):* Tên người dùng: `[admin_user]`, Mật khẩu: `[admin_pass]` *(Cập nhật nếu bạn có thông tin đăng nhập mặc định)*

## 📝 Giấy phép

Công trình này được cấp phép theo [Giấy phép Quốc tế Creative Commons Ghi công-Phi thương mại 4.0](https://creativecommons.org/licenses/by-nc/4.0/).
Bạn được tự do Chia sẻ và Phỏng theo tài liệu, theo các điều khoản Ghi công và Phi thương mại.
[![Giấy phép: CC BY-NC 4.0](https://licensebuttons.net/l/by-nc/4.0/88x31.png)](https://creativecommons.org/licenses/by-nc/4.0/)

## 👤 Thành viên Đóng góp

*   **Nhóm Kỹ thuật**
    *   **Nguyễn Thùy Khanh** - Trưởng nhóm | Định hướng & Lên ý tưởng chính cho Dự án
    *   **Trần Hữu Đạt** - Lập trình viên Web Full-Stack - [@TranHuuDat2004](https://github.com/TranHuuDat2004)
    *   **Trần Bình Quyển** - Thành viên
    *   **Dương Thị Thùy Linh** - Thành viên

</details>
