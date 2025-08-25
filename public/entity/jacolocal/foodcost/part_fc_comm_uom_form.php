<?php
$commUomRepo = new \App\Repository\FcCommUomRepository();
$commUom = null;
if (isset($_GET['name'])) {
    $commUom = $commUomRepo->findByName($_GET['name']);
}
?>

<div class="w3-container">
    <h2><?= $commUom ? 'Edit' : 'Add' ?> Commodity UOM</h2>
    <form action="handle_comm_uom_form.php" method="post">
        <?php if ($commUom): ?>
            <input type="hidden" name="original_fc_comm_uom_name" value="<?= htmlspecialchars($commUom->fc_comm_uom_name) ?>">
        <?php endif; ?>
        <div class="w3-section">
            <label for="fc_comm_uom_name">UOM Name</label>
            <input class="w3-input w3-border" type="text" id="fc_comm_uom_name" name="fc_comm_uom_name" value="<?= htmlspecialchars($commUom->fc_comm_uom_name ?? '') ?>" required>
        </div>
        <button type="submit" class="w3-button w3-blue"><?= $commUom ? 'Update' : 'Create' ?></button>
        <a href="?thing=comm_uom_list" class="w3-button w3-grey">Cancel</a>
    </form>
</div>
