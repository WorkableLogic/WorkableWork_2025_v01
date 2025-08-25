<?php

namespace App\DTO;

class FcMenuPageDTO {
    public function __construct(
        public readonly string $fc_menu_page_name,
        public readonly ?int $fc_menu_page_sort
    ) {}
}
