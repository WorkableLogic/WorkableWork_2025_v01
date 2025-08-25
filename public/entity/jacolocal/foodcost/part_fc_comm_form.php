<?php
use App\DTO\FcCommDTO;
use App\Repository\FcCommTypeRepository;
use App\Repository\FcCommUomRepository;
use App\Repository\FcCommRepository;

// Logic to fetch or create a commodity item
$id = $_GET['id'] ?? null;
if ($id) {
    $repo = new FcCommRepository();
    $commItem = $repo->findById((int)$id);
} else {
    $commItem = new FcCommDTO(null, null, '', null, null, 0.0, 0.13, 0.0, null, null, 1.0, '');
}

/**
 * @var ?FcCommDTO $commItem
 */

$is_edit = isset($commItem) && $commItem->id !== null;
$page_title = $is_edit ? 'Edit Commodity' : 'Create New Commodity';

$typeRepo = new FcCommTypeRepository();
$types = $typeRepo->findAll();

$uomRepo = new FcCommUomRepository();
$uoms = $uomRepo->findAll();

?>

<div class="w3-container">
    <h2><?= htmlspecialchars($page_title) ?></h2>

    <form action="handle_comm_form.php" method="post">
        <?php if ($is_edit) : ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($commItem->id) ?>">
        <?php endif; ?>

        <div class="w3-row-padding">
            <div class="w3-third">
                <label for="fc_comm_name">Name</label>
                <input class="w3-input w3-border" type="text" id="fc_comm_name" name="fc_comm_name" value="<?= htmlspecialchars($commItem->name ?? '') ?>" required>
            </div>
            <div class="w3-third">
                <label for="fc_comm_code">Code</label>
                <input class="w3-input w3-border" type="text" id="fc_comm_code" name="fc_comm_code" value="<?= htmlspecialchars($commItem->code ?? '') ?>">
            </div>
            <div class="w3-third">
                <label for="fc_comm_supplier">Supplier</label>
                <input class="w3-input w3-border" type="text" id="fc_comm_supplier" name="fc_comm_supplier" value="<?= htmlspecialchars($commItem->supplier ?? '') ?>">
            </div>
        </div>

        <div class="w3-row-padding w3-margin-top">
            <div class="w3-third">
                <label for="fc_comm_type">Type</label>
                <select class="w3-select w3-border" id="fc_comm_type" name="fc_comm_type">
                    <option value="">Select Type</option>
                    <?php foreach ($types as $type) : ?>
                        <option value="<?= htmlspecialchars($type->fc_comm_type_name) ?>" <?= (isset($commItem) && $commItem->type === $type->fc_comm_type_name) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($type->fc_comm_type_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w3-third">
                <label for="fc_comm_uom">Unit of Measure</label>
                <select class="w3-select w3-border" id="fc_comm_uom" name="fc_comm_uom">
                    <option value="">Select UOM</option>
                    <?php foreach ($uoms as $uom) : ?>
                        <option value="<?= htmlspecialchars($uom->fc_comm_uom_name) ?>" <?= (isset($commItem) && $commItem->uom === $uom->fc_comm_uom_name) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($uom->fc_comm_uom_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
             <div class="w3-third">
                <label for="fc_comm_convert">Conversion Factor</label>
                <input class="w3-input w3-border" type="number" step="any" id="fc_comm_convert" name="fc_comm_convert" value="<?= htmlspecialchars($commItem->convert ?? '1') ?>">
            </div>
        </div>

        <div class="w3-row-padding w3-margin-top">
            <div class="w3-third">
                <label for="fc_comm_cost_net">Net Cost</label>
                <input class="w3-input w3-border" type="number" step="0.01" id="fc_comm_cost_net" name="fc_comm_cost_net" value="<?= htmlspecialchars($commItem->costNet ?? '0.00') ?>">
            </div>
            <div class="w3-third">
                <label for="fc_comm_tax_perc">Tax %</label>
                <input class="w3-input w3-border" type="number" step="0.01" id="fc_comm_tax_perc" name="fc_comm_tax_perc" value="<?= htmlspecialchars($commItem->taxPerc ?? '0.13') ?>">
            </div>
            <div class="w3-third">
                <label for="fc_comm_cost_gross">Gross Cost</label>
                <input class="w3-input w3-border" type="number" step="0.01" id="fc_comm_cost_gross" name="fc_comm_cost_gross" value="<?= htmlspecialchars($commItem->costGross ?? '0.00') ?>">
            </div>
        </div>
        
        <div class="w3-row-padding w3-margin-top">
            <div class="w3-half">
                <label for="fc_comm_invoice_size">Invoice Size</label>
                <input class="w3-input w3-border" type="text" id="fc_comm_invoice_size" name="fc_comm_invoice_size" value="<?= htmlspecialchars($commItem->invoiceSize ?? '') ?>">
            </div>
            <div class="w3-half">
                <label for="fc_comm_pack_describe">Pack Description</label>
                <input class="w3-input w3-border" type="text" id="fc_comm_pack_describe" name="fc_comm_pack_describe" value="<?= htmlspecialchars($commItem->packDescribe ?? '') ?>">
            </div>
        </div>

        <div class="w3-container w3-margin-top">
            <button type="submit" class="w3-button w3-blue">Save</button>
            <a href="index.php?thing=comm_list" class="w3-button w3-grey">Cancel</a>
            <?php if ($is_edit) : ?>
                <a href="delete_comm.php?id=<?= $commItem->id ?>" class="w3-button w3-red w3-right" onclick="return confirm('Are you sure you want to delete this item?');">Delete</a>
            <?php endif; ?>
        </div>
    </form>
</div>
