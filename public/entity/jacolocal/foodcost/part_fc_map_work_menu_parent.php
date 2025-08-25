<?php
// filepath: /Users/michaelkuhn/Sites/workablework/public/entity/jacolocal/foodcost/part_fc_map_work_menu_parent.php
use App\Repository\FcMenuPageRepository;
use App\Repository\FcMenuTypeRepository;

$typeRepo = new FcMenuTypeRepository();
$pageRepo = new FcMenuPageRepository();
$types = $typeRepo->findAll();
$pages = $pageRepo->findAll();
?>

<div id="menu-parent-container">
    <form id="menu-parent-form" class="parent-form-grid">
        <input type="hidden" id="fc-menu-id" name="fc_menu_id">
        
        <div class="form-group">
            <label for="fc-menu-name">Name</label>
            <input type="text" id="fc-menu-name" name="fc_menu_name" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="fc-menu-price">Price</label>
            <input type="text" id="fc-menu-price" name="fc_menu_price" class="form-control">
        </div>
        
        <div class="form-group">
            <label for="fc-menu-type">Type</label>
            <select id="fc-menu-type" name="fc_menu_type" class="form-control">
                <option value="">Select Type</option>
                <?php foreach ($types as $type) : ?>
                    <option value="<?= htmlspecialchars($type->fc_menu_type_name) ?>">
                        <?= htmlspecialchars($type->fc_menu_type_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        
        <div class="form-group">
            <label for="fc-menu-page">Page</label>
            <select id="fc-menu-page" name="fc_menu_page" class="form-control">
                <option value="">Select Page</option>
                <?php foreach ($pages as $page) : ?>
                    <option value="<?= htmlspecialchars($page->fc_menu_page_name) ?>">
                        <?= htmlspecialchars($page->fc_menu_page_name) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
    </form>
</div>
