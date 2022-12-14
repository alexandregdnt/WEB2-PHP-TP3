<?php
/*
 * @var string $_pageTitle
 * @var string $_pageContent
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WEB2-PHP-TP3 - <?= $_pageTitle ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400;500;600;700&family=Spectral:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="/assets/css/index.css">

</head>
<body>
<header class="section-header ">
    <div class="section-header__wrapper">
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <div>
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="">Actualité</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">Catégories</a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Economie</a></li>
                                <li><a class="dropdown-item" href="#">Politique</a></li>
                                <li><a class="dropdown-item" href="#">Culture</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <a href="/" class="h1">The Blog</a>
        <div class="section-header__user">
            <?php
            if ($this->getUser()) {
                echo '<a href="/auth/logout">Logout</a> <a href="/users/'. $this->getUser()->getId() .'">'. $this->getUser()->getUsername() .'</a>';
            } else {
                echo '<button type="button" class="nav-link active" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                se connecter
                <svg width="50" height="50" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#a)" fill-rule="evenodd" clip-rule="evenodd" fill="#000000"><path d="m14.685 13.752-2.21-2.208a18.75 18.75 0 1 1-1.017 25.848l2.215-2.217a15.625 15.625 0 1 0 1.014-21.423h-.002Z"/><path d="M8.052 22.488v-6.863l8.615 8.333-8.615 8.334v-6.68H-2.083v-3.124H8.052ZM26.042 37.5A11.734 11.734 0 0 0 32 35.89a12.52 12.52 0 0 0 4.458-4.11c-.027-1.074-.68-2.063-1.958-2.968-1.11-.762-2.527-1.383-4.25-1.864-1.556-.423-2.965-.636-4.23-.636-1.264 0-2.672.213-4.228.636-1.723.48-3.125 1.102-4.209 1.864-1.277.905-1.93 1.894-1.958 2.967a12.522 12.522 0 0 0 4.458 4.11c1.89 1.073 3.875 1.611 5.959 1.611Zm0-22.917c-.917 0-1.777.24-2.584.721a5.322 5.322 0 0 0-1.916 1.948 5.176 5.176 0 0 0-.709 2.63c0 .93.236 1.805.709 2.624a5.31 5.31 0 0 0 1.916 1.95 4.972 4.972 0 0 0 5.167 0 5.322 5.322 0 0 0 1.917-1.948c.473-.82.708-1.695.708-2.627 0-.933-.235-1.808-.708-2.629a5.33 5.33 0 0 0-1.917-1.948 4.974 4.974 0 0 0-2.583-.72Z"/></g><defs><clipPath id="a"><path fill="#fff" d="M0 0h50v50H0z"/></clipPath></defs></svg>
            </button>';
            }
            ?>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="modal-header">
                                <h3 class="modal-title fs-5 input-text" id="staticBackdropLabel">Se connecter</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>

                            <form class="row g-3 mb-3" action="/auth/login" method="post">
                                <div class="col-md-6">
                                    <label for="login-email" class="form-label input-text">Username | E-mail | Phone number</label>
                                    <input id="login-email" name="authentication-method" type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="col-md-6">
                                    <label for="login-password" class="form-label input-text">Mot de passe</label>
                                    <input id="login-password" name="password" type="password" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn btn-primary">Se connecter</button>
                                </div>
                            </form>

                            <div class="accordion accordion-flush" id="accordionFlushExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button fs-5 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                            Créer un compte
                                        </button>
                                    </h2>
                                    <form class="modal-content__form-wrapper" action="/auth/register" method="post">
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <fieldset class="modal-body__form-wrapper" action="">
                                                    <label for="username" class="form-label input-text">Pseudo</label>
                                                    <div class="input-group mb-3">
                                                        <input id="username" name="username" type="text" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2" required>
                                                    </div>
                                                    <label for="email" class="form-label input-text">E-mail</label>
                                                    <div class="input-group mb-3">
                                                        <input id="email" name="email" type="email" class="form-control" aria-label="Recipient's email" aria-describedby="basic-addon2" required>
                                                    </div>
                                                    <label for="phone" class="form-label input-text">Téléphone</label>
                                                    <div class="input-group mb-3">
                                                        <input id="phone" name="phone" type="tel" class="form-control" aria-label="Recipient's phone" aria-describedby="basic-addon2">
                                                    </div>
                                                    <label for="password" class="form-label input-text">Mot de passe</label>
                                                    <div class="input-group mb-3">
                                                        <input id="password" name="password" type="password" class="form-control" aria-label="Recipient's password" aria-describedby="basic-addon2" required>
                                                    </div>
                                                    <label for="PasswordConfirmation" class="form-label input-text">Confirmation du mot de passe</label>
                                                    <div class="input-group mb-3">
                                                        <input id="PasswordConfirmation" name="password-confirm" type="password" class="form-control" aria-label="Recipient's password" aria-describedby="basic-addon2" required>
                                                    </div>
                                                    <label class="form-label input-text">Prénom et nom de famille</label>
                                                    <div class="input-group mb-3">
                                                        <input id="firstname" name="firstname" type="text" aria-label="prenom" class="form-control" required>
                                                        <input id="lastname" name="lastname" type="text" aria-label="nom de famille" class="form-control" required>
                                                    </div>
                                                    <label for="date_of_birth" class="form-label input-text">Date de naissance</label>
                                                    <div class="input-group mb-3">
                                                        <input id="date_of_birth" name="date_of_birth" type="date" class="form-control" aria-label="Recipient's username" aria-describedby="basic-addon2">
                                                    </div>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                    <button type="submit" class="btn btn-primary">S'inscrire</button>
                                                </fieldset>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<main class="main" id="main">
    <?= $_pageContent; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>