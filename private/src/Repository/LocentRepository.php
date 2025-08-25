<?php

namespace App\Repository;

use App\Database;
use App\DTO\LocentDTO;
use PDO;

class LocentRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findForUser(int $userId): array {
        $stmt = $this->db->prepare("
            SELECT al.* FROM admin_locent al
            JOIN admin_locent_user alu ON al.locent_id = alu.locent_user_locent
            WHERE alu.locent_user_user = :userId
        ");
        $stmt->execute(['userId' => $userId]);
        $locents = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $locentDTOs = [];
        foreach ($locents as $locent) {
            $locentDTOs[] = new LocentDTO(
                id: $locent['locent_id'],
                code: $locent['locent_code'],
                name: $locent['locent_name'],
                flag: (bool)$locent['locent_flag'],
                sort: $locent['locent_sort'],
                page: $locent['locent_page']
            );
        }

        return $locentDTOs;
    }
}
