<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\ResponseFactory;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request Request
     * @return Response|ResponseFactory
     */
    public function index(Request $request): Response|ResponseFactory
    {
        /** @var \Illuminate\Database\Eloquent\Builder<Log> $query */
        $query = Log::query();
        if ($request->filled('level')) {
            $query->where('level', $request->input('level'));
        }
        $logs = $query->paginate(10);
        return inertia('Logs', [
            'logs' => $logs,
            'filters' => $request->only(['level']),
        ]);
    }
}
