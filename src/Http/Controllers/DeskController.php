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
use Laurel\Kanban\Models\Desk;

class DeskController extends Controller
{
    public function index(DeskIndex $request)
    {
        return Desk::paginate(config('laurel_kanban.desk.page_count'));
    }

    public function show(DeskShow $request, $deskId)
    {
        return Desk::findOrFail($deskId);
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

    public function private(DeskSetFavorite $request, int $deskId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $desk->private();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
