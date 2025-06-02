<?php
function to_user_entry($row) {
    return [
        "id" => $row["id"],
        "username" => $row["username"],
        "is_active" => $row["is_active"],
        "tagline" => htmlspecialchars($row["tagline"]),
        "webpage" => $row["webpage"],
    ];
}

function get_user($db, $id) {
    $query = "SELECT * FROM users WHERE id = :id";

    $stmt = $db->prepare($query);
    $stmt->bindValue(":id", $id);
    $result = $stmt->execute();
    $row = $result->fetchArray();

    if (!$row)
        return null;

    return to_user_entry($row);
}

function get_user_by_username($db, $username) {
    $query = "SELECT * FROM users WHERE username = :username";

    $stmt = $db->prepare($query);
    $stmt->bindValue(":username", $username);
    $result = $stmt->execute();
    $row = $result->fetchArray();

    if (!$row)
        return null;

    return to_user_entry($row);
}

function create_user($db, $username, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = <<<QUERY
INSERT INTO users (username, hashed_password)
VALUES (:username, :hashed_password)
QUERY;

    $statement = $db->prepare($query);
    $statement->bindValue(":username", $username);
    $statement->bindValue(":hashed_password", $hashed_password);

    $statement->execute();
}

function update_user($db, $user_id, $tagline, $webpage) {
    $query = <<<QUERY
UPDATE users
SET tagline = :tagline, webpage = :webpage
WHERE id = :user_id
QUERY;

    $stmt = $db->prepare($query);
    $stmt->bindValue(":tagline", $tagline);
    $stmt->bindValue(":webpage", $webpage);
    $stmt->bindValue(":user_id", $user_id);

    $result = $stmt->execute();
}

function update_password_for_user($db, $id, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET hashed_password = :hashed_password WHERE id = :id";

    $statement = $db->prepare($query);
    $statement->bindValue(":hashed_password", $hashed_password);
    $statement->bindValue("id", $id);

    $statement->execute();
}
