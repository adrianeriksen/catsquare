<li>
    <div class="avatar-container">
        <?= get_avatar_tag($comment["username"], "sm") ?>
    </div>
    <div class="content-container">
        <p>
            <strong>
                <a href="<?= get_user_path($comment["username"]) ?>"><?= $comment["username"] ?></a>
            </strong>
            <?= htmlspecialchars($comment["comment"]) ?>
        </p>
        <p class="timestamp">
            On <?= date("Y-m-d H:i", strtotime($comment["created_at"])) ?>
           <?php if (can_manage_comment($context["authentication"]["user"]["id"], $cat["created_by"], $comment["created_by"])): ?> - <a href="<?= get_cat_delete_comment_path($cat["id"], $comment["id"]) ?>">Delete</a><?php endif; ?>
        </p>
    </div>
</li>
