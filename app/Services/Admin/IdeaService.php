<?php

namespace App\Services\Admin;

use Exception;
use App\Models\Idea;
use App\Models\Closure;
use InvalidArgumentException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Admin\IdeaRepository;
use App\Services\Interfaces\Admin\IdeaServiceInterface;

class IdeaService implements IdeaServiceInterface
{
    protected $ideaRepository;

    public function __construct(IdeaRepository $ideaRepository)
    {
        $this->ideaRepository = $ideaRepository;
    }

    public function getIdeas($request)
    {
        $result = $this->ideaRepository->getIdeas($request);

        return $result;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $data
     * @return \Illuminate\Http\Response
     */

    public function create(array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->ideaRepository->create($data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to create idea');
        }
        DB::commit();

        return $result;
    }

    public function getIdea($id)
    {
        return $this->ideaRepository->getIdea($id);
    }

    public function update(Idea $idea, array $data)
    {
        DB::beginTransaction();
        try {
            $result = $this->ideaRepository->update($idea, $data);
        } catch (Exception $exc) {
            DB::rollBack();
            Log::error($exc->getMessage());
            throw new InvalidArgumentException('Unable to update idea');
        }
        DB::commit();

        return $result;
    }

    public function getIdeasByClosure($closure_id)
    {
        return $result = $this->ideaRepository->getIdeasByClosure($closure_id);
    }
}
