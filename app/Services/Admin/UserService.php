<?php

namespace App\Services\Admin;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {}

    public function getAllUsers()
    {
        return $this->repository->getAll();
    }

    public function getUserById(int $id)
    {
        return $this->repository->findById($id);
    }

    public function createUser(array $data)
    {
        return $this->repository->create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
            'role'     => $data['role'],
        ]);
    }

    public function updateUser(int $id, array $data)
    {
        $payload = [
            'name'  => $data['name'],
            'email' => $data['email'],
            'role'  => $data['role'],
        ];

        // Hanya update password kalau diisi
        if (!empty($data['password'])) {
            $payload['password'] = Hash::make($data['password']);
        }

        return $this->repository->update($id, $payload);
    }

    public function deleteUser(int $id)
    {
        return $this->repository->delete($id);
    }
}