<?php
define("ENDPOINT_REQUIRES_AUTHENTICATION", false);
define("PAGE_LAYOUT", "narrow.php");

include "includes/bootstrap.php";

function can_manage_comment($user_id, $cat_created_by_id, $comment_created_by_id) {
    return $user_id == $cat_created_by_id || $user_id == $comment_created_by_id;
}

function can_manage_cat($user_id, $cat_created_by_id) {
    return $user_id == $cat_created_by_id;
}

$variables = [];

$cat_id = $_GET["id"] ?? 0;

if ($cat_id <= 0)
    render_simple_response(400, "Bad request");

$cat = get_cat($conn, $cat_id);

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

        create_comment($conn, $comment);

        set_notice("Comment successfully published.");
        header("Location: /cat.php?id=" . $cat["id"]);
        exit();
    }
}

if (isset($_GET["action"]) && $_GET["action"] == "delete") {
    if ($_SERVER["REQUEST_METHOD"] != "GET")
        render_simple_response(405, "Method not allowed");

    $current_user_id = $context["authentication"]["user"]["id"];
    $cat_created_by_id = $cat["created_by"];

    // Authorization ligic for deletion
    if (!can_manage_cat($current_user_id, $cat_created_by_id))
        render_simple_response(403, "Forbidden");

    delete_cat($conn, $cat_id);

    set_notice("Cat successfully deleted.");
    header("Location: /");
    exit();
}

if (isset($_GET["action"]) && $_GET["action"] == "delete-comment") {
    if ($_SERVER["REQUEST_METHOD"] != "GET")
        render_simple_response(405, "Method not allowed");

    $comment_id = $_GET["comment-id"] ?? 0;

    if ($comment_id <= 0)
        render_simple_response(400, "Bad request");

    $comment = get_comment($conn, $comment_id);

    if (!$comment)
        render_simple_response(403, "Forbidden");

    $current_user_id = $context["authentication"]["user"]["id"];
    $cat_created_by_id = $cat["created_by"];
    $comment_created_by_id = $comment["created_by"];

    // Authorization logic for deletion
    if (!can_manage_comment($current_user_id, $cat_created_by_id, $comment_created_by_id))
        render_simple_response(403, "Forbidden");

    delete_comment($conn, $comment_id);

    set_notice("Comment successfully deleted.");
    header("Location: /cat.php?id=" . $cat["id"]);
    exit();
}

$author_id = $cat["created_by"];

$variables["cat"] = $cat;
$variables["author"] = get_user($conn, $author_id);
$variables["comments"] = get_comments_for_cat($conn, $cat_id);

$current_user_id = $context["authentication"]["user"]["id"];
$is_viewing_another_user = $context["authentication"]["is_authenticated"] && $current_user_id != $author_id;

$variables["is_viewing_another_user"] = $is_viewing_another_user;

$variables["is_following_author"] = $is_viewing_another_user ?
     is_following_relation_present($conn, $current_user_id, $author_id) : null;

render("show_cat.php", $variables, $context);
