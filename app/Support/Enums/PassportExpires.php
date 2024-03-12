<?php

declare(strict_types=1);

namespace App\Support\Enums;

enum PassportExpires: int
{
    case EXPIRE_IN_DAYS = 15;
    case REFRESH_TOKEN_IN_DAYS = 30;
    case PERSONAL_TOKEN_IN_DAYS = 180;
}
