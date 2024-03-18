<?php

declare(strict_types=1);

use App\Domain\Auth\Models\User;
use App\Domain\Event\Models\Event;
use Faker\Factory as Faker;
use Illuminate\Testing\Fluent\AssertableJson;

test('Create Event', function (): void {
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
        'invitees' => $emails,
    ])->assertOk();
})->group('event');

test('Get Event', function (): void {
    $event = Event::factory()->create();
    loginAsAnd()->getJson(route('event:get', ['event' => $event->id]))
        ->assertOk()
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->has('data.id')
                ->has('data.title')
                ->has('data.description')
                ->has('data.event_date')
                ->has('data.weather_prediction')
                ->etc()
        );
});

test('Delete Event', function (): void {
    $event = Event::factory()->create();
    loginAsAnd()->deleteJson(route('event:delete', ['event' => $event->id]))
        ->assertOk();
});

test('Update Event', function (): void {
    $faker = Faker::create();
    $event = Event::factory()->create();
    $title = $faker->text;

    loginAsAnd()->putJson(route('event:update', ['event' => $event->id]), [
        'title' => $title,
    ])->assertOk()
        ->assertJson(fn (AssertableJson $json) => $json->has('data.title')
            ->where('data.title', $title)
            ->etc()
        );
});

test('Get all events by interval date', function (): void {
    // Create events first
    Event::factory()->count(5)->create();

    // Create Query for parameters
    $parameters = http_build_query([
        'start' => now()->format('Y-m-d'),
        'end' => now()->addMonths(2)->format('Y-m-d'),
        'per_page' => 10,
    ]);

    loginAsAnd()->getJson(route('event:interval').'?'.$parameters)
        ->assertOk()
        ->assertJsonCount(5, 'data.events')
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->has('data.events')
                ->has('data.events.0',
                    fn (AssertableJson $json) => $json
                        ->has('id')
                        ->has('title')
                        ->has('description')
                        ->has('event_date')
                        ->has('weather_prediction')
                )
                ->has('data.links')
                ->has('data.meta')
                ->etc()
        );
});

test('Get all events grouped by location', function (): void {
    Event::factory()->count(5)->create();
    $parameters = http_build_query([
        'start' => now()->format('Y-m-d'),
        'end' => now()->addMonths(2)->format('Y-m-d'),
        'per_page' => 10,
    ]);

    loginAsAnd()->getJson(route('event:location').'?'.$parameters)
        ->assertOk()
        ->assertJson(
            fn (AssertableJson $json) => $json
                ->has('data.data')
                ->has('data.data.0',
                    fn (AssertableJson $json) => $json
                        ->has('location')
                        ->has('events')
                        ->etc()
                )
                ->has('data.links')
                ->has('data.meta')
                ->etc()
        );
});
