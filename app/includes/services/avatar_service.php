<?php
function get_avatar_properties($username) {
    $char = strtoupper(substr($username, 0, 1));


    $hash = md5($username);
    $part = hexdec(substr($hash, -2));
    $color = ($part & 3) + 1;

    return compact("char", "color");
}

function get_avatar_tag($username, $size) {
    extract(get_avatar_properties($username));
    $classes = "avatar avatar-" . $size . " avatar-color-" . $color;

    return <<<HTML
<div class="$classes">$char</div>
HTML;
}
