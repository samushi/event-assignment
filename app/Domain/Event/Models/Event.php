<?php

namespace App\Domain\Event\Models;

use App\Domain\Auth\Models\User;
use App\Support\ReadModel;
use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends ReadModel
{
    /**
     * Fillable attributes
     *
     * @var string[]
     */
    protected $fillable = [
        'title',
        'creator',
        'event_date',
        'location',
        'description',
        'weather_prediction',
    ];

    /**
     * Factory Path
     */
    protected static function newFactory(): EventFactory|Factory
    {
        return EventFactory::new();
    }

    /**
     * Casts attributes
     *
     * @var string[]
     */
    protected $casts = [
        'event_date' => 'date:Y-m-d H:i',
        'weather_prediction' => 'array',
    ];

    /**
     * Relationship to users (invitees)
     */
    public function invitees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')->withTimestamps();
    }
}
