<li>
    <div class="avatar-container">
        <img src="/assets/avatar.png">
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
