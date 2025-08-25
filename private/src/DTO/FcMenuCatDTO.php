<?php

namespace App\DTO;

class FcMenuCatDTO {
    public function __construct(
        public readonly string $fc_menu_cat_name,
        public readonly ?int $fc_menu_cat_sort
    ) {}
}
