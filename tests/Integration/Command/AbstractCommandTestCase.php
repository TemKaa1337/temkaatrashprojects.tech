<?php

declare(strict_types=1);

namespace App\Tests\Integration\Command;

use App\Tests\Integration\AbstractTestCase;
use Symfony\Component\Console\Tester\CommandTester;

abstract class AbstractCommandTestCase extends AbstractTestCase
{
    protected function getCommandTester(string $class): CommandTester
    {
        return new CommandTester(self::getContainer()->get($class));
    }
}
