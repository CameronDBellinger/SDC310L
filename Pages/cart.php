<?php

session_start();

require_once __DIR__ . "/../controller/connect_controller.php";


if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}


if (isset($_GET["remove"])) {

    $remove_id = (int) $_GET["remove"];

    unset($_SESSION["cart"][$remove_id]);

}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $product_id = (int) $_POST["product_id"];

    $quantity = (int) $_POST["quantity"];


    if ($quantity <= 0) {

        unset($_SESSION["cart"][$product_id]);

    } else {

        $_SESSION["cart"][$product_id] = $quantity;

    }

}


require_once __DIR__ . "/../includes/header.php";

?>

<main>

<section class="mission">

<div class="container">

<p class="small-heading">
Shopping Cart
</p>

<h2>
Your Cart
</h2>


<?php if (empty($_SESSION["cart"])): ?>

<p>
Your shopping cart is currently empty.
</p>

<a
href="/purespring/Pages/store.php"
class="button"
>
Continue Shopping
</a>

<?php else: ?>


<?php

$cartIds = array_keys($_SESSION["cart"]);

$placeholders = implode(
    ",",
    array_fill(0, count($cartIds), "?")
);


$stmt = $pdo->prepare("
    SELECT
        id,
        name,
        price
    FROM products
    WHERE id IN ($placeholders)
");


$stmt->execute($cartIds);

$cartProducts = $stmt->fetchAll(
    PDO::FETCH_ASSOC
);


$cartTotal = 0;

?>


<?php foreach ($cartProducts as $product): ?>


<?php

$quantity = $_SESSION["cart"][$product["id"]];

$itemTotal = $product["price"] * $quantity;

$cartTotal += $itemTotal;

?>


<article class="product-card">

<h3>

<?php

echo htmlspecialchars(
    $product["name"]
);

?>

</h3>


<p>

Price:

$<?php

echo number_format(
    $product["price"],
    2
);

?>

</p>


<form method="POST">

<input
type="hidden"
name="product_id"
value="<?php echo $product["id"]; ?>"
>


<label for="quantity-<?php echo $product["id"]; ?>">

Quantity

</label>


<input
type="number"
id="quantity-<?php echo $product["id"]; ?>"
name="quantity"
value="<?php echo $quantity; ?>"
min="0"
>


<button
type="submit"
class="button small-button"
>
Update
</button>

<a
href="/purespring/Pages/cart.php?remove=<?php echo $product["id"]; ?>"
class="button small-button"
>
Remove
</a>


</form>


<p>

Item Total:

$<?php

echo number_format(
    $itemTotal,
    2
);

?>

</p>

</article>


<?php endforeach; ?>


<h3>

Cart Total:

$<?php

echo number_format(
    $cartTotal,
    2
);

?>

</h3>


<a
href="/purespring/Pages/checkout.php"
class="button"
>
Proceed to Checkout
</a>


<a
href="/purespring/Pages/store.php"
class="button"
>
Continue Shopping
</a>


<?php endif; ?>

</div>

</section>

</main>


<?php

require_once __DIR__ . "/../includes/footer.php";

?>
