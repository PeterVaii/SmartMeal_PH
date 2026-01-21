<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\MealPlan;
use App\Models\RecipeIngredient;
use App\Models\ShoppingItem;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class ShoppingListController extends BaseController
{
    public function index(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        $plans = MealPlan::getAll('`user_id` = ?', [$user->getId()]);

        $recipeCounts = [];
        foreach ($plans as $p) {
            $rid = (int)$p->getRecipeId();
            $recipeCounts[$rid] = ($recipeCounts[$rid] ?? 0) + 1;
        }

        $recipeIds = array_keys($recipeCounts);

        $items = [];

        if (!empty($recipeIds)) {
            $placeholders = implode(',', array_fill(0, count($recipeIds), '?'));
            $ings = RecipeIngredient::getAll("`recipe_id` IN ($placeholders)", $recipeIds);

            foreach ($ings as $ing) {
                $mult = $recipeCounts[(int)$ing->getRecipeId()] ?? 1;

                $nameNorm = trim(mb_strtolower($ing->getName()));
                $unitNorm = $ing->getUnit() ? trim(mb_strtolower($ing->getUnit())) : null;
                $key = $nameNorm . '|' . ($unitNorm ?? '');

                if (!isset($items[$key])) {
                    $items[$key] = [
                        'name' => $ing->getName(),
                        'unit' => $ing->getUnit(),
                        'amount' => 0.0,
                        'hasAmount' => false,
                        'countNoAmount' => 0,
                        'times' => 0,
                    ];
                }

                $items[$key]['times'] += $mult;

                $amount = $ing->getAmount();
                if ($amount !== null) {
                    $items[$key]['amount'] += (float)$amount * $mult;
                    $items[$key]['hasAmount'] = true;
                } else {
                    $items[$key]['countNoAmount'] += $mult;
                }
            }
        }

        $items = array_values($items);
        usort($items, fn($a, $b) => strcasecmp($a['name'], $b['name']));

        $checked = ShoppingItem::getAll('`user_id` = ?', [$user->getId()]);

        $checkedMap = [];
        foreach ($checked as $c) {
            $key = mb_strtolower($c->getName()) . '|' . mb_strtolower($c->getUnit() ?? '');
            $checkedMap[$key] = $c->isChecked();
        }

        foreach ($items as &$it) {
            $key = mb_strtolower($it['name']) . '|' . mb_strtolower($it['unit'] ?? '');
            $it['checked'] = $checkedMap[$key] ?? false;
        }
        unset($it);
        return $this->html(compact('items', 'recipeIds'));
    }

    public function toggle(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(\App\Configuration::LOGIN_URL);
        }

        $name = (string)$request->value('name');
        $unit = $request->value('unit') !== null ? (string)$request->value('unit') : null;

        $items = ShoppingItem::getAll(
            '`user_id` = ? AND `name` = ? AND ' . ($unit ? '`unit` = ?' : '`unit` IS NULL'),
            $unit ? [$user->getId(), $name, $unit] : [$user->getId(), $name]
        );

        if ($items) {
            $item = $items[0];
            $item->setChecked(!$item->isChecked());
            $item->save();
        } else {
            $item = new ShoppingItem();
            $item->setUserId($user->getId());
            $item->setName($name);
            $item->setUnit($unit);
            $item->setChecked(true);
            $item->save();
        }
        return $this->redirect($this->url('mealplan.index'));
    }

    //Vygenerované pomocou ChatGPT
    public function toggleAjax(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['ok' => false, 'error' => 'not_logged_in']);
            exit;
        }

        $name = (string)$request->value('name');
        $unit = $request->value('unit') !== null ? (string)$request->value('unit') : null;
        $checked = (int)$request->value('checked') === 1;

        $items = ShoppingItem::getAll(
            '`user_id` = ? AND `name` = ? AND ' . ($unit !== null ? '`unit` = ?' : '`unit` IS NULL'),
            $unit !== null ? [$user->getId(), $name, $unit] : [$user->getId(), $name]
        );

        if (!empty($items)) {
            $it = $items[0];
        } else {
            $it = new \App\Models\ShoppingItem();
            $it->setUserId((int)$user->getId());
            $it->setName($name);
            $it->setUnit($unit);
        }

        $it->setChecked($checked);
        $it->save();

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode(['ok' => true, 'checked' => $checked]);
        exit;
    }
}