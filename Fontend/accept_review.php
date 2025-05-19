<?php
    require_once '../connection/connectData.php';

    if(isset($_POST['review_id'])) {
        $reviewId = $_POST['review_id'];
        // Thực hiện cập nhật trạng thái của review thành đã chấp nhận (hoặc thực hiện bất kỳ xử lý nào bạn cần)
        $sql = "UPDATE review SET accepted = 1 WHERE r_id = $reviewId";
        $query = mysqli_query($conn, $sql);
        if($query) {
            // Trả về thông báo hoặc gì đó nếu cần
            echo "Review accepted successfully!";
        } else {
            echo "Error accepting review!";
        }
    }
?>
