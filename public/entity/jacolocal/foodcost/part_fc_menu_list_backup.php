<?php
use App\Repository\FcMenuRepository;

// Get current criteria from session
$filters = $session->getFcMenuCriteria();

// Get Menu records using the new repository
$menuRepository = new FcMenuRepository();
$menuItems = $menuRepository->getFullMenuList($filters);
?>


   <div id="grid_data_sub_param">
      <form action="<?php echo url_for('/entity/jacolocal/foodcost/handle_criteria.php'); ?>" method="post">
         <?php include('criteria_menu.php'); ?>
      </form>
   </div>  

   <div id="grid_data_sub_crit">
      <div class="w3-row">
         <div class="w3-half">
            Menu Items:
            <?php 
               if (!empty($filters['fc_menu_cat_name'])) echo " | Category: " . h($filters['fc_menu_cat_name']);
               if (!empty($filters['fc_menu_group_name'])) echo " | Group: " . h($filters['fc_menu_group_name']);
               if (!empty($filters['fc_menu_type_name'])) echo " | Type: " . h($filters['fc_menu_type_name']);
               if (!empty($filters['fc_menu_page'])) echo " | Menu Page: " . h($filters['fc_menu_page']);
               if (!empty($filters['fc_menu_name'])) echo " | Menu Name contains: " . h($filters['fc_menu_name']);
            ?>
         </div>
         <div class="w3-half w3-right-align">
            <a href="index.php?thing=menu_form" class="w3-button w3-blue">New Menu Item</a>
         </div>
      </div>
   </div>

   <div class="wd-table-container">
      <table id="tbl_menu_summary" class="wd-table">
         <thead>
            <tr>
               <th>Category</th>
               <th>Group</th>
               <th>Type</th>
               <th>Menu Item</th>
               <th>Menu Page</th>
               <th class="number">Menu Price</th>
               <th class="number no-sort">Actions</th>
            </tr>
         </thead>

         <tbody>
            <?php foreach($menuItems as $menuItem): ?>
               <tr>
                  <td><?php echo h($menuItem->catName); ?></td>
                  <td><?php echo h($menuItem->groupName); ?></td>
                  <td><?php echo h($menuItem->typeName); ?></td>
                  <td><?php echo h($menuItem->name); ?></td>
                  <td><?php echo h($menuItem->pageName); ?></td>
                  <td class="number"><?php echo number_format($menuItem->price, 2, '.', ','); ?></td>
                  <td class="actions">
                     <a href="index.php?thing=menu_form&id=<?php echo h($menuItem->id); ?>" class="wd-action-btn wd-action-edit" data-tooltip="Edit Menu Item">
                        <i class="fas fa-edit"></i>
                     </a>
                     <button class="wd-action-btn wd-action-view" data-tooltip="View Details">
                        <i class="fas fa-eye"></i>
                     </button>
                  </td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>

   <div id="grid_data_sub_foot"> 
      <?php echo count($menuItems); ?> records
   </div>