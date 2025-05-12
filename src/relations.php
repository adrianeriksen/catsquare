<?php
include "includes/bootstrap.php";

if (!isset($_GET["action"]) || !isset($_GET["username"]))
    render_simple_response(400, "Bad request");

$param_username = $_GET["username"];

if (!preg_match("/^[a-zA-Z0-9]+$/", $param_username))
    render_simple_response(400, "Bad request");

$followee = get_user_by_username($db, $param_username);

if (!$followee)
    render_simple_response(400, "Bad request");

$follower_id = $context["authentication"]["user"]["id"];
$followee_id = $followee["id"];

if ($follower_id == $followee_id)
    render_simple_response(400, "Bad request");

$relation_exists = is_following_relation_present($db, $follower_id, $followee_id);

if ($_GET["action"] == "follow") {
    if ($relation_exists)
        render_simple_response(400, "Bad request");

    create_following_relation($db, $follower_id, $followee_id);
} elseif ($_GET["action"] == "unfollow") {
    if (!$relation_exists)
        render_simple_response(400, "Bad request");

    delete_following_relation($db, $follower_id, $followee_id);
} else {
    render_simple_response(400, "Bad request");
}

header("Location: /index.php");
exit();
