<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcCommUomDTO;
use PDO;

class FcCommUomRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT fc_comm_uom_name FROM fc_comm_uom ORDER BY fc_comm_uom_name");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $uoms = [];
        foreach ($results as $row) {
            $dto = new FcCommUomDTO();
            $dto->fc_comm_uom_name = $row['fc_comm_uom_name'];
            $uoms[] = $dto;
        }
        return $uoms;
    }

    public function findByName(string $name): ?FcCommUomDTO {
        $stmt = $this->db->prepare("SELECT fc_comm_uom_name FROM fc_comm_uom WHERE fc_comm_uom_name = :name");
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $dto = new FcCommUomDTO();
        $dto->fc_comm_uom_name = $row['fc_comm_uom_name'];
        return $dto;
    }

    public function create(FcCommUomDTO $dto): bool {
        $stmt = $this->db->prepare("INSERT INTO fc_comm_uom (fc_comm_uom_name) VALUES (:fc_comm_uom_name)");
        return $stmt->execute([
            'fc_comm_uom_name' => $dto->fc_comm_uom_name
        ]);
    }

    public function update(string $original_name, FcCommUomDTO $dto): bool {
        $stmt = $this->db->prepare("UPDATE fc_comm_uom SET fc_comm_uom_name = :new_name WHERE fc_comm_uom_name = :original_name");
        return $stmt->execute([
            'new_name' => $dto->fc_comm_uom_name,
            'original_name' => $original_name
        ]);
    }

    public function delete(string $name): bool {
        $stmt = $this->db->prepare("DELETE FROM fc_comm_uom WHERE fc_comm_uom_name = :name");
        return $stmt->execute(['name' => $name]);
    }
}
