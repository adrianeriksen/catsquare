<?php
function set_notice($message) {
    $_SESSION["notice"] = ["message" => $message];
}

function get_notice_context_object() {
    if (isset($_SESSION["notice"])) {
        $notice = $_SESSION["notice"];
        $_SESSION["notice"] = null;
    } else {
        $notice = null;
    }

    return $notice;
}
