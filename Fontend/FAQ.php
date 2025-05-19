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
		if ($row['u_id'] == $userLogin['userID'] && $row['o_status'] == 0) {
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
		if ($item["u_id"] == $u_id && $item["o_status"] == 0) {
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
<!doctype html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <meta name="theme-color" content="">
    <link rel="canonical" href="https://toytime-theme.myshopify.com/pages/faq">
    <link rel="preconnect" href="https://cdn.shopify.com" crossorigin>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="icon" type="image/png" href="//toytime-theme.myshopify.com/cdn/shop/files/Favicon.svg?crop=center&height=32&v=1707973018&width=32"><link rel="preconnect" href="https://fonts.shopifycdn.com" crossorigin><title>
      faq
 &ndash; ToyTime-theme</title>

 <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
 href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

 <link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
 href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">


<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css">

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
<style>
 @import url('https://fonts.googleapis.com/css2?family=Baloo+2:wght@400..800&display=swap');
</style>
<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v5.15.4/css/all.css">
<!-- link icon -->
<link rel="stylesheet" data-purpose="Layout StyleSheet" title="Web Awesome"
 href="/css/app-wa-8d95b745961f6b33ab3aa1b98a45291a.css?vsn=d">

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/all.css">

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-solid.css">

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-regular.css">

<link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.4.0/css/sharp-light.css">


<link rel="stylesheet" href="css/them.css">
<link rel="stylesheet" href="css/faq.css">





    

<meta property="og:site_name" content="ToyTime-theme">
<meta property="og:url" content="https://toytime-theme.myshopify.com/pages/faq">
<meta property="og:title" content="faq">
<meta property="og:type" content="website">
<meta property="og:description" content="ToyTime-theme"><meta property="og:image" content="http://toytime-theme.myshopify.com/cdn/shop/files/Logo.png?height=628&pad_color=fff&v=1707972992&width=1200">
  <meta property="og:image:secure_url" content="https://toytime-theme.myshopify.com/cdn/shop/files/Logo.png?height=628&pad_color=fff&v=1707972992&width=1200">
  <meta property="og:image:width" content="1200">
  <meta property="og:image:height" content="628"><meta name="twitter:site" content="@#"><meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="faq">
<meta name="twitter:description" content="ToyTime-theme">
    
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/jquery.min.js?v=8324501383853434791708942415"></script>        
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/swiper-bundle.min.js?v=106694489724338690061708942415"></script>
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/slick.min.js?v=8264189252782096261708942415"></script>    
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/global.js?v=47366058397894125521711023983" defer="defer"></script>    
    <script  src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/jquery-cookie-min.js?v=9607349207001725821708942415"></script>
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/wow.min.js?v=149765521133998811681708942415"></script>
     
    <script>window.performance && window.performance.mark && window.performance.mark('shopify.content_for_header.start');</script><meta id="shopify-digital-wallet" name="shopify-digital-wallet" content="/68023124200/digital_wallets/dialog">
<script async="async" src="/checkouts/internal/preloads.js?locale=en-IN"></script>
<script async="async" src="https://shop.app/checkouts/internal/preloads.js?locale=en-IN&shop_id=68023124200" crossorigin="anonymous"></script>
<script id="shopify-features" type="application/json">{"accessToken":"a528fc514e7ced1b065afc1a320b8b2c","betas":["rich-media-storefront-analytics"],"domain":"toytime-theme.myshopify.com","predictiveSearch":true,"shopId":68023124200,"smart_payment_buttons_url":"https:\/\/toytime-theme.myshopify.com\/cdn\/shopifycloud\/payment-sheet\/assets\/latest\/spb.en.js","dynamic_checkout_cart_url":"https:\/\/toytime-theme.myshopify.com\/cdn\/shopifycloud\/payment-sheet\/assets\/latest\/dynamic-checkout-cart.en.js","locale":"en","flg4ff40b22":false}</script>
<script>var Shopify = Shopify || {};
Shopify.shop = "toytime-theme.myshopify.com";
Shopify.locale = "en";
Shopify.currency = {"active":"INR","rate":"1.0"};
Shopify.country = "IN";
Shopify.theme = {"name":"ToyTime","id":139168678120,"theme_store_id":null,"role":"main"};
Shopify.theme.handle = "null";
Shopify.theme.style = {"id":null,"handle":null};
Shopify.cdnHost = "toytime-theme.myshopify.com/cdn";
Shopify.routes = Shopify.routes || {};
Shopify.routes.root = "/";</script>
<script type="module">!function(o){(o.Shopify=o.Shopify||{}).modules=!0}(window);</script>
<script>!function(o){function n(){var o=[];function n(){o.push(Array.prototype.slice.apply(arguments))}return n.q=o,n}var t=o.Shopify=o.Shopify||{};t.loadFeatures=n(),t.autoloadFeatures=n()}(window);</script>
<script>(function() {
  function asyncLoad() {
    var urls = ["https:\/\/cdn1.judge.me\/assets\/installed.js?shop=toytime-theme.myshopify.com"];
    for (var i = 0; i < urls.length; i++) {
      var s = document.createElement('script');
      s.type = 'text/javascript';
      s.async = true;
      s.src = urls[i];
      var x = document.getElementsByTagName('script')[0];
      x.parentNode.insertBefore(s, x);
    }
  };
  if(window.attachEvent) {
    window.attachEvent('onload', asyncLoad);
  } else {
    window.addEventListener('load', asyncLoad, false);
  }
})();</script>
<script id="__st">var __st={"a":68023124200,"offset":-14400,"reqid":"d6fad918-4e9f-4378-86ee-506089005cfd-1714527960","pageurl":"toytime-theme.myshopify.com\/pages\/faq","s":"pages-106106552552","t":"prospect","u":"8a7d37c23b72","p":"page","rtyp":"page","rid":106106552552};</script>
<script>window.ShopifyPaypalV4VisibilityTracking = true;</script>
<script>!function(){'use strict';const e='contact',t='account',n='new_comment',o=e=>e.map((([e,t])=>`form[action*='/${e}'] input[name='form_type'][value='${t}']`)).join(',');function c(e,t,n){try{for(const[o,c]of Object.entries(JSON.parse(n.getItem(t))))e.elements[o]&&(e.elements[o].value=c);n.removeItem(t)}catch{}}const s='form_type',r='cptcha';var a,m,i,u;a=window,m=document,u='ce_forms',a[i='Shopify']=a[i]||{},a[i][u]=a[i][u]||{},a[i][u].q=[],function(a,m,i,u,f,d){const[l,p]=function(c,s){const r=s?[[e,e],['blogs',n],['comments',n],[e,'customer']]:[],a=c?[[t,'customer_login'],[t,'recover_customer_password'],[t,'create_customer']]:[],m=o([...r,...a]),i=o(r.slice(0,3)),u=e=>()=>e?[...document.querySelectorAll(e)].map((e=>e.form)):[];return[u(m),u(i)]}(!0,!0),_=e=>{const t=e.target,n=t instanceof HTMLFormElement?t:t&&t.form;return n&&l().find((e=>n===e))};a.addEventListener('submit',(e=>{_(e)&&e.preventDefault()}));for(const e of['focusin','change'])a.addEventListener(e,(e=>{const t=_(e);t&&!t.dataset[r]&&(u(t,p().some((e=>e===t))),t.dataset[r]=!0)}));const v=i.get('form_key'),g=i.get(s);v&&g&&a.addEventListener('DOMContentLoaded',(()=>{for(const e of p())e.elements[s].value===g&&c(e,v,m)}))}(m,a.sessionStorage,new URLSearchParams(a.location.search),((e,t)=>{const n=a[i][u],o=n.bindForm,c='6LeHG2ApAAAAAO4rPaDW-qVpPKPOBfjbCpzJB9ey';if(o)return o(e,c,t);n.q.push([e,c,t]),m.body.append(Object.assign(m.createElement('script'),{async:!0,src:'https://cdn.shopify.com/shopifycloud/storefront-forms-hcaptcha/ce_storefront_forms_captcha_recaptcha.v1.0.1.iife.js'}))}))}();</script>
<script integrity="sha256-n5Uet9jVOXPHGd4hH4B9Y6+BxkTluaaucmYaxAjUcvY=" data-source-attribution="shopify.loadfeatures" defer="defer" src="//toytime-theme.myshopify.com/cdn/shopifycloud/shopify/assets/storefront/load_feature-9f951eb7d8d53973c719de211f807d63af81c644e5b9a6ae72661ac408d472f6.js" crossorigin="anonymous"></script>
<script integrity="sha256-HAs5a9TQVLlKuuHrahvWuke+s1UlxXohfHeoYv8G2D8=" data-source-attribution="shopify.dynamic-checkout" defer="defer" src="//toytime-theme.myshopify.com/cdn/shopifycloud/shopify/assets/storefront/features-1c0b396bd4d054b94abae1eb6a1bd6ba47beb35525c57a217c77a862ff06d83f.js" crossorigin="anonymous"></script>
<script id="sections-script" data-sections="header" defer="defer" src="//toytime-theme.myshopify.com/cdn/shop/t/4/compiled_assets/scripts.js?1853"></script>

<script>window.performance && window.performance.mark && window.performance.mark('shopify.content_for_header.end');</script>   
    <style data-shopify> /* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}@import url('https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200;0,6..12,300;0,6..12,400;0,6..12,500;0,6..12,600;0,6..12,700;0,6..12,800;0,6..12,900;0,6..12,1000;1,6..12,200;1,6..12,300;1,6..12,400;1,6..12,500;1,6..12,600;1,6..12,700;1,6..12,800;1,6..12,900;1,6..12,1000&display=swap');/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 400;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 500;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 600;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 700;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
/* devanagari */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51ncANwr.woff2) format('woff2');
  unicode-range: U+0900-097F, U+1CD0-1CF9, U+200C-200D, U+20A8, U+20B9, U+25CC, U+A830-A839, U+A8E0-A8FF;
}
/* vietnamese */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51fcANwr.woff2) format('woff2');
  unicode-range: U+0102-0103, U+0110-0111, U+0128-0129, U+0168-0169, U+01A0-01A1, U+01AF-01B0, U+0300-0301, U+0303-0304, U+0308-0309, U+0323, U+0329, U+1EA0-1EF9, U+20AB;
}
/* latin-ext */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51bcANwr.woff2) format('woff2');
  unicode-range: U+0100-02AF, U+0304, U+0308, U+0329, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, U+20AD-20CF, U+2113, U+2C60-2C7F, U+A720-A7FF;
}
/* latin */
@font-face {
  font-family: 'Baloo 2';
  font-style: normal;
  font-weight: 800;
  font-display: swap;
  src: url(https://fonts.gstatic.com/s/baloo2/v21/wXKrE3kTposypRyd51jcAA.woff2) format('woff2');
  unicode-range: U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, U+0304, U+0308, U+0329, U+2000-206F, U+2074, U+20AC, U+2122, U+2191, U+2193, U+2212, U+2215, U+FEFF, U+FFFD;
}
      @font-face {
  font-family: Rubik;
  font-weight: 400;
  font-style: normal;
  font-display: swap;
  src: url("//toytime-theme.myshopify.com/cdn/fonts/rubik/rubik_n4.cc9422f2e84f41ed4707ebaebe66b6de39308266.woff2?h1=dG95dGltZS10aGVtZS5hY2NvdW50Lm15c2hvcGlmeS5jb20&hmac=9405c101971f1a1a00eea03df521da056a9508a8a68026ffbe46b481b4e4079f") format("woff2"),
       url("//toytime-theme.myshopify.com/cdn/fonts/rubik/rubik_n4.e38b3e3cdf5bea8165936df21f0aa42a1290b5ea.woff?h1=dG95dGltZS10aGVtZS5hY2NvdW50Lm15c2hvcGlmeS5jb20&hmac=07a5e9c2b7e872955c3f0d8e520fbfa0eb1ee711cfa805ba88b131338435c6ac") format("woff");
}
                 
      @font-face {
  font-family: Oswald;
  font-weight: 400;
  font-style: normal;
  font-display: swap;
  src: url("//toytime-theme.myshopify.com/cdn/fonts/oswald/oswald_n4.a5ee385bde39969d807f7f1297bf51d73fbf3c1e.woff2?h1=dG95dGltZS10aGVtZS5hY2NvdW50Lm15c2hvcGlmeS5jb20&hmac=6f9069dbd6be3b9c8ee96ae752540a3298f46bffaa44a52ed98f064ea6f154f4") format("woff2"),
       url("//toytime-theme.myshopify.com/cdn/fonts/oswald/oswald_n4.8f3e284746fbc2d29e34993609c51fdc432b0b24.woff?h1=dG95dGltZS10aGVtZS5hY2NvdW50Lm15c2hvcGlmeS5jb20&hmac=63571b458c2f233e4909456694158cba69c8800f0aa6fbf17e5f619bd2a3bffd") format("woff");
}

    
      :root {
        --font-heading-family: 'Baloo 2', sans-serif;
        --font-heading-style: normal;
        --font-heading-weight: 400;
        --font-heading-scale: 1.0;
        --font-body-family: 'Nunito Sans', sans-serif;
        --font-body-style: normal;
        --font-body-weight: 400;
        --font-body-weight-bold: 700;
        --font-body-scale: 1.0;
        --font-additional-family: 'Baloo 2', sans-serif;
        --font-additional-heading-style: normal;
        --font-additional-heading-weight: 400;
         
        --color-base-text: 0, 0, 0;
     
        --color-shadow: 0, 0, 0;
        --color-base-background-1: 255, 255, 255;
        --color-base-background-2: 245, 245, 245;
        --color-base-background-3: 234, 230, 224;
        --color-base-solid-button-labels: 0, 0, 0;
        --color-base-outline-button-labels: 253, 132, 132;
        --color-base-accent-1: 0, 0, 0;
        --color-base-accent-2: 153, 153, 153;
        --color-base-accent-3: 0, 0, 0;
        --color-overlay: 224, 64, 41;
       --color-border: 248, 240, 223;
        --payment-terms-background-color: #ffffff;
        --gradient-button-background-1: #000000;
        /* --gradient-button-hover:; */

      
        --gradient-base-background-1: #ffffff;
        --gradient-base-background-2: #f5f5f5;
        --gradient-base-background-3: #eae6e0;
        --gradient-base-accent-1: #000000;
        --gradient-base-accent-2: #999999;
        --gradient-base-accent-3: #000000;
        
        --media-padding: px;
        --media-border-opacity: 0.0;
        --media-border-width: 0px;
        --media-radius: 18px;
        --media-shadow-opacity: 0.0;
        --media-shadow-horizontal-offset: 0px;
        --media-shadow-vertical-offset: 4px;
        --media-shadow-blur-radius: 5px;

        --page-width: 154rem;
        --page-width-laptop: 120rem;
        --page-width-tab: 96rem;
       --large_desktop: 192rem;
      
        --page-full-width-spacing: 2%;
        --page-width-margin: 0rem;
      
        --card-image-padding: 0.0rem;
        --card-corner-radius: 2.2rem;
        --card-text-alignment: center;
        --card-border-width: 0.0rem;
        --card-border-opacity: 0.0;
        --card-shadow-opacity: 0.0;
        --card-shadow-horizontal-offset: 0.0rem;
        --card-shadow-vertical-offset: 0.0rem;
        --card-shadow-blur-radius: 3.0rem;

        --badge-corner-radius: 4.0rem;

        --popup-border-width: 0px;
        --popup-border-opacity: 0.0;
        --popup-corner-radius: 10px;
        --popup-shadow-opacity: 0.2;
        --popup-shadow-horizontal-offset: 0px;
        --popup-shadow-vertical-offset: 6px;
        --popup-shadow-blur-radius: 10px;

        --drawer-border-width: 1px;
        --drawer-border-opacity: 0.45;
        --drawer-shadow-opacity: 0.0;
        --drawer-shadow-horizontal-offset: 0px;
        --drawer-shadow-vertical-offset: 4px;
        --drawer-shadow-blur-radius: 0px;

        --spacing-sections-desktop: 0px;
        --spacing-sections-mobile: 0px;

        --grid-desktop-vertical-spacing: 20px;
        --grid-desktop-horizontal-spacing: 20px;
        --grid-mobile-vertical-spacing: 10px;
        --grid-mobile-horizontal-spacing: 10px;
        --sidebar-width:400px;

      
        --text-boxes-border-opacity: 0.1;
        --text-boxes-border-width: 0px;
        --text-boxes-radius: 0px;
        --text-boxes-shadow-opacity: 0.0;
        --text-boxes-shadow-horizontal-offset: 0px;
        --text-boxes-shadow-vertical-offset: 4px;
        --text-boxes-shadow-blur-radius: 5px;

        --buttons-radius: 12px;
        --buttons-radius-outset: 13px;
        --buttons-border-width: 1px;
        --buttons-border-opacity: 1.0;
        --buttons-shadow-opacity: 0.0;
        --buttons-shadow-horizontal-offset: 0px;
        --buttons-shadow-vertical-offset: 0px;
        --buttons-shadow-blur-radius: 0px;
        --buttons-border-offset: 0.3px;

        --inputs-radius: 16px;
        --inputs-border-width: 1px;
        --inputs-border-opacity: 1.0;
        --inputs-shadow-opacity: 0.0;
        --inputs-shadow-horizontal-offset: 0px;
        --inputs-margin-offset: 0px;
        --inputs-shadow-vertical-offset: 0px;
        --inputs-shadow-blur-radius: 0px;
        --inputs-radius-outset: 17px;

        --variant-pills-radius: 0px;
        --variant-pills-border-width: 0px;
        --variant-pills-border-opacity: 0.55;
        --variant-pills-shadow-opacity: 0.0;
        --variant-pills-shadow-horizontal-offset: 0px;
        --variant-pills-shadow-vertical-offset: 4px;
        --variant-pills-shadow-blur-radius: 5px;
      }

      #preloader, .dT_loading {
      position: fixed;
      display:block;
      z-index: 2000;
      width: 100%;
      height: 100%;
      top:0;
      bottom:0;
      left:0;
      right: 0;
      margin: auto;
       
      background-image:url('//toytime-theme.myshopify.com/cdn/shop/files/Ellipsis-1s-200px.gif?v=1706865285&width=1920');
     
      background-repeat: no-repeat;
      background-position:center;
      background-color: rgb(var(--color-background));
      }
    .alert-overlay-wrapper {position:relative; width: 100%; height: 100%;}
      .alert-overlay{
      display: none; 
      position: fixed; 
      z-index: 999; 
      padding-top: 100px; 
      left: 0;
      top: 0;
      width: 100%; 
      height: 100%; 
      overflow: auto; 
      background-color: rgb(var(--color-base-accent-1)); 
      background-color:rgba(var(--color-base-accent-1), 0.4); 
      } 
      .alert-overlay .main-content {
      position: absolute;
      left: 50%;
      right: 0;
      top: 50%;
      background-color:rgb(var(--color-base-background-1));    
      bottom: 0;
      z-index: 99;
      width: calc(100% - 2rem);
      max-width: 500px;
      height: 200px;
      padding: 10px;
      transform: translate(-50%, -50%);
      align-items: center;
      display: flex;
      flex-direction: column;
      justify-content: center;text-align:center;
      }
    .closebtn {
    margin-left: 15px;
    background:rgb(var(--color-base-solid-button-labels));
    color: rgb(var(--color-base-background-1)); 
    font-weight: bold;
    float: right;
    font-size: 22px;
    line-height: 20px;
    cursor: pointer;
    transition: 0.3s;
    position:absolute;
    right:15px;
    top:15px;  
    width: 25px;
    height: 25px;
    justify-content: center;
    align-items: center;
    display: flex;  
    }
    .closebtn svg{width:1.4rem; height:1.4rem;}
    .closebtn:hover {
    background: rgb(var(--color-base-outline-button-labels)); color: rgb(var(--color-base-background-1)); 
    }
    .overflow-hidden.filter-clicked .shopify-section-header-sticky { z-index: 1;}
     .overflow-hidden-mobile .mobile-toolbar__icons, .overflow-hidden.filter-clicked .mobile-toolbar__icons { z-index: 0;}

     .page-full-width.page-full-width_spacing .row {margin: 0 var(--page-full-width-spacing);}div#seal-login-helper {  display: none;}
      </style>

    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/base.css?v=164914862435440828891709034714" rel="stylesheet" type="text/css" media="all" />
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/custom.css?v=91386371912497858481708942415" rel="stylesheet" type="text/css" media="all" />
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-card.css?v=157639358725368099861710480762" rel="stylesheet" type="text/css" media="all" />
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/swiper-bundle.min.css?v=88696700385688456501708950131" rel="stylesheet" type="text/css" media="all" />    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/4.1.5/css/flag-icons.min.css" rel="stylesheet" type="text/css" media="all" />
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/animate.min.css?v=73862710899180798181708942415" rel="stylesheet" type="text/css" media="all" />    
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/placeholder.css?v=3127957551884083801708942415" rel="stylesheet" type="text/css" media="all" />    
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/slick.min.css?v=98340474046176884051708942415" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/splitting.css?v=21737044365998488141708942415" rel="stylesheet" type="text/css" media="all" />
    <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/splitting-cells.css?v=140815468133970727221708942415" rel="stylesheet" type="text/css" media="all" />
<link rel="preload" as="font" href="//toytime-theme.myshopify.com/cdn/fonts/rubik/rubik_n4.cc9422f2e84f41ed4707ebaebe66b6de39308266.woff2?h1=dG95dGltZS10aGVtZS5hY2NvdW50Lm15c2hvcGlmeS5jb20&hmac=9405c101971f1a1a00eea03df521da056a9508a8a68026ffbe46b481b4e4079f" type="font/woff2" crossorigin><link rel="preload" as="font" href="//toytime-theme.myshopify.com/cdn/fonts/oswald/oswald_n4.a5ee385bde39969d807f7f1297bf51d73fbf3c1e.woff2?h1=dG95dGltZS10aGVtZS5hY2NvdW50Lm15c2hvcGlmeS5jb20&hmac=6f9069dbd6be3b9c8ee96ae752540a3298f46bffaa44a52ed98f064ea6f154f4" type="font/woff2" crossorigin><link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-predictive-search.css?v=111471959001119457541708944730" media="print" onload="this.media='all'"><script>
      document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
      if (Shopify.designMode) {
        document.documentElement.classList.add('shopify-design-mode');
      }
    </script>

  <link href="https://monorail-edge.shopifysvc.com" rel="dns-prefetch">
<script>(function(){if ("sendBeacon" in navigator && "performance" in window) {var session_token = document.cookie.match(/_shopify_s=([^;]*)/);function handle_abandonment_event(e) {var entries = performance.getEntries().filter(function(entry) {return /monorail-edge.shopifysvc.com/.test(entry.name);});if (!window.abandonment_tracked && entries.length === 0) {window.abandonment_tracked = true;var currentMs = Date.now();var navigation_start = performance.timing.navigationStart;var payload = {shop_id: 68023124200,url: window.location.href,navigation_start,duration: currentMs - navigation_start,session_token: session_token && session_token.length === 2 ? session_token[1] : "",page_type: "page"};window.navigator.sendBeacon("https://monorail-edge.shopifysvc.com/v1/produce", JSON.stringify({schema_id: "online_store_buyer_site_abandonment/1.1",payload: payload,metadata: {event_created_at_ms: currentMs,event_sent_at_ms: currentMs}}));}}window.addEventListener('pagehide', handle_abandonment_event);}}());</script>
<script id="web-pixels-manager-setup">(function e(e,n,a,t,r){var o="function"==typeof BigInt&&-1!==BigInt.toString().indexOf("[native code]")?"modern":"legacy";window.Shopify=window.Shopify||{};var i=window.Shopify;i.analytics=i.analytics||{};var s=i.analytics;s.replayQueue=[],s.publish=function(e,n,a){return s.replayQueue.push([e,n,a]),!0};try{self.performance.mark("wpm:start")}catch(e){}var l=[a,"/wpm","/b",r,o.substring(0,1),".js"].join("");!function(e){var n=e.src,a=e.async,t=void 0===a||a,r=e.onload,o=e.onerror,i=document.createElement("script"),s=document.head,l=document.body;i.async=t,i.src=n,r&&i.addEventListener("load",r),o&&i.addEventListener("error",o),s?s.appendChild(i):l?l.appendChild(i):console.error("Did not find a head or body element to append the script")}({src:l,async:!0,onload:function(){var a=window.webPixelsManager.init(e);n(a);var t=window.Shopify.analytics;t.replayQueue.forEach((function(e){var n=e[0],t=e[1],r=e[2];a.publishCustomEvent(n,t,r)})),t.replayQueue=[],t.publish=a.publishCustomEvent,t.visitor=a.visitor},onerror:function(){var n=e.storefrontBaseUrl.replace(/\/$/,""),a="".concat(n,"/.well-known/shopify/monorail/unstable/produce_batch"),r=JSON.stringify({metadata:{event_sent_at_ms:(new Date).getTime()},events:[{schema_id:"web_pixels_manager_load/2.0",payload:{version:t||"latest",page_url:self.location.href,status:"failed",error_msg:"".concat(l," has failed to load")},metadata:{event_created_at_ms:(new Date).getTime()}}]});try{if(self.navigator.sendBeacon.bind(self.navigator)(a,r))return!0}catch(e){}var o=new XMLHttpRequest;try{return o.open("POST",a,!0),o.setRequestHeader("Content-Type","text/plain"),o.send(r),!0}catch(e){console&&console.warn&&console.warn("[Web Pixels Manager] Got an unhandled error while logging a load error.")}return!1}})})({shopId: 68023124200,storefrontBaseUrl: "https://toytime-theme.myshopify.com",cdnBaseUrl: "https://toytime-theme.myshopify.com/cdn",surface: "storefront-renderer",enabledBetaFlags: ["5de24938"],webPixelsConfigList: [{"id":"shopify-app-pixel","configuration":"{}","eventPayloadVersion":"v1","runtimeContext":"STRICT","scriptVersion":"064","apiClientId":"shopify-pixel","type":"APP","purposes":["ANALYTICS","MARKETING"]},{"id":"shopify-custom-pixel","eventPayloadVersion":"v1","runtimeContext":"LAX","scriptVersion":"064","apiClientId":"shopify-pixel","type":"CUSTOM","purposes":["ANALYTICS","MARKETING"]}],initData: {"cart":{"cost":{"totalAmount":{"amount":654.0,"currencyCode":"INR"}},"id":"Z2NwLWFzaWEtc291dGhlYXN0MTowMUhXRjVCRk5INkJQTTZLVFBGOVlNRUtEUQ","lines":[{"cost":{"totalAmount":{"amount":654.0,"currencyCode":"INR"}},"merchandise":{"id":"45411339075816","image":{"src":"\/\/toytime-theme.myshopify.com\/cdn\/shop\/products\/shop-17_72a003e3-9e8c-411e-9b11-5c56045e0820.jpg?v=1706620757"},"price":{"amount":654.0,"currencyCode":"INR"},"product":{"id":"8547307421928","title":"Baby Owl","untranslatedTitle":"Baby Owl","url":"\/products\/baby-owl","vendor":"Toy World","type":"Soft Dolls"},"sku":"2","title":"Pink \/ 90 g \/ Cotton","untranslatedTitle":"Pink \/ 90 g \/ Cotton"},"quantity":1}],"totalQuantity":1},"checkout":null,"customer":null,"productVariants":[]},},function pageEvents(webPixelsManagerAPI) {webPixelsManagerAPI.publish("page_viewed");},"https://toytime-theme.myshopify.com/cdn","c1d7d6cb9665710b15e5b5994fb4dd5132990d48","a69d2471w3b604ff3p0fda5047m53fe5f78",);</script>  <script>window.ShopifyAnalytics = window.ShopifyAnalytics || {};
window.ShopifyAnalytics.meta = window.ShopifyAnalytics.meta || {};
window.ShopifyAnalytics.meta.currency = 'INR';
var meta = {"page":{"pageType":"page","resourceType":"page","resourceId":106106552552}};
for (var attr in meta) {
  window.ShopifyAnalytics.meta[attr] = meta[attr];
}</script>
<script>window.ShopifyAnalytics.merchantGoogleAnalytics = function() {
  
};
</script>
<script class="analytics">(function () {
    var customDocumentWrite = function(content) {
      var jquery = null;

      if (window.jQuery) {
        jquery = window.jQuery;
      } else if (window.Checkout && window.Checkout.$) {
        jquery = window.Checkout.$;
      }

      if (jquery) {
        jquery('body').append(content);
      }
    };

    var hasLoggedConversion = function(token) {
      if (token) {
        return document.cookie.indexOf('loggedConversion=' + token) !== -1;
      }
      return false;
    }

    var setCookieIfConversion = function(token) {
      if (token) {
        var twoMonthsFromNow = new Date(Date.now());
        twoMonthsFromNow.setMonth(twoMonthsFromNow.getMonth() + 2);

        document.cookie = 'loggedConversion=' + token + '; expires=' + twoMonthsFromNow;
      }
    }

    var trekkie = window.ShopifyAnalytics.lib = window.trekkie = window.trekkie || [];
    if (trekkie.integrations) {
      return;
    }
    trekkie.methods = [
      'identify',
      'page',
      'ready',
      'track',
      'trackForm',
      'trackLink'
    ];
    trekkie.factory = function(method) {
      return function() {
        var args = Array.prototype.slice.call(arguments);
        args.unshift(method);
        trekkie.push(args);
        return trekkie;
      };
    };
    for (var i = 0; i < trekkie.methods.length; i++) {
      var key = trekkie.methods[i];
      trekkie[key] = trekkie.factory(key);
    }
    trekkie.load = function(config) {
      trekkie.config = config || {};
      trekkie.config.initialDocumentCookie = document.cookie;
      var first = document.getElementsByTagName('script')[0];
      var script = document.createElement('script');
      script.type = 'text/javascript';
      script.onerror = function(e) {
        var scriptFallback = document.createElement('script');
        scriptFallback.type = 'text/javascript';
        scriptFallback.onerror = function(error) {
                var Monorail = {
      produce: function produce(monorailDomain, schemaId, payload) {
        var currentMs = new Date().getTime();
        var event = {
          schema_id: schemaId,
          payload: payload,
          metadata: {
            event_created_at_ms: currentMs,
            event_sent_at_ms: currentMs
          }
        };
        return Monorail.sendRequest("https://" + monorailDomain + "/v1/produce", JSON.stringify(event));
      },
      sendRequest: function sendRequest(endpointUrl, payload) {
        // Try the sendBeacon API
        if (window && window.navigator && typeof window.navigator.sendBeacon === 'function' && typeof window.Blob === 'function' && !Monorail.isIos12()) {
          var blobData = new window.Blob([payload], {
            type: 'text/plain'
          });

          if (window.navigator.sendBeacon(endpointUrl, blobData)) {
            return true;
          } // sendBeacon was not successful

        } // XHR beacon

        var xhr = new XMLHttpRequest();

        try {
          xhr.open('POST', endpointUrl);
          xhr.setRequestHeader('Content-Type', 'text/plain');
          xhr.send(payload);
        } catch (e) {
          console.log(e);
        }

        return false;
      },
      isIos12: function isIos12() {
        return window.navigator.userAgent.lastIndexOf('iPhone; CPU iPhone OS 12_') !== -1 || window.navigator.userAgent.lastIndexOf('iPad; CPU OS 12_') !== -1;
      }
    };
    Monorail.produce('monorail-edge.shopifysvc.com',
      'trekkie_storefront_load_errors/1.1',
      {shop_id: 68023124200,
      theme_id: 139168678120,
      app_name: "storefront",
      context_url: window.location.href,
      source_url: "//toytime-theme.myshopify.com/cdn/s/trekkie.storefront.88baf04046928b6edf6574afd22dbd026cc7d568.min.js"});

        };
        scriptFallback.async = true;
        scriptFallback.src = '//toytime-theme.myshopify.com/cdn/s/trekkie.storefront.88baf04046928b6edf6574afd22dbd026cc7d568.min.js';
        first.parentNode.insertBefore(scriptFallback, first);
      };
      script.async = true;
      script.src = '//toytime-theme.myshopify.com/cdn/s/trekkie.storefront.88baf04046928b6edf6574afd22dbd026cc7d568.min.js';
      first.parentNode.insertBefore(script, first);
    };
    trekkie.load(
      {"Trekkie":{"appName":"storefront","development":false,"defaultAttributes":{"shopId":68023124200,"isMerchantRequest":null,"themeId":139168678120,"themeCityHash":"16957464587616843618","contentLanguage":"en","currency":"INR"},"isServerSideCookieWritingEnabled":true,"monorailRegion":"shop_domain","enabledBetaFlags":["bbcf04e6"]},"Session Attribution":{},"S2S":{"facebookCapiEnabled":false,"source":"trekkie-storefront-renderer"}}
    );

    var loaded = false;
    trekkie.ready(function() {
      if (loaded) return;
      loaded = true;

      window.ShopifyAnalytics.lib = window.trekkie;

  
      var originalDocumentWrite = document.write;
      document.write = customDocumentWrite;
      try { window.ShopifyAnalytics.merchantGoogleAnalytics.call(this); } catch(error) {};
      document.write = originalDocumentWrite;

      window.ShopifyAnalytics.lib.page(null,{"pageType":"page","resourceType":"page","resourceId":106106552552});

      var match = window.location.pathname.match(/checkouts\/(.+)\/(thank_you|post_purchase)/)
      var token = match? match[1]: undefined;
      if (!hasLoggedConversion(token)) {
        setCookieIfConversion(token);
        
      }
    });


        var eventsListenerScript = document.createElement('script');
        eventsListenerScript.async = true;
        eventsListenerScript.src = "//toytime-theme.myshopify.com/cdn/shopifycloud/shopify/assets/shop_events_listener-61fa9e0a912c675e178777d2b27f6cbd482f8912a6b0aa31fa3515985a8cd626.js";
        document.getElementsByTagName('head')[0].appendChild(eventsListenerScript);

})();</script>
<script class="boomerang">
(function () {
  if (window.BOOMR && (window.BOOMR.version || window.BOOMR.snippetExecuted)) {
    return;
  }
  window.BOOMR = window.BOOMR || {};
  window.BOOMR.snippetStart = new Date().getTime();
  window.BOOMR.snippetExecuted = true;
  window.BOOMR.snippetVersion = 12;
  window.BOOMR.application = "storefront-renderer";
  window.BOOMR.themeName = "DTFW";
  window.BOOMR.themeVersion = "1.0";
  window.BOOMR.shopId = 68023124200;
  window.BOOMR.themeId = 139168678120;
  window.BOOMR.renderRegion = "gcp-asia-southeast1";
  window.BOOMR.url =
    "https://toytime-theme.myshopify.com/cdn/shopifycloud/boomerang/shopify-boomerang-1.0.0.min.js";
  var where = document.currentScript || document.getElementsByTagName("script")[0];
  var parentNode = where.parentNode;
  var promoted = false;
  var LOADER_TIMEOUT = 3000;
  function promote() {
    if (promoted) {
      return;
    }
    var script = document.createElement("script");
    script.id = "boomr-scr-as";
    script.src = window.BOOMR.url;
    script.async = true;
    parentNode.appendChild(script);
    promoted = true;
  }
  function iframeLoader(wasFallback) {
    promoted = true;
    var dom, bootstrap, iframe, iframeStyle;
    var doc = document;
    var win = window;
    window.BOOMR.snippetMethod = wasFallback ? "if" : "i";
    bootstrap = function(parent, scriptId) {
      var script = doc.createElement("script");
      script.id = scriptId || "boomr-if-as";
      script.src = window.BOOMR.url;
      BOOMR_lstart = new Date().getTime();
      parent = parent || doc.body;
      parent.appendChild(script);
    };
    if (!window.addEventListener && window.attachEvent && navigator.userAgent.match(/MSIE [67]./)) {
      window.BOOMR.snippetMethod = "s";
      bootstrap(parentNode, "boomr-async");
      return;
    }
    iframe = document.createElement("IFRAME");
    iframe.src = "about:blank";
    iframe.title = "";
    iframe.role = "presentation";
    iframe.loading = "eager";
    iframeStyle = (iframe.frameElement || iframe).style;
    iframeStyle.width = 0;
    iframeStyle.height = 0;
    iframeStyle.border = 0;
    iframeStyle.display = "none";
    parentNode.appendChild(iframe);
    try {
      win = iframe.contentWindow;
      doc = win.document.open();
    } catch (e) {
      dom = document.domain;
      iframe.src = "javascript:var d=document.open();d.domain='" + dom + "';void(0);";
      win = iframe.contentWindow;
      doc = win.document.open();
    }
    if (dom) {
      doc._boomrl = function() {
        this.domain = dom;
        bootstrap();
      };
      doc.write("<body onload='document._boomrl();'>");
    } else {
      win._boomrl = function() {
        bootstrap();
      };
      if (win.addEventListener) {
        win.addEventListener("load", win._boomrl, false);
      } else if (win.attachEvent) {
        win.attachEvent("onload", win._boomrl);
      }
    }
    doc.close();
  }
  var link = document.createElement("link");
  if (link.relList &&
    typeof link.relList.supports === "function" &&
    link.relList.supports("preload") &&
    ("as" in link)) {
    window.BOOMR.snippetMethod = "p";
    link.href = window.BOOMR.url;
    link.rel = "preload";
    link.as = "script";
    link.addEventListener("load", promote);
    link.addEventListener("error", function() {
      iframeLoader(true);
    });
    setTimeout(function() {
      if (!promoted) {
        iframeLoader(true);
      }
    }, LOADER_TIMEOUT);
    BOOMR_lstart = new Date().getTime();
    parentNode.appendChild(link);
  } else {
    iframeLoader(false);
  }
  function boomerangSaveLoadTime(e) {
    window.BOOMR_onload = (e && e.timeStamp) || new Date().getTime();
  }
  if (window.addEventListener) {
    window.addEventListener("load", boomerangSaveLoadTime, false);
  } else if (window.attachEvent) {
    window.attachEvent("onload", boomerangSaveLoadTime);
  }
  if (document.addEventListener) {
    document.addEventListener("onBoomerangLoaded", function(e) {
      e.detail.BOOMR.init({
        ResourceTiming: {
          enabled: true,
          trackedResourceTypes: ["script", "img", "css"]
        },
      });
      e.detail.BOOMR.t_end = new Date().getTime();
    });
  } else if (document.attachEvent) {
    document.attachEvent("onpropertychange", function(e) {
      if (!e) e=event;
      if (e.propertyName === "onBoomerangLoaded") {
        e.detail.BOOMR.init({
          ResourceTiming: {
            enabled: true,
            trackedResourceTypes: ["script", "img", "css"]
          },
        });
        e.detail.BOOMR.t_end = new Date().getTime();
      }
    });
  }
})();</script>
</head>

  <body id="faq" class="gradient preloader-overflow  ">
    
  <div class="dt-custom-overlay"></div>
    <a class="skip-to-content-link button visually-hidden" href="#MainContent">
      Skip to content
    </a>
     
   <div id="preloader">
    <div class="spinner"></div> 
    </div>
    
    <div class="mobile-menu" data-menu="dt-main-menu"> </div>
    <div class="mobile-menu-overlay"></div>

<script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/cart.js?v=167438585933768539991708942415" defer="defer"></script>

<style>
  .drawer {
    visibility: hidden;
  }
.cart-group{ display: grid;  align-items: center; grid-template-columns: repeat(3,1fr);padding:1rem 0;}
.cart-group details:nth-child(3) { border-right: 0px solid rgba(var(--color-base-accent-1),.2);}  
  .cart-drawer .cart-item ul.discounts.list-unstyled .discounts__discount{display:none;}
  


</style>

<cart-drawer class="drawer">
  <div id="CartDrawer" class="cart-drawer">
    <div id="CartDrawer-Overlay"class="cart-drawer__overlay"></div>
    <div class="drawer__inner" role="dialog" aria-modal="true" aria-label="Your Cart" tabindex="-1"><div class="drawer__header">
        <h2 class="drawer__heading">Your Cart (1)</h2>
        <button class="drawer__close close_icon_button"  type="button" onclick="this.closest('cart-drawer').close()" aria-label="Close">
  <svg id="Group_24924" data-name="Group 24924" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 25 25">
            <defs>
            <clipPath id="clip-path">
            <rect id="Rectangle_8252" data-name="Rectangle 8252" width="18" height="18" fill="currentcolor"/>
            </clipPath>
            </defs>
            <g id="Group_24923" data-name="Group 24923" >
            <path id="Path_38934" data-name="Path 38934" d="M23.214,25a1.78,1.78,0,0,1-1.263-.523L.523,3.048A1.786,1.786,0,0,1,3.048.523L24.477,21.952A1.786,1.786,0,0,1,23.214,25" transform="translate(0)"  fill="currentcolor"/>
            <path id="Path_38935" data-name="Path 38935" d="M1.786,25A1.786,1.786,0,0,1,.523,21.952L21.952.523a1.786,1.786,0,1,1,2.525,2.525L3.048,24.477A1.78,1.78,0,0,1,1.786,25" transform="translate(0 0)"  fill="currentcolor"/>
            </g>
            </svg> 
         </button>
      </div>     
       <div class="cart__items-widget">
      <cart-drawer-items >
        <form action="/cart" id="CartDrawer-Form" class="cart__contents cart-drawer__form" method="post">
          <div id="CartDrawer-CartItems" class="drawer__contents js-contents">
              

<div class="cart-progress">
<p style="text-align:center" id="main-cart-progress" data-id="" class="free-shipping ">  
  
  
  
       <span>Congratulations! You&#39;ve got <strong>Free Shipping!</strong></span>
      
  
</p>


<div class="cart-progress-bar">
<progress max="10000" value="65400" class="free-shipp-ready">654
</progress>   
<div class="progress-icon">
</div>
</div>
</div>
<style>

progress[value] {
	-webkit-appearance:none;
    -moz-appearance:none;        
    appearance: none;
	border: none;
	position: relative;
	margin: 0 0 ; 
    height: 7px;
    transition: all 0.3s linear;
  width:100%;
}
 .cart-progress-bar{
   position: relative;
   /*  background: rgba(117, 82, 164, 0.2); */
    height: 7px;
    border-radius: 5px;
    margin-top: 15px;
    /* max-width:fit-content; */
    display: flex;
    align-items: center;
    justify-content: flex-start;
    margin: auto;width:100%;
   padding-top:10px;
}
  .progress-icon{position:relative;}
 .cart__contents{
       margin-top: 5rem;
 }
 /* .progress-icon{position: absolute;
    width: 66px;
    height: 55px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #ffffff;
    color: #ffbc12;
    border-radius: 50%;
    border:1px solid;
    top: 0;
    right: -4px;
    transform: translateY(-50%);            
    animation:blinkers 1.5s  infinite;
               }   */
 .progress-icon:before {
    content: "";
    width: 66px;
    height: 55px;
    background-repeat: no-repeat;
    background-size: contain;
    background-position: center;
    background-image:  url(//toytime-theme.myshopify.com/cdn/shop/t/4/assets/Pet.png?v=31099830677393488161708942415);
    display:block;
    right: 0;
    top: auto;
    bottom: -15px;
    position: absolute;
    z-index: 1;  
} 

progress[value]::-webkit-progress-bar {
	background-color: whiteSmoke;
}
 
progress[value]::-webkit-progress-value {
	position: relative;
	border-radius:5px;
  background-color:  rgba(var(--color-base-outline-button-labels));
}

progress[value]::-moz-progress-bar {

	border-radius:5px;
  	background-color: rgba(var(--color-base-outline-button-labels));
}
@-webkit-keyframes blinkers {
  0% {
    transform: translateY(-50%) scale(0.9);
  }
  50% {
    transform : translateY(-50%) scale(0.95);
  }
  100% {
    transform: translateY(-50%) scale(1);
  }
}
@keyframes blinkers {
  0% {
    transform: translateY(-50%) scale(0.9);
  }
  50% {
     transform : translateY(-50%) scale(1);
  }
  100% {
    transform: translateY(-50%) scale(0.9);
  }
}
progress:after {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0;
    background-image: linear-gradient(135deg,rgba(255,255,255,.2) 0,rgba(255,255,255,.2) 25%,rgba(255,255,255,0) 25%,rgba(255,255,255,0) 50%,rgba(255,255,255,.2) 50%,rgba(255,255,255,.2) 75%,rgba(255,255,255,0) 75%,rgba(255,255,255,0) 100%);
    z-index: 1;
    -webkit-animation: move 5s linear infinite;
    border-radius: 5px;
    overflow: hidden;
    background-size: 3rem 3rem;
}
@keyframes move{
0% {
    background-position: 0 0;
}
100% {
    background-position: -60px -60px;
}
  }

.cart-template cart-items .cart-progress .free-shipping  .cart-progress-bar{display:none;}
.cart-progress .free-shipping  strong{    font-weight: 400;color: rgba(var(--color-base-outline-button-labels));}
.cart-progress .free-shipping{margin:0 0 36px;}  
</style>


            
              <div class="drawer__cart-items-wrapper">
                <table class="cart-items" role="table">
                  <thead role="rowgroup">
                    <tr role="row">
                      <th id="CartDrawer-ColumnProductImage" role="columnheader"><span class="visually-hidden">Translation missing: en.sections.cart.headings.image</span></th>
                      <th id="CartDrawer-ColumnProduct" class="caption-with-letter-spacing" scope="col" role="columnheader">Product</th>
                      <th id="CartDrawer-ColumnTotal" class="right caption-with-letter-spacing" scope="col" role="columnheader">Total</th>
                      <th id="CartDrawer-ColumnQuantity" role="columnheader"><span class="visually-hidden">Quantity</span></th>
                    </tr>
                  </thead>

                  <tbody role="rowgroup"><tr id="CartDrawer-Item-1" class="cart-item" role="row">
                        <td class="cart-item__media" role="cell" headers="CartDrawer-ColumnProductImage">
                          
                            
                            <a href="/products/baby-owl?variant=45411339075816" class="cart-item__link" tabindex="-1" aria-hidden="true"> </a>
                            <img class="cart-item__image"
                              src="//toytime-theme.myshopify.com/cdn/shop/products/shop-17_72a003e3-9e8c-411e-9b11-5c56045e0820.jpg?v=1706620757&width=300"
                              alt="Baby Owl"
                              loading="lazy"
                              width="150"
                              height="150"
                            >
                          
                        </td>

                        <td class="cart-item__details" role="cell" headers="CartDrawer-ColumnProduct"><p class="caption-with-letter-spacing">Toy World</p><a href="/products/baby-owl?variant=45411339075816" class="cart-item__name h4 break">Baby Owl</a>

                          <div class="cart-item__totals right" role="cell" headers="CartDrawer-ColumnTotal">
                         

                          <div class="cart-item__price-wrapper"><span class="price price--end">
                                Rs. 654.00
                              </span></div>
                        </div><dl><div class="product-option Color">
                                    <!-- <dt>Color: </dt> -->
                                    <dd>Pink</dd>
                                  </div><div class="product-option Weight">
                                    <!-- <dt>Weight: </dt> -->
                                    <dd>90 g</dd>
                                  </div><div class="product-option Material">
                                    <!-- <dt>Material: </dt> -->
                                    <dd>Cotton</dd>
                                  </div></dl>

                            <p class="product-option"></p><ul class="discounts list-unstyled" role="list" aria-label="Discount"></ul>
                         <div class="cart-item__quantity" role="cell" headers="CartDrawer-ColumnQuantity">
                          <div class="cart-item__quantity-wrapper">
                            <quantity-input class="quantity">
                              <button class="quantity__button no-js-hidden" name="minus" type="button">
                                <span class="visually-hidden">Decrease quantity for Baby Owl</span>
                                
<svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24"><path d="M200-440v-80h560v80H200Z" fill="currentcolor"/></svg>
                              </button>
                              <input class="quantity__input"
                                type="number"
                                name="updates[]"
                                value="1"
                                min="0"
                                aria-label="Quantity for Baby Owl"
                                id="Drawer-quantity-1"
                                data-index="1"
                              >
                              <button class="quantity__button no-js-hidden" name="plus" type="button">
                                <span class="visually-hidden">Increase quantity for Baby Owl</span>
                                
 <svg xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 -960 960 960" width="24" class="icon icon-plus" ><path d="M440-440H200v-80h240v-240h80v240h240v80H520v240h-80v-240Z" fill="currentcolor"/></svg>
               
                              </button>
                            </quantity-input>

                            
                          </div>

                          <div id="CartDrawer-LineItemError-1" class="cart-item__error" role="alert">
                            <small class="cart-item__error-text"></small>
                            <svg aria-hidden="true" focusable="false" role="presentation" class="icon icon-error" viewBox="0 0 13 13">
                              <circle cx="6.5" cy="6.50049" r="5.5" stroke="white" stroke-width="2"/>
                              <circle cx="6.5" cy="6.5" r="5.5" fill="#EB001B" stroke="#EB001B" stroke-width="0.7"/>
                              <path d="M5.87413 3.52832L5.97439 7.57216H7.02713L7.12739 3.52832H5.87413ZM6.50076 9.66091C6.88091 9.66091 7.18169 9.37267 7.18169 9.00504C7.18169 8.63742 6.88091 8.34917 6.50076 8.34917C6.12061 8.34917 5.81982 8.63742 5.81982 9.00504C5.81982 9.37267 6.12061 9.66091 6.50076 9.66091Z" fill="white"/>
                              <path d="M5.87413 3.17832H5.51535L5.52424 3.537L5.6245 7.58083L5.63296 7.92216H5.97439H7.02713H7.36856L7.37702 7.58083L7.47728 3.537L7.48617 3.17832H7.12739H5.87413ZM6.50076 10.0109C7.06121 10.0109 7.5317 9.57872 7.5317 9.00504C7.5317 8.43137 7.06121 7.99918 6.50076 7.99918C5.94031 7.99918 5.46982 8.43137 5.46982 9.00504C5.46982 9.57872 5.94031 10.0109 6.50076 10.0109Z" fill="white" stroke="#EB001B" stroke-width="0.7">
                            </svg>
                          </div>
                           <cart-remove-button id="CartDrawer-Remove-1" data-index="1">
                              <button class="button button--tertiary" aria-label="Remove Baby Owl - Pink / 90 g / Cotton">
                                   
<svg xmlns="http://www.w3.org/2000/svg" width="17" height="22" viewBox="0 0 17 22" fill="none">
  <path d="M10.9849 21H6.01515C3.76592 21 1.89157 19.2613 1.74163 17.0213L1.0026 6.152C0.959754 5.53333 1.45244 5 2.08436 5H14.9263C15.5476 5 16.0402 5.52267 15.9974 6.14133L15.2584 17.0213C15.1084 19.2613 13.2341 21 10.9849 21Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M6 16V9" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M11 9V16" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M1 2H16" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M9 2V1" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
                              </button>
                          </cart-remove-button>
                         </div>         
                        </td>
                      </tr></tbody>
                </table>
              </div><p id="CartDrawer-LiveRegionText" class="visually-hidden" role="status"></p>
            <p id="CartDrawer-LineItemStatus" class="visually-hidden" aria-hidden="true" role="status">Loading...</p>
          </div>
          <div id="CartDrawer-CartErrors" role="alert"></div>
        </form>
      </cart-drawer-items>
         
  </div>
     
                <div class="drawer__footer ">
    <div class="cart-group"><details id="Details-CartDrawer">
        <summary>
        <svg id="Component_60_1" data-name="Component 60 – 1" xmlns="http://www.w3.org/2000/svg" width="23.159" height="21.5" viewBox="0 0 23.159 21.5" class="icon icon-free-shipping">
  <path id="Line_352" data-name="Line 352" d="M6.47.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H6.47A.75.75,0,0,1,7.22,0,.75.75,0,0,1,6.47.75Z" transform="translate(7.496 5.637)" fill="currentcolor"/>
  <path id="Path_54601" data-name="Path 54601" d="M19.659,25.363H5.678a1.817,1.817,0,0,1-1.815-1.815V5.678A1.817,1.817,0,0,1,5.678,3.863H19.544a1.817,1.817,0,0,1,1.815,1.815V10.84a.75.75,0,0,1-1.5,0V5.678a.315.315,0,0,0-.315-.315H5.678a.316.316,0,0,0-.315.315v17.87a.315.315,0,0,0,.315.315H19.659a.315.315,0,0,0,.315-.315V20.936a.75.75,0,0,1,1.5,0v2.612A1.817,1.817,0,0,1,19.659,25.363Z" transform="translate(-3.863 -3.863)" fill="currentcolor"/>
  <path id="Path_54602" data-name="Path 54602" d="M186.027,111.452h0a1.15,1.15,0,0,1-1.062-1.582l1.485-3.653a.75.75,0,0,1,.164-.248l6.21-6.215a2.1,2.1,0,0,1,2.965,0l.784.784a2.1,2.1,0,0,1,0,2.965l-6.21,6.215a.75.75,0,0,1-.248.165l-3.653,1.485A1.149,1.149,0,0,1,186.027,111.452Zm1.755-4.531-1.114,2.742,2.742-1.114,6.1-6.108a.6.6,0,0,0,0-.844l-.784-.784a.6.6,0,0,0-.844,0Z" transform="translate(-174.027 -93.427)" fill="currentcolor"/>
  <path id="Line_353" data-name="Line 353" d="M2.688,3.438a.748.748,0,0,1-.53-.22L-.53.53A.75.75,0,0,1-.53-.53.75.75,0,0,1,.53-.53L3.219,2.158a.75.75,0,0,1-.53,1.28Z" transform="translate(18.539 7.649)" fill="currentcolor"/>
  <path id="Path_54603" data-name="Path 54603" d="M213.588,213.576a.748.748,0,0,1-.53-.22l-2.688-2.688a.75.75,0,0,1,1.061-1.061l2.688,2.688a.75.75,0,0,1-.53,1.28Z" transform="translate(-197.783 -197.067)" fill="currentcolor"/>
  <path id="Line_354" data-name="Line 354" d="M0,3.931a.748.748,0,0,1-.53-.22.75.75,0,0,1,0-1.061L2.651-.53a.75.75,0,0,1,1.061,0,.75.75,0,0,1,0,1.061L.53,3.711A.748.748,0,0,1,0,3.931Z" transform="translate(15.567 10.13)" fill="currentcolor"/>
  <path id="Path_54604" data-name="Path 54604" d="M47.82,71.078a.75.75,0,0,1-.57-.263l-.963-1.128a.75.75,0,1,1,1.14-.974l.354.415.958-1.28a.75.75,0,0,1,1.2.9l-1.52,2.031a.75.75,0,0,1-.576.3Z" transform="translate(-43.574 -63.729)" fill="currentcolor"/>
  <path id="Line_355" data-name="Line 355" d="M5.126.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H5.126a.75.75,0,0,1,.75.75A.75.75,0,0,1,5.126.75Z" transform="translate(7.496 10.734)" fill="currentcolor"/>
  <path id="Path_54605" data-name="Path 54605" d="M47.82,156.094a.75.75,0,0,1-.57-.263l-.963-1.128a.75.75,0,0,1,1.14-.974l.354.415.958-1.28a.75.75,0,1,1,1.2.9l-1.52,2.031a.75.75,0,0,1-.576.3Z" transform="translate(-43.574 -143.648)" fill="currentcolor"/>
  <path id="Line_356" data-name="Line 356" d="M2.427.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H2.427a.75.75,0,0,1,.75.75A.75.75,0,0,1,2.427.75Z" transform="translate(7.496 15.831)" fill="currentcolor"/>
  <path id="Path_54606" data-name="Path 54606" d="M47.82,241.109a.75.75,0,0,1-.57-.263l-.963-1.128a.75.75,0,1,1,1.141-.974l.354.415.958-1.28a.75.75,0,1,1,1.2.9l-1.52,2.031a.75.75,0,0,1-.576.3Z" transform="translate(-43.574 -223.567)" fill="currentcolor"/>
</svg>
   
        <span class="summary__title">
        Order Instructions
        </span>        
        </summary>  
        <div class="cart-drawer-detail">                          
        <cart-note class="cart__note field drawer-details">
        <button type="button" class="close link" onclick="this.closest('details').querySelector('summary').click()">
        
  <svg id="Group_24924" data-name="Group 24924" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 25 25">
            <defs>
            <clipPath id="clip-path">
            <rect id="Rectangle_8252" data-name="Rectangle 8252" width="18" height="18" fill="currentcolor"/>
            </clipPath>
            </defs>
            <g id="Group_24923" data-name="Group 24923" >
            <path id="Path_38934" data-name="Path 38934" d="M23.214,25a1.78,1.78,0,0,1-1.263-.523L.523,3.048A1.786,1.786,0,0,1,3.048.523L24.477,21.952A1.786,1.786,0,0,1,23.214,25" transform="translate(0)"  fill="currentcolor"/>
            <path id="Path_38935" data-name="Path 38935" d="M1.786,25A1.786,1.786,0,0,1,.523,21.952L21.952.523a1.786,1.786,0,1,1,2.525,2.525L3.048,24.477A1.78,1.78,0,0,1,1.786,25" transform="translate(0 0)"  fill="currentcolor"/>
            </g>
            </svg> 
         
        </button>
        <label class="visually-hidden" for="CartDrawer-Note">Order Instructions</label>
        <textarea id="CartDrawer-Note" class="text-area text-area--resize-vertical field__input" name="note" placeholder="How can we help you ?"></textarea>
        </cart-note>  
          </div>
        </details>
<details id="Gift-Wrapper">
        <summary>
        <svg id="Component_61_1" data-name="Component 61 – 1" xmlns="http://www.w3.org/2000/svg" width="19.287" height="21.5" viewBox="0 0 19.287 21.5"  class="icon icon-free-shipping">
  <path id="Path_54595" data-name="Path 54595" d="M39.792,213.235H25.173a.75.75,0,0,1-.749-.711l-.477-9.042a.75.75,0,1,1,1.5-.079l.439,8.331h13.2l.439-8.331a.75.75,0,1,1,1.5.079l-.477,9.042A.75.75,0,0,1,39.792,213.235Z" transform="translate(-22.839 -191.735)" fill="currentcolor"/>
  <path id="Path_54596" data-name="Path 54596" d="M196.616,104.734h-5.767a.75.75,0,0,1,0-1.5h5.615v-3.1h-6.84a.75.75,0,0,1,0-1.5h6.992a1.35,1.35,0,0,1,1.348,1.348v3.408A1.35,1.35,0,0,1,196.616,104.734Z" transform="translate(-178.677 -93.407)" fill="currentcolor"/>
  <path id="Path_54597" data-name="Path 54597" d="M10.979,104.734H5.212c-.835,0-1.348-.932-1.348-1.6V99.726a1.032,1.032,0,0,1,.637-.989,1.8,1.8,0,0,1,.711-.107H12.2a.75.75,0,1,1,0,1.5H5.364v3a.376.376,0,0,0,.033.1h5.582a.75.75,0,0,1,0,1.5Z" transform="translate(-3.864 -93.407)" fill="currentcolor"/>
  <path id="Path_54598" data-name="Path 54598" d="M165.994,16.189a.751.751,0,0,1-.714-.98,7.142,7.142,0,0,1,2.152-3.15,3.869,3.869,0,0,1,2.723-.97,2.223,2.223,0,0,1,1.569.795,2.155,2.155,0,0,1,.5,1.761,2.666,2.666,0,0,1-1.26,1.771,7.713,7.713,0,0,1-1.741.739.75.75,0,1,1-.441-1.434,6.265,6.265,0,0,0,1.4-.584,1.19,1.19,0,0,0,.566-.74.682.682,0,0,0-.18-.561.74.74,0,0,0-.54-.253,2.364,2.364,0,0,0-1.616.612,5.705,5.705,0,0,0-1.7,2.472A.75.75,0,0,1,165.994,16.189Z" transform="translate(-156.35 -10.682)" fill="currentcolor"/>
  <path id="Path_54599" data-name="Path 54599" d="M65.288,9.37a.749.749,0,0,1-.24-.04,5.487,5.487,0,0,1-1.517-.761A2.657,2.657,0,0,1,62.7,4.911a2.415,2.415,0,0,1,1.712-1.017,4.034,4.034,0,0,1,3.018.907A5.839,5.839,0,0,1,69.441,8.51a.75.75,0,1,1-1.484.221A4.364,4.364,0,0,0,66.48,5.96a2.565,2.565,0,0,0-1.854-.581.946.946,0,0,0-.685.378c-.448.654.122,1.338.485,1.608a4.01,4.01,0,0,0,1.1.544.75.75,0,0,1-.24,1.461Z" transform="translate(-59.055 -3.862)" fill="currentcolor"/>
  <path id="Path_54600" data-name="Path 54600" d="M144.936,113.73a.75.75,0,0,1-.75-.75v-12.85h-1.107v12.85a.75.75,0,1,1-1.5,0v-13.6a.75.75,0,0,1,.75-.75h2.607a.75.75,0,0,1,.75.75v13.6A.75.75,0,0,1,144.936,113.73Z" transform="translate(-133.989 -93.408)" fill="currentcolor"/>
</svg>
    
        <span class="summary__title">Gift wrap</span>
        </summary>
         
<div class="cart-drawer-detail">
<div
  id="is-a-gift"
  style="clear: left;"
  class="clearfix rte drawer-details"
>
  <p>
    <input
      id="gift-wrapping"
      type="checkbox"
      name="attributes[gift-wrapping]"
      value="yes"
      
      style="float: none"
    />
    <label
      for="gift-wrapping"
      style="display:inline; padding-left: 0px; float: none;"
    >
      
      
        <button type="button" class="close  link" onclick="this.closest('details').querySelector('summary').click()">
  
  <svg id="Group_24924" data-name="Group 24924" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 25 25">
            <defs>
            <clipPath id="clip-path">
            <rect id="Rectangle_8252" data-name="Rectangle 8252" width="18" height="18" fill="currentcolor"/>
            </clipPath>
            </defs>
            <g id="Group_24923" data-name="Group 24923" >
            <path id="Path_38934" data-name="Path 38934" d="M23.214,25a1.78,1.78,0,0,1-1.263-.523L.523,3.048A1.786,1.786,0,0,1,3.048.523L24.477,21.952A1.786,1.786,0,0,1,23.214,25" transform="translate(0)"  fill="currentcolor"/>
            <path id="Path_38935" data-name="Path 38935" d="M1.786,25A1.786,1.786,0,0,1,.523,21.952L21.952.523a1.786,1.786,0,1,1,2.525,2.525L3.048,24.477A1.78,1.78,0,0,1,1.786,25" transform="translate(0 0)"  fill="currentcolor"/>
            </g>
            </svg> 
         
   </button>
        
      Add this gift wrap worth of  Rs. 450.00      
    </label>
  </p>  
</div>
</div>
  

<style>
  #updates_45418290282728 { display: none; }
</style>

<script>

  Shopify.Cart = Shopify.Cart || {};

  Shopify.Cart.GiftWrap = {};

  Shopify.Cart.GiftWrap.set = function() {
    var headers = new Headers({ 'Content-Type': 'application/json' });

    var request = {
      method: 'POST',
      headers: headers,
      body: JSON.stringify({ updates: { 45418290282728: 1 }, attributes: { 'gift-wrapping': true } })
    };
    fetch('/cart/update.js', request)
    .then(function() {
      location.href = '/cart';
    });
  }

  Shopify.Cart.GiftWrap.remove = function() {
    var headers = new Headers({ 'Content-Type': 'application/json' });

    var request = {
      method: 'POST',
      headers: headers,
      body: JSON.stringify({ updates: { 45418290282728: 0 }, attributes: { 'gift-wrapping': '' } })
    };
    fetch('/cart/update.js', request)
    .then(function() {
      location.href = '/cart';
    });
  }

  // If we have nothing but gift-wrap items in the cart.
  

  // When the gift-wrapping checkbox is checked or unchecked.
  document.addEventListener("DOMContentLoaded", function(){
    document.querySelector('[name="attributes[gift-wrapping]"]').addEventListener("change", function(event) {
      if (event.target.checked) {
        Shopify.Cart.GiftWrap.set();
      } else {
        Shopify.Cart.GiftWrap.remove();
      }

    });

  });
</script>
 
        </details>
<details id="Discount-Wrapper">            
        <summary>
        <svg id="Component_63_1" data-name="Component 63 – 1" xmlns="http://www.w3.org/2000/svg" width="29.339" height="21.5" viewBox="0 0 29.339 21.5" class="icon icon-free-shipping">
  <path id="Rectangle_8832" data-name="Rectangle 8832" d="M3-.75H24.839A3.754,3.754,0,0,1,28.589,3V17a3.754,3.754,0,0,1-3.75,3.75H3A3.754,3.754,0,0,1-.75,17V3A3.754,3.754,0,0,1,3-.75Zm21.839,20A2.253,2.253,0,0,0,27.089,17V3A2.253,2.253,0,0,0,24.839.75H3A2.253,2.253,0,0,0,.75,3V17A2.253,2.253,0,0,0,3,19.25Z" transform="translate(0.75 0.75)" fill="currentcolor"/>
  <path id="Line_339" data-name="Line 339" d="M2.524.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H2.524a.75.75,0,0,1,.75.75A.75.75,0,0,1,2.524.75Z" transform="translate(0.75 10.75)" fill="currentcolor"/>
  <path id="Line_340" data-name="Line 340" d="M10.22.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H10.22a.75.75,0,0,1,.75.75A.75.75,0,0,1,10.22.75Z" transform="translate(18.369 10.75)" fill="currentcolor"/>
  <path id="Line_341" data-name="Line 341" d="M0,6.822a.75.75,0,0,1-.75-.75V0A.75.75,0,0,1,0-.75.75.75,0,0,1,.75,0V6.072A.75.75,0,0,1,0,6.822Z" transform="translate(10.566 14.677)" fill="currentcolor"/>
  <path id="Line_342" data-name="Line 342" d="M0,6.229a.75.75,0,0,1-.75-.75V0A.75.75,0,0,1,0-.75.75.75,0,0,1,.75,0V5.479A.75.75,0,0,1,0,6.229Z" transform="translate(10.566 0.75)" fill="currentcolor"/>
  <path id="Path_54586" data-name="Path 54586" d="M127.382,79.8c-.186,0-.349,0-.492,0l-.259,0a.75.75,0,0,1-.73-.923c.033-.137.818-3.382,2.535-4.762a3.52,3.52,0,0,1,2.209-.823,2.955,2.955,0,0,1,2.223,1,2.719,2.719,0,0,1,.672,2.046,3.036,3.036,0,0,1-1.091,2.108A7.811,7.811,0,0,1,127.382,79.8Zm3.263-5.015a2.041,2.041,0,0,0-1.269.492,7.134,7.134,0,0,0-1.745,3.021,6.2,6.2,0,0,0,3.866-1.019,1.529,1.529,0,0,0,.547-1.063,1.234,1.234,0,0,0-.293-.931A1.454,1.454,0,0,0,130.645,74.79Z" transform="translate(-116.064 -67.705)" fill="currentcolor"/>
  <path id="Path_54587" data-name="Path 54587" d="M55.374,79.8a7.812,7.812,0,0,1-5.067-1.362,3.036,3.036,0,0,1-1.091-2.108,2.719,2.719,0,0,1,.672-2.046,2.955,2.955,0,0,1,2.223-1,3.52,3.52,0,0,1,2.208.822c1.717,1.38,2.5,4.625,2.535,4.762a.75.75,0,0,1-.73.923l-.259,0C55.722,79.8,55.56,79.8,55.374,79.8ZM52.111,74.79a1.454,1.454,0,0,0-1.107.5,1.234,1.234,0,0,0-.293.931,1.529,1.529,0,0,0,.547,1.063A6.2,6.2,0,0,0,55.123,78.3a7.155,7.155,0,0,0-1.744-3.021A2.041,2.041,0,0,0,52.111,74.79Z" transform="translate(-45.559 -67.705)" fill="currentcolor"/>
  <path id="Line_343" data-name="Line 343" d="M3.206,3.956a.748.748,0,0,1-.53-.22L-.53.53A.75.75,0,0,1-.53-.53.75.75,0,0,1,.53-.53L3.736,2.675a.75.75,0,0,1-.53,1.28Z" transform="translate(10.566 11.353)" fill="currentcolor"/>
  <path id="Line_344" data-name="Line 344" d="M0,3.956a.748.748,0,0,1-.53-.22.75.75,0,0,1,0-1.061L2.675-.53a.75.75,0,0,1,1.061,0,.75.75,0,0,1,0,1.061L.53,3.736A.748.748,0,0,1,0,3.956Z" transform="translate(7.359 11.353)" fill="currentcolor"/>
  <path id="Line_345" data-name="Line 345" d="M5.515.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H5.515a.75.75,0,0,1,.75.75A.75.75,0,0,1,5.515.75Z" transform="translate(19.479 15.268)" fill="currentcolor"/>
  <path id="Line_346" data-name="Line 346" d="M2.757.75H0A.75.75,0,0,1-.75,0,.75.75,0,0,1,0-.75H2.757a.75.75,0,0,1,.75.75A.75.75,0,0,1,2.757.75Z" transform="translate(19.479 17.776)" fill="currentcolor"/>
</svg>

        <span class="summary__title">Discount</span>
        </summary>
         <div class="cart-drawer-detail">                         
        <div class="drawer-details">                      
        <button type="button" class="close link" onclick="this.closest('details').querySelector('summary').click()">
        
  <svg id="Group_24924" data-name="Group 24924" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 25 25">
            <defs>
            <clipPath id="clip-path">
            <rect id="Rectangle_8252" data-name="Rectangle 8252" width="18" height="18" fill="currentcolor"/>
            </clipPath>
            </defs>
            <g id="Group_24923" data-name="Group 24923" >
            <path id="Path_38934" data-name="Path 38934" d="M23.214,25a1.78,1.78,0,0,1-1.263-.523L.523,3.048A1.786,1.786,0,0,1,3.048.523L24.477,21.952A1.786,1.786,0,0,1,23.214,25" transform="translate(0)"  fill="currentcolor"/>
            <path id="Path_38935" data-name="Path 38935" d="M1.786,25A1.786,1.786,0,0,1,.523,21.952L21.952.523a1.786,1.786,0,1,1,2.525,2.525L3.048,24.477A1.78,1.78,0,0,1,1.786,25" transform="translate(0 0)"  fill="currentcolor"/>
            </g>
            </svg> 
         
        </button>
        <input type="text" id="drawer-discount" name="discount" placeholder="Enter discount code..."  class="discount-code" value="">   
        <button type="button" class="save button" onclick="saveOption();">SAVE</button>
        </div>
        </div>                          
        </details>
        <script>
        function saveOption() { 
        const element = document.getElementById("drawer-discount");
        const name = $("input[name=discount]").val();  
        if(name != ""){               
        localStorage.setItem("coupon", name);    
        var savedCode = localStorage.getItem('coupon')        
        }
        }
        </script></div>
        <!-- Start blocks-->
        <!-- Subtotals-->

        <div class="cart-drawer__footer" >
          <div class="totals" role="status">
            <h2 class="totals__subtotal">Subtotal</h2>
            <p class="totals__subtotal-value">Rs. 654.00</p>
          </div>

          <div></div>

          <small class="tax-note caption-large rte">Taxes and shipping calculated at checkout
</small>
        </div>

        <!-- CTAs -->

        <div class="cart__ctas" >
          <noscript>
            <button type="submit" class="cart__update-button button button--secondary" form="CartDrawer-Form">
              Update
            </button>
          </noscript>
           <a href="/cart" type="submit" id="CartDrawer-Cart" class="cart__view_cart-button link" name="viewcart" form="CartDrawer-Form">
                                  View Cart
          </a> 
           <button type="submit" id="CartDrawer-Checkout" class="cart__checkout-button button" name="checkout" form="CartDrawer-Form">
            Proceed to checkout
          </button>                      
                             
        </div>
        </div>     
    </div>
  </div>
</cart-drawer>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    function isIE() {
      const ua = window.navigator.userAgent;
      const msie = ua.indexOf('MSIE ');
      const trident = ua.indexOf('Trident/');

      return (msie > 0 || trident > 0);
    }

    if (!isIE()) return;
    const cartSubmitInput = document.createElement('input');
    cartSubmitInput.setAttribute('name', 'checkout');
    cartSubmitInput.setAttribute('type', 'hidden');
    document.querySelector('#cart').appendChild(cartSubmitInput);
    document.querySelector('#checkout').addEventListener('click', function(event) {
      document.querySelector('#cart').submit();
    });
  });
  
</script>

<div id="shopify-section-announcement-bar" class="shopify-section">
<style data-shopify>@media screen and (max-width: 990px) {
  
    .announcement-bar-wrapper.hide-mobile{display:none;}
   }

  .marquee:before {
  left: 0;
  background: linear-gradient(to right, white 5%, transparent 100%);
}
.marquee:after {
  right: 0;
  background: linear-gradient(to left, white 5%, transparent 100%);
}
.marquee:before, .marquee:after {
   position: absolute;
  top: 0;
  width: 100px;
  height: 35px;
  content: "";
  z-index: 1;
}

.announcement-bar-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
      padding: 8px 0;
    /* border-bottom: 0.1rem solid rgba(var(--color-foreground), 0.08); */
} 
.marquee__content {
    display: flex;
    align-items: center;
    white-space: nowrap;
    overflow: hidden;
}  
.marquee_annoucement  {animation: scroll-left 20s linear infinite;display: flex;
    align-items: center;
    justify-content: space-around;
    flex-shrink: 0;
    min-width: 100%;}
.marquee__content:hover .marquee_annoucement {animation-play-state: paused;}
.announcement-bar {padding:0 5vw;}
.announcement-bar .announcement-bar__message{margin:0;padding:0} 
@keyframes scroll-left{0%{transform:translateX(0%);}100%{transform:translateX(-100%);}}

body.overflow-hidden #shopify-section-announcement-bar, body.overflow-hidden-mobile #shopify-section-announcement-bar{ z-index: 0;}
  body.overflow-hidden-tablet #shopify-section-announcement-bar { z-index: 0;  display: none;}</style>
</div>   
    <div id="shopify-section-top-bar" class="shopify-section">
<style data-shopify>@media screen and (max-width: 990px) {
  
    .announcement-bar-wrapper.hide-mobile{display:none;}
   }

  .marquee:before {
  left: 0;
  background: linear-gradient(to right, white 5%, transparent 100%);
}
.marquee:after {
  right: 0;
  background: linear-gradient(to left, white 5%, transparent 100%);
}
.marquee:before, .marquee:after {
   position: absolute;
  top: 0;
  width: 100px;
  height: 35px;
  content: "";
  z-index: 1;
}

.announcement-bar-wrapper {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    padding: 8px 0;
    /* border-bottom: 0.1rem solid rgba(var(--color-foreground), 0.08); */
} 
.marquee__content {
    display: flex;
    align-items: center;
    white-space: nowrap;
    overflow: hidden;
}  
.marquee_annoucement  {animation: scroll-left 20s linear infinite;display: flex;
    align-items: center;
    justify-content: space-around;
    flex-shrink: 0;
    min-width: 100%;}

.announcement-bar {padding:0 5vw;}
.announcement-bar .announcement-bar__message{margin:0;padding:0} 
@keyframes scroll-left{0%{transform:translateX(0%);}100%{transform:translateX(-100%);}}

body.overflow-hidden #shopify-section-announcement-bar, body.overflow-hidden-mobile #shopify-section-announcement-bar{ z-index: 0;}
  body.overflow-hidden-tablet #shopify-section-announcement-bar { z-index: 0;  display: none;}</style>


  <script>
  class verticalBar extends HTMLElement {
  constructor() {
    super();
    this.container = document.querySelector('.enable-vertical-marquee');
    // Initialize Swiper
    this.mySwiper = new Swiper(this.container, {
        effect: "fade",
        fadeEffect: {
        crossFade: true
        },
         loop: true,
         navigation: {
            nextEl: '.vertical-marquee-next',
            prevEl: '.vertical-marquee-prev',
         },
         autoplay: {
            delay: 3000,
            disableOnInteraction: false,
         },
         speed: 1000, 
          });
  }
}
customElements.define('vertical-bar', verticalBar);  
</script>
  <style>
    .social-icons{ display:none;}
    .dt-sc-header-top-bar a{ font-family:var(--font-heading-family); font-size:1.4rem; font-weight:500; }
      .dt-sc-header-top-bar .header-contact{ widht:2rem; height:2rem;}
      .dt-sc-header-top-bar{padding-top:0px;padding-bottom:0px;}
      .dt-sc-header-top-bar .list-social__link svg{width:1.6rem;height:1.6rem;}
      .dt-sc-header-top-bar .list-social__item:not(:last-child) .list-social__link{margin-right: 20px;}
      .dt-sc-header-top-bar a .icon-text{font-size:1.4rem;font-weight:600;transition: all var(--duration-default) linear;}
      .dt-sc-header-top-bar ul{list-style:none;margin:0;padding:0; display:flex;align-items: center;}
      .dt-sc-header-top-bar a{text-decoration:none;display: inline-flex;  justify-content:center; gap:10px;}
      .dt-sc-header-top-bar .dt-sc-flex-space-between{display: flex;justify-content: space-between;align-items:center;flex-wrap: wrap;}
      .dt-sc-header-top-bar .header-contact,
      .dt-sc-header-top-bar .top-bar-content{display: flex;justify-content: space-between;align-items:center;}
      .dt-sc-header-top-bar .header-contact li:not(:last-child){margin-right:20px}
      .dt-sc-header-top-bar .top-bar-content a.top-bar-link.link {text-decoration: underline;}
      .dt-sc-header-top-bar .top-bar-content .top-bar-text{margin:0;font-size:1.4rem;font-weight:500;}
      .dt-sc-header-top-bar .list-social__link{padding:0 0rem;/* color: rgb(var(--color-foreground)); */}
      .dt-sc-header-top-bar .disclosure__link{color:var(--gradient-base-accent-1);}
      .dt-sc-header-top-bar .disclosure .localization-form__select{padding-top: 0;margin: 0!important; padding-bottom: 0;font-weight:500;box-shadow: none;outline: 0;text-decoration: none;padding-right:4rem;}
      .dt-sc-header-top-bar .localization-form{padding:0!important;margin:0!important;}
      .dt-sc-header-top-bar .localization-selector+.disclosure__list-wrapper{opacity: 1;animation: animateLocalization var(--duration-default) ease;}
      .dt-sc-header-top-bar .disclosure__list,
      .dt-sc-header-top-bar .disclosure__list-wrapper{flex-direction: column;z-index:3;}
      .dt-sc-header-top-bar .localization-form__select .icon-caret{width: 6px;right: 28px;}
      .dt-sc-header-top-bar .disclosure__button{font-size:1.4rem;}
      .dt-sc-header-top-bar .disclosure .flag-icon{display:none;}
      .dt-sc-header-top-bar .disclosure__list-wrapper{background-color: var(--gradient-base-background-1);}
      .dt-sc-header-top-bar .disclosure__link:hover { color: var(--gradient-base-accent-2);}
      .dt-sc-header-top-bar .disclosure__list{padding:5px 0;}
      .dt-sc-header-top-bar .disclosure .localization-form__select{height:35px;min-height:35px;line-height:normal}
      .localization-selector+.disclosure__list-wrapper{margin-top:6px;}
      .dt-sc-header-top-bar a:hover .icon-text{color:var(--gradient-base-accent-2);}
      .dt-sc-header-top-bar .top-bar-content li{display:flex;align-items: center;}
      .dt-sc-header-top-bar .currency_language{display:flex;}
      .dt-sc-header-top-bar localization-form .disclosure__list-wrapper{top: 100%; bottom: unset;}
        .dt-sc-flex-space-between.flex-center {
        justify-content: center;
        }
      .dt-sc-header-top-bar .localization-form__select .icon-caret {
        position: absolute;
        content: "";
        height: 0.6rem;
        top: calc(50% - 0.2rem);
    }
       @media screen and (max-width: 990px) {
    section.dt-sc-header-top-bar{ display:none;} }
     @media screen and (max-width: 749px) {

      

     }
    .swiper-button-prev1.vertical-marquee-prev ,.swiper-button-next1.vertical-marquee-next{ position:absolute; }
.dt-sc-header-top-bar a p{ margin:0; }
    vertical-bar{ max-width:40rem;}
  </style>
</div>   
    <div id="shopify-section-header" class="shopify-section section-header"><link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-menu.css?v=67740596207655118111708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-search.css?v=11398205511829012651708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-menu-drawer.css?v=16299667800328736951708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-cart-notification.css?v=119852831333870967341708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-cart-items.css?v=104036442983571478941708942415" media="print" onload="this.media='all'"><link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-price.css?v=150523514419358740191708942415" media="print" onload="this.media='all'">
  <link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-loading-overlay.css?v=77174176155476131141708942415" media="print" onload="this.media='all'"><link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-mega-menu.css?v=54702892762461369721710413165" media="print" onload="this.media='all'">
  <noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-mega-menu.css?v=54702892762461369721710413165" rel="stylesheet" type="text/css" media="all" /></noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-cart-drawer.css?v=40032688583049957591709122609" rel="stylesheet" type="text/css" media="all" />
  <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-cart.css?v=135531771766781695931709034119" rel="stylesheet" type="text/css" media="all" />
  <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-totals.css?v=42436900882442635581708942415" rel="stylesheet" type="text/css" media="all" />
  <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-price.css?v=150523514419358740191708942415" rel="stylesheet" type="text/css" media="all" />
  <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-discounts.css?v=152760482443307489271708942415" rel="stylesheet" type="text/css" media="all" />
  <link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-loading-overlay.css?v=77174176155476131141708942415" rel="stylesheet" type="text/css" media="all" />
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-menu.css?v=67740596207655118111708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-search.css?v=11398205511829012651708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-menu-drawer.css?v=16299667800328736951708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-cart-notification.css?v=119852831333870967341708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-cart-items.css?v=104036442983571478941708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
 
<style> 
  
.megamenu_megamenu.mega-menu {
    position: static;
}
.megamenu_megamenu{
  position:relative;
}  
.count-zero {
    display: none;
}
  .count-exist.count-zero {display:block;}
  .header__icons #dT_TopStickySearchBtn.icon-search,
  .search-icon  #dT_TopStickySearchBtn.icon-search{cursor:pointer;width: 26px; height: 26px;display: flex;}
  header svg,
header .header__icon, header .header__icon--cart .icon{width:2.6rem;height:2.6rem;}
  @media screen and (min-width: 1200px) {
    header-drawer {
      display: none;
    }
   .header__icons .icon-search { margin-right: 0;}
    .header:not(.header--top-center) * > .header__search,
    .header--top-center > .header__search {
    display: inline-flex;
    }
    .header:not(.header--top-center) > .header__icons .header__search,
    .header--top-center * > .header__icons .header__search,
    .header--middle.secondary-menu-enabled .header__icons .header__search{
    display: none;
    }
    .header__inline-menu {
    display: inline-flex;
    }
    .tabs-nav.mobileTabs {display: none;}
    .header--top-center .header__heading-link, .header--top-center .header__heading {
    justify-self: center;
    text-align: center;
    }
    header .header__icons .header__search.search-box-hide{display:none;}
     .header {
    padding-top: 0;
    padding-bottom: 0;
  }
  .header--top-left .header-row,
  .header--middle-left:not(.header--has-menu) .header-row {
    grid-template-areas:
     "heading icons"
     "navigation navigation";
    grid-template-columns: 1fr auto;
  }

  .header--middle-left .header-row {
    grid-template-areas: "heading navigation icons";
   grid-template-columns: 1fr auto 1fr; 
    column-gap: 1rem;
  }
  .header--middle .header-row {
    grid-template-areas: "navigation heading  icons";
    grid-template-columns: 1fr auto  1fr;
    column-gap: 1rem;
    padding: 0 50px 0 30px;
  }  
  .header--middle.secondary-menu-enabled .header-row {
    grid-template-areas: "left-icon navigation heading secondary-menu icons";
    grid-template-columns: 1fr 1.5fr auto 1.5fr 1fr;
    column-gap: 1rem;
  }  
  .header--middle.secondary-menu-enabled .header-row #AccessibleNav {
    justify-content: center;
  }
  .header--middle.secondary-menu-enabled .header-row #AccessibleNav ul.dt-nav > li > a {padding:0px 20px;line-height: normal;}
  .header--middle.secondary-menu-enabled .header-row #AccessibleNav ul.dt-nav > li.top-level-link{padding:0;}  
  .header--top-center .header-row{
    grid-template-areas:
      "left-icon heading icons "
      "navigation navigation navigation";
    column-gap: 1.5rem;
    row-gap:1.5rem;
    grid-template-columns: 1fr auto 1fr;
  }
   .header--top-left .header-row{
    grid-template-areas:
      "heading left-icon  icons "
      "navigation navigation navigation";
    grid-template-columns: 1fr 1fr 1fr; 
    column-gap: 1.5rem;
    row-gap:1.5rem; 
  }
  .category-menu-button.header--top-left .header-row{
    grid-template-areas:
      "heading left-icon  icons "
      "category-menu navigation navigation";
    grid-template-columns:auto 1fr auto; 
    column-gap: 1.5rem;
    row-gap:1.5rem; 
  }
  .category-menu-button.header--top-center .header-row{
    grid-template-areas:
      "left-icon heading icons "
      "category-menu navigation navigation";
      grid-template-columns:auto 1fr auto; 
      column-gap: 1.5rem;
    row-gap:1.5rem;
  }
  .header--top-center .header__heading-link, .header--top-center .header__heading {
    justify-self: center;
    text-align: center;
}
   
 .header .search-modal__form{margin-right:1rem;}
 .header .search-modal__form .icon-search {margin: 0;}
 ul.dt-sc-list-inline>li ul.sub-menu-lists>li>ul a:hover{transform:translateX(5px);-webkit-transform:translateX(5px);}   
 .shopify-section-header-sticky .header-wrapper .header {padding:0;}
  ul.dt-sc-list-inline
  > li
  ul.sub-menu-lists
  .tabs-content
  li.dt-sc-menu-tabs
  ul
  li
  ul
  li
  a:hover, ul.dt-sc-list-inline>li:not(.has-mega-menu) ul.sub-menu-lists li a:hover {
  color: rgb(var(--color-base-outline-button-labels));
  transform: translateX(5px); 
  -webkit-transform: translateX(5px);  
}  

  .header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav li:not(.has-mega-menu) .sub-menu-block {margin-top:34px;}
  .header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav li:not(.has-mega-menu) .sub-menu-block .submenu_inner .sub-menu-block{margin-top:0;}
  .header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav li.has-mega-menu .megamenu_megamenu.mega-menu .sub-menu-block{transform:translateY(0);}
  }
@media screen and (max-width: 1199px) {
        .header:not(.header--top-center) >  .header__search,
        .header--top-center * >  .header__search,
        .header--middle.secondary-menu-enabled  .header__search
        {
         display: none;
        }
        .header:not(.header--top-center) > .header__icons .header__search,
        .header--top-center * > .header__icons .header__search,
        .header--middle.secondary-menu-enabled .header__icons .header__search{
        display:  inline-flex;
        }
        .page-width.mega{display:none;}
        ul.sub-menu-lists.dt-sc-column.four-column { grid-template-columns: repeat(1,1fr);row-gap: 15px;}
        ul.dt-sc-list-inline > li ul.sub-menu-lists .hide-mobile { display: none !important;}
        ul.dt-sc-list-inline > li ul.sub-menu-lists .tabs-nav .tabs .heading ~ ul{ border: none; display: inline-block; }
        ul.dt-sc-list-inline > li ul.sub-menu-lists .tabs-nav .tabs .heading ~ ul li > a{ border: none; padding: 0 15px !important;}
        ul.dt-sc-list-inline > li ul.sub-menu-lists .tabs-nav .tabs li a { background:transparent; position:relative; margin:0;cursor: pointer; padding:0; }
       ul.dt-sc-list-inline > li ul.sub-menu-lists .tabs-nav .tabs li a:hover {color:rgba(var(--color-base-outline-button-labels));background:transparent; }
        ul.dt-sc-list-inline > li ul.sub-menu-lists .tabs-nav .tabs > li > a:after{ content: ''; position: absolute; right: 15px; top: 50%; width: 6px; height: 6px; border-left: 1px solid currentColor; border-bottom: 1px solid currentColor; transform: rotate(-45deg) translateY(-50%);}
         header .tag.hot, header .tag.sale, header .tag.new{position:relative;left:10px;} 
        header ul.dt-sc-list-inline>li ul.sub-menu-lists>li>ul a .tag{top:0;}
        header .search-box.search-box-hide{display:none;}
        a.header__icon.link.focus-inset.small-hide,
         header .header__icons   localization-form{display:none}

   
   
   
.menu-drawer ul.sub-menu-lists{ display: inline-block;}
.dt-sc-nav-link.dropdown{display:none;}

.js .menu-drawer__menu li:not(.has-mega-menu) .sub-menu-lists{padding:0;}
.menu-drawer .menu-drawer__navigation .mega-menu__content{margin-bottom:5rem}  

}
@media screen and (max-width: 1199px)  and (min-width:750px){
        
        .header header-drawer{display: flex;justify-content: flex-end;}
       .category-menu-button.header--top-left .header-row,
       .category-menu-button.header--top-center .header-row{
       grid-template-areas:
      "heading left-icon  icons"
      "category-menu category-menu category-menu";
  }
    
  .header__icon--menu .icon{    width: 3rem;height: 3rem;}
  .header .header-row{padding:0 20px;}
  
}

@media screen and (max-width:749px){
   .category-menu-button.header--top-left .header-row .category-menu,
   .category-menu-button.header--top-center .header-row .category-menu{
        grid-column: 1;
  }
  header svg, header .header__icon, header .header__icon--cart .icon,
  .header__icons #dT_TopStickySearchBtn.icon-search, .search-icon #dT_TopStickySearchBtn.icon-search{width:2rem;height:2rem;}
  .header .header-row{padding:0 10px;}
 } 
@media screen and (max-width:480px){
  .category-menu-button.header--top-left .header-row,
   .category-menu-button.header--top-center .header-row{display: flex;flex-direction: column;}
   .category-menu-button.header--top-center .header-row header-drawer,
   .category-menu-button.header--top-left .header-row header-drawer{order: 1;}
   
}
  
  .menu-drawer-container {
    display: flex;
  }
 

  .list-menu {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .list-menu--inline {
    display: inline-flex;
    flex-wrap: wrap;
  }

  summary.list-menu__item {
    padding-right: 2.7rem;
  }

  .list-menu__item {
    display: flex;
    align-items: center;
    line-height: calc(1 + 0.3 / var(--font-body-scale));
  }

  .list-menu__item--link {
    text-decoration: none;
    padding-bottom: 1rem;
    padding-top: 1rem;
    line-height: calc(1 + 0.8 / var(--font-body-scale));
  }

  @media screen and (min-width: 750px) {
    .list-menu__item--link {
      padding-bottom: 0.5rem;
      padding-top: 0.5rem;
    }
    
  }
  .header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav {
    z-index: 2;
}
 /* ul.dt-nav > li.top-level-link{display: inline-flex;}
ul.dt-nav > li.top-level-link a.dt-sc-nav-link  {overflow: hidden; display: inline-block;padding:0;border-radius:0;} */
  ul.dt-nav > li.top-level-link a.dt-sc-nav-link span:not(.dt-sc-caret){position:relative;display: inline-flex; /* -webkit-transition:all .4s cubic-bezier(0.68, -0.55, 0.265, 1.55); -o-transition:all .4s cubic-bezier(0.68, -0.55, 0.265, 1.55); transition:all .4s cubic-bezier(0.68, -0.55, 0.265, 1.55);*/}
/* ul.dt-nav.dt-desktop-menu > li.top-level-link a.dt-sc-nav-link span:not(.dt-sc-caret):after{content:attr( data-hover ); display:block; width:100%; height:100%; position:absolute; left:0; top:0; text-align:center;
	-webkit-transform:translateY( -100% );
	-ms-transform:translateY( -100% );
	-o-transform:translateY( -100% );
	transform:translateY( -100% );
}
 ul.dt-nav.dt-desktop-menu > li.top-level-link a.dt-sc-nav-link:hover span:not(.dt-sc-caret){
	-webkit-transform:translateY( 100% );
	-ms-transform:translateY( 100% );
	-o-transform:translateY( 100% );
	transform:translateY( 100% );
}  */

.dt-sc-nav-link.dropdown{padding:1.4rem; position:relative;}
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav{
display: inline-flex;
    flex-wrap: wrap;
    list-style:none;grid-gap:45px;
}
 .header .header-row .header__icons{gap:30px;}
 .section-header:not(.shopify-section-header-sticky) .header--middle-left .header-row{border-radius: var(--media-radius); padding:22px 0px; } 
 /* 
   .header{margin-bottom:var(--page-full-width-spacing);}
   */
@media screen and (max-width: 1199px) {
  .section-header:not(.shopify-section-header-sticky) .header--middle-left .header-row{padding:22px 0px;}
   .header .header-row .header__icons{gap:20px;}
}
@media screen and (max-width: 576px) {
  .section-header:not(.shopify-section-header-sticky) .header--middle-left .header-row{padding:22px 0px;}
  .header .header-row .header__icons{gap:10px;}
  }
</style><style data-shopify>.section-header {
    margin-bottom: 0px;
  }
  @media screen and (min-width: 750px) {
    .section-header {
      margin-bottom: 0px;
    }
  }
#dT_top-sticky.search-show {display:flex;}

    
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-2b791c78-36aa-4c3c-a4a3-410435975699-type  { 
    width: 96%;
    max-width: 96%; 
    margin:auto;
  }    
  header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-2b791c78-36aa-4c3c-a4a3-410435975699-type  { 
     box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  background-color: var(--gradient-base-background-1);
  /* font-size: var(--gradient-base-background-2); */
  border-radius:var(--media-radius);  
    
  }
 @media screen and (min-width: 1921px) {
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-2b791c78-36aa-4c3c-a4a3-410435975699-type  { max-width:var(--large_desktop); margin:auto;}
    .other-templates .header .page-full-width{ max-width: 100%; margin-bottom: 20px;}
    .other-templates .header .page-full-width .row{  background: rgba(var(--color-base-outline-button-labels)); border-radius: var(--card-corner-radius); max-width: 100%;}
    .other-templates .header .page-full-width .header-row{max-width:var(--large_desktop); margin:auto;}
    } 

 header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-2b791c78-36aa-4c3c-a4a3-410435975699-type  { margin:auto;}
.header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav .megamenu_megamenu ul.sub-menu-lists{padding:0;}
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu .sub-menu-block{    padding: 10px; min-width:15rem; border-radius: 10px; box-shadow:rgba(0, 0, 0, 0.35) 0px 2px 5px;}  
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu.mega-menu .sub-menu-block{  /*  padding: var(--grid-desktop-horizontal-spacing);*/ width:100%; padding:0;}  
  
    
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-766bf1d8-02c1-4532-8474-0802961ae3f5-type  { 
    width: 96%;
    max-width: 96%; 
    margin:auto;
  }    
  header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-766bf1d8-02c1-4532-8474-0802961ae3f5-type  { 
     box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  background-color: var(--gradient-base-background-1);
  /* font-size: var(--gradient-base-background-2); */
  border-radius:var(--media-radius);  
    
  }
 @media screen and (min-width: 1921px) {
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-766bf1d8-02c1-4532-8474-0802961ae3f5-type  { max-width:var(--large_desktop); margin:auto;}
    .other-templates .header .page-full-width{ max-width: 100%; margin-bottom: 20px;}
    .other-templates .header .page-full-width .row{  background: rgba(var(--color-base-outline-button-labels)); border-radius: var(--card-corner-radius); max-width: 100%;}
    .other-templates .header .page-full-width .header-row{max-width:var(--large_desktop); margin:auto;}
    } 

 header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-766bf1d8-02c1-4532-8474-0802961ae3f5-type  { margin:auto;}
.header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav .megamenu_megamenu ul.sub-menu-lists{padding:0;}
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu .sub-menu-block{    padding: 10px; min-width:15rem; border-radius: 10px; box-shadow:rgba(0, 0, 0, 0.35) 0px 2px 5px;}  
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu.mega-menu .sub-menu-block{  /*  padding: var(--grid-desktop-horizontal-spacing);*/ width:100%; padding:0;}  
  
    
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-b0124b59-6f4c-434a-befc-3fbf210c2762-type  { 
    width: 96%;
    max-width: 96%; 
    margin:auto;
  }    
  header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-b0124b59-6f4c-434a-befc-3fbf210c2762-type  { 
     box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  background-color: var(--gradient-base-background-1);
  /* font-size: var(--gradient-base-background-2); */
  border-radius:var(--media-radius);  
    
  }
 @media screen and (min-width: 1921px) {
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-b0124b59-6f4c-434a-befc-3fbf210c2762-type  { max-width:var(--large_desktop); margin:auto;}
    .other-templates .header .page-full-width{ max-width: 100%; margin-bottom: 20px;}
    .other-templates .header .page-full-width .row{  background: rgba(var(--color-base-outline-button-labels)); border-radius: var(--card-corner-radius); max-width: 100%;}
    .other-templates .header .page-full-width .header-row{max-width:var(--large_desktop); margin:auto;}
    } 

 header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-b0124b59-6f4c-434a-befc-3fbf210c2762-type  { margin:auto;}
.header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav .megamenu_megamenu ul.sub-menu-lists{padding:0;}
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu .sub-menu-block{    padding: 10px; min-width:15rem; border-radius: 10px; box-shadow:rgba(0, 0, 0, 0.35) 0px 2px 5px;}  
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu.mega-menu .sub-menu-block{  /*  padding: var(--grid-desktop-horizontal-spacing);*/ width:100%; padding:0;}  
  
    
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-7a4623fd-898c-4da5-b757-40ebc6b9efad-type  { 
    width: 96%;
    max-width: 96%; 
    margin:auto;
  }    
  header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-7a4623fd-898c-4da5-b757-40ebc6b9efad-type  { 
     box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
  background-color: var(--gradient-base-background-1);
  /* font-size: var(--gradient-base-background-2); */
  border-radius:var(--media-radius);  
    
  }
 @media screen and (min-width: 1921px) {
    header nav#AccessibleNav.custom_width_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-7a4623fd-898c-4da5-b757-40ebc6b9efad-type  { max-width:var(--large_desktop); margin:auto;}
    .other-templates .header .page-full-width{ max-width: 100%; margin-bottom: 20px;}
    .other-templates .header .page-full-width .row{  background: rgba(var(--color-base-outline-button-labels)); border-radius: var(--card-corner-radius); max-width: 100%;}
    .other-templates .header .page-full-width .header-row{max-width:var(--large_desktop); margin:auto;}
    } 

 header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav > li.has-mega-menu > .megamenu_megamenu > div.sub-menu-block.block-7a4623fd-898c-4da5-b757-40ebc6b9efad-type  { margin:auto;}
.header nav#AccessibleNav.default_dropdown ul.dt-desktop-menu.dt-nav .megamenu_megamenu ul.sub-menu-lists{padding:0;}
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu .sub-menu-block{    padding: 10px; min-width:15rem; border-radius: 10px; box-shadow:rgba(0, 0, 0, 0.35) 0px 2px 5px;}  
.header ul.dt-sc-list-inline.dt-desktop-menu.dt-nav .megamenu_megamenu.mega-menu .sub-menu-block{  /*  padding: var(--grid-desktop-horizontal-spacing);*/ width:100%; padding:0;}  
  
  .cart-count-bubble.count-zero {
    opacity: 0;
        visibility: hidden;
  }


 /* ul.dt-nav>li a.dt-sc-nav-link.dropdown span .char {
  line-height: 1;
  transform-origin: center bottom;
  -webkit-animation-timing-function: cubic-bezier(0.77, 0.02, 0.11, 0.97);
          animation-timing-function: cubic-bezier(0.77, 0.02, 0.11, 0.97);
  -webkit-animation-iteration-count: 1;
          animation-iteration-count: 1;
  -webkit-animation-fill-mode: both;
          animation-fill-mode: both;
  -webkit-animation-delay: calc(0.05s * var(--char-index) );
          animation-delay: calc(0.05s * var(--char-index) );
  -webkit-animation-duration: calc( 0.3s + ( 0.03s * var(--char-total)) );
          animation-duration: calc( 0.3s + ( 0.03s * var(--char-total)) );
}
   ul.dt-nav>li:hover a.dt-sc-nav-link.dropdown span .char {
   -webkit-animation-name: bounce-char;
          animation-name: bounce-char;
}
  @-webkit-keyframes bounce-end {
  to {
    transform: translateY(0%) scale(1);
  }
}

@keyframes bounce-end {
  to {
    transform: translateY(0%) scale(1);
  }
}
@-webkit-keyframes bounce-char {
  20% {
    transform: translateY(0%) scale(1.3, 0.8);
  }
  70% {
    transform: translateY(-15%) scale(0.8, 1.2);
  }
}
@keyframes bounce-char {
  20% {
    transform: translateY(0%) scale(1.3, 0.8);
  }
  70% {
    transform: translateY(-15%) scale(0.8, 1.2);
  }
} */

ul.dt-nav>li>.megamenu_megamenu a.dt-sc-nav-link{overflow:hidden;line-height:18px;}
ul.dt-nav>li>.megamenu_megamenu a.dt-sc-nav-link span:not(.dt-sc-caret){
    position: relative;
    display: inline-flex;
    /* -webkit-transition: all .4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
    transition: all .4s cubic-bezier(0.68, -0.55, 0.265, 1.55); */
}
/* ul.dt-nav>li>.megamenu_megamenu a.dt-sc-nav-link span:not(.dt-sc-caret):after{
  content: attr( data-hover );
    display: block;
    width: 100%;
    height: 100%;
    position: absolute;
    left: 0;
    top: 0;
    text-align: center;
    -webkit-transform: translateY( -100% );
    transform: translateY( -100% );
}
ul.dt-nav>li>.megamenu_megamenu a.dt-sc-nav-link:hover span:not(.dt-sc-caret) {
    -webkit-transform: translateY( 100% );
    transform: translateY( 100% );
}
 */</style> <details-overlay-modal class="header__search " id="dT_top-sticky">
          <div class="search-modal modal__content gradient" role="dialog" aria-modal="true" aria-label="Search">
            <div class="modal-overlay"></div>
            
            <div class="search-modal__content search-modal__content-bottom" tabindex="-1">
             <button type="button" class="dT_TopStickySearchCloseBtn search-modal__close-button modal__close-button link link--text focus-inset" aria-label="Close">
                 <svg id="Group_24924" data-name="Group 24924" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 25 25">
            <defs>
            <clipPath id="clip-path">
            <rect id="Rectangle_8252" data-name="Rectangle 8252" width="18" height="18" fill="currentcolor"/>
            </clipPath>
            </defs>
            <g id="Group_24923" data-name="Group 24923" >
            <path id="Path_38934" data-name="Path 38934" d="M23.214,25a1.78,1.78,0,0,1-1.263-.523L.523,3.048A1.786,1.786,0,0,1,3.048.523L24.477,21.952A1.786,1.786,0,0,1,23.214,25" transform="translate(0)"  fill="currentcolor"/>
            <path id="Path_38935" data-name="Path 38935" d="M1.786,25A1.786,1.786,0,0,1,.523,21.952L21.952.523a1.786,1.786,0,1,1,2.525,2.525L3.048,24.477A1.78,1.78,0,0,1,1.786,25" transform="translate(0 0)"  fill="currentcolor"/>
            </g>
            </svg>
              </button><predictive-search class="search-modal__form" data-loading-text="Loading..."><form action="/search" method="get" role="search" class="search search-modal__form">
               <h2 class="predictive-heading">🐻 What are you looking for ?</h2>  
              <div class="field">
                <input class="search__input field__input"
                  id=""
                  type="search"
                  name="q"
                  value=""
                  placeholder="Search"role="combobox"
                    aria-expanded="false"
                    aria-owns="predictive-search-results"
                    aria-controls="predictive-search-results"
                    aria-haspopup="listbox"
                    aria-autocomplete="list"
                    autocorrect="off"
                    autocomplete="off"
                    autocapitalize="off"
                    spellcheck="false">
                <label class="field__label" for="">Search</label>
                <input type="hidden" name="options[prefix]" value="last">
                <button type="reset" class="reset__button field__button hidden" aria-label="Translation missing: en.general.search.reset">
                  <svg class="icon icon-close" aria-hidden="true" focusable="false">
                    <use xlink:href="#icon-reset">
                  </svg>
                </button>
                <button class="search__button field__button" aria-label="Search">
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="22" viewBox="0 0 24 22" fill="none">
                    <path d="M8 11C8 8.23809 10.2381 6 13 6" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M10.9445 20.1649C16.1712 19.7076 20.5246 15.0852 20.668 9.84049C20.8114 4.59575 16.6906 0.71474 11.4638 1.17202C6.23711 1.6293 1.88373 6.25171 1.74031 11.4965C1.59689 16.7412 5.71773 20.6222 10.9445 20.1649Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M20.0039 18L23.0039 21" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg> -->
                  <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M5.92188 10.0183C5.92188 7.85883 7.67181 6.10889 9.83132 6.10889" stroke="currentcolor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M10.7553 18.0273C15.326 17.6274 18.7071 13.598 18.3072 9.02731C17.9073 4.45663 13.8779 1.07553 9.3072 1.47541C4.73652 1.87529 1.35542 5.90473 1.7553 10.4754C2.15518 15.0461 6.18462 18.4272 10.7553 18.0273Z" stroke="currentcolor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M15.6953 15.8826L17.65 17.8373" stroke="currentcolor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"></path>
                  </svg>
                </button>
              </div>
                <div class="search-collection-tags-with-middle-left line-70">
         
        
        <ul class="search-tags">
          <li>Popular searches:</li>
          
          <li class="tag-item">
            <a  href="/search?q=featured&product=product" title="featured">              
              <span>featured</span>
            </a>
          </li> 
          
          <li class="tag-item">
            <a  href="/search?q=trendy&product=product" title=" trendy">              
              <span> trendy</span>
            </a>
          </li> 
          
          <li class="tag-item">
            <a  href="/search?q=sale&product=product" title=" sale">              
              <span> sale</span>
            </a>
          </li> 
          
          <li class="tag-item">
            <a  href="/search?q=new&product=product" title=" new">              
              <span> new</span>
            </a>
          </li> 
          
        </ul>
        
        
</div>

   <div class="predictive-search predictive-search--header" tabindex="-1" data-predictive-search>
                  <div class="predictive-search__loading-state">
                    <svg aria-hidden="true" focusable="false" class="spinner" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
                      <circle class="path" fill="none" stroke-width="6" cx="33" cy="33" r="30"></circle>
                    </svg>
                  </div>
                </div>

                <span class="predictive-search-status visually-hidden" role="status" aria-hidden="true"></span>
 



   <featured-swiper-slider class="">
     <div data-slider-options='{"loop": "2","desktop": "6", "laptop": "4", "tablet": "3","mobile": "2","auto_play": "2"}'>
     <h3 class="recently_purchased">Recommended products</h3>
      <div class="swiper" data-swiper-slider>
      <div id="Slider-header" class="product-grid contains-card  swiper-wrapper" role="list" aria-label="Slider">
        
        <div id="Slide-header-1" class=" swiper-slide card_style-card_with_icons">
           
             
<div class="card-wrapper underline-links-hover ">
    <div class="card
      card--card
       card--media
      color-background-1 gradient
      
      "
      style="--ratio-percent: 125.0%;"
    >
      <div class="card__inner  ratio" style="--ratio-percent: 125.0%;"><div class="card__media">
            <a href="/products/monkey-doll">
            <div class="media media--transparent media--hover-effect">
              
         
              <img
                 srcset="//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666 960w
                "
                src="//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=533"
                sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                alt="Monkey Doll"
                class="motion-reduce  loading-image"                
                loading="lazy"
                width="960"
                height="960"
              >
              
<img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/files/shop-11_b03a8176-eef3-4860-8de4-6c082fa84d26.jpg?v=1709889667&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/files/shop-11_b03a8176-eef3-4860-8de4-6c082fa84d26.jpg?v=1709889667&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/files/shop-11_b03a8176-eef3-4860-8de4-6c082fa84d26.jpg?v=1709889667&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/files/shop-11_b03a8176-eef3-4860-8de4-6c082fa84d26.jpg?v=1709889667&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/files/shop-11_b03a8176-eef3-4860-8de4-6c082fa84d26.jpg?v=1709889667&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/files/shop-11_b03a8176-eef3-4860-8de4-6c082fa84d26.jpg?v=1709889667 960w
                  "
                  src="//toytime-theme.myshopify.com/cdn/shop/files/shop-11_b03a8176-eef3-4860-8de4-6c082fa84d26.jpg?v=1709889667&width=533"
                  sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                  alt="Monkey Doll"
                  class="motion-reduce  loading-image secondary-image"
                  loading="lazy"
                  width="960"
                  height="960"
                ></div>
           </a>

          </div><div class="card__content">
          <div class="card__information">
            <h3 class="card__heading">
              <a href="/products/monkey-doll" class="full-unstyled-link">
                Monkey Doll
              </a>
            </h3>
          </div>
          <div class="card__badge top-left">
            <!--<span class="badge badge--bottom-left color-inverse">Sold out</span>--><span class="badge badge--bottom-left color-inverse">Sold out</span></div>
       <ul class="product-icons right-aligned"><li><dtx-wishlist><a href="javascript:void(0);" class="add-wishlist" data-product_handle="monkey-doll"> </a></dtx-wishlist>
            <tooltip class="tooltip">wishlist</tooltip>
          </li><li class="mobile-hide"><dtx-compare><a href="javascript:void(0);" class="add-compare" data-product_handle="monkey-doll"></a></dtx-compare>
          <tooltip class="tooltip">compare</tooltip>
          </li><li>
            <product-form><form method="post" action="/cart/add" id="quick-add-header8598657368296" accept-charset="UTF-8" class="form shopify-product-form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" class="variant-push" value="45563167867112" disabled>
                  <button
                    id="quick-add-header8598657368296-submit"
                    type="submit"
                    name="add"
                    class="quick-add__submit  button--full-width button--secondary"
                    aria-haspopup="dialog"
                    aria-labelledby="quick-add-header8598657368296-submit title-header-8598657368296"
                    aria-live="polite"
                    data-sold-out-message="true"
                    disabled
                  >
<!-- <svg  width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
<path d="M3.3,17.5c-0.4,0-0.8-0.2-1.1-0.5c-0.3-0.3-0.5-0.7-0.5-1.1V6.2c0-0.4,0.2-0.8,0.5-1.1c0.3-0.3,0.7-0.5,1.1-0.5H5
	c0-1.1,0.4-2.1,1.2-2.9S7.9,0.5,9,0.5s2.1,0.4,2.9,1.2S13,3.4,13,4.5h1.6c0.4,0,0.8,0.2,1.1,0.5s0.5,0.7,0.5,1.1v9.7
	c0,0.4-0.2,0.8-0.5,1.1c-0.3,0.3-0.7,0.5-1.1,0.5H3.3z M3.3,15.9h11.3V6.2H3.3V15.9z M9,11c1.1,0,2.1-0.4,2.9-1.2S13,8.1,13,7h-1.6
	c0,0.7-0.2,1.2-0.7,1.7c-0.5,0.5-1,0.7-1.7,0.7c-0.7,0-1.2-0.2-1.7-0.7C6.8,8.2,6.6,7.7,6.6,7H5c0,1.1,0.4,2.1,1.2,2.9S7.9,11,9,11z
	 M6.6,4.5h4.9c0-0.7-0.2-1.2-0.7-1.7c-0.5-0.5-1-0.7-1.7-0.7c-0.7,0-1.2,0.2-1.7,0.7S6.6,3.9,6.6,4.5z M3.3,15.9V6.2V15.9z" fill="currentcolor" />
</svg> -->

<svg width="17" height="17" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.3166 19.7513H3.40213C2.21719 19.7513 1.27974 18.7663 1.36473 17.6088L2.28218 6.66884C2.32468 6.15134 2.75966 5.75134 3.27963 5.75134H13.4391C13.9591 5.75134 14.3916 6.14884 14.4366 6.66884L15.354 17.6088C15.439 18.7663 14.5016 19.7513 13.3166 19.7513Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.35938 8.75134V3.75134C5.35938 2.64634 6.25437 1.75134 7.35938 1.75134H9.35938C10.4644 1.75134 11.3594 2.64634 11.3594 3.75134V8.75134" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<span class="sold-out-message hidden">
                      Sold out
                    </span>
                    <div class="loading-overlay__spinner hidden">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background:transparent; display: block; shape-rendering: auto; animation-play-state: running; animation-delay: 0s;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="currentColor" stroke-width="6" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" style="animation-play-state: running; animation-delay: 0s;">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.819672131147541s" values="0 50 50;360 50 50" keyTimes="0;1" style="animation-play-state: running; animation-delay: 0s;"></animateTransform>
                    </circle>
                  </svg>
                    </div>
                  </button><input type="hidden" name="product-id" value="8598657368296" /><input type="hidden" name="section-id" value="header" /></form></product-form>  
              <tooltip class="tooltip">Add to cart</tooltip>
           </li></ul>          
        </div>
           
      </div>
      <div class="card__content for-arrow-alignment content-center  ">
        <div class="card__information">
          <div class="card-information new--tag">      
          </div><div class="card-information review">
              <div class="rating" role="img" aria-label=" out of  stars">
                <span aria-hidden="true" class="rating-star color-icon-accent-1" style="--rating: 0; --rating-max: ; --rating-decimal: 0;"></span>
              </div>
              <p class="rating-text caption">
                <span aria-hidden="true"> / </span>
              </p>
              <p class="rating-count caption">
                <span aria-hidden="true">()</span>
                <span class="visually-hidden"> total reviews</span>
              </p></div>
          <!-- <div class="heading-swatch"> -->
          <h3 class="card__heading h5" id="title-header-8598657368296">
            <a href="/products/monkey-doll" class="full-unstyled-link">
              Monkey Doll <span class="choosen-swatch"></span>
            </a>
          </h3>
        
          <!-- </div> -->
        
<div class="price  price--sold-out  product-price-current" data-price="Rs. 200.00">
  <div class="price__container">    
    <div class="price__regular">
      <span class="visually-hidden visually-hidden--inline">Regular price</span>
      <span class="price-item price-item--regular">
       Rs. 200.00
      </span>
    </div>
    <div class="price__sale">      
      <span class="visually-hidden visually-hidden--inline">Sale price</span>
      <span class="price-item price-item--sale price-item--last">
       Rs. 200.00
      </span>
        <span class="visually-hidden visually-hidden--inline">Regular price</span>
        <span>
          <s class="price-item price-item--regular">
            
              Rs. 12.77
            
          </s>
        </span>
    </div>
    <small class="unit-price caption hidden">
      <span class="visually-hidden">Unit price</span>
      <span class="price-item price-item--last">
        <span></span>
        <span aria-hidden="true">/</span>
        <span class="visually-hidden">&nbsp;per&nbsp;</span>
        <span>
        </span>
      </span>
    </small>
  </div></div>
      
         <span class="caption-large light"></span>
      
            

    



<ul class="variant-option-color">
   
      
  <li class="color-values">       
    <a data-href="/products/monkey-doll?variant=45563167867112" class="swatch swatch-element  active color bg-color-white" data-swatch-meta="name-color_white">
      <tooltip class="tooltip">White</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=460"
         style="background-size: cover;background-color:white;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/white_50x50.png); background-repeat: no-repeat;"data-id="45563167867112"
        data-variant-title-id="color" data-variant-item="white"  data-variant-title="White / 100 g / Rubber"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/monkey-doll?variant=45563167899880" class="swatch swatch-element  color bg-color-brown" data-swatch-meta="name-color_brown">
      <tooltip class="tooltip">Brown</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/files/shop-10_859b7ccc-e885-4235-87f2-728a196a386f.jpg?v=1709889666&width=460"
         style="background-size: cover;background-color:brown;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/brown_50x50.png); background-repeat: no-repeat;"data-id="45563167899880"
        data-variant-title-id="color" data-variant-item="brown"  data-variant-title="Brown / 150 g / Polyester"></span>
    </a>          
    
  </li>
  

  
  

    
      
    
  
  
    
      
  
    
      
  
  

</ul>


    


    




        </div>
        <div class="card__badge top-left"><span class="badge badge--bottom-left color-inverse">Sold out</span></div>        
         
          
         
  
      </div>     
    </div>      
  </div>
        
          </div><div id="Slide-header-2" class=" swiper-slide card_style-card_with_icons">
           
             
<div class="card-wrapper underline-links-hover ">
    <div class="card
      card--card
       card--media
      color-background-1 gradient
      
      "
      style="--ratio-percent: 125.0%;"
    >
      <div class="card__inner  ratio" style="--ratio-percent: 125.0%;"><div class="card__media">
            <a href="/products/lovely-dog-stuffed">
            <div class="media media--transparent media--hover-effect">
              
         
              <img
                 srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791 960w
                "
                src="//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791&width=533"
                sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                alt="Lovely Dog Stuffed"
                class="motion-reduce  loading-image"                
                loading="lazy"
                width="960"
                height="960"
              >
              
<img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791 960w
                  "
                  src="//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791&width=533"
                  sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                  alt="Lovely Dog Stuffed"
                  class="motion-reduce  loading-image secondary-image"
                  loading="lazy"
                  width="960"
                  height="960"
                ></div>
           </a>

          </div><div class="card__content">
          <div class="card__information">
            <h3 class="card__heading">
              <a href="/products/lovely-dog-stuffed" class="full-unstyled-link">
                Lovely Dog Stuffed
              </a>
            </h3>
          </div>
          <div class="card__badge top-left">
            <!----></div>
       <ul class="product-icons right-aligned"><li><dtx-wishlist><a href="javascript:void(0);" class="add-wishlist" data-product_handle="lovely-dog-stuffed"> </a></dtx-wishlist>
            <tooltip class="tooltip">wishlist</tooltip>
          </li><li class="mobile-hide"><dtx-compare><a href="javascript:void(0);" class="add-compare" data-product_handle="lovely-dog-stuffed"></a></dtx-compare>
          <tooltip class="tooltip">compare</tooltip>
          </li><li>
            <product-form><form method="post" action="/cart/add" id="quick-add-header8547307618536" accept-charset="UTF-8" class="form shopify-product-form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" class="variant-push" value="45411339698408" disabled>
                  <button
                    id="quick-add-header8547307618536-submit"
                    type="submit"
                    name="add"
                    class="quick-add__submit  button--full-width button--secondary"
                    aria-haspopup="dialog"
                    aria-labelledby="quick-add-header8547307618536-submit title-header-8547307618536"
                    aria-live="polite"
                    data-sold-out-message="true"
                    
                  >
<!-- <svg  width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
<path d="M3.3,17.5c-0.4,0-0.8-0.2-1.1-0.5c-0.3-0.3-0.5-0.7-0.5-1.1V6.2c0-0.4,0.2-0.8,0.5-1.1c0.3-0.3,0.7-0.5,1.1-0.5H5
	c0-1.1,0.4-2.1,1.2-2.9S7.9,0.5,9,0.5s2.1,0.4,2.9,1.2S13,3.4,13,4.5h1.6c0.4,0,0.8,0.2,1.1,0.5s0.5,0.7,0.5,1.1v9.7
	c0,0.4-0.2,0.8-0.5,1.1c-0.3,0.3-0.7,0.5-1.1,0.5H3.3z M3.3,15.9h11.3V6.2H3.3V15.9z M9,11c1.1,0,2.1-0.4,2.9-1.2S13,8.1,13,7h-1.6
	c0,0.7-0.2,1.2-0.7,1.7c-0.5,0.5-1,0.7-1.7,0.7c-0.7,0-1.2-0.2-1.7-0.7C6.8,8.2,6.6,7.7,6.6,7H5c0,1.1,0.4,2.1,1.2,2.9S7.9,11,9,11z
	 M6.6,4.5h4.9c0-0.7-0.2-1.2-0.7-1.7c-0.5-0.5-1-0.7-1.7-0.7c-0.7,0-1.2,0.2-1.7,0.7S6.6,3.9,6.6,4.5z M3.3,15.9V6.2V15.9z" fill="currentcolor" />
</svg> -->

<svg width="17" height="17" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.3166 19.7513H3.40213C2.21719 19.7513 1.27974 18.7663 1.36473 17.6088L2.28218 6.66884C2.32468 6.15134 2.75966 5.75134 3.27963 5.75134H13.4391C13.9591 5.75134 14.3916 6.14884 14.4366 6.66884L15.354 17.6088C15.439 18.7663 14.5016 19.7513 13.3166 19.7513Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.35938 8.75134V3.75134C5.35938 2.64634 6.25437 1.75134 7.35938 1.75134H9.35938C10.4644 1.75134 11.3594 2.64634 11.3594 3.75134V8.75134" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<span class="sold-out-message hidden">
                      Sold out
                    </span>
                    <div class="loading-overlay__spinner hidden">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background:transparent; display: block; shape-rendering: auto; animation-play-state: running; animation-delay: 0s;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="currentColor" stroke-width="6" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" style="animation-play-state: running; animation-delay: 0s;">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.819672131147541s" values="0 50 50;360 50 50" keyTimes="0;1" style="animation-play-state: running; animation-delay: 0s;"></animateTransform>
                    </circle>
                  </svg>
                    </div>
                  </button><input type="hidden" name="product-id" value="8547307618536" /><input type="hidden" name="section-id" value="header" /></form></product-form>  
              <tooltip class="tooltip">Add to cart</tooltip>
           </li></ul>          
        </div>
           
      </div>
      <div class="card__content for-arrow-alignment content-center  ">
        <div class="card__information">
          <div class="card-information new--tag">      
          </div><div class="card-information review">
              <div class="rating" role="img" aria-label="5.0 out of 5.0 stars">
                <span aria-hidden="true" class="rating-star color-icon-accent-1" style="--rating: 5; --rating-max: 5.0; --rating-decimal: 0;"></span>
              </div>
              <p class="rating-text caption">
                <span aria-hidden="true">5.0 / 5.0</span>
              </p>
              <p class="rating-count caption">
                <span aria-hidden="true">(1)</span>
                <span class="visually-hidden">1 total reviews</span>
              </p></div>
          <!-- <div class="heading-swatch"> -->
          <h3 class="card__heading h5" id="title-header-8547307618536">
            <a href="/products/lovely-dog-stuffed" class="full-unstyled-link">
              Lovely Dog Stuffed <span class="choosen-swatch"></span>
            </a>
          </h3>
        
          <!-- </div> -->
        
<div class="price  product-price-current" data-price="Rs. 620.00">
  <div class="price__container">    
    <div class="price__regular">
      <span class="visually-hidden visually-hidden--inline">Regular price</span>
      <span class="price-item price-item--regular">
       Rs. 620.00
      </span>
    </div>
    <div class="price__sale">      
      <span class="visually-hidden visually-hidden--inline">Sale price</span>
      <span class="price-item price-item--sale price-item--last">
       Rs. 620.00
      </span>
        <span class="visually-hidden visually-hidden--inline">Regular price</span>
        <span>
          <s class="price-item price-item--regular">
            
              Rs. 11.50
            
          </s>
        </span>
    </div>
    <small class="unit-price caption hidden">
      <span class="visually-hidden">Unit price</span>
      <span class="price-item price-item--last">
        <span></span>
        <span aria-hidden="true">/</span>
        <span class="visually-hidden">&nbsp;per&nbsp;</span>
        <span>
        </span>
      </span>
    </small>
  </div></div>
      
         <span class="caption-large light"></span>
      
            

    



<ul class="variant-option-color">
   
      
  <li class="color-values">       
    <a data-href="/products/lovely-dog-stuffed?variant=45411339698408" class="swatch swatch-element  active color bg-color-brown" data-swatch-meta="name-color_brown">
      <tooltip class="tooltip">Brown</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-13_bf1d2c00-1eb6-4139-8592-88a5ca507440.jpg?v=1706620791&width=460"
         style="background-size: cover;background-color:brown;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/brown_50x50.png); background-repeat: no-repeat;"data-id="45411339698408"
        data-variant-title-id="color" data-variant-item="brown"  data-variant-title="Brown / 80 g / Cotton"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/lovely-dog-stuffed?variant=45411339731176" class="swatch swatch-element  color bg-color-white" data-swatch-meta="name-color_white">
      <tooltip class="tooltip">White</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-18.jpg?v=1706620791&width=460"
         style="background-size: cover;background-color:white;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/white_50x50.png); background-repeat: no-repeat;"data-id="45411339731176"
        data-variant-title-id="color" data-variant-item="white"  data-variant-title="White / 90 g / Fur"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/lovely-dog-stuffed?variant=45411339763944" class="swatch swatch-element  color bg-color-red" data-swatch-meta="name-color_red">
      <tooltip class="tooltip">Red</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/Image10_48e728dd-e58a-4700-bec4-f5ab7bc2b8e1.jpg?v=1706620791&width=460"
         style="background-size: cover;background-color:red;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/red_50x50.png); background-repeat: no-repeat;"data-id="45411339763944"
        data-variant-title-id="color" data-variant-item="red"  data-variant-title="Red / 250 g / Polyester"></span>
    </a>          
    
  </li>
  

  
   
    
  <li class="color-values show-on-click" style="display:none">
    <a data-href="/products/lovely-dog-stuffed?variant=45411339796712" class="swatch  color bg-color-pink" data-swatch-meta="name-color_pink">
     <tooltip class="tooltip">Pink</tooltip>
         <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-16_4019784d-7765-4d99-b7fa-99562c89e837.jpg?v=1706620791&width=460"
         style="background-size: cover;background-color:pink;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/pink_50x50.png); background-repeat: no-repeat;"data-ids="45411339796712"
            data-variant-title-id="color" data-variant-item="pink"  data-variant-title="Pink / 100 g / Mohair"></span>
    </a>  
  </li>
  
  

  
  

    
      
    
  
  
    
      
  
    
      
  
  

</ul>


    


    




        </div>
        <div class="card__badge top-left"></div>        
         
          
         
  
      </div>     
    </div>      
  </div>
        
          </div><div id="Slide-header-3" class=" swiper-slide card_style-card_with_icons">
           
             
<div class="card-wrapper underline-links-hover ">
    <div class="card
      card--card
       card--media
      color-background-1 gradient
      
      "
      style="--ratio-percent: 125.0%;"
    >
      <div class="card__inner  ratio" style="--ratio-percent: 125.0%;"><div class="card__media">
            <a href="/products/giraffe-toy">
            <div class="media media--transparent media--hover-effect">
              
         
              <img
                 srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832 960w
                "
                src="//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832&width=533"
                sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                alt="Giraffe Toy"
                class="motion-reduce  loading-image"                
                loading="lazy"
                width="960"
                height="960"
              >
              
<img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832 960w
                  "
                  src="//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832&width=533"
                  sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                  alt="Giraffe Toy"
                  class="motion-reduce  loading-image secondary-image"
                  loading="lazy"
                  width="960"
                  height="960"
                ></div>
           </a>

          </div><div class="card__content">
          <div class="card__information">
            <h3 class="card__heading">
              <a href="/products/giraffe-toy" class="full-unstyled-link">
                Giraffe Toy
              </a>
            </h3>
          </div>
          <div class="card__badge top-left">
            <!----></div>
       <ul class="product-icons right-aligned"><li><dtx-wishlist><a href="javascript:void(0);" class="add-wishlist" data-product_handle="giraffe-toy"> </a></dtx-wishlist>
            <tooltip class="tooltip">wishlist</tooltip>
          </li><li class="mobile-hide"><dtx-compare><a href="javascript:void(0);" class="add-compare" data-product_handle="giraffe-toy"></a></dtx-compare>
          <tooltip class="tooltip">compare</tooltip>
          </li><li>
            <product-form><form method="post" action="/cart/add" id="quick-add-header8547307847912" accept-charset="UTF-8" class="form shopify-product-form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" class="variant-push" value="45411340550376" disabled>
                  <button
                    id="quick-add-header8547307847912-submit"
                    type="submit"
                    name="add"
                    class="quick-add__submit  button--full-width button--secondary"
                    aria-haspopup="dialog"
                    aria-labelledby="quick-add-header8547307847912-submit title-header-8547307847912"
                    aria-live="polite"
                    data-sold-out-message="true"
                    
                  >
<!-- <svg  width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
<path d="M3.3,17.5c-0.4,0-0.8-0.2-1.1-0.5c-0.3-0.3-0.5-0.7-0.5-1.1V6.2c0-0.4,0.2-0.8,0.5-1.1c0.3-0.3,0.7-0.5,1.1-0.5H5
	c0-1.1,0.4-2.1,1.2-2.9S7.9,0.5,9,0.5s2.1,0.4,2.9,1.2S13,3.4,13,4.5h1.6c0.4,0,0.8,0.2,1.1,0.5s0.5,0.7,0.5,1.1v9.7
	c0,0.4-0.2,0.8-0.5,1.1c-0.3,0.3-0.7,0.5-1.1,0.5H3.3z M3.3,15.9h11.3V6.2H3.3V15.9z M9,11c1.1,0,2.1-0.4,2.9-1.2S13,8.1,13,7h-1.6
	c0,0.7-0.2,1.2-0.7,1.7c-0.5,0.5-1,0.7-1.7,0.7c-0.7,0-1.2-0.2-1.7-0.7C6.8,8.2,6.6,7.7,6.6,7H5c0,1.1,0.4,2.1,1.2,2.9S7.9,11,9,11z
	 M6.6,4.5h4.9c0-0.7-0.2-1.2-0.7-1.7c-0.5-0.5-1-0.7-1.7-0.7c-0.7,0-1.2,0.2-1.7,0.7S6.6,3.9,6.6,4.5z M3.3,15.9V6.2V15.9z" fill="currentcolor" />
</svg> -->

<svg width="17" height="17" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.3166 19.7513H3.40213C2.21719 19.7513 1.27974 18.7663 1.36473 17.6088L2.28218 6.66884C2.32468 6.15134 2.75966 5.75134 3.27963 5.75134H13.4391C13.9591 5.75134 14.3916 6.14884 14.4366 6.66884L15.354 17.6088C15.439 18.7663 14.5016 19.7513 13.3166 19.7513Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.35938 8.75134V3.75134C5.35938 2.64634 6.25437 1.75134 7.35938 1.75134H9.35938C10.4644 1.75134 11.3594 2.64634 11.3594 3.75134V8.75134" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<span class="sold-out-message hidden">
                      Sold out
                    </span>
                    <div class="loading-overlay__spinner hidden">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background:transparent; display: block; shape-rendering: auto; animation-play-state: running; animation-delay: 0s;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="currentColor" stroke-width="6" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" style="animation-play-state: running; animation-delay: 0s;">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.819672131147541s" values="0 50 50;360 50 50" keyTimes="0;1" style="animation-play-state: running; animation-delay: 0s;"></animateTransform>
                    </circle>
                  </svg>
                    </div>
                  </button><input type="hidden" name="product-id" value="8547307847912" /><input type="hidden" name="section-id" value="header" /></form></product-form>  
              <tooltip class="tooltip">Add to cart</tooltip>
           </li></ul>          
        </div>
           
      </div>
      <div class="card__content for-arrow-alignment content-center  ">
        <div class="card__information">
          <div class="card-information new--tag">      
          </div><div class="card-information review">
              <div class="rating" role="img" aria-label="4.0 out of 5.0 stars">
                <span aria-hidden="true" class="rating-star color-icon-accent-1" style="--rating: 4; --rating-max: 5.0; --rating-decimal: 0;"></span>
              </div>
              <p class="rating-text caption">
                <span aria-hidden="true">4.0 / 5.0</span>
              </p>
              <p class="rating-count caption">
                <span aria-hidden="true">(1)</span>
                <span class="visually-hidden">1 total reviews</span>
              </p></div>
          <!-- <div class="heading-swatch"> -->
          <h3 class="card__heading h5" id="title-header-8547307847912">
            <a href="/products/giraffe-toy" class="full-unstyled-link">
              Giraffe Toy <span class="choosen-swatch"></span>
            </a>
          </h3>
        
          <!-- </div> -->
        
<div class="price  product-price-current" data-price="Rs. 657.00">
  <div class="price__container">    
    <div class="price__regular">
      <span class="visually-hidden visually-hidden--inline">Regular price</span>
      <span class="price-item price-item--regular">
       Rs. 657.00
      </span>
    </div>
    <div class="price__sale">      
      <span class="visually-hidden visually-hidden--inline">Sale price</span>
      <span class="price-item price-item--sale price-item--last">
       Rs. 657.00
      </span>
        <span class="visually-hidden visually-hidden--inline">Regular price</span>
        <span>
          <s class="price-item price-item--regular">
            
              Rs. 10.34
            
          </s>
        </span>
    </div>
    <small class="unit-price caption hidden">
      <span class="visually-hidden">Unit price</span>
      <span class="price-item price-item--last">
        <span></span>
        <span aria-hidden="true">/</span>
        <span class="visually-hidden">&nbsp;per&nbsp;</span>
        <span>
        </span>
      </span>
    </small>
  </div></div>
      
         <span class="caption-large light"></span>
      
            

    



<ul class="variant-option-color">
   
      
  <li class="color-values">       
    <a data-href="/products/giraffe-toy?variant=45411340550376" class="swatch swatch-element  active color bg-color-yellow" data-swatch-meta="name-color_yellow">
      <tooltip class="tooltip">Yellow</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-8_cb1db957-8b3d-461c-95ea-07fd4bf55c19.jpg?v=1706620832&width=460"
         style="background-size: cover;background-color:yellow;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/yellow_50x50.png); background-repeat: no-repeat;"data-id="45411340550376"
        data-variant-title-id="color" data-variant-item="yellow"  data-variant-title="Yellow / 80 g / Cotton"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/giraffe-toy?variant=45411340583144" class="swatch swatch-element  color bg-color-pink" data-swatch-meta="name-color_pink">
      <tooltip class="tooltip">Pink</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-16_dcdd2022-5313-4267-8754-735f576eedb4.jpg?v=1706620832&width=460"
         style="background-size: cover;background-color:pink;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/pink_50x50.png); background-repeat: no-repeat;"data-id="45411340583144"
        data-variant-title-id="color" data-variant-item="pink"  data-variant-title="Pink / 90 g / ‎Polyester"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/giraffe-toy?variant=45411340615912" class="swatch swatch-element  color bg-color-red" data-swatch-meta="name-color_red">
      <tooltip class="tooltip">Red</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/Image8.jpg?v=1706620832&width=460"
         style="background-size: cover;background-color:red;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/red_50x50.png); background-repeat: no-repeat;"data-id="45411340615912"
        data-variant-title-id="color" data-variant-item="red"  data-variant-title="Red / 100 g / Shweshwe"></span>
    </a>          
    
  </li>
  

  
   
    
  <li class="color-values show-on-click" style="display:none">
    <a data-href="/products/giraffe-toy?variant=45411340648680" class="swatch  color bg-color-brown" data-swatch-meta="name-color_brown">
     <tooltip class="tooltip">Brown</tooltip>
         <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-18_6b504bcd-ed75-4de2-b713-f66a471868ce.jpg?v=1706620832&width=460"
         style="background-size: cover;background-color:brown;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/brown_50x50.png); background-repeat: no-repeat;"data-ids="45411340648680"
            data-variant-title-id="color" data-variant-item="brown"  data-variant-title="Brown / 250 g / Hollow Fibre"></span>
    </a>  
  </li>
  
  

  
  

    
      
    
  
  
    
      
  
    
      
  
  

</ul>


    


    




        </div>
        <div class="card__badge top-left"></div>        
         
          
         
  
      </div>     
    </div>      
  </div>
        
          </div><div id="Slide-header-4" class=" swiper-slide card_style-card_with_icons">
           
             
<div class="card-wrapper underline-links-hover ">
    <div class="card
      card--card
       card--media
      color-background-1 gradient
      
      "
      style="--ratio-percent: 125.0%;"
    >
      <div class="card__inner  ratio" style="--ratio-percent: 125.0%;"><div class="card__media">
            <a href="/products/cuddly-monkey">
            <div class="media media--transparent media--hover-effect">
              
         
              <img
                 srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815 960w
                "
                src="//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815&width=533"
                sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                alt="Cuddly Monkey"
                class="motion-reduce  loading-image"                
                loading="lazy"
                width="960"
                height="960"
              >
              
<img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815 960w
                  "
                  src="//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815&width=533"
                  sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                  alt="Cuddly Monkey"
                  class="motion-reduce  loading-image secondary-image"
                  loading="lazy"
                  width="960"
                  height="960"
                ></div>
           </a>

          </div><div class="card__content">
          <div class="card__information">
            <h3 class="card__heading">
              <a href="/products/cuddly-monkey" class="full-unstyled-link">
                Cuddly Monkey
              </a>
            </h3>
          </div>
          <div class="card__badge top-left">
            <!----></div>
       <ul class="product-icons right-aligned"><li><dtx-wishlist><a href="javascript:void(0);" class="add-wishlist" data-product_handle="cuddly-monkey"> </a></dtx-wishlist>
            <tooltip class="tooltip">wishlist</tooltip>
          </li><li class="mobile-hide"><dtx-compare><a href="javascript:void(0);" class="add-compare" data-product_handle="cuddly-monkey"></a></dtx-compare>
          <tooltip class="tooltip">compare</tooltip>
          </li><li>
            <product-form><form method="post" action="/cart/add" id="quick-add-header8547307782376" accept-charset="UTF-8" class="form shopify-product-form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" class="variant-push" value="45411340222696" disabled>
                  <button
                    id="quick-add-header8547307782376-submit"
                    type="submit"
                    name="add"
                    class="quick-add__submit  button--full-width button--secondary"
                    aria-haspopup="dialog"
                    aria-labelledby="quick-add-header8547307782376-submit title-header-8547307782376"
                    aria-live="polite"
                    data-sold-out-message="true"
                    
                  >
<!-- <svg  width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
<path d="M3.3,17.5c-0.4,0-0.8-0.2-1.1-0.5c-0.3-0.3-0.5-0.7-0.5-1.1V6.2c0-0.4,0.2-0.8,0.5-1.1c0.3-0.3,0.7-0.5,1.1-0.5H5
	c0-1.1,0.4-2.1,1.2-2.9S7.9,0.5,9,0.5s2.1,0.4,2.9,1.2S13,3.4,13,4.5h1.6c0.4,0,0.8,0.2,1.1,0.5s0.5,0.7,0.5,1.1v9.7
	c0,0.4-0.2,0.8-0.5,1.1c-0.3,0.3-0.7,0.5-1.1,0.5H3.3z M3.3,15.9h11.3V6.2H3.3V15.9z M9,11c1.1,0,2.1-0.4,2.9-1.2S13,8.1,13,7h-1.6
	c0,0.7-0.2,1.2-0.7,1.7c-0.5,0.5-1,0.7-1.7,0.7c-0.7,0-1.2-0.2-1.7-0.7C6.8,8.2,6.6,7.7,6.6,7H5c0,1.1,0.4,2.1,1.2,2.9S7.9,11,9,11z
	 M6.6,4.5h4.9c0-0.7-0.2-1.2-0.7-1.7c-0.5-0.5-1-0.7-1.7-0.7c-0.7,0-1.2,0.2-1.7,0.7S6.6,3.9,6.6,4.5z M3.3,15.9V6.2V15.9z" fill="currentcolor" />
</svg> -->

<svg width="17" height="17" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.3166 19.7513H3.40213C2.21719 19.7513 1.27974 18.7663 1.36473 17.6088L2.28218 6.66884C2.32468 6.15134 2.75966 5.75134 3.27963 5.75134H13.4391C13.9591 5.75134 14.3916 6.14884 14.4366 6.66884L15.354 17.6088C15.439 18.7663 14.5016 19.7513 13.3166 19.7513Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.35938 8.75134V3.75134C5.35938 2.64634 6.25437 1.75134 7.35938 1.75134H9.35938C10.4644 1.75134 11.3594 2.64634 11.3594 3.75134V8.75134" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<span class="sold-out-message hidden">
                      Sold out
                    </span>
                    <div class="loading-overlay__spinner hidden">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background:transparent; display: block; shape-rendering: auto; animation-play-state: running; animation-delay: 0s;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="currentColor" stroke-width="6" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" style="animation-play-state: running; animation-delay: 0s;">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.819672131147541s" values="0 50 50;360 50 50" keyTimes="0;1" style="animation-play-state: running; animation-delay: 0s;"></animateTransform>
                    </circle>
                  </svg>
                    </div>
                  </button><input type="hidden" name="product-id" value="8547307782376" /><input type="hidden" name="section-id" value="header" /></form></product-form>  
              <tooltip class="tooltip">Add to cart</tooltip>
           </li></ul>          
        </div>
           
      </div>
      <div class="card__content for-arrow-alignment content-center  ">
        <div class="card__information">
          <div class="card-information new--tag">      
          </div><div class="card-information review">
              <div class="rating" role="img" aria-label="4.0 out of 5.0 stars">
                <span aria-hidden="true" class="rating-star color-icon-accent-1" style="--rating: 4; --rating-max: 5.0; --rating-decimal: 0;"></span>
              </div>
              <p class="rating-text caption">
                <span aria-hidden="true">4.0 / 5.0</span>
              </p>
              <p class="rating-count caption">
                <span aria-hidden="true">(1)</span>
                <span class="visually-hidden">1 total reviews</span>
              </p></div>
          <!-- <div class="heading-swatch"> -->
          <h3 class="card__heading h5" id="title-header-8547307782376">
            <a href="/products/cuddly-monkey" class="full-unstyled-link">
              Cuddly Monkey <span class="choosen-swatch"></span>
            </a>
          </h3>
        
          <!-- </div> -->
        
<div class="price  product-price-current" data-price="Rs. 657.00">
  <div class="price__container">    
    <div class="price__regular">
      <span class="visually-hidden visually-hidden--inline">Regular price</span>
      <span class="price-item price-item--regular">
       Rs. 657.00
      </span>
    </div>
    <div class="price__sale">      
      <span class="visually-hidden visually-hidden--inline">Sale price</span>
      <span class="price-item price-item--sale price-item--last">
       Rs. 657.00
      </span>
        <span class="visually-hidden visually-hidden--inline">Regular price</span>
        <span>
          <s class="price-item price-item--regular">
            
              Rs. 6.88
            
          </s>
        </span>
    </div>
    <small class="unit-price caption hidden">
      <span class="visually-hidden">Unit price</span>
      <span class="price-item price-item--last">
        <span></span>
        <span aria-hidden="true">/</span>
        <span class="visually-hidden">&nbsp;per&nbsp;</span>
        <span>
        </span>
      </span>
    </small>
  </div></div>
      
         <span class="caption-large light"></span>
      
            

    



<ul class="variant-option-color">
   
      
  <li class="color-values">       
    <a data-href="/products/cuddly-monkey?variant=45411340222696" class="swatch swatch-element  active color bg-color-orange" data-swatch-meta="name-color_orange">
      <tooltip class="tooltip">Orange</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-10_eb50b7fb-ae89-4cb7-b4d1-19da2de33a2f.jpg?v=1706620815&width=460"
         style="background-size: cover;background-color:orange;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/orange_50x50.png); background-repeat: no-repeat;"data-id="45411340222696"
        data-variant-title-id="color" data-variant-item="orange"  data-variant-title="Orange / Cotton / 90 g"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/cuddly-monkey?variant=45411340255464" class="swatch swatch-element  color bg-color-blue" data-swatch-meta="name-color_blue">
      <tooltip class="tooltip">Blue</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/Image4_1_7f9e2fd3-4b73-4ea5-8587-369285a6f2ba.jpg?v=1706620815&width=460"
         style="background-size: cover;background-color:blue;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/blue_50x50.png); background-repeat: no-repeat;"data-id="45411340255464"
        data-variant-title-id="color" data-variant-item="blue"  data-variant-title="Blue / Polyester / 100 g"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/cuddly-monkey?variant=45411340288232" class="swatch swatch-element  color bg-color-grey" data-swatch-meta="name-color_grey">
      <tooltip class="tooltip">Grey</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-15.jpg?v=1706620815&width=460"
         style="background-size: cover;background-color:grey;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/grey_50x50.png); background-repeat: no-repeat;"data-id="45411340288232"
        data-variant-title-id="color" data-variant-item="grey"  data-variant-title="Grey / Hypoallergenic / 150 g"></span>
    </a>          
    
  </li>
  

  
   
    
  <li class="color-values show-on-click" style="display:none">
    <a data-href="/products/cuddly-monkey?variant=45411340321000" class="swatch  color bg-color-white" data-swatch-meta="name-color_white">
     <tooltip class="tooltip">White</tooltip>
         <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-11_85c69b63-8613-45f3-81d6-0e07c2fe7dac.jpg?v=1706620815&width=460"
         style="background-size: cover;background-color:white;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/white_50x50.png); background-repeat: no-repeat;"data-ids="45411340321000"
            data-variant-title-id="color" data-variant-item="white"  data-variant-title="White / Plush / 200 g"></span>
    </a>  
  </li>
  
  

  
  

    
      
    
  
  
    
      
  
    
      
  
  

</ul>


    


    




        </div>
        <div class="card__badge top-left"></div>        
         
          
         
  
      </div>     
    </div>      
  </div>
        
          </div><div id="Slide-header-5" class=" swiper-slide card_style-card_with_icons">
           
             
<div class="card-wrapper underline-links-hover ">
    <div class="card
      card--card
       card--media
      color-background-1 gradient
      
      "
      style="--ratio-percent: 125.0%;"
    >
      <div class="card__inner  ratio" style="--ratio-percent: 125.0%;"><div class="card__media">
            <a href="/products/bear-soft-toy">
            <div class="media media--transparent media--hover-effect">
              
         
              <img
                 srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799 960w
                "
                src="//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799&width=533"
                sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                alt="Bear Soft Toy"
                class="motion-reduce  loading-image"                
                loading="lazy"
                width="960"
                height="960"
              >
              
<img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799 960w
                  "
                  src="//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799&width=533"
                  sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                  alt="Bear Soft Toy"
                  class="motion-reduce  loading-image secondary-image"
                  loading="lazy"
                  width="960"
                  height="960"
                ></div>
           </a>

          </div><div class="card__content">
          <div class="card__information">
            <h3 class="card__heading">
              <a href="/products/bear-soft-toy" class="full-unstyled-link">
                Bear Soft Toy
              </a>
            </h3>
          </div>
          <div class="card__badge top-left">
            <!----></div>
       <ul class="product-icons right-aligned"><li><dtx-wishlist><a href="javascript:void(0);" class="add-wishlist" data-product_handle="bear-soft-toy"> </a></dtx-wishlist>
            <tooltip class="tooltip">wishlist</tooltip>
          </li><li class="mobile-hide"><dtx-compare><a href="javascript:void(0);" class="add-compare" data-product_handle="bear-soft-toy"></a></dtx-compare>
          <tooltip class="tooltip">compare</tooltip>
          </li><li>
            <product-form><form method="post" action="/cart/add" id="quick-add-header8547307684072" accept-charset="UTF-8" class="form shopify-product-form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" class="variant-push" value="45411339862248" disabled>
                  <button
                    id="quick-add-header8547307684072-submit"
                    type="submit"
                    name="add"
                    class="quick-add__submit  button--full-width button--secondary"
                    aria-haspopup="dialog"
                    aria-labelledby="quick-add-header8547307684072-submit title-header-8547307684072"
                    aria-live="polite"
                    data-sold-out-message="true"
                    
                  >
<!-- <svg  width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
<path d="M3.3,17.5c-0.4,0-0.8-0.2-1.1-0.5c-0.3-0.3-0.5-0.7-0.5-1.1V6.2c0-0.4,0.2-0.8,0.5-1.1c0.3-0.3,0.7-0.5,1.1-0.5H5
	c0-1.1,0.4-2.1,1.2-2.9S7.9,0.5,9,0.5s2.1,0.4,2.9,1.2S13,3.4,13,4.5h1.6c0.4,0,0.8,0.2,1.1,0.5s0.5,0.7,0.5,1.1v9.7
	c0,0.4-0.2,0.8-0.5,1.1c-0.3,0.3-0.7,0.5-1.1,0.5H3.3z M3.3,15.9h11.3V6.2H3.3V15.9z M9,11c1.1,0,2.1-0.4,2.9-1.2S13,8.1,13,7h-1.6
	c0,0.7-0.2,1.2-0.7,1.7c-0.5,0.5-1,0.7-1.7,0.7c-0.7,0-1.2-0.2-1.7-0.7C6.8,8.2,6.6,7.7,6.6,7H5c0,1.1,0.4,2.1,1.2,2.9S7.9,11,9,11z
	 M6.6,4.5h4.9c0-0.7-0.2-1.2-0.7-1.7c-0.5-0.5-1-0.7-1.7-0.7c-0.7,0-1.2,0.2-1.7,0.7S6.6,3.9,6.6,4.5z M3.3,15.9V6.2V15.9z" fill="currentcolor" />
</svg> -->

<svg width="17" height="17" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.3166 19.7513H3.40213C2.21719 19.7513 1.27974 18.7663 1.36473 17.6088L2.28218 6.66884C2.32468 6.15134 2.75966 5.75134 3.27963 5.75134H13.4391C13.9591 5.75134 14.3916 6.14884 14.4366 6.66884L15.354 17.6088C15.439 18.7663 14.5016 19.7513 13.3166 19.7513Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.35938 8.75134V3.75134C5.35938 2.64634 6.25437 1.75134 7.35938 1.75134H9.35938C10.4644 1.75134 11.3594 2.64634 11.3594 3.75134V8.75134" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<span class="sold-out-message hidden">
                      Sold out
                    </span>
                    <div class="loading-overlay__spinner hidden">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background:transparent; display: block; shape-rendering: auto; animation-play-state: running; animation-delay: 0s;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="currentColor" stroke-width="6" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" style="animation-play-state: running; animation-delay: 0s;">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.819672131147541s" values="0 50 50;360 50 50" keyTimes="0;1" style="animation-play-state: running; animation-delay: 0s;"></animateTransform>
                    </circle>
                  </svg>
                    </div>
                  </button><input type="hidden" name="product-id" value="8547307684072" /><input type="hidden" name="section-id" value="header" /></form></product-form>  
              <tooltip class="tooltip">Add to cart</tooltip>
           </li></ul>          
        </div>
           
      </div>
      <div class="card__content for-arrow-alignment content-center  ">
        <div class="card__information">
          <div class="card-information new--tag">      
          </div><div class="card-information review">
              <div class="rating" role="img" aria-label="5.0 out of 5.0 stars">
                <span aria-hidden="true" class="rating-star color-icon-accent-1" style="--rating: 5; --rating-max: 5.0; --rating-decimal: 0;"></span>
              </div>
              <p class="rating-text caption">
                <span aria-hidden="true">5.0 / 5.0</span>
              </p>
              <p class="rating-count caption">
                <span aria-hidden="true">(1)</span>
                <span class="visually-hidden">1 total reviews</span>
              </p></div>
          <!-- <div class="heading-swatch"> -->
          <h3 class="card__heading h5" id="title-header-8547307684072">
            <a href="/products/bear-soft-toy" class="full-unstyled-link">
              Bear Soft Toy <span class="choosen-swatch"></span>
            </a>
          </h3>
        
          <!-- </div> -->
        
<div class="price  product-price-current" data-price="Rs. 450.00">
  <div class="price__container">    
    <div class="price__regular">
      <span class="visually-hidden visually-hidden--inline">Regular price</span>
      <span class="price-item price-item--regular">
       Rs. 450.00
      </span>
    </div>
    <div class="price__sale">      
      <span class="visually-hidden visually-hidden--inline">Sale price</span>
      <span class="price-item price-item--sale price-item--last">
       Rs. 450.00
      </span>
        <span class="visually-hidden visually-hidden--inline">Regular price</span>
        <span>
          <s class="price-item price-item--regular">
            
              Rs. 6.00
            
          </s>
        </span>
    </div>
    <small class="unit-price caption hidden">
      <span class="visually-hidden">Unit price</span>
      <span class="price-item price-item--last">
        <span></span>
        <span aria-hidden="true">/</span>
        <span class="visually-hidden">&nbsp;per&nbsp;</span>
        <span>
        </span>
      </span>
    </small>
  </div></div>
      
         <span class="caption-large light"></span>
      
            

    



<ul class="variant-option-color">
   
      
  <li class="color-values">       
    <a data-href="/products/bear-soft-toy?variant=45411339862248" class="swatch swatch-element  active color bg-color-brown" data-swatch-meta="name-color_brown">
      <tooltip class="tooltip">Brown</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-12_a2eba408-3628-4af6-88e8-a0430a18890c.jpg?v=1706620799&width=460"
         style="background-size: cover;background-color:brown;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/brown_50x50.png); background-repeat: no-repeat;"data-id="45411339862248"
        data-variant-title-id="color" data-variant-item="brown"  data-variant-title="Brown / 150 g / Synthetic fur"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/bear-soft-toy?variant=45411339895016" class="swatch swatch-element  color bg-color-pink" data-swatch-meta="name-color_pink">
      <tooltip class="tooltip">Pink</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-4_efa4ac46-b134-491b-b9a8-1d21f74d1d03.jpg?v=1706620799&width=460"
         style="background-size: cover;background-color:pink;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/pink_50x50.png); background-repeat: no-repeat;"data-id="45411339895016"
        data-variant-title-id="color" data-variant-item="pink"  data-variant-title="Pink / 100 g / Satin"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/bear-soft-toy?variant=45411339927784" class="swatch swatch-element  color bg-color-blue" data-swatch-meta="name-color_blue">
      <tooltip class="tooltip">Blue</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/Image4_2.jpg?v=1706620799&width=460"
         style="background-size: cover;background-color:blue;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/blue_50x50.png); background-repeat: no-repeat;"data-id="45411339927784"
        data-variant-title-id="color" data-variant-item="blue"  data-variant-title="Blue / 200 g / Cotton"></span>
    </a>          
    
  </li>
  

  
   
    
  <li class="color-values show-on-click" style="display:none">
    <a data-href="/products/bear-soft-toy?variant=45411339960552" class="swatch  color bg-color-red" data-swatch-meta="name-color_red">
     <tooltip class="tooltip">Red</tooltip>
         <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/Image4_1.jpg?v=1706620799&width=460"
         style="background-size: cover;background-color:red;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/red_50x50.png); background-repeat: no-repeat;"data-ids="45411339960552"
            data-variant-title-id="color" data-variant-item="red"  data-variant-title="Red / 250 g / Crochet"></span>
    </a>  
  </li>
  
  

  
  

    
      
    
  
  
    
      
  
    
      
  
  

</ul>


    


    




        </div>
        <div class="card__badge top-left"></div>        
         
          
         
  
      </div>     
    </div>      
  </div>
        
          </div><div id="Slide-header-6" class=" swiper-slide card_style-card_with_icons">
           
             
<div class="card-wrapper underline-links-hover ">
    <div class="card
      card--card
       card--media
      color-background-1 gradient
      
      "
      style="--ratio-percent: 125.0%;"
    >
      <div class="card__inner  ratio" style="--ratio-percent: 125.0%;"><div class="card__media">
            <a href="/products/baby-doll">
            <div class="media media--transparent media--hover-effect">
              
         
              <img
                 srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823 960w
                "
                src="//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823&width=533"
                sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                alt="Baby Doll"
                class="motion-reduce  loading-image"                
                loading="lazy"
                width="960"
                height="960"
              >
              
<img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823&width=533 533w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823&width=720 720w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823&width=940 940w,//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823 960w
                  "
                  src="//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823&width=533"
                  sizes="(min-width: 1540px) 352px, (min-width: 990px) calc((100vw - 130px) / 4), (min-width: 750px) calc((100vw - 120px) / 3), calc((100vw - 35px) / 2)"
                  alt="Baby Doll"
                  class="motion-reduce  loading-image secondary-image"
                  loading="lazy"
                  width="960"
                  height="960"
                ></div>
           </a>

          </div><div class="card__content">
          <div class="card__information">
            <h3 class="card__heading">
              <a href="/products/baby-doll" class="full-unstyled-link">
                Baby Doll
              </a>
            </h3>
          </div>
          <div class="card__badge top-left">
            <!----></div>
       <ul class="product-icons right-aligned"><li><dtx-wishlist><a href="javascript:void(0);" class="add-wishlist" data-product_handle="baby-doll"> </a></dtx-wishlist>
            <tooltip class="tooltip">wishlist</tooltip>
          </li><li class="mobile-hide"><dtx-compare><a href="javascript:void(0);" class="add-compare" data-product_handle="baby-doll"></a></dtx-compare>
          <tooltip class="tooltip">compare</tooltip>
          </li><li>
            <product-form><form method="post" action="/cart/add" id="quick-add-header8547307815144" accept-charset="UTF-8" class="form shopify-product-form" enctype="multipart/form-data" novalidate="novalidate" data-type="add-to-cart-form"><input type="hidden" name="form_type" value="product" /><input type="hidden" name="utf8" value="✓" /><input type="hidden" name="id" class="variant-push" value="45411340386536" disabled>
                  <button
                    id="quick-add-header8547307815144-submit"
                    type="submit"
                    name="add"
                    class="quick-add__submit  button--full-width button--secondary"
                    aria-haspopup="dialog"
                    aria-labelledby="quick-add-header8547307815144-submit title-header-8547307815144"
                    aria-live="polite"
                    data-sold-out-message="true"
                    
                  >
<!-- <svg  width="18px" height="18px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
<path d="M3.3,17.5c-0.4,0-0.8-0.2-1.1-0.5c-0.3-0.3-0.5-0.7-0.5-1.1V6.2c0-0.4,0.2-0.8,0.5-1.1c0.3-0.3,0.7-0.5,1.1-0.5H5
	c0-1.1,0.4-2.1,1.2-2.9S7.9,0.5,9,0.5s2.1,0.4,2.9,1.2S13,3.4,13,4.5h1.6c0.4,0,0.8,0.2,1.1,0.5s0.5,0.7,0.5,1.1v9.7
	c0,0.4-0.2,0.8-0.5,1.1c-0.3,0.3-0.7,0.5-1.1,0.5H3.3z M3.3,15.9h11.3V6.2H3.3V15.9z M9,11c1.1,0,2.1-0.4,2.9-1.2S13,8.1,13,7h-1.6
	c0,0.7-0.2,1.2-0.7,1.7c-0.5,0.5-1,0.7-1.7,0.7c-0.7,0-1.2-0.2-1.7-0.7C6.8,8.2,6.6,7.7,6.6,7H5c0,1.1,0.4,2.1,1.2,2.9S7.9,11,9,11z
	 M6.6,4.5h4.9c0-0.7-0.2-1.2-0.7-1.7c-0.5-0.5-1-0.7-1.7-0.7c-0.7,0-1.2,0.2-1.7,0.7S6.6,3.9,6.6,4.5z M3.3,15.9V6.2V15.9z" fill="currentcolor" />
</svg> -->

<svg width="17" height="17" viewBox="0 0 17 21" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M13.3166 19.7513H3.40213C2.21719 19.7513 1.27974 18.7663 1.36473 17.6088L2.28218 6.66884C2.32468 6.15134 2.75966 5.75134 3.27963 5.75134H13.4391C13.9591 5.75134 14.3916 6.14884 14.4366 6.66884L15.354 17.6088C15.439 18.7663 14.5016 19.7513 13.3166 19.7513Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M5.35938 8.75134V3.75134C5.35938 2.64634 6.25437 1.75134 7.35938 1.75134H9.35938C10.4644 1.75134 11.3594 2.64634 11.3594 3.75134V8.75134" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
</svg>
<span class="sold-out-message hidden">
                      Sold out
                    </span>
                    <div class="loading-overlay__spinner hidden">
                      <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background:transparent; display: block; shape-rendering: auto; animation-play-state: running; animation-delay: 0s;" width="40px" height="40px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid">
                    <circle cx="50" cy="50" fill="none" stroke="currentColor" stroke-width="6" r="35" stroke-dasharray="164.93361431346415 56.97787143782138" style="animation-play-state: running; animation-delay: 0s;">
                      <animateTransform attributeName="transform" type="rotate" repeatCount="indefinite" dur="0.819672131147541s" values="0 50 50;360 50 50" keyTimes="0;1" style="animation-play-state: running; animation-delay: 0s;"></animateTransform>
                    </circle>
                  </svg>
                    </div>
                  </button><input type="hidden" name="product-id" value="8547307815144" /><input type="hidden" name="section-id" value="header" /></form></product-form>  
              <tooltip class="tooltip">Add to cart</tooltip>
           </li></ul>          
        </div>
           
      </div>
      <div class="card__content for-arrow-alignment content-center  ">
        <div class="card__information">
          <div class="card-information new--tag">      
          </div><div class="card-information review">
              <div class="rating" role="img" aria-label="4.33 out of 5.0 stars">
                <span aria-hidden="true" class="rating-star color-icon-accent-1" style="--rating: 4; --rating-max: 5.0; --rating-decimal: 0.5;"></span>
              </div>
              <p class="rating-text caption">
                <span aria-hidden="true">4.33 / 5.0</span>
              </p>
              <p class="rating-count caption">
                <span aria-hidden="true">(3)</span>
                <span class="visually-hidden">3 total reviews</span>
              </p></div>
          <!-- <div class="heading-swatch"> -->
          <h3 class="card__heading h5" id="title-header-8547307815144">
            <a href="/products/baby-doll" class="full-unstyled-link">
              Baby Doll <span class="choosen-swatch"></span>
            </a>
          </h3>
        
          <!-- </div> -->
        
<div class="price  product-price-current" data-price="Rs. 200.00">
  <div class="price__container">    
    <div class="price__regular">
      <span class="visually-hidden visually-hidden--inline">Regular price</span>
      <span class="price-item price-item--regular">
       Rs. 200.00
      </span>
    </div>
    <div class="price__sale">      
      <span class="visually-hidden visually-hidden--inline">Sale price</span>
      <span class="price-item price-item--sale price-item--last">
       Rs. 200.00
      </span>
        <span class="visually-hidden visually-hidden--inline">Regular price</span>
        <span>
          <s class="price-item price-item--regular">
            
              Rs. 10.95
            
          </s>
        </span>
    </div>
    <small class="unit-price caption hidden">
      <span class="visually-hidden">Unit price</span>
      <span class="price-item price-item--last">
        <span></span>
        <span aria-hidden="true">/</span>
        <span class="visually-hidden">&nbsp;per&nbsp;</span>
        <span>
        </span>
      </span>
    </small>
  </div></div>
      
         <span class="caption-large light"></span>
      
            

    



<ul class="variant-option-color">
   
      
  <li class="color-values">       
    <a data-href="/products/baby-doll?variant=45411340386536" class="swatch swatch-element  active color bg-color-white" data-swatch-meta="name-color_white">
      <tooltip class="tooltip">White</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-9_1eb15643-c698-4013-bbbb-c3ba391e4e0e.jpg?v=1706620823&width=460"
         style="background-size: cover;background-color:white;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/white_50x50.png); background-repeat: no-repeat;"data-id="45411340386536"
        data-variant-title-id="color" data-variant-item="white"  data-variant-title="White / 100 g / Rubber"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/baby-doll?variant=45411340419304" class="swatch swatch-element  color bg-color-brown" data-swatch-meta="name-color_brown">
      <tooltip class="tooltip">Brown</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-10_e909c1be-0de0-463d-98f2-44e4721aaf9f.jpg?v=1706620823&width=460"
         style="background-size: cover;background-color:brown;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/brown_50x50.png); background-repeat: no-repeat;"data-id="45411340419304"
        data-variant-title-id="color" data-variant-item="brown"  data-variant-title="Brown / 150 g / Polyester"></span>
    </a>          
    
  </li>
  

  
   
      
  <li class="color-values">       
    <a data-href="/products/baby-doll?variant=45411340452072" class="swatch swatch-element  color bg-color-yellow" data-swatch-meta="name-color_yellow">
      <tooltip class="tooltip">Yellow</tooltip>
      <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/shop-11_a0642ca0-ff47-42af-a98b-1e49005394d2.jpg?v=1706620823&width=460"
         style="background-size: cover;background-color:yellow;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/yellow_50x50.png); background-repeat: no-repeat;"data-id="45411340452072"
        data-variant-title-id="color" data-variant-item="yellow"  data-variant-title="Yellow / 200 g / Fur"></span>
    </a>          
    
  </li>
  

  
   
    
  <li class="color-values show-on-click" style="display:none">
    <a data-href="/products/baby-doll?variant=45411340484840" class="swatch  color bg-color-pink" data-swatch-meta="name-color_pink">
     <tooltip class="tooltip">Pink</tooltip>
         <span 
        data-image="//toytime-theme.myshopify.com/cdn/shop/products/Image1_b08630f7-8e13-4393-9604-e52786a2458c.jpg?v=1706620823&width=460"
         style="background-size: cover;background-color:pink;background-image: url(https://toytime-theme.myshopify.com/cdn/shop/files/pink_50x50.png); background-repeat: no-repeat;"data-ids="45411340484840"
            data-variant-title-id="color" data-variant-item="pink"  data-variant-title="Pink / 250 g / Bisque"></span>
    </a>  
  </li>
  
  

  
  

    
      
    
  
  
    
      
  
    
      
  
  

</ul>


    


    




        </div>
        <div class="card__badge top-left"></div>        
         
          
         
        <div class="rte grid-view-hidden">{"type"=>"root", "children"=>[{"type"=>"paragraph", "children"=>[{"type"=>"text", "value"=>"Babies love to feel and touch different textures, so toys might be the ideal mix for fostering the development of sensory abilities. Kids find toys amusing and enjoyable, which eventually brings them delight. "}]}]}</div>
        
  
      </div>     
    </div>      
  </div>
        
          </div></div>
            
        
    </div>
      </div>
    </featured-swiper-slider>   
         
            </form></predictive-search></div>  
          </div>        
                  </details-overlay-modal>




   
<script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/details-disclosure.js?v=153497636716254413831708942415" defer="defer"></script>
<script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/details-modal.js?v=4511761896672669691708942415" defer="defer"></script>
<script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/cart-notification.js?v=31179948596492670111708942415" defer="defer"></script>
<script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/dt-mega-menu.js?v=33680591316716689811708942415" defer="defer"></script><script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/cart-drawer.js?v=44260131999403604181708942415" defer="defer"></script><script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/search-form.js?v=133129549252120666541708942415" defer="defer"></script>
 <svg xmlns="http://www.w3.org/2000/svg" class="hidden">
  <symbol id="icon-search" viewbox="0 0 18 19" fill="none">
    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.03 11.68A5.784 5.784 0 112.85 3.5a5.784 5.784 0 018.18 8.18zm.26 1.12a6.78 6.78 0 11.72-.7l5.4 5.4a.5.5 0 11-.71.7l-5.41-5.4z" fill="currentColor"/>
  </symbol>

  <symbol id="icon-close" class="icon icon-close" fill="none" viewBox="0 0 18 17">
    <path d="M.865 15.978a.5.5 0 00.707.707l7.433-7.431 7.579 7.282a.501.501 0 00.846-.37.5.5 0 00-.153-.351L9.712 8.546l7.417-7.416a.5.5 0 10-.707-.708L8.991 7.853 1.413.573a.5.5 0 10-.693.72l7.563 7.268-7.418 7.417z" fill="currentColor">
  </symbol>
</svg> 

<!-- 
<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
	 viewBox="0 0 18 18" style="enable-background:new 0 0 18 18;" xml:space="preserve">
<path d="M16.2,17.5l-6-5.9c-0.5,0.4-1,0.7-1.6,0.9c-0.6,0.2-1.3,0.3-2,0.3c-1.7,0-3.2-0.6-4.4-1.8S0.5,8.4,0.5,6.6s0.6-3.2,1.8-4.4
	s2.6-1.8,4.4-1.8S9.8,1.1,11,2.3s1.8,2.6,1.8,4.4c0,0.7-0.1,1.3-0.3,2c-0.2,0.6-0.5,1.2-0.9,1.6l5.9,6L16.2,17.5z M6.6,10.9
	c1.2,0,2.2-0.4,3-1.2c0.8-0.8,1.2-1.8,1.2-3s-0.4-2.2-1.2-3c-0.8-0.8-1.8-1.2-3-1.2s-2.2,0.4-3,1.2s-1.2,1.8-1.2,3s0.4,2.2,1.2,3
	C4.5,10.5,5.5,10.9,6.6,10.9z"/>
</svg> -->
<div id="shopify-section-headers" class="header-wrapper ">
  
  <header>
		<!-- Header desktop -->
		<div  class="container-menu-desktop">
			<!-- Topbar -->
			<div  class="top-bar" style="height: 60px;">
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
								<a href="register.php" class="btn2 btn-primary2 mt-1" style="color: #49243E;"><b><?php echo $userLogin["userID"];?>
										/</b></a>
							</div>
							<div class="data2">
								<i style="color: #49243E;" class=""></i>
								<a href="register.php" class="btn2 btn-primary2 mt-1" style="color: #49243E;"><b><?php echo $userLogin["userName"];?></b></a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div id="thanhbar" class="wrap-menu-desktop" style="background-color: #FFEFEF;">
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
<script>

  window.addEventListener('scroll', function() {
    var thanhbar = document.getElementById('thanhbar');
    if (window.scrollY > 100) {
        thanhbar.style.transform = 'translateY(-40px)';
    } else {
        thanhbar.style.transform = 'translateY(0)';
    }
});
</script>
					
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


<script type="application/ld+json">
  {
    "@context": "http://schema.org",
    "@type": "Organization",
    "name": "ToyTime-theme",
    
      "logo": "https:\/\/toytime-theme.myshopify.com\/cdn\/shop\/files\/Logo.png?v=1707972992\u0026width=150",
    
    "sameAs": [
      "#",
      "#",
      "#",
      "#",
      "",
      "",
      "",
      "",
      ""
    ],
    "url": "https:\/\/toytime-theme.myshopify.com\/pages\/faq"
  }
</script>

</div>    
    
     
<main id="MainContent" class="content-for-layout focus-none placeholder-shadow-blocks page-template" role="main" tabindex="-1">      
      <div id="shopify-section-template--17275203027176__6cd6487e-d9a0-4ded-85ba-5068911dc2fd" class="shopify-section"><style data-shopify>.section-template--17275203027176__6cd6487e-d9a0-4ded-85ba-5068911dc2fd-padding {
    padding-top: 90px;
    padding-bottom: 90px;
  }
 @media screen and (max-width: 576px) {
    .section-template--17275203027176__6cd6487e-d9a0-4ded-85ba-5068911dc2fd-padding {
      padding-top: 60px;
      padding-bottom: 60px;
    }
  } 
  @media screen and (min-width: 750px) {
    .section-template--17275203027176__6cd6487e-d9a0-4ded-85ba-5068911dc2fd-padding {
      padding-top: 120px;
      padding-bottom: 120px;
    }
  } 
  
 
 .breadcrumb {background-image:url(//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11-1.png?v=1707972746&width=1920);background-repeat:no-repeat; border-radius: var(--media-radius);padding-left:60px;padding-right:60px; background-size: cover;     background-position: 25% 30%; }  
   
 .breadcrumb a{color: rgba(var(--color-foreground),1);}  
 .breadcrumb a:hover{ color: rgb(var(--color-base-outline-button-labels));}
 .breadcrumb{position: relative;z-index: 1;}  
 .breadcrumb .breadcrumb_title{margin:0; font-weight: 600;font-size: 4rem; }
 .breadcrumb a, .breadcrumb span{display: inline-block;margin-top:1rem;font-size:1.6rem;font-weight:400; padding: 0;text-transform: capitalize;opacity:0.7;} 
 .breadcrumb.text-center{text-align:center;}  
 .breadcrumb.text-start{text-align:left;}  
 .breadcrumb.text-end{text-align:right;}
 .breadcrumb:before { position: absolute; content: "";  display: block;  width: 100%;  height: 100%;  left: 0;  top: 0;  z-index: -1;background:rgba(var(--color-base-background-1));opacity:.0;}  

   span.breadcrumb__sep svg {
    width: 1rem;
    height: 1rem;
    fill:currentcolor;
}
  @media screen and (max-width: 990px) {
     .breadcrumb {padding-left:30px;padding-right:30px;}
  }
  
  @media screen and (max-width: 576px) { 
    .breadcrumb .breadcrumb_title{font-size: 2.6rem; margin-bottom:1rem;}
    .breadcrumb a, .breadcrumb span{font-size:1.4rem; margin:0;font-weight: 600;}
  }
</style>

          

        </div><section class="bg-img1 txt-center p-lr-15 p-tb-92 header" style="background-image: url('images/contactbg.png');">
            <h2 class="">
                FAQ
            </h2>
        </section><section id="shopify-section-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" class="shopify-section section section-collapsible-content"><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-accordion.css?v=12157121302558442951708942415" rel="stylesheet" type="text/css" media="all" />
<link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/collapsible-content.css?v=76473396394287422521710411979" rel="stylesheet" type="text/css" media="all" />
<style data-shopify>.section-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896-padding {
    padding-top: 50px;
    padding-bottom: 0px;
  }
   @media screen and (min-width: 576px) and (max-width: 749px){
   .section-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896-padding {
    padding-top: 75px;
    padding-bottom: 0px;
  }
   }
  @media screen and (min-width: 750px) {
    .section-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896-padding {
      padding-top: 100px;
      padding-bottom: 0px;
    }
  }</style><div class="color-background-1 gradient">
  <div class="collapsible-content custom-faq collapsible-row-layout isolate  page-full-width   page-full-width_spacing  section-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896-padding">
   <div class="row">
    <div id="hinhbienmat" class="collapsible-content__wrapper "><div class="grid grid--1-col grid--2-col-tablet collapsible-content__grid collapsible-content__grid--reverse"><div class="grid__item collapsible-content__grid-item"><div class="collapsible-content__media collapsible-content__media--adapt media global-media-settings gradient"
                 style="padding-bottom: 166.89655172413794%;"
              >
                <img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=535 535w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=750 750w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=1070 1070w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758 1160w"
                  src="//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=1500"
                  sizes="(min-width: 1540px) 720px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)"
                  alt=""
                  loading="lazy"
                  width="1160"
                  height="1936"
                >
              </div>
                  
              
              
            </div>
          
          <div id="khuvucbienmat" class="grid__item collapsible-content">
            
                <h3  class="address-block-heading h1">Our Toys</h3>
              
            
                <p class="address-block-desc"> </p>
             <div  class="accordion content-container color-background-1 gradient" >
                <details  class="dt-details" id="Details-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" open>
                  <summary id="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" class="dt-sumary">
                    
                    <h3 id="khuvucbienmat" class="accordion__title h4">
                        I have a child with special needs.Are your toys suitable
                    </h3>
                    
                    
                    <svg  xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    
                      <path  d="M14 16.4136V14.0226H16.102L22.791 20.7171V14H26V24.4745L24.1696 26H14.1355V22.9032H20.4858L14 16.4136Z" fill="black"/>
                    </svg>
                     
                  </summary>
                  <div  class="accordion__content rte dt-accordion__content" id="CollapsibleAccordion-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" role="region" aria-labelledby="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                    <p>Each toy is designed with an age rating in mind to help you choose the best toy for your child’s needs. Also, some of our toys have been recommended by the National Lekotek Center, an independent non-profit organization founded to help children with special needs</p>
                    
                  </div>
                </details>
              </div>
                
                 
                    
                    
                    
                </details>
              </div>
            </div>
        </div>

    </div>
  </div>
</div>
</div>

<img  id="khuvucxuathien"  src="//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=535 0w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=750 0w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758&width=1070 1070w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_11_1fbd88b4-addc-449c-b413-87613f1cf7ae.png?v=1707972758 1160w"" alt="">

</section><section id="shopify-section-template--17275203027176__d675f3ce-be02-4aaa-9549-e924a90a15a0" class="shopify-section section section-collapsible-content"><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-accordion.css?v=12157121302558442951708942415" rel="stylesheet" type="text/css" media="all" />
<link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/collapsible-content.css?v=76473396394287422521710411979" rel="stylesheet" type="text/css" media="all" />
<style data-shopify>.section-template--17275203027176__d675f3ce-be02-4aaa-9549-e924a90a15a0-padding {
    padding-top: 40px;
    padding-bottom: 0px;
  }
   @media screen and (min-width: 576px) and (max-width: 749px){
   .section-template--17275203027176__d675f3ce-be02-4aaa-9549-e924a90a15a0-padding {
    padding-top: 60px;
    padding-bottom: 0px;
  }
   }
  @media screen and (min-width: 750px) {
    .section-template--17275203027176__d675f3ce-be02-4aaa-9549-e924a90a15a0-padding {
      padding-top: 80px;
      padding-bottom: 0px;
    }
  }</style><div class="color-background-1 gradient">
  <div class="collapsible-content custom-faq collapsible-row-layout isolate  page-full-width   page-full-width_spacing  section-template--17275203027176__d675f3ce-be02-4aaa-9549-e924a90a15a0-padding">
   <div class="row">
    <div id="hinhauto" class="collapsible-content__wrapper "><div class="grid grid--1-col grid--2-col-tablet collapsible-content__grid"><div class="grid__item collapsible-content__grid-item"><div class="collapsible-content__media collapsible-content__media--adapt media global-media-settings gradient"
                 style="padding-bottom: 170.86206896551724%;"
              >
                <img
                  srcset="//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_12_5cbf94b4-1467-4c73-9024-43425248af23.png?v=1707972758&width=165 165w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_12_5cbf94b4-1467-4c73-9024-43425248af23.png?v=1707972758&width=360 360w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_12_5cbf94b4-1467-4c73-9024-43425248af23.png?v=1707972758&width=535 535w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_12_5cbf94b4-1467-4c73-9024-43425248af23.png?v=1707972758&width=750 750w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_12_5cbf94b4-1467-4c73-9024-43425248af23.png?v=1707972758&width=1070 1070w,//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_12_5cbf94b4-1467-4c73-9024-43425248af23.png?v=1707972758 1160w"
                  src="//toytime-theme.myshopify.com/cdn/shop/files/Rectangle_12_5cbf94b4-1467-4c73-9024-43425248af23.png?v=1707972758&width=1500"
                  sizes="(min-width: 1540px) 720px, (min-width: 750px) calc((100vw - 130px) / 2), calc((100vw - 50px) / 2)"
                  alt=""
                  loading="lazy"
                  width="1160"
                  height="1982"
                >
              </div>
                  
              <div class="collapsible_address-block">
                <ul class=" list-unstyled">
                      
                       
                        
                    </ul>
              </div>
            </div>
          
            <div class="grid__item collapsible-content">
            
                <h3 class="address-block-heading h1">Safety</h3>
              
            
                <p class="address-block-desc"> </p>
             <div class="accordion content-container color-background-1 gradient" >
                <details class="dt-details" id="Details-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" open>
                  <summary id="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" class="dt-sumary">
                    
                    <h3 class="accordion__title h4">
                      Are your toys safe?
                    </h3>
                    
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    
                      <path d="M14 16.4136V14.0226H16.102L22.791 20.7171V14H26V24.4745L24.1696 26H14.1355V22.9032H20.4858L14 16.4136Z" fill="black"/>
                    </svg>
                     
                  </summary>
                  <div class="accordion__content rte dt-accordion__content" id="CollapsibleAccordion-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" role="region" aria-labelledby="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-0-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                    <p>Children are our greatest treasure, and they need to be protected at every turn. Rest assured that all our toys go through stringent testing procedures that meet or exceed all U.S., Canadian and the even more rigorous European safety standards, all regulations regarding age guidelines, all Consumer Product Safety Commission (CPSC) directives and guidelines, and all regulations of the American Society for Testing and Materials.

                        In addition to our product testing, we do in-house use and abuse test on all products. We then perform an on-site inspection of our products with our own quality control staff during the manufacturing process as well as before products are shipped from the factory.</p>
                    
                  </div>
                </details>
              </div><div class="accordion content-container color-background-1 gradient" >
                <details class="dt-details" id="Details-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-1-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                  <summary id="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-1-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" class="dt-sumary">
                    
                    <h3 class="accordion__title h4">
                        What materials do you use to make your products? 
                    </h3>
                    
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    
                      <path d="M14 16.4136V14.0226H16.102L22.791 20.7171V14H26V24.4745L24.1696 26H14.1355V22.9032H20.4858L14 16.4136Z" fill="black"/>
                    </svg>
                     
                  </summary>
                  <div class="accordion__content rte dt-accordion__content" id="CollapsibleAccordion-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-1-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" role="region" aria-labelledby="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-1-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                    <p>The materials we use vary according to the toy and its age rating. We use wood, plastic, cloth, metal, and other materials. We ensure that all our wooden toys are smoothly sanded, with rounded corners, and we go the extra mile by rounding out all corners. There are established safety guidelines for all materials used; we follow these guidelines and keep a mama-bear eye on regulations and current events in the industry. </p>
                    
                  </div>
                </details>
              </div><div class="accordion content-container color-background-1 gradient" >
                <details class="dt-details" id="Details-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-2-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                  <summary id="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-2-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" class="dt-sumary">
                    
                    <h3 class="accordion__title h4">
                        I have a safety concern. Who do I notify?
                    </h3>
                    
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    
                      <path d="M14 16.4136V14.0226H16.102L22.791 20.7171V14H26V24.4745L24.1696 26H14.1355V22.9032H20.4858L14 16.4136Z" fill="black"/>
                    </svg>
                     
                  </summary>
                  <div class="accordion__content rte dt-accordion__content" id="CollapsibleAccordion-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-2-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" role="region" aria-labelledby="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-2-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                    <p>We want to hear about any concern you might have. Please email us directly at omacha.com with the words SAFETY ISSUE in the subject line so we can make it our priority. Be sure to include your name and telephone number in case we have questions. </p>
                    
                  </div>
                </details>
              </div><div class="accordion content-container color-background-1 gradient" >
                <details class="dt-details" id="Details-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-3-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                  <summary id="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-3-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" class="dt-sumary">
                    
                    <h3 class="accordion__title h4">
                        Does your toy shop provide information and guidance on product? 
                    </h3>
                    
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    
                      <path d="M14 16.4136V14.0226H16.102L22.791 20.7171V14H26V24.4745L24.1696 26H14.1355V22.9032H20.4858L14 16.4136Z" fill="black"/>
                    </svg>
                     
                  </summary>
                  <div class="accordion__content rte dt-accordion__content" id="CollapsibleAccordion-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-3-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" role="region" aria-labelledby="Summary-template--16688272900316__dac594f5-6f42-441b-b718-a5640c6f4896-16672924418c53fb80-3-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                    <p>Of course.We alway give information and guidance on product in product detail page you can check it when you clicking the product.</p>
                    
                  </div>
                </details>
              </div><div class="accordion content-container color-background-1 gradient" >
                <details class="dt-details" id="Details-a28c49d0-90ca-483f-bf46-d4bee34fac3b-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                  <summary id="Summary-a28c49d0-90ca-483f-bf46-d4bee34fac3b-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" class="dt-sumary">
                    
                    <h3 class="accordion__title h4">
                      How can i contact your shop when my kid have a problem while playing your shop's toy?
                    </h3>
                    
                    
                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                    
                      <path d="M14 16.4136V14.0226H16.102L22.791 20.7171V14H26V24.4745L24.1696 26H14.1355V22.9032H20.4858L14 16.4136Z" fill="black"/>
                    </svg>
                     
                  </summary>
                  <div class="accordion__content rte dt-accordion__content" id="CollapsibleAccordion-a28c49d0-90ca-483f-bf46-d4bee34fac3b-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896" role="region" aria-labelledby="Summary-a28c49d0-90ca-483f-bf46-d4bee34fac3b-template--17275203027176__dac594f5-6f42-441b-b718-a5640c6f4896">
                    <p>Please email us directly at omacha.com with the words SAFETY ISSUE in the subject line so we can make it our priority. Be sure to include your name and telephone number in case we have questions. </p>
                    
                  </div>
                </details>
              </div></div>
        </div>

    </div>
    
  </div>

  
</div>

<div  class="breadcrumb-section color-background-1 gradient  ">
  <div class=" page-full-width   page-full-width_spacing ">
   <div class="row"> 
     <div class="support-block fashion2support color-background-1 gradient  no-heading">
         <div class=" page-width  section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding isolate">
           <div class="row">
           <support-slider>
             
             <div id="icon1" class="swiper" data-swiper-slider><div id="Slider-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26"
                 class="support-block-list contains-content-container slider  swiper-wrapper fix"
                 role="list"
               ><div id="Slide-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-1" class="support-block-list__item color-background-2 gradient  swiper-slide center  grid__items" >
                   <div id="icon4" class="support-block-card content-container veritcal_center">
                  
                       <div  class="support-block-card__image-wrapper  color- gradient ">
                       
       <img src="//toytime-theme.myshopify.com/cdn/shop/files/Group_141021.png?v=1707976219&amp;width=275" srcset="//toytime-theme.myshopify.com/cdn/shop/files/Group_141021.png?v=1707976219&amp;width=275 275w" loading="lazy" sizes="(min-width: 990px) 550px, (min-width: 750px) 550px, calc(100vw - 30px)" class="support-block-card__image"> 
       </div>              
                     <div class="support-block-card__info"><h3 class="support-title">Flexible Payment</h3><div class="rte"><p>Providing multiple payment methods such as credit cards, bank transfers, e-wallets, or installment payments through financial services</p></div></div>
                   </div>
                 </div>
             </div>
           </div>
       </div>   
     </div>
      </div>
        
      <div  class="breadcrumb-section color-background-1 gradient  " >
        <div class=" page-full-width   page-full-width_spacing ">
         <div class="row"> 
           <div class="support-block fashion2support color-background-1 gradient  no-heading">
               <div class=" page-width  section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding isolate">
                 <div class="row">
                 <support-slider>
                   
                   <div id="icon5" class="swiper" data-swiper-slider><div id="Slider-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26"
                       class="support-block-list contains-content-container slider  swiper-wrapper"
                       role="list"
                     ><div id="Slide-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-1" class="support-block-list__item color-background-2 gradient  swiper-slide center  grid__items" >
                         <div class="support-block-card content-container veritcal_center">
                        
                             <div class="support-block-card__image-wrapper  color- gradient ">
                             
             <img src="//toytime-theme.myshopify.com/cdn/shop/files/Group_141020.png?v=1707976220&amp;width=275" srcset="//toytime-theme.myshopify.com/cdn/shop/files/Group_141020.png?v=1707976220&amp;width=275 275w" loading="lazy" sizes="(min-width: 990px) 550px, (min-width: 750px) 550px, calc(100vw - 30px)" class="support-block-card__image"> 
             </div>              
                           <div class="support-block-card__info"><h3 class="support-title">Online support</h3><div class="rte"><p>Customers can send inquiries or support requests via email and receive responses from support staff in a timely manner.</p></div></div>
                         </div>
                       </div>
                   </div>
                 </div>
             </div>   
           </div>
            </div> 



</section><section id="shopify-section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26" class="shopify-section section"><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/section-support-block.css?v=39698500543991474431708942415" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-slider.css?v=166414295792065203761708942415" media="print" onload="this.media='all'">
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-slider.css?v=166414295792065203761708942415" rel="stylesheet" type="text/css" media="all" /></noscript><style data-shopify>.section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding {
    padding-top: 40px;
    padding-bottom: 8px;
  }

  .support-block .support-block-card .support-block-card__image-wrapper svg.placeholder_svg { width: 60px; height: 60px;  }
  @media screen and (max-width: 480px) {
    .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding {
    padding-top: 20px;
    padding-bottom: 4px;
    }
  }
  @media screen and (min-width: 1201px) {
    .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding {
      padding-top: 80px;
      padding-bottom: 16px;
    }
  }
 .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding  .support-block-card .support-block-card__image-wrapper{
    
    height: 60px;
    
    
    }

.section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding   .support-block-card .support-block-card__image-wrapper img{
       width: auto; 
      height: px;
      object-fit: contain;   
   }
 .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding   .support-block-list__item.list__item .support-block-card .support-block-card__info{
     width:calc( 100% - px );
   }
   @media screen and (max-width: 576px) {
     /* .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding   .support-block-card .support-block-card__image-wrapper img{ height: 0px;} */
     /* .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding   .support-block-card .support-block-card__image-wrapper img{height:auto;} */
   
     .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding  .support-block-card .support-block-card__image-wrapper{ 
  
    height: 45px;
    
     }
     .fashion2support .section-template--17275203027176__61f84a49-ed0f-447f-ba5f-4285c285fe26-padding   .support-block-card .support-block-card__image-wrapper img{ height: px;}

   }</style>
      
        
    </div>
    
    </div>
    </support-slider><!--     <div class="center"></div> -->
    </div>
  </div>
</div>


</section>      
    </main> 
  
      <div id="shopify-section-footer" class="shopify-section">
        
<link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/section-footer.css?v=147143311404675742001710411579" rel="stylesheet" type="text/css" media="all" />
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-newsletter.css?v=24283018766086552221710143684" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-menu.css?v=67740596207655118111708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-payment.css?v=120513839681986052751708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-social.css?v=165443367683607913461708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-rte.css?v=164390173837475133831708942415" media="print" onload="this.media='all'">
<link rel="stylesheet" href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/disclosure.css?v=144609428849090764641708942415" media="print" onload="this.media='all'">

<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-newsletter.css?v=24283018766086552221710143684" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-menu.css?v=67740596207655118111708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-payment.css?v=120513839681986052751708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-list-social.css?v=165443367683607913461708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/component-rte.css?v=164390173837475133831708942415" rel="stylesheet" type="text/css" media="all" /></noscript>
<noscript><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/disclosure.css?v=144609428849090764641708942415" rel="stylesheet" type="text/css" media="all" /></noscript><style data-shopify>.footer {
    margin-top: 45px;
  }
  
    .section-footer-padding {
    padding-top: 46px;
    padding-bottom: 32px;
  }
   @media screen and (min-width: 576px) and (max-width: 749px){
   .section-footer-padding {
    padding-top: 69px;
    padding-bottom: 48px;
  }
   }
  @media screen and (max-width: 576px) {
    .footer {
    margin-top: 30px;
  }
  }
  
  @media screen and (min-width: 750px) {
    .footer {
      margin-top: 60px;
    }

    .section-footer-padding {
      padding-top: 92px;
      padding-bottom: 64px;
    }
  }
 .sections-index-template .footer {
    margin-top: 30px;
  }
  @media screen and (max-width: 480px) {
    .sections-index-template .footer {
    margin-top: 45px;
    }
  }
  @media screen and (min-width: 1201px) {
    .sections-index-template .footer {
    margin-top: 60px;
    }
  }
  .footer  .footer__blocks-wrapper{display:flex;justify-content:space-between;flex-wrap: wrap;row-gap:var(--grid-desktop-horizontal-spacing);}
  .footer .footer-text .footer-block__details-content{margin-top:15px;}@media screen and (min-width: 1200px) {
  .footer__item--bd27e402-31b6-4bd2-9c8f-b64d9598283f.footer-block{
    width:calc(38% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(38% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
    
}
   @media screen and (max-width: 1199px) and (min-width: 577px) {
  .footer__item--bd27e402-31b6-4bd2-9c8f-b64d9598283f.footer-block{
    width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
  .footer__item--bd27e402-31b6-4bd2-9c8f-b64d9598283f.footer-block.footer-newsletter{width:100%; max-width:100%;}
    }
   @media screen and (max-width: 576px)  {
  .footer__item--bd27e402-31b6-4bd2-9c8f-b64d9598283f.footer-block{
    width:100%;
    max-width:100%;
  } 
    }@media screen and (min-width: 1200px) {
  .footer__item--8c88a831-9d3f-4039-9e74-6f7b20caa8ff.footer-block{
    width:calc(16% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(16% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
    
}
   @media screen and (max-width: 1199px) and (min-width: 577px) {
  .footer__item--8c88a831-9d3f-4039-9e74-6f7b20caa8ff.footer-block{
    width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
  .footer__item--8c88a831-9d3f-4039-9e74-6f7b20caa8ff.footer-block.footer-newsletter{width:100%; max-width:100%;}
    }
   @media screen and (max-width: 576px)  {
  .footer__item--8c88a831-9d3f-4039-9e74-6f7b20caa8ff.footer-block{
    width:100%;
    max-width:100%;
  } 
    }@media screen and (min-width: 1200px) {
  .footer__item--3408e200-d33a-433c-bdd0-1d9c73fff07e.footer-block{
    width:calc(18% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(18% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
    
}
   @media screen and (max-width: 1199px) and (min-width: 577px) {
  .footer__item--3408e200-d33a-433c-bdd0-1d9c73fff07e.footer-block{
    width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
  .footer__item--3408e200-d33a-433c-bdd0-1d9c73fff07e.footer-block.footer-newsletter{width:100%; max-width:100%;}
    }
   @media screen and (max-width: 576px)  {
  .footer__item--3408e200-d33a-433c-bdd0-1d9c73fff07e.footer-block{
    width:100%;
    max-width:100%;
  } 
    }@media screen and (min-width: 1200px) {
  .footer__item--dc1fe050-cc87-40ca-bc4e-bdb5ee8f4ab7.footer-block{
    width:calc(22% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(22% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
    
}
   @media screen and (max-width: 1199px) and (min-width: 577px) {
  .footer__item--dc1fe050-cc87-40ca-bc4e-bdb5ee8f4ab7.footer-block{
    width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
    max-width:calc(33.3% - calc(var(--grid-desktop-horizontal-spacing) / 2));
  } 
  .footer__item--dc1fe050-cc87-40ca-bc4e-bdb5ee8f4ab7.footer-block.footer-newsletter{width:100%; max-width:100%;}
    }
   @media screen and (max-width: 576px)  {
  .footer__item--dc1fe050-cc87-40ca-bc4e-bdb5ee8f4ab7.footer-block{
    width:100%;
    max-width:100%;
  } 
    }</style>	<footer class="bg3 p-t-75 p-b-32 footer-res" >
		<div class="container" >
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
						Any questions? Let us know in store at 8th floor, 379 Hudson St, New York, NY 10018 or call us
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
					<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i
						class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com"
						target="_blank">Colorlib</a> &amp; distributed by <a href="https://themewagon.com"
						target="_blank">ThemeWagon</a>
					<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->

				</p>
			</div>
		</div>
	</footer><style data-shopify>.footer .footer-block-image{position:relative;}
  
</style>
</div> 
      
    
    <ul hidden>
      <li id="a11y-refresh-page-message">Choosing a selection results in a full page refresh.</li>
    </ul>

    <script>
      window.shopUrl = 'https://toytime-theme.myshopify.com';
      window.routes = {
        cart_add_url: '/cart/add',
        cart_change_url: '/cart/change',
        cart_update_url: '/cart/update',
        cart_url: '/cart',
        predictive_search_url: '/search/suggest'
      };

      window.cartStrings = {
        error: `There was an error while updating your cart. Please try again.`,
        quantityError: `You can only add [quantity] of this item to your cart.`
      }

      window.variantStrings = {
        addToCart: `Add to cart`,
        soldOut: `Sold out`,
        unavailable: `Unavailable`,
        unavailable_with_option: `[value] - Unavailable`,
      }

      window.accessibilityStrings = {
        imageAvailable: `Image [index] is now available in gallery view`,
        shareSuccess: `Link copied to clipboard`,
        pauseSlideshow: `Pause slideshow`,
        playSlideshow: `Play slideshow`,
      }
      
      var DT_THEME = {
        strings: {
          addToWishList: "wishlist",
          viewMyWishList: "View wishlist",             
          unavailable: "Unavailable",
          addToCompareList: "Translation missing: en.products.compare.addToCompareList",
          viewMyCompareList: "Translation missing: en.products.compare.viewMyCompareList",
          minCompareProductNav: "Translation missing: en.products.compare.minCompareProductNav",
          minCompareProduct: "Translation missing: en.products.compare.minCompareProduct",
          inventoryStatus: "Availability",
          in_stock: "In stock",
          
        },
        moneyFormat: "Rs. {{amount}}"        
      };      
        function debounce(func, timeout = 300){
        let timer;
        return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
      };
      }   
      new WOW().init();
    </script><script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/predictive-search.js?v=162273246065392412141708942415" defer="defer"></script><!-- Footer Scripts ================================ -->     
        
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/splitting.min.js?v=161123785925030483801708942415" defer="defer"></script>    
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/dt_wishlist.js?v=87123945011968281601708942415" defer="defer"></script>    
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/dt_compare.js?v=4216865400915853291708942415" defer="defer"></script>  
    <script src="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/dt-theme.js?v=166549269193297830551713417731" defer="defer"></script>   
    <div id="shopify-section-suggested-products" class="shopify-section customer-purchased">

<script type="text/javascript">
  if ($.cookie('dT_suggested-cookie') == 'closed') {
    $('.customer-who-purchased').remove();
  }

  $('.dT_close').bind('click',function(){
    $('.customer-who-purchased').remove();
    $.cookie('dT_suggested-cookie', 'closed', {expires:1, path:'/'});
  });      

  var elements = $('.customer-who-purchased li');
  var init_element = 0;
  var i = 0;
  //elements.css({top: 0,left: 0,}).fadeOut(1);
  elements.removeClass('active');
  function fadeInRandomElement() { 
    if ( i % 2 == 0) {
      var currentItem = elements.eq(init_element);      
      currentItem.addClass('active');
      setTimeout(function(){ 
        currentItem.removeClass('active')
      }, 8000);

      init_element++;
      if(elements.length == init_element) {
        init_element = 0;
      }

    }

    i++;

  }

  setInterval(function(){ 
    fadeInRandomElement();
  }, 8000);


</script>

<style type="text/css">

  .customer-who-purchased{  
    pointer-events: none;
    margin: 0;
    height: 129px;
    max-width: 350px;
    min-width: 350px;
    position: fixed;
    bottom: 20px;
    width: auto;
    z-index: 3;
    -webkit-transition: all 0.3s linear;
    transition: all 0.3s linear;
    padding:0;
        }

  .customer-who-purchased.text-left { left: 20px; }
  .customer-who-purchased.text-right { right: 20px; }

  .customer-who-purchased .product-data {
    display: flex;
    justify-content:space-between;
    height: auto;
    margin: 0;
    opacity: 0;
    padding: 12px;
    position: absolute;
    bottom: 0px;
    left: 0;
/*     visibility: hidden; */
    width: 100%;
    border-radius:0;
    align-items:center;
    pointer-events: none;
    transform: translateX(-100px) scale(.8);
    transition: all .5s;
      }
  .customer-who-purchased .product-data:before {
   background-color:var(--gradient-base-background-2);
   content: "";
    display: block;
    height: auto;
/*     margin: -15px -25px; */
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    top: 0;
    width: auto;
    z-index: -1;
    border-radius: 15px;
    -webkit-box-shadow: 0 0 30px rgb(0 0 0 / 15%);
    box-shadow:0 0 30px rgb(0 0 0 / 15%);
          }

  .customer-who-purchased .product-data.active { pointer-events: all; opacity: 1;  transform: translateX(0) scale(1); }
  .customer-who-purchased .product-data p { font-size: 12px; line-height: normal;margin:0; }
  .customer-who-purchased .product-data p span {
    display: inline;
    padding: 0px; 
  }
  .customer-who-purchased .product-data p  span.verified {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 6px;
    padding: 0px; 
  }
.customer-who-purchased .timing-content {
    display: grid;
    justify-content: center;
    align-items: center;
    gap: 55px;
    grid-template-columns: repeat(2,1fr);
}

  .customer-who-purchased .product-data span.title, 
  .customer-who-purchased .product-data p span.location { font-weight: 400; }  

  .customer-who-purchased .product-data p span.purchased { padding-left: 0;color:var(--gradient-base-accent-2);font-size:12px;font-weight:400; }

  .customer-who-purchased .product-data p span.timing {     
    font-size: 12px;
    font-weight: 400;
/*     position: absolute;
    bottom: -10px;
    right: -10px; */
    color: var(--gradient-base-accent-2); }
    .customer-who-purchased .product-data p.timing-data{margin-top:0px}

  .customer-who-purchased .product-data .product-image a img {
    width: 100%;
    height:100%;
   border-radius:11px;object-fit: contain;
  }

  .customer-who-purchased .product-data .dT_close {
    height: auto;
    position: absolute;
    right: 18px;
    top: 18px;
    text-align: center;
    width: auto;
    pointer-events: all;
    
      }
 .customer-who-purchased .product-image {
     padding-right: 13px;
     width:105px;
     height:105px;
   }
  .customer-who-purchased .product-data .dT_close svg { 
    height: 12px;
/*     position: absolute; 
    right: 10px; 
    top: 10px;  */
    width: 12px;
    fill:currentcolor;
    transition: all 0.3s linear;
  }
  .customer-who-purchased .product-data .dT_close:hover  {
    color:rgb(var(--color-base-outline-button-labels));
  }
  @media (max-width:450px) {
    .customer-who-purchased{
      left: 0 !important;
      right: 0!important;
      margin: auto;
    }
  }
  @media (max-width:1540px) {
 .customer-who-purchased.text-left { left: 20px; }
  .customer-who-purchased{ bottom:20px}  
  }
.customer-who-purchased .product-data span.title {
    color: var(--gradient-base-accent-1);
    transition: all 0.3s linear;
    font-size:18px;
    font-weight:700;
    line-height:normal;
    font-family: var(--font-heading-family);
    margin:0;
    display: inline-block;
}
 .customer-who-purchased .product-content {
    display: flex;
    justify-content: space-between;
    flex-direction: column;
    gap: 20px;
}
 .customer-who-purchased .product-data span.title:hover {
    color: rgb(var(--color-base-outline-button-labels));
} 
  .enquiry-overlay .customer-who-purchased {
        opacity: 0;
}
  @media (max-width:749px) {
  .customer-who-purchased{ bottom:80px}  
   }
  @media (max-width:480px) {
  .customer-who-purchased{display:none;}
    }
</style>



</div>
    <div id="shopify-section-cookie-banner" class="shopify-section gdpr-section">  
  <div class="cookie-disclaimer bottom" > 
    <div class="cookie-content color-background-1 gradient">
      <div class="cookie-text-wrapper">
        
        <div class="cookie-text">
      <h4>We care about your privacy</h4>
      <p>This website uses cookie to ensure you to get the best experience on our website.</p>
       </div>  
      </div>
      <div class="cookie-button">
      <button type="button" class="button accept-cookie  button--secondary">Cookie policy</button>
      <button type="button" class="button decline-cookie">Allow cookies</button>  
      </div>
    </div>
  </div>

  <style>
    .cookie-disclaimer {display:none;}
    .cookie-disclaimer .cookie-content p {
      font-size:16px;
      margin-bottom: 10px;
      text-align:left;
      line-height: 26px;
    }
    .cookie-disclaimer .cookie-content {
      position: fixed;
      max-width: 380px;
      bottom: 15px; 
      padding: 20px 25px; 
      z-index: 100;
      display: flex; 
      flex-wrap: wrap; 
      align-items: center;
      justify-content: flex-end;
      text-align: center;
      box-shadow: var(--popup-shadow-horizontal-offset) var(--popup-shadow-vertical-offset) var(--popup-shadow-blur-radius) rgba(var(--color-shadow),var(--popup-shadow-opacity));
      border-radius: var(--buttons-radius);    
    }
    .cookie-disclaimer .cookie-content > * {
      margin: 0px; 
    }
    .cookie-disclaimer.bottom .cookie-content {
      bottom: 0; 
      left: 0;
      right: 0; 
      padding:10px 0; 
      max-width: 100%;
      border-radius:0;
      justify-content: space-between;
      padding: 30px 40px;
    }
    .cookie-disclaimer.bottom .cookie-text-wrapper{display:flex;align-items:center;}
    .cookie-disclaimer.bottom .cookie-text-wrapper .cookie-text{text-align:left; margin-left: 15px;}
    .cookie-disclaimer.bottom .cookie-text-wrapper .cookie-text h4{margin:0; font-weight:500; font-size:2.4rem; line-height: 34px;}
    .cookie-disclaimer.bottom .cookie-text-wrapper .cookie-text p{margin:0;}
    /* .cookie-disclaimer button.button.accept-cookie {
    background: transparent;
    color: var(--gradient-base-accent-1);
} */
    .cookie-disclaimer button:after, .gdpr-section .cookie-disclaimer button:hover:after,
    .cookie-disclaimer .button.button--secondary:after{box-shadow:none;}
    .cookie-disclaimer.left .cookie-content {
      left: 15px;
      right: auto; 
    }
    .cookie-disclaimer.right .cookie-content {
      left: auto;
      right: 15px; 
    }
    .cookie-disclaimer .cookie-content button {
    font-size:16px;
    padding:14px 33px 14px 33px;
    min-width: calc(14rem + var(--buttons-border-width) * 2);
    min-height: calc(4.3rem + var(--buttons-border-width) * 2);
    transition: all 0.3s linear;
    }
   
    .cookie-disclaimer.left .cookie-content{flex-direction: column;}

    @media screen and (max-width: 767px){

      /* .cookie-disclaimer .cookie-content {
        left: 0 !important;
        right: 0 !important;
        max-width: 100%;
        bottom: 0; 
      } */
      .cookie-disclaimer .cookie-content > p {width: 100%;}
      .cookie-disclaimer.right .cookie-content { left: auto; right: 0; bottom: 0;}
       .cookie-disclaimer.left .cookie-content { left: 0; right: auto; bottom: 0;}    
    }
    @media screen and (max-width: 400px){
    .cookie-disclaimer .cookie-content button{padding:10px;}
    .cookie-disclaimer .cookie-content{bottom:0;}  
    .cookie-disclaimer.right .cookie-content{left:0; right:0;} 
    .cookie-disclaimer.left .cookie-content{left:0; right:0;}   
    }
    @media screen and (max-width: 1200px){
      .cookie-disclaimer .cookie-content p{    font-size: 14px;}
      .cookie-disclaimer .cookie-content button {
    font-size: 14px;
    padding: 14px 15px 14px 15px;
    min-width: calc(14rem + var(--buttons-border-width) * 2);
    min-height: calc(3.2rem + var(--buttons-border-width) * 2);
    transition: all 0.3s linear;
}
    .cookie-disclaimer.bottom .cookie-content{    padding: 15px;}
    }
 @media screen and (max-width: 928px){
    .cookie-disclaimer.bottom .cookie-text-wrapper{margin-bottom: 1rem;}
   .cookie-disclaimer.bottom .cookie-text-wrapper .cookie-text{text-align:center;}
   .cookie-disclaimer.bottom .cookie-content{justify-content:center; flex-direction:column;}
   .cookie-disclaimer .cookie-content p{text-align:center;}
   .cookie-disclaimer.bottom .cookie-text-wrapper{    display: flex; flex-direction: column; align-items: center;}
 }
 @media screen and (max-width: 576px){
   .cookie-disclaimer .cookie-content button{ font-size: 12px; padding: 10px;}
   .cookie-disclaimer.bottom .cookie-text-wrapper{flex-direction:column;}
   .cookie-disclaimer.bottom .cookie-text-wrapper { flex-direction: column;  align-items: center;}
   .cookie-disclaimer.bottom .cookie-text-wrapper .cookie-text { text-align: center; margin-top: 10px; margin-left: 0;}
   .cookie-disclaimer.bottom .cookie-content{padding:20px 10px;}
   .cookie-button{ display: flex; gap: 10px;}
 }    
  .cookie-disclaimer.bottom .cookie-text-wrapper img{width:49px; height:49px;}  
  </style>

  <script type="text/javascript">

  jQuery(document).ready(function() { 
    var cookie = false;
    var cookieContent = $('.cookie-disclaimer');
    
    checkCookie();

    if (cookie === false) {
      cookieContent.css("display","flex");
    }
    
    if (cookie === true) {
      cookieContent.css("display","none");
    }
    
    function setCookie(cname, cvalue, exdays) {
  		var d = new Date();
  		d.setTime(d.getTime() + (exdays*24*60*60*1000));
  		var expires = "expires="+ d.toUTCString();
  		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    	console.log(cname + "=" + cvalue + ";" + expires + ";path=/");
	}
    
    function getCookie(cname) {
  		var name = cname + "=";
  		var decodedCookie = decodeURIComponent(document.cookie);
  		var ca = decodedCookie.split(';');
  		for(var i = 0; i < ca.length; i++) {
    	var c = ca[i];
    	while (c.charAt(0) == ' ') {
      	c = c.substring(1);
    	}
    	if (c.indexOf(name) == 0) {
      		return c.substring(name.length, c.length);
    	}
  		}
  		return "";
	}
    
    function checkCookie() {
      var user = getCookie("hldn_consent_choice");
      if (user !== "") {        
        cookie = true;
        if (user === "accepted") {                  
        }
      }
    }

    $('.accept-cookie').click(function () {
      setCookie("hldn_consent_choice", "accepted", 365);
      cookieContent.css("display","none");
    });

    $('.decline-cookie').click(function () {    
      setCookie("hldn_consent_choice", "declined", 365);
      cookieContent.css("display","none");
    });
  });
   
  </script>
  
  </div>    
    
<a id="to-top" href="#faq" class="dt-sc-to-top">
  <div class="scroll-text">
    <svg xmlns="http://www.w3.org/2000/svg" width="55" height="57" viewBox="0 0 55 57" fill="none">
  <path d="M28.1372 50.4229V55.2106H29V56.1512H26.0086V55.2106H26.8643V50.4229H28.1372Z" fill="currentcolor"/>
  <path d="M18.0311 48.1784C18.4177 48.3645 18.6908 48.5798 18.8504 48.8241C19.0101 49.0684 19.0774 49.3416 19.0524 49.6435C19.0273 49.9454 18.9299 50.2726 18.7601 50.6252L17.8366 52.543C17.6647 52.8998 17.4696 53.18 17.2512 53.3836C17.0328 53.5872 16.7794 53.7006 16.4908 53.7238C16.2003 53.7514 15.8617 53.672 15.4751 53.4859C15.0844 53.2977 14.8091 53.0814 14.6495 52.8371C14.4835 52.5949 14.412 52.325 14.435 52.0274C14.458 51.7297 14.5554 51.4025 14.7272 51.0457L15.6508 49.1278C15.8206 48.7753 16.0157 48.4951 16.2361 48.2873C16.4566 48.0794 16.7142 47.9628 17.009 47.9373C17.2996 47.9098 17.6403 47.9902 18.0311 48.1784ZM17.6414 48.9876C17.5225 48.9303 17.4211 48.9181 17.3372 48.9509C17.2534 48.9838 17.1805 49.0429 17.1185 49.1282C17.0565 49.2134 17.0019 49.3049 16.9549 49.4026L15.7582 51.8875C15.7091 51.9895 15.6716 52.0891 15.6456 52.1865C15.6176 52.2882 15.6169 52.382 15.6435 52.4681C15.6701 52.5541 15.7428 52.6258 15.8618 52.6831C15.9722 52.7363 16.0694 52.7464 16.1532 52.7135C16.2371 52.6807 16.31 52.6216 16.372 52.5363C16.4319 52.4553 16.4865 52.3638 16.5356 52.2619L17.7322 49.777C17.7793 49.6793 17.8189 49.5806 17.8512 49.481C17.8792 49.3794 17.882 49.2866 17.8597 49.2026C17.8331 49.1165 17.7604 49.0448 17.6414 48.9876Z" fill="currentcolor"/>
  <path d="M7.97975 44.2897L8.08348 45.0663L7.20205 45.118L7.44715 45.8903L6.7521 46.119L6.62297 45.3446L6.03339 45.9323L5.49546 45.2578L6.19968 44.8138L5.469 44.51L5.85211 43.8789L6.555 44.2952L6.79156 43.4463L7.53442 43.7313L7.1688 44.4751L7.97975 44.2897Z" fill="currentcolor"/>
  <path d="M6.27546 33.9964L1.60781 35.0617L1.7998 35.9029L0.882812 36.1122L0.217158 33.1958L1.13414 32.9865L1.32455 33.8207L5.99221 32.7554L6.27546 33.9964Z" fill="currentcolor"/>
  <path d="M6.21155 23.6472C6.11608 24.0655 5.967 24.3797 5.76431 24.5897C5.56163 24.7997 5.31033 24.9262 5.01041 24.9689C4.7105 25.0117 4.36979 24.9895 3.98829 24.9025L1.91301 24.4288C1.52691 24.3407 1.21033 24.2128 0.963274 24.0452C0.716215 23.8776 0.549243 23.6557 0.462356 23.3796C0.370874 23.1024 0.372866 22.7547 0.468335 22.3364C0.564852 21.9135 0.714454 21.5971 0.917141 21.387C1.11628 21.1713 1.36351 21.0416 1.65883 20.9978C1.95414 20.9539 2.29485 20.9761 2.68095 21.0642L4.75623 21.5379C5.13773 21.625 5.45431 21.7528 5.70596 21.9215C5.95762 22.0902 6.12867 22.3154 6.2191 22.5972C6.31058 22.8743 6.30806 23.2244 6.21155 23.6472ZM5.33593 23.4474C5.36531 23.3187 5.35464 23.2171 5.30393 23.1427C5.25321 23.0682 5.1794 23.0103 5.08247 22.9688C4.98555 22.9274 4.88423 22.8946 4.77851 22.8704L2.08961 22.2567C1.9793 22.2315 1.87378 22.2171 1.77306 22.2135C1.66774 22.2088 1.57609 22.229 1.4981 22.274C1.42011 22.3191 1.36643 22.406 1.33706 22.5347C1.30978 22.6542 1.3215 22.7511 1.37221 22.8256C1.42292 22.9 1.49674 22.958 1.59366 22.9994C1.68599 23.0399 1.78731 23.0727 1.89762 23.0978L4.58652 23.7116C4.69224 23.7357 4.79723 23.7524 4.9015 23.7617C5.00682 23.7664 5.09795 23.7485 5.17489 23.708C5.25288 23.663 5.30656 23.5761 5.33593 23.4474Z" fill="currentcolor"/>
  <path d="M9.36916 16.0788L4.89062 12.5073L6.08995 11.0034C6.30453 10.7343 6.53251 10.5543 6.77387 10.4633C7.01155 10.3695 7.26188 10.358 7.52484 10.429C7.78413 10.4971 8.05199 10.6414 8.32845 10.8619C8.67493 11.1382 8.89477 11.4069 8.98794 11.6682C9.07743 11.9265 9.0793 12.1812 8.99354 12.4325C8.90778 12.6837 8.7679 12.9309 8.57389 13.1742L8.25642 13.5723L10.1584 15.0891L9.36916 16.0788ZM7.56529 13.0211L7.82985 12.6894C7.92685 12.5677 7.97822 12.458 7.98396 12.36C7.9897 12.2621 7.95569 12.1686 7.88192 12.0796C7.81109 11.987 7.70749 11.8863 7.5711 11.7775C7.45684 11.6864 7.34996 11.6162 7.25049 11.5671C7.15027 11.5112 7.04937 11.4941 6.94779 11.5156C6.84621 11.5371 6.74251 11.6142 6.63669 11.7469L6.37654 12.0731L7.56529 13.0211Z" fill="currentcolor"/>
  <path d="M16.4486 5.95683L15.6684 5.88515L15.8141 5.01432L15.0066 5.0814L14.9383 4.3529L15.722 4.39933L15.2802 3.69374L16.0575 3.3194L16.3337 4.10476L16.7924 3.46L17.3225 3.97395L16.7602 4.56657L17.5352 4.98611L17.0921 5.64692L16.4483 5.12495L16.4486 5.95683Z" fill="currentcolor"/>
  <path d="M26.8706 6.57701V1.78932L26.0078 1.78932V0.848755L28.9992 0.848755V1.78932L28.1435 1.78932V6.57701L26.8706 6.57701Z" fill="currentcolor"/>
  <path d="M36.9767 8.82146C36.5902 8.63531 36.317 8.42006 36.1574 8.17572C35.9977 7.93137 35.9304 7.65825 35.9554 7.35633C35.9805 7.05442 36.0779 6.72719 36.2477 6.37462L37.1713 4.45678C37.3431 4.09997 37.5382 3.81978 37.7566 3.61622C37.975 3.41265 38.2284 3.29923 38.517 3.27597C38.8076 3.24846 39.1461 3.32778 39.5327 3.51393C39.9235 3.70212 40.1987 3.91839 40.3584 4.16274C40.5243 4.40488 40.5958 4.67478 40.5728 4.97244C40.5498 5.27011 40.4524 5.59735 40.2806 5.95415L39.357 7.872C39.1872 8.22456 38.9921 8.50475 38.7717 8.71256C38.5512 8.92038 38.2936 9.03702 37.9988 9.06248C37.7082 9.08999 37.3675 9.00965 36.9767 8.82146ZM37.3664 8.01226C37.4853 8.06954 37.5867 8.08174 37.6706 8.04887C37.7544 8.01599 37.8274 7.95692 37.8894 7.87165C37.9513 7.78638 38.0059 7.6949 38.0529 7.5972L39.2496 5.11229C39.2987 5.01034 39.3362 4.91068 39.3622 4.81329C39.3902 4.71166 39.3909 4.61782 39.3643 4.53175C39.3377 4.44569 39.265 4.37403 39.1461 4.31675C39.0356 4.26356 38.9385 4.25341 38.8546 4.28628C38.7707 4.31916 38.6978 4.37823 38.6358 4.4635C38.5759 4.54452 38.5214 4.636 38.4723 4.73795L37.2756 7.22286C37.2285 7.32056 37.1889 7.4192 37.1566 7.51879C37.1286 7.62042 37.1258 7.71324 37.1481 7.79726C37.1747 7.88332 37.2474 7.95499 37.3664 8.01226Z" fill="currentcolor"/>
  <path d="M47.0281 12.7102L46.9243 11.9336L47.8058 11.8819L47.5607 11.1095L48.2557 10.8809L48.3848 11.6553L48.9744 11.0675L49.5124 11.7421L48.8081 12.1861L49.5388 12.4898L49.1557 13.121L48.4528 12.7046L48.2163 13.5536L47.4734 13.2686L47.839 12.5248L47.0281 12.7102Z" fill="currentcolor"/>
  <path d="M48.7323 23.0036L53.4 21.9382L53.208 21.0971L54.125 20.8878L54.7907 23.8042L53.8737 24.0135L53.6833 23.1792L49.0156 24.2446L48.7323 23.0036Z" fill="currentcolor"/>
  <path d="M48.7963 33.3526C48.8917 32.9344 49.0408 32.6202 49.2435 32.4102C49.4462 32.2001 49.6975 32.0737 49.9974 32.031C50.2973 31.9882 50.638 32.0103 51.0195 32.0974L53.0948 32.5711C53.4809 32.6592 53.7975 32.7871 54.0445 32.9547C54.2916 33.1223 54.4586 33.3442 54.5455 33.6203C54.6369 33.8975 54.6349 34.2452 54.5395 34.6635C54.443 35.0864 54.2934 35.4028 54.0907 35.6129C53.8915 35.8285 53.6443 35.9583 53.349 36.0021C53.0537 36.0459 52.713 36.0238 52.3269 35.9357L50.2516 35.462C49.8701 35.3749 49.5535 35.247 49.3018 35.0784C49.0502 34.9097 48.8791 34.6845 48.7887 34.4027C48.6972 34.1255 48.6997 33.7755 48.7963 33.3526ZM49.6719 33.5525C49.6425 33.6812 49.6532 33.7828 49.7039 33.8572C49.7546 33.9316 49.8284 33.9896 49.9253 34.0311C50.0223 34.0725 50.1236 34.1053 50.2293 34.1295L52.9182 34.7432C53.0285 34.7684 53.134 34.7828 53.2348 34.7864C53.3401 34.7911 53.4317 34.7709 53.5097 34.7259C53.5877 34.6808 53.6414 34.5939 53.6708 34.4652C53.698 34.3457 53.6863 34.2487 53.6356 34.1743C53.5849 34.0998 53.5111 34.0419 53.4142 34.0004C53.3218 33.96 53.2205 33.9272 53.1102 33.902L50.4213 33.2883C50.3156 33.2642 50.2106 33.2475 50.1063 33.2382C50.001 33.2335 49.9099 33.2514 49.8329 33.2918C49.7549 33.3369 49.7013 33.4238 49.6719 33.5525Z" fill="currentcolor"/>
  <path d="M45.6387 40.9212L50.1172 44.4927L48.9179 45.9966C48.7033 46.2657 48.4753 46.4457 48.2339 46.5366C47.9963 46.6305 47.7459 46.6419 47.483 46.5709C47.2237 46.5028 46.9558 46.3585 46.6794 46.1381C46.3329 45.8618 46.113 45.593 46.0199 45.3318C45.9304 45.0734 45.9285 44.8187 46.0143 44.5675C46.1 44.3163 46.2399 44.069 46.4339 43.8257L46.7514 43.4277L44.8494 41.9109L45.6387 40.9212ZM47.4425 43.9788L47.178 44.3106C47.081 44.4322 47.0296 44.542 47.0239 44.6399C47.0181 44.7379 47.0521 44.8313 47.1259 44.9203C47.1967 45.013 47.3003 45.1137 47.4367 45.2224C47.551 45.3136 47.6578 45.3837 47.7573 45.4329C47.8575 45.4887 47.9584 45.5058 48.06 45.4843C48.1616 45.4628 48.2653 45.3857 48.3711 45.253L48.6313 44.9268L47.4425 43.9788Z" fill="currentcolor"/>
  <path d="M38.5593 51.0431L39.3395 51.1148L39.1937 51.9856L40.0012 51.9185L40.0695 52.647L39.2858 52.6006L39.7276 53.3062L38.9503 53.6805L38.6741 52.8952L38.2154 53.5399L37.6853 53.026L38.2476 52.4334L37.4726 52.0138L37.9157 51.353L38.5596 51.875L38.5593 51.0431Z" fill="currentcolor"/>
</svg>
  </div>
  <div class="arrow">
    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="19" viewBox="0 0 21 19" fill="none">
      <path d="M10.5 18.9651C11.2893 18.9651 11.9286 18.3259 11.9286 17.5366L11.9286 4.91515L18.0607 11.0473C18.6179 11.6044 19.5214 11.6044 20.0821 11.0473C20.3607 10.7687 20.5 10.4044 20.5 10.0366C20.5 9.66872 20.3607 9.30443 20.0821 9.02586L11.5107 0.454435C11.4429 0.386577 11.3714 0.329435 11.2929 0.275863C11.2571 0.250864 11.2214 0.236579 11.1821 0.21515C11.1357 0.190151 11.0929 0.161577 11.0464 0.14372C11 0.125864 10.95 0.111578 10.9 0.0972915C10.8607 0.0865779 10.8214 0.0687213 10.7786 0.0615783C10.5929 0.0258632 10.4036 0.0258632 10.2179 0.0615783C10.175 0.0687213 10.1357 0.0865779 10.0964 0.0972915C10.0464 0.111578 10 0.122291 9.95 0.14372C9.90357 0.165149 9.85714 0.190151 9.81429 0.21515C9.77857 0.236579 9.73929 0.250864 9.70357 0.275863C9.625 0.329435 9.55357 0.386577 9.48571 0.454435L0.917857 9.02586C0.360714 9.58301 0.360714 10.4901 0.917857 11.0473C1.475 11.6044 2.37857 11.6044 2.93929 11.0473L9.07143 4.91515L9.07143 17.5366C9.07143 18.3259 9.71071 18.9651 10.5 18.9651Z" fill="currentcolor"/>
    </svg>
  </div>
      
</a>
 


<style data-shopify> 
   .dt-sc-to-top.show {
  bottom: 15px;
  opacity: 1;
}
.dt-sc-to-top > div {
  -webkit-transition: all 0.3s ease-in-out;
  -moz-transition: all 0.3s ease-in-out;
  -ms-transition: all 0.3s ease-in-out;
  -o-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
}  
.dt-sc-to-top > div.arrow {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translateY(-50%) translateX(-50%);
  opacity: 1;
  display: flex;
  align-items: center;
}
.dt-sc-to-top > div.text {
  font-size: 0.8rem;
  line-height: 10px;
  text-transform: uppercase;
  font-weight: 600;
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translateY(50%) translateX(-50%);
  opacity: 0;
  margin-top: 1px;
}
.dt-sc-to-top:hover {
  transform: scale(1.05);
  bottom: 20px;
  cursor: pointer;
  background: black;
  box-shadow: 0 10px 5px rgba(0, 0, 0, 0.1);
}
/* .dt-sc-to-top:hover > div.arrow {
  transform: translateY(-150%) translateX(-50%);
  opacity: 0;
}
.dt-sc-to-top:hover > div.text {
  transform: translateY(-50%) translateX(-50%);
  opacity: 1;
} */
.dt-sc-to-top .scroll-text{
    position: absolute;
    left: 50%;
    width: 55px;
    height: 55px;
    display: flex;
    justify-content: center;
    align-items: center;
    top: 50%;
    transform: translate(-50%, -50%);
    
}
a#to-top.dt-sc-to-top .scroll-text svg{width: 55px;height: 55px;border-radius: 50%;
   -webkit-animation:spin 4s linear infinite;
    -moz-animation:spin 4s linear infinite;
    animation:spin 4s linear infinite;}
a#to-top.dt-sc-to-top:hover .scroll-text svg{animation-play-state:paused;}

  
   @-moz-keyframes spin { 
    100% { -moz-transform: rotate(360deg); } 
}
@-webkit-keyframes spin { 
    100% { -webkit-transform: rotate(360deg); } 
}
@keyframes spin { 
    100% { 
        -webkit-transform: rotate(360deg); 
        transform:rotate(360deg); 
    } 
}
  
@-webkit-keyframes AnimationName {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
@-moz-keyframes AnimationName {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
@keyframes AnimationName {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}
  body.overflow-hidden-mobile #to-top{z-index:0;}
 </style> 
<script type="text/javascript">
  
 $(document).ready(function () {                                                            
  $('#to-top').on('click', function (e) {
    e.preventDefault();
    
    var target = this.hash;
    var $target = $(target);
    $('html, body').stop().animate({
      'scrollTop': $target.offset().top
    }, 900, 'swing');
    
    
  });                    

});

$(window).scroll(function(event){
  	var scroll = $(window).scrollTop();
    if (scroll >= 800) {
        $(".dt-sc-to-top").addClass("show");
    } else {
        $(".dt-sc-to-top").removeClass("show");
    }
});




</script>
    <div id="shopify-section-newsletter-modal" class="shopify-section dt-sc-newsletter-modal-overlay"><link href="//toytime-theme.myshopify.com/cdn/shop/t/4/assets/model-newsletter-section.css?v=17334636124362220861708942558" rel="stylesheet" type="text/css" media="all" />



  </div>  
    <div class="alert-overlay" style="display:none" id="compareModal">  
<div class="main-content">
<p>You will not be allowed to compare more than 4 products at a time</p>
<a href="/pages/compare" class="button">View compare</a>
<span class="closebtn" id="compareModalClose"> 
  <svg id="Group_24924" data-name="Group 24924" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18" height="18" viewBox="0 0 25 25">
            <defs>
            <clipPath id="clip-path">
            <rect id="Rectangle_8252" data-name="Rectangle 8252" width="18" height="18" fill="currentcolor"/>
            </clipPath>
            </defs>
            <g id="Group_24923" data-name="Group 24923" >
            <path id="Path_38934" data-name="Path 38934" d="M23.214,25a1.78,1.78,0,0,1-1.263-.523L.523,3.048A1.786,1.786,0,0,1,3.048.523L24.477,21.952A1.786,1.786,0,0,1,23.214,25" transform="translate(0)"  fill="currentcolor"/>
            <path id="Path_38935" data-name="Path 38935" d="M1.786,25A1.786,1.786,0,0,1,.523,21.952L21.952.523a1.786,1.786,0,1,1,2.525,2.525L3.048,24.477A1.78,1.78,0,0,1,1.786,25" transform="translate(0 0)"  fill="currentcolor"/>
            </g>
            </svg> 
         </span> 
</div>   
</div>  
    <div class="mobile-toolbar__icons icon-res"> 
  <div class="mobile-toolbar">
    
   <a href="/" class="header__icon header__icon--home link">
   <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
   <path d="M24.1081 10.9814V25.1061C24.1081 25.9041 23.4618 26.5504 22.6638 26.5504H19.7754C18.9774 26.5504 18.3311 25.9041 18.3311 25.1061V22.2177C18.3311 20.6218 17.0385 19.3292 15.4426 19.3292H12.5541C10.9582 19.3292 9.66565 20.6218 9.66565 22.2177V25.1061C9.66565 25.9041 9.01935 26.5504 8.2214 26.5504H5.33292C4.53497 26.5504 3.88867 25.9041 3.88867 25.1061V10.9814" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
   <path d="M1 13.5521L12.0809 2.79614C13.175 1.73462 14.825 1.73462 15.919 2.79614L27 13.5521" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
   </svg>
     <span class="icon-text">Home</span>
   </a>
   <a href="/collections" class="header__icon header__icon--shop link">
  <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
  <path d="M26.9964 14.9982H1L2.04343 8.74467C2.27451 7.35097 3.4805 6.33276 4.89225 6.33276H23.1078C24.5195 6.33276 25.7255 7.35459 25.9566 8.74467L27 14.9982H26.9964Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M2.44385 2H25.5517" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M2.44385 14.9982V22.2194C2.44385 23.8153 3.73645 25.1079 5.33233 25.1079H13.9978C15.5937 25.1079 16.8863 23.8153 16.8863 22.2194V14.9982" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  <path d="M25.5522 14.9982V25.1079" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
  </svg>  
  <span class="icon-text">Shop</span>
   </a>
  
  <a href="/pages/wishlist" class="header__icon header__icon--wishlist link">
               <div class="icon-with-count"> 
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M14.0049 7.14229C14.2049 6.89288 16.9785 3.53895 20.5819 4.13951C23.3687 4.60224 25.0053 7.15217 25.5453 8.44846C27.3053 12.6721 23.8485 17.9393 17.0384 23.8629C15.295 25.379 12.5916 25.379 10.8482 23.8629C4.06472 17.959 0.704572 12.7639 2.46129 8.54032C3.0013 7.24403 4.63806 4.5333 7.42481 4.07057C11.0282 3.47001 13.8016 6.89288 14.0017 7.14558L14.0049 7.14229Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
               </svg>

                <mobile-dtx-wish-count class="mobile-dtxc-wishlist-count cart-count-bubble" grid_type="wishList" count="0">
                  <div class="grid-count-bubble">
                    <span aria-hidden="true"></span>
                  </div>
                </mobile-dtx-wish-count>
               </div>
                <span class="icon-text">Wishlist</span>
              </a>

              <a href="/account/login" class="header__icon link ">
                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M14 15.1429C17.6293 15.1429 20.5714 12.2007 20.5714 8.57143C20.5714 4.94213 17.6293 2 14 2C10.3707 2 7.42859 4.94213 7.42859 8.57143C7.42859 12.2007 10.3707 15.1429 14 15.1429Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                  <path d="M2 26C2 19.9984 5.18545 15.1428 11.8182 15.1428H16.1818C22.8145 15.1428 26 19.9984 26 26" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                </svg>
               <span class="icon-text">Log in</span>
              </a>
               
   </div>
</div>
<style>
  .mobile-toolbar__icons  {display:flex;justify-content:center;}
  .mobile-toolbar__icons svg {width:16px;height:16px;}
  .mobile-toolbar__icons {
    display: flex;
    justify-content: center;
    position: sticky;
    width: 100%;
    bottom: 0;
    background: var(--gradient-base-background-1);
    z-index: 2;
    box-shadow: 0 0 10px #1a1a1a26;
}
  .mobile-toolbar__icons .header__icon {height: 100%;width: auto;margin:0!important;display: flex;
    flex-direction: column;
    text-transform: capitalize;padding:14px 0;}
  .mobile-toolbar__icons .mobile-toolbar{padding: 0;display: grid;grid-template-columns: repeat(4, 1fr);width: 100%;}
  .mobile-toolbar__icons .mobile-toolbar .header__icon .icon-text{line-height:14px;font-size:14px;font-weight:400;margin-top:7px;height: fit-content;}
  .mobile-toolbar__icons .header__icon:not(:last-child){border-right:1px solid rgba(var(--color-base-accent-1), 0.2);}
  .mobile-toolbar__icons .header__icon .mobile-dtxc-wishlist-count.cart-count-bubble{top: -2px;right: -7px;}
  .mobile-toolbar__icons .header__icon .icon-with-count{position:relative;display: flex;}
  .mega-full-width-active.overflow-hidden-tablet .mobile-toolbar__icons {z-index: 1;}
  @media screen and (min-width: 750px) {
    .mobile-toolbar__icons {display:none;}
  }
  .overflow-hidden-tablet .mobile-toolbar__icons{z-index:1;}
</style>          
    <div class="video-popup">
      <a class="pop-up__video-close close">&times;</a>  
      <div class="video-wrapper">
        <div class="video-container">
          <iframe id="video-popup-iframe" width="860" height="615"  src="" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
      </div>
    </div>
  <style> .bg-color-coal-black {background-color: #36454f;} </style>
</body>
</html>
