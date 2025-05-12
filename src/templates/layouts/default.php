<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catsquare</title>
    <link rel="stylesheet" href="assets/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%2210 0 100 100%22><text y=%22.90em%22 font-size=%2290%22>🐈</text></svg>">
</head>

<body>

<header class="top-header">
    <div class="wrapper">
        <h1><a href="/">Catsquare</a></h1>
        <nav>
            <?php
            if ($context["authentication"]["is_authenticated"])
                include "templates/partials/navigation.php";
            ?>
        </nav>
    </div>
</header>

<?php if ($context["notice"]): ?>
<div class="success-notice">
    <div class="wrapper">
        <?= $context["notice"]["message"] ?>
    </div>
</div>
<?php endif; ?>

<div class="wrapper primary-section">
    <?= $rendered_template ?>
<div>

</body>
</html>
