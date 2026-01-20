<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Recipe|null $recipe */
/** @var array $ingredients */
?>

<div class="container">

    <div class="mb-3">
        <a class="text-decoration-none" href="<?= $link->url('recipes.index') ?>">← Späť na recepty</a>
    </div>

    <?php if ($recipe === null) { ?>
        <div class="alert alert-danger">Recept sa nenašiel.</div>
    <?php } else { ?>

        <?php if ($user->isLoggedIn() && $user->getId() === $recipe->getUserId()) { ?>
            <div class="mb-3 d-flex gap-2">
                <a class="btn btn-sm btn-outline-primary"
                   href="?c=recipes&a=edit&id=<?= (int)$recipe->getId() ?>">Upraviť</a>

                <a class="btn btn-sm btn-outline-danger"
                   href="?c=recipes&a=delete&id=<?= (int)$recipe->getId() ?>"
                   onclick="return confirm('Naozaj chceš recept zmazať?');">
                    Zmazať
                </a>
            </div>
        <?php } ?>

        <div class="d-flex align-items-start justify-content-between gap-3 mb-2">
            <div>
                <h1 class="fw-bold mb-1"><?= htmlspecialchars($recipe->getTitle(), ENT_QUOTES, 'UTF-8') ?></h1>

                <?php if ($recipe->getDescription()) { ?>
                    <p class="text-muted mb-2">
                        <?= htmlspecialchars($recipe->getDescription(), ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php } ?>

                <div class="d-flex flex-wrap gap-2">
                    <?php if ($recipe->getPrepTime() !== null) { ?>
                        <span class="badge bg-light text-dark border"><?= (int)$recipe->getPrepTime() ?> min</span>
                    <?php } ?>
                    <?php if ($recipe->getServings() !== null) { ?>
                        <span class="badge bg-light text-dark border"><?= (int)$recipe->getServings() ?> porcie</span>
                    <?php } ?>
                    <?php
                        $diffMap = ['easy' => 'ľahká', 'medium' => 'stredná', 'hard' => 'ťažká'];
                        $diff = $recipe->getDifficulty();
                    ?>
                    <span class="badge bg-light text-dark border"><?= htmlspecialchars($diffMap[$diff] ?? $diff, ENT_QUOTES, 'UTF-8') ?></span>

                    <?php if (!$recipe->isPublic()) { ?>
                        <span class="badge bg-secondary">súkromný</span>
                    <?php } ?>
                </div>
            </div>
        </div>

        <div class="row g-3 mt-1">
            <div class="col-lg-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">Ingrediencie</h5>

                        <?php if (empty($ingredients)) { ?>
                            <div class="text-muted">Zatiaľ bez ingrediencií.</div>
                        <?php } else { ?>
                            <ul class="list-group list-group-flush">
                                <?php foreach ($ingredients as $ing) { ?>
                                    <li class="list-group-item d-flex justify-content-between gap-3">
                                        <span><?= htmlspecialchars($ing->getName(), ENT_QUOTES, 'UTF-8') ?></span>
                                        <span class="text-muted">
                                            <?php
                                                $amount = $ing->getAmount();
                                                $unit = $ing->getUnit();
                                                echo $amount !== null ? htmlspecialchars((string)$amount, ENT_QUOTES, 'UTF-8') : '';
                                                echo $unit ? ' ' . htmlspecialchars($unit, ENT_QUOTES, 'UTF-8') : '';
                                            ?>
                                        </span>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>

                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Postup</h5>
                        <div style="white-space: pre-line;">
                            <?= htmlspecialchars($recipe->getInstructions(), ENT_QUOTES, 'UTF-8') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php } ?>

</div>
