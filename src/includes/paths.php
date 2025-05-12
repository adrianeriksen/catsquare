<?php
function get_index_path() {
    return "index.php";
}

function get_discover_path() {
    return "discover.php";
}

function get_relations_path($action, $username) {
    return "/relations.php?action=$action&username=$username";
}

function get_user_path($username) {
    return "/user.php?username=$username";
}
