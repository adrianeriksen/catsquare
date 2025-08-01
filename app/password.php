<?php
const PAGE_LAYOUT = "narrow.php";

require_once "includes/bootstrap.php";

$form_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_current_password_value = $_POST["current_password"];
    $form_new_password_value = $_POST["new_password"];
    $form_confirm_new_password_value = $_POST["confirm_new_password"];

    if ($err = validate_password($form_new_password_value, $form_confirm_new_password_value))
        $form_errors["new_password"] = $err;

    $user_id = $context["authentication"]["user"]["id"];
    $username = $context["authentication"]["user"]["username"];

    if (!verify_credentials($conn, $username, $form_current_password_value))
        $form_errors["current_password"] = "Wrong password";

    if (!$form_errors) {
        update_password_for_user($conn, $user_id, $form_new_password_value);
        set_notice("Password successfully updated. Please login again.");
        header("Location: /login.php");
        exit();
    }
}

$variables = [
    "form_errors" => $form_errors,
];

render("update_password.php", $variables, $context);
