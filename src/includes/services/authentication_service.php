<?php
function verify_credentials($db, $username, $password)
{
    $query = "SELECT hashed_password FROM users WHERE username = :username";

    $statement = $db->prepare($query);
    $statement->bindValue(":username", $username);
    $result = $statement->execute();
    $row = $result->fetchArray();

    if (!$row)
        return false;

    $hash = $row["hashed_password"];

    return password_verify($password, $hash);
}
