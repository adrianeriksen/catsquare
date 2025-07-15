<?php
function to_comment_entry($row) {
    return [
        "id" => $row["id"],
        "comment" => $row["comment"],
        "username" => $row["username"],
        "created_at" => $row["created_at"],
        "created_by" => $row["created_by"],
    ];
}

function get_comment($conn, $id) {
    $query = <<<QUERY
SELECT comments.id AS id, comments.comment AS comment, users.username AS username, comments.created_by AS created_by, comments.created_at AS created_at
FROM comments
LEFT JOIN users ON comments.created_by = users.id
WHERE comments.id = ?
QUERY;

    $result = mysqli_execute_query($conn, $query, [$id]);
    $row = mysqli_fetch_assoc($result);

    if (!$row)
        return false;

    return to_comment_entry($row);
}

function create_comment($conn, $comment) {
    $query = <<<QUERY
INSERT INTO comments (comment, cat_id, created_by)
VALUES (?, ?, ?)
QUERY;

    $params = [$comment["comment"], $comment["cat_id"], $comment["user_id"]];
    mysqli_execute_query($conn, $query, $params);
}

function delete_comment($conn, $id) {
    $query = "DELETE FROM comments WHERE id = ?";
    mysqli_execute_query($conn, $query, [$id]);
}

function get_comments_for_cat($conn, $cat_id) {
    $query = <<<QUERY
SELECT comments.id AS id, comments.comment AS comment, users.username AS username, comments.created_by AS created_by, comments.created_at AS created_at
FROM comments
LEFT JOIN users ON comments.created_by = users.id
WHERE comments.cat_id = ?
QUERY;

    $result = mysqli_execute_query($conn, $query, [$cat_id]);

    $comments = [];

    while ($row = mysqli_fetch_assoc($result))
        $comments[] = to_comment_entry($row);

    return $comments;
}
