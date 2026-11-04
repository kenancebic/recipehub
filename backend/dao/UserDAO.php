<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseDAO.php';

class UserDAO extends BaseDAO
{
    public function __construct()
    {
        parent::__construct('users');
    }

    public function getByEmail(string $email): array|false
    {
        $sql = 'SELECT * FROM users WHERE email = :email';

        $statement = $this->connection->prepare($sql);
        $statement->execute(['email' => $email]);

        return $statement->fetch();
    }
}