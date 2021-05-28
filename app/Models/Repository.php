<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\RepositoryLanguage;
use App\Models\RepositoryDemo;

class Repository extends Model
{
    use HasFactory;
    protected $fillable = ['*'];

    public static function findByGitId(int $gitId) : ?self
    {
        return self::where('git_id', $gitId)->get()->first();
    }

    public function demo() : ?RepositoryDemo
    {
        return $this->belongsTo(RepositoryDemo::class, 'project_id', 'id')->first();
    }
}
