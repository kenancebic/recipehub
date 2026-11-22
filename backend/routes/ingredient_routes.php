<?php

declare(strict_types=1);

// Get all ingredients
Flight::route('GET /api/ingredients', function () {
    try {
        $ingredients = Flight::ingredient_service()->getAll();

        Flight::json($ingredients);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get one ingredient by ID
Flight::route('GET /api/ingredients/@id:[0-9]+', function ($id) {
    try {
        $ingredient = Flight::ingredient_service()->getById((int) $id);

        Flight::json($ingredient);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Create a new ingredient
Flight::route('POST /api/ingredients', function () {
    try {
        $data = Flight::request()->data->getData();

        $ingredient = Flight::ingredient_service()->add($data);

        Flight::json($ingredient, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Update an ingredient
Flight::route('PUT /api/ingredients/@id:[0-9]+', function ($id) {
    try {
        $data = Flight::request()->data->getData();

        $ingredient = Flight::ingredient_service()->update((int) $id, $data);

        Flight::json($ingredient);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Delete an ingredient
Flight::route('DELETE /api/ingredients/@id:[0-9]+', function ($id) {
    try {
        Flight::ingredient_service()->delete((int) $id);

        Flight::json([
            'message' => 'Ingredient deleted successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
