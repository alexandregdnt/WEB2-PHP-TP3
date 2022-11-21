<?php
/**
 * @var App\Entities\User $user
 * @var bool $userIsConnected
 * @var bool $userIsAdmin
 */
?>

<section class="section user-details" id="user-details">
    <h2>Profil de <?= $user->getUsername(); ?></h2>
    <div class="user-details__content">
        <div class="user-details__content__left">
            <div class="user-details__content__left__avatar">
                <img src="https://www.gravatar.com/avatar/<?= md5($user->getEmail()); ?>?s=200" alt="Avatar de <?= $user->getUsername(); ?>">
            </div>
            <div class="user-details__content__left__bio">
                <p><?php if (!empty($user->getBio())) echo $user->getBio(); ?></p>

                <?php if ($userIsAdmin || $userIsConnected): ?>
                    <div class="user-details__content__left__actions">
                        <a href="/user/<?= $user->getId() ?>/edit" class="btn btn-primary">Modifier mon profil</a>
                        <a href="/user/<?= $user->getId() ?>/delete" class="btn btn-primary">Supprimer mon compte</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="user-details__content__right">
                <div class="user-details__content__right__info">
                    <h3>Informations</h3>
                    <ul>
                        <li><strong>Nom d'utilisateur : </strong><?= $user->getUsername(); ?></li>
                        <li><strong>Date de création : </strong><?= $user->getCreatedAt(); ?></li>
                    </ul>
                </div>
                <div class="user-details__content__right__posts">
                    <h3>Articles</h3>
                    <ul>
                        <?php foreach ($user->getPosts() as $post): ?>
                            <li>
                                <h3><?= $post->getTitle() ?></h3>
                                <a href="/posts/<?= $post->getId() ?>">Voir l'article</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
</section>