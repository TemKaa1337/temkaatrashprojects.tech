<?php

declare(strict_types=1);

namespace App\Enum;

enum Language: string
{
    case Html = 'HTML';
    case JavaScript = 'JavaScript';
    case Php = 'PHP';
    case Python = 'Python';
}
