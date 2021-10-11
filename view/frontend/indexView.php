<?php

$title = 'Développeur PHP/Symfony' ?>
<?php
ob_start() ?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../../public/images/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Léo Moille</h1>
                    <span class="subheading">Développeur PHP/Symfony</span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Latest post-->
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7">
            <?php
            while ($article = $articles->fetch()) {
                ?>
                <div class="post-preview">
                    <a href="?action=post&id=<?= $article['id'] ?>">
                        <h2 class="post-title"><?= htmlspecialchars($article['title']) ?></h2>
                        <h3 class="post-subtitle"><?= htmlspecialchars($article["pre_content"]); ?></h3>
                    </a>
                    
                    <p class="post-meta">
                        Publié par <a href="#"><?= htmlspecialchars($article['author']); ?></a> le <?= htmlspecialchars(
                            $article['publication_date']
                        ); ?>
                        <?= htmlspecialchars($article['modification_date']) !== null ?
                            null :
                            ' - Dernière modification le ' . htmlspecialchars($article['modification_date']); ?>
                    </p>
                </div>
                <!-- Divider-->
                <hr class="my-4" />
                <?php
            }
            $articles->closeCursor();
            ?>
            <!-- Pager-->
            <div class="d-flex justify-content-end mb-4">
                <a class="btn btn-primary text-uppercase" href="#">Voir toutes les publications →</a>
            </div>
        </div>
    </div>
</div>
<!-- Contact --->
<div class="container px-4 px-lg-5">
    <div class="row gx-4 gx-lg-5 justify-content-center">
        <div class="col-md-10 col-lg-8 col-xl-7 my-5">
            <h2>Contact</h2>
            <p>Entrez facilement en contact avec moi dès maintenant.</p>
            <form id="contactForm">
                <div class="form-floating">
                    <input class="form-control" id="name" type="text" placeholder="Votre nom" required />
                    <label for="name">Nom</label>
                </div>
                <div class="form-floating">
                    <input class="form-control" id="email" type="email" placeholder="Votre email" required />
                    <label for="email">Email address</label>
                </div>
                <div class="form-floating">
                    <textarea class="form-control" id="message" placeholder="Votre message" style="height: 12rem"
                              required></textarea>
                    <label for="message">Message</label>
                </div>
                <br />
                <p>[CAPTCHA]</p>
                <!-- Submit Button-->
                <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Envoyer
                </button>
            </form>
        </div>
    </div>
</div>
<!-- Compétences --->
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-12 col-xl-7 my-5">
            <h2 class="text-center py-3">Mes compétences</h2>
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <div class="col col-md-6">
                    <div class="card border-0 p-2">
                        <div class="card-body">
                            <h3 class="h5 card-title text-center">PHP</h3>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                                 to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="card border-0 p-2">
                        <div class="card-body">
                            <h3 class="h5 card-title text-center">Twig</h3>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                                 to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="card border-0 p-2">
                        <div class="card-body">
                            <h3 class="h5 card-title text-center">MySQL</h3>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                                 to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="card border-0 p-2">
                        <div class="card-body">
                            <h3 class="h5 card-title text-center">HTML 5</h3>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                                 to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="card border-0 p-2">
                        <div class="card-body">
                            <h3 class="h5 card-title text-center">CSS 3</h3>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                                 to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
                <div class="col col-md-6">
                    <div class="card border-0 p-2">
                        <div class="card-body">
                            <h3 class="h5 card-title text-center">JavaScript</h3>
                            <p class="card-text">This is a longer card with supporting text below as a natural lead-in
                                                 to additional content. This content is a little bit longer.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean(); ?>

<?php
require('template.php') ?>
