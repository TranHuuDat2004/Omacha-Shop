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


function sumTotalPrice($order_array, $u_id)
{
    $totalPrice = 0; // Khởi tạo biến tổng giá tiền

    // Duyệt qua từng sản phẩm trong giỏ hàng và tính tổng giá tiền
    foreach ($order_array as $item) {
        // Kiểm tra xem u_id của sản phẩm có khớp với u_id được chỉ định hay không
        if ($item["u_id"] == $u_id && $item["o_status"] == 1) {
            // Tính giá tiền của mỗi sản phẩm (giá tiền * số lượng)
            $productPrice = $item["p_price"] * $item["o_quantity"];

            // Cộng vào tổng giá tiền
            $totalPrice += $productPrice;
        }
    }

    return $totalPrice; // Trả về tổng giá tiền
}

// Truy vấn để đếm số dòng trong bảng order
$sql = "SELECT COUNT(*) AS total_rows FROM `order` WHERE u_id = '{$userLogin['userID']}' AND o_quantity > 0 AND o_status = 0";
$result = $conn->query($sql);

// Kiểm tra và hiển thị kết quả
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$order_count = $row["total_rows"];
} else {
	// echo "Không có dữ liệu trong bảng order";
}

// Truy vấn để đếm số dòng trong bảng order
$sql = "SELECT COUNT(*) AS total_rows FROM wishlist";
$result = $conn->query($sql);

// Kiểm tra và hiển thị kết quả
if ($result->num_rows > 0) {
	$row = $result->fetch_assoc();
	$wishlist_count = $row["total_rows"];
} else {
	// echo "Không có dữ liệu trong bảng order";
}

// Truy vấn thông tin chiết khấu dựa trên tên discount (d_name)
$sqlDiscount = "SELECT * FROM discount";
$query = mysqli_query($conn, $sqlDiscount);

// Mảng chứa thông tin chiết khấu
$discount = array();

// Kiểm tra kết quả truy vấn
if ($query->num_rows > 0) {
    // Lặp qua từng hàng dữ liệu từ kết quả truy vấn
    while ($row = $query->fetch_assoc()) {
        // Thêm thông tin từng hàng vào mảng $discount
        $discount = array(
            "d_id" => $row["d_id"],
            "d_name" => $row["d_name"],
            "d_amount" => $row["d_amount"],
            "d_description" => $row["d_description"],
            "d_start_date" => $row["d_start_date"],
            "d_end_date" => $row["d_end_date"]
        );
    }
} else {
    // Nếu không tìm thấy kết quả
    // echo "0 results";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Shopping Cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="search.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
    <!-- link icon -->
    <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome" href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
    <!-- link icon -->
    <link rel="icon" type="image/png" href="images/icon.png" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!--===============================================================================================-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        #button-add {
            border-radius: 30px;
            padding: 10px;
            margin-bottom: 20px;
            background-color: black;
            color: white;
            margin-right: 10px;
            /* Add margin to create space between buttons */
        }

        #button-add:hover {
            background-color: #F4538A;
        }

        #button {
            border-radius: 30px;
            padding: 10px;
            background-color: rgb(207, 204, 204);
            color: rgb(0, 0, 0);
            margin-right: 10px;
            /* Add margin to create space between buttons */
        }

        #button:hover {
            background-color: #F4538A;
        }

        .btn-remove-product {
            cursor: pointer;
            /* Đổi con trỏ chuột thành kiểu pointer khi di chuột qua */
        }

        .btn-remove-product i {
            color: #F4538A;
            /* Đổi màu của biểu tượng thành màu đỏ */
        }

        /* Định dạng hình ảnh sản phẩm */
        /* .header-cart-item-img {
			flex: 0 0 auto;
			
			width: 100px;
			
			height: auto;
			
			margin-right: 20px;
			
		} */

        #button-cart {
            border-radius: 10px;
            padding: 10px;
            background-color: black;
            color: white;
        }

        #button-cart:hover {
            background-color: #F4538A;
        }

        .btn-up,
        .btn-down {
            width: 45px;
            height: 100%;
            cursor: pointer;
        }

        #update-cart {
            background-color: #F4538A;
            color: white;
        }

        #update-cart:hover {
            background-color: black;
            color: white;
        }

        /* Định dạng nút check out và view cart */
        #btn-cart {
            background-color: #F4538A;
            color: #FFEFEF;
        }

        #btn-cart:hover {
            background-color: black;
            color: #FFEFEF;
        }

        /* Định dạng nút delete */
        .btn-delete {
            color: black;
        }

        .btn-delete:hover {
            color: #F4538A;
        }

        #thank-you{
            color:black;
            padding: 5px;
            text-align: center;
        }

        .how-itemcart1 {
            width: 125px;
            position: relative;
            margin-right: 20px;
            cursor: pointer;
        }
    </style>
</head>

<body class="animsition">

    <!-- Header -->
    <header class="header-v4">
        <!-- Header desktop -->
        <div class="container-menu-desktop">
            <!-- Topbar -->
            <div class="top-bar">
                <div class="content-topbar flex-sb-m h-full container">
                    <div class="left-top-bar">
                        <div class="d-inline-flex align-items-center">
                            <p style="color: #F4538A"><i class="fa fa-envelope mr-2"></i><a href="mailto:omachacontact@gmail.com" style="color: #000; text-decoration: none;">omachacontact@gmail.com</a></p>
                            <p class="text-body px-3">|</p>
                            <p style="color: #F4538A"><i class="fa fa-phone-alt mr-2"></i><a href="tel:+19223600" style="color: #000; text-decoration: none;">+1922 4800</a></p>
                        </div>
                    </div>

                    <div class="col-lg-6 text-center text-lg-right">
                        <div class="d-inline-flex align-items-center">
                            <a class="text-primary px-3" href="https://www.facebook.com/profile.php?id=61557250007525" target="_blank" title="Visit the Reis Adventures fanpage.">
                                <i style="color: #49243E;" class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-primary px-3" href="https://twitter.com/reis_adventures" target="_blank" title="Visit the Reis Adventures Twitter.">
                                <i style="color: #49243E;" class="fab fa-twitter"></i>
                            </a>
                            <a class="text-primary px-3" href="https://www.linkedin.com/in/reis-adventures-458144300/" target="_blank" title="Visit the Reis Adventures Linkedin.">
                                <i style="color: #49243E;" class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-primary px-3" href="https://www.instagram.com/reis_adventures2024?igsh=YTQwZjQ0NmI0OA%3D%3D&utm_source=qr" target="_blank" title="Visit the Reis Adventures Instagram.">
                                <i style="color: #49243E;" class="fab fa-instagram"></i>
                            </a>
                            <div class="data1">
                                <i style="color: #49243E;" class=""></i>
                                <a href="register.php" class="btn2 btn-primary2 mt-1" style="color: #49243E;"><b><?php echo $userLogin["userID"]; ?>
                                        /</b></a>
                            </div>
                            <div class="data2">
                                <i style="color: #49243E;" class=""></i>
                                <a href="register.php" class="btn2 btn-primary2 mt-1" style="color: #49243E;"><b><?php echo $userLogin["userName"]; ?></b></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="wrap-menu-desktop" style="background-color: #FFEFEF;">
                <nav class="limiter-menu-desktop container" style="background-color: #FFEFEF;">

                    <!-- Logo desktop -->
					<a href="index.php" class="navbar-brand">
						<h1 class="m-0 text-primary1 mt-3 "><span class="text-dark1"><img class="Imagealignment"
									src="images/icon.png">Omacha</h1>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="index.php">Home</a>

							</li>

							<li class="label1" data-label1="hot">
							<a href="product2.php">Shop</a>
								<ul class="sub-menu">
									<li><a href="0_12months.php">0-12 Months</a></li>
									<li><a href="1_2years.php">1-2 Years</a></li>
									<li><a href="3+years.php">3+ Years</a></li>
									<li><a href="5+years.php">5+ Years</a></li>
								</ul>
							</li>

							<li>
								<a href="blog.php">Blog</a>
							</li>

							<li>
								<a href="contact.php">Contact</a>
							</li>

							<li>
								<a href="about.php">Pages</a>
								<ul class="sub-menu">
									<li><a href="about.php">About</a></li>
									<li><a href="FAQ.php">Faq</a></li>
								</ul>
							</li>
						</ul>
					</div>

					<!-- Icon header -->
					<div class="wrap-icon-header flex-w flex-r-m">
						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
							<i class="zmdi zmdi-search"></i>
						</div>

						<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
							data-notify="<?php echo $order_count?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="wishlist.php"
							class="dis-block icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
							data-notify="<?php echo $wishlist_count?>">
							<i class="zmdi zmdi-favorite-outline"></i>
						</a>
					</div>
                </nav>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap-header-mobile">
            <!-- Logo moblie -->
            <div class="logo-mobile">
                <a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO"></a>
            </div>

            <!-- Icon header -->
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                    <i class="zmdi zmdi-search"></i>
                </div>

                <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart" data-notify="<?php echo $order_count ?>">
                    <i class="zmdi zmdi-shopping-cart"></i>
                </div>

                <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="0">
                    <i class="zmdi zmdi-favorite-outline"></i>
                </a>
            </div>

            <!-- Button show menu -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>
        </div>


        <!-- Menu Mobile -->
		<div class="menu-mobile">
			<!-- <ul class="topbar-mobile">
					<li>
						<div class="left-top-bar">
							Free shipping for standard order over $100
						</div>
					</li>

					<li>
						<div class="right-top-bar flex-w h-full">
							<a href="#" class="flex-c-m p-lr-10 trans-04">
								Help & FAQs
							</a>

							<a href="#" class="flex-c-m p-lr-10 trans-04">
								My Account
							</a>

							<a href="#" class="flex-c-m p-lr-10 trans-04">
								EN
							</a>

							<a href="#" class="flex-c-m p-lr-10 trans-04">
								USD
							</a>
						</div>
					</li>
				</ul> -->

			<ul class="main-menu-m">
				<li>
					<a href="index.php">Home</a>
					
				</li>

				<li>
					<a href="product2.php">Shop</a>
					<ul class="sub-menu-m">
					<li><a href="0_12months.php">0-12 Months</a></li>
						<li><a href="1_2years.php">1-2 Years</a></li>
						<li><a href="3+years.php">3+ Years</a></li>
						<li><a href="5+years.php">5+ Years</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="shoping-cart.php" class="label1 rs1" data-label1="hot">Cart</a>
				</li>

				<li>
					<a href="blog.php">Blog</a>
				</li>

				<li>
					<a href="about.php">About</a>
				</li>

				<li>
					<a href="contact.php">Contact</a>
				</li>
			</ul>
		</div>

        <!-- Modal Search -->
        <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
            <div class="container-search-header">
                <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                    <img src="images/icons/icon-close2.png" alt="CLOSE">
                </button>

                <form class="wrap-search-header flex-w p-l-15">
                    <button class="flex-c-m trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                    <input class="plh3" type="text" name="search" placeholder="Search...">
                </form>
            </div>
        </div>
    </header>

    <!-- Cart -->
	<div class="wrap-header-cart js-panel-cart">
		<div class="s-full js-hide-cart"></div>

		<div class="header-cart flex-col-l p-l-65 p-r-25">
			<div class="header-cart-title flex-w flex-sb-m p-b-8">
				<span class="mtext-103 cl2">
					Your Cart
				</span>

				<div class="fs-35 lh-10 cl2 p-lr-5 pointer hov-cl1 trans-04 js-hide-cart">
					<i class="zmdi zmdi-close"></i>
				</div>
			</div>

			<div class="header-cart-content flex-w js-pscroll">
				<ul class="header-cart-wrapitem w-full">
					<span>Congratulations! You&#39;ve got <strong>Free Shipping!</strong></span>
					<div class="progress1"></div>
					<br>
					<?php
					// Duyệt qua mỗi sản phẩm trong giỏ hàng và hiển thị thông tin
					foreach ($order_array as $item) {
						// Tách chuỗi hình ảnh thành mảng và loại bỏ khoảng trắng thừa
						$product_images = array_map('trim', explode(',', $item["p_image"]));
						
						// mới có u_id $userLogin["userID"], 555
						if ($item["u_id"] == $userLogin["userID"] && $item["o_quantity"] > 0 && $item["o_status"] == 0) {
					?>
							<li class="header-cart-item m-b-20">
								<div class="row">
									<div class="col-md-3">
										<div class="header-cart-item-img">
											<!-- Hiện hình trong giỏ hàng -->
											<img src="images/<?php echo $product_images[0]; ?>" alt="IMG">
										</div>
									</div>
									<div class="col-md-6">
										<div >
											<!-- Hiện tên sản phẩm trong giỏ hàng -->
											<a href="#" class="header-cart-item-name hov-cl1 trans-04"><?php echo $item["p_name"]; ?></a>
										</div>
										<!-- Hiện số lượng sản phẩm và giá tiền -->
										<span class="header-cart-item-info"><?php echo $item["o_quantity"]; ?> x $<?php echo $item["p_price"]; ?></span>
									</div>
									<div class="col-md-3">
										<form action="delete-cart2.php" method="post">											
											<input type="hidden" name="p_id" value="<?php echo $item['p_id']; ?>">

											<!-- Nút xóa tại đây -->
											<input type="submit" value="X" name="delete-cart" class="btn-delete">
											<!-- <//?php print_r($item['p_id']); ?> -->
										</form>
									</div>
								</div>
							</li>
					<?php
						}
					}
					?>
				</ul>


				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						<?php $totalPrice = sumTotalPrice($order_array, $userLogin["userID"]); ?> <!-- thay doi user -->
						<p>Total: $<?php echo $totalPrice; ?></p>
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="shopping-cart.php" id="btn-cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="your-order.php" id="btn-cart" class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Your Order
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
    <!-- Shoping Cart -->
    <form class="bg0 p-t-75 p-b-85">
        <div class="container">
        <h1 id="thank-you">Thank You!</h1>
        <p id="thank-you">Your order has been successfully placed.</p>
        <p style="padding-bottom: 10px;" id="thank-you">We appreciate your business and look forward to serving you again.</p>
            <table style="width:100%" class="table-shopping-cart">
                <tr class="table_head">
                    <th class="column-1">Product</th>
                    <th class="column-2"></th>
                    <th class="column-3">Price</th>
                    <th class="column-4">Quantity</th>
                    <th class="column-5">Total</th>
                </tr>

                <?php foreach ($order_array as $item) : ?>
                    <?php if ($item['u_id'] == $userLogin['userID'] && $item["o_quantity"] > 0 && $item["o_status"] == 1) 
                    
                    // Tách chuỗi hình ảnh thành mảng và loại bỏ khoảng trắng thừa
                    $p_images = array_map('trim', explode(',', $item["p_image"]));                   
                    
                    ?>
                    <tr class="table_row">
                        <td class="column-1">
                            <div class="how-itemcart1">
                                <img src="images/<?php echo $p_images[0]; ?>" alt="IMG">
                            </div>
                        </td>
                        <td class="column-2"><?php echo $item["p_name"]; ?></td>
                        <td id="price_<?php echo $item['p_id']; ?>" class="column-3">$ <?php echo $item["p_price"]; ?></td>

                        <td id="quantity_<?php echo $item['p_id']; ?>" class="column-4"><?php echo $item["o_quantity"]; ?></td>

                        <td id="total_<?php echo $item['p_id']; ?>" class="column-5">$ <?php echo $item["p_price"] * $item["o_quantity"]; ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>


        </div>


        <!-- <div style="text-align:center; padding-top:40px">
            Total: $ <?php echo sumTotalPrice($order_array, $userLogin["userID"]); ?>
            <div style="padding-top: 30px;" class="row">
                <div class="col-md-4">
                    <a style="color: white" id="button-add" href="index.php">Back to Home</a>
                </div>

                <div class="col-md-4">
                    <a style="color: white" id="button-add" href="product2.php">Continue Shopping</a>
                </div>

                <div class="col-md-4">
                    <a style="color: white" id="button-add" href="contact.php">Continue Contact</a>
                </div>
            </div>

        </div> -->

        <div class="col-sm-12 col-lg-10 col-xl-8 m-lr-auto p-b-85">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                    <div class="size-208 w-full-ssm">
                        <span class="stext-110 cl2">
                            Shipping:
                        </span>
                    </div>

                    <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                        <p class="stext-111 cl6 p-t-2">
                            There are no shipping methods available. Please double check your address, or contact us if you need any help.
                        </p>

                    </div>
                </div>

                <div class="flex-w flex-t p-t-27 p-b-33">
                    <div class="size-208">
                        <span class="mtext-101 cl2">
                            Total:
                        </span>
                    </div>

                    <div class="size-209 p-t-1">
                        <span class="mtext-110 cl2">
                            $ <?php echo sumTotalPrice($order_array, $userLogin["userID"]); ?>
                        </span>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <a href="index.php" id="button-add" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Back to Home</a>
                    </div>

                    <div class="col-md-4">
                        <a href="product2.php" id="button-add" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Continue Shopping</a>
                    </div>

                    <div class="col-md-4">
                        <a href="exportPDF.php" id="button-add" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">Export to PDF</a>
                    </div>
                </div>




            </div>
        </div>

    </form>




    <!-- Footer -->
    <footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Categories
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Women
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Men
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Shoes
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Watches
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Help
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Track Order
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Returns
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Shipping
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                FAQs
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        GET IN TOUCH
                    </h4>

                    <p class="stext-107 cl7 size-201">
                        Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us on (+1) 96 716 6879
                    </p>

                    <div class="p-t-27">
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-instagram"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa fa-pinterest-p"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl0 p-b-30">
                        Newsletter
                    </h4>

                    <form>
                        <div class="wrap-input1 w-full p-b-4">
                            <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email" placeholder="email@example.com">
                            <div class="focus-input1 trans-04"></div>
                        </div>

                        <div class="p-t-18">
                            <button class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04">
                                Subscribe
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="p-t-40">
                <div class="flex-c-m flex-w p-b-18">
                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-01.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-02.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-03.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-04.png" alt="ICON-PAY">
                    </a>

                    <a href="#" class="m-all-1">
                        <img src="images/icons/icon-pay-05.png" alt="ICON-PAY">
                    </a>
                </div>

                <p class="stext-107 cl6 txt-center">
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    Copyright &copy;<script>
                        document.write(new Date().getFullYear());
                    </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com" target="_blank">ThemeWagon</a>
                    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

                </p>
            </div>
        </div>
    </footer>


    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <!--===============================================================================================-->
    <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/bootstrap/js/popper.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/select2/select2.min.js"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <!--===============================================================================================-->
    <script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function() {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function() {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="js/main.js"></script>
    <script src="js/update-cart.js"></script>

</body>

</html>