<article class="cat-detail">
    <aside>
        <div class="avatar-container">
            <img src="/assets/avatar.png">
        </div>
        <div>
            <strong><a href="<?= get_user_path($author["username"]) ?>"><?= $author["username"] ?></a></strong>
            <?php if ($is_viewing_another_user): ?>
                <?php if ($is_following_author): ?>
                – <a href="<?= get_relations_path("unfollow", $author["username"]) ?>">Unfollow</a>
                <?php else: ?>
                – <a href="<?= get_relations_path("follow", $author["username"]) ?>">Follow</a>
                <?php endif; ?>
            <?php endif; ?>
            <br>
            <span class="timestamp">On <?= date("Y-m-d H:i", strtotime($cat["created_at"])) ?></span>
        </div>

    </aside>

    <main>
        <img src="uploads/<?= $cat["image_path"] ?>" alt="" class="cat-image">
    </main>

    <section class="comments">
        <ul>
            <?php foreach ($comments as $comment) require "templates/partials/comment.php" ?>
        </ul>

        <?php if ($context["authentication"]["is_authenticated"]): ?>
        <form class="comment-form" action="<?= get_cat_comment_path($cat["id"]) ?>" method="post">
            <div class="comment-input-wrapper">
                <input type="text" name="comment" placeholder="Type your comment...">
                <button>Meow</button>
            </div>
        </form>
        <?php endif; ?>
    </section>
</article>
