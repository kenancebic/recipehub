<?php

declare(strict_types=1);

// Error reporting
error_reporting(E_ALL);
ini_set('display_errors', '0');

// Composer autoload
require_once __DIR__ . '/vendor/autoload.php';

// Exceptions
require_once __DIR__ . '/utils/exceptions.php';

// DAO classes
require_once __DIR__ . '/dao/BaseDAO.php';
require_once __DIR__ . '/dao/UserDAO.php';
require_once __DIR__ . '/dao/CategoryDAO.php';
require_once __DIR__ . '/dao/IngredientDAO.php';
require_once __DIR__ . '/dao/RecipeDAO.php';
require_once __DIR__ . '/dao/RecipeIngredientDAO.php';
require_once __DIR__ . '/dao/SavedRecipeDAO.php';
require_once __DIR__ . '/dao/MealPlanDAO.php';
require_once __DIR__ . '/dao/MealPlanItemDAO.php';

// Service classes
require_once __DIR__ . '/services/BaseService.php';
require_once __DIR__ . '/services/UserService.php';
require_once __DIR__ . '/services/CategoryService.php';
require_once __DIR__ . '/services/IngredientService.php';
require_once __DIR__ . '/services/RecipeService.php';
require_once __DIR__ . '/services/RecipeIngredientService.php';
require_once __DIR__ . '/services/SavedRecipeService.php';
require_once __DIR__ . '/services/MealPlanService.php';
require_once __DIR__ . '/services/MealPlanItemService.php';
require_once __DIR__ . '/services/ExternalApiService.php';

// Enable FlightPHP error handling
Flight::set('flight.handle_errors', true);
Flight::set('flight.log_errors', true);

// Global error handler
Flight::map('error', function (Throwable $error) {

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
});

// Register services
Flight::register(
    'user_service',
    UserService::class,
    [new UserDAO()]
);

Flight::register(
    'category_service',
    CategoryService::class,
    [new CategoryDAO()]
);

Flight::register(
    'ingredient_service',
    IngredientService::class,
    [new IngredientDAO()]
);

Flight::register(
    'recipe_service',
    RecipeService::class,
    [
        new RecipeDAO(),
        new UserDAO(),
        new CategoryDAO()
    ]
);

Flight::register(
    'recipe_ingredient_service',
    RecipeIngredientService::class,
    [
        new RecipeIngredientDAO(),
        new RecipeDAO(),
        new IngredientDAO()
    ]
);

Flight::register(
    'saved_recipe_service',
    SavedRecipeService::class,
    [
        new SavedRecipeDAO(),
        new UserDAO(),
        new RecipeDAO()
    ]
);

Flight::register(
    'meal_plan_service',
    MealPlanService::class,
    [
        new MealPlanDAO(),
        new UserDAO()
    ]
);

Flight::register(
    'meal_plan_item_service',
    MealPlanItemService::class,
    [
        new MealPlanItemDAO(),
        new MealPlanDAO(),
        new RecipeDAO()
    ]
);

// Register external API service
Flight::register(
    'external_api_service',
    ExternalApiService::class
);

// Load API routes
require_once __DIR__ . '/routes/category_routes.php';
require_once __DIR__ . '/routes/ingredient_routes.php';
require_once __DIR__ . '/routes/recipe_routes.php';
require_once __DIR__ . '/routes/recipe_ingredient_routes.php';
require_once __DIR__ . '/routes/saved_recipe_routes.php';
require_once __DIR__ . '/routes/meal_plan_routes.php';
require_once __DIR__ . '/routes/meal_plan_item_routes.php';
require_once __DIR__ . '/routes/user_routes.php';
require_once __DIR__ . '/routes/external_api_routes.php';

// OpenAPI YAML endpoint
Flight::route('GET /openapi.yaml', function () {
    $file = __DIR__ . '/docs/openapi.yaml';

    if (!file_exists($file)) {
        Flight::json(['error' => 'OpenAPI documentation not found.'], 404);
        return;
    }

    header('Content-Type: application/yaml; charset=utf-8');
    readfile($file);
});

// Swagger UI page
Flight::route('GET /docs', function () {
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RecipeHub API Documentation</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@5/swagger-ui.css">
</head>
<body>
    <div id="swagger-ui"></div>

    <script src="https://unpkg.com/swagger-ui-dist@5/swagger-ui-bundle.js"></script>
    <script>
        window.onload = function () {
            SwaggerUIBundle({
                url: "/openapi.yaml",
                dom_id: "#swagger-ui",
                deepLinking: true
            });
        };
    </script>
</body>
</html>';
});

// Default route
Flight::route('GET /', function () {
    Flight::json([
        'message' => 'RecipeHub API is running.'
    ]);
});

// Start FlightPHP
Flight::start();
