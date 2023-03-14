<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Repository;

class RepositoryController extends Controller
{
    public function index(Request $request): Response
    {
        $repository = new Repository();
        $repositories = $repository->getAllRepositories();

        return response($repositories, 200);
    }
}
