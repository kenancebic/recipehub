<?php

declare(strict_types=1);

// Get all saved recipes
Flight::route('GET /api/saved-recipes', function () {
    try {
        $savedRecipes = Flight::saved_recipe_service()->getAll();

        Flight::json($savedRecipes);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get saved recipes for one user
Flight::route('GET /api/users/@user_id:[0-9]+/saved-recipes', function ($user_id) {
    try {
        $savedRecipes = Flight::saved_recipe_service()->getByUser((int) $user_id);

        Flight::json($savedRecipes);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Save a recipe for a user
Flight::route('POST /api/saved-recipes', function () {
    try {
        $data = Flight::request()->data->getData();

        $savedRecipe = Flight::saved_recipe_service()->add($data);

        Flight::json($savedRecipe, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Remove a saved recipe
Flight::route('DELETE /api/saved-recipes/@user_id:[0-9]+/@recipe_id:[0-9]+', function ($user_id, $recipe_id) {
    try {
        Flight::saved_recipe_service()->delete(
            (int) $user_id,
            (int) $recipe_id
        );

        Flight::json([
            'message' => 'Saved recipe deleted successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
