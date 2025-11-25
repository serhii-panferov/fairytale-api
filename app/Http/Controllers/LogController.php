<?php

namespace App\Http\Controllers;

use App\Models\Log;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Log::query();
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }
        $logs = $query->paginate(10);
        return inertia('Logs', [
            'logs' => $logs,
            'filters' => $request->only(['level']),
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
