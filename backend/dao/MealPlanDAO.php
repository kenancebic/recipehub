<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class MealPlanDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('meal_plans');
    }

    public function getByUser(int $userId): array
    {
        $sql = 'SELECT * FROM meal_plans
                WHERE user_id = :user_id';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchAll();
    }
}