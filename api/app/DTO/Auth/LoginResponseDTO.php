<?php

namespace App\DTO\Auth;

use App\Models\User;

class LoginResponseDTO {
    public function __construct(
        public User $user,
        public string $accessToken
    ) {}

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'user' => $this->user->only(['id', 'name', 'email']),
            'access_token' => $this->accessToken
        ];
    }
}
