<?php

declare(strict_types=1);

namespace App\Support;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class ReadModel extends Model
{
    use HasFactory, HasUuids;
}
