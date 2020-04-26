<?php

namespace Laurel\Kanban\App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $fillable = ['name', 'description', 'order'];

    public function desk()
    {
        return $this->belongsTo(Desk::class);
    }

    public function collumn()
    {
        return $this->belongsTo(Card::class);
    }

    public function user()
    {
        return $this->belongsTo(config('laurel_kanban.user_class'), 'user_id');
    }
}
