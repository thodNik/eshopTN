<?php

namespace App\Data\Client;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;

class ClientData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $password
    ) {
        if ($this->password !== null) {
            $this->password = bcrypt($this->password);
        }
    }

    public static function rules(ValidationContext $context): array
    {
        return [
            'name' => ['required', 'string', 'between:2,100'],
            'email' => ['required', 'string', 'email', 'max:100'],
            'password' => ['string', 'min:6'],
        ];
    }
}
