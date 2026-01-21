<?php
/** @var \Framework\Auth\AppUser $user */
/** @var \Framework\Support\LinkGenerator $link */
?>
<!-- Emotikony + návrh obsahu stránky s pomocou ChatGPT-->
<div class="container">

    <div class="mb-4">
        <h1 class="fw-bold">SmartMeal</h1>
        <p class="text-muted mb-0">Plánuj jedlá, ukladaj recepty a maj nákupy pod kontrolou.</p>
    </div>

    <?php if (!$user->isLoggedIn()) { ?>
        <div class="alert alert-info d-flex align-items-center gap-2 home-alert" role="alert">
            <span>👀 Recepty si môžeš pozerať aj bez prihlásenia. Pre jedálny plán a nákupný zoznam sa prihlás.</span>
        </div>

        <div class="d-flex gap-2 mb-4">
            <a class="btn btn-primary" href="<?= $link->url('recipes.index') ?>">Pozrieť recepty</a>
        </div>

    <?php } else { ?>
        <div class="row g-3">

            <div class="col-md-4">
                <div class="card h-100 home-card">
                    <div class="card-body">
                        <h5 class="card-title">🍲 Recepty</h5>
                        <p class="card-text text-muted">Prehliadaj recepty alebo pridaj nový.</p>
                        <a class="btn btn-outline-primary btn-sm" href="<?= $link->url('recipes.index') ?>">Otvoriť recepty</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 home-card">
                    <div class="card-body">
                        <h5 class="card-title">📅 Jedálny plán</h5>
                        <p class="card-text text-muted">Naplánuj si jedlá na celý týždeň.</p>
                        <a class="btn btn-outline-primary btn-sm" href="<?= $link->url('mealplan.index') ?>">Naplánovať</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card h-100 home-card">
                    <div class="card-body">
                        <h5 class="card-title">🛒 Nákupný zoznam</h5>
                        <p class="card-text text-muted">Maj všetky nákupy na jednom mieste.</p>
                        <a class="btn btn-outline-primary btn-sm" href="<?= $link->url('shoppinglist.index') ?>">Otvoriť zoznam</a>
                    </div>
                </div>
            </div>

        </div>

        <div class="alert alert-info mt-4 home-alert">
            💡 Tip: Naplánuj si jedlá na celý týždeň a ušetríš čas aj peniaze.
        </div>
    <?php } ?>

</div>