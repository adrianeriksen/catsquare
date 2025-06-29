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
        <p>
            <span class="timestamp">On <?= date("Y-m-d H:i", strtotime($comment["created_at"])) ?></span>
        </p>
    </div>
</li>
