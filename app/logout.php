<?php
require_once "config.php";

session_start();
unset($_SESSION["authenticated_user"]);
header("Location: /");
