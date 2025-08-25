<?php
$commUomRepo = new \App\Repository\FcCommUomRepository();
$commUoms = $commUomRepo->findAll();
?>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            <h2>Commodity UOMs</h2>
        </div>
        <div class="w3-half w3-right-align">
            <a href="?thing=comm_uom_form" class="w3-button w3-blue">New Commodity UOM</a>
        </div>
    </div>
</div>

<div class="wd-table-container">
    <table id="tbl_comm_uom_summary" class="wd-table">
        <thead>
            <tr>
                <th>Name</th>
                <th class="number no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commUoms as $uom): ?>
                <tr>
                    <td><?= htmlspecialchars($uom->fc_comm_uom_name) ?></td>
                    <td>
                        <a href="?thing=comm_uom_form&name=<?= urlencode($uom->fc_comm_uom_name) ?>" class="w3-button w3-small w3-green">Edit</a>
                        <a href="delete_comm_uom.php?name=<?= urlencode($uom->fc_comm_uom_name) ?>" class="w3-button w3-small w3-red" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
