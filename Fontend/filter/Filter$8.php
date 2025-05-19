<?php
session_start();
// Kết nối cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'toy-shop');
$min_price = 8; // Giá sản phẩm tối thiểu
$max_price = 9; // Giá sản phẩm tối đa

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Sử dụng prepared statement để tránh các vấn đề liên quan đến SQL injection
$sql = "SELECT * FROM product WHERE p_price BETWEEN ? AND ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $min_price, $max_price); // ii: kiểu dữ liệu của hai biến là integer
$stmt->execute();
$result = $stmt->get_result();
$counter = 1;
// Kiểm tra xem có sản phẩm nào được tìm thấy không
if ($result->num_rows > 0) {
    // Lặp qua các hàng kết quả
    while($product = $result->fetch_assoc()) {
        $class_name = "duck" . $counter;
        $class_name1 = "bear" . $counter;

        ?>
        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy <?php echo $class_name1; ?>">
            <!-- Block2 -->
            <div class="block2">
                <form method="POST" action="productdetail.php">
                    <div id="<?php echo $product['p_id']; ?>" class="block2-pic hov-img0 <?php echo $class_name; ?>" style="border: 0.1px dashed #000; border-radius: 50px;">
                        <img src="images/<?php echo $product['p_image']; ?>" alt="IMG-PRODUCT">
                    </div>
                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <input class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6" style="background-color: white;" type="submit" name="p_name" value="<?php echo $product["p_name"]; ?>">
                            <input type="hidden" name="user" value="<?php echo $userLogin["userName"]; ?>">
                            <p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text1"><?php echo $product['p_type']; ?></p>
                            <span class="stext-105 cl3 price">$<?php echo $product['p_price']; ?></span>
                        </div>
                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="../Admin/public/addWishlist.php?p_id=<?php echo $product['p_id']; ?>" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png" alt="ICON" href="../Admin/public/addWishlist.php?p_id=<?php echo $product['p_id']; ?>">
                                <img class="icon-heart2 dis-block trans-04 ab-t-l" src="images/icons/icon-heart-02.png" alt="ICON" href="../Admin/public/addWishlist.php?p_id=<?php echo $product['p_id']; ?>">
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <?php
        $counter++;
    }
} else {
    // Hiển thị thông báo nếu không tìm thấy sản phẩm
    echo "Không tìm thấy sản phẩm phù hợp";
}
// Đóng kết nối cơ sở dữ liệu
$stmt->close();
$conn->close();
?>
