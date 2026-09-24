<?php

require_once __DIR__ . "/../controller/connect_controller.php";

?>

<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PureSpring Database</title>

    <link rel="stylesheet" href="/purespring/css/style.css">

</head>

<body>

<header class="site-header">

    <div class="container header-container">

        <div class="logo">

            <h1>PURE<span>SPRING</span></h1>

            <p>Water Solutions</p>

        </div>

        <nav class="main-nav">

            <a href="/purespring/index.php">Home</a>

            <a href="/purespring/Pages/store.php">Store</a>

        </nav>

    </div>

</header>


<main>

    <section class="mission">

        <div class="container">

            <h2>Database Connection Status</h2>

            <?php if ($connection_success): ?>

                <h3>Connection Successful</h3>

                <p>
                    <?php echo htmlspecialchars($connection_status); ?>
                </p>

            <?php else: ?>

                <h3>Connection Failed</h3>

                <p>
                    <?php echo htmlspecialchars($connection_status); ?>
                </p>

            <?php endif; ?>

        </div>

    </section>

</main>


</body>

</html>
