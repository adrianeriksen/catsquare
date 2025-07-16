<?php
define("PAGE_LAYOUT", "narrow.php");

require_once "includes/bootstrap.php";

function get_profile_fields($context) {
    $user = $context["authentication"]["user"];
    return array_intersect_key($user, array_flip(["tagline", "webpage"]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $errors = [];

    $input_webpage = isset($_POST["webpage"]) ?
        filter_input(INPUT_POST, "webpage", FILTER_VALIDATE_URL) : "";

    if ($_POST["tagline"]) {
        $input_tagline = filter_input(INPUT_POST, "tagline", FILTER_SANITIZE_SPECIAL_CHARS);

        if (grapheme_strlen($input_tagline) > 200) {
            $errors["tagline"] = "Tagline can't be over 200 characters.";
        }
    } else {
        $input_tagline = "";
    }

    if (!$errors) {
        update_user($conn, $context["authentication"]["user"]["id"], $input_tagline, $input_webpage);
        set_notice("Profile successfully updated.");
        header("Location: /settings.php", 302);
        exit();
    }

    $profile = [
        "tagline" => $input_tagline,
        "webpage" => $input_webpage,
    ];
} else {
    $profile = get_profile_fields($context);
}

$variables = [
    "profile" => $profile,
];

render("settings.php", $variables, $context);
