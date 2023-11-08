<?php

namespace App\Http\VO;

class ProductIndexVO
{
    protected ?int $startId;

    public function __construct(
        protected ?int    $category,
        protected ?int    $fabric,
        protected ?int    $tone,
        protected ?int    $pattern,
        protected ?int    $countryId,
        protected ?int    $purpose,
        protected ?int    $lastId,
        protected ?string $prodStatus,
    ) {
        $this->startId = $this->lastId;
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['category'] ?? null,
            $data['fabric'] ?? null,
            $data['tone'] ?? null,
            $data['pattern'] ?? null,
            $data['country_id'] ?? null,
            $data['purpose'] ?? null,
            $data['lastId'] ?? null,
            $data['prod_status'] ?? null
        );
    }

    /**
     * @return int|null
     */
    public function getStartId(): ?int
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
        return $this->countryId;
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
        return $this->prodStatus;
    }

}
