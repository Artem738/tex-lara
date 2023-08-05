<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = [
        'r',
        'sku',
        'title',
        'goodUrl',
        'description',
        'categoryAll',
        'purpose',
        'rollWidth',
        'density',
        'madeIn',
        'fabricTone',
        'patternType',
        'fabricStructure',
        'price',
        'regularPrice',
        'salePrice',
        'imgUrl',
        'allImgUrl',
        'optDiscount',
        'saleDiscount',
        'cutDiscount',
        'rollDiscount',
        'prodStatus'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }

}