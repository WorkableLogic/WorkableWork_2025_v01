<?php

namespace App\DTO;

class FcMenuDTO {
    public function __construct(
        public ?int $id,
        public string $name,
        public float $price,
        public string $pageName,
        public string $typeName,
        public string $groupName,
        public string $catName
    ) {}

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'pageName' => $this->pageName,
            'typeName' => $this->typeName,
            'groupName' => $this->groupName,
            'catName' => $this->catName,
        ];
    }
}
