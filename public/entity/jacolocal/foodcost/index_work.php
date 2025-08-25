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

        // Fetch data needed for forms
        $menus = $menuRepo->getFullMenuList();
        $commodities = $commRepo->findAll();

        // Compatibility layer for old 'thing' parameter from sidebar_nav.php
        if (isset($_GET['thing']) && !isset($_GET['view'])) {
            $thing = $_GET['thing'];
            $id = $_GET['id'] ?? null; // Keep id if present

            // Map 'thing' to 'view'
            $thing_to_view_map = [
                'menu_list' => 'menu',
                'menu_form' => 'menu',
                'menu_work' => 'menu_work',
                'comm_list' => 'comm',
                'comm_form' => 'comm',
                'map_list' => 'map',
                'map_form' => 'map',
                'menu_summary' => 'summary',
                'summary' => 'summary'
            ];

            if (array_key_exists($thing, $thing_to_view_map)) {
                $_GET['view'] = $thing_to_view_map[$thing];
                // Determine if it should be a form view
                if (strpos($thing, '_form') !== false || $id) {
                    $_GET['id'] = $id ?? 'new'; // Ensure id is set for form views
                }
            }
        }

        if (isset($_GET['view'])) {
            $view = $_GET['view'];
            $id = $_GET['id'] ?? null;

            switch ($view) {
                case 'menu':
                    $page_part = $id ? 'part_fc_menu_form.php' : 'part_fc_menu_list.php';
                    break;
                case 'comm':
                    $page_part = $id ? 'part_fc_comm_form.php' : 'part_fc_comm_list.php';
                    break;
                case 'map':
                    $page_part = $id ? 'part_fc_map_form.php' : 'part_fc_map_list.php';
                    break;
                case 'summary':
                    $page_part = 'part_fc_menu_summary.php';
                    break;
                case 'menu_work':
                    $page_part = 'part_fc_menu_work.php';
                    break;
                default:
                    $page_part = 'part_fc_dashboard.php';
                    break;
            }

            // Load data for forms if an ID is present
            if ($id) {
                switch ($view) {
                    case 'menu':
                        $menu = $menuRepo->findById($id);
                        break;
                    case 'comm':
                        $commodity = $commRepo->findById($id);
                        break;
                    case 'map':
                        $map = $mapRepo->findById($id);
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
<script src="../../../js/wd_sidebar_default.js"></script>

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
