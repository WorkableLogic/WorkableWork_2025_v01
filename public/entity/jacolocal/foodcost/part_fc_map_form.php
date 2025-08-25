<?php
// /public/entity/jacolocal/foodcost/part_fc_map_form.php

use App\Repository\FcMapRepository;
use App\Repository\FcMenuRepository;
use App\Repository\FcCommRepository;
use App\DTO\FcMapDTO;

// Logic to fetch or create a map item
$id = $_GET['id'] ?? null;
$repo = new FcMapRepository();
$menuRepo = new FcMenuRepository();
$commRepo = new FcCommRepository();

if ($id) {
    $mapItem = $repo->findById((int)$id);
} else {
    // Correctly instantiate with named arguments matching the DTO constructor
    $mapItem = new FcMapDTO(fc_map_id: null, menuType: '', fc_map_menu: 0, menuName: '', fc_map_comm: 0, commName: '', fc_map_amount: 0.0, commUom: '', commCostUom: 0.0, mapCostExtend: 0.0);
}

/**
 * @var ?FcMapDTO $mapItem
 */

$is_edit = isset($mapItem) && $mapItem->fc_map_id !== null;
$page_title = $is_edit ? 'Edit Recipe Mapping' : 'Create New Recipe Mapping';

// Get dropdown options
$menus = $menuRepo->getFullMenuList(); 
$commodities = $commRepo->findByCriteria([]);

?>

<div class="w3-container">
    <h2><?= htmlspecialchars($page_title) ?></h2>

    <form action="handle_map_form.php" method="post">
        <?php if ($is_edit) : ?>
            <input type="hidden" name="fc_map_id" value="<?= htmlspecialchars($mapItem->fc_map_id) ?>">
        <?php endif; ?>

        <div class="w3-row-padding">
            <div class="w3-half">
                <label for="fc_map_menu">Menu Item</label>
                <select class="w3-select w3-border" id="fc_map_menu" name="fc_map_menu" required>
                    <option value="">Select Menu Item</option>
                    <?php foreach ($menus as $menu) : ?>
                        <option value="<?= htmlspecialchars($menu->id) ?>" <?= ($mapItem && $mapItem->fc_map_menu == $menu->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($menu->name) ?> (<?= htmlspecialchars($menu->typeName) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w3-half">
                <label for="fc_map_comm">Commodity</label>
                <select class="w3-select w3-border" id="fc_map_comm" name="fc_map_comm" required>
                    <option value="">Select Commodity</option>
                    <?php foreach ($commodities as $comm) : ?>
                        <option value="<?= htmlspecialchars($comm->id) ?>" <?= ($mapItem && $mapItem->fc_map_comm == $comm->id) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($comm->name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="w3-row-padding w3-margin-top">
            <div class="w3-quarter">
                <label for="fc_map_amount">Amount</label>
                <input class="w3-input w3-border" type="number" step="any" id="fc_map_amount" name="fc_map_amount" value="<?= htmlspecialchars($mapItem->fc_map_amount ?? '0.0') ?>" required>
            </div>
            <div class="w3-threequarter" style="padding-top: 24px;">
                <span id="comm_uom_display" class="w3-margin-left"></span>
                <span id="comm_pack_display" class="w3-margin-left w3-text-grey"></span>
            </div>
        </div>

        <div class="w3-container w3-margin-top">
            <button type="submit" class="w3-button w3-blue">Save</button>
            <a href="index.php?thing=map_list" class="w3-button w3-grey">Cancel</a>
            <?php if ($is_edit) : ?>
                <a href="delete_map.php?id=<?= $mapItem->fc_map_id ?>" class="w3-button w3-red w3-right" onclick="return confirm('Are you sure you want to delete this mapping?');">Delete</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<script>
// Embed commodity data as JSON
const commoditiesData = <?= json_encode(array_map(fn($c) => ['id' => $c->id, 'uom' => $c->uom, 'packDescribe' => $c->packDescribe], $commodities)) ?>;

const commSelect = document.getElementById('fc_map_comm');
const uomDisplay = document.getElementById('comm_uom_display');
const packDisplay = document.getElementById('comm_pack_display');

function updateCommodityDetails() {
    const selectedCommId = commSelect.value;
    const selectedCommodity = commoditiesData.find(c => c.id == selectedCommId);

    if (selectedCommodity) {
        uomDisplay.textContent = selectedCommodity.uom;
        packDisplay.textContent = `(${selectedCommodity.packDescribe})`;
    } else {
        uomDisplay.textContent = '';
        packDisplay.textContent = '';
    }
}

// Add event listener for changes
commSelect.addEventListener('change', updateCommodityDetails);

// Run on page load to set initial state
document.addEventListener('DOMContentLoaded', updateCommodityDetails);
</script>
