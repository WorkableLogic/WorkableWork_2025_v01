<?php
// /public/entity/jacolocal/foodcost/part_fc_menu_form.php

use App\Repository\FcMenuPageRepository;
use App\Repository\FcMenuTypeRepository;
use App\DTO\FcMenuDTO;
use App\Repository\FcMenuRepository;

// Logic to fetch or create a menu item
$id = $_GET['id'] ?? null;
if ($id) {
    $repo = new FcMenuRepository();
    $menuItem = $repo->findById((int)$id);
} else {
    $menuItem = new FcMenuDTO(null, '', 0.0, '', '', '', '');
}

/**
 * @var ?FcMenuDTO $menuItem
 */

$is_edit = isset($menuItem) && $menuItem->id !== null;

// Get dropdown options
$pageRepo = new FcMenuPageRepository();
$pages = $pageRepo->findAll();

$typeRepo = new FcMenuTypeRepository();
$types = $typeRepo->findAll();

?>

<div class="w3-container">

    <form action="handle_menu_form.php" method="post">
        <?php if ($is_edit) : ?>
            <input type="hidden" name="fc_menu_id" value="<?= htmlspecialchars($menuItem->id) ?>">
        <?php endif; ?>

        <div class="w3-row-padding">
            <div class="w3-half">
                <label for="fc_menu_name">Menu Item Name</label>
                <input class="w3-input w3-border" type="text" id="fc_menu_name" name="fc_menu_name" value="<?= htmlspecialchars($menuItem->name ?? '') ?>" required>
            </div>
            <div class="w3-half">
                <label for="fc_menu_price">Price</label>
                <input class="w3-input w3-border" type="number" step="0.01" id="fc_menu_price" name="fc_menu_price" value="<?= htmlspecialchars($menuItem->price ?? '0.00') ?>" required>
            </div>
        </div>

        <div class="w3-row-padding w3-margin-top">
            <div class="w3-half">
                <label for="fc_menu_page">Page</label>
                <select class="w3-select w3-border" id="fc_menu_page" name="fc_menu_page" required>
                    <option value="">Select Page</option>
                    <?php foreach ($pages as $page) : ?>
                        <option value="<?= htmlspecialchars($page['fc_menu_page_name']) ?>" <?= (isset($menuItem) && $menuItem->pageName === $page['fc_menu_page_name']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($page['fc_menu_page_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w3-half">
                <label for="fc_menu_type">Type</label>
                <select class="w3-select w3-border" id="fc_menu_type" name="fc_menu_type" required>
                    <option value="">Select Type</option>
                     <?php foreach ($types as $type) : ?>
                        <option value="<?= htmlspecialchars($type['fc_menu_type_name']) ?>" <?= (isset($menuItem) && $menuItem->typeName === $type['fc_menu_type_name']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($type['fc_menu_type_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="w3-container w3-margin-top">
            <button type="submit" class="w3-button w3-blue">Save</button>
            <a href="index.php?thing=menu_list" class="w3-button w3-grey">Cancel</a>
            <?php if ($is_edit) : ?>
                <a href="delete_menu.php?id=<?= $menuItem->id ?>" class="w3-button w3-red w3-right" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
            <?php endif; ?>
        </div>
    </form>
</div>