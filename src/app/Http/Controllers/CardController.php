<?php

namespace Laurel\Kanban\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Laurel\Kanban\App\Http\Requests\Card\Show;
use Laurel\Kanban\App\Http\Requests\Card\Index;
use Laurel\Kanban\App\Http\Requests\Card\Store;
use Laurel\Kanban\App\Http\Requests\Card\Update;
use Laurel\Kanban\App\Http\Requests\Card\Destroy;
use Laurel\Kanban\App\Http\Requests\Card\Reorder;
use Laurel\Kanban\App\Http\Resources\Card\Resource;
use Laurel\Kanban\App\Http\Resources\Card\ShortResource;
use Laurel\Kanban\App\Kanban;
use Laurel\Kanban\App\Models\Card;

class CardController extends Controller
{
    public function index(Index $request, int $deskId)
    {
        try {
            $cards = Kanban::getUserDesks()->findOrFail($deskId)->cards()->get();
        } catch (\Exception $e) {
            $cards = [];
        }
        return CardShortResource::collection($cards);
    }

    public function show(Show $request, int $deskId, int $cardId)
    {
        try {
            return new CardResource(
                Kanban::getUserDesks()->findOrFail($deskId)->cards()->findOrFail($cardId)
            );
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function store(Store $request, int $deskId)
    {
        try {
            $collumn = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->findOrFail($request->validated()['collumn_id']);
            $card = new Card;
            $card->fill($request->validated());
            $card->collumn()->associate($collumn);
            $card->user()->associate(Auth::user());
            return response([
                'status' => $card->save()
            ]);
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function update(Update $request, int $deskId, $cardId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $card = $desk->cards()->findOrFail($deskId);
            $card->fill($request->validated());
            if (isset($request->validated()['collumn_id'])) {
                $collumn = $desk->collumns()->findOrFail($request->validated()['collumn_id']);
                $card->collumn()->associate($collumn);
            }
            $card->user()->associate(Auth::user());
            return (bool)$card->save();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function destroy(Destroy $request, int $deskId, $cardId)
    {
        try {
            $desk = Kanban::getUserDesks()->findOrFail($deskId);
            $card = $desk->cards()->findOrFail($deskId);
            return (bool)$card->delete();
        } catch (\Exception $e) {
            return response('', 404);
        }
    }

    public function reorder(Reorder $request, int $deskId, int $collumnId)
    {
        try {
            $collumn = Kanban::getUserDesks()->findOrFail($deskId)->collumns()->findOrFail($collumnId);
            foreach ($request->validated()['order'] as $cardId => $order) {
                $card = $collumn->cards()->find($cardId);
                if ($card) {
                    $card->order = $order;
                    $card->save();
                }
            }
            return true;
        } catch (\Exception $e) {
            return response('', 404);
        }
    }
}
