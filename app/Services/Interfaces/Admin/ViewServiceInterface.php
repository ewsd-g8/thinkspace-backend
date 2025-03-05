<?php

namespace App\Services\Interfaces\Admin;

interface ReactionServiceInterface
{
    public function increaseView(array $data);
    public function getUsersViewByIdea($ideaId);
}