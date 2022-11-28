<?php
/**
 * @var App\Entities\Post[] $posts
 */

$postsLength = count($posts);
?>

<section class="section__OnTop">

    <?php if ($postsLength > 0): ?>
    <div class="OnTop__card">
        <span><?= $posts[0]->getCreatedAt() ?></span>
        <div class="aside-card__card-title">
            <h2><?= $posts[0]->getTitle() ?></h2>
            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path d="M24 3a3 3 0 0 0-3 3 3 3 0 0 0 .375 1.447L15.551 14H8.826A3 3 0 0 0 6 12a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 2.824-2h6.727l5.822 6.55A3 3 0 0 0 21 24a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3 3 3 0 0 0-1.13.223L17.337 15l5.531-6.223A3 3 0 0 0 24 9a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/></svg>
        </div>
        <picture class="OnTop-card-img">
            <img src="<?= $posts[0]->getHeroImageUrl() ?? '/assets/image/blackFriday.jpeg' ?>" alt="" />
        </picture>
        <div class="onTop__description">
            <p><?= $posts[0]->getContent() ?></p>
            <a href="/posts/<?= $posts[0]->getId() ?>" class="card-link">Lire la suite</a>
        </div>
    </div>
    <?php endif; ?>

    <div class="OnTop__aside">
        <?php $i = 1; ?>
        <?php while ($i < 4 && $i < $postsLength): ?>
            <div class="OnTop__aside-card">
                <picture class="aside-card__card-img">
                    <img src= "<?= $posts[$i]->getHeroImageUrl() ?? '/assets/image/blackFriday.jpeg' ?>" alt="" />
                </picture>
                <div class="aside-card__description">
                    <span><?= $posts[$i]->getCreatedAt() ?></span>
                    <div class="aside-card__card-title">
                        <h2><?= $posts[$i]->getTitle() ?></h2>
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path d="M24 3a3 3 0 0 0-3 3 3 3 0 0 0 .375 1.447L15.551 14H8.826A3 3 0 0 0 6 12a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 2.824-2h6.727l5.822 6.55A3 3 0 0 0 21 24a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3 3 3 0 0 0-1.13.223L17.337 15l5.531-6.223A3 3 0 0 0 24 9a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/></svg>
                    </div>
                    <p><?= $posts[$i]->getContent() ?></p>
                    <a href="/posts/<?= $posts[$i]->getId() ?>" class="card-link">Lire la suite</a>
                </div>
            </div>
            <?php $i++; ?>
        <?php endwhile; ?>
    </div>
</section>

<section class="section__BestVue">
    <div class="BestVue-row">
        <?php $j = $i; ?>
        <?php $i = 0; ?>
        <?php while ($i < 5 && $j < $postsLength): ?>
            <div class="BestVue__card">
                <picture class="card__card-img">
                    <img src= "<?= $posts[$i]->getHeroImageUrl() ?? '/assets/image/blackFriday.jpeg' ?>" alt="" />
                </picture>
                <span><?= $posts[$i]->getCreatedAt() ?></span>
                <div class="card__card-title">
                    <h2><?= $posts[$i]->getTitle() ?></h2>
                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30"><path d="M24 3a3 3 0 0 0-3 3 3 3 0 0 0 .375 1.447L15.551 14H8.826A3 3 0 0 0 6 12a3 3 0 0 0-3 3 3 3 0 0 0 3 3 3 3 0 0 0 2.824-2h6.727l5.822 6.55A3 3 0 0 0 21 24a3 3 0 0 0 3 3 3 3 0 0 0 3-3 3 3 0 0 0-3-3 3 3 0 0 0-1.13.223L17.337 15l5.531-6.223A3 3 0 0 0 24 9a3 3 0 0 0 3-3 3 3 0 0 0-3-3z"/></svg>
                </div>
                <p><?= $posts[$i]->getContent() ?></p>
                <a href="/posts/<?= $posts[$i]->getId() ?>" class="card-link">Lire la suite</a>
            </div>
        <?php $i++; ?>
        <?php endwhile; ?>
    </div>
</section>
