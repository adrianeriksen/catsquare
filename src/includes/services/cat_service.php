<?php
function to_cat_entry($row) {
    return [
        "id" => $row["id"],
        "image_path" => $row["image_path"],
        "created_by" => $row["created_by"],
        "created_at" => $row["created_at"],
    ];
}

function get_cat($db, $id) {
    $query = "SELECT * FROM cats WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $id);
    $result = $stmt->execute();

    $row = $result->fetchArray(SQLITE3_ASSOC);

    if (!$row)
        return false;

    return to_cat_entry($row);
}

function list_cats($db, $page) {
    $query = <<<QUERY
SELECT * FROM cats
ORDER BY created_at DESC
LIMIT :limit OFFSET :offset
QUERY;

    $offset = CATS_PER_PAGE * ($page - 1);

    $stmt = $db->prepare($query);
    $stmt->bindValue(":limit", CATS_PER_PAGE);
    $stmt->bindValue(":offset", $offset);
    $result = $stmt->execute();

    $cats = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC))
        $cats[] = to_cat_entry($row);

    return $cats;
}

function get_number_of_cats($db) {
    $query = <<<QUERY
SELECT count(*) AS number_of_cats FROM cats
QUERY;

    $row = $db->query($query)->fetchArray();
    return $row["number_of_cats"];
}

function list_cats_for_index($db, $page, $current_user) {
    $query = <<<QUERY
SELECT * FROM cats
WHERE created_by IN (
    SELECT following_id FROM relations
    WHERE follower_id = :current_user)
ORDER BY created_at DESC
LIMIT :limit OFFSET :offset
QUERY;

    $offset = CATS_PER_PAGE * ($page - 1);

    $stmt = $db->prepare($query);
    $stmt->bindValue(":limit", CATS_PER_PAGE);
    $stmt->bindValue(":offset", $offset);
    $stmt->bindValue(":current_user", $current_user);
    $result = $stmt->execute();

    $cats = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC))
        $cats[] = to_cat_entry($row);

    return $cats;
}

function get_number_of_cats_for_index($db, $current_user) {
    $query = <<<QUERY
SELECT COUNT(*) AS num_cats FROM cats
WHERE created_by IN (
    SELECT following_id FROM relations
    WHERE follower_id = :current_user)
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":current_user", $current_user);
    $result = $stmt->execute();
    $row = $result->fetchArray();

    return $row["num_cats"];
}

function create_cat($db, $comment, $image_name, $created_by_id) {
    $query = <<<QUERY
INSERT INTO cats (image_path, created_by)
VALUES (:image_path, :created_by_id)
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":image_path", $image_name);
    $stmt->bindValue(":created_by_id", $created_by_id);
    $stmt->execute();

    $id = $db->lastInsertRowID();

    if (!empty($comment)) {
        $comment = [
            "comment" => $comment,
            "cat_id" => $id,
            "user_id" => $created_by_id,
        ];

        create_comment($db, $comment);
    }

    return $id;
}

function list_cats_by_user_id($db, $user_id, $page)
{
    $query =
        "SELECT * FROM cats WHERE created_by = :user_id ORDER BY created_at DESC LIMIT :limit OFFSET :offset";
    $offset = CATS_PER_PAGE * ($page - 1);

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user_id);
    $stmt->bindValue(":limit", CATS_PER_PAGE);
    $stmt->bindValue(":offset", $offset);
    $result = $stmt->execute();

    $cats = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC))
        $cats[] = to_cat_entry($row);

    return $cats;
}

function get_number_of_cats_for_user_id($db, $user_id)
{
    $query = "SELECT COUNT(*) AS num_cats FROM cats WHERE created_by = :user_id";

    $stmt = $db->prepare($query);
    $stmt->bindValue(":user_id", $user_id);
    $result = $stmt->execute();

    $row = $result->fetchArray();

    return $row["num_cats"];
}
