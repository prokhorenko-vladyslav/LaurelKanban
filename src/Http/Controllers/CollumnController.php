<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Requests\CollumnIndex;
use Laurel\Kanban\Http\Resources\CollumnResource;
use Laurel\Kanban\Models\Desk;

class CollumnController extends Controller
{
    public function index(CollumnIndex $request, int $deskId)
    {
        try {
            $collumns = Desk::findOrFail($deskId)->collumns()->with('cards')->get();
        } catch (\Exception $e) {
            $collumns = [];
        }
        return CollumnResource::collection($collumns);
    }
}
