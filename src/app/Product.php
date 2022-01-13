<?php

namespace App;

use App\Category;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'price', 'eid', 'title'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
