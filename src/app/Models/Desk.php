<?php

namespace Laurel\Kanban\App\Models;

use Illuminate\Database\Eloquent\Model;

class Desk extends Model
{
    protected $fillable = ['name', 'description', 'is_favorite', 'is_private'];

    public function collumns()
    {
        return $this->hasMany(Collumn::class)->orderBy('order');
    }

    public function cards()
    {
        return $this->hasManyThrough(Card::class, Collumn::class)->orderBy('order');
    }

    public function user()
    {
        return $this->belongsTo(config('laurel_kanban.user_class'), 'user_id');
    }

    public function favorite()
    {
        $this->is_favorite = true;
        return $this;
    }

    public function unfavorite()
    {
        $this->is_favorite = false;
        return $this;
    }

    public function private()
    {
        $this->is_private = true;
        return $this;
    }

    public function public()
    {
        $this->is_private = false;
        return $this;
    }
}
