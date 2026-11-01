<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class IngredientDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('ingredients');
    }
}