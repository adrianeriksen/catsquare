<?php
function display_url($url) {
    $components = parse_url($url);
    if ($components["path"] == "/") {
        $components["path"] = null;
    }
    return "{$components["host"]}{$components["path"]}";
}
?>
<?php if (isset($profile)): ?>
<header class="profile-header">
    <h2><?= $profile["username"] ?></h2>

    <?php if (!empty($profile["tagline"])): ?>
    <p><?= $profile["tagline"] ?></p>
    <?php endif; ?>

    <?php if (!empty($profile["webpage"])): ?>
    <p><a href="<?= $profile["webpage"] ?>"><?= display_url($profile["webpage"]) ?></a></p>
    <?php endif; ?>
</header>
<?php endif; ?>

<div class="photos-of-cats">
    <?php foreach ($cats as $cat) require "templates/partials/cat.php"; ?>
</div>

<?php if ($paginator) require "templates/partials/paginator.php"; ?>
