<?php

namespace App;

use App\Product;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = [
        'eid' , 'title'
    ];  

    public function products()
    {
        return $this->belongsToMany(Product::class);
    } 
}
