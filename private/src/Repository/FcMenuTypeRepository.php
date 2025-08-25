<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcMenuTypeDTO;
use PDO;

class FcMenuTypeRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT fc_menu_type_name, fc_menu_type_sort, fc_menu_type_group FROM fc_menu_type ORDER BY fc_menu_type_group, fc_menu_type_sort, fc_menu_type_name");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $types = [];
        foreach ($results as $row) {
            $types[] = new FcMenuTypeDTO(
                fc_menu_type_name: $row['fc_menu_type_name'],
                fc_menu_type_sort: $row['fc_menu_type_sort'],
                fc_menu_type_group: $row['fc_menu_type_group']
            );
        }
        return $types;
    }

    public function findByName(string $name): ?FcMenuTypeDTO {
        $stmt = $this->db->prepare("SELECT fc_menu_type_name, fc_menu_type_sort, fc_menu_type_group FROM fc_menu_type WHERE fc_menu_type_name = :name");
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new FcMenuTypeDTO(
            fc_menu_type_name: $row['fc_menu_type_name'],
            fc_menu_type_sort: $row['fc_menu_type_sort'],
            fc_menu_type_group: $row['fc_menu_type_group']
        );
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO fc_menu_type (fc_menu_type_name, fc_menu_type_sort, fc_menu_type_group) VALUES (:fc_menu_type_name, :fc_menu_type_sort, :fc_menu_type_group)");
        return $stmt->execute([
            'fc_menu_type_name' => $data['fc_menu_type_name'],
            'fc_menu_type_sort' => $data['fc_menu_type_sort'],
            'fc_menu_type_group' => $data['fc_menu_type_group']
        ]);
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("UPDATE fc_menu_type SET fc_menu_type_sort = :fc_menu_type_sort, fc_menu_type_group = :fc_menu_type_group WHERE fc_menu_type_name = :fc_menu_type_name");
        return $stmt->execute([
            'fc_menu_type_sort' => $data['fc_menu_type_sort'],
            'fc_menu_type_group' => $data['fc_menu_type_group'],
            'fc_menu_type_name' => $data['fc_menu_type_name']
        ]);
    }

    public function delete(string $name): bool {
        $stmt = $this->db->prepare("DELETE FROM fc_menu_type WHERE fc_menu_type_name = :name");
        return $stmt->execute(['name' => $name]);
    }
}
