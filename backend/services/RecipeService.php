<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/RecipeDAO.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class RecipeService extends BaseService
{
    private UserDAO $userDAO;
    private CategoryDAO $categoryDAO;

    public function __construct(
        RecipeDAO $recipeDAO,
        UserDAO $userDAO,
        CategoryDAO $categoryDAO
    ) {
        $this->userDAO = $userDAO;
        $this->categoryDAO = $categoryDAO;

        parent::__construct($recipeDAO, 'Recipe not found.');
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, [
            'user_id',
            'category_id',
            'title',
            'instructions',
            'difficulty',
            'prep_time'
        ]);

        $allowedFields = [
            'user_id',
            'category_id',
            'title',
            'description',
            'instructions',
            'difficulty',
            'prep_time'
        ];

        foreach (array_keys($data) as $field) {
            if (!in_array($field, $allowedFields, true)) {
                throw new ValidationException(
                    "Field '$field' is not allowed."
                );
            }
        }

        Validator::integer($data['user_id'], 'user_id', 1);
        Validator::integer($data['category_id'], 'category_id', 1);
        Validator::integer($data['prep_time'], 'prep_time', 0);

        Validator::length(trim((string) $data['title']), 'title', 2, 150);

        if (trim((string) $data['instructions']) === '') {
            throw new ValidationException(
                'Instructions are required.'
            );
        }

        Validator::one_of(
            $data['difficulty'],
            'difficulty',
            ['easy', 'medium', 'hard']
        );

        if (
            $this->userDAO->getById((int) $data['user_id']) === false
        ) {
            throw new ValidationException('User does not exist.');
        }

        if (
            $this->categoryDAO->getById((int) $data['category_id']) === false
        ) {
            throw new ValidationException('Category does not exist.');
        }
    }

    public function add(array $data): array
    {
        $data['title'] = trim((string) ($data['title'] ?? ''));
        $data['instructions'] = trim(
            (string) ($data['instructions'] ?? '')
        );

        if (isset($data['description'])) {
            $data['description'] = trim((string) $data['description']);
        }

        return parent::add($data);
    }

    public function update(int $id, array $data): array
    {
        if (isset($data['title'])) {
            $data['title'] = trim((string) $data['title']);
        }

        if (isset($data['instructions'])) {
            $data['instructions'] = trim(
                (string) $data['instructions']
            );
        }

        if (isset($data['description'])) {
            $data['description'] = trim((string) $data['description']);
        }

        return parent::update($id, $data);
    }
}
