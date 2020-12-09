DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
    `id` int(11) NOT NULL auto_increment primary key,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(255) NOT NULL,
    `active` tinyint(8) default 1,
    `admin` tinyint(8) default 0,
    `create` timestamp default CURRENT_TIMESTAMP
);

INSERT INTO `user` (`username`, `password`, `email`) 
VALUES ('user', '$2y$10$Klq5nt0Lw1BBcSYtNzkIv.Lw7B5BBeGulUaQdWutv7M69Pjiqr7li', 'user@example.com');

INSERT INTO `user` (`username`, `password`, `email`) 
VALUES ('test', '$2y$10$Klq5nt0Lw1BBcSYtNzkIv.Lw7B5BBeGulUaQdWutv7M69Pjiqr7li', 'test@example.com');

INSERT INTO `user` (`username`, `password`, `email`, `admin`) 
VALUES ('admin', '$2y$10$SxlWmEW8UFLUbsFgyyB/j.qlCyKEmZXZ5abeNYQw085j8PuQxRogW', 'admin@example.com', 1);

INSERT INTO `user` (`username`, `password`, `email`, `admin`) 
VALUES ('noah4546', '$2y$10$hoXaS3Jn85fGgLzQ4Jk2bO8ESD5HARtBY51T6T1BZymBUVsumHF6O', '1tomkinsnoa@gmail.com', 1);


DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
    `id` int(11) NOT NULL auto_increment primary key,
    `name` varchar(50) NOT NULL,
    `user_id` int(11) NOT NULL REFERENCES `user`(`id`),
    `street_address` varchar(255) NOT NULL,
    `city` varchar(255) NOT NULL,
    `province` varchar(20) NOT NULL,
    `postal` varchar(6) NOT NULL
);


DROP TABLE IF EXISTS `product_category`;
CREATE TABLE `product_category` (
    `id` int(11) NOT NULL auto_increment primary key,
    `name` varchar(255) NOT NULL,
    `description` varchar(512) NULL
);

INSERT INTO `product_category` (`name`) VALUES 
    ('uncategoried'),
    ('graphics cards');

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
    `id` int(11) NOT NULL auto_increment primary key,
    `category_id` int(11) NOT NULL default 1 REFERENCES `product_category`(`id`),
    `name` varchar(255) NOT NULL,
    `short_description` varchar(2048) NULL,
    `long_description` varchar(10000) NULL,
    `price` FLOAT NOT NULL,
    `discount` FLOAT default 0,
    `quantity` int(11) default 0,
    `status` varchar(20) default 'available',
    `image_url` varchar(255) NULL default 'product0.jpg',
    `created` timestamp default CURRENT_TIMESTAMP
);

INSERT INTO `product` (`category_id`, `name`, `price`, `quantity`) VALUES
    (2, 'RTX 3090', 1499.00, 10),
    (2, 'RTX 3080', 699.00, 25),
    (2, 'RTX 3070', 499.00, 200),
    (2, 'RTX 3060 Ti', 399.00, 2500);

# AOPEN Gaming Monitor Test Product
INSERT INTO `product` (`id`, `category_id`, `name`, `short_description`, `long_description`, `price`, `discount`, `quantity`, `status`, `image_url`, `created`) VALUES (NULL, '1', 'Aopen Gaming Series 24HC1QR Pbidpx 23.6\" Black VA Curved 1800R FreeSync 144Hz LED Monitor 1920 x 1080 Widescreen 16:9 Response Time 250 cd/m2 1000:1 DVI, HDMI, DisplayPort', '<div class=\"product-bullets\"><ul><li>23.6\" VA 1800R Curved Panel with 1920 x 1080 Full HD Resolution\r\n</li><li>AMD Radeon FreeSync Technology\r\n</li><li>144Hz Refresh Rate\r\n</li><li>DVI, HDMI, DisplayPort\r\n</li><li>Low Blue Light &amp; Flicker-less Technology</li></ul></div>', '<div class=\"wc-aplus-body\"><div class=\"wc-reset\"> <ul class=\"wc-rich-features wc-rich-content-orientation-banner-image wc-first wc-no-line-seperator\"> <li class=\"wc-rich-feature-item wc-text-placement-true wc-odd-0 wc-first wc-has-media wc-thumb-large wc-has-no-caption wc-has-no-description wc-last\" id=\"wcr-rf-mqclps_wcrid1\"> <style> .wc-richfeatures-layout-computer ul.wc-rich-content-orientation-banner-image #wcr-rf-mqclps_wcrid1 { max-width:1920px!important; } .wc-richfeatures-layout-computer ul.wc-rich-content-orientation-banner-image #wcr-rf-mqclps_wcrid1 .wc-rf-banner-image-container { max-width:1920px!important; padding-bottom:30.885417%!important; } .wc-richfeatures-layout-computer ul.wc-rich-content-orientation-banner-image #wcr-rf-mqclps_wcrid1.wc-rf-box-placement-below .wc-rf-banner-image-container, .wc-richfeatures-layout-computer ul.wc-rich-content-orientation-banner-image #wcr-rf-mqclps_wcrid1.wc-rf-box-location-below .wc-rf-banner-image-container { padding-bottom:0!important; } </style> <div class=\"wc-rf-banner-image-container\"> <img alt=\"\" class=\"wc-media wc-image wc-rf-banner-image\" data-asset-type=\"image\" data-asset-url=\"/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/7331b0e8-ba35-42f2-a3aa-c97dfc43fe6c.jpg\" height=\"593\" src=\"https://smedia.webcollage.net/rwvfp/wc/cp/1538681947445_c310a94d-1a42-4ce3-a843-a008234ae8e2/module/acer/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/7331b0e8-ba35-42f2-a3aa-c97dfc43fe6c.jpg.w1920.jpg\" width=\"1920\"> </div> </li> </ul> </div><div class=\"wc-reset\"> <ul class=\"wc-rich-features wc-rich-content-orientation-right-aligned wc-rich-features-center-984\"> <li class=\"wc-rich-feature-item wc-text-placement-false wc-odd-0 wc-first wc-has-media wc-thumb-medium wc-last \"> <div class=\"wc-media-wrap\" style=\"width:457px !important\"> <div class=\"wc-media-inner-wrap\" style=\"max-width:457px !important\"> <img alt=\"\" class=\"wc-media wc-image\" data-asset-title=\"Games play smoother with cutting edge gaming technology\" data-asset-type=\"image\" data-asset-url=\"/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/936613b4-d119-4cee-aaba-15fd12d991c9.jpg\" data-asset-wrapper=\"rich-features\" data-height=\"480\" data-section-template-code=\"rich-features\" data-width=\"480\" height=\"480\" module-id=\"acer\" src=\"https://smedia.webcollage.net/rwvfp/wc/cp/1538681947445_c310a94d-1a42-4ce3-a843-a008234ae8e2/module/acer/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/936613b4-d119-4cee-aaba-15fd12d991c9.jpg.w480.jpg\" title=\"Games play smoother with cutting edge gaming technology\" wcpc=\"1538673877852\" width=\"480\"> </div> </div> <div class=\"wc-text-wrap\"><h3 class=\"wc-rich-content-header wc-feature-main-header \">Games play smoother with cutting edge gaming technology</h3> <div class=\"wc-rich-content-description\"> Dive deep into the game and immerse yourself in super sharp colors with up to WQHD 1800R curved display. Get lag free entertainment with AMD® Radeon FreeSync™, 144Hz refresh rate, and a 4ms response time. </div> </div> </li> </ul> </div><div class=\"wc-reset\"> <ul class=\"wc-rich-features wc-rich-content-orientation-banner-image wc-no-line-seperator\"> </ul> </div><div class=\"wc-reset\"> <ul class=\"wc-rich-features wc-rich-content-orientation-four-columns wc-last wc-rf-columns wc-no-line-seperator\"> <li class=\"wc-rich-feature-item wc-text-placement-false wc-odd-0 wc-first wc-has-media wc-thumb-medium wc-has-no-caption \"> <div class=\"wc-media-wrap\"> <div class=\"wc-media-inner-wrap\"> <img alt=\"\" class=\"wc-media wc-image\" data-asset-type=\"image\" data-asset-url=\"/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/7736e5f9-2522-4b3a-814f-0b7e697ff621.jpg\" data-asset-wrapper=\"rich-features\" data-height=\"480\" data-section-template-code=\"rich-features\" data-width=\"480\" height=\"480\" module-id=\"acer\" src=\"https://smedia.webcollage.net/rwvfp/wc/cp/1538681947445_c310a94d-1a42-4ce3-a843-a008234ae8e2/module/acer/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/7736e5f9-2522-4b3a-814f-0b7e697ff621.jpg.w480.jpg\" title=\"\" wcpc=\"1538673877852\" width=\"480\"> </div> </div> <div class=\"wc-rich-content-description\"> <b>FHD 1800R curved display<br></b><br>The HC1 series brings users into a perfect colorful world with FHD (1920 x 1080) resolution, and 1800R curvature, providing a cinematic viewing experience. </div> </li> <li class=\"wc-rich-feature-item wc-text-placement-false wc-even-0 wc-has-media wc-thumb-medium wc-has-no-caption \"> <div class=\"wc-media-wrap\"> <div class=\"wc-media-inner-wrap\"> <img alt=\"\" class=\"wc-media wc-image\" data-asset-type=\"image\" data-asset-url=\"/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/a6bf7b4c-ea05-4c06-9132-be65db074000.jpg\" data-asset-wrapper=\"rich-features\" data-height=\"480\" data-section-template-code=\"rich-features\" data-width=\"480\" height=\"480\" module-id=\"acer\" src=\"https://smedia.webcollage.net/rwvfp/wc/cp/1538681947445_c310a94d-1a42-4ce3-a843-a008234ae8e2/module/acer/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/a6bf7b4c-ea05-4c06-9132-be65db074000.jpg.w480.jpg\" title=\"\" wcpc=\"1538673877852\" width=\"480\"> </div> </div> <div class=\"wc-rich-content-description\"> <b>AMD® Radeon FreeSync™</b><br><br>With Radeon FreeSync, the monitor’s frames are synced with the graphics card’s frames, which eliminate screen tearing and delivers very smooth gaming experiences. </div> </li> <li class=\"wc-rich-feature-item wc-text-placement-false wc-odd-0 wc-has-media wc-thumb-medium wc-has-no-caption \"> <div class=\"wc-media-wrap\"> <div class=\"wc-media-inner-wrap\"> <img alt=\"\" class=\"wc-media wc-image\" data-asset-type=\"image\" data-asset-url=\"/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/a4e67a85-125d-42f6-978f-1333e106e4ee.jpg\" data-asset-wrapper=\"rich-features\" data-height=\"480\" data-section-template-code=\"rich-features\" data-width=\"480\" height=\"480\" module-id=\"acer\" src=\"https://smedia.webcollage.net/rwvfp/wc/cp/1538681947445_c310a94d-1a42-4ce3-a843-a008234ae8e2/module/acer/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/a4e67a85-125d-42f6-978f-1333e106e4ee.jpg.w480.jpg\" title=\"\" wcpc=\"1538673877852\" width=\"480\"> </div> </div> <div class=\"wc-rich-content-description\"> <b>144Hz refresh rate</b><br><br>HC1 series feature with high refresh rate up to 144Hz, The 144Hz refresh rate speeds up the frames per second to deliver an ultra-smooth 2D motion scenes. </div> </li> <li class=\"wc-rich-feature-item wc-text-placement-false wc-even-0 wc-has-media wc-thumb-medium wc-has-no-caption wc-last \"> <div class=\"wc-media-wrap\"> <div class=\"wc-media-inner-wrap\"> <img alt=\"\" class=\"wc-media wc-image\" data-asset-type=\"image\" data-asset-url=\"/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/04ea1fad-ee0a-4baa-8b8f-52981066c195.jpg\" data-asset-wrapper=\"rich-features\" data-height=\"480\" data-section-template-code=\"rich-features\" data-width=\"480\" height=\"480\" module-id=\"acer\" src=\"https://smedia.webcollage.net/rwvfp/wc/cp/1538681947445_c310a94d-1a42-4ce3-a843-a008234ae8e2/module/acer/_cp/products/1538673877852/tab-93cbcabf-817c-4e8a-9a28-2a4916dbdcb7/04ea1fad-ee0a-4baa-8b8f-52981066c195.jpg.w480.jpg\" title=\"\" wcpc=\"1538673877852\" width=\"480\"> </div> </div> <div class=\"wc-rich-content-description\"> <b>4ms response time</b><br><br>Never let your enemies escape by slow display. An ultra-fast 4ms repose time, which makes you able to aim at the first gaze with super smooth transition without any ghosting and image dragging. </div> </li> </ul> </div></div>', '139.99', '20', '5000', 'available', 'product5.jpg', '2020-12-04 17:57:04');


DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
    `id` int(11) NOT NULL auto_increment primary key,
    `product_id` int(11) NOT NULL REFERENCES `product`(`id`),
    `user_id` int(11) NOT NULL REFERENCES `user`(`id`),
    `price` FLOAT NOT NULL,
    `discount` FLOAT default 0,
    `quantity` int(11) default 1
);