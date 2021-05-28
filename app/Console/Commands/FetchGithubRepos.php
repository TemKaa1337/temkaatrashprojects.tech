<?php

namespace App\Console\Commands;

use App\Models\Repository;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchGithubRepos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:repos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';
    public string $apiUrl = 'https://api.github.com/users/temkaa1337/repos';

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
        // TODO add cron command to run this command once a day
        $response = Http::get($this->apiUrl);

        if ($response->status() == 200) {

            foreach ($response->json() as $repo) {
                Repository::updateOrCreate(
                    ['git_id' => $repo['id']],
                    [
                        'name' => $repo['full_name'],
                        'repo_url' => $repo['html_url'],
                        'clone_url' => $repo['clone_url'],
                        'description' => $repo['description']
                    ]
                );
            }
        }

        return 0;
    }
}
