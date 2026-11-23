<?php

declare(strict_types=1);

Flight::route('GET /api/external/meal-search', function () {

    try {
        $query = $_GET['query'] ?? '';

        if (!is_string($query) || trim($query) === '') {
            Flight::json([
                'error' => 'Please provide a recipe search query.'
            ], 400);
            return;
        }

        $service = Flight::external_api_service();

        $meals = $service->searchMeals($query);

        Flight::json([
            'success' => true,
            'query' => $query,
            'results' => $meals
        ], 200);

    } catch (InvalidArgumentException $error) {

        Flight::json([
            'error' => $error->getMessage()
        ], 400);

    } catch (Throwable $error) {

        Flight::json([
            'error' => 'Recipe search is temporarily unavailable.'
        ], 500);
    }
});
