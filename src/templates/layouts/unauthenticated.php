
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

<div class="unauthenticated-container">
    <?php if ($context["notice"]): ?>
    <div class="success-notice">
        <?= $context["notice"]["message"] ?>
    </div>
    <?php endif; ?>

    <div class="unauthenticated-main">
        <header>
            <h3>Catsquare</h3>
        </header>

        <section>
            <?= $rendered_template ?>
        </section>
    </div>
</div>

</body>
</html>
