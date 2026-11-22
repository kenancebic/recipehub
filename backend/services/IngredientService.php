<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/IngredientDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class IngredientService extends BaseService
{
    private IngredientDAO $ingredientDAO;

    public function __construct(IngredientDAO $ingredientDAO)
    {
        $this->ingredientDAO = $ingredientDAO;

        parent::__construct($ingredientDAO, 'Ingredient not found.');
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

        $existingIngredient = $this->ingredientDAO->getByName($name);

        if (
            $existingIngredient !== false
            && (int) $existingIngredient['id'] !== $id
        ) {
            throw new ValidationException(
                'An ingredient with this name already exists.'
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
