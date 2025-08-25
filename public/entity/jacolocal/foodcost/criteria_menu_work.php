<?php
use App\Repository\FcMenuCatRepository;
use App\Repository\FcMenuGroupRepository;
use App\Repository\FcMenuTypeRepository;
use App\Repository\FcMenuPageRepository;

// Get current criteria from the session object
$criteria = $session->getFcMenuCriteria();

// Instantiate repositories to get dropdown options
// $catRepo = new FcMenuCatRepository();
// $cats = $catRepo->findAll();

// $groupRepo = new FcMenuGroupRepository();
// $groups = $groupRepo->findAll();

$typeRepo = new FcMenuTypeRepository();
$types = $typeRepo->findAll();

$pageRepo = new FcMenuPageRepository();
$pages = $pageRepo->findAll();
?>

<form method="post" action="<?php echo url_for('/entity/jacolocal/foodcost/handle_criteria.php'); ?>">
    <input type="hidden" name="criteria_type" value="menu_work">
    

    <label for="fc_menu_type_name">Type:</label>
    <select id="fc_menu_type_name" name="fc_menu_type_name">
        <option value="All"<?php echo ($criteria['fc_menu_type_name'] ?? 'All') == 'All' ? ' selected' : ''; ?>>All</option>
        <?php foreach($types as $type): ?> 
            <option value="<?= htmlspecialchars($type['fc_menu_type_name']) ?>" <?= (($criteria['fc_menu_type_name'] ?? '') == $type['fc_menu_type_name']) ? ' selected' : ''; ?>>
                <?= htmlspecialchars($type['fc_menu_type_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>
    
    <label for="fc_menu_name">Menu Item:</label>
    <input type="text" id="fc_menu_name" name="fc_menu_name" value="<?php echo h($criteria['fc_menu_name'] ?? ''); ?>"/>
    
    <label for="fc_menu_page">Menu Page:</label>
    <select id="fc_menu_page" name="fc_menu_page">
        <option value="All"<?php echo ($criteria['fc_menu_page'] ?? 'All') == 'All' ? ' selected' : ''; ?>>All</option>
        <?php foreach($pages as $page): ?> 
            <option value="<?= htmlspecialchars($page['fc_menu_page_name']) ?>" <?= (($criteria['fc_menu_page'] ?? '') == $page['fc_menu_page_name']) ? ' selected' : ''; ?>>
                <?= htmlspecialchars($page['fc_menu_page_name']) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="submit" value="Update" /> 
</form>
