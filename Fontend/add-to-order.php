<!-- Trang này xử lí thêm vào giỏ hàng -->
<!-- Name input is add-to-order -->
<?php
    session_start();

    // Kiểm tra nếu form đã được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add-to-order'])) {
        // Lấy dữ liệu từ form
        $p_id = $_POST['p_id'];
        $p_image = $_POST['p_image'];
        $p_name = $_POST['p_name'];
        $p_price = $_POST['p_price'];
        $p_type = $_POST['p_type'];
        $o_status = $_POST['o_status'];
        $u_id = 123;
    
        // Kết nối đến cơ sở dữ liệu
        $servername = "localhost";
        $username = "root"; // Thay thế bằng username của bạn
        $password = ""; // Thay thế bằng mật khẩu của bạn
        $dbname = "toy-shop"; // Thay thế bằng tên cơ sở dữ liệu của bạn
    
        // Tạo kết nối
        $conn = new mysqli($servername, $username, $password, $dbname);
    
        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
    
        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $check_query = "SELECT * FROM `order` WHERE u_id = $u_id AND p_id = $p_id";
        $result = $conn->query($check_query);
    
        if ($result->num_rows > 0) {
            // Sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $row = $result->fetch_assoc();
            $p_id = $row['p_id'];
            $o_id = $row['o_id'];
            $u_id = $row['u_id'];
            $update_query = "UPDATE `order` SET o_quantity = o_quantity + 1 WHERE o_id = $o_id AND p_id = $p_id AND u_id = $u_id";
            if ($conn->query($update_query) === TRUE) {
                header("Location: product2.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $insert_query = "INSERT INTO `order` (u_id, p_id, o_price, o_quantity, o_status)
                             VALUES ($u_id, $p_id, $p_price, 1, '$o_status')";
            if ($conn->query($insert_query) === TRUE) {
                header("Location: product2.php");
            } else {
                echo "Error inserting record: " . $conn->error;
            }
        }
    
        // Đóng kết nối
        $conn->close();
    }
?>

