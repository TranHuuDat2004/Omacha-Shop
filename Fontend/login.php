<?php
session_start();

// if (!isset($_SESSION['user'])) {
//   header('Location: ../admin/index.php');
//   die();
// }

$user = '';
$pass = '';
$error = '';

$conn = new mysqli('localhost', 'root', '', 'toy-shop'); //servername, username, password, database's name
if ($conn->connect_error) {
    die("Connection Failed : " . $conn->connect_error);
} else {
    if (isset($_POST['user']) && isset($_POST['pass'])) { // kiem tra xem bien co ton tai hay hong
        $user = $_POST['user'];
        $pass = $_POST['pass'];

        if ($user === 'admin' && $pass === '1234') {
            $_SESSION['user'] = 'admin.com';
            header('Location: ../Admin/public/index.php');
        } else {
            $stmt = $conn->prepare("SELECT * FROM login WHERE userName = ? AND loginpassword = ?"); // so sanh bien nhap vao voi database
            $stmt->bind_param("ss", $user, $pass);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows <= 0) {
                $error = 'Invalid username or password';
                header('Location: login.html'); // Chuyển hướng đến trang login.html nếu đăng nhập thất bại
            } else if ($result->num_rows > 0) {
                $_SESSION['user'] = $user;
                // print_r($_SESSION['user']);
                header('Location: ../Fontend/index.php');
            }
            $stmt->close();
            $conn->close();
        }
    }
}
?>
