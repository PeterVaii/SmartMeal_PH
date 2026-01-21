<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\Recipe;
use App\Models\RecipeIngredient;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class RecipesController extends BaseController
{
    public function index(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();

        if ($user->isLoggedIn()) {
            $recipes = Recipe::getAll(
                '(`is_public` = 1 OR `user_id` = ?)',
                [$user->getId()],
                orderBy: '`created_at` DESC'
            );
        } else {
            $recipes = Recipe::getAll(
                '`is_public` = 1',
                [],
                orderBy: '`created_at` DESC'
            );
        }
        return $this->html(compact('recipes'));
    }

    public function show(Request $request): Response
    {
        $id = (int)$request->value('id');
        $recipe = \App\Models\Recipe::getOne($id);

        if ($recipe === null) {
            return $this->html([
                'recipe' => null,
                'ingredients' => [],
            ]);
        }

        $ingredients = RecipeIngredient::getAll('`recipe_id` = ?', [$id]);

        return $this->html(compact('recipe', 'ingredients'));
    }

    public function create(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        $message = null;

        if ($request->hasValue('submit')) {
            $title = trim((string)$request->value('title'));
            $description = trim((string)$request->value('description'));
            $instructions = trim((string)$request->value('instructions'));
            $isPublic = $request->hasValue('is_public');

            $prepTimeRaw = trim((string)($request->value('prep_time') ?? ''));
            $servingsRaw = trim((string)($request->value('servings') ?? ''));
            $difficulty = (string)($request->value('difficulty') ?? 'easy');

            $prepTime = $prepTimeRaw === '' ? null : (int)$prepTimeRaw;
            $servings = $servingsRaw === '' ? null : (int)$servingsRaw;

            if (!in_array($difficulty, ['easy', 'medium', 'hard'], true)) {
                $difficulty = 'easy';
            }

            if ($title === '' || $instructions === '') {
                $message = 'Vyplň názov a postup.';
            } else {
                $recipe = new Recipe();
                $recipe->setUserId((int)$user->getId());
                $recipe->setTitle($title);
                $recipe->setDescription($description !== '' ? $description : null);
                $recipe->setInstructions($instructions);
                $recipe->setPublic($isPublic);

                $recipe->setPrepTime($prepTime);
                $recipe->setServings($servings);
                $recipe->setDifficulty($difficulty);

                $recipe->save();
                $recipeId = (int)$recipe->getId();

                $names = (array)($request->value('ing_name') ?? []);
                $amounts = (array)($request->value('ing_amount') ?? []);
                $units = (array)($request->value('ing_unit') ?? []);

                for ($i = 0; $i < count($names); $i++) {
                    $name = trim((string)$names[$i]);
                    if ($name === '') continue;

                    $ing = new \App\Models\RecipeIngredient();
                    $ing->setRecipeId($recipeId);
                    $ing->setName($name);

                    $amountRaw = isset($amounts[$i]) ? trim((string)$amounts[$i]) : '';
                    $amount = ($amountRaw === '') ? null : (float)str_replace(',', '.', $amountRaw);
                    $ing->setAmount($amount);

                    $unit = isset($units[$i]) ? trim((string)$units[$i]) : '';
                    $ing->setUnit($unit !== '' ? $unit : null);

                    $ing->save();
                }
                return $this->redirect("?c=recipes&a=show&id=" . $recipeId);
            }
        }
        return $this->html(compact('message'));
    }

    public function edit(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        $id = (int)$request->value('id');
        $recipe = Recipe::getOne($id);

        if ($recipe === null) {
            return $this->redirect($this->url('recipes.index'));
        }

        if ($recipe->getUserId() !== $user->getId()) {
            return $this->redirect("?c=recipes&a=show&id=" . $id);
        }

        $ingredients = RecipeIngredient::getAll('`recipe_id` = ?', [$id], orderBy: '`id` asc');

        $message = null;

        if ($request->hasValue('submit')) {
            $title = trim((string)$request->value('title'));
            $description = trim((string)$request->value('description'));
            $instructions = trim((string)$request->value('instructions'));
            $isPublic = $request->hasValue('is_public');

            $prepTimeRaw = trim((string)($request->value('prep_time') ?? ''));
            $servingsRaw = trim((string)($request->value('servings') ?? ''));
            $difficulty = (string)($request->value('difficulty') ?? 'easy');

            $prepTime = $prepTimeRaw === '' ? null : (int)$prepTimeRaw;
            $servings = $servingsRaw === '' ? null : (int)$servingsRaw;

            if (!in_array($difficulty, ['easy', 'medium', 'hard'], true)) {
                $difficulty = 'easy';
            }

            if ($title === '' || $instructions === '') {
                $message = 'Vyplň názov a postup.';
            } else {
                $recipe->setTitle($title);
                $recipe->setDescription($description !== '' ? $description : null);
                $recipe->setInstructions($instructions);
                $recipe->setPublic($isPublic);

                $recipe->setPrepTime($prepTime);
                $recipe->setServings($servings);
                $recipe->setDifficulty($difficulty);

                $recipe->save();

                foreach ($ingredients as $old) {
                    $old->delete();
                }

                $names = (array)($request->value('ing_name') ?? []);
                $amounts = (array)($request->value('ing_amount') ?? []);
                $units = (array)($request->value('ing_unit') ?? []);

                for ($i = 0; $i < count($names); $i++) {
                    $name = trim((string)$names[$i]);
                    if ($name === '') continue;

                    $ing = new RecipeIngredient();
                    $ing->setRecipeId($id);
                    $ing->setName($name);

                    $amountRaw = isset($amounts[$i]) ? trim((string)$amounts[$i]) : '';
                    $amount = ($amountRaw === '') ? null : (float)str_replace(',', '.', $amountRaw);
                    $ing->setAmount($amount);

                    $unit = isset($units[$i]) ? trim((string)$units[$i]) : '';
                    $ing->setUnit($unit !== '' ? $unit : null);

                    $ing->save();
                }
                return $this->redirect("?c=recipes&a=show&id=" . $id);
            }
        }
        return $this->html(compact('recipe', 'ingredients', 'message'));
    }

    public function delete(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        $id = (int)$request->value('id');
        $recipe = Recipe::getOne($id);

        if ($recipe === null) {
            return $this->redirect($this->url('recipes.index'));
        }

        if ($recipe->getUserId() !== $user->getId()) {
            return $this->redirect("?c=recipes&a=show&id=" . $id);
        }

        $recipe->delete();
        return $this->redirect($this->url('recipes.index'));
    }

    //Vygenerované pomocou ChatGPT
    public function searchAjax(Request $request): Response
    {
        $q = trim((string)$request->value('q'));
        $like = '%' . $q . '%';

        $user = $this->app->getAuthenticator()->getUser();

        if ($user->isLoggedIn()) {
            $recipes = Recipe::getAll(
                '(`is_public` = 1 OR `user_id` = ?) AND `title` LIKE ?',
                [$user->getId(), $like],
                orderBy: '`created_at` DESC'
            );
        } else {
            $recipes = Recipe::getAll(
                '`is_public` = 1 AND `title` LIKE ?',
                [$like],
                orderBy: '`created_at` DESC'
            );
        }

        $payload = array_map(fn($r) => [
            'id' => (int)$r->getId(),
            'title' => (string)$r->getTitle(),
            'description' => (string)($r->getDescription() ?? ''),
            'is_public' => (int)$r->isPublic(),
        ], $recipes);

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => true, 'recipes' => $payload]);
        exit;
    }
}