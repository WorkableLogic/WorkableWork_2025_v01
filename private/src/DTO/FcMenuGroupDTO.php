<?php

declare(strict_types=1);

namespace App\DTO;

class FcMenuGroupDTO
{
    public string $fc_menu_group_name;
    public ?int $fc_menu_group_sort;
    public string $fc_menu_group_cat;

    public function __construct(
        string $fc_menu_group_name,
        ?int $fc_menu_group_sort,
        string $fc_menu_group_cat
    ) {
        $this->fc_menu_group_name = $fc_menu_group_name;
        $this->fc_menu_group_sort = $fc_menu_group_sort;
        $this->fc_menu_group_cat = $fc_menu_group_cat;
    }
}
