<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class CategoryDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('categories');
    }

    public function getByName(string $name): array|false
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE name = :name
                LIMIT 1";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['name' => $name]);

        return $statement->fetch();
    }
}
