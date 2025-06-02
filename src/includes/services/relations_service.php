<?php
function is_following_relation_present($db, $follower_id, $followee_id) {
    $query = <<<QUERY
SELECT count(*) AS number_of_relations FROM relations
WHERE follower_id = :follower_id AND following_id = :followee_id
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":follower_id", $follower_id);
    $stmt->bindValue(":followee_id", $followee_id);
    $row = $stmt->execute()->fetchArray();

    return $row["number_of_relations"] > 0;
}

function create_following_relation($db, $follower_id, $followee_id) {
    $query = <<<QUERY
INSERT INTO relations (follower_id, following_id)
VALUES (:follower_id, :followee_id)
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":follower_id", $follower_id);
    $stmt->bindValue(":followee_id", $followee_id);
    $stmt->execute();
}

function delete_following_relation($db, $follower_id, $followee_id) {
    $query = <<<QUERY
DELETE FROM relations
WHERE follower_id = :follower_id AND following_id = :followee_id
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":follower_id", $follower_id);
    $stmt->bindValue(":followee_id", $followee_id);
    $stmt->execute();
}
