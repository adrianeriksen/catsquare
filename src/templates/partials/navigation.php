<ul>
    <li><a href="upload.php">Upload</a></li>
    <li><a href="discover.php">Discover</a></li>
    <li>
        <a href="<?= get_permalink_to_user($context["authentication"]["user"]["username"]) ?>">
            Logged in as <?= $context["authentication"]["user"]["username"] ?>
        </a>
    </li>
    <li><a href="settings.php">Settings</a><li>
    <li><a href="logout.php">Log out</a></li>
</ul>
