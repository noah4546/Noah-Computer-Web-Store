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

INSERT INTO `user` (`username`, `password`, `email`, `admin`) 
VALUES ('admin', '$2y$10$SxlWmEW8UFLUbsFgyyB/j.qlCyKEmZXZ5abeNYQw085j8PuQxRogW', 'admin@example.com', 1);
