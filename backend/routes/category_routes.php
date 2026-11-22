<?php

declare(strict_types=1);

// Handle API errors
function sendApiError(Throwable $error): void
{
    if ($error instanceof HttpException) {
        $status = $error->get_status();
        $message = $error->getMessage();
    } else {
        $status = 500;
        $message = 'An internal server error occurred.';
    }

    Flight::json([
        'error' => $message
    ], $status);
}

// Get all categories
Flight::route('GET /api/categories', function () {
    try {
        $categories = Flight::category_service()->getAll();
        Flight::json($categories);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get one category
Flight::route('GET /api/categories/@id:[0-9]+', function ($id) {
    try {
        $category = Flight::category_service()->getById((int) $id);
        Flight::json($category);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Create category
Flight::route('POST /api/categories', function () {
    try {
        $data = Flight::request()->data->getData();
        $category = Flight::category_service()->add($data);
        Flight::json($category, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Update category
Flight::route('PUT /api/categories/@id:[0-9]+', function ($id) {
    try {
        $data = Flight::request()->data->getData();
        $category = Flight::category_service()->update((int) $id, $data);
        Flight::json($category);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Delete category
Flight::route('DELETE /api/categories/@id:[0-9]+', function ($id) {
    try {
        Flight::category_service()->delete((int) $id);

        Flight::json([
            'message' => 'Category deleted successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
