<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/part_fc_menu_type_form.php
$menuTypeRepo = new \App\Repository\FcMenuTypeRepository();
$menuGroupRepo = new \App\Repository\FcMenuGroupRepository();
$menuType = null;
if (isset($_GET['name'])) {
    $menuType = $menuTypeRepo->findByName($_GET['name']);
}
$menuGroups = $menuGroupRepo->findAll();
?>

<div class="w3-container">
    <h2><?= $menuType ? 'Edit' : 'Add' ?> Menu Type</h2>
    <form action="handle_menu_type_form.php" method="post">
        <input type="hidden" name="original_fc_menu_type_name" value="<?= htmlspecialchars($menuType->fc_menu_type_name ?? '') ?>">
        <div class="w3-section">
            <label for="fc_menu_type_name">Type Name</label>
            <input class="w3-input w3-border" type="text" id="fc_menu_type_name" name="fc_menu_type_name" value="<?= htmlspecialchars($menuType->fc_menu_type_name ?? '') ?>" required>
        </div>
        <div class="w3-section">
            <label for="fc_menu_type_sort">Sort Order</label>
            <input class="w3-input w3-border" type="number" id="fc_menu_type_sort" name="fc_menu_type_sort" value="<?= htmlspecialchars($menuType->fc_menu_type_sort ?? '100') ?>">
        </div>
        <div class="w3-section">
            <label for="fc_menu_type_group">Group</label>
            <select class="w3-select w3-border" id="fc_menu_type_group" name="fc_menu_type_group">
                <?php foreach ($menuGroups as $group): ?>
                    <option value="<?= htmlspecialchars($group->fc_menu_group_name) ?>" <?= (isset($menuType) && $menuType->fc_menu_type_group === $group->fc_menu_group_name) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($group->fc_menu_group_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="w3-button w3-blue"><?= $menuType ? 'Update' : 'Create' ?></button>
        <a href="?thing=menu_type_list" class="w3-button w3-grey">Cancel</a>
    </form>
</div>
