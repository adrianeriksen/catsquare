<?php
function to_comment_entry($row) {
    return [
        "id" => $row["id"],
        "comment" => $row["comment"],
        "username" => $row["username"],
        "created_at" => $row["created_at"],
    ];
}

function create_comment($db, $comment) {
    $query = <<<QUERY
INSERT INTO comments (comment, cat_id, created_by)
VALUES (:comment, :cat_id, :created_by)
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":comment", $comment["comment"]);
    $stmt->bindValue(":cat_id", $comment["cat_id"]);
    $stmt->bindValue(":created_by", $comment["user_id"]);
    $stmt->execute();
}

function get_comments_for_cat($db, $cat_id) {
    $query = <<<QUERY
SELECT comments.id AS id, comments.comment AS comment, users.username AS username, comments.created_at AS created_at
FROM comments
LEFT JOIN users ON comments.created_by = users.id
WHERE comments.cat_id = :cat_id;
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":cat_id", $cat_id);
    $result = $stmt->execute();

    $comments = [];

    while ($row = $result->fetchArray(SQLITE3_ASSOC))
        $comments[] = to_comment_entry($row);

    return $comments;
}
