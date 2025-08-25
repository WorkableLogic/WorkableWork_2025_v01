<?php

namespace App\DTO;

class LocentDTO {
    public function __construct(
        public readonly ?int $id,
        public readonly string $code,
        public readonly string $name,
        public readonly bool $flag,
        public readonly int $sort,
        public readonly string $page
    ) {}
}
