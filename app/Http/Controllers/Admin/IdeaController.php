<?php

namespace App\Http\Controllers\Admin;

use ZipArchive;
use App\Models\Idea;
use App\Models\Closure;
use App\Exports\IdeasExport;
use Illuminate\Http\Request;
use App\Services\Admin\IdeaService;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Routing\Controllers\Middleware;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use App\Http\Requests\Admin\Idea\CreateIdeaRequest;
use App\Http\Requests\Admin\Idea\UpdateIdeaRequest;

class IdeaController extends Controller implements HasMiddleware
{

    protected $ideaService;
    public static function middleware(): array
    {
        return [
            new Middleware('permission:idea-list', only: ['index', 'show']),
            new Middleware('permission:idea-create', only: ['store']),
            new Middleware('permission:idea-edit', only: ['update', 'changeStatus']),
            new Middleware('permission:dashboard-view', only: ['mostPopularIdeas'])
        ];

    }

    public function __construct(IdeaService $ideaService)
    {
        $this->ideaService = $ideaService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ideas = $this->ideaService->getIdeas($request);

        return response()->success('Success!', Response::HTTP_OK, $ideas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIdeaRequest $request)
    {
        $this->ideaService->create($request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->ideaService->getIdea($id);

        return response()->success('Success!', Response::HTTP_OK, $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdeaRequest $request, Idea $idea)
    {
        $this->ideaService->update($idea, $request->all());

        return response()->success('Success!', Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function changeStatus(Idea $idea)
    {
        $changedStatus = $this->ideaService->changeStatus($idea);

        return response()->success('Success!', Response::HTTP_OK, $changedStatus);
    }

    public function export($closure_id)
    {
        $closure = Closure::where('id', $closure_id)->first();
        $filename = 'Ideas_For_' . str_replace(' ', '_', $closure->name) . '.csv';

        return Excel::download(new IdeasExport($closure_id), $filename);
    }

    public function downloadDocuments($closure_id)
    {
        $closure = Closure::where('id', $closure_id)->first();
        $ideas = Idea::with('documents')->where('closure_id', $closure_id)->get();

        $zipFileName = 'Documents_For_' . str_replace(' ', '_', $closure->name) . '.zip';
        $zipPath = storage_path('app/public/' . $zipFileName);
        $zip = new ZipArchive;

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($ideas as $idea) {
                foreach ($idea->documents as $document) {
                    $path = parse_url($document->file_path, PHP_URL_PATH);
                    $pathParts = explode('/', $path);
                    $filepath = implode('/', array_slice($pathParts, 2));

                    if ($filepath && Storage::exists($filepath)) {
                        // Get the full path of the file to add to the ZIP
                        $fullFilePath = storage_path('app/public/' . $filepath);
                        $zip->addFile($fullFilePath, basename($fullFilePath));
                    } else {
                        // Log a warning for missing files
                        Log::warning("File not found: " . $filepath);
                    }

                }
            }
            $zip->close();
        } else {
            return response()->json(['message' => 'Unable to create ZIP file'], 500);
        }

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }

    public function mostPopularIdeas()
    {
        $ideas = Idea::withCount(['reactions', 'comments', 'views'])->orderByRaw('(comments_count + (reactions_count / 4) + (views_count / 8)) DESC');

        if (request()->has('paginate')) {
            $ideas = $ideas->paginate(request()->get('paginate'));
        } else {
            $ideas = $ideas->paginate(5);
        }

        return $ideas;
    }
}
