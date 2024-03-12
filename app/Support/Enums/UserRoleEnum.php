<?php

declare(strict_types=1);

namespace App\Support\Enums;

enum UserRoleEnum: string
{
    case TENANT_ADMIN = 'tenant';
    case SUPER_ADMIN = 'admin';
    case TENANT_MEMBER = 'member';
}
