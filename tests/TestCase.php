<?php



namespace Tests;

use App\Models\User;
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
     * @param array $permissions (Optional) Array of permissions to assign to the user.
     *
     * @return static Returns the current test case instance for method chaining.
     */
    protected function login(?User $user = null, array $permissions = []): static
    {
        $user = $user ?? User::factory()->create(); // هذا يعيد كائن واحد فقط، وليس مجموعة
        return $this->actingAs($user, 'web'); // تأكد من تمرير كائن واحد فقط

    }
}