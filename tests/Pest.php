<?php

/*
|--------------------------------------------------------------------------
| Test Case
|--------------------------------------------------------------------------
|
| The closure you provide to your test functions is always bound to a specific PHPUnit test
| case class. By default, that class is "PHPUnit\Framework\TestCase". Of course, you may
| need to change it using the "uses()" function to bind a different classes or traits.
|
*/

use App\Domain\Auth\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase;
use Illuminate\Support\Facades\Artisan;
use function Pest\Laravel\actingAs;

uses(
    Tests\TestCase::class,
     Illuminate\Foundation\Testing\RefreshDatabase::class,
)->in('Feature');

beforeEach(function () {
    // Run migrations for the testing database
    Artisan::call('assignment:setup --force');
});

/*
|--------------------------------------------------------------------------
| Expectations
|--------------------------------------------------------------------------
|
| When you're writing tests, you often need to check that values meet certain conditions. The
| "expect()" function gives you access to a set of "expectations" methods that you can use
| to assert different things. Of course, you may extend the Expectation API at any time.
|
*/

expect()->extend('toBeOne', function () {
    return $this->toBe(1);
});

/*
|--------------------------------------------------------------------------
| Functions
|--------------------------------------------------------------------------
|
| While Pest is very powerful out-of-the-box, you may have some testing code specific to your
| project that you don't want to repeat in every file. Here you can also expose helpers as
| global functions to help you to reduce the number of lines of code in your test files.
|
*/

if(!function_exists('login')) {
    /**
     * Login User
     * @return TestCase
     */
    function login(): TestCase
    {
        $user = User::factory()->create();
        return actingAs($user)
            ->withToken(
                $user
                    ->createToken('TestToken')
                    ->accessToken
            );
    }
}

if(!function_exists('loginAs')){
    /**
     * Login as for test
     * @param User|null $user
     * @return User|Collection|Model
     */
    function loginAs(User $user = null): Model|Collection|User
    {
        $user = $user ?? User::factory()->create();
        actingAs($user);

        return $user;
    }
}

if(!function_exists('loginAsAnd')){
    /**
     * Login as for test
     * @return TestCase
     */
    function loginAsAnd(): TestCase
    {
        return actingAs(User::factory()->create());
    }
}
