<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class RecipeDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('recipes');
    }

    public function getByCategory(int $categoryId): array
    {
        $sql = 'SELECT * FROM recipes
                WHERE category_id = :category_id';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['category_id' => $categoryId]);

        return $statement->fetchAll();
    }

    public function getByUser(int $userId): array
    {
        $sql = 'SELECT * FROM recipes
                WHERE user_id = :user_id';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll();
    }
}