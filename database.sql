CREATE DATABASE IF NOT EXISTS healthtea CHARACTER SET utf8 COLLATE utf8_general_ci;

USE healthtea;

CREATE TABLE IF NOT EXISTS `users` (
    id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(30) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_admin BIT DEFAULT 0,
    PRIMARY KEY (id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS productlist (
    prod_id INT NOT NULL AUTO_INCREMENT,
    prod_name VARCHAR(50) NOT NULL,
    prod_desc VARCHAR(255) NOT NULL,
    prod_price DECIMAL(10,2) NOT NULL,
    is_available BIT DEFAULT 1,
    PRIMARY KEY (prod_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS wishlist (
    id INT NOT NULL AUTO_INCREMENT,
    userid INT,
    wishlistitemid INT,
    wishlistquantity INT,
    PRIMARY KEY (id),
    FOREIGN KEY (userid) REFERENCES users(id),
    FOREIGN KEY (wishlistitemid) REFERENCES productlist(prod_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS address (
    id INT NOT NULL AUTO_INCREMENT,
    userid INT,
    address VARCHAR(255),
    PRIMARY KEY (id),
    FOREIGN KEY (userid) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS orders (
    order_id INT NOT NULL AUTO_INCREMENT,
    user_id INT,
    address_id INT,
    is_received BIT DEFAULT 0,
    PRIMARY KEY (order_id),
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (address_id) REFERENCES address(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS order_item (
    oi_id INT NOT NULL AUTO_INCREMENT,
    order_id INT,
    prod_id INT,
    quantity INT(5),
    price DECIMAL(10,2),
    PRIMARY KEY (oi_id),
    FOREIGN KEY (order_id) REFERENCES orders(order_id),
    FOREIGN KEY (prod_id) REFERENCES productlist(prod_id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS contact (
    cont_id INT NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(30) NOT NULL,
    address VARCHAR(255) NOT NULL,
    message VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (cont_id)
) ENGINE=InnoDB;

INSERT INTO productlist(prod_id,prod_name,prod_desc,prod_price) VALUES
(1,'Royale Fruit Oolong Tea', '100% fresh fruits to bring you the freshest and healthiest fruit tea.',15.90),
(2,'Melon Oolong Tea', 'Aroma of oolong tea blend with sweet melon. Perfect for those warm afternoon. melon. Perfect ',12.90),
(3,'Melon Oolong Macchiato', 'Blend of tea, coconut water, milk and ice that is irresistibly creamy and delicious.',13.50),
(4,'Tie Guan Yin Coconut Tea', 'Floral aroma and smooth taste are elevated by Coconut Aqua Jelly, adding bursts of flavour and texture.',12.90),
(5,'Fresh Watermelon Tea', 'A perfect cup of fruit slushy. Beat the heat waves with our Fresh Watermelon Oolong tea today!',13.50),
(6,'Fresh Lemon Green Tea', 'Brewed with Glutinous Green Tea which gives off the aroma of roasted sugar cane and barley fragrant.',12.50),
(7,'Tie Guan Yin Coconut Frappe', 'A blend of tea, coconut water, milk and ice that is irresistibly creamy and delicious.',13.90),
(8,'Jasmine Peach Tea', 'The delicate aroma of jasmine and the rich peach flavour blend together. You will be pleasantly surprised with each and every sip.',13.90),
(9,'Fresh Kiwi Oolong Tea', 'The blend of fresh kiwi added shines through with that burst of sharp-fruitiness.',12.50),
(10,'Fresh Grapefruit Jasmine Tea', 'Made with 100% fresh grapefruits and our premium jasmine tea. Experience the exquisite fusion of citrus freshness.',12.50);

INSERT INTO users(username, email, password, is_admin) VALUES 
('aassdd', 'aassdd@gmail.com', 'aassdd', 0),
('qqwwee', 'qqwwee@gmail.com', 'qqwwee', 1);

INSERT INTO address(userid, address) VALUES 
(1, '342, Jalan Sultan Abdul Samad, 42700 Banting, Selangor.'),
(1, '344, Jalan Sultan Abdul Samad, 42700 Banting, Selangor.'),
(2, '111, Jalan Aba Aba Aba, 42700 Banting, Selangor.');