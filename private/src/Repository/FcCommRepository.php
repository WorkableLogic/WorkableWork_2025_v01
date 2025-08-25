<?php

namespace App\Repository;

use App\Database;
use App\DTO\FcCommDTO;
use PDO;

class FcCommRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function findByCriteria(array $criteria): array
    {
        $sql = "SELECT * FROM fc_comm WHERE 1=1";
        $params = [];

        if (!empty($criteria['fc_comm_name'])) {
            $sql .= " AND fc_comm_name LIKE :name";
            $params[':name'] = '%' . $criteria['fc_comm_name'] . '%';
        }

        if (!empty($criteria['fc_comm_type']) && $criteria['fc_comm_type'] !== 'All') {
            $sql .= " AND fc_comm_type = :type";
            $params[':type'] = $criteria['fc_comm_type'];
        }
        
        if (!empty($criteria['fc_comm_supplier'])) {
            $sql .= " AND fc_comm_supplier LIKE :supplier";
            $params[':supplier'] = '%' . $criteria['fc_comm_supplier'] . '%';
        }

        $sql .= " ORDER BY fc_comm_name ASC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $this->rowToDTO($row);
        }
        return $results;
    }

    public function findById(int $id): ?FcCommDTO
    {
        $stmt = $this->db->prepare("SELECT * FROM fc_comm WHERE fc_comm_id = :id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $this->rowToDTO($row) : null;
    }

    public function findAll(): array
    {
        return $this->findByCriteria([]);
    }

    public function findUnusedCommoditiesForMenu(int $menuId): array
    {
        $sql = "
            SELECT c.*
            FROM fc_comm c
            LEFT JOIN fc_map m ON c.fc_comm_id = m.fc_map_comm AND m.fc_map_menu = :menu_id
            WHERE m.fc_map_id IS NULL
            ORDER BY c.fc_comm_name ASC
        ";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':menu_id' => $menuId]);
        
        $results = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $results[] = $this->rowToDTO($row);
        }
        return $results;
    }

    public function create(FcCommDTO $comm): bool
    {
        $sql = "INSERT INTO fc_comm (fc_comm_code, fc_comm_name, fc_comm_type, fc_comm_supplier, fc_comm_cost_net, fc_comm_tax_perc, fc_comm_cost_gross, fc_comm_invoice_size, fc_comm_pack_describe, fc_comm_convert, fc_comm_uom) VALUES (:code, :name, :type, :supplier, :costNet, :taxPerc, :costGross, :invoiceSize, :packDescribe, :convert, :uom)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($this->dtoToParams($comm));
    }

    public function update(FcCommDTO $comm): bool
    {
        $sql = "UPDATE fc_comm SET fc_comm_code = :code, fc_comm_name = :name, fc_comm_type = :type, fc_comm_supplier = :supplier, fc_comm_cost_net = :costNet, fc_comm_tax_perc = :taxPerc, fc_comm_cost_gross = :costGross, fc_comm_invoice_size = :invoiceSize, fc_comm_pack_describe = :packDescribe, fc_comm_convert = :convert, fc_comm_uom = :uom WHERE fc_comm_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($this->dtoToParams($comm, true));
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM fc_comm WHERE fc_comm_id = :id");
        return $stmt->execute([':id' => $id]);
    }

    private function rowToDTO(array $row): FcCommDTO
    {
        return new FcCommDTO(
            $row['fc_comm_id'],
            $row['fc_comm_code'],
            $row['fc_comm_name'],
            $row['fc_comm_type'],
            $row['fc_comm_supplier'],
            $row['fc_comm_cost_net'],
            $row['fc_comm_tax_perc'],
            $row['fc_comm_cost_gross'],
            $row['fc_comm_invoice_size'],
            $row['fc_comm_pack_describe'],
            $row['fc_comm_convert'],
            $row['fc_comm_uom']
        );
    }

    private function dtoToParams(FcCommDTO $comm, bool $includeId = false): array
    {
        $params = [
            ':code' => $comm->code,
            ':name' => $comm->name,
            ':type' => $comm->type,
            ':supplier' => $comm->supplier,
            ':costNet' => $comm->costNet,
            ':taxPerc' => $comm->taxPerc,
            ':costGross' => $comm->costGross,
            ':invoiceSize' => $comm->invoiceSize,
            ':packDescribe' => $comm->packDescribe,
            ':convert' => $comm->convert,
            ':uom' => $comm->uom,
        ];

        if ($includeId) {
            $params[':id'] = $comm->id;
        }

        return $params;
    }
}
