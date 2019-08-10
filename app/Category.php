<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at'
    ];

    public function articles() {
        return $this->hasMany(Article::class);
    }
}
