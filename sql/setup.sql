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
    ('uncategoried');

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
    `id` int(11) NOT NULL auto_increment primary key,
    `category_id` int(11) NOT NULL default 1 REFERENCES `product_category`(`id`),
    `name` varchar(255) NOT NULL,
    `short_description` varchar(2048) NULL,
    `long_description` varchar(255) NULL,
    `price` FLOAT NOT NULL,
    `discount` FLOAT default 0,
    `quantity` int(11) default 0,
    `status` varchar(20) default 'available',
    `image_url` varchar(255) NULL default 'product0.jpg',
    `created` timestamp default CURRENT_TIMESTAMP
);

DROP TABLE IF EXISTS `cart`;
CREATE TABLE `cart` (
    `id` int(11) NOT NULL auto_increment primary key,
    `product_id` int(11) NOT NULL REFERENCES `product`(`id`),
    `user_id` int(11) NOT NULL REFERENCES `user`(`id`),
    `price` FLOAT NOT NULL,
    `discount` FLOAT default 0,
    `quantity` int(11) default 1
);


DROP TABLE IF EXISTS `order`;
CREATE TABLE `order` (
    `id` int(11) NOT NULL auto_increment primary key,
    `user_id` int(11) NOT NULL REFERENCES `user`(`id`),
    `total` FLOAT NOT NULL,
    `date` timestamp  default CURRENT_TIMESTAMP,
    `status` varchar(20) default 'Processing'
);

DROP TABLE IF EXISTS `order_item`;
CREATE TABLE `order_item` (
    `id` int(11) NOT NULL auto_increment primary key,
    `product_id` int(11) NOT NULL REFERENCES `product`(`id`),
    `order_id` int(11) NOT NULL REFERENCES `order`(`id`),
    `price` FLOAT NOT NULL,
    `discount` FLOAT default 0,
    `quantity` int(11) default 1
);

DROP TABLE IF EXISTS `order_address`;
CREATE TABLE `order_address` (
    `id` int(11) NOT NULL auto_increment primary key,
    `name` varchar(50) NOT NULL,
    `order_id` int(11) NOT NULL REFERENCES `order`(`id`),
    `street_address` varchar(255) NOT NULL,
    `city` varchar(255) NOT NULL,
    `province` varchar(20) NOT NULL,
    `postal` varchar(6) NOT NULL
);