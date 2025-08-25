<?php

namespace App\DTO;

class FcMapDTO {
    public function __construct(
        public readonly ?int $fc_map_id,
        public readonly ?string $menuType,
        public readonly int $fc_map_menu,
        public readonly string $menuName,
        public readonly int $fc_map_comm,
        public readonly string $commName,
        public readonly float $fc_map_amount,
        public readonly ?string $commUom,
        public readonly ?float $commCostUom,
        public readonly ?float $mapCostExtend
    ) {}
}
