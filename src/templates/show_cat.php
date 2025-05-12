<?php
$comment_path = "cat.php?id=" . $cat["id"] . "&action=comment";
?>
<div class="white-background">
    <img src="uploads/<?= $cat["image_path"] ?>" alt="" class="cat-image">

    <div class="main">
        <p>
            <em>
                <a href="<?= get_permalink_to_user($author["username"]) ?>"><?= $author["username"] ?></a>
            </em>
        </p>

        <?php if ($is_viewing_another_user): ?>
        <p>
            <?php if ($is_following_author): ?>
            <a href="<?= get_relations_path("unfollow", $author["username"]) ?>">Unfollow</a>
            <?php else: ?>
            <a href="<?= get_relations_path("follow", $author["username"]) ?>">Follow</a>
            <?php endif; ?>
        </p>
        <?php endif; ?>

        <ul class="comments" id="comments">
            <?php foreach ($comments as $comment): ?>
            <li>
                <strong>
                    <a href="<?= get_permalink_to_user($comment["username"]) ?>"><?= $comment["username"] ?></a>
                </strong>
                <?= $comment["comment"] ?>
            </li>
            <?php endforeach; ?>
        </ul>

        <?php if ($context["authentication"]["is_authenticated"]): ?>
        <form class="comment-form" action="<?= $comment_path ?>" method="post">
            <p>
                <textarea name="comment" placeholder="Type your comment..."></textarea>
            </p>
            <p>
                <button>Publish</button>
            </p>
        </form>
        <?php endif; ?>
    </div>
</div>
