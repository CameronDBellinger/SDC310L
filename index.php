<?php

require_once __DIR__ . "/controller/connect_controller.php";

require_once __DIR__ . "/includes/header.php";

?>

<main>

<!-- HERO SECTION -->

<section class="hero">

<div class="container hero-container">

<article class="hero-text">

<p class="small-heading">
Sustainable Water Solutions
</p>

<h2>
Clean Water.<br>
Better Lives.
</h2>

<p>
PureSpring Water Solutions provides clean, safe, and sustainable water products for homes, communities, and off-grid living.
</p>

<p>
Shop water tanks, filters, pumps, hoses, fittings, and other products while supporting our mission to improve access to clean water.
</p>

<a
href="/purespring/Pages/store.php"
class="button"
>
Shop Now
</a>

</article>

<aside class="hero-image">

<div class="water-drop"></div>

</aside>

</div>

</section>


<!-- PRODUCT CATEGORIES -->

<section class="categories">

<div class="container">

<p class="small-heading">
Shop By Category
</p>

<h2>
Everything You Need for Your Water System
</h2>

<div class="category-grid">


<article class="category-card">

<div class="category-icon">💧</div>

<h3>Water Tanks</h3>

<p>
Water storage solutions for homes, farms, communities, and off-grid systems.
</p>

</article>


<article class="category-card">

<div class="category-icon">🚰</div>

<h3>Filters</h3>

<p>
Filtration systems designed to improve water quality and provide cleaner water.
</p>

</article>


<article class="category-card">

<div class="category-icon">⚙️</div>

<h3>Hoses & Pumps</h3>

<p>
Pumps and hoses designed to move water efficiently wherever it is needed.
</p>

</article>


<article class="category-card">

<div class="category-icon">🔧</div>

<h3>Fittings</h3>

<p>
Durable fittings and connectors for building reliable water systems.
</p>

</article>


<article class="category-card">

<div class="category-icon">👕</div>

<h3>Apparel</h3>

<p>
PureSpring shirts and apparel that support our clean-water mission.
</p>

</article>


<article class="category-card">

<div class="category-icon">⭐</div>

<h3>Stickers</h3>

<p>
PureSpring stickers and decals for supporters of our mission.
</p>

</article>


</div>

</div>

</section>


<!-- MISSION SECTION -->

<section class="mission">

<div class="container mission-container">

<article>

<p class="small-heading">
Our Mission
</p>

<h2>
Pure Water. Pure Impact.
</h2>

<p>
PureSpring Water Solutions is more than an online store. Our goal is to provide useful, dependable water products while helping improve access to clean water for families and communities in need.
</p>

<a
href="/purespring/Pages/about.php"
class="button"
>
Learn More
</a>

</article>


<aside class="mission-box">

<h3>
What We Focus On
</h3>

<ul>

<li>Clean Water</li>

<li>Quality Products</li>

<li>Sustainable Solutions</li>

<li>Community Impact</li>

<li>Secure Shopping</li>

</ul>

</aside>

</div>

</section>


<!-- FEATURED PRODUCTS -->

<section class="featured-products">

<div class="container">

<p class="small-heading">
Featured Products
</p>

<h2>
Popular PureSpring Products
</h2>


<div class="product-grid">

<?php

$productQuery = $pdo->query("

SELECT
products.name,
products.price,
categories.name AS category_name

FROM products

LEFT JOIN categories
ON products.category_id = categories.id

ORDER BY products.id

LIMIT 10

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


<a
href="/purespring/Pages/store.php"
class="button small-button"
>
View Product
</a>

</article>


<?php endforeach; ?>

</div>

</div>

</section>


<!-- CONTACT FORM -->

<section class="contact-form container">

<h2>
Contact Us
</h2>


<form>

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


<label for="subject">
Subject
</label>

<input
type="text"
id="subject"
name="subject"
>


<label for="message">
Message
</label>

<textarea
id="message"
name="message"
required
></textarea>


<button
type="submit"
class="button" 
>
Send Message
</button>

</form>

</section>

</main>


<?php

require_once __DIR__ . "/includes/footer.php";

?>
