<?php

namespace App\Services;

use App\DTO\Auth\LoginResponseDTO;
use App\Exceptions\InvalidCredentialException;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;

class AuthService {
    protected UserRepository $userRepo;

    /**
     * @param UserRepository $userRepo
     */
    public function __construct(UserRepository $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    /**
     * @param string $email
     * @param string $password
     *
     * @return LoginResponseDTO
     */
    public function login(string $email, string $password): LoginResponseDTO
    {
        $user = $this->userRepo->getByEmail($email);

        if (!$user || !Hash::check($password, $user->password)) {
            throw new InvalidCredentialException();
        }

        $user->tokens()->delete();
        $token = $user->createToken('api_token')->plainTextToken;

        return new LoginResponseDTO($user, $token);
    }
}
