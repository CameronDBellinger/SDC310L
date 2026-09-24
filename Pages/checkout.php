<?php

session_start();

require_once __DIR__ . "/../controller/connect_controller.php";

$order_created = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $full_name = $_POST["fullname"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];


    $customerStmt = $pdo->prepare("
        INSERT INTO customers
        (full_name, email, address, city, state, zip)
        VALUES (?, ?, ?, ?, ?, ?)
        ON DUPLICATE KEY UPDATE
        full_name = VALUES(full_name),
        address = VALUES(address),
        city = VALUES(city),
        state = VALUES(state),
        zip = VALUES(zip)
    ");

    $customerStmt->execute([
        $full_name,
        $email,
        $address,
        $city,
        $state,
        $zip
    ]);


    $customerStmt = $pdo->prepare("
        SELECT id
        FROM customers
        WHERE email = ?
    ");

    $customerStmt->execute([$email]);

    $customer = $customerStmt->fetch(PDO::FETCH_ASSOC);

    $customer_id = $customer["id"];


    $total = 0;

    if (!empty($_SESSION["cart"])) {

        $cartIds = array_keys($_SESSION["cart"]);

        $placeholders = implode(
            ",",
            array_fill(0, count($cartIds), "?")
        );

        $productStmt = $pdo->prepare("
            SELECT id, price
            FROM products
            WHERE id IN ($placeholders)
        ");

        $productStmt->execute($cartIds);

        $cartProducts = $productStmt->fetchAll(
            PDO::FETCH_ASSOC
        );


        foreach ($cartProducts as $product) {

            $quantity = $_SESSION["cart"][$product["id"]];

            $total += $product["price"] * $quantity;

        }

    }


    $orderStmt = $pdo->prepare("
        INSERT INTO orders
        (customer_id, total)
        VALUES (?, ?)
    ");

    $orderStmt->execute([
        $customer_id,
        $total
    ]);


    $order_id = $pdo->lastInsertId();


    if (!empty($_SESSION["cart"])) {

        foreach ($cartProducts as $product) {

            $quantity = $_SESSION["cart"][$product["id"]];

            $itemStmt = $pdo->prepare("
                INSERT INTO order_items
                (order_id, product_id, quantity, price_each)
                VALUES (?, ?, ?, ?)
            ");

            $itemStmt->execute([
                $order_id,
                $product["id"],
                $quantity,
                $product["price"]
            ]);

        }

    }


    $_SESSION["cart"] = [];

    $order_created = true;
}

require_once __DIR__ . "/../includes/header.php";

?>

<main>

<section class="mission">

<div class="container">

<?php if ($order_created): ?>

<p class="small-heading">
Order Complete
</p>

<h2>
Thank You For Your Order
</h2>

<p>
Your order has been successfully created.
</p>

<a
href="/purespring/index.php"
class="button"
>
Return Home
</a>

<?php else: ?>

<p class="small-heading">
Checkout
</p>

<h2>
Complete Your Order
</h2>


<form method="POST">

<label for="fullname">
Full Name
</label>

<input
type="text"
id="fullname"
name="fullname"
required
>


<label for="email">
Email Address
</label>

<input
type="email"
id="email"
name="email"
required
>


<label for="address">
Address
</label>

<input
type="text"
id="address"
name="address"
required
>


<label for="city">
City
</label>

<input
type="text"
id="city"
name="city"
required
>


<label for="state">
State
</label>

<input
type="text"
id="state"
name="state"
required
>


<label for="zip">
ZIP Code
</label>

<input
type="text"
id="zip"
name="zip"
required
>


<button
type="submit"
class="button"
>
Place Order
</button>

</form>

<?php endif; ?>

</div>

</section>

</main>

<?php

require_once __DIR__ . "/../includes/footer.php";

?>
