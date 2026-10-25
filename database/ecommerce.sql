CREATE DATABASE IF NOT EXISTS mitti_makers;
USE mitti_makers;

CREATE TABLE admins (
 id INT AUTO_INCREMENT PRIMARY KEY,
 admin_id VARCHAR(50) UNIQUE NOT NULL,
 password VARCHAR(255) NOT NULL,
 status TINYINT DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 email VARCHAR(150) UNIQUE NOT NULL,
 mobile VARCHAR(20),
 password VARCHAR(255) NOT NULL,
 address TEXT,
 city VARCHAR(80),
 state VARCHAR(80),
 pincode VARCHAR(10),
 status TINYINT DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE categories (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100) NOT NULL,
 image VARCHAR(255),
 description TEXT,
 status TINYINT DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
 id INT AUTO_INCREMENT PRIMARY KEY,
 category_id INT NOT NULL,
 name VARCHAR(150) NOT NULL,
 image VARCHAR(255),
 price DECIMAL(10,2) NOT NULL,
 discount DECIMAL(5,2) DEFAULT 0,
 description TEXT,
 stock INT DEFAULT 0,
 status TINYINT DEFAULT 1,
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(category_id) REFERENCES categories(id) ON DELETE CASCADE
);

CREATE TABLE orders (
 id INT AUTO_INCREMENT PRIMARY KEY,
 user_id INT NOT NULL,
 customer_name VARCHAR(100),
 email VARCHAR(150),
 mobile VARCHAR(20),
 billing_address TEXT,
 shipping_address TEXT,
 city VARCHAR(80),
 state VARCHAR(80),
 pincode VARCHAR(10),
 total_amount DECIMAL(10,2) NOT NULL,
 payment_method VARCHAR(50) DEFAULT 'Cash on Delivery',
 payment_status VARCHAR(30) DEFAULT 'Pending',
 order_status VARCHAR(30) DEFAULT 'Pending',
 order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 FOREIGN KEY(user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
 id INT AUTO_INCREMENT PRIMARY KEY,
 order_id INT NOT NULL,
 product_id INT NOT NULL,
 quantity INT NOT NULL,
 price DECIMAL(10,2) NOT NULL,
 FOREIGN KEY(order_id) REFERENCES orders(id) ON DELETE CASCADE,
 FOREIGN KEY(product_id) REFERENCES products(id)
);

CREATE TABLE contacts (
 id INT AUTO_INCREMENT PRIMARY KEY,
 name VARCHAR(100),
 email VARCHAR(150),
 message TEXT,
 submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Demo admin: admin / admin123
INSERT INTO admins(admin_id,password) VALUES
('admin','$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC1QvXK8JfYjK6dJ9u6');

INSERT INTO categories(name,image,description) VALUES
('Handmade Jewelry','accessories.png','Handcrafted earrings, necklaces and bracelets made with care'),
('Home Decor','men-fashion.png','Beautiful handmade decor to make your home feel special'),
('Art & Paintings','women-fashion.png','Original art, paintings and hand-painted keepsakes'),
('Crochet & Knitting','footwear.png','Cozy handmade crochet gifts, toys and accessories'),
('Candles & Soaps','classic-watch.png','Small-batch scented candles and handmade soaps'),
('Bags & Accessories','leather-wallet.png','Handmade fabric bags, pouches and everyday accessories');

INSERT INTO products(category_id,name,image,price,discount,description,stock) VALUES
(1,'Terracotta Floral Earrings','classic-tshirt.png',249,10,'Hand-painted terracotta earrings made by local artisans. Lightweight and perfect for everyday wear.',25),
(1,'Beaded Statement Necklace','denim-shirt.png',499,5,'A colorful handmade beaded necklace crafted with care. Each piece has its own character.',15),
(2,'Macrame Wall Hanging','women-top.png',799,10,'Hand-knotted cotton macrame wall decor for bedrooms, living rooms and cozy corners.',20),
(2,'Hand-Painted Ceramic Planter','casual-dress.png',399,15,'A cheerful hand-painted planter that adds a personal touch to your favorite plants.',12),
(3,'Floral Canvas Painting','running-shoes.png',1199,10,'Original floral artwork painted by hand on canvas. A thoughtful gift for art lovers.',8),
(3,'Handmade Greeting Card Set','casual-sneakers.png',199,0,'Set of five handmade greeting cards for birthdays, celebrations and heartfelt notes.',30),
(4,'Crochet Teddy Bear','classic-watch.png',599,10,'Soft handmade crochet teddy bear, lovingly stitched and ideal for gifting.',10),
(4,'Crochet Tote Bag','leather-wallet.png',699,5,'Reusable crochet tote bag with a unique handmade finish for daily essentials.',14),
(5,'Lavender Soy Wax Candle','women-fashion.png',349,10,'Small-batch soy wax candle with a relaxing lavender fragrance, poured by hand.',18),
(5,'Handmade Herbal Soap','accessories.png',149,0,'Gentle handmade soap crafted in small batches. Store in a dry place between uses.',24),
(6,'Block-Printed Cotton Pouch','footwear.png',299,5,'Reusable cotton pouch featuring a traditional-inspired block print pattern.',20),
(6,'Upcycled Fabric Tote','men-fashion.png',449,10,'A sturdy tote made from upcycled fabric, giving textiles a fresh new life.',16);
