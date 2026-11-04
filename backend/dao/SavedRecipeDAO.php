<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class SavedRecipeDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('saved_recipes', 'user_id');
    }

    public function getByUser(int $userId): array
    {
        $sql = 'SELECT sr.user_id, sr.recipe_id, sr.created_at,
                       r.title, r.description
                FROM saved_recipes sr
                JOIN recipes r ON r.id = sr.recipe_id
                WHERE sr.user_id = :user_id';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll();
    }

    public function deleteSavedRecipe(int $userId, int $recipeId): bool
    {
        $sql = 'DELETE FROM saved_recipes
                WHERE user_id = :user_id
                AND recipe_id = :recipe_id';

        $statement = $this->connection->prepare($sql);

        return $statement->execute([
            'user_id' => $userId,
            'recipe_id' => $recipeId,
        ]);
    }
}