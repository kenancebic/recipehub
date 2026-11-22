<?php

declare(strict_types=1);

// Get all meal plans
Flight::route('GET /api/meal-plans', function () {
    try {
        $mealPlans = Flight::meal_plan_service()->getAll();

        Flight::json($mealPlans);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get one meal plan by ID
Flight::route('GET /api/meal-plans/@id:[0-9]+', function ($id) {
    try {
        $mealPlan = Flight::meal_plan_service()->getById((int) $id);

        Flight::json($mealPlan);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get meal plans for one user
Flight::route('GET /api/users/@user_id:[0-9]+/meal-plans', function ($user_id) {
    try {
        $mealPlans = Flight::meal_plan_service()->getByUser((int) $user_id);

        Flight::json($mealPlans);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Create a meal plan
Flight::route('POST /api/meal-plans', function () {
    try {
        $data = Flight::request()->data->getData();

        $mealPlan = Flight::meal_plan_service()->add($data);

        Flight::json($mealPlan, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Update a meal plan
Flight::route('PUT /api/meal-plans/@id:[0-9]+', function ($id) {
    try {
        $data = Flight::request()->data->getData();

        $mealPlan = Flight::meal_plan_service()->update((int) $id, $data);

        Flight::json($mealPlan);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Delete a meal plan
Flight::route('DELETE /api/meal-plans/@id:[0-9]+', function ($id) {
    try {
        Flight::meal_plan_service()->delete((int) $id);

        Flight::json([
            'message' => 'Meal plan deleted successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
