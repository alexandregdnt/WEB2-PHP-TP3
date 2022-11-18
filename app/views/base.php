<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?= $_pageTitle; ?></title>
</head>
<body>
<header class="header">
    <nav class="nav">
        <div class="nav__container">
            <div class="nav__row">
                <div class="nav__col">
                    <a href="/" class="nav__logo">
                        <img src="/assets/img/logo.png" alt="Logo" class="nav__logo-img">
                    </a>
                </div>
                <div class="nav__col">
                    <ul class="nav__list">
                        <li class="nav__list-item">
                            <a href="/" class="nav__list-link">Home</a>
                        </li>
                        <?php if (isset($_SESSION['user'])): ?>
                            <li class="nav__list-item">
                                <a href="/post/create" class="nav__list-link">Create Post</a>
                            </li>
                            <li class="nav__list-item">
                                <a href="/user/<?php echo unserialize($_SESSION['user'])->getId(); ?>" class="nav__list-link">User Profile</a>
                            </li>
                            <li class="nav__list-item">
                                <a href="/auth/logout" class="nav__list-link">Logout</a>
                            </li>
                        <?php else: ?>
                            <li class="nav__list-item">
                                <a href="/auth/login" class="nav__list-link">Login</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="main">
    <?php
    if (isset($_SESSION['error']) && !empty($_SESSION['error'])) {
        \App\Helpers\Printers::printError($_SESSION['error']);
        unset($_SESSION['error']);
    } elseif (isset($_SESSION['success']) && !empty($_SESSION['success'])) {
        \App\Helpers\Printers::printSuccess($_SESSION['success']);
        unset($_SESSION['success']);
    } elseif (isset($_SESSION['info']) && !empty($_SESSION['info'])) {
        \App\Helpers\Printers::printInfo($_SESSION['info']);
        unset($_SESSION['info']);
    } elseif (isset($_SESSION['warning']) && !empty($_SESSION['warning'])) {
        \App\Helpers\Printers::printWarning($_SESSION['warning']);
        unset($_SESSION['warning']);
    }
    ?>

    <?= $_pageContent; ?>
</main>
</body>
</html>
