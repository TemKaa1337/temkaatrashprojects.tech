<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Model;
use App\Models\RepositoryDemo;

class Repository extends Model
{
    use HasFactory;
    protected $fillable = ['*'];

    public static function findByGitId(int $gitId) : ?self
    {
        return self::where('git_id', $gitId)->get()->first();
    }

    public function demo() : HasOne
    {
        return $this->hasOne(RepositoryDemo::class, 'project_id', 'id');
    }

    public function getAllRepositories() : array
    {
        $result = [];
        $repositories = self::orderBy('id')->with(['demo'])->get();

        foreach ($repositories as $repository) {
            $result[] = [
                'id' => $repository->id,
                'name' => $repository->name,
                'description' => $repository->description,
                'language' => $repository->language,
                'repository_url' => $repository->repo_url,
                'clone_url' => $repository->clone_url,
                'demo_url' => $repository->demo->demo_url,
                'repo_created_at' => date('d.m.Y H:i:s', strtotime($repository->repo_created_at))
            ];
        }

        return $result;
    }
}
