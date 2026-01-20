<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var \App\Models\Recipe $recipe */
/** @var array $ingredients */
/** @var string|null $message */
?>

<div class="container" style="max-width: 900px;">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-bold mb-0">Upraviť recept</h1>
        <a class="btn btn-outline-secondary btn-sm" href="?c=recipes&a=show&id=<?= (int)$recipe->getId() ?>">Späť</a>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php } ?>

    <form method="post">
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Názov</label>
                    <label>
                        <input name="title" class="form-control"
                               value="<?= htmlspecialchars($recipe->getTitle(), ENT_QUOTES, 'UTF-8') ?>" required>
                    </label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Popis</label>
                    <label>
                        <textarea name="description" class="form-control"
                            rows="2"><?= htmlspecialchars($recipe->getDescription() ?? '', ENT_QUOTES, 'UTF-8') ?></textarea>
                    </label>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Čas prípravy (min)</label>
                        <label>
                            <input name="prep_time" type="number" min="1" class="form-control"
                                   value="<?= htmlspecialchars((string)($recipe->getPrepTime() ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Počet porcií</label>
                        <label>
                            <input name="servings" type="number" min="1" class="form-control"
                                   value="<?= htmlspecialchars((string)($recipe->getServings() ?? ''), ENT_QUOTES, 'UTF-8') ?>">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Náročnosť</label>
                        <label>
                            <select name="difficulty" class="form-select">
                                <option value="easy" <?= $recipe->getDifficulty() === 'easy' ? 'selected' : '' ?>>ľahká</option>
                                <option value="medium" <?= $recipe->getDifficulty() === 'medium' ? 'selected' : '' ?>>stredná</option>
                                <option value="hard" <?= $recipe->getDifficulty() === 'hard' ? 'selected' : '' ?>>ťažká</option>
                            </select>
                        </label>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Postup</label>
                    <label>
                        <textarea name="instructions" class="form-control"
                            rows="8" required><?= htmlspecialchars($recipe->getInstructions(), ENT_QUOTES, 'UTF-8') ?></textarea>
                    </label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_public" id="is_public"
                        <?= $recipe->isPublic() ? 'checked' : '' ?>>
                    <label class="form-check-label" for="is_public">Verejný recept</label>
                </div>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Ingrediencie</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm" id="add-ingredient">
                        + Pridať ingredienciu
                    </button>
                </div>

                <div id="ingredients-list"></div>

                <template id="ingredient-row-template">
                    <div class="row g-2 mb-2 ingredient-row">
                        <div class="col-md-5">
                            <label>
                                <input class="form-control" name="ing_name[]" placeholder="Napr. Špagety">
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label>
                                <input class="form-control" name="ing_amount[]" placeholder="200">
                            </label>
                        </div>
                        <div class="col-md-2">
                            <label>
                                <input class="form-control" name="ing_unit[]" placeholder="g / ml / ks">
                            </label>
                        </div>
                        <div class="col-md-3 d-grid">
                            <button type="button" class="btn btn-outline-danger remove-ingredient">
                                Odstrániť
                            </button>
                        </div>
                    </div>
                </template>

                <script type="application/json" id="ingredients-prefill">
                    <?= json_encode(array_map(function($ing) {
                        return [
                            'name' => $ing->getName(),
                            'amount' => $ing->getAmount(),
                            'unit' => $ing->getUnit()
                        ];
                    }, $ingredients), JSON_UNESCAPED_UNICODE) ?>
                </script>

                <div class="text-muted small mt-2">
                    Tip: prázdne riadky sa ignorujú.
                </div>
            </div>
        </div>

        <button class="btn btn-primary" type="submit" name="submit" value="1">Uložiť zmeny</button>
        <a class="btn btn-outline-secondary" href="?c=recipes&a=show&id=<?= (int)$recipe->getId() ?>">
            Zrušiť
        </a>
    </form>
</div>
