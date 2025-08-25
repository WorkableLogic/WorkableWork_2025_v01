<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/part_fc_menu_type_list.php
$menuTypeRepo = new \App\Repository\FcMenuTypeRepository();
$menuTypes = $menuTypeRepo->findAll();
?>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            <h2>Menu Types</h2>
        </div>
        <div class="w3-half w3-right-align">
            <a href="?thing=menu_type_form" class="w3-button w3-blue">New Menu Type</a>
        </div>
    </div>
</div>

<div class="wd-table-container">
    <table id="tbl_menu_summary" class="wd-table">
        <thead>
            <tr>
                <th>Group</th>
                <th>Name</th>
                <th>Sort</th>
                <th class="number no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuTypes as $type): ?>
                <tr>
                    <td><?= htmlspecialchars($type->fc_menu_type_group) ?></td>
                    <td><?= htmlspecialchars($type->fc_menu_type_name) ?></td>
                    <td><?= htmlspecialchars($type->fc_menu_type_sort) ?></td>
                    <td>
                        <a href="?thing=menu_type_form&name=<?= urlencode($type->fc_menu_type_name) ?>" class="w3-button w3-small w3-green">Edit</a>
                        <a href="delete_menu_type.php?name=<?= urlencode($type->fc_menu_type_name) ?>" class="w3-button w3-small w3-red" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
