<?php
function is_following_relation_present($conn, $follower_id, $followee_id) {
    $query = <<<QUERY
SELECT count(*) AS number_of_relations FROM relations
WHERE follower_id = ? AND followee_id = ?
QUERY;

    $params = [$follower_id, $followee_id];
    $result = mysqli_execute_query($conn, $query, $params);
    $row = mysqli_fetch_assoc($result);

    return $row["number_of_relations"] > 0;
}

function create_following_relation($conn, $follower_id, $followee_id) {
    $query = <<<QUERY
INSERT INTO relations (follower_id, followee_id)
VALUES (?, ?)
QUERY;

    $params = [$follower_id, $followee_id];
    mysqli_execute_query($conn, $query, $params);
}

function delete_following_relation($conn, $follower_id, $followee_id) {
    $query = <<<QUERY
DELETE FROM relations
WHERE follower_id = :follower_id AND followee_id = :followee_id
QUERY;

    $params = [$follower_id, $followee_id];
    mysqli_execute_query($conn, $query, $params);
}
