<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toy-shop";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Xử lý dữ liệu từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $comment = $_POST["cmt"];
    $website = $_POST["web"];

    // Thực hiện truy vấn để chèn dữ liệu vào cơ sở dữ liệu
    $sql = "INSERT INTO comments (name, email, comment, website) VALUES ('$name', '$email', '$comment', '$website')";

    if ($conn->query($sql) === TRUE) {
        // Chuyển hướng người dùng trở lại trang HTML
        header("Location: blog-detail1.php");
        exit(); // Đảm bảo không có mã HTML hoặc mã PHP nào được thực thi sau khi chuyển hướng
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>