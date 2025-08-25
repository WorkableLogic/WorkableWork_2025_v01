<?php
use App\Repository\FcMapRepository;

// Get criteria from session
$criteria = $session->getFcMapCriteria();

// Get map items from the database
$mapRepo = new FcMapRepository();
$maps = $mapRepo->findByCriteria($criteria);

?>

<div class="wd-table-container">
    <table class="wd-table">
        <thead>
            <tr>
                <th>Commodity Name</th>
                <th class="number">Amount</th>
                <th>UOM</th>
                <th class="number">Cost/UOM</th>
                <th class="number">Extended Cost</th>
                <th class="number no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($maps as $map) : ?>
                <tr>
                    <td><?= htmlspecialchars($map->commName) ?></td>
                    <td class="number"><?= number_format($map->fc_map_amount, 2) ?></td>
                    <td><?= htmlspecialchars($map->commUom ?? '') ?></td>
                    <td class="number"><?= number_format($map->commCostUom ?? 0, 2) ?></td>
                    <td class="number"><?= number_format($map->mapCostExtend ?? 0, 2) ?></td>
                    <td class="actions">
                        <a href="index.php?thing=map_form&id=<?= $map->fc_map_id ?>" class="wd-action-btn wd-action-edit" data-tooltip="Edit Mapping">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="grid_data_sub_foot">
    <?php echo count($maps); ?> records
</div>
