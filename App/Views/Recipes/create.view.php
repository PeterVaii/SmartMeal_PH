<?php
/** @var \Framework\Support\LinkGenerator $link */
/** @var \Framework\Auth\AppUser $user */
/** @var string|null $message */
?>

<div class="container page-narrow">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="fw-bold mb-0">Pridať recept</h1>
        <a class="btn btn-outline-secondary btn-sm" href="<?= $link->url('recipes.index') ?>">Späť</a>
    </div>

    <?php if (!empty($message)) { ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php } ?>

    <form method="post" action="?c=recipes&a=create">
        <div class="card mb-3">
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Názov receptu</label>
                        <input name="title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Krátky popis</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="O čom je recept?"></textarea>
                </div>

                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <label class="form-label">Čas prípravy (min)</label>
                        <label>
                            <input name="prep_time" type="number" min="1" class="form-control" placeholder="napr. 20">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Počet porcií</label>
                        <label>
                            <input name="servings" type="number" min="1" class="form-control" placeholder="napr. 2">
                        </label>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Náročnosť</label>
                            <select name="difficulty" class="form-select">
                                <option value="easy">ľahká</option>
                                <option value="medium">stredná</option>
                                <option value="hard">ťažká</option>
                            </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Postup</label>
                        <textarea name="instructions" class="form-control" rows="8" required placeholder="Krok 1...&#10;Krok 2..."></textarea>
                    <div class="form-text">
                        Tip: každý krok píš na nový riadok.
                    </div>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_public" id="is_public" checked>
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

                <div class="text-muted small mt-2">
                    Tip: prázdne riadky sa ignorujú.
                </div>
            </div>
        </div>

        <button class="btn btn-primary" type="submit" name="submit" value="1">
            Uložiť recept
        </button>
    </form>
</div>
