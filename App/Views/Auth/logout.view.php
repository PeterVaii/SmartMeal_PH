<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Support\View $view */

$view->setLayout('auth');
?>

<div class="container" style="max-width: 520px;">
    <div class="card shadow-sm mt-5">
        <div class="card-body text-center p-4">

            <div class="display-6 mb-2">👋</div>

            <h1 class="h4 mb-2">Boli ste odhlásený</h1>
            <p class="text-muted mb-4">Ďakujeme, že používate SmartMeal.</p>

            <div class="d-grid gap-2">
                <a class="btn btn-primary" href="<?= App\Configuration::LOGIN_URL ?>">Prihlásiť sa znova</a>
                <a class="btn btn-outline-secondary" href="<?= $link->url('domovskastranka.index') ?>">Späť na domovskú stránku</a>
            </div>

        </div>
    </div>

    <p class="text-center text-muted small mt-3 mb-0">Ak si nebol/a odhlásený/á ty, odporúčame zmeniť heslo.</p>
</div>
