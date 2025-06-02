<?php
function generate_paginator($current_page, $number_of_items, $items_per_page, $path) {
    if ($number_of_items <= $items_per_page)
        return null;

    $elements = [];
    $last_page = ceil($number_of_items / $items_per_page);

    $separator = (str_contains($path, "?")) ? "&" : "?";

    if ($current_page > 1) {
        $page = 1;
        $elements[] = [
            "page" => $page,
            "label" => "«",
            "active" => false,
            "path" => "{$path}{$separator}page={$page}",
        ];
    }

    if ($current_page > 1) {
        $page = $current_page - 1;
        $elements[] = [
            "page" => $page,
            "label" => "‹",
            "active" => false,
            "path" => "{$path}{$separator}page={$page}",
        ];
    }

    $start = max(1, $current_page - 2);
    $end = min($last_page, $current_page + 2);

    foreach (range($start, $end) as $page) {
        $elements[] = [
            "page" => $page,
            "label" => strval($page),
            "active" => $page == $current_page,
            "path" => "{$path}{$separator}page={$page}",
        ];
    }

    if ($current_page < $last_page) {
        $page = $current_page + 1;
        $elements[] = [
            "page" => $current_page + 1,
            "label" => "›",
            "active" => false,
            "path" => "{$path}{$separator}page={$page}",
        ];
    }

    if ($current_page < $last_page) {
        $page = $last_page;
        $elements[] = [
            "page" => $page,
            "label" => "»",
            "active" => false,
            "path" => "{$path}{$separator}page={$page}",
        ];
    }

    return $elements;
}
