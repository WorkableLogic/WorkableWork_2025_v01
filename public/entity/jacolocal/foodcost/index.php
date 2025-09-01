<?php 
require_once('../../../../private/config/initialize.php');
require_login();
?> 

<?php include(PRIVATE_PATH . '/parts/wd_header.php'); ?>

<!-- Location entity name -->
<div id="grid_data_locent">
    <?php if (isset($_SESSION['locent_name'])) {echo $_SESSION['locent_name'];}?>
</div>

<!-- Main menu -->
<?php include_once('../parts/menu_main.php');?>

<!-- Sidebar navigation -->
<?php include_once('sidebar_nav.php');?>

<!-- Main content area -->
<div class="wd-main">

        <!-- Page Part logic with thing here -->
        <?php

        // Instantiate repositories
        $menuRepo = new \App\Repository\FcMenuRepository();
        $commRepo = new \App\Repository\FcCommRepository();
        $mapRepo = new \App\Repository\FcMapRepository();
        $menuTypeRepo = new \App\Repository\FcMenuTypeRepository();
        $menuGroupRepo = new \App\Repository\FcMenuGroupRepository();
        $menuCatRepo = new \App\Repository\FcMenuCatRepository();
        $menuPageRepo = new \App\Repository\FcMenuPageRepository();
        $commTypeRepo = new \App\Repository\FcCommTypeRepository();
        $commUomRepo = new \App\Repository\FcCommUomRepository();

        // Compatibility layer for old 'thing' parameter from sidebar_nav.php
        if (isset($_GET['thing']) && !isset($_GET['view'])) {
            $thing = $_GET['thing'];
            
            $thing_to_view_map = [
                'menu_list' => 'menu',
                'menu_form' => 'menu',
                'menu_type_list' => 'menu_type',
                'menu_type_form' => 'menu_type',
                'menu_group_list' => 'menu_group',
                'menu_group_form' => 'menu_group',
                'menu_cat_list' => 'menu_cat',
                'menu_cat_form' => 'menu_cat',
                'menu_page_list' => 'menu_page',
                'menu_page_form' => 'menu_page',
                'comm_list' => 'comm',
                'comm_form' => 'comm',
                'comm_type_list' => 'comm_type',
                'comm_type_form' => 'comm_type',
                'comm_uom_list' => 'comm_uom',
                'comm_uom_form' => 'comm_uom',
                'map_list' => 'map',
                'map_form' => 'map',
                'map_work' => 'map_work',
                'menu_summary' => 'summary',
                'summary' => 'summary'
            ];

            if (array_key_exists($thing, $thing_to_view_map)) {
                $_GET['view'] = $thing_to_view_map[$thing];
            }
        }

        if (isset($_GET['view'])) {
            $view = $_GET['view'];
            $id = $_GET['id'] ?? null;
            $name = $_GET['name'] ?? null;

            switch ($view) {
                case 'menu':
                    $filters = $session->getFcMenuCriteria();
                    $menus = $menuRepo->getFullMenuList($filters);
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'menu_form') !== false) ? 'part_fc_menu_form.php' : 'part_fc_menu_list.php';
                    break;
                case 'menu_type':
                    $menuTypes = $menuTypeRepo->findAll();
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'menu_type_form') !== false) ? 'part_fc_menu_type_form.php' : 'part_fc_menu_type_list.php';
                    break;
                case 'menu_group':
                    $menuGroups = $menuGroupRepo->findAll();
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'menu_group_form') !== false) ? 'part_fc_menu_group_form.php' : 'part_fc_menu_group_list.php';
                    break;
                case 'menu_cat':
                    $menuCats = $menuCatRepo->findAll();
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'menu_cat_form') !== false) ? 'part_fc_menu_cat_form.php' : 'part_fc_menu_cat_list.php';
                    break;
                case 'menu_page':
                    $menuPages = $menuPageRepo->findAll();
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'menu_page_form') !== false) ? 'part_fc_menu_page_form.php' : 'part_fc_menu_page_list.php';
                    break;
                case 'comm':
                    $commodities = $commRepo->findAll();
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'comm_form') !== false) ? 'part_fc_comm_form.php' : 'part_fc_comm_list.php';
                    break;
                case 'comm_type':
                    $commTypes = $commTypeRepo->findAll();
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'comm_type_form') !== false) ? 'part_fc_comm_type_form.php' : 'part_fc_comm_type_list.php';
                    break;
                case 'comm_uom':
                    $commUoms = $commUomRepo->findAll();
                    $page_part = (strpos($_SERVER['QUERY_STRING'], 'comm_uom_form') !== false) ? 'part_fc_comm_uom_form.php' : 'part_fc_comm_uom_list.php';
                    break;
                case 'map':
                    $page_part = ($id || strpos($_SERVER['QUERY_STRING'], 'map_form') !== false) ? 'part_fc_map_form.php' : 'part_fc_map_list.php';
                    break;
                case 'map_work':
                    $page_part = 'part_fc_map_work.php';
                    break;
                case 'summary':
                    $filters = $session->getFcMenuCriteria();
                    $menus = $menuRepo->getFullMenuList($filters);
                    $page_part = 'part_fc_menu_summary.php';
                    break;
                default:
                    $page_part = 'part_fc_dashboard.php';
                    break;
            }

            // Load data for forms if an ID is present and numeric
            if ($id && is_numeric($id)) {
                switch ($view) {
                    case 'menu':
                        $menu = $menuRepo->findById($id);
                        break;
                    case 'menu_type':
                        $menuType = $menuTypeRepo->findById($id);
                        break;
                    case 'menu_group':
                        $menuGroup = $menuGroupRepo->findById($id);
                        break;
                    case 'menu_cat':
                        $menuCat = $menuCatRepo->findById($id);
                        break;
                    case 'menu_page':
                        $menuPage = $menuPageRepo->findById($id);
                        break;
                    case 'comm':
                        $commodity = $commRepo->findById($id);
                        break;
                    case 'map':
                        $map = $mapRepo->findById($id);
                        break;
                    case 'map_work':
                        // Data for this view is loaded directly in the part file
                        break;
                }
            }

        } else {
            $page_part = 'part_fc_dashboard.php';
        }

        include_once($page_part);

        ?>

</div>

<!-- Footer - Generic Sitewide -->
<?php include_once('../../../../private/parts/wd_php_footer.php');?>

<!-- Javascript for the page -->
<!-- <script src="../../../js/wd_sidebar_default.js"></script> -->

<!-- Debug Session Info -->
<div style="background: #f0f0f0; padding: 10px; margin: 20px; font-family: monospace;">
    <strong>SESSION Debug:</strong><br>
    <?php
    echo '<pre>';
    print_r($_SESSION);
    echo '</pre>';
    ?>
</div>

</body>
</html>
