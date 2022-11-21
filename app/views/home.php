<?php
/**
 * @var App\Entities\Post[] $posts
 */
?>

    <h1>TOUS LES POSTS</h1>

    <?php foreach ($posts as $post): ?>
        <div class="post">
            <h2><?= $post->getTitle() ?></h2>
            <p><?= $post->getContent() ?></p>
            <p><?= $post->getCreatedAt() ?></p>
            <p><?= $post->getUpdatedAt() ?></p>
            <p><?= $post->getAuthor()->getUsername() ?></p>
        </div>
    <?php endforeach; ?>
