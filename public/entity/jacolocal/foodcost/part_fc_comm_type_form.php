<?php
$commTypeRepo = new \App\Repository\FcCommTypeRepository();
$commType = null;
if (isset($_GET['name'])) {
    $commType = $commTypeRepo->findByName($_GET['name']);
}
?>

<div class="w3-container">
    <h2><?= $commType ? 'Edit' : 'Add' ?> Commodity Type</h2>
    <form action="handle_comm_type_form.php" method="post">
        <?php if ($commType): ?>
            <input type="hidden" name="original_fc_comm_type_name" value="<?= htmlspecialchars($commType->fc_comm_type_name) ?>">
        <?php endif; ?>
        <div class="w3-section">
            <label for="fc_comm_type_name">Type Name</label>
            <input class="w3-input w3-border" type="text" id="fc_comm_type_name" name="fc_comm_type_name" value="<?= htmlspecialchars($commType->fc_comm_type_name ?? '') ?>" required>
        </div>
        <button type="submit" class="w3-button w3-blue"><?= $commType ? 'Update' : 'Create' ?></button>
        <a href="?thing=comm_type_list" class="w3-button w3-grey">Cancel</a>
    </form>
</div>
