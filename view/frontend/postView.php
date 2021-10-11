<?php

$title = $article['title'] ?>
<?php
ob_start() ?>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../../public/images/post-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="post-heading">
                    <h1><?= htmlspecialchars($article['title']) ?></h1>
                    <h2 class="subheading"><?= htmlspecialchars($article['pre_content']) ?></h2>
                    <span class="meta">
                            Publié par <a href="#"><?= htmlspecialchars($article['author']); ?></a>
                        le <?= htmlspecialchars($article['publication_date']); ?>
                        <?= htmlspecialchars($article['modification_date']) !== null ?
                            null : ' - Dernière modification le ' . htmlspecialchars($article['modification_date']); ?>
                        </span>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Post Content-->
<article class="mb-4">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <p><?= htmlspecialchars($article['content']) ?></p>
            </div>
        </div>
    </div>
</article>
<!-- Commentaires -->
<section id="commentaire" class="mb-4">
    <div class="container px-4 px-lg-5">
        <h3>Commentaires (<?= (int)$comments->fetch() ?>)</h3>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="mb-3">
                <!-- COMMENTAIRE -->
                <?php
                if ($comments->fetch() == 0) {
                    ?>
                    <p>Soyez le premier à me laisser un commentaire !</p>
                    <?php
                }
                while ($comment = $comments->fetch()) {
                    ?>
                    <div class="row g-0 align-items-baseline">
                        <div class="col-md-4">
                            <div class="">
                                <h5 class="card-title"><?= htmlspecialchars($comment['author']) ?></h5>
                                <p class="card-subtitle"><small class="text-muted">Publié le
                                        <?= nl2br(htmlspecialchars($comment['comment_date'])) ?>
                                    </small>
                                </p>
                                <p class="small m-0"><a href="#">Modifier mon commentaire</a><br><a href="#">Supprimer
                                                                                                             mon
                                                                                                             commentaire</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <p class=""><?= htmlspecialchars($comment['comment']) ?></p>
                        </div>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
    <hr style="width: 50%; margin: auto;">
    <div class="container px-4 px-lg-5 mt-5">
        <h3 class="h4">Commenter</h3>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="mb-3">
                <p>Vous devez être connecté pour publier un commentaire !</p>
                <p><a href="#">Connexion/Inscription</a></p>
            </div>
        </div>
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="mb-3">
                <form id="contactForm">
                    <p>Vous êtes connecté en tant que [Nom]</p>
                    <div class="form-floating">
                            <textarea class="form-control" id="message" placeholder="Votre message"
                                      style="height: 12rem" required></textarea>
                        <label for="message">Message</label>
                    </div>
                    <br />
                    <!-- Submit Button-->
                    <button class="btn btn-primary text-uppercase" id="submitButton" type="submit">Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean(); ?>

<?php
require('template.php') ?>
