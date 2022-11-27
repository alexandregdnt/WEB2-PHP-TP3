<?php
/**
 * @var App\Entities\Post $post
 * @var App\Entities\Comment $comments[]
 */
?>

<h1><?= $post->getTitle() ?></h1>

<div class="post">
    <img src="<?= $post->getHeroImageUrl() ?? '/assets/image/blackFriday.jpeg' ?>" style="display: block; height: auto; width: 250px;" alt="" />
    <span><?= $post->getCreatedAt() ?></span>
    <p><?= $post->getContent() ?></p>
    <a href="/users/<?= $post->getAuthor()->getId() ?>"><?= $post->getAuthor()->getUsername() ?></a>

    <?php if ($this->getUser() && $post->getAuthor()->getId() === $this->getUser()->getId()): ?>
        <a href="/posts/<?= $post->getId() ?>/edit">Modifier</a>
        <a href="/posts/<?= $post->getId() ?>/delete">Supprimer</a>
    <?php endif; ?>

    <div class="comments">
        <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <p><?= $comment->getContent() ?></p>
                    <a href="/users/<?= $comment->getAuthor()->getId() ?>"><?= $comment->getAuthor()->getUsername() ?></a>

                    <?php if ($this->getUser() && $comment->getAuthor()->getId() === $this->getUser()->getId()): ?>
                        <a href="/comments/<?= $comment->getId() ?>/edit">Modifier</a>
                        <a href="/comments/<?= $comment->getId() ?>/delete">Supprimer</a>
                    <?php endif; ?>

                    <?php if (!empty($comment->getAnswers())): ?>
                        <ul>
                            <?php foreach ($comment->getAnswers() as $answer): ?>
                                <li>
                                    <p><?= $answer->getContent() ?></p>
                                    <a href="/users/<?= $answer->getAuthor()->getId() ?>"><?= $answer->getAuthor()->getUsername() ?></a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <?php if ($this->getUser()): ?>
        <form action="/posts/<?= $post->getId() ?>/comment" method="post">
            <textarea name="content" id="content" cols="30" rows="10"></textarea>
            <button type="submit">Commenter</button>
        </form>
    <?php endif; ?>
</div>