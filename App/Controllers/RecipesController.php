<?php

namespace App\Controllers;

use App\Models\Recipe;
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
}