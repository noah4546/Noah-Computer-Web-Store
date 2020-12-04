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

INSERT INTO `product_category` (`name`)
VALUES ('graphics cards');

DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
    `id` int(11) NOT NULL auto_increment primary key,
    `category_id` int(11) NOT NULL REFERENCES `product_category`(`id`),
    `name` varchar(255) NOT NULL,
    `description` varchar(5000) NULL,
    `price` FLOAT NOT NULL,
    `discount` FLOAT default 0,
    `quantity` int(11) default 0,
    `status` varchar(20) default 'available',
    `image_url` varchar(255) NULL,
    `created` timestamp default CURRENT_TIMESTAMP
);

INSERT INTO `product` (`category_id`, `name`, `price`, `quantity`) VALUES
    (1, 'RTX 3090', 1499.00, 10),
    (1, 'RTX 3080', 699.00, 25),
    (1, 'RTX 3070', 499.00, 200),
    (1, 'RTX 3060 Ti', 399.00, 2500);
