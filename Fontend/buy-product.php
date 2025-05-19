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

$sql = "SELECT * FROM product";
$query = mysqli_query($conn, $sql);


// Câu truy vấn SQL SELECT
$sqlOrder = "SELECT 
`order`.o_id, 
`order`.u_id, 
`order`.p_id, 
`order`.o_price, 
`order`.o_status, 
`order`.o_quantity,
product.p_type, 
product.p_image, 
product.p_name, 
product.p_price 
FROM 
`order`
INNER JOIN 
product ON `order`.p_id = product.p_id";

// Thực hiện truy vấn
$resultOrder = $conn->query($sqlOrder);

// Mảng chứa thông tin các đơn hàng
$order_array = array();

// Kiểm tra kết quả truy vấn
if ($resultOrder->num_rows > 0) {
    // Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
    while ($row = $resultOrder->fetch_assoc()) {
        if ($row['u_id'] == $userLogin['userID'] && $row['o_status'] == 1) {
            // Thêm thông tin từng hàng vào mảng $order_array
            $order_array[] = array(
                "o_id" => $row["o_id"],
                "u_id" => $row["u_id"],
                "p_id" => $row["p_id"],
                "o_price" => $row["o_price"],
                "o_quantity" => $row["o_quantity"],
                "o_status" => $row["o_status"],
                "p_type" => $row["p_type"],
                "p_image" => $row["p_image"],
                "p_name" => $row["p_name"],
                "p_price" => $row["p_price"]
            );
        }
    };
} else {
    // echo "0 results";
}

function updateOrderStatus($userID)
{
    global $conn;
    // Cập nhật trạng thái đơn hàng
    $sqlUpdate = "UPDATE `order` SET o_status = 1 WHERE u_id = '{$userID}'";
    $result = $conn->query($sqlUpdate);

    if ($result) {
        header('location: your-order.php');
        // return true;
    } else {
        // Trả về false nếu cập nhật thất bại
        // return false;
    }
}

updateOrderStatus($userLogin["userID"]);
