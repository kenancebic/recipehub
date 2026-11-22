<?php

declare(strict_types=1);

// Get all recipes
Flight::route('GET /api/recipes', function () {
    try {
        $recipes = Flight::recipe_service()->getAll();

        Flight::json($recipes);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get one recipe by ID
Flight::route('GET /api/recipes/@id:[0-9]+', function ($id) {
    try {
        $recipe = Flight::recipe_service()->getById((int) $id);

        Flight::json($recipe);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Create a new recipe
Flight::route('POST /api/recipes', function () {
    try {
        $data = Flight::request()->data->getData();

        $recipe = Flight::recipe_service()->add($data);

        Flight::json($recipe, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Update a recipe
Flight::route('PUT /api/recipes/@id:[0-9]+', function ($id) {
    try {
        $data = Flight::request()->data->getData();

        $recipe = Flight::recipe_service()->update((int) $id, $data);

        Flight::json($recipe);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Delete a recipe
Flight::route('DELETE /api/recipes/@id:[0-9]+', function ($id) {
    try {
        Flight::recipe_service()->delete((int) $id);

        Flight::json([
            'message' => 'Recipe deleted successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
