<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Requests\CardShow;
use Laurel\Kanban\Http\Requests\CardIndex;
use Laurel\Kanban\Http\Resources\CardResource;
use Laurel\Kanban\Http\Resources\CardShortResource;
use Laurel\Kanban\Models\Desk;

class CardController extends Controller
{
    public function index(CardIndex $request, int $deskId)
    {
        try {
            $cards = Desk::findOrFail($deskId)->cards()->get();
        } catch (\Exception $e) {
            $cards = [];
        }
        return CardShortResource::collection($cards);
    }

    public function show(CardShow $request, int $deskId, int $cardId)
    {
        try {
            return new CardResource(
                Desk::findOrFail($deskId)->cards()->findOrFail($cardId)
            );
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
