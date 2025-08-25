<?php
// part_fc_menu_summary_list.php

// Ensure repositories are available
if (!isset($menuRepo) || !isset($mapRepo)) {
    echo "Error: Repositories not available.";
    return;
}

?>

<div id="grid_data_sub_param">
    <form action="<?php echo url_for('/entity/jacolocal/foodcost/handle_criteria.php'); ?>" method="post">
        <?php include('criteria_menu_summary.php'); ?>
    </form>
</div>  

<div id="grid_data_sub_crit">
    <div class="w3-row">
        <div class="w3-half">
            Menu Summary and Cost Analysis
        </div>
    </div>
</div>


<div class="wd-table-container">
    <table class="wd-table">
        <thead>
            <tr>
                <th>Menu Type</th>
                <th>Menu Item</th>
                <th>Menu Page</th>
                <th class="number">Price</th>
                <th class="number">Cost</th>
                <th class="number">COG %</th>
                <th class="number">Margin</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($menus)): ?>
                <tr>
                    <td colspan="8">No menu items found.</td>
                </tr>
            <?php else: ?>
                <?php foreach ($menus as $menu): ?>
                    <?php
                        $cost = $mapRepo->getCostForMenu($menu->id);
                        $price = $menu->price;
                        $margin = $price - $cost;
                        $cost_percent = ($price > 0) ? ($cost / $price) * 100 : 0;
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($menu->typeName) ?></td>
                        <td><?= htmlspecialchars($menu->name) ?></td>
                        <td><?= htmlspecialchars($menu->pageName) ?></td>
                        <td class="number">$<?= number_format($price, 2) ?></td>
                        <td class="number">$<?= number_format($cost, 2) ?></td>
                        <td class="number"><?= number_format($cost_percent, 2) ?>%</td>
                        <td class="number">$<?= number_format($margin, 2) ?></td>
                        <td><a href="?thing=map_work&id=<?= $menu->id ?>" class="w3-button w3-small w3-blue">Map</a></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div id="grid_data_sub_foot">
    <?php echo count($menus); ?> records
</div>
