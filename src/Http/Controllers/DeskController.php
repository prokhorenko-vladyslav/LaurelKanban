<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Requests\DeskShow;
use Laurel\Kanban\Http\Requests\DeskIndex;
use Laurel\Kanban\Http\Requests\DeskStore;
use Laurel\Kanban\Http\Requests\DeskUpdate;
use Laurel\Kanban\Http\Requests\DeskDestroy;
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

    public function update(DeskUpdate $request, Desk $desk)
    {
        $desk->fill($request->validated());
        $desk->user_id = 1;
        return (bool)$desk->save();
    }

    public function destroy(DeskDestroy $request, $deskId)
    {
        return (bool)Desk::findOrFail($deskId)->delete();
    }
}
