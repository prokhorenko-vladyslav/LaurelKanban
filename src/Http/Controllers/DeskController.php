<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Requests\DeskShow;
use Laurel\Kanban\Http\Requests\DeskIndex;
use Laurel\Kanban\Models\Desk;

class DeskController extends Controller
{
    public function index(DeskIndex $request)
    {
        return Desk::paginate(config('laurel_kanban.desk.page_count'));
    }

    public function show(DeskShow $request, $deskId)
    {
    }
}
