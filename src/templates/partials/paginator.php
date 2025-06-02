<?php
$active_item_template = <<<EOD
<li class="active">%s</li>
EOD;

$item_template = <<<EOD
<li><a href="%s">%s</a></li>
EOD;
?>
<ul class="paginator">
    <?php
    foreach ($paginator as $item) {
        if ($item["active"])
            printf($active_item_template, $item["label"]);
        else
            printf($item_template, $item["path"], $item["label"]);
    }
    ?>
</ul>
