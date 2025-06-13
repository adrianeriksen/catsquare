<?php
function verify_credentials($conn, $username, $password) {
    $query = "SELECT hashed_password FROM users WHERE username = ?";

    $result = mysqli_execute_query($conn, $query, [$username]);
    $row = mysqli_fetch_assoc($result);

    if (!$row)
        return false;

    return password_verify($password, $row["hashed_password"]);
}
