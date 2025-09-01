<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcMapDTO;
use PDO;

class FcMapRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByCriteria(array $criteria): array
    {
        $sql = "SELECT 
                    m.fc_map_id,
                    mn.fc_menu_type,
                    m.fc_map_menu,
                    mn.fc_menu_name,
                    m.fc_map_comm, 
                    c.fc_comm_name,
                    m.fc_map_amount, 
                    c.fc_comm_uom,
                    round(c.fc_comm_cost_gross / c.fc_comm_convert, 2) as fc_comm_cost_uom,
                    round(c.fc_comm_cost_gross / c.fc_comm_convert * m.fc_map_amount, 2) as fc_map_cost_extend
                FROM fc_map m
                JOIN fc_menu mn ON m.fc_map_menu = mn.fc_menu_id 
                JOIN fc_comm c ON m.fc_map_comm = c.fc_comm_id
                WHERE 1=1";
        
        $params = [];

        if (!empty($criteria['fc_menu_type']) && $criteria['fc_menu_type'] !== 'All') {
            $sql .= " AND mn.fc_menu_type = :menu_type";
            $params[':menu_type'] = $criteria['fc_menu_type'];
        }

        if (!empty($criteria['fc_menu_name'])) {
            $sql .= " AND mn.fc_menu_name LIKE :menu_name";
            $params[':menu_name'] = '%' . $criteria['fc_menu_name'] . '%';
        }

        if (!empty($criteria['fc_comm_name'])) {
            $sql .= " AND c.fc_comm_name LIKE :comm_name";
            $params[':comm_name'] = '%' . $criteria['fc_comm_name'] . '%';
        }

        $sql .= " ORDER BY mn.fc_menu_type, mn.fc_menu_name, c.fc_comm_name";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = new FcMapDTO(
                $row['fc_map_id'],
                $row['fc_menu_type'],
                $row['fc_map_menu'],
                $row['fc_menu_name'],
                $row['fc_map_comm'],
                $row['fc_comm_name'],
                $row['fc_map_amount'],
                $row['fc_comm_uom'],
                $row['fc_comm_cost_uom'],
                $row['fc_map_cost_extend']
            );
        }
        return $results;
    }

    public function findIngredientsByMenuId(int $menuId): array {
        $sql = "
            SELECT 
                m.fc_map_id as id,
                c.fc_comm_name as commodity_name,
                m.fc_map_amount as amount,
                c.fc_comm_uom as uom,
                ROUND(c.fc_comm_cost_gross / c.fc_comm_convert, 2) as cost_per_uom
            FROM 
                fc_map m
            JOIN 
                fc_comm c ON m.fc_map_comm = c.fc_comm_id
            WHERE 
                m.fc_map_menu = :menu_id
            ORDER BY
                c.fc_comm_name
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':menu_id' => $menuId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findById(int $id): ?FcMapDTO {
        $sql = "SELECT 
                    m.fc_map_id,
                    mn.fc_menu_type,
                    m.fc_map_menu,
                    mn.fc_menu_name,
                    m.fc_map_comm, 
                    c.fc_comm_name,
                    m.fc_map_amount, 
                    c.fc_comm_uom,
                    round(c.fc_comm_cost_gross / c.fc_comm_convert, 2) as fc_comm_cost_uom,
                    round(c.fc_comm_cost_gross / c.fc_comm_convert * m.fc_map_amount, 2) as fc_map_cost_extend
                FROM fc_map m
                JOIN fc_menu mn ON m.fc_map_menu = mn.fc_menu_id 
                JOIN fc_comm c ON m.fc_map_comm = c.fc_comm_id
                WHERE m.fc_map_id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new FcMapDTO(
            $row['fc_map_id'],
            $row['fc_menu_type'],
            $row['fc_map_menu'],
            $row['fc_menu_name'],
            $row['fc_map_comm'],
            $row['fc_comm_name'],
            $row['fc_map_amount'],
            $row['fc_comm_uom'],
            $row['fc_comm_cost_uom'],
            $row['fc_map_cost_extend']
        );
    }

    public function create(FcMapDTO $mapDTO): int
    {
        $sql = "INSERT INTO fc_map (fc_map_menu, fc_map_comm, fc_map_amount) VALUES (:menu_id, :comm_id, :amount)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':menu_id' => $mapDTO->getMenuId(),
            ':comm_id' => $mapDTO->getCommId(),
            ':amount' => $mapDTO->getAmount()
        ]);
        return (int)$this->db->lastInsertId();
    }

    public function update(FcMapDTO $map): bool
    {
        $sql = "UPDATE fc_map SET fc_map_menu = :menu_id, fc_map_comm = :comm_id, fc_map_amount = :amount WHERE fc_map_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $map->getId(),
            ':menu_id' => $map->getMenuId(),
            ':comm_id' => $map->getCommId(),
            ':amount' => $map->getAmount()
        ]);
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM fc_map WHERE fc_map_id = :id");
        return $stmt->execute([':id' => $id]);
    }

    public function updateAmount(int $id, float $amount): bool
    {
        $sql = "UPDATE fc_map SET fc_map_amount = :amount WHERE fc_map_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':id' => $id,
            ':amount' => $amount
        ]);
    }

    public function getIngredientById(int $id): ?array {
        $sql = "
            SELECT 
                m.fc_map_id as id,
                c.fc_comm_name as commodity_name,
                m.fc_map_amount as amount,
                c.fc_comm_uom as uom,
                ROUND(c.fc_comm_cost_gross / c.fc_comm_convert, 2) as cost_per_uom
            FROM 
                fc_map m
            JOIN 
                fc_comm c ON m.fc_map_comm = c.fc_comm_id
            WHERE 
                m.fc_map_id = :id
        ";

        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function updateRecipeForMenu(int $menuId, array $postData): bool
    {
        $this->db->beginTransaction();

        try {
            // 1. Handle Deletions
            if (!empty($postData['deleted_map_ids']) && is_array($postData['deleted_map_ids'])) {
                $deleteStmt = $this->db->prepare("DELETE FROM fc_map WHERE fc_map_id = :map_id AND fc_map_menu = :menu_id");
                foreach ($postData['deleted_map_ids'] as $mapId) {
                    $deleteStmt->execute([':map_id' => (int)$mapId, ':menu_id' => $menuId]);
                }
            }

            // 2. Handle Updates
            if (!empty($postData['amounts']) && is_array($postData['amounts'])) {
                $updateStmt = $this->db->prepare("UPDATE fc_map SET fc_map_amount = :amount WHERE fc_map_id = :map_id AND fc_map_menu = :menu_id");
                foreach ($postData['amounts'] as $mapId => $amount) {
                    if (is_numeric($amount) && $amount >= 0) {
                        $updateStmt->execute([
                            ':amount' => $amount,
                            ':map_id' => (int)$mapId,
                            ':menu_id' => $menuId
                        ]);
                    }
                }
            }

            // 3. Handle Inserts
            if (!empty($postData['new_comm_ids']) && is_array($postData['new_comm_ids'])) {
                $insertStmt = $this->db->prepare("INSERT INTO fc_map (fc_map_menu, fc_map_comm, fc_map_amount) VALUES (:menu_id, :comm_id, :amount)");
                foreach ($postData['new_comm_ids'] as $commId) {
                    if (isset($postData['new_amounts'][$commId]) && is_numeric($postData['new_amounts'][$commId]) && $postData['new_amounts'][$commId] > 0) {
                        $insertStmt->execute([
                            ':menu_id' => $menuId,
                            ':comm_id' => (int)$commId,
                            ':amount' => $postData['new_amounts'][$commId]
                        ]);
                    }
                }
            }

            $this->db->commit();
            return true;

        } catch (\Exception $e) {
            $this->db->rollBack();
            // Optionally log the error: error_log($e->getMessage());
            return false;
        }
    }

    public function getCostForMenu(int $menuId): float {
        $sql = "
            SELECT 
                SUM(m.fc_map_amount * (c.fc_comm_cost_gross / c.fc_comm_convert)) as total_cost
            FROM 
                fc_map m
            JOIN 
                fc_comm c ON m.fc_map_comm = c.fc_comm_id
            WHERE 
                m.fc_map_menu = :menu_id
                AND c.fc_comm_convert > 0
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':menu_id' => $menuId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (float) ($result['total_cost'] ?? 0.0);
    }
}
