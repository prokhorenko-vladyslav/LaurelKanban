<?php

namespace Laurel\Kanban\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Collumn extends Model
{
    protected $fillable = ['name', 'order'];
    protected $with = ['cards'];

    public function desk()
    {
        return $this->belongsTo(Desk::class);
    }

    public function cards() : HasMany
    {
        return $this->hasMany(Card::class)->orderBy('order');
    }

    public function user()
    {
        return $this->belongsTo(config('laurel_kanban.user_class'), 'user_id');
    }
}
