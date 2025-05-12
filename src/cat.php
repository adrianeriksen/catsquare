<?php
define("ENDPOINT_REQUIRES_AUTHENTICATION", false);
define("PAGE_LAYOUT", "narrow.php");

include "includes/bootstrap.php";

$variables = [];

$cat_id = $_GET["id"] ?? 0;

if ($cat_id == 0)
    render_simple_response(400, "Bad request");

$cat = get_cat($db, $cat_id);

if ($cat == null)
    render_simple_response(404, "Page not found");

if (isset($_GET["action"]) && $_GET["action"] == "comment") {
    if ($_SERVER["REQUEST_METHOD"] != "POST")
        render_simple_response(405, "Method not allowed");

    $error = false;

    if (!isset($_POST["comment"]) || empty($_POST["comment"]))
        $error = true;

    if (!$error) {
        $comment = [
            "comment" => $_POST["comment"],
            "cat_id" => $cat["id"],
            "user_id" => $context["authentication"]["user"]["id"],
        ];

        create_comment($db, $comment);

        set_notice("Comment successfully published.");
        header("Location: /cat.php?id=" . $cat["id"]);
        exit();
    }
}

$author_id = $cat["created_by"];

$variables["cat"] = $cat;
$variables["author"] = get_user($db, $author_id);
$variables["comments"] = get_comments_for_cat($db, $cat_id);

$current_user_id = $context["authentication"]["user"]["id"];
$is_viewing_another_user = $context["authentication"]["is_authenticated"] && $current_user_id != $author_id;

$variables["is_viewing_another_user"] = $is_viewing_another_user;

if ($is_viewing_another_user) {
    $variables["is_following_author"] = is_following_relation_present($db, $current_user_id, $author_id);
} else {
    $variables["is_following_author"] = null;
}

render("show_cat.php", $variables, $context);
