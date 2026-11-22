<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class UserDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function getAll(): array
    {
        $sql = 'SELECT id, name, email, role, created_at FROM users';

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = 'SELECT id, name, email, role, created_at
                FROM users
                WHERE id = :id';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public function getByEmail(string $email): array|false
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['email' => $email]);

        return $statement->fetch();
    }
}
