<?php 
require_once('../../private/config/initialize.php');
require_login();
?> 

<?php include(PRIVATE_PATH . '/parts/wd_header.php'); ?>

<!-- Location entity name -->
<div id="grid_data_locent">
    <?php if (isset($_SESSION['locent_name'])) {echo $_SESSION['locent_name'];}?>
</div>

<!-- Main menu -->
<?php include_once('menu_main.php');?>

<!-- Sidebar navigation -->
<?php include_once('sidebar_nav.php');?>

<!-- Main content area -->
<div class="wd-main">
    <?php
    // Determine the page to load based on the 'thing' parameter
    $thing = $_GET['thing'] ?? '';

    switch ($thing) {
        case 'admin_user_list':
            include('part_admin_user_list.php');
            break;
        case 'admin_user_form':
            include('part_admin_user_form.php');
            break;
        default:
            include('part_admin_user_list.php');
            break;
    }
    ?>
</div>

<!-- Footer - Generic Sitewide -->
<?php include_once('../../private/parts/wd_php_footer.php');?>

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
