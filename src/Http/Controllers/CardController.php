<?php

namespace Laurel\Kanban\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laurel\Kanban\Http\Requests\CardShow;
use Laurel\Kanban\Http\Requests\CardIndex;
use Laurel\Kanban\Http\Requests\CardStore;
use Laurel\Kanban\Http\Requests\CardUpdate;
use Laurel\Kanban\Http\Requests\CardDestroy;
use Laurel\Kanban\Http\Resources\CardResource;
use Laurel\Kanban\Http\Resources\CardShortResource;
use Laurel\Kanban\Models\Desk;
use Laurel\Kanban\Models\Card;

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

    public function store(CardStore $request, int $deskId)
    {
        try {
            $collumn = Desk::findOrFail($deskId)->collumns()->findOrFail($request->validated()['collumn_id']);
            $card = new Card;
            $card->fill($request->validated());
            $card->collumn()->associate($collumn);
            $card->user()->associate(Auth::user());
            return (bool)$card->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function update(CardUpdate $request, int $deskId, $cardId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $card = $desk->cards()->findOrFail($deskId);
            $card->fill($request->validated());
            if (isset($request->validated()['collumn_id'])) {
                $collumn = Desk::findOrFail($deskId)->collumns()->findOrFail($request->validated()['collumn_id']);
                $card->collumn()->associate($collumn);
            }
            $card->user()->associate(Auth::user());
            return (bool)$card->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function destroy(CardDestroy $request, int $deskId, $cardId)
    {
        try {
            $desk = Desk::findOrFail($deskId);
            $card = $desk->cards()->findOrFail($deskId);
            return (bool)$card->delete();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
