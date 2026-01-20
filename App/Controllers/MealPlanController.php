<?php

namespace App\Controllers;

use App\Configuration;
use App\Models\MealPlan;
use App\Models\Recipe;
use Framework\Core\BaseController;
use Framework\Http\Request;
use Framework\Http\Responses\Response;

class MealPlanController extends BaseController
{
    public function index(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(\App\Configuration::LOGIN_URL);
        }

        $plans = MealPlan::getAll('`user_id` = ?', [$user->getId()]);
        $recipes = Recipe::getAll('`is_public` = 1 OR `user_id` = ?', [$user->getId()]);

        return $this->html(compact('plans', 'recipes'));
    }

    public function add(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        $day = (string)$request->value('day');
        $recipeId = (int)$request->value('recipe_id');

        $mp = new MealPlan();
        $mp->setUserId($user->getId());
        $mp->setRecipeId($recipeId);
        $mp->setDay($day);
        $mp->save();

        return $this->redirect($this->url('mealplan.index'));
    }

    public function remove(Request $request): Response
    {
        $user = $this->app->getAuthenticator()->getUser();
        if (!$user->isLoggedIn()) {
            return $this->redirect(Configuration::LOGIN_URL);
        }

        $id = (int)$request->value('id');
        $mp = MealPlan::getOne($id);

        if ($mp === null || $mp->getUserId() !== $user->getId()) {
            return $this->redirect($this->url('mealplan.index'));
        }

        $mp->delete();
        return $this->redirect($this->url('mealplan.index'));
    }
}