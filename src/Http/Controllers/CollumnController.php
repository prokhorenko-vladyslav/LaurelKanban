<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Requests\CollumnIndex;
use Laurel\Kanban\Http\Requests\CollumnStore;
use Laurel\Kanban\Http\Requests\CollumnUpdate;
use Laurel\Kanban\Http\Requests\CollumnDestroy;
use Laurel\Kanban\Http\Requests\CollumnReorder;
use Laurel\Kanban\Http\Requests\CollumnShow;
use Laurel\Kanban\Http\Resources\CollumnResource;
use Laurel\Kanban\Models\Collumn;
use Laurel\Kanban\Kanban;

class CollumnController extends Controller
{
    public function index(CollumnIndex $request, int $deskId)
    {
        try {
            $collumns = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->with('cards')->get();
        } catch (\Exception $e) {
            $collumns = [];
        }
        return CollumnResource::collection($collumns);
    }

    public function show(CollumnShow $request, int $deskId, int $collumnId)
    {
        try {
            return new CollumnResource(
                Kanban::getUserDesks()->findOrFail($deskId)->collumns()->with('cards')->findOrFail($deskId)
            );
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function store(CollumnStore $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $collumn = new Collumn;
            $collumn->fill($request->validated());
            $collumn->desk()->associate($desk);
            return (bool)$collumn->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function update(CollumnUpdate $request, int $deskId, int $collumnId)
    {
        try {
            $collumn = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->findOrFail($collumnId);
            $collumn->fill($request->validated());
            return (bool)$collumn->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function destroy(CollumnDestroy $request, int $deskId, int $collumnId)
    {
        try {
            $collumn = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->findOrFail($collumnId);
            $collumn->cards()->delete();
            return (bool)$collumn->delete();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function reorder(CollumnReorder $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            foreach ($request->validated()['order'] as $collumnId => $order) {
                $collumn = $desk->collumns()->find($collumnId);
                if ($collumn) {
                    $collumn->order = $order;
                    $collumn->save();
                }
            }
            return true;
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
