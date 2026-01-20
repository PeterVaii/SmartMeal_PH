<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var array $plans */
/** @var array $recipes */

$days = [
    'mon' => 'Pondelok',
    'tue' => 'Utorok',
    'wed' => 'Streda',
    'thu' => 'Štvrtok',
    'fri' => 'Piatok',
    'sat' => 'Sobota',
    'sun' => 'Nedeľa',
];

$plansByDay = [];
foreach ($plans as $p) {
    $plansByDay[$p->getDay()][] = $p;
}
?>

<div class="container" style="max-width: 900px;">
    <h1 class="fw-bold mb-3">Jedálny plán</h1>

    <?php foreach ($days as $dayKey => $dayLabel) { ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title mb-3"><?= $dayLabel ?></h5>

                <?php $dayPlans = $plansByDay[$dayKey] ?? []; ?>

                <?php if (!empty($dayPlans)) { ?>
                    <div class="mb-3">
                        <?php foreach ($dayPlans as $mp) {
                            $recipe = App\Models\Recipe::getOne($mp->getRecipeId());
                            ?>
                            <div class="d-flex justify-content-between align-items-center border rounded p-2 mb-2">
                                <span>
                                    <?= htmlspecialchars($recipe ? $recipe->getTitle() : 'Neznámy recept', ENT_QUOTES, 'UTF-8') ?>
                                </span>

                                <a class="btn btn-sm btn-outline-danger"
                                   href="?c=mealplan&a=remove&id=<?= (int)$mp->getId() ?>"
                                   onclick="return confirm('Odstrániť recept z tohto dňa?');">
                                    ✕
                                </a>
                            </div>
                        <?php } ?>
                    </div>
                <?php } else { ?>
                    <div class="text-muted mb-3">
                        Zatiaľ žiadny recept.
                    </div>
                <?php } ?>

                <form method="post" action="?c=mealplan&a=add" class="d-flex gap-2">
                    <input type="hidden" name="day" value="<?= $dayKey ?>">

                    <label>
                        <select name="recipe_id" class="form-select form-select-sm" required>
                            <?php foreach ($recipes as $r) { ?>
                                <option value="<?= (int)$r->getId() ?>">
                                    <?= htmlspecialchars($r->getTitle(), ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php } ?>
                        </select>
                    </label>

                    <button class="btn btn-sm btn-primary">
                        Pridať
                    </button>
                </form>
            </div>
        </div>
    <?php } ?>
</div>
