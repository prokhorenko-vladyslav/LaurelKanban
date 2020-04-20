<?php

namespace Laurel\Kanban\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laurel\Kanban\App\Http\Requests\Desk\Show;
use Laurel\Kanban\App\Http\Requests\Desk\Index;
use Laurel\Kanban\App\Http\Requests\Desk\Store;
use Laurel\Kanban\App\Http\Requests\Desk\Update;
use Laurel\Kanban\App\Http\Requests\Desk\Destroy;
use Laurel\Kanban\App\Http\Requests\Desk\SetFavorite;
use Laurel\Kanban\App\Http\Requests\Desk\SetPrivate;
use Laurel\Kanban\App\Http\Resources\DeskResource;
use Laurel\Kanban\App\Models\Desk;
use Laurel\Kanban\App\Kanban;

class DeskController extends Controller
{
    public function index(DeskIndex $request)
    {
        return DeskResource::collection(Kanban::getUserDesks()->paginate(config('laurel_kanban.desk.page_count')));
    }

    public function show(DeskShow $request, $deskId)
    {
        try {
            return new DeskResource(Kanban::getUserDesks()->findOrFail($deskId)->load('collumns'));
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function store(DeskStore $request)
    {
        $desk = new Desk;
        $desk->fill($request->validated());
        $desk->user()->associate(Auth::user());
        return (bool)$desk->save();
    }

    public function update(DeskUpdate $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $desk->fill($request->validated());
            $desk->user_id = 1;
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function destroy(DeskDestroy $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $desk->collumns()->each(function ($collumn) {
                $collumn->cards()->delete();
                $collumn->delete();
            });
            return (bool)$desk->delete();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function favorite(DeskSetFavorite $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $desk->favorite();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function unfavorite(DeskSetFavorite $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $desk->unfavorite();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function private(DeskSetPrivate $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $desk->private();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function public(DeskSetPrivate $request, int $deskId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $desk->public();
            return (bool)$desk->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
