<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
        'parent_id'
    ];
    public function children()
    {
        return $this->hasMany('App\Models\Section', 'parent', 'id');
    }

    public function parent()
    {
        return $this->hasOne('App\Models\Section', 'id', 'parent');
    }
}
