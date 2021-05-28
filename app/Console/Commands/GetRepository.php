<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Repository;

class GetRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get all repositories names and ids';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = [];

        $repos = Repository::select('id', 'name')->get();

        foreach ($repos as $repo) {
            $result[] = "id: {$repo->id}, name: {$repo->name}";
        }

        echo 'List of existing repositories:'.PHP_EOL.implode(PHP_EOL, $result);

        return 0;
    }
}
