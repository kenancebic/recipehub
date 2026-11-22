<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/CategoryDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class CategoryService extends BaseService
{
    private CategoryDAO $categoryDAO;

    public function __construct(CategoryDAO $categoryDAO)
    {
        $this->categoryDAO = $categoryDAO;

        parent::__construct($categoryDAO, 'Category not found.');
    }

    protected function validate(array $data, ?int $id = null): void
    {
        Validator::required($data, ['name']);

        foreach (array_keys($data) as $field) {
            if ($field !== 'name') {
                throw new ValidationException(
                    "Field '$field' is not allowed."
                );
            }
        }

        $name = trim((string) $data['name']);

        Validator::length($name, 'name', 2, 100);

        $existingCategory = $this->categoryDAO->getByName($name);

        if (
            $existingCategory !== false
            && (int) $existingCategory['id'] !== $id
        ) {
            throw new ValidationException(
                'A category with this name already exists.'
            );
        }
    }

    public function add(array $data): array
    {
        Validator::required($data, ['name']);

        $data['name'] = trim((string) $data['name']);

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
