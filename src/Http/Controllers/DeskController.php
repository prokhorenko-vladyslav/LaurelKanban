<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Requests\DeskShow;
use Laurel\Kanban\Http\Requests\DeskIndex;
use Laurel\Kanban\Http\Requests\DeskStore;
use Laurel\Kanban\Http\Requests\DeskUpdate;
use Laurel\Kanban\Http\Requests\DeskDestroy;
use Laurel\Kanban\Http\Requests\DeskSetFavorite;
use Laurel\Kanban\Http\Requests\DeskSetPrivate;
use Laurel\Kanban\Http\Resources\DeskResource;
use Laurel\Kanban\Http\Resources\DeskCollection;
use Laurel\Kanban\Models\Desk;
use Laurel\Kanban\Kanban;

class DeskController extends Controller
{
    public function index(DeskIndex $request)
    {
        return DeskResource::collection(Desk::paginate(config('laurel_kanban.desk.page_count')));
    }

    public function show(DeskShow $request, $deskId)
    {
        try {
            return new DeskResource(Desk::findOrFail($deskId)->load('collumns'));
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function store(DeskStore $request)
    {
        $desk = new Desk;
        $desk->fill($request->validated());
        $desk->user_id = 1;
        return (bool)$desk->save();
    }

    public function update(DeskUpdate $request, int $deskId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $desk->fill($request->validated());
            $desk->user_id = 1;
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function destroy(DeskDestroy $request, int $deskId)
    {
        return (bool)Desk::findOrFail($deskId)->delete();
    }

    public function favorite(DeskSetFavorite $request, int $deskId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $desk->favorite();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function unfavorite(DeskSetFavorite $request, int $deskId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $desk->unfavorite();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function private(DeskSetPrivate $request, int $deskId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $desk->private();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function public(DeskSetPrivate $request, int $deskId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $desk->public();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
