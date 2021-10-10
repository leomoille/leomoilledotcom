<?php

$title = 'Développeur PHP/Symfony' ?>
<?php
ob_start() ?>
<!-- Navigation-->
<nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="/">Léo Moille</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            Menu <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ms-auto py-4 py-lg-0">
                <li class="nav-item active">
                    <a class="nav-link px-lg-3 py-3 py-lg-4" href="/">Accueil</a>
                </li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="?action=blog">Blog</a></li>
                <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="?action=connexion">Connexion</a></li>
            </ul>
        </div>
    </div>
</nav>
<!-- Page Header-->
<header class="masthead" style="background-image: url('../../public/images/home-bg.jpg')">
    <div class="container position-relative px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <div class="site-heading">
                    <h1>Léo Moille</h1>
                    <span class="subheading">Connexion</span>
                </div>
            </div>
        </div>
    </div>
</header>
<h3>CONNEXION EN CONSTRUCTION</h3>
<!-- Footer-->
<footer class="border-top">
    <div class="container px-4 px-lg-5">
        <div class="row gx-4 gx-lg-5 justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-7">
                <ul class="list-inline text-center">
                    <li class="list-inline-item">
                        <a href="https://twitter.com/leo_moille/">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
                                </span> </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://www.linkedin.com/in/leomoille/">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-linkedin-in fa-stack-1x fa-inverse"></i>
                                </span> </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="https://github.com/leomoille/">
                                <span class="fa-stack fa-lg">
                                    <i class="fas fa-circle fa-stack-2x"></i>
                                    <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                </span> </a>
                    </li>
                </ul>
                <div class="small text-center text-muted fst-italic">Copyright &copy; Léo Moille [Année en cours]
                </div>
                <div class="small text-center text-muted"><a href="#">Mentions légales</a> - <a href="#">Politique de
                                                                                                         confidentialité</a>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php
$content = ob_get_clean(); ?>

<?php
require('template.php') ?>
