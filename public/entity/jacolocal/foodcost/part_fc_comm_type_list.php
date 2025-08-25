<?php
$commTypeRepo = new \App\Repository\FcCommTypeRepository();
$commTypes = $commTypeRepo->findAll();
?>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            <h2>Commodity Types</h2>
        </div>
        <div class="w3-half w3-right-align">
            <a href="?thing=comm_type_form" class="w3-button w3-blue">New Commodity Type</a>
        </div>
    </div>
</div>

<div class="wd-table-container">
    <table id="tbl_comm_type_summary" class="wd-table">
        <thead>
            <tr>
                <th>Name</th>
                <th class="number no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($commTypes as $type): ?>
                <tr>
                    <td><?= htmlspecialchars($type->fc_comm_type_name) ?></td>
                    <td>
                        <a href="?thing=comm_type_form&name=<?= urlencode($type->fc_comm_type_name) ?>" class="w3-button w3-small w3-green">Edit</a>
                        <a href="delete_comm_type.php?name=<?= urlencode($type->fc_comm_type_name) ?>" class="w3-button w3-small w3-red" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
