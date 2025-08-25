<?php
use App\Repository\FcCommTypeRepository;

// Get current criteria from the session object
$criteria = $session->getFcCommCriteria();

$typeRepo = new FcCommTypeRepository();
$types = $typeRepo->findAll();
?>

<form method="post" action="<?php echo url_for('/entity/jacolocal/foodcost/handle_criteria.php'); ?>">
    <input type="hidden" name="criteria_type" value="comm">
    
    <label for="fc_comm_name">Name:</label>
    <input type="text" id="fc_comm_name" name="fc_comm_name" value="<?= htmlspecialchars($criteria['fc_comm_name'] ?? '') ?>"/>

    <label for="fc_comm_type">Type:</label>
    <select id="fc_comm_type" name="fc_comm_type">
        <option value="All"<?= (($criteria['fc_comm_type'] ?? 'All') == 'All') ? ' selected' : ''; ?>>All</option>
        <?php foreach($types as $type): ?> 
            <option value="<?= htmlspecialchars($type->fc_comm_type_name) ?>" <?= (($criteria['fc_comm_type'] ?? '') == $type->fc_comm_type_name) ? ' selected' : ''; ?>>
                <?= htmlspecialchars($type->fc_comm_type_name) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <label for="fc_comm_supplier">Supplier:</label>
    <input type="text" id="fc_comm_supplier" name="fc_comm_supplier" value="<?= htmlspecialchars($criteria['fc_comm_supplier'] ?? '') ?>"/>

    <input type="submit" value="Update" /> 
</form>
