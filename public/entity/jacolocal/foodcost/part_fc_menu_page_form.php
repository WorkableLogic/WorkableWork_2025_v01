<?php
$menuPageRepo = new \App\Repository\FcMenuPageRepository();
$menuPage = null;
if (isset($_GET['name'])) {
    $menuPage = $menuPageRepo->findByName($_GET['name']);
}
?>

<div class="w3-container">
    <h2><?= $menuPage ? 'Edit' : 'Add' ?> Menu Page</h2>
    <form action="handle_menu_page_form.php" method="post">
        <input type="hidden" name="original_fc_menu_page_name" value="<?= htmlspecialchars($menuPage->fc_menu_page_name ?? '') ?>">
        <div class="w3-section">
            <label for="fc_menu_page_name">Page Name</label>
            <input class="w3-input w3-border" type="text" id="fc_menu_page_name" name="fc_menu_page_name" value="<?= htmlspecialchars($menuPage->fc_menu_page_name ?? '') ?>" required>
        </div>
        <div class="w3-section">
            <label for="fc_menu_page_sort">Sort Order</label>
            <input class="w3-input w3-border" type="number" id="fc_menu_page_sort" name="fc_menu_page_sort" value="<?= htmlspecialchars($menuPage->fc_menu_page_sort ?? '100') ?>">
        </div>
        <button type="submit" class="w3-button w3-blue"><?= $menuPage ? 'Update' : 'Create' ?></button>
        <a href="?thing=menu_page_list" class="w3-button w3-grey">Cancel</a>
    </form>
</div>
