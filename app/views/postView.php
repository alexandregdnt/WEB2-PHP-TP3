<?php
/**
 * @var App\Entities\Post $post
 */
?>

<h1><?= $post->getTitle() ?></h1>

<div class="post">
    <h2><?= $post->getTitle() ?></h2>
    <p><?= $post->getContent() ?></p>
    <p><?= $post->getAuthor()->getUsername() ?></p>
</div>