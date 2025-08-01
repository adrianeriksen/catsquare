<?php
const ENDPOINT_REQUIRES_AUTHENTICATION = false;
const PAGE_LAYOUT = "unauthenticated.php";

include "includes/bootstrap.php";

$form_errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $form_username_value = $_POST["username"];
    $form_password_value = $_POST["password"];
    $form_confirm_password_value = $_POST["confirm_password"];

    if (!preg_match("/^[a-zA-Z0-9]+$/", $form_username_value))
        $form_errors["username"] = "Username can only contain characters A to Z and numbers";

    if (strlen($form_username_value) > 16)
        $form_errors["username"] = "Username can't exceed 16 characters";

    if (!isset($form_username_value) || strlen($form_username_value) == 0)
        $form_errors["username"] = "Username can't be blank";

    if (get_user_by_username($conn, $form_username_value))
        $form_errors["username"] = "Username is already taken";

    if ($err = validate_password($form_password_value, $form_confirm_password_value))
        $form_errors["password"] = $err;

    if (!$form_errors) {
        create_user($conn, $form_username_value, $form_password_value);
        set_notice("User successfully created. An administrator must active the account before you can login.");
        header("Location: /login.php");
        exit();
    }
} else {
    $form_username_value = "";
}

$variables = [
    "form_username_value" => $form_username_value,
    "form_errors" => $form_errors,
];

render("create_user_form.php", $variables, $context);
