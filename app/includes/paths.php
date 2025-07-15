<?php
function get_index_path() {
    return "index.php";
}

function get_discover_path() {
    return "discover.php";
}

function get_cat_comment_path($id) {
    return "/cat.php?id=$id&action=comment";
}

function get_cat_delete_comment_path($cat_id, $comment_id) {
    return "/cat.php?id=$cat_id&action=delete-comment&comment-id=$comment_id";
}

function get_relations_path($action, $username) {
    return "/relations.php?action=$action&username=$username";
}

function get_user_path($username) {
    return "/user.php?username=$username";
}
