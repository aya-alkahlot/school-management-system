<?php

namespace Tests;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Route;
use function PHPUnit\Framework\assertTrue;
use function PHPUnit\Framework\assertContains;




abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


     /**
     * Logs in the specified user or creates and logs in a new user if none is provided.
     *
     * @param User|null $user The user to log in, or null to create and log in a new user.
     *
     * @return TestCase Returns the current test case instance for method chaining.
     */
    protected function login(User $user = null, array $permissions = []): TestCase
    {
        return $this->actingAs($user ?? UserFactory::new()->create(),'web');
    }


}