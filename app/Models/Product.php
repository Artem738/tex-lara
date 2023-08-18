<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $sku
 * @property string $title
 * @property string $goodUrl
 * @property string|null $description
 * @property string|null $categoryAll
 * @property string|null $purpose
 * @property string|null $rollWidth
 * @property string|null $rollWidthCategory
 * @property string|null $density
 * @property string|null $fabricTone
 * @property string|null $patternType
 * @property string|null $fabricStructure
 * @property float|null $price
 * @property float|null $regularPrice
 * @property float|null $salePrice
 * @property string|null $imgUrl
 * @property string|null $allImgUrl
 * @property string|null $optDiscount
 * @property string|null $saleDiscount
 * @property string|null $cutDiscount
 * @property string|null $rollDiscount
 * @property string|null $prodStatus
 * @property string|null $similarProducts
 * @method static findOrFail($id)
 */
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function purposes()
    {
        return $this->belongsToMany(Purpose::class, 'purpose_product');
    }

    public function fabrics()
    {
        return $this->belongsToMany(Fabric::class, 'fabric_product');
    }
    public function tones()
    {
        return $this->belongsToMany(Tone::class, 'tone_product');
    }
    public function patterns()
    {
        return $this->belongsToMany(Pattern::class, 'pattern_product');
    }

}
