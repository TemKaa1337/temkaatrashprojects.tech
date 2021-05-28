<?php

namespace App\Console\Commands;

use App\Models\Repository;
use App\Models\RepositoryDemo;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class FetchRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Updates public information repos from TemKaa github';

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
        $response = Http::get(env('GITHUB_URL'));

        if ($response->status() == 200) {
            dd($response->json());
            foreach ($response->json() as $repo) {

                $repository = Repository::findByGitId($repo['id']);

                if ($repository === null) {
                    $repoId = Repository::insert([
                        'git_id' => $repo['id'],
                        'name' => $repo['name'],
                        'repo_url' => $repo['html_url'],
                        'clone_url' => $repo['clone_url'],
                        'description' => $repo['description'],
                        'language' => $repo['language']
                    ]);

                    RepositoryDemo::insert([
                        'project_id' => $repoId
                    ]);

                } else {
                    $repository->language = $repo['language'];
                    $repository->description = $repo['description'];
                    $repository->save();
                }
            }
        } else echo "Error occured, got status code: {$response->status()}";

        return 0;
    }
}
