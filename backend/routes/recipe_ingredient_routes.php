<?php

declare(strict_types=1);

// Get all recipe ingredients
Flight::route('GET /api/recipe-ingredients', function () {
    try {
        $items = Flight::recipe_ingredient_service()->getAll();

        Flight::json($items);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get ingredients for one recipe
Flight::route('GET /api/recipes/@recipe_id:[0-9]+/ingredients', function ($recipe_id) {
    try {
        $items = Flight::recipe_ingredient_service()->getByRecipe((int) $recipe_id);

        Flight::json($items);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Add an ingredient to a recipe
Flight::route('POST /api/recipe-ingredients', function () {
    try {
        $data = Flight::request()->data->getData();

        $item = Flight::recipe_ingredient_service()->add($data);

        Flight::json($item, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Update the quantity of an ingredient in a recipe
Flight::route('PUT /api/recipe-ingredients/@recipe_id:[0-9]+/@ingredient_id:[0-9]+', function ($recipe_id, $ingredient_id) {
    try {
        $data = Flight::request()->data->getData();

        $item = Flight::recipe_ingredient_service()->update(
            (int) $recipe_id,
            (int) $ingredient_id,
            $data
        );

        Flight::json($item);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Remove an ingredient from a recipe
Flight::route('DELETE /api/recipe-ingredients/@recipe_id:[0-9]+/@ingredient_id:[0-9]+', function ($recipe_id, $ingredient_id) {
    try {
        Flight::recipe_ingredient_service()->delete(
            (int) $recipe_id,
            (int) $ingredient_id
        );

        Flight::json([
            'message' => 'Ingredient removed from recipe successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
