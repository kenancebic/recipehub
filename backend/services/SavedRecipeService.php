<?php

declare(strict_types=1);

require_once __DIR__ . '/../dao/SavedRecipeDAO.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../dao/RecipeDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class SavedRecipeService
{
    private SavedRecipeDAO $savedRecipeDAO;
    private UserDAO $userDAO;
    private RecipeDAO $recipeDAO;

    public function __construct(
        SavedRecipeDAO $savedRecipeDAO,
        UserDAO $userDAO,
        RecipeDAO $recipeDAO
    ) {
        $this->savedRecipeDAO = $savedRecipeDAO;
        $this->userDAO = $userDAO;
        $this->recipeDAO = $recipeDAO;
    }

    public function getAll(): array
    {
        return $this->savedRecipeDAO->getAll();
    }

    public function getByUser(int $userId): array
    {
        Validator::integer($userId, 'user_id', 1);

        if ($this->userDAO->getById($userId) === false) {
            throw new NotFoundException('User not found.');
        }

        return $this->savedRecipeDAO->getByUser($userId);
    }

    public function add(array $data): array
    {
        Validator::required($data, ['user_id', 'recipe_id']);

        Validator::integer($data['user_id'], 'user_id', 1);
        Validator::integer($data['recipe_id'], 'recipe_id', 1);

        $userId = (int) $data['user_id'];
        $recipeId = (int) $data['recipe_id'];

        if ($this->userDAO->getById($userId) === false) {
            throw new NotFoundException('User not found.');
        }

        if ($this->recipeDAO->getById($recipeId) === false) {
            throw new NotFoundException('Recipe not found.');
        }

        $savedRecipes = $this->savedRecipeDAO->getByUser($userId);

        foreach ($savedRecipes as $savedRecipe) {
            if ((int) $savedRecipe['recipe_id'] === $recipeId) {
                throw new ValidationException(
                    'This recipe is already saved by the user.'
                );
            }
        }

        $this->savedRecipeDAO->insert([
            'user_id' => $userId,
            'recipe_id' => $recipeId
        ]);

        foreach ($this->savedRecipeDAO->getByUser($userId) as $savedRecipe) {
            if ((int) $savedRecipe['recipe_id'] === $recipeId) {
                return $savedRecipe;
            }
        }

        throw new NotFoundException('Saved recipe could not be found.');
    }

    public function delete(int $userId, int $recipeId): bool
    {
        Validator::integer($userId, 'user_id', 1);
        Validator::integer($recipeId, 'recipe_id', 1);

        $savedRecipes = $this->savedRecipeDAO->getByUser($userId);

        foreach ($savedRecipes as $savedRecipe) {
            if ((int) $savedRecipe['recipe_id'] === $recipeId) {
                return $this->savedRecipeDAO->deleteSavedRecipe(
                    $userId,
                    $recipeId
                );
            }
        }

        throw new NotFoundException('Saved recipe not found.');
    }
}
