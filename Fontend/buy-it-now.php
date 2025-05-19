<!-- Trang này xử lí thêm vào giỏ hàng -->
<!-- Name input is add-to-order -->
<?php
    include 'login.php';

    
if (!isset($_SESSION["user"])) {
	// Redirect user to the login page if not logged in
	header("Location: login.html");
	exit(); // Stop further execution of the script
}

$userName = $_SESSION["user"];	
// print_r($userName);
$sqlLogin = "SELECT * FROM `login` WHERE userName = '$userName' " ;
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
        
    // Kiểm tra nếu form đã được submit
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['buy-it-now'])) {
        // Lấy dữ liệu từ form
        $p_id = $_POST['p_id'];
        $p_image = $_POST['p_image'];
        $p_name = $_POST['p_name'];
        $p_price = $_POST['p_price'];
        $p_type = $_POST['p_type'];
        $o_status = $_POST['o_status'];
        $o_quantity = $_POST['o_quantity'];
        $u_id = $userLogin["userID"];
    
        print_r($o_quantity);

        // Kiểm tra sản phẩm đã tồn tại trong giỏ hàng chưa
        $check_query = "SELECT * FROM `order` WHERE u_id = $u_id AND p_id = $p_id AND o_status = 0";
        $result = $conn->query($check_query);
        $u_id = $userLogin["userID"];
        if ($result->num_rows > 0) {
            // Sản phẩm đã tồn tại trong giỏ hàng, tăng số lượng
            $row = $result->fetch_assoc();
            $p_id = $row['p_id'];
            $o_id = $row['o_id'];
            
            $update_query = "UPDATE `order` SET o_quantity = o_quantity + '$o_quantity' WHERE o_id = $o_id AND p_id = $p_id AND u_id = $u_id";
            if ($conn->query($update_query) === TRUE) {
                header("Location: shopping-cart.php");
            } else {
                echo "Error updating record: " . $conn->error;
            }
        } else {
            // Sản phẩm chưa tồn tại trong giỏ hàng, thêm mới
            $insert_query = "INSERT INTO `order` (u_id, p_id, o_price, o_quantity, o_status)
                             VALUES ($u_id, $p_id, $p_price, '$o_quantity', '$o_status')";
            if ($conn->query($insert_query) === TRUE) {
                header("Location: shopping-cart.php");
            } else {
                echo "Error inserting record: " . $conn->error;
            }
        }
    
        // Đóng kết nối
        $conn->close();
    }
?>
