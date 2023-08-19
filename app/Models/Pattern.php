<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pattern extends Model
{
    use HasFactory;
    protected $fillable = ['name'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'pattern_product');
    }
}
