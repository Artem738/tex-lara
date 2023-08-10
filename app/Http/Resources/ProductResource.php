<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'goodUrl' => $this->good_url,
            'name' => $this->name,
            'price' => $this->price,
            'country' => $this->country->name,
            'categories' => $this->categories->pluck('name'),
            'purpose' => $this->purposes->pluck('name'),
            // Добавьте другие поля, которые вы хотите включить в JSON
        ];
    }
}
