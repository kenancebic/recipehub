<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class RecipeIngredientDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('recipe_ingredients', 'recipe_id');
    }

    public function getByRecipe(int $recipeId): array
    {
        $sql = 'SELECT ri.recipe_id, ri.ingredient_id, ri.quantity,
                       i.name AS ingredient_name
                FROM recipe_ingredients ri
                JOIN ingredients i ON i.id = ri.ingredient_id
                WHERE ri.recipe_id = :recipe_id';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['recipe_id' => $recipeId]);

        return $statement->fetchAll();
    }

    public function deleteRelation(int $recipeId, int $ingredientId): bool
    {
        $sql = 'DELETE FROM recipe_ingredients
                WHERE recipe_id = :recipe_id
                AND ingredient_id = :ingredient_id';

        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            'recipe_id' => $recipeId,
            'ingredient_id' => $ingredientId,
        ]);
    }
}