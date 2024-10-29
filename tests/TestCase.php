<?php

namespace Tests;

use App\Models\Person;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public string $token = '';
    public array $authorization;
    public $company;

    public function setUp(): void
    {
        parent::setUp();

        $userAdminFitLife = Person::where('email', 'admin1@gmail.com')->first();

        $this->company = $userAdminFitLife->company_id;
        $this->token = $userAdminFitLife->createToken('test')->plainTextToken;
        $this->authorization = ['authorization' => "Bearer $this->token"];
    }
}
