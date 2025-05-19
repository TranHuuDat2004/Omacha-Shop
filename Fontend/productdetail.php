<!--php-->
<?php
include 'login.php';
include ('../Admin/connection/connectionpro.php');
require_once '../Admin/connection/connectData.php';

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli('localhost', 'root', '', 'toy-shop'); //servername, username, password, database's name

// Kiểm tra kết nối
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}


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

if (isset($_GET['p_id'])) {
	$p_id = $_GET['p_id'];

	// Truy vấn chi tiết sản phẩm dựa trên p_id
	$sqlProduct = "SELECT * FROM `product` WHERE `p_id` = '$p_id'";
	$result = mysqli_query($conn, $sqlProduct);

	// Kiểm tra xem có kết quả trả về không
	if ($result->num_rows > 0) {
		// Lấy thông tin chi tiết của sản phẩm và đưa vào mảng product
		$row = $result->fetch_assoc();
		$product = array(
			"p_id" => $row["p_id"],
			"p_type" => $row["p_type"],
			"p_image" => $row["p_image"],
			"p_name" => $row["p_name"],
			"p_price" => $row["p_price"],
			"p_provider" => $row["p_provider"],
			"p_age" => $row["p_age"],
			"p_description" => $row["p_description"]
		);

		// Tách chuỗi hình ảnh thành mảng và loại bỏ khoảng trắng thừa
		$product_images = array_map('trim', explode(',', $row["p_image"]));

		// Kiểm tra và gán lại giá trị nếu ảnh thứ 2 và thứ 3 trống
		if (empty($product_images[1])) {
			$product_images[1] = $product_images[0];
		}

		if (empty($product_images[2])) {
			$product_images[2] = $product_images[0];
		}

		// Hiển thị thông tin chi tiết của sản phẩm
		// print_r($product_images);
	} else {
		echo "Không tìm thấy sản phẩm với p_id là $p_id";
		header("Location: 404.php");
		exit(); // Stop further execution of the script
	}
} else {
	header("Location: 404.php");
	exit(); // Stop further execution of the script
}




//echo "Test1<br>";
require_once ('../Admin/connection/connectData.php');
//echo "Test2<br>";
if (isset($_POST['sbm'])) {
	//echo "Test1<br>";
	$r_name = $_POST['r_name'];
	$r_star = $_POST['r_star'];
	$r_email = $_POST['r_email'];
	$r_description = $_POST['r_description'];



	//$date = date("Y/m/d"); //thay sua

	//echo "Test3<br>";
	$sql = "INSERT INTO review (r_name, r_star, r_email, r_description) 
			VALUES ('$r_name', '$r_star', '$r_email', '$r_description')"; //thay sua them thuoc tính date
	//echo "Test4<br>"; //met moi 
	//thay them try catch
	try {
		$query = mysqli_query($conn, $sql);
	} catch (Exception $e) {
		// var_dump($e);
	}


}

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

// // Kiểm tra kết quả truy vấn
// if ($resultOrder->num_rows > 0) {
// 	// Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
// 	while ($row = $resultOrder->fetch_assoc()) {
// 		// Hiển thị thông tin sản phẩm
// 		echo "Order ID: " . $row["o_id"] . "<br>";
// 		echo "User ID: " . $row["u_id"] . "<br>";
// 		echo "Product ID: " . $row["p_id"] . "<br>";
// 		echo "Order Price: " . $row["o_price"] . "<br>";
// 		echo "Order Status: " . $row["o_status"] . "<br>";
// 		echo "Product Type: " . $row["p_type"] . "<br>";
// 		echo "Product Image: " . $row["p_image"] . "<br>";
// 		echo "Product Name: " . $row["p_name"] . "<br>";
// 		echo "Product Price: " . $row["p_price"] . "<br>";
// 		echo "<br>";
// 	}
// } else {
// 	echo "0 results";
// }


// Kiểm tra kết quả truy vấn
if ($resultOrder->num_rows > 0) {
	// Duyệt qua từng hàng dữ liệu từ kết quả truy vấn
	while ($row = $resultOrder->fetch_assoc()) {
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
			"p_price" => $row["p_price"],
		);
	}
} else {
	// echo "0 results";
}




function sumTotalPrice($order_array, $u_id)
{
	$totalPrice = 0; // Khởi tạo biến tổng giá tiền

	// Duyệt qua từng sản phẩm trong giỏ hàng và tính tổng giá tiền
	foreach ($order_array as $item) {
		// Kiểm tra xem u_id của sản phẩm có khớp với u_id được chỉ định hay không
		if ($item["u_id"] == $u_id && $item["o_status"] == 0) {
			// Tính giá tiền của mỗi sản phẩm (giá tiền * số lượng)
			$productPrice = $item["p_price"] * $item["o_quantity"];

			// Cộng vào tổng giá tiền
			$totalPrice += $productPrice;
		}
	}

	return $totalPrice; // Trả về tổng giá tiền
}


//else echo "Test2<br>";

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


?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Product Details</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!-- link icon -->
	<link rel="icon" type="image/png" href="images/icon.png" />
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
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/slick/slick.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/MagnificPopup/magnific-popup.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/perfect-scrollbar/perfect-scrollbar.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!--===============================================================================================-->
</head>

<style>
	/* CSS to change the size of the image */
	.item-slick3 img {
		width: 100%;
		/* Set the width of the image to 100% of the parent element */
		height: auto;
		/* Allow the aspect ratio of the image to be maintained */
	}

	/* # for id */
	#font-size {
		font-size: 20px;
	}

	/* Setting size thumb image  */
	.wrap-slick3-dots {
		width: 20%;
	}

	/* Setting size display image  */
	.gallery-lb {
		width: 70%;
	}

	/* Zoom image */
	.zoom-container {
		position: relative;
		overflow: hidden;
		width: 100%;
	}

	.zoom-container img {
		width: 100%;
		height: auto;
		transition: transform 0.3s ease;
	}

	/* Zoom Hover */
	.zoom-container:hover img {
		transform: scale(1.5);
		/* Scale upsize 150% hover */
	}

	/* Add cart */
	#button-add {
		border-radius: 8px;
		padding: 10px;
		background-color: #F4538A;
		color: white;
		margin-bottom: 10px;
		/* Add margin to create space between buttons */
		width: 75%;
	}

	#button-add:hover {
		background-color: black;
	}

	/* Buy it now */
	#button-buy {
		border-radius: 8px;
		padding: 10px;
		padding-left: 10px;
		background-color: black;
		color: white;
		width: 75%;
	}

	/* Default hover effect */
	#button-buy:hover {
		background-color: #F4538A;
	}


	/* Radio button container style */
	.size-204 {
		display: flex;
		/* Use flexbox for the container */
		align-items: center;
		/* Align items vertically */
	}

	/* Radio button style */
	input[type="radio"] {
		display: none;
		/* Hide the default radio button */
	}

	/* Custom radio button style */
	input[type="radio"]+label {
		border-radius: 8px;
		padding: 10px;
		background-color: white;
		color: black;
		cursor: pointer;
		margin-right: 10px;
		/* Add margin to create space between buttons */
	}

	/* Styling for when radio button is checked */
	input[type="radio"]:checked+label {
		background-color: black;
		color: white;
	}

	#bolder {
		font-weight: bolder;
	}

	.info-item {
		margin-bottom: 10px;
	}

	.info-label {
		font-weight: bold;
	}

	.info-value {
		margin-left: 10px;
	}

	/* Responsive styles for screens up to 800px */
	@media (max-width: 800px) {

		.col-lg-6,
		.col-md-8,
		.col-sm-10 {
			width: 100%;
			/* Make columns full width on small screens */
		}
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
</style>


<body class="animsition">

	<!-- Header -->
	<header>
		<!-- Header desktop -->
		<div class="container-menu-desktop">
			<!-- Topbar -->
			<div class="top-bar">
				<div class="content-topbar flex-sb-m h-full container">
					<div class="left-top-bar">
						<div class="d-inline-flex align-items-center">
							<p style="color: #F4538A"><i class="fa fa-envelope mr-2"></i><a
									href="mailto:omachacontact@gmail.com"
									style="color: #000; text-decoration: none;">omachacontact@gmail.com</a></p>
							<p class="text-body px-3">|</p>
							<p style="color: #F4538A"><i class="fa fa-phone-alt mr-2"></i><a href="tel:+19223600"
									style="color: #000; text-decoration: none;">+1922 4800</a></p>
						</div>
					</div>

					<div class="col-lg-6 text-center text-lg-right">
						<div class="d-inline-flex align-items-center">
							<a class="text-primary px-3" href="https://www.facebook.com/profile.php?id=61557250007525"
								target="_blank" title="Visit the Reis Adventures fanpage.">
								<i style="color: #49243E;" class="fab fa-facebook-f"></i>
							</a>
							<a class="text-primary px-3" href="https://twitter.com/reis_adventures" target="_blank"
								title="Visit the Reis Adventures Twitter.">
								<i style="color: #49243E;" class="fab fa-twitter"></i>
							</a>
							<a class="text-primary px-3" href="https://www.linkedin.com/in/reis-adventures-458144300/"
								target="_blank" title="Visit the Reis Adventures Linkedin.">
								<i style="color: #49243E;" class="fab fa-linkedin-in"></i>
							</a>
							<a class="text-primary px-3"
								href="https://www.instagram.com/reis_adventures2024?igsh=YTQwZjQ0NmI0OA%3D%3D&utm_source=qr"
								target="_blank" title="Visit the Reis Adventures Instagram.">
								<i style="color: #49243E;" class="fab fa-instagram"></i>
							</a>
							<div class="data1">
								<i style="color: #49243E;" class=""></i>
								<a href="register.php" class="btn2 btn-primary2 mt-1"
									style="color: #49243E;"><b><?php echo $userLogin["userID"]; ?>
										/</b></a>
							</div>
							<div class="data2">
								<i style="color: #49243E;" class=""></i>
								<a href="register.php" class="btn2 btn-primary2 mt-1"
									style="color: #49243E;"><b><?php echo $userLogin["userName"]; ?></b></a>
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
							data-notify="<?php echo $order_count ?>">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="wishlist.php"
							class="dis-block icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
							data-notify="<?php echo $wishlist_count ?>">
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

				<div class="icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
					data-notify="<?php echo ($order_count); ?>">
					<i class="zmdi zmdi-shopping-cart"></i>
				</div>

				<a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
					data-notify="0">
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
						$p_images = array_map('trim', explode(',', $item["p_image"]));

						// mới có u_id $userLogin["userID"], 555
						if ($item["u_id"] == $userLogin["userID"] && $item["o_quantity"] > 0 && $item["o_status"] == 0) {
							?>
							<li class="header-cart-item m-b-20">
								<div class="row">
									<div class="col-md-3">
										<div class="header-cart-item-img">
											<!-- Hiện hình trong giỏ hàng -->
											<img src="images/<?php echo $p_images[0]; ?>" alt="IMG">
										</div>
									</div>
									<div class="col-md-6">
										<div>
											<!-- Hiện tên sản phẩm trong giỏ hàng -->
											<a href="#"
												class="header-cart-item-name hov-cl1 trans-04"><?php echo $item["p_name"]; ?></a>
										</div>
										<!-- Hiện số lượng sản phẩm và giá tiền -->
										<span class="header-cart-item-info"><?php echo $item["o_quantity"]; ?> x
											$<?php echo $item["p_price"]; ?></span>
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
						<a href="shopping-cart.php" id="btn-cart"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="your-order.php" id="btn-cart"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Your Order
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!-- breadcrumb -->
	<div class="container">
		<div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
			<a href="index.html" class="stext-109 cl8 hov-cl1 trans-04">
				Home
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<a href="product2.php" class="stext-109 cl8 hov-cl1 trans-04">
				Men
				<i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
			</a>

			<span class="stext-109 cl4">
				Lightweight Jacket
			</span>
		</div>
	</div>


	<!-- Product Detail -->
	<section class="sec-product-detail bg0 p-t-65 p-b-60">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-lg-7 p-b-30">
					<div class="p-l-25 p-r-30 p-lr-0-lg">
						<div class="wrap-slick3 flex-sb flex-w">
							<div class="wrap-slick3-dots"></div>
							<div class="slick3 gallery-lb">

								<!-- Image 1 -->
								<div class="item-slick3" data-thumb="images/<?php echo $product_images[0]; ?>">
									<div class="wrap-pic-w pos-relative zoom-container">
										<img src="images/<?php echo $product_images[0]; ?>" alt="IMG-PRODUCT">

										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
											href="images/teddy-bear-1.png">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<!-- Image 2 -->
								<div class="item-slick3" data-thumb="images/<?php echo $product_images[1]; ?>">
									<div class="wrap-pic-w pos-relative zoom-container">
										<img src="images/<?php echo $product_images[1]; ?>" alt="IMG-PRODUCT">
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
											href="images/teddy-bear-2.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

								<!-- Image 3 -->
								<div class="item-slick3" data-thumb="images/<?php echo $product_images[2]; ?>">
									<div class="wrap-pic-w pos-relative zoom-container">
										<img src="images/<?php echo $product_images[2]; ?>" alt="IMG-PRODUCT">
										<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
											href="images/teddy-bear-3.jpg">
											<i class="fa fa-expand"></i>
										</a>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<div class="col-md-6 col-lg-5 p-b-30">
					<div class="p-r-50 p-t-5 p-lr-0-lg">
						<h4 class="mtext-105 cl2 js-name-detail p-b-14">
							<?php echo $product["p_name"]; ?>
						</h4>

						<span class="mtext-106 cl2">
							$ <?php echo $product["p_price"]; ?>
						</span>

						<p class="stext-102 cl3 p-t-23">
							<?php echo $product["p_description"]; ?>
						</p>

						<!-- Size selection -->
						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div id="font-size" class="size-203 flex-c-m respon6">
									Size:
								</div>

								<div class="size-204 respon6-next">
									<!-- Radio buttons for size selection -->
									<div>
										<input type="radio" id="sizeS" name="size" value="Size S">
										<label for="sizeS">Size S</label>
									</div>
									<div>
										<input type="radio" id="sizeM" name="size" value="Size M">
										<label for="sizeM">Size M</label>
									</div>
									<div>
										<input type="radio" id="sizeL" name="size" value="Size L">
										<label for="sizeL">Size L</label>
									</div>
									<div>
										<input type="radio" id="sizeXL" name="size" value="Size XL">
										<label for="sizeXL">Size XL</label>
									</div>
									<!-- End of radio buttons -->
								</div>
							</div>
						</div>

						<!-- Color selection -->
						<div class="p-t-33">
							<div class="flex-w flex-r-m p-b-10">
								<div id="font-size" class="size-203 flex-c-m respon6">
									Color:
								</div>

								<div class="size-204 respon6-next">
									<!-- Radio buttons for size selection -->
									<div>
										<input type="radio" id="red" name="color" value="Red">
										<label for="red">Red</label>
									</div>
									<div>
										<input type="radio" id="blue" name="color" value="Blue">
										<label for="blue">Blue</label>
									</div>
									<div>
										<input type="radio" id="yellow" name="color" value="Yellow">
										<label for="yellow">Yellow</label>
									</div>
									<div>
										<input type="radio" id="green" name="color" value="Green">
										<label for="green">Green</label>
									</div>
									<!-- End of radio buttons -->
								</div>
							</div>
						</div>

						<div class="flex-w flex-r-m p-b-10">
							<div class="size-204 flex-w flex-m respon6-next">
								<div class="wrap-num-product flex-w m-r-20 m-tb-10">
									<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
										<i class="fs-16 zmdi zmdi-minus"></i>
									</div>

									<input id="quantity-input" class="mtext-104 cl3 txt-center num-product"
										type="number" name="num-product" value="<?php echo $quantity = 1; ?>">

									<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
										<i class="fs-16 zmdi zmdi-plus"></i>
									</div>
								</div>
							</div>

							<div class="size-204 flex-w flex-m respon6-next">
								<form action="add-to-cart.php" method="post">
									<!-- Name input is add-to-order -->
									<input type="submit" value="Add to cart" id="button-add" name="add-to-cart"
										class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
									<input type="hidden" name="p_id" value="<?php echo $product["p_id"]; ?>">
									<input type="hidden" name="p_image" value="<?php echo $product["p_image"]; ?>">
									<input type="hidden" name="p_name" value="<?php echo $product["p_name"]; ?>">
									<input type="hidden" name="p_price" value="<?php echo $product["p_price"]; ?>">
									<input type="hidden" name="p_type" value="<?php echo $product["p_type"]; ?>">
									<input type="hidden" name="o_quantity" id="hidden-quantity"
										value="<?php echo $quantity; ?>">
									<input type="hidden" name="o_status" value="0"> <!-- Nằm trong giỏ hàng -->
								</form>

								<form action="buy-it-now.php" method="post">
									<!-- Name input is buy-it-now -->
									<input type="submit" value="Buy it now" id="button-buy" name="buy-it-now"
										class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
									<input type="hidden" name="p_id" value="<?php echo $product["p_id"]; ?>">
									<input type="hidden" name="p_image" value="<?php echo $product["p_image"]; ?>">
									<input type="hidden" name="p_name" value="<?php echo $product["p_name"]; ?>">
									<input type="hidden" name="p_price" value="<?php echo $product["p_price"]; ?>">
									<input type="hidden" name="p_type" value="<?php echo $product["p_type"]; ?>">
									<input type="hidden" name="o_quantity" id="hidden-quantity-buy"
										value="<?php echo $quantity; ?>">
									<input type="hidden" name="o_status" value="0"> <!-- Nằm trong giỏ hàng -->
								</form>
							</div>
						</div>
					</div>

					<!--  -->
					<div class="flex-w flex-m p-l-100 p-t-40 respon7">
						<div class="flex-m bor9 p-r-10 m-r-11">
							<a href="#"
								class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
								data-tooltip="Add to Wishlist">
								<i class="zmdi zmdi-favorite"></i>
							</a>
						</div>

						<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
							data-tooltip="Facebook">
							<i class="fab fa-facebook"></i> <!-- Use "fab" for brand icons -->
						</a>

						<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
							data-tooltip="Twitter">
							<i class="fab fa-twitter"></i>
						</a>

						<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
							data-tooltip="Google Plus">
							<i class="fab fa-google-plus"></i>
						</a>
					</div>
				</div>
			</div>
		</div>

		<div class="bor10 m-t-50 p-t-43 p-b-40">
			<!-- Tab01 -->
			<div class="tab01">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<li class="nav-item p-b-10">
						<a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
					</li>

					<li class="nav-item p-b-10">
						<a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
					</li>

					<li class="nav-item p-b-10">
						<a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content p-t-43">
					<!-- Description -->
					<div class="tab-pane fade show active" id="description" role="tabpanel">
						<div class="how-pos2 p-lr-15-md">
							<p class="stext-102 cl6">
								<b>Shape and Size:</b> Teddy bears often have a bear-like appearance, with two ears, a
								round nose, and two round eyes.
								The size of a teddy bear can vary from small to large.
							</p>

							<p class="stext-102 cl6">
								<b>Material: </b> The product is made from soft and safe fabric materials such as
								sheepskin, fleece, cotton, or synthetic plush.
								Sometimes, accessories like silk or velvet fabric may also be used to create accents.

							<p class="stext-102 cl6">
								<b>Color: </b>Teddy bears can come in a variety of colors, from the natural brown of
								real bears to vibrant colors like pink, blue, and yellow.
								Colors are often chosen to reflect personality traits or create interesting accents for
								the product.
							</p>

							<p class="stext-102 cl6">
								<b>Accessories:</b> Some teddy bears may be adorned with accessories like knitted
								sweaters, bow ties, or ribbons.
								These accessories are often added to create unique styles or make the product more
								adorable.
							</p>

							<p class="stext-102 cl6">
								<b>Safety and Quality: </b>Teddy bear products are typically manufactured to high safety
								standards, ensuring that they are safe for children and pose no health hazards.
								The quality of the product is also ensured to ensure that the teddy bear is durable and
								maintains its shape and color after repeated use.
							</p>
						</div>
					</div>

					<!-- Additional information -->
					<div class="tab-pane fade" id="information" role="tabpanel">
						<div style="margin-left: 50px;" class="how-pos2 p-lr-15-md">
							<div class="row how-pos2 p-lr-15-md">
								<div class="stext-102 cl6 col-md-6">
									<div class="info-item">
										<span class="info-label">Weight:</span>
										<span class="info-value">0.79 kg</span>
									</div>
								</div>
								<div class="stext-102 cl6 col-md-6">
									<div class="info-item">
										<span class="info-label">Dimensions:</span>
										<span class="info-value">110 x 33 x 100 cm</span>
									</div>
								</div>
								<div class="stext-102 cl6 col-md-6">
									<div class="info-item">
										<span class="info-label">Materials:</span>
										<span class="info-value">60% cotton</span>
									</div>
								</div>
								<div class="stext-102 cl6 col-md-6">
									<div class="info-item">
										<span class="info-label">Color:</span>
										<span class="info-value">Black, Blue, Grey, Green, Red, White</span>
									</div>
								</div>
								<div class="stext-102 cl6 col-md-6">
									<div class="info-item">
										<span class="info-label">Size:</span>
										<span class="info-value">XL, L, M, S</span>
									</div>
								</div>
							</div>
						</div>
					</div>

					<!-- - -->
					<div class="tab-pane fade" id="reviews" role="tabpanel">
						<div class="row">
							<div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
								<div class="p-b-30 m-lr-15-sm">
									<!-- Review -->
									<div class="flex-w flex-t p-b-68">
										<div>
											<div class="flex-w flex-sb-m p-b-17">
												<span class="mtext-107 cl2 p-r-20">
													Ariana Grande
												</span>

												<span class="fs-18 cl11">
													<i class="zmdi zmdi-star"></i>
													<i class="zmdi zmdi-star"></i>
													<i class="zmdi zmdi-star"></i>
													<i class="zmdi zmdi-star"></i>
													<i class="zmdi zmdi-star-half"></i>
												</span>
											</div>

											<p class="stext-102 cl6">
												With soft materials and eye-catching colors, cotton buckets are the
												perfect choice for children to play and simulate daily activities such
												as bathing, cooking, or taking care of their small family.
											</p>
										</div>
									</div>

									<div>
										<?php
										$sql = "SELECT * from review";
										$query = mysqli_query($conn, $sql);
										while ($review = mysqli_fetch_assoc($query)) {
											?>
											<div class="flex-w flex-t p-b-68">
												<div>
													<div class="flex-w flex-sb-m p-b-17">
														<span class="mtext-107 cl2 p-r-20">
															<?php echo $review['r_name']; ?>
														</span>
														<span class="fs-18 cl11">
															<?php
															// Tính toán và hiển thị số lượng sao
															$stars = $review['r_star'];
															for ($i = 1; $i <= 5; $i++) {
																if ($i <= $stars) {
																	echo '<i class="zmdi zmdi-star"></i>';
																} else {
																	echo '<i class="zmdi zmdi-star-outline"></i>';
																}
															}
															?>
														</span>
													</div>
													<p class="stext-102 cl6">
														<?php echo $review['r_description']; ?>
													</p>
												</div>
											</div>
										<?php } ?>
									</div>


									<!-- Add review -->
									<form class="w-full" method="POST" enctype="multipart/form-data"
										action="productdetail.php">
										<h5 class="mtext-108 cl2 p-b-7">
											Add a review
										</h5>

										<p class="stext-102 cl6">
											Your email address will not be published. Required fields are marked *
										</p>

										<div class="flex-w flex-m p-t-50 p-b-23">
											<span class="stext-102 cl3 m-r-16">
												Your Rating
											</span>

											<span class="wrap-rating fs-18 cl11 pointer">
												<i class="item-rating pointer zmdi zmdi-star-outline"></i>
												<i class="item-rating pointer zmdi zmdi-star-outline"></i>
												<i class="item-rating pointer zmdi zmdi-star-outline"></i>
												<i class="item-rating pointer zmdi zmdi-star-outline"></i>
												<i class="item-rating pointer zmdi zmdi-star-outline"></i>
												<input class="dis-none" type="number" name="r_star">
											</span>
										</div>

										<div class="row p-b-25">
											<div class="col-12 p-b-5">
												<label class="stext-102 cl3" for="review">Your review</label>
												<textarea class="size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10"
													id="review" name="r_description"></textarea>
											</div>

											<div class="col-sm-6 p-b-5">
												<label class="stext-102 cl3" for="name">Name</label>
												<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="name" type="text"
													name="r_name">
											</div>

											<div class="col-sm-6 p-b-5">
												<label class="stext-102 cl3" for="email">Email</label>
												<input class="size-111 bor8 stext-102 cl2 p-lr-20" id="email"
													type="text" name="r_email">
												<input type="hidden"
													class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6"
													style="background-color: white;" name="p_name"
													value="<?php echo $product["p_name"]; ?>">
												<input type="hidden" name="user"
													value="<?php $userLogin["userName"]; ?>">
											</div>
										</div>

										<button
											class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10"
											name="sbm">
											Submit
										</button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>



	</section>


	<!-- Related Products -->
	<section class="sec-relate-product bg0 p-t-45 p-b-105">
		<div class="container">
			<div class="p-b-45">
				<h3 class="ltext-106 cl5 txt-center">
					Related Products
				</h3>
			</div>

			<!-- Slide2 -->
			<div class="wrap-slick2">
				<div class="slick2">
					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/jellycat.png" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Strawberry Jelly Cat
									</a>

									<span class="stext-105 cl3">
										$12.99
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/Elephant.png" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Elephant Jelly Cat
									</a>

									<span class="stext-105 cl3">
										$10.99
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/giraffe.png" alt="IMG-PRODUCT">
								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Giraffe Jelly Cat
									</a>

									<span class="stext-105 cl3">
										$12.99
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/beartowel.png" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Bear Baby Tower
									</a>

									<span class="stext-105 cl3">
										$12.99
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/Jelly Cat Flower.png" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Flower Jelly Cat
									</a>

									<span class="stext-105 cl3">
										$10.99
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/duck.png" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Duck
									</a>

									<span class="stext-105 cl3">
										$5.25
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/bearjellycat.png" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Bear Jelly Cat
									</a>

									<span class="stext-105 cl3">
										$10.99
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>

					<div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
						<!-- Block2 -->
						<div class="block2">
							<div class="block2-pic hov-img0">
								<img src="images/unicorn.png" alt="IMG-PRODUCT">

								<a href="#"
									class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
									Quick View
								</a>
							</div>

							<div class="block2-txt flex-w flex-t p-t-14">
								<div class="block2-txt-child1 flex-col-l ">
									<a href="product-detail.html"
										class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
										Unicorn
									</a>

									<span class="stext-105 cl3">
										$10.99
									</span>
								</div>

								<div class="block2-txt-child2 flex-r p-t-3">
									<a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
										<img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
											alt="ICON">
										<img class="icon-heart2 dis-block trans-04 ab-t-l"
											src="images/icons/icon-heart-02.png" alt="ICON">
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>

	    <!-- Footer -->
		<footer class="bg3 p-t-75 p-b-32">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl10 p-b-30">
                        Legal
                    </h4>

                    <ul>
                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Faq
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Retailers
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Privacy Policy
                            </a>
                        </li>

                        <li class="p-b-10">
                            <a href="#" class="stext-107 cl7 hov-cl1 trans-04">
                                Cookies
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl10 p-b-30">
                        Services
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
                    <h4 class="stext-301 cl10 p-b-30">
                        GET IN TOUCH
                    </h4>

                    <p class="stext-107 cl7 size-201">
                        Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us
                        on (+1) 96 716 6879
                    </p>

                    <div class="p-t-27">
                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa-brands fa-facebook fa-lg" style="color: #ea539c;"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa-brands fa-instagram fa-lg" style="color: #e151a5;"></i>
                        </a>

                        <a href="#" class="fs-18 cl7 hov-cl1 trans-04 m-r-16">
                            <i class="fa-brands fa-pinterest fa-lg" style="color: #e74b7a;"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6 col-lg-3 p-b-50">
                    <h4 class="stext-301 cl10 p-b-30">
                        Newsletter
                    </h4>

                    <form>
                        <div class="wrap-input1 w-full p-b-4">
                            <input class="input1 bg-none plh1 stext-107 cl7" type="text" name="email"
                                placeholder="email@example.com">
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
                    Copyright &copy;
                    <script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i
                        class="fa fa-heart-o" aria-hidden="true"></i> Group 5
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

	<!-- Modal1 -->
	<div class="wrap-modal1 js-modal1 p-t-60 p-b-20">
		<div class="overlay-modal1 js-hide-modal1"></div>

		<div class="container">
			<div class="bg0 p-t-60 p-b-30 p-lr-15-lg how-pos3-parent">
				<button class="how-pos3 hov3 trans-04 js-hide-modal1">
					<img src="images/icons/icon-close.png" alt="CLOSE">
				</button>

				<div class="row">
					<div class="col-md-6 col-lg-7 p-b-30">
						<div class="p-l-25 p-r-30 p-lr-0-lg">
							<div class="wrap-slick3 flex-sb flex-w">
								<div class="wrap-slick3-dots"></div>
								<div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

								<div class="slick3 gallery-lb">
									<div class="item-slick3" data-thumb="images/teddy-bear-1.png">
										<div class="wrap-pic-w pos-relative">
											<img src="images/teddy-bear-1.png" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/teddy-bear-1.png">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="images/teddy-bear-2.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/teddy-bear-2.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/teddy-bear-2.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>

									<div class="item-slick3" data-thumb="images/teddy-bear-3.jpg">
										<div class="wrap-pic-w pos-relative">
											<img src="images/teddy-bear-3.jpg" alt="IMG-PRODUCT">

											<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
												href="images/teddy-bear-3.jpg">
												<i class="fa fa-expand"></i>
											</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-6 col-lg-5 p-b-30">
						<div class="p-r-50 p-t-5 p-lr-0-lg">
							<h4 class="mtext-105 cl2 js-name-detail p-b-14">
								Lightweight Jacket
							</h4>

							<span class="mtext-106 cl2">
								$58.79
							</span>

							<p class="stext-102 cl3 p-t-23">
								Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris consequat
								ornare feugiat.
							</p>

							<!--  -->
							<div class="p-t-33">
								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Size
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Size S</option>
												<option>Size M</option>
												<option>Size L</option>
												<option>Size XL</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-203 flex-c-m respon6">
										Color
									</div>

									<div class="size-204 respon6-next">
										<div class="rs1-select2 bor8 bg0">
											<select class="js-select2" name="time">
												<option>Choose an option</option>
												<option>Red</option>
												<option>Blue</option>
												<option>White</option>
												<option>Grey</option>
											</select>
											<div class="dropDownSelect2"></div>
										</div>
									</div>
								</div>

								<div class="flex-w flex-r-m p-b-10">
									<div class="size-204 flex-w flex-m respon6-next">
										<div class="wrap-num-product flex-w m-r-20 m-tb-10">
											<div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-minus"></i>
											</div>

											<input class="mtext-104 cl3 txt-center num-product" type="number"
												name="num-product" value="1">

											<div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
												<i class="fs-16 zmdi zmdi-plus"></i>
											</div>
										</div>

										<button
											class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
											Add to cart
										</button>
									</div>
								</div>
							</div>

							<!--  -->
							<div class="flex-w flex-m p-l-100 p-t-40 respon7">
								<div class="flex-m bor9 p-r-10 m-r-11">
									<a href="#"
										class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
										data-tooltip="Add to Wishlist">
										<i class="zmdi zmdi-favorite"></i>
									</a>
								</div>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Facebook">
									<i class="fa fa-facebook"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Twitter">
									<i class="fa fa-twitter"></i>
								</a>

								<a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
									data-tooltip="Google Plus">
									<i class="fa fa-google-plus"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
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
		$(".js-select2").each(function () {
			$(this).select2({
				minimumResultsForSearch: 20,
				dropdownParent: $(this).next('.dropDownSelect2')
			});
		})
	</script>
	<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/slick/slick.min.js"></script>
	<script src="js/slick-custom.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/parallax100/parallax100.js"></script>
	<script>
		$('.parallax100').parallax100();
	</script>
	<!--===============================================================================================-->
	<script src="vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
	<script>
		$('.gallery-lb').each(function () { // the containers for all your galleries
			$(this).magnificPopup({
				delegate: 'a', // the selector for gallery item
				type: 'image',
				gallery: {
					enabled: true
				},
				mainClass: 'mfp-fade'
			});
		});
	</script>
	<!--===============================================================================================-->
	<script src="vendor/isotope/isotope.pkgd.min.js"></script>
	<!--===============================================================================================-->
	<script src="vendor/sweetalert/sweetalert.min.js"></script>
	<script>
		$('.js-addwish-b2, .js-addwish-detail').on('click', function (e) {
			e.preventDefault();
		});

		$('.js-addwish-b2').each(function () {
			var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
			$(this).on('click', function () {
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-b2');
				$(this).off('click');
			});
		});

		$('.js-addwish-detail').each(function () {
			var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

			$(this).on('click', function () {
				swal(nameProduct, "is added to wishlist !", "success");

				$(this).addClass('js-addedwish-detail');
				$(this).off('click');
			});
		});

		/*---------------------------------------------*/

		$('.js-addcart-detail').each(function () {
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function () {
				swal(nameProduct, "is added to cart !", "success");
			});
		});

		$('.js-buycart-detail').each(function () {
			var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
			$(this).on('click', function () {
				swal(nameProduct, "is ready to buy !", "success");
			});
		});

		// Zoom Image
		$(document).ready(function () {
			$(".zoom-container").mousemove(function (e) {
				var image = $(this).find("img");
				var offsetX = e.pageX - $(this).offset().left;
				var offsetY = e.pageY - $(this).offset().top;
				var posX = offsetX / $(this).width() * 100;
				var posY = offsetY / $(this).height() * 100;
				image.css("transform-origin", posX + "% " + posY + "%");
			});
		});
	</script>
	<!--===============================================================================================-->
	<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
	<script>
		$('.js-pscroll').each(function () {
			$(this).css('position', 'relative');
			$(this).css('overflow', 'hidden');
			var ps = new PerfectScrollbar(this, {
				wheelSpeed: 1,
				scrollingThreshold: 1000,
				wheelPropagation: false,
			});

			$(window).on('resize', function () {
				ps.update();
			})
		});

		document.getElementById("button-add").addEventListener("click", function () {
			var productId = 123; // Thay đổi productId bằng ID thực của sản phẩm
			var quantity = 1; // Số lượng sản phẩm, bạn có thể thay đổi tùy theo yêu cầu

			var xhr = new XMLHttpRequest();
			xhr.open("POST", "add_to_cart.php", true);
			xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
			xhr.onreadystatechange = function () {
				if (xhr.readyState === 4 && xhr.status === 200) {
					// Xử lý phản hồi từ máy chủ (nếu cần)
					console.log(xhr.responseText);
				}
			};
			xhr.send("productId=" + productId + "&quantity=" + quantity);
		});

		// Người dùng lựa chọn số lượng sản phẩm để thêm vào giỏ hàng
		document.addEventListener("DOMContentLoaded", function () {
			var quantityInput = document.getElementById("quantity-input");
			var hiddenQuantity = document.getElementById("hidden-quantity");
			var hiddenQuantityBuy = document.getElementById("hidden-quantity-buy");

			// Lắng nghe sự kiện thay đổi giá trị trong ô input
			quantityInput.addEventListener("change", function () {
				// Cập nhật giá trị biến quantity
				var quantity = parseInt(this.value);
				hiddenQuantity.value = quantity;
				hiddenQuantityBuy.value = quantity;
			});

			// Lắng nghe sự kiện nhấn nút tăng giảm số lượng
			var buttons = document.querySelectorAll(".btn-num-product-up, .btn-num-product-down");
			buttons.forEach(function (button) {
				button.addEventListener("click", function () {
					// Cập nhật giá trị biến quantity
					var currentValue = parseInt(quantityInput.value);
					var newValue = this.classList.contains("btn-num-product-up") ? currentValue : currentValue;
					quantityInput.value = newValue >= 1 ? newValue : 1;
					hiddenQuantity.value = quantityInput.value;
					hiddenQuantityBuy.value = quantityInput.value;
				});
			});
		});

		// Truyền biến PHP vào JavaScript
		var images = "<?php echo $product["p_image"]; ?>";

		// Tách chuỗi thành mảng
		var imageArray = images.split(',');

		// Container để chứa các hình ảnh
		var container = document.getElementById('image-container');

		// Duyệt qua từng hình ảnh trong mảng và tạo các phần tử hình ảnh
		imageArray.forEach(function (imagePath, index) {
			var img = document.createElement('img');
			img.src = imagePath;

			// Thêm các class màu sắc khác nhau dựa vào index
			if (index % 3 === 0) {
				img.classList.add('image-1');
			} else if (index % 3 === 1) {
				img.classList.add('image-2');
			} else {
				img.classList.add('image-3');
			}

			container.appendChild(img);
		})

	</script>
	<!--===============================================================================================-->
	<script src="js/main.js"></script>


</body>

</html>