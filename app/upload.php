<?php
define("PAGE_LAYOUT", "narrow.php");
define("TARGET_SIDE", 480);

include "includes/bootstrap.php";

$variables = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $caption_value = $_POST["caption"];
    $file_content_type = $_FILES["image"]["type"];

    if ($file_content_type == "image/jpeg") {
        $image = imagecreatefromjpeg($_FILES["image"]["tmp_name"]);
    } elseif ($file_content_type == "image/webp") {
        $image = imagecreatefromwebp($_FILES["image"]["tmp_name"]);
    } elseif ($file_content_type == "image/png") {
        $image = imagecreatefrompng($_FILES["image"]["tmp_name"]);
    }

    if (!isset($image) || !$image) {
        render_simple_response(400, "Bad request");
    }

    $side = min(imagesx($image), imagesy($image));

    $image = imagecrop($image, ["x" => 0, "y" => 0, "width" => $side, "height" => $side]);
    $image = imagescale($image, TARGET_SIDE);

    $final_filename = uniqid() . ".webp";

    imagewebp($image, "uploads/" . $final_filename);

    $cat_id = create_cat($db, $caption_value, $final_filename, $context["authentication"]["user"]["id"]);

    set_notice("Cat image successfully uploaded.");
    header("Location: /cat.php?id=$cat_id");
    exit();
}

render("create_cat_form.php", $variables, $context);
