<?php

namespace App\Domain\Event\Models;

use App\Domain\Auth\Models\User;
use App\Support\ReadModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends ReadModel
{
    /**
     * Fillable attributes
     * @var string[]
     */
    protected $fillable =[
      'creator',
      'event_date',
      'location'
    ];

    /**
     * Casts attributes
     * @var string[]
     */
    protected $casts = [
        'event_date' => 'datetime',
        'creator' => User::class
    ];
    /**
     * Relationship to users (invitees)
     * @return BelongsToMany
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'event_user', 'event_id', 'user_id')->withTimestamps();
    }
}
