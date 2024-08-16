<?php

declare(strict_types=1);

namespace App\Command\GithubRepo;

use App\Handler\GithubRepo\ParseHandler;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

#[AsCommand(name: 'app:github-repo:parse')]
final class ParseCommand extends Command
{
    public function __construct(
        private readonly LoggerInterface $githubParserLogger,
        private readonly ParseHandler $parseHandler,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $this->parseHandler->handle();

            $this->githubParserLogger->info('Successfully parsed github repositories.');
        } catch (Throwable $exception) {
            $this->githubParserLogger->error('Could not parse github repositories.');
            $this->githubParserLogger->error($exception);

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
