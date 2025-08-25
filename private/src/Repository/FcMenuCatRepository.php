<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcMenuCatDTO;
use PDO;

class FcMenuCatRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT fc_menu_cat_name, fc_menu_cat_sort FROM fc_menu_cat ORDER BY fc_menu_cat_sort, fc_menu_cat_name");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $cats = [];
        foreach ($results as $row) {
            $cats[] = new FcMenuCatDTO(
                fc_menu_cat_name: $row['fc_menu_cat_name'],
                fc_menu_cat_sort: $row['fc_menu_cat_sort']
            );
        }
        return $cats;
    }

    public function findByName(string $name): ?FcMenuCatDTO {
        $stmt = $this->db->prepare("SELECT fc_menu_cat_name, fc_menu_cat_sort FROM fc_menu_cat WHERE fc_menu_cat_name = :name");
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new FcMenuCatDTO(
            fc_menu_cat_name: $row['fc_menu_cat_name'],
            fc_menu_cat_sort: $row['fc_menu_cat_sort']
        );
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO fc_menu_cat (fc_menu_cat_name, fc_menu_cat_sort) VALUES (:fc_menu_cat_name, :fc_menu_cat_sort)");
        return $stmt->execute([
            'fc_menu_cat_name' => $data['fc_menu_cat_name'],
            'fc_menu_cat_sort' => $data['fc_menu_cat_sort']
        ]);
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("UPDATE fc_menu_cat SET fc_menu_cat_sort = :fc_menu_cat_sort WHERE fc_menu_cat_name = :fc_menu_cat_name");
        return $stmt->execute([
            'fc_menu_cat_sort' => $data['fc_menu_cat_sort'],
            'fc_menu_cat_name' => $data['fc_menu_cat_name']
        ]);
    }

    public function delete(string $name): bool {
        $stmt = $this->db->prepare("DELETE FROM fc_menu_cat WHERE fc_menu_cat_name = :name");
        return $stmt->execute(['name' => $name]);
    }
}
