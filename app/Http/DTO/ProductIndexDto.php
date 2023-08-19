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
        protected ?string $prod_status,
    ) {
        $this->startId = $this->lastId;
    }

    /**
     * @return int
     */
    public function getStartId(): int
    {
        return $this->startId;
    }

    /**
     * @return int|null
     */
    public function getCategory(): ?int
    {
        return $this->category;
    }

    /**
     * @return int|null
     */
    public function getFabric(): ?int
    {
        return $this->fabric;
    }

    /**
     * @return int|null
     */
    public function getTone(): ?int
    {
        return $this->tone;
    }

    /**
     * @return int|null
     */
    public function getPattern(): ?int
    {
        return $this->pattern;
    }

    /**
     * @return int|null
     */
    public function getCountryId(): ?int
    {
        return $this->country_id;
    }

    /**
     * @return int|null
     */
    public function getPurpose(): ?int
    {
        return $this->purpose;
    }

    /**
     * @return int|null
     */
    public function getLastId(): ?int
    {
        return $this->lastId;
    }

    /**
     * @return string|null
     */
    public function getProdStatus(): ?string
    {
        return $this->prod_status;
    }

}
