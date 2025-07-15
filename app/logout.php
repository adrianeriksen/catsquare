<?php
require_once "config.php";

session_start(SESSION_OPTIONS);
unset($_SESSION["authenticated_user"]);
header("Location: /");
