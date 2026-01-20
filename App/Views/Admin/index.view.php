<?php
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container" style="max-width: 520px">

    <div class="card mt-5">
        <div class="card-body text-center">

            <h1 class="mb-3">
                Vitaj, <?= htmlspecialchars($user->getName(), ENT_QUOTES, 'UTF-8') ?> 👋
            </h1>

            <p class="text-muted mb-4">Úspešne si sa prihlásil do aplikácie SmartMeal.</p>

            <a href="<?= $link->url('homepage.index') ?>" class="btn btn-primary btn-lg w-100">Pokračovať na domovskú stránku</a>

        </div>
    </div>

</div>