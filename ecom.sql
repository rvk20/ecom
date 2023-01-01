/*Tabela z kategoriami produktów */
CREATE TABLE `category` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `name` varchar(80) NOT NULL,
                            PRIMARY KEY (`id`)
);
/*Tabela z komentarzami do produktów */
CREATE TABLE `comment` (
                           `id` int NOT NULL AUTO_INCREMENT,
                           `author` int NOT NULL,
                           `text` varchar(255) NOT NULL,
                           `product` int NOT NULL,
                           PRIMARY KEY (`id`)
);
/*Tabela przechowująca pliki */
CREATE TABLE `file` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `filename` varchar(255) NOT NULL,
                        PRIMARY KEY (`id`)
);
/*Tabela z zamówieniami */
CREATE TABLE `ord` (
                       `id` int NOT NULL AUTO_INCREMENT,
                       `name` varchar(255) NOT NULL,
                       `cost` float NOT NULL,
                       `status` varchar(20) NOT NULL,
                       `user` int NOT NULL,
                       `date` datetime NOT NULL,
                       PRIMARY KEY (`id`)
);
/*Tabela z produktami do zamówien*/
CREATE TABLE `ord_item` (
                            `id` int NOT NULL AUTO_INCREMENT,
                            `product` int NOT NULL,
                            `quantity` int NOT NULL,
                            `ord` int NOT NULL,
                            PRIMARY KEY (`id`)
);
/*Tabela produktów*/
CREATE TABLE `product` (
                           `id` int NOT NULL AUTO_INCREMENT,
                           `name` varchar(60) NOT NULL,
                           `cost` float NOT NULL,
                           `quantity` int NOT NULL,
                           `category` int NOT NULL,
                           `image` int NOT NULL,
                           PRIMARY KEY (`id`)
);
/*Tabela z sesją logowania*/
CREATE TABLE `session` (
                           `session_id` varchar(50) NOT NULL,
                           `user_id` int NOT NULL,
                           `role` varchar(50) NOT NULL,
                           `started_at` datetime NOT NULL,
                           `end` datetime DEFAULT NULL,
                           `status` bit(1) NOT NULL DEFAULT b'1'
);
/*Tabela użytkowników*/
CREATE TABLE `user` (
                        `id` int NOT NULL AUTO_INCREMENT,
                        `name` varchar(60) NOT NULL,
                        `password` varchar(255) NOT NULL,
                        `role` varchar(10) NOT NULL,
                        PRIMARY KEY (`id`)
);
/*Dodanie konta admina*/
INSERT INTO `user`(`name`, `password`, `role`) VALUES ("admin","123","admin");
/*Dodanie testowego pliku*/
INSERT INTO `file`(`filename`) VALUES ("img");
/*Wyzwalacz zmieniający stan produktu po dokonaniu zamówienia*/
CREATE TRIGGER AI_PRODUCT
    AFTER INSERT ON ord_item
    FOR EACH ROW
    UPDATE product
    SET quantity = (quantity - NEW.quantity) WHERE id = NEW.product;
