<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcMenuPageDTO;
use PDO;

class FcMenuPageRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT fc_menu_page_name, fc_menu_page_sort FROM fc_menu_page ORDER BY fc_menu_page_sort, fc_menu_page_name");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $pages = [];
        foreach ($results as $row) {
            $pages[] = new FcMenuPageDTO(
                fc_menu_page_name: $row['fc_menu_page_name'],
                fc_menu_page_sort: $row['fc_menu_page_sort']
            );
        }
        return $pages;
    }

    public function findByName(string $name): ?FcMenuPageDTO {
        $stmt = $this->db->prepare("SELECT fc_menu_page_name, fc_menu_page_sort FROM fc_menu_page WHERE fc_menu_page_name = :name");
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        return new FcMenuPageDTO(
            fc_menu_page_name: $row['fc_menu_page_name'],
            fc_menu_page_sort: $row['fc_menu_page_sort']
        );
    }

    public function create(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO fc_menu_page (fc_menu_page_name, fc_menu_page_sort) VALUES (:fc_menu_page_name, :fc_menu_page_sort)");
        return $stmt->execute([
            'fc_menu_page_name' => $data['fc_menu_page_name'],
            'fc_menu_page_sort' => $data['fc_menu_page_sort']
        ]);
    }

    public function update(array $data): bool {
        $stmt = $this->db->prepare("UPDATE fc_menu_page SET fc_menu_page_sort = :fc_menu_page_sort WHERE fc_menu_page_name = :fc_menu_page_name");
        return $stmt->execute([
            'fc_menu_page_sort' => $data['fc_menu_page_sort'],
            'fc_menu_page_name' => $data['fc_menu_page_name']
        ]);
    }

    public function delete(string $name): bool {
        $stmt = $this->db->prepare("DELETE FROM fc_menu_page WHERE fc_menu_page_name = :name");
        return $stmt->execute(['name' => $name]);
    }
}
