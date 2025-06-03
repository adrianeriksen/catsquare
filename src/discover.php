<?php
require "includes/bootstrap.php";
require "includes/paginator.php";

$variables = [];

$page = $_GET["page"] ?? 1;
$page = filter_var($page, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);

if (!$page)
    render_simple_response(400, "Bad request");

$number_of_cats = get_number_of_cats($db);

if ($number_of_cats > 0) {
    if ($page > ceil($number_of_cats / CATS_PER_PAGE))
        render_simple_response(404, "Page not found");

    $variables["cats"] = list_cats($db, $page);
    $variables["paginator"] = generate_paginator($page, $number_of_cats, CATS_PER_PAGE, get_discover_path());
} else {
    $variables["cats"] = [];
    $variables["paginator"] = null;
}


render("list_cats.php", $variables, $context);
