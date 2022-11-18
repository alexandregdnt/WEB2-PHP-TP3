
    <h1>TOUS LES POSTS</h1>

    <?php
    /** @var App\Entities\Post[] $posts */
    foreach ($posts as $post) {
        echo $post->getContent();
    }
    ?>
