<?php

namespace App\Repository;

use App\Database;
use PDO;

class FcCommTypeRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findAll(): array {
        $stmt = $this->db->query("SELECT fc_comm_type_name FROM fc_comm_type ORDER BY fc_comm_type_name");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $types = [];
        foreach ($results as $row) {
            $dto = new \App\DTO\FcCommTypeDTO();
            $dto->fc_comm_type_name = $row['fc_comm_type_name'];
            $types[] = $dto;
        }
        return $types;
    }

    public function findByName(string $name): ?\App\DTO\FcCommTypeDTO {
        $stmt = $this->db->prepare("SELECT fc_comm_type_name FROM fc_comm_type WHERE fc_comm_type_name = :name");
        $stmt->execute(['name' => $name]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }
        $dto = new \App\DTO\FcCommTypeDTO();
        $dto->fc_comm_type_name = $row['fc_comm_type_name'];
        return $dto;
    }

    public function create(\App\DTO\FcCommTypeDTO $dto): bool {
        $stmt = $this->db->prepare("INSERT INTO fc_comm_type (fc_comm_type_name) VALUES (:fc_comm_type_name)");
        return $stmt->execute([
            'fc_comm_type_name' => $dto->fc_comm_type_name
        ]);
    }

    public function update(string $original_name, \App\DTO\FcCommTypeDTO $dto): bool {
        $stmt = $this->db->prepare("UPDATE fc_comm_type SET fc_comm_type_name = :new_name WHERE fc_comm_type_name = :original_name");
        return $stmt->execute([
            'new_name' => $dto->fc_comm_type_name,
            'original_name' => $original_name
        ]);
    }

    public function delete(string $name): bool {
        $stmt = $this->db->prepare("DELETE FROM fc_comm_type WHERE fc_comm_type_name = :name");
        return $stmt->execute(['name' => $name]);
    }
}
