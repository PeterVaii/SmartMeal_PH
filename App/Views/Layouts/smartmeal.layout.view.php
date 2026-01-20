<?php
/** @var string $contentHTML */
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>

<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartMeal</title>
    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="180x180" href="<?= $link->asset('favicons/apple-touch-icon.png') ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= $link->asset('favicons/favicon-32x32.png') ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= $link->asset('favicons/favicon-16x16.png') ?>">
    <link rel="manifest" href="<?= $link->asset('favicons/site.webmanifest') ?>">
    <link rel="shortcut icon" href="<?= $link->asset('favicons/favicon.ico') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="<?= $link->asset('css/styl.css') ?>">
    <script src="<?= $link->asset('js/script.js') ?>"></script>
</head>

<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="<?= $link->url('homepage.index') ?>">SmartMeal</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="<?= $link->url('recepty.index') ?>">Recepty</a>
                </li>
                <?php if ($user->isLoggedIn()) { ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url('jedalnyplan.index') ?>">Jedálny plán</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= $link->url('nakupnyzoznam.index') ?>">Nákupný zoznam</a>
                    </li>
                <?php } ?>
            </ul>

            <div class="d-flex align-items-center gap-3">
                <?php if ($user->isLoggedIn()) { ?>
                    <span class="text-secondary small">
                        <?= htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <a class="btn btn-outline-danger btn-sm" href="<?= $link->url('auth.logout') ?>">Odhlásiť</a>
                <?php } else { ?>
                    <a class="btn btn-primary btn-sm" href="<?= App\Configuration::LOGIN_URL ?>">Prihlásiť</a>
                <?php } ?>
            </div>
        </div>
    </div>
</nav>

<main class="container-fluid py-3">
    <?= $contentHTML ?>
</main>

<footer class="border-top bg-white">
    <div class="container-fluid py-3 text-center text-secondary small">
        © <?= date('Y') ?> SmartMeal
    </div>
</footer>
</body>
</html>