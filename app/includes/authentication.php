<?php
function get_authentication_context_object($conn) {
    if (isset($_SESSION["authenticated_user"])) {
        $user = get_user_by_username($conn, $_SESSION["authenticated_user"]);
        return [
            "is_authenticated" => true,
            "user" => $user,
        ];
    }

    return [
        "is_authenticated" => false,
        "user" => null,
    ];
}
