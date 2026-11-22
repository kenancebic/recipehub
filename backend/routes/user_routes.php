<?php

declare(strict_types=1);

// Get all users
Flight::route('GET /api/users', function () {
    try {
        $users = Flight::user_service()->getAll();

        Flight::json($users);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Get one user by ID
Flight::route('GET /api/users/@id:[0-9]+', function ($id) {
    try {
        $user = Flight::user_service()->getById((int) $id);

        Flight::json($user);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Create a new user
Flight::route('POST /api/users', function () {
    try {
        $data = Flight::request()->data->getData();

        $user = Flight::user_service()->add($data);

        Flight::json($user, 201);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Update a user
Flight::route('PUT /api/users/@id:[0-9]+', function ($id) {
    try {
        $data = Flight::request()->data->getData();

        $user = Flight::user_service()->update((int) $id, $data);

        Flight::json($user);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});

// Delete a user
Flight::route('DELETE /api/users/@id:[0-9]+', function ($id) {
    try {
        Flight::user_service()->delete((int) $id);

        Flight::json([
            'message' => 'User deleted successfully.'
        ]);
    } catch (Throwable $error) {
        sendApiError($error);
    }
});
