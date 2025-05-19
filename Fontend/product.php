<?php
    require_once '../Admin/connection/connectData.php';
    $sql = "SELECT * FROM product";
    $query = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title>Product</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
	<link rel="stylesheet" href="css/cart.css">
	<link rel="stylesheet" href="css/box.css">
	<!-- link icon -->
	<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
		href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

	<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">
	<!--===============================================================================================-->

	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
	<link rel="icon" type="image/png" href="images/icons/favicon.png" />
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
	<link rel="stylesheet" type="text/css" href="css/product_res.css">

	<!--===============================================================================================-->
</head>

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
								<a href="register.html" class="btn2 btn-primary2 mt-1" style="color: #49243E;"><b>Login
										/</b></a>
							</div>
							<div class="data2">
								<i style="color: #49243E;" class=""></i>
								<a href="register.html" class="btn2 btn-primary2 mt-1"
									style="color: #49243E;"><b>Register</b></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="wrap-menu-desktop" style="background-color: #FFEFEF;">
				<nav class="limiter-menu-desktop container" style="background-color: #FFEFEF;">

					<!-- Logo desktop -->
					<a href="index.html" class="navbar-brand">
						<h1 class="m-0 text-primary1 mt-3 "><span class="text-dark1"><img class="Imagealignment"
									src="images/icon.png">Omacha</h1>
					</a>

					<!-- Menu desktop -->
					<div class="menu-desktop">
						<ul class="main-menu">
							<li class="active-menu">
								<a href="index.html">Home</a>

							</li>

							<li class="label1" data-label1="hot">
								<a href="product.html">Shop</a>
								<ul class="sub-menu">
									<li><a href="index.html">Homepage 1</a></li>
									<li><a href="home-02.html">Homepage 2</a></li>
									<li><a href="home-03.html">Homepage 3</a></li>
								</ul>
							</li>

							<li>
								<a href="blog.html">Blog</a>
							</li>

							<li>
								<a href="contact.html">Contact</a>
							</li>

							<li>
								<a href="about.html">Pages</a>
								<ul class="sub-menu">
									<li><a href="index.html">About</a></li>
									<li><a href="home-02.html">Faq</a></li>
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
							data-notify="2">
							<i class="zmdi zmdi-shopping-cart"></i>
						</div>

						<a href="#"
							class="dis-block icon-header-item cl13 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
							data-notify="0">
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

				<div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
					data-notify="2">
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
			<ul class="topbar-mobile">
				<li>
					<div class="left-top-bar ">
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
			</ul>

			<ul class="main-menu-m">
				<li>
					<a href="index.html">Home</a>
					<ul class="sub-menu-m">
						<li><a href="index.html">Homepage 1</a></li>
						<li><a href="home-02.html">Homepage 2</a></li>
						<li><a href="home-03.html">Homepage 3</a></li>
					</ul>
					<span class="arrow-main-menu-m">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</span>
				</li>

				<li>
					<a href="product.html">Shop</a>
				</li>

				<li>
					<a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
				</li>

				<li>
					<a href="blog.html">Blog</a>
				</li>

				<li>
					<a href="about.html">About</a>
				</li>

				<li>
					<a href="contact.html">Contact</a>
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
					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="images/item-cart-01.jpg" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								White Shirt Pleat
							</a>

							<span class="header-cart-item-info">
								1 x $19.00
							</span>
						</div>
					</li>

					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="images/item-cart-02.jpg" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Converse All Star
							</a>

							<span class="header-cart-item-info">
								1 x $39.00
							</span>
						</div>
					</li>

					<li class="header-cart-item flex-w flex-t m-b-12">
						<div class="header-cart-item-img">
							<img src="images/item-cart-03.jpg" alt="IMG">
						</div>

						<div class="header-cart-item-txt p-t-8">
							<a href="#" class="header-cart-item-name m-b-18 hov-cl1 trans-04">
								Nixon Porter Leather
							</a>

							<span class="header-cart-item-info">
								1 x $17.00
							</span>
						</div>
					</li>
				</ul>

				<div class="w-full">
					<div class="header-cart-total w-full p-tb-40">
						Total: $75.00
					</div>

					<div class="header-cart-buttons flex-w w-full">
						<a href="shoping-cart.html"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-r-8 m-b-10">
							View Cart
						</a>

						<a href="shoping-cart.html"
							class="flex-c-m stext-101 cl0 size-107 bg3 bor2 hov-btn3 p-lr-15 trans-04 m-b-10">
							Check Out
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>




	<!-- Product -->
	<div class="bg0 m-t-23 p-b-140" id="product_res">

		<div style="padding-top: 100px;" class="container">

			<div class="flex-w flex-sb-m p-b-52" style="transform: translateX(120px);">

				<div  class="flex-w flex-l-m filter-tope-group m-tb-10">
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1 allproductMobile" data-filter="*">
						All Products
					</button>
					<fieldset>
						<legend>
							<button id="PriceButtonMobile" type="button"> Price <i><i id="icon_muitenPrice"
										class="fa-sharp fa-thin fa-chevron-up"
										style="padding-left: 70px;height: 4px;padding-top: 40px;"></i></i></button>
						</legend>
					</fieldset>
					<ul id="PriceListMobile" style="display: none;">
						<!-- <button type="button"><li>Cotton</li></button>  -->

						<fieldset>
							<legend>
								<span class="hand-icon">50$</span><input type="checkbox" value="Cotton"
									style="transform: translateX(80px) translateY(-20px) ;font-size: 30px;">
							</legend>
						</fieldset>
						<fieldset>
							<legend>
								<span class="hand-icon">20$</span><input type="checkbox" value="Cotton"
									style="transform: translateX(80px) translateY(-20px) ;">
							</legend>
						</fieldset>
						<fieldset>
							<legend>
								<span class="hand-icon">30$</span><input type="checkbox" value="Cotton"
									style="transform: translateX(80px) translateY(-20px) ;">
							</legend>
						</fieldset>






					</ul>
					<button id="materialButton1" type="button" class="filter2 materialwhen2 "> Material <i><i id="icon_muitenmobile"
								class="fa-sharp fa-thin fa-chevron-up"
								style="padding-left: 40px;height: 4px;padding-top: 40px;"></i></i></button>
								<ul id="materialList1" style="display: none;">
									<!-- <button type="button"><li>Cotton</li></button>  -->
		
									<fieldset>
										<legend>
											<span class="hand-icon">Cotton</span><input type="checkbox" value="Cotton"
												style="transform: translateX(80px) translateY(-20px) ;">
										</legend>
									</fieldset>
									<fieldset>
										<legend>
											<span class="hand-icon">Fur</span><input type="checkbox" value="Cotton"
												style="transform: translateX(80px) translateY(-20px) ;">
										</legend>
									</fieldset>
									</ul>
								<script>
									// Lấy tham chiếu đến các phần tử DOM
									const PriceButtonMobile = document.getElementById('PriceButtonMobile');
									const PriceListMobile = document.getElementById('PriceListMobile');
									const iconmuitenPrice = document.querySelector('#icon_muitenPrice');
			
									// Thêm sự kiện click cho nút "Material"
									PriceButtonMobile.addEventListener('click', function () {
										// Kiểm tra trạng thái hiển thị của danh sách vật liệu
										const isMaterialListVisible2 = PriceListMobile.style.display === 'block';
										// Đảo ngược trạng thái hiển thị
										PriceListMobile.style.display = isMaterialListVisible2 ? 'none' : 'block';
			
										// Đổi icon
										if (isMaterialListVisible2) {
											iconmuitenPrice.classList.remove('fa-chevron-up');
											iconmuitenPrice.classList.add('fa-chevron-down');
											PriceListMobile.classList.remove('mucbienmat');
											PriceListMobile.classList.add('mucxuathien');
										} else {
											iconmuitenPrice.classList.remove('fa-chevron-down');
											iconmuitenPrice.classList.add('fa-chevron-up');
											PriceListMobile.classList.remove('mucxuathien');
											PriceListMobile.classList.add('mucbienmat');
										}
									});
			
								</script>
								<script>
									// Lấy tham chiếu đến các phần tử DOM
									const materialButton1 = document.getElementById('materialButton1');
									const materialList1 = document.getElementById('materialList1');
									const iconElementmobile = document.querySelector('#icon_muitenmobile');
			
									// Thêm sự kiện click cho nút "Material"
									materialButton1.addEventListener('click', function () {
										// Kiểm tra trạng thái hiển thị của danh sách vật liệu
										const isMaterialListVisibleMobile = materialList1.style.display === 'block';
										// Đảo ngược trạng thái hiển thị
										materialList1.style.display = isMaterialListVisibleMobile ? 'none' : 'block';
			
										// Đổi icon
										if (isMaterialListVisibleMobile) {
											iconElementmobile.classList.remove('fa-chevron-up');
											iconElementmobile.classList.add('fa-chevron-down');
										} else {
											iconElementmobile.classList.remove('fa-chevron-down');
											iconElementmobile.classList.add('fa-chevron-up');
										}
									});
			
								</script>
					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 " data-filter=".toy" id="toy">
						Toy
					</button>

					<button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 pillowMobile" data-filter=".pillow">
						Pillow
					</button>


				</div>

				<div class="flex-w flex-c-m m-tb-10">


					<div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
						<i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
						<i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
						Search
					</div>
				</div>

				<!-- Search product -->
				<div class="dis-none panel-search w-full p-t-10 p-b-15">
					<div class="bor8 dis-flex p-l-15">
						<button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
							<i class="zmdi zmdi-search"></i>
						</button>

						<input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
							placeholder="Search">
					</div>
				</div>




			</div>

			<div class="row isotope-grid " style="transform: translateX(100px);">
				<div style="transform: translateX(-250px);box-sizing: border-box;
    
				border: 0.1px dashed #000;
				border-top:none;border-bottom: none;border-left: none;padding-right: 100px;">

					<h2>Filter:</h2>

					<div>
						<fieldset>
							<legend>
								<button id="materialButton" type="button"> Material <i><i id="icon_muiten"
											class="fa-sharp fa-thin fa-chevron-up"
											style="padding-left: 40px;height: 4px;padding-top: 40px;"></i></i></button>
							</legend>
						</fieldset>
						<ul id="materialList" style="display: none;">
							<!-- <button type="button"><li>Cotton</li></button>  -->

							<fieldset>
								<legend>
									<span class="hand-icon">Cotton</span><input type="checkbox" value="Cotton"
										style="transform: translateX(80px) translateY(-20px) ;">
								</legend>
							</fieldset>
							<fieldset>
								<legend>
									<span class="hand-icon">Fur</span><input type="checkbox" value="Cotton"
										style="transform: translateX(80px) translateY(-20px) ;">
								</legend>
							</fieldset>






						</ul>
					</div>
					<div>
						<fieldset>
							<legend>
								<button id="PriceButton" type="button"> Price <i><i id="icon_muiten1"
											class="fa-sharp fa-thin fa-chevron-up"
											style="padding-left: 70px;height: 4px;padding-top: 40px;"></i></i></button>
							</legend>
						</fieldset>
						<ul id="PriceList" style="display: none;">
							<!-- <button type="button"><li>Cotton</li></button>  -->

							<fieldset>
								<legend>
									<span class="hand-icon">50$</span><input type="checkbox" value="Cotton"
										style="transform: translateX(80px) translateY(-20px) ;font-size: 30px;">
								</legend>
							</fieldset>
							<fieldset>
								<legend>
									<span class="hand-icon">20$</span><input type="checkbox" value="Cotton"
										style="transform: translateX(80px) translateY(-20px) ;">
								</legend>
							</fieldset>
							<fieldset>
								<legend>
									<span class="hand-icon">30$</span><input type="checkbox" value="Cotton"
										style="transform: translateX(80px) translateY(-20px) ;">
								</legend>
							</fieldset>






						</ul>
					</div>
					<script>
						// Lấy tham chiếu đến các phần tử DOM
						const PriceButton = document.getElementById('PriceButton');
						const PriceList = document.getElementById('PriceList');
						const iconElement1 = document.querySelector('#icon_muiten1');

						// Thêm sự kiện click cho nút "Material"
						PriceButton.addEventListener('click', function () {
							// Kiểm tra trạng thái hiển thị của danh sách vật liệu
							const isMaterialListVisible1 = PriceList.style.display === 'block';
							// Đảo ngược trạng thái hiển thị
							PriceList.style.display = isMaterialListVisible1 ? 'none' : 'block';

							// Đổi icon
							if (isMaterialListVisible1) {
								iconElement1.classList.remove('fa-chevron-up');
								iconElement1.classList.add('fa-chevron-down');
							} else {
								iconElement1.classList.remove('fa-chevron-down');
								iconElement1.classList.add('fa-chevron-up');
							}
						});

					</script>
					<script>
						// Lấy tham chiếu đến các phần tử DOM
						const materialButton = document.getElementById('materialButton');
						const materialList = document.getElementById('materialList');
						const iconElement = document.querySelector('#icon_muiten');

						// Thêm sự kiện click cho nút "Material"
						materialButton.addEventListener('click', function () {
							// Kiểm tra trạng thái hiển thị của danh sách vật liệu
							const isMaterialListVisible = materialList.style.display === 'block';
							// Đảo ngược trạng thái hiển thị
							materialList.style.display = isMaterialListVisible ? 'none' : 'block';

							// Đổi icon
							if (isMaterialListVisible) {
								iconElement.classList.remove('fa-chevron-up');
								iconElement.classList.add('fa-chevron-down');
							} else {
								iconElement.classList.remove('fa-chevron-down');
								iconElement.classList.add('fa-chevron-up');
							}
						});

					</script>

				</div>
				<div id="imgBear" class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy">

					<!-- Block2 -->
					<div class="block2">

						<div id="bear" class="block2-pic hov-img0 box  ">
							<img src="images/beardollyellow.jpg" alt="IMG-PRODUCT">

							<div>
								<i id="cart1" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1 cart1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;  "></i>
								<i id="love1" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view1" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv = document.querySelector('#cart1');
								var imageofbear = document.querySelector('#bear');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofbear.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv.style.visibility = 'visible';
									iconDiv.style.transform = 'translateY(-200px) translateX(230px) scale(2.0)';
								});
								imageofbear.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv.style.visibility = 'hidden';
									iconDiv.style.transform = 'translateY(-200px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconlove = document.querySelector('#love1');
								var imageofbear = document.querySelector('#bear');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofbear.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove.style.visibility = 'visible';
									iconlove.style.transform = 'translateY(-160px) translateX(210px) scale(2.0)';
								});
								imageofbear.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove.style.visibility = 'hidden';
									iconlove.style.transform = 'translateY(-160px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box = document.querySelector('.box');
								var imageofbear = document.querySelector('#bear');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofbear.addEventListener('mouseover', function () {
									box.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofbear.addEventListener('mouseout', function () {
									box.style.borderColor = "#000";
								});
							</script>
							<script>
								const iconview1 = document.querySelector('#view1');
								var imageofbear = document.querySelector('#bear');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofbear.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview1.style.visibility = 'visible';
									iconview1.style.transform = 'translateY(-230px) translateX(190px) scale(2.0)';
								});
								imageofbear.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview1.style.visibility = 'hidden';
									iconview1.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text">
									Teddy bear
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>

								<span class="stext-105 cl3  price">
									$16.64
								</span>
							</div>

							<div class="block2-txt-child2 flex-r p-t-3">

							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy">
					<!-- Block2 -->
					<div class="block2">
						<div id="doll" class="block2-pic hov-img0 box1">
							<img src="images/babydoll.jpg" alt="IMG-PRODUCT">


							<div>
								<i id="cart2" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;  "></i>
								<i id="love2" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view2" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>

							</div>
							<script>
								const iconDiv1 = document.querySelector('#cart2');
								var imageofdoll = document.querySelector('#doll');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdoll.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv1.style.visibility = 'visible';
									iconDiv1.style.transform = 'translateY(-200px) translateX(230px) scale(2.0)';
								});
								imageofdoll.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv1.style.visibility = 'hidden';
									iconDiv1.style.transform = 'translateY(-200px) translateX(250px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box1 = document.querySelector('.box1');
								var imageofdoll = document.querySelector('#doll');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofdoll.addEventListener('mouseover', function () {
									box1.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofdoll.addEventListener('mouseout', function () {
									box1.style.borderColor = "#000";
								});
							</script>
							<script>
								const iconlove2 = document.querySelector('#love2');
								var imageofdoll = document.querySelector('#doll');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdoll.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove2.style.visibility = 'visible';
									iconlove2.style.transform = 'translateY(-160px) translateX(210px) scale(2.0)';
								});
								imageofdoll.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove2.style.visibility = 'hidden';
									iconlove2.style.transform = 'translateY(-160px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview2 = document.querySelector('#view2');
								var imageofdoll = document.querySelector('#doll');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdoll.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview2.style.visibility = 'visible';
									iconview2.style.transform = 'translateY(-230px) translateX(190px) scale(2.0)';
								});
								imageofdoll.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview2.style.visibility = 'hidden';
									iconview2.style.transform = 'translateY(-230px) translateX(210px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>


						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									Baby doll
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$35.31
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy">
					<!-- Block2 -->
					<div class="block2">
						<div id="rabbit" class="block2-pic hov-img0 box2 ">
							<img src="images/rabbitdoll.png" alt="IMG-PRODUCT">

							<div>
								<i id="cart3" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;height: 40px;  "></i>
								<i id="love3" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view3" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv2 = document.querySelector('#cart3');
								var imageofrabbit = document.querySelector('#rabbit');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofrabbit.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv2.style.visibility = 'visible';
									iconDiv2.style.transform = 'translateY(-180px) translateX(230px) scale(2.0)';
								});
								imageofrabbit.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv2.style.visibility = 'hidden';
									iconDiv2.style.transform = 'translateY(-180px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box2 = document.querySelector('.box2');
								var imageofrabbit = document.querySelector('#rabbit');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofrabbit.addEventListener('mouseover', function () {
									box2.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofrabbit.addEventListener('mouseout', function () {
									box2.style.borderColor = "#000";
								});
							</script>
							<script>
								const iconlove3 = document.querySelector('#love3');
								var imageofrabbit = document.querySelector('#rabbit');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofrabbit.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove3.style.visibility = 'visible';
									iconlove3.style.transform = 'translateY(-160px) translateX(210px) scale(2.0)';
								});
								imageofrabbit.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove3.style.visibility = 'hidden';
									iconlove3.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview3 = document.querySelector('#view3');
								var imageofrabbit = document.querySelector('#rabbit');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofrabbit.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview3.style.visibility = 'visible';
									iconview3.style.transform = 'translateY(-230px) translateX(190px) scale(2.0)';
								});
								imageofrabbit.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview3.style.visibility = 'hidden';
									iconview3.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									Rabbit doll
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$25.50
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy">
					<!-- Block2 -->
					<div class="block2">

						<div id="monkey" class="block2-pic hov-img0 box3">
							<img style="height: 260px;width: 250px;" src="images/monkeytoy.png" alt="IMG-PRODUCT">

							<div>
								<i id="cart4" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;height: 40px;  "></i>
								<i id="love4" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view4" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv3 = document.querySelector('#cart4');
								var imageofmonkey = document.querySelector('#monkey');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofmonkey.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv3.style.visibility = 'visible';
									iconDiv3.style.transform = 'translateY(-190px) translateX(230px) scale(2.0)';

								});
								imageofmonkey.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv3.style.visibility = 'hidden';
									iconDiv3.style.transform = 'translateY(-190px) translateX(260px) scale(2.0)';

								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box3 = document.querySelector('.box3');
								var imageofmonkey = document.querySelector('#monkey');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofmonkey.addEventListener('mouseover', function () {
									box3.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofmonkey.addEventListener('mouseout', function () {
									box3.style.borderColor = "#000";
								});
							</script>
							<script>
								const iconlove4 = document.querySelector('#love4');
								var imageofmonkey = document.querySelector('#monkey');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofmonkey.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove4.style.visibility = 'visible';
									iconlove4.style.transform = 'translateY(-170px) translateX(210px) scale(2.0)';

								});
								imageofmonkey.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove4.style.visibility = 'hidden';
									iconlove4.style.transform = 'translateY(-170px) translateX(240px) scale(2.0)';

								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview4 = document.querySelector('#view4');
								var imageofmonkey = document.querySelector('#monkey');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofmonkey.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview4.style.visibility = 'visible';
									iconview4.style.transform = 'translateY(-230px) translateX(190px) scale(2.0)';

								});
								imageofmonkey.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview4.style.visibility = 'hidden';
									iconview4.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';

								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
						</div>
						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									Monkey toy
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$75.00
								</span>
							</div>


						</div>

					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy">
					<!-- Block2 -->
					<div class="block2">
						<div id="deer" class="block2-pic hov-img0 box4">
							<img src="images/deer.png" alt="IMG-PRODUCT">

							<div>
								<i id="cart5" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;height: 40px;  "></i>
								<i id="love5" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view5" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv4 = document.querySelector('#cart5');
								var imageofdeer = document.querySelector('#deer');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdeer.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv4.style.visibility = 'visible';
									iconDiv4.style.transform = 'translateY(-190px) translateX(230px) scale(2.0)';
								});
								imageofdeer.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv4.style.visibility = 'hidden';
									iconDiv4.style.transform = 'translateY(-190px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box4 = document.querySelector('.box4');
								var imageofdeer = document.querySelector('#deer');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofdeer.addEventListener('mouseover', function () {
									box4.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofdeer.addEventListener('mouseout', function () {
									box4.style.borderColor = "#000";
								});
							</script>
							<script>
								const iconlove5 = document.querySelector('#love5');
								var imageofdeer = document.querySelector('#deer');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdeer.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove5.style.visibility = 'visible';
									iconlove5.style.transform = 'translateY(-170px) translateX(210px) scale(2.0)';

								});
								imageofdeer.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove5.style.visibility = 'hidden';
									iconlove5.style.transform = 'translateY(-170px) translateX(240px) scale(2.0)';

								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview5 = document.querySelector('#view5');
								var imageofdeer = document.querySelector('#deer');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdeer.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview5.style.visibility = 'visible';
									iconview5.style.transform = 'translateY(-230px) translateX(190px) scale(2.0)';

								});
								imageofdeer.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview5.style.visibility = 'hidden';
									iconview5.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';

								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 textdeer">
									Deer toy
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  textDeer">Cotton</p>
								<span class="stext-105 cl3 price">
									$34.75
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item pillow">
					<!-- Block2 -->
					<div class="block2">
						<div id="moon" class="block2-pic hov-img0 box5">
							<img src="images/moon.png" alt="IMG-PRODUCT" style="height:270px">
							<div>
								<i id="cart6" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;height: 40px;  "></i>
								<i id="love6" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view6" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv5 = document.querySelector('#cart6');
								var imageofmoon = document.querySelector('#moon');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofmoon.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv5.style.visibility = 'visible';
									iconDiv5.style.transform = 'translateY(-180px) translateX(220px) scale(2.0)';
								});
								imageofmoon.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv5.style.visibility = 'hidden';
									iconDiv5.style.transform = 'translateY(-180px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconlove6 = document.querySelector('#love6');
								var imageofmoon = document.querySelector('#moon');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofmoon.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove6.style.visibility = 'visible';
									iconlove6.style.transform = 'translateY(-160px) translateX(200px) scale(2.0)';
								});
								imageofmoon.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove6.style.visibility = 'hidden';
									iconlove6.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview6 = document.querySelector('#view6');
								var imageofmoon = document.querySelector('#moon');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofmoon.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview6.style.visibility = 'visible';
									iconview6.style.transform = 'translateY(-230px) translateX(180px) scale(2.0)';
								});
								imageofmoon.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview6.style.visibility = 'hidden';
									iconview6.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box5 = document.querySelector('.box5');
								var imageofmoon = document.querySelector('#moon');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofmoon.addEventListener('mouseover', function () {
									box5.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofmoon.addEventListener('mouseout', function () {
									box5.style.borderColor = "#000";
								});
							</script>

						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									Moon pillow
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$93.20
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item pillow">
					<!-- Block2 -->
					<div class="block2">
						<div id="pig" class="block2-pic hov-img0 box6">
							<img src="images/pig.png" alt="IMG-PRODUCT">

							<div>
								<i id="cart7" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;height: 40px;  "></i>
								<i id="love7" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view7" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv6 = document.querySelector('#cart7');
								var imageofpig = document.querySelector('#pig');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofpig.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv6.style.visibility = 'visible';
									iconDiv6.style.transform = 'translateY(-180px) translateX(240px) scale(2.0)';
								});
								imageofpig.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv6.style.visibility = 'hidden';
									iconDiv6.style.transform = 'translateY(-180px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconlove7 = document.querySelector('#love7');
								var imageofpig = document.querySelector('#pig');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofpig.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove7.style.visibility = 'visible';
									iconlove7.style.transform = 'translateY(-160px) translateX(220px) scale(2.0)';
								});
								imageofpig.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove7.style.visibility = 'hidden';
									iconlove7.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview7 = document.querySelector('#view7');
								var imageofpig = document.querySelector('#pig');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofpig.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview7.style.visibility = 'visible';
									iconview7.style.transform = 'translateY(-230px) translateX(200px) scale(2.0)';
								});
								imageofpig.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview7.style.visibility = 'hidden';
									iconview7.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box6 = document.querySelector('.box6');
								var imageofpig = document.querySelector('#pig');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofpig.addEventListener('mouseover', function () {
									box6.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofpig.addEventListener('mouseout', function () {
									box6.style.borderColor = "#000";
								});
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									Pig pillow
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$52.66
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item toy">
					<!-- Block2 -->
					<div class="block2">
						<div id="robot" class="block2-pic hov-img0 box7">
							<img src="images/robot.jpg" alt="IMG-PRODUCT">

							<div>
								<i id="cart8" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;visibility: hidden;height: 40px;  "></i>
								<i id="love8" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view8" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv7 = document.querySelector('#cart8');
								var imageofrobot = document.querySelector('#robot');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofrobot.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv7.style.visibility = 'visible';
									iconDiv7.style.transform = 'translateY(-190px) translateX(230px) scale(2.0)';
								});
								imageofrobot.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv7.style.visibility = 'hidden';
									iconDiv7.style.transform = 'translateY(-190px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconlove8 = document.querySelector('#love8');
								var imageofrobot = document.querySelector('#robot');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofrobot.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove8.style.visibility = 'visible';
									iconlove8.style.transform = 'translateY(-160px) translateX(210px) scale(2.0)';
								});
								imageofrobot.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove8.style.visibility = 'hidden';
									iconlove8.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview8 = document.querySelector('#view8');
								var imageofrobot = document.querySelector('#robot');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofrobot.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview8.style.visibility = 'visible';
									iconview8.style.transform = 'translateY(-230px) translateX(190px) scale(2.0)';
								});
								imageofrobot.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview8.style.visibility = 'hidden';
									iconview8.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box7 = document.querySelector('.box7');
								var imageofrobot = document.querySelector('#robot');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofrobot.addEventListener('mouseover', function () {
									box7.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofrobot.addEventListener('mouseout', function () {
									box7.style.borderColor = "#000";
								});
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text2">
									Robot
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  textRobot">Cotton</p>
								<span class="stext-105 cl3 price2">
									$18.96
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item pillow">
					<!-- Block2 -->
					<div class="block2">
						<div id="tiger" class="block2-pic hov-img0 box8">
							<img src="images/tiger.jpg" alt="IMG-PRODUCT" style="height: 270px;">

							<div>
								<i id="cart9" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;height: 40px;visibility: hidden;  "></i>
								<i id="love9" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view9" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>

							</div>
							<script>
								const iconDiv8 = document.querySelector('#cart9');
								var imageoftiger = document.querySelector('#tiger');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageoftiger.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv8.style.visibility = 'visible';
									iconDiv8.style.transform = 'translateY(-180px) translateX(230px) scale(2.0)';
								});
								imageoftiger.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv8.style.visibility = 'hidden';
									iconDiv8.style.transform = 'translateY(-180px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconlove9 = document.querySelector('#love9');
								var imageoftiger = document.querySelector('#tiger');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageoftiger.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove9.style.visibility = 'visible';
									iconlove9.style.transform = 'translateY(-160px) translateX(210px) scale(2.0)';
								});
								imageoftiger.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove9.style.visibility = 'hidden';
									iconlove9.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview9 = document.querySelector('#view9');
								var imageoftiger = document.querySelector('#tiger');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageoftiger.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview9.style.visibility = 'visible';
									iconview9.style.transform = 'translateY(-230px) translateX(190px) scale(2.0)';
								});
								imageoftiger.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview9.style.visibility = 'hidden';
									iconview9.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box8 = document.querySelector('.box8');
								var imageoftiger = document.querySelector('#tiger');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageoftiger.addEventListener('mouseover', function () {
									box8.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageoftiger.addEventListener('mouseout', function () {
									box8.style.borderColor = "#000";
								});
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									White tiger
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$75.00
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item pillow">
					<!-- Block2 -->
					<div class="block2">
						<div id="snowman" class="block2-pic hov-img0 box9">
							<img src="images/snowman.png" alt="IMG-PRODUCT">

							<div>
								<i id="cart10" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;height: 40px;visibility: hidden;  "></i>
								<i id="love10" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view10" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv9 = document.querySelector('#cart10');
								var imageofsnowman = document.querySelector('#snowman');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofsnowman.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv9.style.visibility = 'visible';
									iconDiv9.style.transform = 'translateY(-180px) translateX(240px) scale(2.0)';
								});
								imageofsnowman.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv9.style.visibility = 'hidden';
									iconDiv9.style.transform = 'translateY(-180px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview10 = document.querySelector('#view10');
								var imageofsnowman = document.querySelector('#snowman');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofsnowman.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview10.style.visibility = 'visible';
									iconview10.style.transform = 'translateY(-230px) translateX(200px) scale(2.0)';
								});
								imageofsnowman.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview10.style.visibility = 'hidden';
									iconview10.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconlove10 = document.querySelector('#love10');
								var imageofsnowman = document.querySelector('#snowman');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofsnowman.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove10.style.visibility = 'visible';
									iconlove10.style.transform = 'translateY(-160px) translateX(220px) scale(2.0)';
								});
								imageofsnowman.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove10.style.visibility = 'hidden';
									iconlove10.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box9 = document.querySelector('.box9');
								var imageofsnowman = document.querySelector('#snowman');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofsnowman.addEventListener('mouseover', function () {
									box9.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofsnowman.addEventListener('mouseout', function () {
									box9.style.borderColor = "#000";
								});
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									Snow man
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$25.85
								</span>
							</div>


						</div>
					</div>
				</div>

				<div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item men">
					<!-- Block2 -->
					<div class="block2">
						<div id="dog" class="block2-pic hov-img0 box10">
							<img src="images/dog.jpg" alt="IMG-PRODUCT">

							<div>
								<i id="cart11" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
									style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;height: 40px; visibility: hidden; "></i>
								<i id="love11" class="fa-light fa-heart hand-icon icon icon1 "
									style="color: #ea931a;visibility: hidden;"></i>
								<i id="view11" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
							</div>
							<script>
								const iconDiv10 = document.querySelector('#cart11');
								var imageofdog = document.querySelector('#dog');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdog.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconDiv10.style.visibility = 'visible';
									iconDiv10.style.transform = 'translateY(-180px) translateX(240px) scale(2.0)';
								});
								imageofdog.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconDiv10.style.visibility = 'hidden';
									iconDiv10.style.transform = 'translateY(-180px) translateX(260px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconlove11 = document.querySelector('#love11');
								var imageofdog = document.querySelector('#dog');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdog.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconlove11.style.visibility = 'visible';
									iconlove11.style.transform = 'translateY(-160px) translateX(220px) scale(2.0)';
								});
								imageofdog.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconlove11.style.visibility = 'hidden';
									iconlove11.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const iconview11 = document.querySelector('#view11');
								var imageofdog = document.querySelector('#dog');

								// Tạo sự kiện di chuột qua cho biểu tượng
								imageofdog.addEventListener('mouseover', function () {
									// Hiển thị biểu tượng
									iconview11.style.visibility = 'visible';
									iconview11.style.transform = 'translateY(-230px) translateX(200px) scale(2.0)';
								});
								imageofdog.addEventListener('mouseout', function () {
									// Ẩn biểu tượng
									iconview11.style.visibility = 'hidden';
									iconview11.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
								});
								// Tạo sự kiện di chuột ra khỏi biểu tượng
							</script>
							<script>
								const box10 = document.querySelector('.box10');
								var imageofdog = document.querySelector('#dog');

								// Thay đổi viền khi di chuột qua hình ảnh
								imageofdog.addEventListener('mouseover', function () {
									box10.style.borderColor = "#FEB5B5";
								});

								// Thay đổi viền khi di chuột ra khỏi hình ảnh
								imageofdog.addEventListener('mouseout', function () {
									box10.style.borderColor = "#000";
								});
							</script>
						</div>

						<div class="block2-txt flex-w flex-t p-t-14">
							<div class="block2-txt-child1 flex-col-l ">
								<a href="product-detail.html"
									class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
									Dog pillow
								</a>
								<p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1">Cotton</p>
								<span class="stext-105 cl3 price">
									$63.16
								</span>
							</div>


						</div>
					</div>
				</div>

                <div>
                <?php
                    // Thực hiện truy vấn và lặp qua kết quả
                    //$query = mysqli_query($conn, $sql);
                    while ($product = mysqli_fetch_assoc($query)) {

                        ?>
                        <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item men">
                            <!-- Block2 -->
                            <div class="block2">
                                <div id="dog" class="block2-pic hov-img0 box10">
                                    <img src="images/<?php echo $product['p_image']; ?>" alt="IMG-PRODUCT">

                                    <div>
                                        <i id="cart12" class=" fa-duotone fa-basket-shopping-simple hand-icon icon icon1"
                                            style="--fa-primary-color: #d27014; --fa-secondary-color: #d27014;height: 40px; visibility: hidden; "></i>
                                        <i id="love11" class="fa-light fa-heart hand-icon icon icon1 "
                                            style="color: #ea931a;visibility: hidden;"></i>
                                        <i id="view11" class="fa-solid fa-eye hand-icon icon" style="visibility: hidden;"></i>
                                    </div>
                                    <script>
                                        const iconDiv10 = document.querySelector('#cart12');
                                        var imageofdog = document.querySelector('#dog');

                                        // Tạo sự kiện di chuột qua cho biểu tượng
                                        imageofdog.addEventListener('mouseover', function () {
                                            // Hiển thị biểu tượng
                                            iconDiv10.style.visibility = 'visible';
                                            iconDiv10.style.transform = 'translateY(-180px) translateX(240px) scale(2.0)';
                                        });
                                        imageofdog.addEventListener('mouseout', function () {
                                            // Ẩn biểu tượng
                                            iconDiv10.style.visibility = 'hidden';
                                            iconDiv10.style.transform = 'translateY(-180px) translateX(260px) scale(2.0)';
                                        });
                                        // Tạo sự kiện di chuột ra khỏi biểu tượng
                                    </script>
                                    <script>
                                        const iconlove11 = document.querySelector('#love12');
                                        var imageofdog = document.querySelector('#dog');

                                        // Tạo sự kiện di chuột qua cho biểu tượng
                                        imageofdog.addEventListener('mouseover', function () {
                                            // Hiển thị biểu tượng
                                            iconlove11.style.visibility = 'visible';
                                            iconlove11.style.transform = 'translateY(-160px) translateX(220px) scale(2.0)';
                                        });
                                        imageofdog.addEventListener('mouseout', function () {
                                            // Ẩn biểu tượng
                                            iconlove11.style.visibility = 'hidden';
                                            iconlove11.style.transform = 'translateY(-160px) translateX(240px) scale(2.0)';
                                        });
                                        // Tạo sự kiện di chuột ra khỏi biểu tượng
                                    </script>
                                    <script>
                                        const iconview11 = document.querySelector('#view12');
                                        var imageofdog = document.querySelector('#dog');

                                        // Tạo sự kiện di chuột qua cho biểu tượng
                                        imageofdog.addEventListener('mouseover', function () {
                                            // Hiển thị biểu tượng
                                            iconview11.style.visibility = 'visible';
                                            iconview11.style.transform = 'translateY(-230px) translateX(200px) scale(2.0)';
                                        });
                                        imageofdog.addEventListener('mouseout', function () {
                                            // Ẩn biểu tượng
                                            iconview11.style.visibility = 'hidden';
                                            iconview11.style.transform = 'translateY(-230px) translateX(220px) scale(2.0)';
                                        });
                                        // Tạo sự kiện di chuột ra khỏi biểu tượng
                                    </script>
                                    <script>
                                        const box10 = document.querySelector('.box10');
                                        var imageofdog = document.querySelector('#dog');

                                        // Thay đổi viền khi di chuột qua hình ảnh
                                        imageofdog.addEventListener('mouseover', function () {
                                            box10.style.borderColor = "#FEB5B5";
                                        });

                                        // Thay đổi viền khi di chuột ra khỏi hình ảnh
                                        imageofdog.addEventListener('mouseout', function () {
                                            box10.style.borderColor = "#000";
                                        });
                                    </script>
                                </div>

                                <div class="block2-txt flex-w flex-t p-t-14">
                                    <div class="block2-txt-child1 flex-col-l ">
                                        <a href="product-detail.html"
                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 text">
                                            <?php echo $product['p_name']; ?>
                                        </a>
                                        <p class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  text1"><?php echo $product['p_type']; ?></p>
                                        <span class="stext-105 cl3 price">
                                            $<?php echo $product['p_price']; ?>
                                        </span>
                                    </div>


                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
				<!-- Load more -->
			</div>
		</div>


		<!-- Footer -->
		<footer class="bg3 p-t-75 p-b-32" id="footer_res">
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
							Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call
							us
							on (+1) 96 716 6879
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
						<script>document.write(new Date().getFullYear());</script> All rights reserved |Made with <i
							class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com"
							target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com"
							target="_blank">ThemeWagon</a>
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
										<div class="item-slick3" data-thumb="images/product-detail-01.jpg">
											<div class="wrap-pic-w pos-relative">
												<img src="images/product-detail-01.jpg" alt="IMG-PRODUCT">

												<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
													href="images/product-detail-01.jpg">
													<i class="fa fa-expand"></i>
												</a>
											</div>
										</div>

										<div class="item-slick3" data-thumb="images/product-detail-02.jpg">
											<div class="wrap-pic-w pos-relative">
												<img src="images/product-detail-02.jpg" alt="IMG-PRODUCT">

												<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
													href="images/product-detail-02.jpg">
													<i class="fa fa-expand"></i>
												</a>
											</div>
										</div>

										<div class="item-slick3" data-thumb="images/product-detail-03.jpg">
											<div class="wrap-pic-w pos-relative">
												<img src="images/product-detail-03.jpg" alt="IMG-PRODUCT">

												<a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
													href="images/product-detail-03.jpg">
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
									Nulla eget sem vitae eros pharetra viverra. Nam vitae luctus ligula. Mauris
									consequat
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
		</script>
		<!--===============================================================================================-->
		<script src="js/main.js"></script>

</body>

</html>