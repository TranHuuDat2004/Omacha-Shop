-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th6 24, 2024 lúc 05:26 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `toy-shop`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `comments`
--

CREATE TABLE `comments` (
  `IDcomment` int(11) NOT NULL,
  `commentText` text NOT NULL,
  `commentName` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `dateComment` datetime NOT NULL,
  `replyText` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `comments`
--

INSERT INTO `comments` (`IDcomment`, `commentText`, `commentName`, `email`, `dateComment`, `replyText`) VALUES
(13, 'sam oke ples', 'sam', 'sam@gmail.com', '2024-05-29 00:00:00', NULL),
(21, 'khách', 'khách', 'k@gmail.com', '2024-05-11 00:00:00', 'cảm ơn ạ'),
(28, 'chao mot ngay moi', 'linh', 'duongthuylinh@gmail.com', '2024-05-11 00:00:00', NULL),
(29, '123456', 'thuylinh', 'duongthuylinh@gmail.com', '2024-05-11 00:00:00', 'hello ban'),
(32, 'Đẹp quá à', 'Tran Huu Dat', 'huudat.lego@gmail.com', '2024-05-15 00:00:00', NULL);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `contacts`
--

CREATE TABLE `contacts` (
  `c_id` int(11) NOT NULL,
  `c_name` varchar(255) DEFAULT NULL,
  `c_email` varchar(255) DEFAULT NULL,
  `c_subject` varchar(255) DEFAULT NULL,
  `c_message` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `contacts`
--

INSERT INTO `contacts` (`c_id`, `c_name`, `c_email`, `c_subject`, `c_message`) VALUES
(1, 'Huudat2004', 'huudat.lego@gmail.com', 'First Contact', 'First Contact'),
(10, 'Huudat2004', 'huudat.lego@gmail.com', '10th May', 'Hello'),
(11, 'Huudat2004', 'huudat.lego@gmail.com', 'First Contact', '8:29PM');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `discount`
--

CREATE TABLE `discount` (
  `d_id` int(20) NOT NULL,
  `d_name` varchar(100) NOT NULL,
  `d_amount` int(20) NOT NULL,
  `d_description` varchar(255) NOT NULL,
  `d_start_date` date DEFAULT NULL,
  `d_end_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `discount`
--

INSERT INTO `discount` (`d_id`, `d_name`, `d_amount`, `d_description`, `d_start_date`, `d_end_date`) VALUES
(2, 'Wood toys for your kids', 20, 'Discount 20%', '2024-04-30', '2024-05-18');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `login`
--

CREATE TABLE `login` (
  `userID` int(50) NOT NULL,
  `userName` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `loginpassword` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `login`
--

INSERT INTO `login` (`userID`, `userName`, `email`, `loginpassword`) VALUES
(1, 'admin', 'admin123@gmail.com', '1230'),
(2, 'khanhne', 'Khanhne@gmail.com', '1234'),
(14, 'TranHuuDat', 'huudat.lego', 'huudat'),
(15, 'TranHuuDat123', 'huudat.mini', 'huudat'),
(16, 'DuongThiThuyLinh', 'DuongThiThuyLinh', '1234'),
(17, 'NguyenThuyKhanh', 'NguyenThuyKhanh', '1234'),
(19, 'TestA', 'TestA', '1234'),
(21, 'DaoMinhPhuc', 'DaoMinhPhuc@gmail.com', '1234'),
(23, 'huudat', 'huudat', 'huudat'),
(24, 'mini', 'mini', 'mini'),
(25, 'TranHuuDat', 'TranHuuDat@gmail.com', '123456');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order`
--

CREATE TABLE `order` (
  `o_id` int(20) NOT NULL,
  `u_id` int(20) NOT NULL,
  `p_id` int(11) NOT NULL,
  `o_price` int(20) NOT NULL,
  `o_quantity` int(10) NOT NULL,
  `o_status` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `order`
--

INSERT INTO `order` (`o_id`, `u_id`, `p_id`, `o_price`, `o_quantity`, `o_status`) VALUES
(70, 21, 3, 11, 5, 1),
(79, 14, 6, 13, 5, 1),
(84, 14, 4, 11, 1, 1),
(86, 24, 2, 13, 1, 0),
(87, 24, 3, 11, 1, 0),
(94, 14, 5, 11, 3, 1),
(95, 14, 1, 13, 3, 1),
(96, 14, 21, 10, 3, 1);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `order_detail`
--

CREATE TABLE `order_detail` (
  `od_id` int(20) NOT NULL,
  `o_id` int(20) NOT NULL,
  `od_address` varchar(255) NOT NULL,
  `od_price` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `product`
--

CREATE TABLE `product` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_type` varchar(255) NOT NULL,
  `p_price` float NOT NULL,
  `p_provider` varchar(225) NOT NULL,
  `p_age` varchar(100) NOT NULL,
  `p_description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `product`
--

INSERT INTO `product` (`p_id`, `p_name`, `p_image`, `p_type`, `p_price`, `p_provider`, `p_age`, `p_description`) VALUES
(1, 'LEGO 70365 Axl', 'LEGO_70365_1.png, LEGO_70365_2.png, LEGO_70365_3.png', 'Plastic', 12.99, 'LEGO', '0-12 months', 'Features a buildable battle suit with highly posable limbs and a minifigure cockpit. Charge into battle with an even bigger Axl and send the Stone monsters flying! Also includes a super-sized buildable axe. Accessory elements include a Combo NEXO Power shield and five scannable NEXO Powers.'),
(2, 'Rabit', 'rabit.png,About-Icon-1.webp,About-Icon-2.webp', 'Plastic', 12.99, 'dun dun dun', '3+ years', 'it is very pretty'),
(3, 'Elephant Jelly Cat', 'Elephant.png', 'Cotton', 10.99, 'Cookie', '0-12 months', 'it is very pretty'),
(4, 'Unicorn', 'unicorn.png', 'Cotton', 10.99, 'Baby Logo', '1-2 years', 'it is very pretty'),
(5, 'Barbie', 'barbie.png', 'Plastic', 10.99, 'BarBie', '3+ years', 'it is very pretty'),
(6, 'Beach', 'beach.png', 'Plastic', 12.99, 'Cookie', '5+ years', 'it is very pretty'),
(7, 'Frog Duck', 'frog.png', 'Cotton', 12.99, 'Frog Leaf', '1-2 years', 'it is very pretty'),
(8, 'Bear Jelly Cat', 'bearjellycat.png', 'Cotton', 10.99, 'DiNo', '0-12 months', 'it is very pretty'),
(9, 'Giraffe Jelly Cat', 'giraffe.png', 'Cotton', 12.99, 'Frog Leaf', '0-12 months', 'it is very pretty'),
(10, 'Bear Baby Tower', 'beartowel.png,,', 'Cotton', 12.99, 'Frog Leaf', '0-12 months', 'it is very pretty'),
(11, 'Flower Jelly Cat', 'Jelly Cat Flower.png', 'Cotton', 10.99, 'Frog Leaf', '0-12 months', 'it is very pretty'),
(12, 'Ring', 'ring.png', 'Wood', 8.49, 'dun dun dun', '0-12 months', 'it is very pretty'),
(13, 'Tiger Ring', 'tiger2.png', 'Cotton', 8.49, 'Baby Logo', '1-2 years', 'it is very pretty'),
(14, 'Duck', 'duck.png', 'Plastic', 5.25, 'dun dun dun', '1-2 years', 'it is very pretty'),
(15, 'Frog', 'frog1.png', 'Plastic', 8.49, 'Frog Leaf', '3+ years', 'it is very pretty'),
(16, 'Barbie Cutie Reveal', 'barbie2.png', 'Rubberized Plastic', 5.25, 'BarBie', '5+ years', 'it is very pretty'),
(17, 'Logic Matrix', 'logicmatrix.png', 'Metal', 5.25, 'Cookie', '5+ years', 'it is very pretty'),
(18, 'Music', 'music1.png', 'Wood', 8.49, 'dun dun dun', '5+ years', 'it is very pretty'),
(21, 'LEGO 70362 Clay', 'LEGO_70362_1.png,70362.jpeg,19458_lego-nexo-chien-giap-clay-tuticare-2.jpg', 'Plastic', 9.99, 'LEGO', '5+ years', 'Features a buildable battle suit with highly posable limbs and a minifigure cockpit. Also includes a super-sized buildable sword. Accessory elements include a Combo NEXO Power shield and 5 scannable NEXO Powers. Download the free LEGO® NEXO KNIGHTS™: MERLOK 2.0 app to your smartphone or tablet.'),
(22, 'Sticker', 'StickerCookieRun 1.png,StickerCookieRun 2.png,StickerCookieRun 3.png', 'Plastic', 9.99, 'Cookie', '5+ years', 'Sticker Very Good'),
(23, 'LEGO 70363 Macy', 'Macy 1.jpg,Macy 2.jpg,Macy 3.jpg', 'Plastic', 9.99, 'LEGO', '5+ years', 'Đặc điểm nổi bật của Lego Nexo Knights 70363 - Chiến giáp Macy:\r\nGồm 66 miếng ghép thuộc chủ đề Lego Nexo Knights mới nhất năm 2017.\r\nKết hợp chơi xếp hình và lắp ráp mô hình trong bộ Lego Nexo Knights 70363 - Chiến giáp Macy cùng công nghệ hấp dẫn khi có thể chơi cả trên ứng dụng điện thoại và máy tính bảng.');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `review`
--

CREATE TABLE `review` (
  `r_id` int(50) NOT NULL,
  `r_name` varchar(50) NOT NULL,
  `r_star` varchar(225) NOT NULL,
  `r_email` varchar(100) NOT NULL,
  `r_description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `review`
--

INSERT INTO `review` (`r_id`, `r_name`, `r_star`, `r_email`, `r_description`) VALUES
(3, 'Justin Bieber', '7', 'justinbieber@gmail.com', 'Using cotton buckets regularly will help your skin become cleaner, softer and brighter. However, it should be noted that excessive use can cause damage to the skin, so use gently and only periodically.'),
(23, 'HuuDat', '5', 'HuuDat', 'Hello'),
(24, 'ThuyKhanh', '4', 'ThuyKhanh', 'Đẹp quá'),
(25, 'ThuyLinh', '0', 'ThuyLinh', 'Hay lắm mua ngay nha'),
(26, 'BInhQuyen', '0', 'BInhQuyen', 'Mua liền'),
(30, 'Zalo', '0', '', 'Mua thêm đi');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `wishlist`
--

CREATE TABLE `wishlist` (
  `p_id` int(11) NOT NULL,
  `p_name` varchar(255) NOT NULL,
  `p_image` varchar(255) NOT NULL,
  `p_type` varchar(255) NOT NULL,
  `p_price` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`IDcomment`);

--
-- Chỉ mục cho bảng `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`c_id`);

--
-- Chỉ mục cho bảng `discount`
--
ALTER TABLE `discount`
  ADD PRIMARY KEY (`d_id`);

--
-- Chỉ mục cho bảng `login`
--
ALTER TABLE `login`
  ADD PRIMARY KEY (`userID`);

--
-- Chỉ mục cho bảng `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`o_id`),
  ADD KEY `fk_u_id_user` (`u_id`),
  ADD KEY `fk_p_id_product` (`p_id`);

--
-- Chỉ mục cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`od_id`),
  ADD KEY `fk_order_id` (`o_id`);

--
-- Chỉ mục cho bảng `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`p_id`);

--
-- Chỉ mục cho bảng `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`r_id`);

--
-- Chỉ mục cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  ADD PRIMARY KEY (`p_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `comments`
--
ALTER TABLE `comments`
  MODIFY `IDcomment` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT cho bảng `contacts`
--
ALTER TABLE `contacts`
  MODIFY `c_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT cho bảng `discount`
--
ALTER TABLE `discount`
  MODIFY `d_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `login`
--
ALTER TABLE `login`
  MODIFY `userID` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `order`
--
ALTER TABLE `order`
  MODIFY `o_id` int(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=97;

--
-- AUTO_INCREMENT cho bảng `product`
--
ALTER TABLE `product`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT cho bảng `review`
--
ALTER TABLE `review`
  MODIFY `r_id` int(50) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT cho bảng `wishlist`
--
ALTER TABLE `wishlist`
  MODIFY `p_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `fk_order_id` FOREIGN KEY (`o_id`) REFERENCES `order` (`o_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
