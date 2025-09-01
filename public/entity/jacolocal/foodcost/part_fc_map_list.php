<?php
use App\Repository\FcMapRepository;

// Get criteria from session
$criteria = $session->getFcMapCriteria();

// Get map items from the database
$mapRepo = new FcMapRepository();
$maps = $mapRepo->findByCriteria($criteria);

?>

<div id="grid_data_sub_param">
    <form action="<?php echo url_for('/entity/jacolocal/foodcost/handle_criteria.php'); ?>" method="post">
        <?php include 'criteria_map.php'; ?>
    </form>
</div>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            Recipe Mappings:
            <?php
            if (!empty($criteria['fc_menu_type'])) echo " | Menu Type: " . h($criteria['fc_menu_type']);
            if (!empty($criteria['fc_menu_name'])) echo " | Menu Name contains: " . h($criteria['fc_menu_name']);
            if (!empty($criteria['fc_comm_name'])) echo " | Commodity Name contains: " . h($criteria['fc_comm_name']);
            ?>
        </div>
        <div class="w3-half w3-right-align">
            <a href="index.php?thing=map_form" class="w3-button w3-blue">New Mapping</a>
        </div>
    </div>
</div>

<div class="wd-table-container">
    <table class="wd-table">
        <thead>
            <tr>
                <th>Menu Type</th>
                <th>Menu Name</th>
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
                    <td><?= htmlspecialchars($map->getMenuType() ?? '') ?></td>
                    <td><?= htmlspecialchars($map->getMenuName()) ?></td>
                    <td><?= htmlspecialchars($map->getCommName()) ?></td>
                    <td class="number"><?= number_format($map->getAmount(), 2) ?></td>
                    <td><?= htmlspecialchars($map->getUom() ?? '') ?></td>
                    <td class="number"><?= number_format($map->getCostPerUom() ?? 0, 2) ?></td>
                    <td class="number"><?= number_format($map->getCostExtend() ?? 0, 2) ?></td>
                    <td class="actions">
                        <a href="index.php?thing=map_form&id=<?= $map->getId() ?>" class="wd-action-btn wd-action-edit" data-tooltip="Edit Mapping">
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
