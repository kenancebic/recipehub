<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/MealPlanDAO.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class MealPlanService extends BaseService
{
    private UserDAO $userDAO;

    public function __construct(
        MealPlanDAO $mealPlanDAO,
        UserDAO $userDAO
    ) {
        $this->userDAO = $userDAO;

        parent::__construct($mealPlanDAO, 'Meal plan not found.');
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, [
            'user_id',
            'name',
            'start_date',
            'end_date'
        ]);

        $allowedFields = [
            'user_id',
            'name',
            'start_date',
            'end_date'
        ];

        foreach (array_keys($data) as $field) {
            if (!in_array($field, $allowedFields, true)) {
                throw new ValidationException(
                    "Field '$field' is not allowed."
                );
            }
        }

        Validator::integer($data['user_id'], 'user_id', 1);

        $name = trim((string) $data['name']);

        Validator::length($name, 'name', 2, 150);

        if ($this->userDAO->getById((int) $data['user_id']) === false) {
            throw new ValidationException('User does not exist.');
        }

        foreach (['start_date', 'end_date'] as $field) {
            $date = (string) $data[$field];

            if (
                !preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)
            ) {
                throw new ValidationException(
                    "Field '$field' must use YYYY-MM-DD format."
                );
            }

            [$year, $month, $day] = array_map(
                'intval',
                explode('-', $date)
            );

            if (!checkdate($month, $day, $year)) {
                throw new ValidationException(
                    "Field '$field' is not a valid date."
                );
            }
        }

        if ($data['end_date'] < $data['start_date']) {
            throw new ValidationException(
                'End date cannot be earlier than start date.'
            );
        }
    }

    public function add(array $data): array
    {
        if (isset($data['name'])) {
            $data['name'] = trim((string) $data['name']);
        }

        return parent::add($data);
    }

    public function update(int $id, array $data): array
    {
        if (isset($data['name'])) {
            $data['name'] = trim((string) $data['name']);
        }

        return parent::update($id, $data);
    }
}
