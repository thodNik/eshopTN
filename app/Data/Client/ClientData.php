<?php

namespace App\Data\Client;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Support\Validation\ValidationContext;
use function Webmozart\Assert\Tests\StaticAnalysis\digits;

class ClientData extends Data
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $email,
        public ?string $password,
        public string $address,
        public string $phone,
        public string $zipcode,
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
            'address' => ['required', 'string', 'between:2,100'],
            'phone' => ['required', 'string','regex:/^[0-9]{10}$/'],
            'zipcode' => ['string', 'digits:5']
        ];
    }
}
