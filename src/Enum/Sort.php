<?php

declare(strict_types=1);

namespace App\Enum;

enum Sort: string
{
    case Asc = 'ASC';
    case Desc = 'DESC';
}
