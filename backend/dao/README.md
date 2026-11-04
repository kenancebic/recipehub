# RecipeHub DAO Layer

DAO classes use PDO to access the MySQL database.

## Available DAO classes

- UserDAO
- CategoryDAO
- RecipeDAO
- IngredientDAO
- RecipeIngredientDAO
- SavedRecipeDAO
- MealPlanDAO
- MealPlanItemDAO

## Shared CRUD methods

All DAO classes extend BaseDAO and inherit:

- getAll()
- getById()
- insert()
- update()
- delete()

Some tables use composite primary keys. Their DAO classes include
additional methods to work with both key values.

## Example

```php
require_once __DIR__ . '/dao/RecipeDAO.php';

$recipeDAO = new RecipeDAO();

$recipes = $recipeDAO->getAll();
$recipe = $recipeDAO->getById(1);