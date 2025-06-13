<?php
function to_comment_entry($row) {
    return [
        "id" => $row["id"],
        "comment" => $row["comment"],
        "username" => $row["username"],
        "created_at" => $row["created_at"],
    ];
}

function create_comment($conn, $comment) {
    $query = <<<QUERY
INSERT INTO comments (comment, cat_id, created_by)
VALUES (?, ?, ?)
QUERY;

    $params = [$comment["comment"], $comment["cat_id"], $comment["user_id"]];
    mysqli_execute_query($conn, $query, $params);
}

function get_comments_for_cat($conn, $cat_id) {
    $query = <<<QUERY
SELECT comments.id AS id, comments.comment AS comment, users.username AS username, comments.created_at AS created_at
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
