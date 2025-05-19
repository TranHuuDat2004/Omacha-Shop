<?php
    include 'login.php';

    include('../Admin/connection/connectionpro.php');
    require_once '../Admin/connection/connectData.php';
    
    
    if (!isset($_SESSION["user"])) {
        // Redirect user to the login page if not logged in
        header("Location: login.html");
        exit(); // Stop further execution of the script
    }
    
    $userName = $_SESSION["user"];
    // print_r($userName);
    $sqlLogin = "SELECT * FROM `login` WHERE userName = '$userName' ";
    $queryLogin = mysqli_query($conn, $sqlLogin);
    // print_r($queryLogin);
    // Kiểm tra kết quả truy vấn
    
    // Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
    $row = $queryLogin->fetch_assoc();
    // Thêm thông tin từng hàng vào mảng $vuserLogin
    $userLogin = array(
        "userID" => $row["userID"],
        "userName" => $row["userName"],
        "email" => $row["email"],
    );

    // Hàm xử lý xóa một mục khỏi giỏ hàng
    function deleteCartItem($user_id, $product_id)
    {
        // Viết mã SQL để xóa một mục từ giỏ hàng cho user có user_id và product_id tương ứng
        $sql = "DELETE FROM `order` WHERE u_id = $user_id AND p_id = $product_id";

        // Thực thi câu lệnh SQL
        $conn = new mysqli('localhost', 'root', '', 'toy-shop');
        $result = mysqli_query($conn, $sql);

        // Kiểm tra xem có xóa thành công hay không
        if ($result) {
            // echo "Sản phẩm đã được xóa khỏi giỏ hàng thành công";
        } else {
            // echo "Có lỗi xảy ra khi xóa sản phẩm khỏi giỏ hàng";
        }
    }

    // Kiểm tra nếu form đã được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete-cart'])) {
        // Lấy dữ liệu từ form
        $p_id = $_POST['p_id'];
        $u_id = $userLogin["userID"]; // Thay đổi thành id người dùng thực tế
        var_dump($p_id);
        // Gọi hàm xóa một mục khỏi giỏ hàng
        deleteCartItem($u_id, $p_id);

    // Khôi phục dữ liệu POST từ session
    header("Location: product2.php");

        exit(); // Dừng script ngay sau khi chuyển hướng
    }
?>

