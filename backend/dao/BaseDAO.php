<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/Database.php';

class BaseDAO
{
    protected PDO $connection;
    protected string $table;
    protected string $primaryKey;

    public function __construct(string $table, string $primaryKey = 'id')
    {
        $this->connection = Database::connect();
        $this->table = $table;
        $this->primaryKey = $primaryKey;
    }

    public function getAll(): array
    {
        $sql = "SELECT * FROM {$this->table}";
        $statement = $this->connection->prepare($sql);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function getById(int $id): array|false
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE {$this->primaryKey} = :id";

        $statement = $this->connection->prepare($sql);
        $statement->execute(['id' => $id]);

        return $statement->fetch();
    }

    public function insert(array $data): int
    {
        $columns = array_keys($data);

        if (empty($columns)) {
            throw new InvalidArgumentException('Insert data cannot be empty.');
        }

        $columnList = implode(', ', $columns);
        $placeholders = implode(', ', array_map(
            static fn(string $column): string => ':' . $column,
            $columns
        ));

        $sql = "INSERT INTO {$this->table}
                ({$columnList}) VALUES ({$placeholders})";

        $statement = $this->connection->prepare($sql);
        $statement->execute($data);

        return (int) $this->connection->lastInsertId();
    }

    public function update(int $id, array $data): bool
    {
        if (empty($data)) {
            return false;
        }

        $setParts = [];

        foreach (array_keys($data) as $column) {
            $setParts[] = "{$column} = :{$column}";
        }

        $setClause = implode(', ', $setParts);

        $sql = "UPDATE {$this->table}
                SET {$setClause}
                WHERE {$this->primaryKey} = :primary_id";

        $data['primary_id'] = $id;

        $statement = $this->connection->prepare($sql);

        return $statement->execute($data);
    }

    public function delete(int $id): bool
    {
        $sql = "DELETE FROM {$this->table}
                WHERE {$this->primaryKey} = :id";

        $statement = $this->connection->prepare($sql);

        return $statement->execute(['id' => $id]);
    }
}