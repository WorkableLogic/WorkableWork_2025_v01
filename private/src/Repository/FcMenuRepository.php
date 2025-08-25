<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcMenuDTO;
use PDO;

class FcMenuRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getFullMenuList(array $filters = []): array {
        $sql = "
            SELECT 
                m.fc_menu_id,
                m.fc_menu_name,
                m.fc_menu_price,
                p.fc_menu_page_name,
                t.fc_menu_type_name,
                g.fc_menu_group_name,
                c.fc_menu_cat_name
            FROM 
                fc_menu m
            LEFT JOIN 
                fc_menu_page p ON m.fc_menu_page = p.fc_menu_page_name
            LEFT JOIN 
                fc_menu_type t ON m.fc_menu_type = t.fc_menu_type_name
            LEFT JOIN 
                fc_menu_group g ON t.fc_menu_type_group = g.fc_menu_group_name
            LEFT JOIN 
                fc_menu_cat c ON g.fc_menu_group_cat = c.fc_menu_cat_name
        ";

        $whereClauses = [];
        $params = [];

        if (!empty($filters['fc_menu_cat_name']) && $filters['fc_menu_cat_name'] !== 'All') {
            $whereClauses[] = "c.fc_menu_cat_name = :cat_name";
            $params['cat_name'] = $filters['fc_menu_cat_name'];
        }
        if (!empty($filters['fc_menu_group_name']) && $filters['fc_menu_group_name'] !== 'All') {
            $whereClauses[] = "g.fc_menu_group_name = :group_name";
            $params['group_name'] = $filters['fc_menu_group_name'];
        }
        if (!empty($filters['fc_menu_type_name']) && $filters['fc_menu_type_name'] !== 'All') {
            $whereClauses[] = "t.fc_menu_type_name = :type_name";
            $params['type_name'] = $filters['fc_menu_type_name'];
        }
        if (!empty($filters['fc_menu_page']) && $filters['fc_menu_page'] !== 'All') {
            $whereClauses[] = "p.fc_menu_page_name = :page_name";
            $params['page_name'] = $filters['fc_menu_page'];
        }
        if (!empty($filters['fc_menu_name'])) {
            $whereClauses[] = "m.fc_menu_name LIKE :menu_name";
            $params['menu_name'] = '%' . $filters['fc_menu_name'] . '%';
        }

        if (!empty($whereClauses)) {
            $sql .= " WHERE " . implode(" AND ", $whereClauses);
        }

        $sql .= "
            ORDER BY
                c.fc_menu_cat_sort,
                c.fc_menu_cat_name,
                g.fc_menu_group_sort,
                g.fc_menu_group_name,
                t.fc_menu_type_sort,
                t.fc_menu_type_name,
                m.fc_menu_name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $menuDTOs = [];
        foreach ($results as $row) {
            $menuDTOs[] = new FcMenuDTO(
                id: $row['fc_menu_id'],
                name: $row['fc_menu_name'],
                price: $row['fc_menu_price'],
                pageName: $row['fc_menu_page_name'],
                typeName: $row['fc_menu_type_name'],
                groupName: $row['fc_menu_group_name'],
                catName: $row['fc_menu_cat_name']
            );
        }

        return $menuDTOs;
    }

    public function findById(int $id): ?FcMenuDTO {
        $sql = "
            SELECT 
                m.fc_menu_id,
                m.fc_menu_name,
                m.fc_menu_price,
                m.fc_menu_page,
                m.fc_menu_type,
                g.fc_menu_group_name,
                c.fc_menu_cat_name
            FROM 
                fc_menu m
            LEFT JOIN 
                fc_menu_page p ON m.fc_menu_page = p.fc_menu_page_name
            LEFT JOIN 
                fc_menu_type t ON m.fc_menu_type = t.fc_menu_type_name
            LEFT JOIN 
                fc_menu_group g ON t.fc_menu_type_group = g.fc_menu_group_name
            LEFT JOIN 
                fc_menu_cat c ON g.fc_menu_group_cat = c.fc_menu_cat_name
            WHERE m.fc_menu_id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new FcMenuDTO(
            id: $row['fc_menu_id'],
            name: $row['fc_menu_name'],
            price: $row['fc_menu_price'],
            pageName: $row['fc_menu_page'],
            typeName: $row['fc_menu_type'],
            groupName: $row['fc_menu_group_name'],
            catName: $row['fc_menu_cat_name']
        );
    }

    public function update(FcMenuDTO $menuItem): bool {
        $sql = "
            UPDATE fc_menu
            SET
                fc_menu_name = :name,
                fc_menu_price = :price,
                fc_menu_page = :pageName,
                fc_menu_type = :typeName
            WHERE
                fc_menu_id = :id
        ";

        $stmt = $this->db->prepare($sql);

        return $stmt->execute([
            'id' => $menuItem->id,
            'name' => $menuItem->name,
            'price' => $menuItem->price,
            'pageName' => $menuItem->pageName,
            'typeName' => $menuItem->typeName
        ]);
    }

    public function create(FcMenuDTO $menuItem): int {
        $sql = "
            INSERT INTO fc_menu (fc_menu_name, fc_menu_price, fc_menu_page, fc_menu_type)
            VALUES (:name, :price, :page, :type)
        ";

        $stmt = $this->db->prepare($sql);

        $stmt->execute([
            'name' => $menuItem->name,
            'price' => $menuItem->price,
            'page' => $menuItem->pageName,
            'type' => $menuItem->typeName
        ]);

        return (int)$this->db->lastInsertId();
    }

    public function delete(int $id): bool {
        $sql = "DELETE FROM fc_menu WHERE fc_menu_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
