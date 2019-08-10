<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{

    protected $with = ['category'];

    protected $fillable = [
        'id',
        'register_number',
        'name',
        'quantity',
        'category_id',
        'created_at',
        'updated_at'
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function setNameAttribute($value) {
        $this->attributes['name'] = strtolower($value);
    }

    public function getNameAttribute($value) {
        return ucwords($value);
    }

}
