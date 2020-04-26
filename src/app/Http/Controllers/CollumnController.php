<?php

namespace Laurel\Kanban\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laurel\Kanban\App\Http\Requests\Collumn\Index;
use Laurel\Kanban\App\Http\Requests\Collumn\Store;
use Laurel\Kanban\App\Http\Requests\Collumn\Update;
use Laurel\Kanban\App\Http\Requests\Collumn\Destroy;
use Laurel\Kanban\App\Http\Requests\Collumn\Reorder;
use Laurel\Kanban\App\Http\Requests\Collumn\Show;
use Laurel\Kanban\App\Http\Resources\CollumnResource;
use Laurel\Kanban\App\Models\Collumn;
use Laurel\Kanban\App\Kanban;

class CollumnController extends Controller
{
    public function index(Index $request, int $deskId)
    {
        try {
            $collumns = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->with('cards')->get();
        } catch (\Exception $e) {
            $collumns = [];
        }
        return CollumnResource::collection($collumns);
    }

    public function show(Show $request, int $deskId, int $collumnId)
    {
        try {
            return new CollumnResource(
                Kanban::getUserDesks()->findOrFail($deskId)->collumns()->with('cards')->findOrFail($deskId)
            );
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function store(Store $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $collumn = new Collumn;
            $collumn->fill($request->validated());
            $collumn->desk()->associate($desk);
            return response([
                'status' => (bool)$collumn->save(),
                'data' => [
                    'id' => $collumn->id
                ]
            ]);
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function update(Update $request, int $deskId, int $collumnId)
    {
        try {
            $collumn = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->findOrFail($collumnId);
            $collumn->fill($request->validated());
            return response([
                'status' => (bool)$collumn->save()
            ]);
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function destroy(Destroy $request, int $deskId, int $collumnId)
    {
        try {
            $collumn = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->findOrFail($collumnId);
            $collumn->cards()->delete();
            return (bool)$collumn->delete();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function reorder(Reorder $request, int $deskId)
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
            return response([
                'status' => true
            ]);
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
