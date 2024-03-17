<?php
declare(strict_types=1);

use App\Domain\Auth\Models\User;
use App\Domain\Event\Models\Event;
use Faker\Factory as Faker;

test('Create new event', function(): void {
    $faker = Faker::create();

    // Create fake emails
    $emails = collect(range(1, 5))->map(function () {
        return User::factory()->create()->email;
    })->toArray();

    // Create event
    loginAsAnd()->postJson(route('event:create'), [
        'title' => $faker->text(20),
        'event_date' => now()->addDays(14)->format('Y-m-d H:i'),
        'location' => $faker->country,
        'description' => $faker->text,
        'invitees' => $emails
    ])->assertOk();
})->group('event');


