<?php

namespace App\Http\DTO;

class ProductIndexDto
{
    protected ?int $startId;

    public function __construct(

        protected ?int $category,
        protected ?int $fabric,
        protected ?int $tone,
        protected ?int $pattern,
        protected ?int $country_id,
        protected ?int $purpose,
        protected ?int $lastId,
    ) {
        $this->startId = $this->lastId;
    }

}
