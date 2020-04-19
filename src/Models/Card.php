<?php

namespace Laurel\Kanban\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Card extends Model
{
    protected $fillable = ['name', 'description', 'order'];

    public function desk()
    {
        return $this->newHasOneThrough(Desk::class, Collumn::class);
    }

    public function collumn()
    {
        return $this->belongsTo(Card::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
