<?php

namespace App\DTO;

class FcMenuTypeDTO {
    public function __construct(
        public readonly string $fc_menu_type_name,
        public readonly ?int $fc_menu_type_sort,
        public readonly ?string $fc_menu_type_group
    ) {}
}
