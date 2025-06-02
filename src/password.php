<?php
define("PAGE_LAYOUT", "narrow.php");

require_once "includes/bootstrap.php";

$form_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_value_current_password = $_POST["current_password"];
    $form_value_new_password = $_POST["new_password"];
    $form_value_confirm_new_password = $_POST["confirm_new_password"];

    if (grapheme_strlen($form_value_new_password) < 8) {
        $form_errors["new_password"] = "Password must be at least 8 characters";
    }

    if (grapheme_strlen($form_value_new_password) > 256) {
        $form_errors["new_password"] = "Password can't exceed 256 characters";
    }

    if ($form_value_new_password != $form_value_confirm_new_password) {
        $form_errors["new_password"] = "Passwords doesn't match";
    }

    $user_id = $context["authentication"]["user"]["id"];
    $username = $context["authentication"]["user"]["username"];

    if (
        count($form_errors) == 0 &&
        verify_credentials($db, $username, $form_value_current_password)
    ) {
        update_password_for_user($db, $user_id, $form_value_new_password);
        header("Location: /login.php");
        exit();
    }
}

$variables = [
    "form_errors" => $form_errors,
];

render("update_password.php", $variables, $context);
