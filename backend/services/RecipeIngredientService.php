<?php

declare(strict_types=1);

require_once __DIR__ . '/../dao/RecipeIngredientDAO.php';
require_once __DIR__ . '/../dao/RecipeDAO.php';
require_once __DIR__ . '/../dao/IngredientDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class RecipeIngredientService
{
    private RecipeIngredientDAO $recipeIngredientDAO;
    private RecipeDAO $recipeDAO;
    private IngredientDAO $ingredientDAO;

    public function __construct(
        RecipeIngredientDAO $recipeIngredientDAO,
        RecipeDAO $recipeDAO,
        IngredientDAO $ingredientDAO
    ) {
        $this->recipeIngredientDAO = $recipeIngredientDAO;
        $this->recipeDAO = $recipeDAO;
        $this->ingredientDAO = $ingredientDAO;
    }

    public function getAll(): array
    {
        return $this->recipeIngredientDAO->getAll();
    }

    public function getByRecipe(int $recipeId): array
    {
        Validator::integer($recipeId, 'recipe_id', 1);

        if ($this->recipeDAO->getById($recipeId) === false) {
            throw new NotFoundException('Recipe not found.');
        }

        return $this->recipeIngredientDAO->getByRecipe($recipeId);
    }

    public function add(array $data): array
    {
        Validator::required($data, [
            'recipe_id',
            'ingredient_id',
            'quantity'
        ]);

        $this->validateData($data);

        $recipeId = (int) $data['recipe_id'];
        $ingredientId = (int) $data['ingredient_id'];

        foreach ($this->recipeIngredientDAO->getByRecipe($recipeId) as $item) {
            if ((int) $item['ingredient_id'] === $ingredientId) {
                throw new ValidationException(
                    'This ingredient is already added to the recipe.'
                );
            }
        }

        $this->recipeIngredientDAO->insert([
            'recipe_id' => $recipeId,
            'ingredient_id' => $ingredientId,
            'quantity' => trim((string) $data['quantity'])
        ]);

        foreach ($this->recipeIngredientDAO->getByRecipe($recipeId) as $item) {
            if ((int) $item['ingredient_id'] === $ingredientId) {
                return $item;
            }
        }

        throw new NotFoundException(
            'Recipe ingredient could not be found.'
        );
    }

    public function update(
        int $recipeId,
        int $ingredientId,
        array $data
    ): array {
        Validator::required($data, ['quantity']);

        $this->validateData([
            'recipe_id' => $recipeId,
            'ingredient_id' => $ingredientId,
            'quantity' => $data['quantity']
        ]);

        $this->findRelation($recipeId, $ingredientId);

        $this->recipeIngredientDAO->updateRelation(
            $recipeId,
            $ingredientId,
            trim((string) $data['quantity'])
        );

        foreach ($this->recipeIngredientDAO->getByRecipe($recipeId) as $item) {
            if ((int) $item['ingredient_id'] === $ingredientId) {
                return $item;
            }
        }

        throw new NotFoundException('Recipe ingredient not found.');
    }

    public function delete(int $recipeId, int $ingredientId): bool
    {
        $this->findRelation($recipeId, $ingredientId);

        return $this->recipeIngredientDAO->deleteRelation(
            $recipeId,
            $ingredientId
        );
    }

    private function validateData(array $data): void
    {
        Validator::integer($data['recipe_id'], 'recipe_id', 1);
        Validator::integer($data['ingredient_id'], 'ingredient_id', 1);

        $quantity = trim((string) $data['quantity']);

        Validator::required(['quantity' => $quantity], ['quantity']);
        Validator::length($quantity, 'quantity', 1, 100);

        if ($this->recipeDAO->getById((int) $data['recipe_id']) === false) {
            throw new NotFoundException('Recipe not found.');
        }

        if (
            $this->ingredientDAO->getById((int) $data['ingredient_id']) === false
        ) {
            throw new NotFoundException('Ingredient not found.');
        }
    }

    private function findRelation(int $recipeId, int $ingredientId): array
    {
        Validator::integer($recipeId, 'recipe_id', 1);
        Validator::integer($ingredientId, 'ingredient_id', 1);

        foreach ($this->recipeIngredientDAO->getByRecipe($recipeId) as $item) {
            if ((int) $item['ingredient_id'] === $ingredientId) {
                return $item;
            }
        }

        throw new NotFoundException('Recipe ingredient not found.');
    }
}
