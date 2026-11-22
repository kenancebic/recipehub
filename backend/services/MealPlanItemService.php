<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/MealPlanItemDAO.php';
require_once __DIR__ . '/../dao/MealPlanDAO.php';
require_once __DIR__ . '/../dao/RecipeDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class MealPlanItemService extends BaseService
{
    private MealPlanDAO $mealPlanDAO;
    private RecipeDAO $recipeDAO;

    public function __construct(
        MealPlanItemDAO $mealPlanItemDAO,
        MealPlanDAO $mealPlanDAO,
        RecipeDAO $recipeDAO
    ) {
        $this->mealPlanDAO = $mealPlanDAO;
        $this->recipeDAO = $recipeDAO;

        parent::__construct(
            $mealPlanItemDAO,
            'Meal plan item not found.'
        );
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, [
            'meal_plan_id',
            'recipe_id',
            'planned_date',
            'meal_type'
        ]);

        $allowedFields = [
            'meal_plan_id',
            'recipe_id',
            'planned_date',
            'meal_type'
        ];

        foreach (array_keys($data) as $field) {
            if (!in_array($field, $allowedFields, true)) {
                throw new ValidationException(
                    "Field '$field' is not allowed."
                );
            }
        }

        Validator::integer($data['meal_plan_id'], 'meal_plan_id', 1);
        Validator::integer($data['recipe_id'], 'recipe_id', 1);

        if (
            $this->mealPlanDAO->getById((int) $data['meal_plan_id']) === false
        ) {
            throw new ValidationException('Meal plan does not exist.');
        }

        if (
            $this->recipeDAO->getById((int) $data['recipe_id']) === false
        ) {
            throw new ValidationException('Recipe does not exist.');
        }

        $date = (string) $data['planned_date'];

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
            throw new ValidationException(
                'Planned date must use YYYY-MM-DD format.'
            );
        }

        [$year, $month, $day] = array_map(
            'intval',
            explode('-', $date)
        );

        if (!checkdate($month, $day, $year)) {
            throw new ValidationException(
                'Planned date is not a valid date.'
            );
        }

        Validator::one_of(
            $data['meal_type'],
            'meal_type',
            ['breakfast', 'lunch', 'dinner', 'snack']
        );
    }
}
