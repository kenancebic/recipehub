<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class MealPlanItemDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('meal_plan_items');
    }

    public function getByMealPlan(int $mealPlanId): array
    {
        $sql = 'SELECT mpi.*, r.title AS recipe_title
                FROM meal_plan_items mpi
                JOIN recipes r ON r.id = mpi.recipe_id
                WHERE mpi.meal_plan_id = :meal_plan_id';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['meal_plan_id' => $mealPlanId]);

        return $statement->fetchAll();
    }
}