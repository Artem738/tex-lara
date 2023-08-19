<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tone extends Model
{
    protected $fillable = ['name'];
    public function products()
    {
        return $this->belongsToMany(Product::class, 'tone_product');
    }
}
