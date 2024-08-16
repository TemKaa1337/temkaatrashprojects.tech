<?php

declare(strict_types=1);

namespace App\Enum;

enum ErrorCode: string
{
    case VALIDATION_CONSTRAINT_NOT_BLANK = 'VALIDATION_CONSTRAINT_NOT_BLANK';
    case VALIDATION_CONSTRAINT_NOT_AN_URL = 'VALIDATION_CONSTRAINT_NOT_AN_URL';
}
