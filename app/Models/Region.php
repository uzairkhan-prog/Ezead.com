<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;

    public function childs()
    {
        return $this->hasMany(Region::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->hasMany(Country::class, 'id', 'parent_id');
    }
}
