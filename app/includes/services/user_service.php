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

function get_user($conn, $id) {
    $query = "SELECT * FROM users WHERE id = ?";

    $result = mysqli_execute_query($conn, $query, [$id]);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$row)
        return null;

    return to_user_entry($row);
}

function get_user_by_username($conn, $username) {
    $query = "SELECT * FROM users WHERE username = ?";

    $result = mysqli_execute_query($conn, $query, [$username]);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

    if (!$row)
        return null;

    return to_user_entry($row);
}

function create_user($conn, $username, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = <<<QUERY
INSERT INTO users (username, hashed_password)
VALUES (?, ?)
QUERY;

    $params = [$username, $hashed_password];
    mysqli_execute_query($conn, $query, $params);
}

function update_user($conn, $id, $tagline, $webpage) {
    $query = <<<QUERY
UPDATE users
SET tagline = ?, webpage = ?
WHERE id = ?
QUERY;

    $params = [$tagline, $webpage, $id];
    mysqli_execute_query($conn, $query, $params);
}

function update_password_for_user($conn, $id, $password) {
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users SET hashed_password = ? WHERE id = ?";

    $params = [$hashed_password, $id];
    mysqli_execute_query($conn, $query, $params);
}
