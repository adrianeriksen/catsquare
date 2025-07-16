<?php
include "includes/bootstrap.php";
include "includes/paginator.php";

$username = $_GET["username"] ?? null;

if (!$username)
    render_simple_response(400, "Bad request");

$user = get_user_by_username($conn, $username);

if (!$user)
    render_simple_response(404, "Page not found");

$variables = [];

$page = $_GET["page"] ?? 1;
$page = filter_var($page, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if (!$page)
    render_simple_response(400, "Bad request");

$number_of_cats = get_number_of_cats_for_user_id($conn, $user["id"]);

if ($number_of_cats > 0) {
    if ($page > ceil($number_of_cats / CATS_PER_PAGE))
        render_simple_response(404, "Page not found");

    $variables["cats"] = list_cats_by_user_id($conn, $user["id"], $page);
    $variables["paginator"] = generate_paginator($page, $number_of_cats, CATS_PER_PAGE, get_user_path($username));
} else {
    $variables["cats"] = [];
    $variables["paginator"] = null;
}

$variables["profile"] = $user;

render("list_cats.php", $variables, $context);
