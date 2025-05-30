<?php

namespace App\Services\Admin;

use App\Repositories\Admin\ViewRepository;
use App\Services\Interfaces\Admin\ViewServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class ViewService implements ViewServiceInterface
{
    protected $viewRepository;
    
    public function __construct (ViewRepository $viewRepository) {
        $this->viewRepository = $viewRepository;
    }

    public function increaseView(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->viewRepository->increaseView($data);
        } 
        catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to set view');
        }
        DB::commit();
        return $result;
    }

    public function getUsersViewByIdea($ideaId)
    {
        return $this->viewRepository->getUsersViewByIdea($ideaId);
    }

}