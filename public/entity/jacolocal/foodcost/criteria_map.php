<?php
use App\Repository\FcMenuTypeRepository;

// Check for URL parameters and update session criteria
if (isset($_GET['menu_type']) || isset($_GET['menu_name']) || isset($_GET['menu_page'])) {
    $newCriteria = [
        'fc_menu_type' => $_GET['menu_type'] ?? $session->getFcMapCriteria()['fc_menu_type'],
        'fc_menu_name' => $_GET['menu_name'] ?? $session->getFcMapCriteria()['fc_menu_name'],
        'fc_comm_name' => $session->getFcMapCriteria()['fc_comm_name'], // Retain existing commodity name
    ];
    $session->setFcMapCriteria($newCriteria);
}

// Get dropdown options
$typeRepo = new FcMenuTypeRepository();
$types = $typeRepo->findAll();

// Get current criteria from session
$criteria = $session->getFcMapCriteria();
?>

<div class="w3-card">
    <div class="w3-container w3-padding">
        <div class="w3-row-padding">
            <div class="w3-third">
                <label for="fc_menu_type">Menu Type</label>
                <select class="w3-select w3-border" id="fc_menu_type" name="fc_menu_type">
                    <option value="All" <?= ($criteria['fc_menu_type'] ?? '') === 'All' ? 'selected' : '' ?>>All</option>
                    <?php foreach ($types as $type) : ?>
                        <option value="<?= htmlspecialchars($type->fc_menu_type_name) ?>" <?= ($criteria['fc_menu_type'] ?? '') === $type->fc_menu_type_name ? 'selected' : '' ?>>
                            <?= htmlspecialchars($type->fc_menu_type_name) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w3-third">
                <label for="fc_menu_name">Menu Name</label>
                <input class="w3-input w3-border" type="text" id="fc_menu_name" name="fc_menu_name" value="<?= htmlspecialchars($criteria['fc_menu_name'] ?? '') ?>">
            </div>
            <div class="w3-third">
                <label for="fc_comm_name">Commodity Name</label>
                <input class="w3-input w3-border" type="text" id="fc_comm_name" name="fc_comm_name" value="<?= htmlspecialchars($criteria['fc_comm_name'] ?? '') ?>">
            </div>
        </div>
    </div>
    <div class="w3-container w3-padding w3-light-grey">
        <input type="hidden" name="criteria_type" value="fc_map">
        <button type="submit" name="action" value="apply" class="w3-button w3-blue">Apply</button>
        <button type="submit" name="action" value="clear" class="w3-button w3-grey">Clear</button>
    </div>
</div>
