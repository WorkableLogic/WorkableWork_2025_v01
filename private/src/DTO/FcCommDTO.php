<?php

namespace App\DTO;

class FcCommDTO {
    public function __construct(
        public ?int $id,
        public ?string $code,
        public string $name,
        public ?string $type,
        public ?string $supplier,
        public float $costNet,
        public float $taxPerc,
        public float $costGross,
        public ?string $invoiceSize,
        public ?string $packDescribe,
        public ?float $convert,
        public string $uom
    ) {}
}
