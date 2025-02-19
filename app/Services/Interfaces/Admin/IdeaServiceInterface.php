<?php

namespace App\Services\Interfaces\Admin;

use App\Models\Idea;
use Illuminate\Http\Request;

interface IdeaServiceInterface
{
    public function getIdeas(Request $request);
    public function create(array $data);
    public function update(Idea $idea, array $data);
    public function getIdea($id);
}
