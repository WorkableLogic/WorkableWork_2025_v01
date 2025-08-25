<?php
$menuCatRepo = new \App\Repository\FcMenuCatRepository();
$menuCat = null;
if (isset($_GET['name'])) {
    $menuCat = $menuCatRepo->findByName($_GET['name']);
}
?>

<div class="w3-container">
    <h2><?= $menuCat ? 'Edit' : 'Add' ?> Menu Category</h2>
    <form action="handle_menu_cat_form.php" method="post">
        <input type="hidden" name="original_fc_menu_cat_name" value="<?= htmlspecialchars($menuCat->fc_menu_cat_name ?? '') ?>">
        <div class="w3-section">
            <label for="fc_menu_cat_name">Category Name</label>
            <input class="w3-input w3-border" type="text" id="fc_menu_cat_name" name="fc_menu_cat_name" value="<?= htmlspecialchars($menuCat->fc_menu_cat_name ?? '') ?>" required>
        </div>
        <div class="w3-section">
            <label for="fc_menu_cat_sort">Sort Order</label>
            <input class="w3-input w3-border" type="number" id="fc_menu_cat_sort" name="fc_menu_cat_sort" value="<?= htmlspecialchars($menuCat->fc_menu_cat_sort ?? '100') ?>">
        </div>
        <button type="submit" class="w3-button w3-blue"><?= $menuCat ? 'Update' : 'Create' ?></button>
        <a href="?thing=menu_cat_list" class="w3-button w3-grey">Cancel</a>
    </form>
</div>
