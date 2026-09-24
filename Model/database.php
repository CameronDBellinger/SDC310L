<?php

// ==========================================
// PureSpring Database Configuration
// ==========================================
 
$dbHost = "localhost";
$dbName = "PureSpringProject";
$dbUser = "ecpi_user";
$dbPassword = "Password1";

 
// ==========================================
// Connect to MySQL
// ==========================================

try {

    $pdo = new PDO(
        "mysql:host=$dbHost;charset=utf8mb4",
        $dbUser,
        $dbPassword
    );

    $pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );

    // ==========================================
    // Create Database
    // ==========================================

    $pdo->exec("
        CREATE DATABASE IF NOT EXISTS `PureSpringProject`
        CHARACTER SET utf8mb4
        COLLATE utf8mb4_unicode_ci
    ");

    // Select database
    $pdo->exec("USE `PureSpringProject`");


    // ==========================================
    // Categories Table
    // ==========================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS categories (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT
        ) ENGINE=InnoDB
    ");


    // ==========================================
    // Products Table
    // ==========================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS products (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            category_id INT,
            price DECIMAL(10,2) NOT NULL,
            description TEXT,
            image_url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (category_id)
            REFERENCES categories(id)
            ON DELETE SET NULL
            ON UPDATE CASCADE
        ) ENGINE=InnoDB
    ");


    // ==========================================
    // Customers Table
    // ==========================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS customers (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(50),
            address VARCHAR(255),
            city VARCHAR(100),
            state VARCHAR(50),
            zip VARCHAR(20),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");


    // ==========================================
    // Orders Table
    // ==========================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS orders (
            id INT AUTO_INCREMENT PRIMARY KEY,
            customer_id INT NOT NULL,
            total DECIMAL(10,2) NOT NULL,
            status VARCHAR(50) DEFAULT 'Pending',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (customer_id)
            REFERENCES customers(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ) ENGINE=InnoDB
    ");


    // ==========================================
    // Order Items Table
    // ==========================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS order_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            order_id INT NOT NULL,
            product_id INT NOT NULL,
            quantity INT NOT NULL,
            price_each DECIMAL(10,2) NOT NULL,

            FOREIGN KEY (order_id)
            REFERENCES orders(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE,

            FOREIGN KEY (product_id)
            REFERENCES products(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ) ENGINE=InnoDB
    ");


    // ==========================================
    // Contact Messages Table
    // ==========================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS contact_messages (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL,
            subject VARCHAR(255),
            message TEXT NOT NULL,
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB
    ");


    // ==========================================
    // Cart Items Table
    // ==========================================

    $pdo->exec("
        CREATE TABLE IF NOT EXISTS cart_items (
            id INT AUTO_INCREMENT PRIMARY KEY,
            session_id VARCHAR(255) NOT NULL,
            product_id INT NOT NULL,
            quantity INT DEFAULT 1,
            added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

            FOREIGN KEY (product_id)
            REFERENCES products(id)
            ON DELETE CASCADE
            ON UPDATE CASCADE
        ) ENGINE=InnoDB
    ");


    // ==========================================
    // Insert Categories
    // ==========================================

    $categories = [
        [
            "Water Tanks",
            "Water storage solutions for homes, farms, and off-grid systems."
        ],
        [
            "Filters",
            "Filtration systems designed to improve water quality."
        ],
        [
            "Hoses & Pumps",
            "Pumps and hoses designed to move water efficiently."
        ],
        [
            "Fittings",
            "Durable fittings and connectors for water systems."
        ],
        [
            "Apparel",
            "PureSpring shirts and apparel."
        ],
        [
            "Stickers",
            "PureSpring stickers and decals."
        ]
    ];

    $categoryStmt = $pdo->prepare("
        INSERT INTO categories (name, description)
        SELECT ?, ?
        WHERE NOT EXISTS (
            SELECT 1
            FROM categories
            WHERE name = ?
        )
    ");

    foreach ($categories as $category) {

        $categoryStmt->execute([
            $category[0],
            $category[1],
            $category[0]
        ]);

    }


    // ==========================================
    // Insert Products
    // ==========================================

    $products = [
        ["20,000L Water Tank", "Water Tanks", 1450.00],
        ["Inline Water Filter", "Filters", 89.99],
        ["High-Flow Water Pump", "Hoses & Pumps", 179.00],
        ["Flexible Hose Kit", "Hoses & Pumps", 49.99],
        ["Brass Fitting Set", "Fittings", 29.99],
        ["PureSpring T-Shirt", "Apparel", 24.99],
        ["Logo Sticker Pack", "Stickers", 9.99],
        ["Rainwater Collector", "Water Tanks", 199.00],
        ["UV Purifier", "Filters", 129.00],
        ["Mini Pump System", "Hoses & Pumps", 89.00]
    ];

    $productStmt = $pdo->prepare("
        INSERT INTO products (name, category_id, price)
        SELECT ?, categories.id, ?
        FROM categories
        WHERE categories.name = ?
        AND NOT EXISTS (
            SELECT 1
            FROM products
            WHERE products.name = ?
        )
        LIMIT 1
    ");

    foreach ($products as $product) {

        $productStmt->execute([
            $product[0],
            $product[2],
            $product[1],
            $product[0]
        ]);

    }


    // ==========================================
    // Success Message
    // ==========================================

    echo "<!DOCTYPE html>";
    echo "<html>";
    echo "<head>";
    echo "<title>PureSpring Database</title>";
    echo "</head>";

    echo "<body>";

    echo "<h1>PureSpring Database Setup Successful</h1>";

    echo "<p>Database: <strong>PureSpringProject</strong></p>";

    echo "<h2>Tables Created</h2>";

    echo "<ul>";
    echo "<li>categories</li>";
    echo "<li>products</li>";
    echo "<li>customers</li>";
    echo "<li>orders</li>";
    echo "<li>order_items</li>";
    echo "<li>contact_messages</li>";
    echo "<li>cart_items</li>";
    echo "</ul>";

    echo "<p>Categories and sample products have been populated.</p>";

    echo "</body>";
    echo "</html>";


} catch (PDOException $e) {

    echo "<h1>Database Error</h1>";

    echo "<p>";
    echo htmlspecialchars($e->getMessage());
    echo "</p>";

}

?>
