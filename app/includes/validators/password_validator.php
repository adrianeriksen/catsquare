<?php
function is_password_banned($password) {
    if (!file_exists(BANNED_PASSWORDS_FILE))
        return false;

    $banned_passwords = file(BANNED_PASSWORDS_FILE, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    return in_array($password, $banned_passwords);
}

function validate_password($password, $password2) {
    if (grapheme_strlen($password) < 8)
        return "Password must be at least 8 characters";

    if (grapheme_strlen($password) > 256)
        return "Password can't exceed 256 characters";

    if (is_password_banned($password))
        return "Password is to common";

    if ($password != $password2)
        return "Passwords doesn't match";

    return null;
}
