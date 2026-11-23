<?php
declare(strict_types=1);

require_once __DIR__ . '/../dao/BaseDAO.php';
require_once __DIR__ . '/../utils/exceptions.php';

class BaseService
{
    protected BaseDAO $dao;
    protected string $notFoundMessage;

    public function __construct(
        BaseDAO $dao,
        string $notFoundMessage = 'Record not found.'
    ) {
        $this->dao = $dao;
        $this->notFoundMessage = $notFoundMessage;
    }

    protected function validate(array $data, ?int $id = null): void
    {
        // Validation rules are defined in child services.
    }

    public function getAll(): array
    {
        return $this->dao->getAll();
    }

    public function getById(int $id): array
    {
        $result = $this->dao->getById($id);

        if ($result === false) {
            throw new NotFoundException($this->notFoundMessage);
        }

        return $result;
    }

    public function add(array $data): array
    {
        $this->validate($data);

        $id = $this->dao->insert($data);

        return $this->getById($id);
    }

    public function update(int $id, array $data): array
    {
        $this->getById($id);

        $this->validate($data, $id);

        $this->dao->update($id, $data);

        return $this->getById($id);
    }

    public function delete(int $id): bool
    {
        $this->getById($id);

        return $this->dao->delete($id);
    }
}
