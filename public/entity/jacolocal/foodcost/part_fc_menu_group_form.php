<?php
$menuGroupRepo = new \App\Repository\FcMenuGroupRepository();
$menuCatRepo = new \App\Repository\FcMenuCatRepository();
$menuGroup = null;
if (isset($_GET['name'])) {
    $menuGroup = $menuGroupRepo->findByName($_GET['name']);
}
$menuCats = $menuCatRepo->findAll();
?>

<div class="w3-container">
    <h2><?= $menuGroup ? 'Edit' : 'Add' ?> Menu Group</h2>
    <form action="handle_menu_group_form.php" method="post">
        <input type="hidden" name="original_fc_menu_group_name" value="<?= htmlspecialchars($menuGroup->fc_menu_group_name ?? '') ?>">
        <div class="w3-section">
            <label for="fc_menu_group_name">Group Name</label>
            <input class="w3-input w3-border" type="text" id="fc_menu_group_name" name="fc_menu_group_name" value="<?= htmlspecialchars($menuGroup->fc_menu_group_name ?? '') ?>" required>
        </div>
        <div class="w3-section">
            <label for="fc_menu_group_sort">Sort Order</label>
            <input class="w3-input w3-border" type="number" id="fc_menu_group_sort" name="fc_menu_group_sort" value="<?= htmlspecialchars($menuGroup->fc_menu_group_sort ?? '100') ?>">
        </div>
        <div class="w3-section">
            <label for="fc_menu_group_cat">Category</label>
            <select class="w3-select w3-border" id="fc_menu_group_cat" name="fc_menu_group_cat">
                <?php foreach ($menuCats as $cat): ?>
                    <option value="<?= htmlspecialchars($cat->fc_menu_cat_name) ?>" <?= (isset($menuGroup) && $menuGroup->fc_menu_group_cat === $cat->fc_menu_cat_name) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat->fc_menu_cat_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="w3-button w3-blue"><?= $menuGroup ? 'Update' : 'Create' ?></button>
        <a href="?thing=menu_group_list" class="w3-button w3-grey">Cancel</a>
    </form>
</div>
