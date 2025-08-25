<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcMenuGroupDTO;
use PDO;

class FcMenuGroupRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT fc_menu_group_name, fc_menu_group_sort, fc_menu_group_cat FROM fc_menu_group ORDER BY fc_menu_group_cat, fc_menu_group_sort, fc_menu_group_name");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $groups = [];
        foreach ($results as $row) {
            $groups[] = new FcMenuGroupDTO(
                fc_menu_group_name: $row['fc_menu_group_name'],
                fc_menu_group_sort: $row['fc_menu_group_sort'],
                fc_menu_group_cat: $row['fc_menu_group_cat']
            );
        }
        return $groups;
    }

    public function findByName(string $name): ?FcMenuGroupDTO {
        $stmt = $this->db->prepare("SELECT fc_menu_group_name, fc_menu_group_sort, fc_menu_group_cat FROM fc_menu_group WHERE fc_menu_group_name = :name");
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new FcMenuGroupDTO(
            fc_menu_group_name: $row['fc_menu_group_name'],
            fc_menu_group_sort: $row['fc_menu_group_sort'],
            fc_menu_group_cat: $row['fc_menu_group_cat']
        );
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO fc_menu_group (fc_menu_group_name, fc_menu_group_sort, fc_menu_group_cat) VALUES (:fc_menu_group_name, :fc_menu_group_sort, :fc_menu_group_cat)");
        return $stmt->execute([
            'fc_menu_group_name' => $data['fc_menu_group_name'],
            'fc_menu_group_sort' => $data['fc_menu_group_sort'],
            'fc_menu_group_cat' => $data['fc_menu_group_cat']
        ]);
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("UPDATE fc_menu_group SET fc_menu_group_sort = :fc_menu_group_sort, fc_menu_group_cat = :fc_menu_group_cat WHERE fc_menu_group_name = :fc_menu_group_name");
        return $stmt->execute([
            'fc_menu_group_sort' => $data['fc_menu_group_sort'],
            'fc_menu_group_cat' => $data['fc_menu_group_cat'],
            'fc_menu_group_name' => $data['fc_menu_group_name']
        ]);
    }

    public function delete(string $name): bool {
        $stmt = $this->db->prepare("DELETE FROM fc_menu_group WHERE fc_menu_group_name = :name");
        return $stmt->execute(['name' => $name]);
    }
}
