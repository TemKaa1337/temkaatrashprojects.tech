<?php

declare(strict_types=1);

namespace App\Enum\Command;

enum Argument: string
{
    case DemoUrl = 'demo_url';
    case RepoName = 'repo_name';
}
