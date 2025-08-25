<?php
use App\Repository\FcCommRepository;

// Get criteria from session
$criteria = $session->getFcCommCriteria();

// Get menu items from the database
$commRepo = new FcCommRepository();
$comms = $commRepo->findByCriteria($criteria);

?>

<div id="grid_data_sub_param">
    <form action="<?php echo url_for('/entity/jacolocal/foodcost/handle_criteria.php'); ?>" method="post">
        <?php include 'criteria_comm.php'; ?>
    </form>
</div>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            Commodities:
            <?php
            if (!empty($criteria['fc_comm_name'])) echo " | Name contains: " . h($criteria['fc_comm_name']);
            if (!empty($criteria['fc_comm_type'])) echo " | Type: " . h($criteria['fc_comm_type']);
            if (!empty($criteria['fc_comm_supplier'])) echo " | Supplier: " . h($criteria['fc_comm_supplier']);
            ?>
        </div>
        <div class="w3-half w3-right-align">
            <a href="index.php?thing=comm_form" class="w3-button w3-blue">New Commodity</a>
        </div>
    </div>
</div>

<div class="wd-table-container">
    <table class="wd-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Supplier</th>
                <th class="number">Net Cost</th>
                <th>UOM</th>
                <th class="number no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($comms as $comm) : ?>
                <tr>
                    <td><?= htmlspecialchars($comm->name) ?></td>
                    <td><?= htmlspecialchars($comm->type) ?></td>
                    <td><?= htmlspecialchars($comm->supplier) ?></td>
                    <td class="number"><?= number_format($comm->costNet, 2, '.', ',') ?></td>
                    <td><?= htmlspecialchars($comm->uom) ?></td>
                    <td class="actions">
                        <a href="index.php?thing=comm_form&id=<?= $comm->id ?>" class="wd-action-btn wd-action-edit" data-tooltip="Edit Commodity">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div id="grid_data_sub_foot">
    <?php echo count($comms); ?> records
</div>
