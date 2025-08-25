<?php
$menuGroupRepo = new \App\Repository\FcMenuGroupRepository();
$menuGroups = $menuGroupRepo->findAll();
?>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            <h2>Menu Groups</h2>
        </div>
        <div class="w3-half w3-right-align">
            <a href="?thing=menu_group_form" class="w3-button w3-blue">New Menu Group</a>
        </div>
    </div>
</div>

<div class="wd-table-container">
    <table id="tbl_menu_summary" class="wd-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Name</th>
                <th>Sort</th>
                <th class="number no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuGroups as $group): ?>
                <tr>
                    <td><?= htmlspecialchars($group->fc_menu_group_cat) ?></td>
                    <td><?= htmlspecialchars($group->fc_menu_group_name) ?></td>
                    <td><?= htmlspecialchars($group->fc_menu_group_sort) ?></td>
                    <td>
                        <a href="?thing=menu_group_form&name=<?= urlencode($group->fc_menu_group_name) ?>" class="w3-button w3-small w3-green">Edit</a>
                        <a href="delete_menu_group.php?name=<?= urlencode($group->fc_menu_group_name) ?>" class="w3-button w3-small w3-red" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
