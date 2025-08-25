<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/part_fc_map_work_menu_list.php

// Fetch data for the filter dropdowns.
// We need to instantiate the repositories to get the list of types and pages.
$menuTypeRepo = new \App\Repository\FcMenuTypeRepository();
$menuPageRepo = new \App\Repository\FcMenuPageRepository();

// The findAll() methods now return associative arrays as they originally did.
$menuTypes = $menuTypeRepo->findAll();
$menuPages = $menuPageRepo->findAll();

?>

<div class="wd-filter-form-container">
    <h4>Filter Menu Items</h4>
    <form id="menu-list-filter-form">
        <input type="hidden" name="thing" value="map_work">
        <div class="form-group">
            <label for="filter_menu_type">Type:</label>
            <select id="filter_menu_type" name="menu_type" class="wd-select">
                <option value="All">All Types</option>
                <?php foreach ($menuTypes as $type): ?>
                    <option value="<?= htmlspecialchars($type->fc_menu_type_name) ?>"><?= htmlspecialchars($type->fc_menu_type_name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="filter_menu_page">Page:</label>
            <select id="filter_menu_page" name="menu_page" class="wd-select">
                <option value="All">All Pages</option>
                 <?php foreach ($menuPages as $page): ?>
                    <option value="<?= htmlspecialchars($page->fc_menu_page_name) ?>"><?= htmlspecialchars($page->fc_menu_page_name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group">
            <label for="filter_menu_name">Name:</label>
            <input type="text" id="filter_menu_name" name="menu_name" class="wd-input-text" placeholder="e.g., Burger">
        </div>
    </form>
</div>

<hr>

<div class="menu-list-header">
    <span class="menu-item-type">Type</span>
    <span class="menu-item-name">Name</span>
    <span class="menu-item-page">Page</span>
</div>
<div id="menu-item-list-container" class="wd-scrollable-list">
    <!-- This div will be populated with menu items by JavaScript -->
    <div class="wd-list-item-placeholder">Use filters to load menu items...</div>
</div>
