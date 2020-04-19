<?php

namespace Laurel\Kanban\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Desk extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'description', 'is_favorite', 'is_private'];

    public function collumns()
    {
        return $this->hasMany(Collumn::class);
    }

    public function cards()
    {
        return $this->hasMany(Card::class);
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
}
