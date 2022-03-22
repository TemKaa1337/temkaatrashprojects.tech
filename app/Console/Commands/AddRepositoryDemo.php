<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Repository;

class AddRepositoryDemo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:demo {repoId} {demoPath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add demo path to existing repository';

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
        $repoId = $this->argument('repoId');
        $demoPath = $this->argument('demoPath');

        if ($repoId !== null && $demoPath !== null) {
            $repo = Repository::find($repoId);

            if ($repo !== null) {
                $demo = $repo->demo()->first();

                $demo->demo_url = $demoPath;
                $demo->save();

                echo 'Successfully added demo path.'.PHP_EOL;
            } echo 'There is no existing repository with this id.'.PHP_EOL;
        } else echo 'Not enough arguments.'.PHP_EOL;

        return 0;
    }
}
