<?php

session_start();

require_once __DIR__ . "/../controller/connect_controller.php";


if (!isset($_SESSION["cart"])) {
    $_SESSION["cart"] = [];
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $product_id = (int) $_POST["product_id"];

    if (isset($_SESSION["cart"][$product_id])) {

        $_SESSION["cart"][$product_id]++;

    } else {

        $_SESSION["cart"][$product_id] = 1;

    }

}


require_once __DIR__ . "/../includes/header.php";

?>

<main>

<section class="featured-products">

<div class="container">

<p class="small-heading">
PureSpring Store
</p>

<h2>
Our Products
</h2>


<div class="product-grid">

<?php

$productQuery = $pdo->query("

SELECT
products.id,
products.name,
products.price,
categories.name AS category_name

FROM products

LEFT JOIN categories
ON products.category_id = categories.id

ORDER BY products.name

");

$products = $productQuery->fetchAll(PDO::FETCH_ASSOC);


foreach ($products as $product):

?>

<article class="product-card">

<div class="product-image">

<?php

echo htmlspecialchars(
$product["category_name"]
);

?>

</div>


<h3>

<?php

echo htmlspecialchars(
$product["name"]
);

?>

</h3>


<p class="product-category">

<?php

echo htmlspecialchars(
$product["category_name"]
);

?>

</p>


<p class="price">

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

<button
type="submit"
class="button small-button"
>
Add to Cart
</button>

</form>

</article>


<?php endforeach; ?>

</div>

</div>

</section>

</main>


<?php

require_once __DIR__ . "/../includes/footer.php";

?>
