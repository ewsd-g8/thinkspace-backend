<?php

namespace App\Services\Interfaces\Admin;

interface ViewServiceInterface
{
    public function increaseView(array $data);
    public function getUsersViewByIdea($ideaId);
}