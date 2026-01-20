<?php
/** @var array $items */
/** @var array $recipeIds */
/** @var \Framework\Support\LinkGenerator $link */
?>

<div class="container" style="max-width: 900px;">
    <h1 class="fw-bold mb-3">Nákupný zoznam</h1>

    <?php if (empty($recipeIds)) { ?>
        <div class="alert alert-info">
            Najprv si pridaj recepty do <a href="<?= $link->url('mealplan.index') ?>">Jedálneho plánu</a>.
        </div>
    <?php } elseif (empty($items)) { ?>
        <div class="alert alert-warning">
            Recepty v jedálnom pláne nemajú žiadne ingrediencie.
        </div>
    <?php } else { ?>
        <div class="card shopping-card">
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    <?php foreach ($items as $it) { ?>
                        <li class="list-group-item shopping-row shopping-item <?= !empty($it['checked']) ? 'checked' : '' ?>">
                            <div class="label">
                                <label>
                                    <input class="form-check-input shopping-toggle"
                                           type="checkbox"
                                           data-name="<?= htmlspecialchars($it['name'], ENT_QUOTES, 'UTF-8') ?>"
                                           data-unit="<?= htmlspecialchars($it['unit'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                                        <?= !empty($it['checked']) ? 'checked' : '' ?>>
                                </label>

                                <span><?= htmlspecialchars($it['name'], ENT_QUOTES, 'UTF-8') ?></span>
                            </div>

                            <span class="amount text-muted">
                                <?php if (!empty($it['hasAmount'])) { ?>
                                    <?= htmlspecialchars(number_format((float)$it['amount'], 2, '.', ''), ENT_QUOTES, 'UTF-8') ?>
                                    <?= $it['unit'] ? htmlspecialchars(' ' . $it['unit'], ENT_QUOTES, 'UTF-8') : '' ?>

                                    <?php if (($it['times'] ?? 1) > 1) { ?>
                                        <span class="ms-2">(<?= (int)$it['times'] ?>×)</span>
                                    <?php } ?>

                                <?php } else { ?>
                                    <?= (($it['times'] ?? 1) > 1) ? ((int)$it['times'] . '×') : 'bez množstva' ?>
                                <?php } ?>
                            </span>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <div class="text-muted small mt-2">
            Zoznam je automaticky vygenerovaný z tvojho jedálneho plánu.
        </div>
    <?php } ?>
</div>
