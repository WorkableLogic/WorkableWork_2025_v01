<?php
  if(!isset($page_title)) { $page_title = 'Workable Data v1'; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo htmlspecialchars($page_title); ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- W3 Schools CSS -->
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <!-- WorkableData (WD) customization -->
    <link rel="stylesheet" href="<?php echo url_for('css/variables/public_variables.css') ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/variables/wd_variables.css') ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/wd_grid.css') ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/wd_layout.css') ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/wd_style.css') ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/wd_tables.css') ?>">
    <link rel="stylesheet" href="<?php echo url_for('css/wd_components.css') ?>">

    
    
    <!-- <script type="text/javascript" src="../../../js/wd.js"></script> -->
    <script src="<?php echo url_for('entity/jacolocal/foodcost/part_fc_map_work_menu_list.js'); ?>"></script>
    <script src="<?php echo url_for('entity/jacolocal/foodcost/part_fc_map_work_menu_parent.js'); ?>"></script>
    <script src="<?php echo url_for('entity/jacolocal/foodcost/part_fc_map_work_child_list.js'); ?>"></script>
</head>

<body class="wd-workspace">
    <div class="wd-container">

        <header class="wd-header">
            <div class="wd-header__content">
                <button class="wd-button wd-button-icon w3-hide-large" onclick="w3_open();">
                    <i class="fa fa-bars"></i>
                    <span class="sr-only">Menu</span>
                </button>
                
                <div class="wd-header__left">
                    <img src="<?php echo url_for('logo/Logo-01_small.jpg')?>" alt="Workable Data" class="wd-header__logo">
                </div>
                
                <div class="wd-header__center">
                    <?php echo "Ledger and Accounting System";?>
                </div>
                
                <div class="wd-header__right">
                    <?php if (isset($_SESSION['locent_name'])) {echo $_SESSION['locent_name'];}?>
                    <br>
                    <?php if (isset($_SESSION['username'])) {echo $_SESSION['username'];}?>
                </div>
            </div>
        </header>
