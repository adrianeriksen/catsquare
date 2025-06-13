<?php
session_start();

define("DATABASE_PATH", "database.sqlite");
define("CATS_PER_PAGE", 3);

if (!defined("ENDPOINT_REQUIRES_AUTHENTICATION"))
    define("ENDPOINT_REQUIRES_AUTHENTICATION", true);

if (!defined("PAGE_LAYOUT"))
    define("PAGE_LAYOUT", "default.php");

require_once "config.php";

function render($template, $variables = [], $context = []) {
    extract($variables);

    ob_start();
    require "templates/" . $template;
    $rendered_template = ob_get_clean();

    require "templates/layouts/" . PAGE_LAYOUT;
}

function render_simple_response($code, $message) {
    http_response_code($code);
    echo "<pre>" . $code . ": " . $message . "</pre>";
    exit(1);
}

try {
    $db = new mysqli(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_NAME);
} catch (Exception $e) {
    render_simple_response(500, "Internal server error");
}

require_once "includes/services/authentication_service.php";
require_once "includes/services/cat_service.php";
require_once "includes/services/comment_service.php";
require_once "includes/services/relations_service.php";
require_once "includes/services/user_service.php";

require_once "includes/notice.php";
require_once "includes/authentication.php";

$context["notice"] = get_notice_context_object();
$context["authentication"] = get_authentication_context_object($db);

require_once "includes/paths.php";

if (ENDPOINT_REQUIRES_AUTHENTICATION && !$context["authentication"]["is_authenticated"]) {
    header("Location: /login.php");
    exit();
}
