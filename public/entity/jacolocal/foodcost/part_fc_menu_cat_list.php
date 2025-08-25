<?php
$menuCatRepo = new \App\Repository\FcMenuCatRepository();
$menuCats = $menuCatRepo->findAll();
?>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            <h2>Menu Categories</h2>
        </div>
        <div class="w3-half w3-right-align">
            <a href="?thing=menu_cat_form" class="w3-button w3-blue">New Menu Category</a>
        </div>
    </div>
</div>

<div class="wd-table-container">
    <table id="tbl_menu_summary" class="wd-table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Sort</th>
                <th class="number no-sort">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($menuCats as $cat): ?>
                <tr>
                    <td><?= htmlspecialchars($cat->fc_menu_cat_name) ?></td>
                    <td><?= htmlspecialchars($cat->fc_menu_cat_sort) ?></td>
                    <td>
                        <a href="?thing=menu_cat_form&name=<?= urlencode($cat->fc_menu_cat_name) ?>" class="w3-button w3-small w3-green">Edit</a>
                        <a href="delete_menu_cat.php?name=<?= urlencode($cat->fc_menu_cat_name) ?>" class="w3-button w3-small w3-red" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
