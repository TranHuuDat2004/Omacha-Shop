<?php
require_once '../connection/connectData.php';

if(isset($_POST['sbm'])) {
    // Lấy thông tin sản phẩm từ form
    $p_id = $_POST['p_id'];
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_age = mysqli_real_escape_string($conn, $_POST['p_age']);
    $p_provider = mysqli_real_escape_string($conn, $_POST['p_provider']);
    $p_price = mysqli_real_escape_string($conn, $_POST['p_price']);
    $p_type = mysqli_real_escape_string($conn, $_POST['p_type']);
    $p_description = mysqli_real_escape_string($conn, $_POST['p_description']);

    // Kiểm tra nếu có hình ảnh được chọn
    if (!empty(array_filter($_FILES['p_image']['name']))) {
        $p_images = $_FILES['p_image']['name'];
        $p_images_tmp = $_FILES['p_image']['tmp_name'];
        $p_image_paths = []; // Mảng để chứa các đường dẫn ảnh

        // Duyệt qua từng ảnh và di chuyển vào thư mục 'images/'
        foreach ($p_images as $index => $p_image) {
            $p_image_tmp = $p_images_tmp[$index];
            $image_path = basename($p_image); // Thêm tiền tố 'images/' vào tên tệp
            move_uploaded_file($p_image_tmp, '../../Fontend/images/' . $image_path); // Di chuyển tệp vào thư mục 'images'
            $p_image_paths[] = $image_path;
        }

        // Ghép các đường dẫn ảnh thành một chuỗi, ngăn cách bởi dấu phẩy
        $p_image = implode(',', $p_image_paths);

        // Cập nhật thông tin sản phẩm kèm theo đường dẫn ảnh mới
        $sql = "UPDATE product SET p_name = '$p_name', p_age = '$p_age', p_provider = '$p_provider', p_price = '$p_price', p_type = '$p_type', p_image = '$p_image', p_description = '$p_description' WHERE p_id = $p_id";
    } else {
        // Nếu không có file hình ảnh mới, chỉ cập nhật thông tin về sản phẩm
        $sql = "UPDATE product SET p_name = '$p_name', p_age = '$p_age', p_provider = '$p_provider', p_price = '$p_price', p_type = '$p_type', p_description = '$p_description' WHERE p_id = $p_id";
    }

    // Thực thi truy vấn SQL
    if (mysqli_query($conn, $sql)) {
        // Nếu thành công, chuyển hướng người dùng về trang quản lý sản phẩm
        header('Location: manageProduct.php');
        exit(); // Kết thúc script sau khi chuyển hướng để đảm bảo không có mã nào được thực thi tiếp sau khi chuyển hướng
    } else {
        // Nếu có lỗi, hiển thị thông báo lỗi
        echo "Lỗi cập nhật sản phẩm: " . mysqli_error($conn);
    }
} else {
    // Nếu không có biến sbm được gửi, chuyển hướng người dùng về trang quản lý sản phẩm
    header('Location: manageProduct.php');
    exit();
}
?>
