<?php

declare(strict_types=1);

require_once __DIR__ . '/BaseService.php';
require_once __DIR__ . '/../dao/UserDAO.php';
require_once __DIR__ . '/../utils/Validator.php';

class UserService extends BaseService
{
    private UserDAO $userDAO;

    public function __construct(UserDAO $userDAO)
    {
        $this->userDAO = $userDAO;

        parent::__construct($userDAO, 'User not found.');
    }

    protected function validate(array $data, ?int $id = null): void
    {
        $allowedFields = ['name', 'email', 'password', 'role'];

        foreach (array_keys($data) as $field) {
            if (!in_array($field, $allowedFields, true)) {
                throw new ValidationException(
                    "Field '$field' is not allowed."
                );
            }
        }

        if ($id === null) {
            Validator::required($data, ['name', 'email', 'password']);
        } elseif (empty($data)) {
            throw new ValidationException(
                'At least one field must be provided.'
            );
        }

        if (isset($data['name'])) {
            $name = trim((string) $data['name']);
            Validator::length($name, 'name', 2, 100);
        }

        if (isset($data['email'])) {
            $email = strtolower(trim((string) $data['email']));

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new ValidationException(
                    'Please provide a valid email address.'
                );
            }

            $existingUser = $this->userDAO->getByEmail($email);

            if (
                $existingUser !== false
                && (int) $existingUser['id'] !== $id
            ) {
                throw new ValidationException(
                    'An account with this email already exists.'
                );
            }
        }

        if (isset($data['password'])) {
            $password = (string) $data['password'];

            Validator::length($password, 'password', 8, 255);

            if (
                !preg_match('/[A-Za-z]/', $password)
                || !preg_match('/[0-9]/', $password)
            ) {
                throw new ValidationException(
                    'Password must contain at least one letter and one number.'
                );
            }
        }

        if (isset($data['role'])) {
            Validator::one_of(
                $data['role'],
                'role',
                ['user', 'admin']
            );
        }
    }

    public function add(array $data): array
    {
        $data['name'] = trim((string) ($data['name'] ?? ''));
        $data['email'] = strtolower(trim((string) ($data['email'] ?? '')));
        $data['role'] = $data['role'] ?? 'user';

        $this->validate($data);

        $data['password'] = password_hash(
            (string) $data['password'],
            PASSWORD_BCRYPT
        );

        $id = $this->userDAO->insert($data);

        return $this->getById($id);
    }

    public function update(int $id, array $data): array
    {
        $this->getById($id);

        if (isset($data['name'])) {
            $data['name'] = trim((string) $data['name']);
        }

        if (isset($data['email'])) {
            $data['email'] = strtolower(trim((string) $data['email']));
        }

        $this->validate($data, $id);

        if (isset($data['password'])) {
            $data['password'] = password_hash(
                (string) $data['password'],
                PASSWORD_BCRYPT
            );
        }

        $this->userDAO->update($id, $data);

        return $this->getById($id);
    }
}
