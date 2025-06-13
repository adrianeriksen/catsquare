<?php
function to_cat_entry($row) {
    return [
        "id" => $row["id"],
        "image_path" => $row["image_filename"],
        "created_by" => $row["created_by"],
        "created_at" => $row["created_at"],
    ];
}

function get_cat($conn, $id) {
    $query = "SELECT * FROM cats WHERE id = ?";

    $result = mysqli_execute_query($conn, $query, [$id]);
    $row = mysqli_fetch_assoc($result);

    if (!$row)
        return false;

    return to_cat_entry($row);
}

function list_cats($conn, $page) {
    $query = <<<QUERY
SELECT * FROM cats
ORDER BY created_at DESC
LIMIT ? OFFSET ?
QUERY;

    $offset = CATS_PER_PAGE * ($page - 1);

    $params = [CATS_PER_PAGE, $offset];
    $result = mysqli_execute_query($conn, $query, $params);

    $cats = [];

    while ($row = mysqli_fetch_assoc($result))
        $cats[] = to_cat_entry($row);

    return $cats;
}

function get_number_of_cats($conn) {
    $query = "SELECT count(*) AS number_of_cats FROM cats";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    return $row["number_of_cats"];
}

function list_cats_for_index($conn, $page, $current_user_id) {
    $query = <<<QUERY
SELECT * FROM cats
WHERE created_by IN (
    SELECT followee_id FROM relations
    WHERE follower_id = ?)
ORDER BY created_at DESC
LIMIT :limit OFFSET :offset
QUERY;

    $offset = CATS_PER_PAGE * ($page - 1);

    $params = [$current_user_id, CATS_PER_PAGE, $offset];
    $result = mysqli_execute_query($conn, $query, $params);

    $cats = [];

    while ($row = mysqli_fetch_assoc($result))
        $cats[] = to_cat_entry($row);

    return $cats;
}

function get_number_of_cats_for_index($conn, $current_user_id) {
    $query = <<<QUERY
SELECT COUNT(*) AS num_cats FROM cats
WHERE created_by IN (
    SELECT followee_id FROM relations
    WHERE follower_id = ?)
QUERY;

    $result = mysqli_execute_query($conn, $query, [$current_user_id]);
    $row = mysqli_fetch_assoc($result);

    return $row["num_cats"];
}

function create_cat($conn, $comment, $image_filename, $created_by_id) {
    $query = <<<QUERY
INSERT INTO cats (image_filename, created_by)
VALUES (?, ?)
QUERY;

    $params = [$image_filename, $created_by_id];
    $result = mysqli_execute_query($conn, $query, $params);

    $id = mysqli_insert_id($conn);

    if (!empty($comment)) {
        $comment = [
            "comment" => $comment,
            "cat_id" => $id,
            "user_id" => $created_by_id,
        ];

        create_comment($conn, $comment);
    }

    return $id;
}

function list_cats_by_user_id($conn, $user_id, $page) {
    $query = <<<QUERY
SELECT * FROM cats
WHERE created_by = ?
ORDER BY created_at DESC
LIMIT ? OFFSET ?
QUERY;

    $offset = CATS_PER_PAGE * ($page - 1);

    $params = [$user_id, CATS_PER_PAGE, $offset];
    $result = mysqli_execute_query($conn, $query, $params);

    $cats = [];

    while ($row = mysqli_fetch_assoc($result))
        $cats[] = to_cat_entry($row);

    return $cats;
}

function get_number_of_cats_for_user_id($conn, $user_id) {
    $query = "SELECT COUNT(*) AS num_cats FROM cats WHERE created_by = ?";

    $result = mysqli_execute_query($conn, $query, [$user_id]);
    $row = mysqli_fetch_assoc($result);

    return $row["num_cats"];
}
