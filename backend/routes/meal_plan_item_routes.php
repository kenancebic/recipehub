<?php

declare(strict_types=1);

// Get all meal plan items
Flight::route('GET /api/meal-plan-items', function () {
    try {
        $items = Flight::meal_plan_item_service()->getAll();

        Flight::json($items);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get one meal plan item by ID
Flight::route('GET /api/meal-plan-items/@id:[0-9]+', function ($id) {
    try {
        $item = Flight::meal_plan_item_service()->getById((int) $id);

        Flight::json($item);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get items for one meal plan
Flight::route('GET /api/meal-plans/@meal_plan_id:[0-9]+/items', function ($meal_plan_id) {
    try {
        $items = Flight::meal_plan_item_service()->getByMealPlan((int) $meal_plan_id);

        Flight::json($items);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Create a meal plan item
Flight::route('POST /api/meal-plan-items', function () {
    try {
        $data = Flight::request()->data->getData();

        $item = Flight::meal_plan_item_service()->add($data);

        Flight::json($item, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Update a meal plan item
Flight::route('PUT /api/meal-plan-items/@id:[0-9]+', function ($id) {
    try {
        $data = Flight::request()->data->getData();

        $item = Flight::meal_plan_item_service()->update((int) $id, $data);

        Flight::json($item);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Delete a meal plan item
Flight::route('DELETE /api/meal-plan-items/@id:[0-9]+', function ($id) {
    try {
        Flight::meal_plan_item_service()->delete((int) $id);

        Flight::json([
            'message' => 'Meal plan item deleted successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
