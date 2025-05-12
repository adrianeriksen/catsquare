<?php
define("ENDPOINT_REQUIRES_AUTHENTICATION", false);
define("PAGE_LAYOUT", "unauthenticated.php");

include "includes/bootstrap.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = verify_credentials($db, $_POST["username"], $_POST["password"]);

    if ($login) {
        $user = get_user_by_username($db, $_POST["username"]);

        if (!$user['is_active']) {
            set_notice("Your account must be activated by an administrator before you can login!");
            header("Location: /login.php", false, 302);
            exit();
        }

        session_regenerate_id(true);

        $_SESSION["authenticated_user"] = $_POST["username"];
        header("Location: /", false, 302);
        exit();
    }
}

render("login_form.php", [], $context);
