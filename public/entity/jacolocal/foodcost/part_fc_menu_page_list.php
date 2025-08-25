<?php
$menuPageRepo = new \App\Repository\FcMenuPageRepository();
$menuPages = $menuPageRepo->findAll();
?>

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            <h2>Menu Pages</h2>
        </div>
        <div class="w3-half w3-right-align">
            <a href="?thing=menu_page_form" class="w3-button w3-blue">New Menu Page</a>
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
            <?php foreach ($menuPages as $page): ?>
                <tr>
                    <td><?= htmlspecialchars($page->fc_menu_page_name) ?></td>
                    <td><?= htmlspecialchars($page->fc_menu_page_sort) ?></td>
                    <td>
                        <a href="?thing=menu_page_form&name=<?= urlencode($page->fc_menu_page_name) ?>" class="w3-button w3-small w3-green">Edit</a>
                        <a href="delete_menu_page.php?name=<?= urlencode($page->fc_menu_page_name) ?>" class="w3-button w3-small w3-red" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
